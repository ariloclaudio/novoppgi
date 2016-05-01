<?php

namespace backend\controllers;

use Yii;
use app\models\Defesa;
use app\models\DefesaSearch;
use app\models\BancaControleDefesas;
use app\models\Banca;
use app\models\BancaSearch;
use app\models\MembrosBanca;
use app\models\MembrosBancaSearch;
use app\models\Aluno;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException;
use yii\base\Exception;
use yii\web\UploadedFile;
use mPDF;

/**
 * DefesaController implements the CRUD actions for Defesa model.
 */
class DefesaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Defesa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DefesaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Defesa model.
     * @param integer $idDefesa
     * @param integer $aluno_id
     * @return mixed
     */
    public function actionView($idDefesa, $aluno_id)
    {

        $model_defesa = $this->findModel($idDefesa, $aluno_id);

        $model_banca = new BancaSearch();
        $dataProvider = $model_banca->search(Yii::$app->request->queryParams,$model_defesa->banca_id);

        return $this->render('view', [
            'model' => $model_defesa,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Defesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($aluno_id)
    {
        
        $membrosBancaInternos = ArrayHelper::map(MembrosBanca::find()->where("filiacao = 'PPGI/UFAM'")->orderBy('nome')->all(), 'id', 'nome','filiacao');

        $membrosBancaExternos = ArrayHelper::map(MembrosBanca::find()->where("filiacao <> 'PPGI/UFAM'")->orderBy('nome')->all(), 'id', 'nome','filiacao');
        
        $membrosExternos = ArrayHelper::map(MembrosBanca::find()->where("filiacao <> 'PPGI/UFAM'")->orderBy('nome')->all(), 'id', 'nome');
        
        $model = new Defesa();
        
        $conceitoPendente = $model->ConceitoPendente($aluno_id);
        
        if ($conceitoPendente == true){

                $this->mensagens('danger', 'Defesas Pendências de Conceito', 'Existem defesas deste aluno que estão pendentes de conceito. Por favor, solicite que a secretaria atribua o conceito.');

                return $this->redirect(['aluno/orientandos',]);            
            
        }
        

        $model->aluno_id = $aluno_id;

        $cont_Defesas = Defesa::find()->where("aluno_id = ".$aluno_id)->count();
        $curso = Aluno::find()->select("curso")->where("id =".$aluno_id)->one()->curso;

            if($cont_Defesas == 0 && $curso == 1){
                $model->tipoDefesa = "Q1";
                $tipodefesa = 1;
            }
            else if($cont_Defesas == 0 && $curso == 2){
                $model->tipoDefesa = "Q1";
                $tipodefesa = 2;
            }
            else if ($cont_Defesas == 1 && $curso == 1){
                $model->tipoDefesa = "D";
                $tipodefesa = 3;
            }
            else if ($cont_Defesas == 1 && $curso == 2){
                $model->tipoDefesa = "Q2";
                $tipodefesa = 4;
            }
            else if ($cont_Defesas == 2 && $curso == 2){
                $model->tipoDefesa = "T";
                $tipodefesa = 5;
            }

        if ($model->load(Yii::$app->request->post() ) ) {

            $model->auxiliarTipoDefesa = $tipodefesa;

            $model_ControleDefesas = new BancaControleDefesas();
            if($model->tipoDefesa == "Q1" && $model->curso == "Doutorado"){
                $model_ControleDefesas->status_banca = 1;
            }
            else{
                $model_ControleDefesas->status_banca = null;
            }
            $model_ControleDefesas->save(false);

            $model->banca_id = $model_ControleDefesas->id;

            if(! $model->uploadDocumento(UploadedFile::getInstance($model, 'previa'))){
                $this->mensagens('danger', 'Erro ao salvar defesa', 'Ocorreu um erro ao salvar a defesa. Verifique os campos e tente novamente');
                return $this->redirect(['aluno/orientandos',]);
            }


            try{
                
                if($model->tipoDefesa == "Q1" && $model->curso == "Doutorado"){


                    if($model->save(false)){

                        $this->mensagens('success', 'Defesa salva', 'A defesa foi salva com sucesso.');
                        return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
                    }

                }
                else{

                    $model->salvaMembrosBanca();


                    if($model->save()){

                        $this->mensagens('success', 'Defesa salva', 'A defesa foi salva com sucesso.');
                        
                        return $this->redirect(['passagens', 'banca_id' => $model->banca_id]);

                    }else{
                        $this->mensagens('danger', 'Erro ao salvar defesa', 'Ocorreu um erro ao salvar a defesa. Verifique os campos e tente novamente');
                    }

                }

            } catch(Exception $e){
                $this->mensagens('danger', 'Erro ao salvar Membros da banca', 'Ocorreu um Erro ao salvar os membros da bancas.');
            }

        }
        else if ( ($curso == 1 && $cont_Defesas >= 2) || ($curso == 2 && $cont_Defesas >= 3) ){
            $this->mensagens('danger', 'Solicitar Banca', 'Não foi possível solicitar banca, pois esse aluno já possui '.$cont_Defesas.' defesas cadastradas');
            return $this->redirect(['aluno/orientandos',]);
        }

        return $this->render('create', [
            'model' => $model,
            'tipodefesa' => $tipodefesa,
            'membrosBancaInternos' => $membrosBancaInternos,
            'membrosBancaExternos' => $membrosBancaExternos,
        ]);
    }
    
    public function actionPassagens($banca_id){
        

        $banca = Banca::find()->select("j17_banca_has_membrosbanca.* , mb.nome as membro_nome, mb.filiacao as membro_filiacao, mb.*")->leftJoin("j17_membrosbanca as mb","mb.id = j17_banca_has_membrosbanca.membrosbanca_id")
        ->where(["banca_id" => $banca_id , "funcao" => "E"])->all();
        
        return $this->render('passagens', [
            'model' => $banca,
        ]);
    
        
        
    }
    
    public function actionPassagens2(){

    $where = "";

    $banca_id = $_POST['banca_id'];

        if(!empty($_POST['check_list'])){
            // Loop to store and display values of individual checked checkbox.

           $arrayChecked = $_POST['check_list'];

            for($i=0; $i<count($arrayChecked)-1; $i++){
                $where = $where."membrosbanca_id = ".$arrayChecked[$i]." OR ";
            }
                $where = $where."membrosbanca_id = ".$arrayChecked[$i];
        }

  
        if ($where != ""){
            $sqlSim = "UPDATE j17_banca_has_membrosbanca SET passagem = 'S' WHERE ($where) AND banca_id = ".$banca_id;
            //$sqlNao = "UPDATE j17_banca_has_membrosbanca SET passagem = 'N' WHERE $where";

            try{
                echo Yii::$app->db->createCommand($sqlSim)->execute();

              //  echo Yii::$app->db->createCommand($sqlNao)->execute();

                $this->mensagens('success', 'Passagens', 'As alterações das passagens foram salvas com sucesso.');

                return $this->redirect(['aluno/orientandos',]);

            }
            catch(\Exception $e){

                $this->mensagens('danger', 'Erro ao salvar', 'Ocorreu um Erro ao salvar essas alterações no Banco. Tente Novamente.');
            }
        }
        else {
            $this->mensagens('success', 'Passagens', 'As alterações das passagens foram salvas com sucesso.');
            return $this->redirect(['aluno/orientandos',]);
        }


        
    }


    /**
     * Updates an existing Defesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idDefesa
     * @param integer $aluno_id
     * @return mixed
     */
    public function actionUpdate($idDefesa, $aluno_id)
    {


        //SÓ PODE EDITAR A DEFESA SE ELA NÃO FOI CONCEITUADA! TEM DE CHECAR SE CONCEITO == NULL

        $model_aluno = Aluno::find()->where("id = ".$aluno_id)->one();

        $model = $this->findModel($idDefesa, $aluno_id);

        $model->data = date('d-m-Y', strtotime($model->data));

        if ($model->load(Yii::$app->request->post())) {
            
            $model->data = date('Y-m-d', strtotime($model->data));
            $model->save(false);
           
            
            return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_aluno' => $model_aluno,

            ]);
        }
    }

    /**
     * Deletes an existing Defesa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idDefesa
     * @param integer $aluno_id
     * @return mixed
     */
    public function actionDelete($idDefesa, $aluno_id)
    {

        //SÓ PODE EXCLUIR A DEFESA SE ELA NÃO NÃO POSSUIR BANCA! TEM DE CHECAR SE banca_id == 0
        $model = $this->findModel($idDefesa, $aluno_id);

        $banca = BancaControleDefesas::find()->where(["id" => $model->banca_id])->one();


        if($banca->status_banca != null){
            $this->mensagens('danger', 'Não Excluído', 'Não foi possível excluir, pois essa defesa já possui banca aprovada');
            return $this->redirect(['index']);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    public function cabecalhoRodape($pdf){
            $pdf->SetHTMLHeader('
                <table style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
                    <tr>
                        <td width="20%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 175%;"> <img src = "../../frontend/web/img/logo-brasil.jpg" height="90px" width="90px"> </td>
                        <td width="60%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 135%;">  PODER EXECUTIVO <br> UNIVERSIDADE FEDERAL DO AMAZONAS <br> INSTITUTO DE COMPUTAÇÃO <br> PROGRAMA DE PÓS-GRADUAÇÃO EM INFORMÁTICA </td>
                        <td width="20%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 175%;"> <img style="margin-left:8%" src = "../../frontend/web/img/ufam.jpg" height="90px" width="75px"> </td>
                    </tr>
                </table>
                <hr>
            ');

            $pdf->SetHTMLFooter('

                <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
                    <tr>
                        <td  colspan = "3" align="center" ><span style="font-weight: bold"> Av. Rodrigo Otávio, 6.200 - Campus Universitário Senador Arthur Virgílio Filho - CEP 69077-000 - Manaus, AM, Brasil </span></td>
                    </tr>
                    <tr>
                        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">  Tel. (092) 3305-1193/2808/2809</td>
                        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">  E-mail: secretaria@icomp.ufam.edu.br</td>

                        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">  http://www.icomp.ufam.edu.br </td>
                    </tr>
                </table>
            ');

            return $pdf;
    }

    public function actionConvitepdf($idDefesa, $aluno_id){

        $model = $this->findModel($idDefesa, $aluno_id);

        $banca = Banca::find()
        ->select("j17_banca_has_membrosbanca.* , j17_banca_has_membrosbanca.funcao ,mb.nome as membro_nome, mb.filiacao as membro_filiacao, mb.*")->leftJoin("j17_membrosbanca as mb","mb.id = j17_banca_has_membrosbanca.membrosbanca_id")
        ->where(["banca_id" => $model->banca_id])->all();

        $bancacompleta = "";

        foreach ($banca as $rows) {
            if($rows->funcao == "P"){
                $funcao = "(Presidente)";
            }
            else{
                $funcao = "";
            }
            $bancacompleta = $bancacompleta . $rows->membro_nome.' - '.$rows->membro_filiacao.' '.$funcao.'<br>';
        }

        $pdf = new mPDF('utf-8','A4','','','15','15','42','30');

        $pdf = $this->cabecalhoRodape($pdf);

             $pdf->WriteHTML('
                <div style="text-align:center"> <h3>  CONVITE À COMUNIDADE </h3> </div>
                <p style = "text-align: justify;">
                     A Coordenação do Programa de Pós-Graduação em Informática PPGI/UFAM tem o prazer de convidar toda a
                    comunidade para a sessão pública de apresentação de defesa de exame de qualificação de mestrado:
                </p>
            ');

             $pdf->WriteHTML('
                <div style="text-align:center"> <h4>'.$model->titulo.'</h4> </div>
                <p style = "text-align: justify;">
                RESUMO: '.$model->resumo.'
                </p>
            ');

             $pdf->WriteHTML('

                    CANDIDATO: '.$model->nome.' <br><br>

                    BANCA EXAMINADORA: <br>
                    <div style="margin-left:15%"> '.$bancacompleta.' </div>

            ');


             $pdf->WriteHTML('
                <p> 
                    LOCAL: '.$model->local.'
                </p>
                <p> 
                    DATA: '.$model->data.'
                </p>
                <p> 
                    HORÁRIO: '.$model->horario.'
                </p>

                <div style="text-align:center"> 
                    <h5 style="margin-bottom:0px">Prof. Dr. Eduardo Luzeiro Feitosa</h5>
                    <h5 style="margin-top:0px"> Coordenador(a) do Programa de Pós-Graduação em Informática PPGI/UFAM </h5>

                </div>
            ');

    $pdfcode = $pdf->output();
    fwrite($arqPDF,$pdfcode);
    fclose($arqPDF);



    }


    public function actionAtapdf($idDefesa, $aluno_id){

    $model = $this->findModel($idDefesa, $aluno_id);

            $banca = Banca::find()
            ->select("j17_banca_has_membrosbanca.* , j17_banca_has_membrosbanca.funcao ,mb.nome as membro_nome, mb.filiacao as membro_filiacao, mb.*")->leftJoin("j17_membrosbanca as mb","mb.id = j17_banca_has_membrosbanca.membrosbanca_id")
            ->where(["banca_id" => $model->banca_id])->all();

            $bancacompleta = "";

            foreach ($banca as $rows) {
                if($rows->funcao == "P"){
                    $funcao = "(Presidente)";
                }
                else{
                    $funcao = "";
                }
                $bancacompleta = $bancacompleta . $rows->membro_nome.' - '.$rows->membro_filiacao.' '.$funcao.'<br>';
            }

            $pdf = new mPDF('utf-8','A4','','','15','15','42','30');

            $pdf = $this->cabecalhoRodape($pdf);

                 $pdf->WriteHTML('
                    <div style="text-align:center"> <h3>  AVALIAÇÃO DE PROPOSTA DE DISSERTAÇÃO DE MESTRADO </h3> </div>
                    <p style = "font-weight: bold;">
                        DADOS DO(A) ALUNO(A): </p>
                        Nome: '.$model->nome.'  <br><br>
                        Área de Conceitação: '.$model->nome.'  <br><br>
                        Linha de Pesquisa: '.$model->nome.'  <br><br>
                        Orientador: '.$model->nome.'  <br><br>
                        <hr>
                    </p>
                ');


                 $pdf->WriteHTML('
                    <p style = "font-weight: bold;">
                        DADOS DA DEFESA: </p>
                        Título: '.$model->titulo.' <br><br>
                        Data: '.date("d-m-Y",  strtotime($model->data)).'<br>  Hora: '.$model->horario.'<br> Local: '.$model->local.'

                    </p>
                ');

    $pdfcode = $pdf->output();
    fwrite($arqPDF,$pdfcode);
    fclose($arqPDF);
}










    public function actionAprovar($idDefesa, $aluno_id)
    {
        $model = $this->findModel($idDefesa, $aluno_id);

        $model->conceito = "Aprovado";

        if ($model->save(false)) {

             $this->mensagens('success', 'Aluno', 'Aluno Aprovado com sucesso');

            return $this->redirect(['index']);
        } else {
            $this->mensagens('danger', 'Aluno', 'Não foi possível atribuir conceito para este aluno, tente mais tarde');
            return $this->redirect(['index']);
        }
    }


    public function actionReprovar($idDefesa, $aluno_id)
    {
        $model = $this->findModel($idDefesa, $aluno_id);

        $model->conceito = "Reprovado";

        if ($model->save(false)) {

             $this->mensagens('success', 'Aluno', 'Aluno Reprovado com sucesso');

            return $this->redirect(['index']);
        } else {
            $this->mensagens('danger', 'Aluno', 'Não foi possível atribuir conceito para este aluno, tente mais tarde');
            return $this->redirect(['index']);
        }
    }


    /**
     * Finds the Defesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idDefesa
     * @param integer $aluno_id
     * @return Defesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idDefesa, $aluno_id)
    {
        if (($model = Defesa::findOne(['idDefesa' => $idDefesa, 'aluno_id' => $aluno_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

            /* Envio de mensagens para views
       Tipo: success, danger, warning*/
    protected function mensagens($tipo, $titulo, $mensagem){
        Yii::$app->session->setFlash($tipo, [
            'type' => $tipo,
            'icon' => 'home',
            'duration' => 5000,
            'message' => $mensagem,
            'title' => $titulo,
            'positonY' => 'top',
            'positonX' => 'center',
            'showProgressbar' => true,
        ]);
    }
}
