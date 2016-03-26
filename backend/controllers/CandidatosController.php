<?php

namespace backend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Aluno;
use common\models\User;
use app\models\CandidatosSearch;
use backend\models\SignupForm;
use common\models\LinhaPesquisa;
use common\models\Recomendacoes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CandidatosController implements the CRUD actions for Candidato model.
 */
class CandidatosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                               return Yii::$app->user->identity->checarAcesso('coordenacao');
                        }
                    ],
                ],
            ], 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Candidato models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new CandidatosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idEdital' => $id,
        ]);
    }

    /**
     * Displays a single Candidato model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        
        //obtendo o nome linha de pesquisa através do id da linha de pesquisa
        $linhaPesquisa = new LinhaPesquisa();
        $linhaPesquisa = $linhaPesquisa->getLinhaPesquisaNome($model->idLinhaPesquisa);
        if ($linhaPesquisa != null){
            $model->idLinhaPesquisa = $linhaPesquisa->nome;
        }
        //fim de obter nome da linha de pesquisa

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Candidato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Candidato();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Candidato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Candidato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionDownloadscompletos($id){

        $idEdital = $id;

        $resultado = shell_exec("cd ../../frontend/web/documentos/ && zip -r ".$idEdital.".zip ".$idEdital);

        if (is_dir('../../frontend/web/documentos/'.$idEdital)){

            header('Content-type: application/zip');
            header('Content-disposition: attachment; filename=Doc_Completos_'.$idEdital.".zip");
            readfile("../../frontend/web/documentos/".$idEdital.".zip");
            unlink("../../frontend/web/documentos/".$idEdital.".zip");

        }
        else{

        $this->mensagens('warning', 'Não há documentos', 'Nenhum candidato fez upload de sua documentação.');

        return $this->redirect(['edital/view','id'=>$id]);

        }

    }


    public function actionDownloads($id,$idEdital)
    {
        //$model = $this->findModel($id);

        $modelCandidato = new Candidato();
        $candidato = $modelCandidato->download($id,$idEdital);


        $salt1 = "programadeposgraduacaoufamicompPPGI";
        $salt2 = $id * 777;
        $idCriptografado = md5($salt1+$id+$salt2);


        $diretorio = '../../frontend/web/documentos/'.$idEdital.'/'.$idCriptografado;


        $zipFile = $candidato->nome.'_doc_ppgi.zip';
        $zipArchive = new \ZipArchive();

            if (!$zipArchive->open($zipFile, \ZIPARCHIVE::OVERWRITE))
                die("Failed to create archive\n");

                $options = array('add_path' => '/', 'remove_path' => $diretorio);

                $zipArchive->addGlob($diretorio.'/*', GLOB_BRACE, $options);

            if (!$zipArchive->status == \ZIPARCHIVE::ER_OK)
                echo "Failed to write files to zip\n";

            $zipArchive->close();
            header('Content-type: application/zip');
            header('Content-disposition: attachment; filename='.$zipFile);
            readfile($zipFile);
            unlink($zipFile);

    }

    public function actionAprovar($id,$idEdital){


        $model_usuario = new User();

        $model_candidato = $this->findModel($id);


        if($model_candidato != null){
            $usuario_ja_existe = User::find()->select("id")->where("username = '".$model_candidato->cpf."'")->one();
        }


        if($usuario_ja_existe != null){
            $model_usuario_existente = User::findOne($usuario_ja_existe->id);
            $model_usuario_existente->aluno = 1;
            $model_usuario_existente->status = 10;
            $salvou = $model_usuario_existente->save();

            $id_usuario = $model_usuario_existente->id;

        }
        else{

            $model_usuario->nome = $model_candidato->nome;
            $model_usuario->username = $model_candidato->cpf;
            $model_usuario->password = $model_candidato->senha;
            $model_usuario->email = $model_candidato->email;
            $model_usuario->administrador =  0;
            $model_usuario->coordenador =  0;
            $model_usuario->secretaria =  0;
            $model_usuario->professor = 0;
            $model_usuario->aluno = 1;
            $model_usuario->auth_key = Yii::$app->security->generateRandomString();

            $salvou = $model_usuario->save();

            $id_usuario = $model_usuario->id;

        }


        if($salvou == true){    
            return $this->actionAprovar1($id,$idEdital,$id_usuario);
        }
        else{
            $this->mensagens('warning', 'Erro', 'Erro ao Aprovar Candidato. Entre com contato com o administrador do sistema.');

        }

        return $this->redirect(['candidatos/index','id'=>$idEdital]);

    }



    
    public function actionAprovar1($id,$idEdital,$id_usuario){

        $model_candidato = $this->findModel($id);
        $model_aluno = new Aluno();

         $model_aluno->senha  = $model_candidato->senha;
         $model_aluno->nome  = $model_candidato->nome;
         $model_aluno->endereco  = $model_candidato->endereco;
         $model_aluno->bairro  = $model_candidato->bairro;
         $model_aluno->cidade  = $model_candidato->cidade;
         $model_aluno->uf  = $model_candidato->uf; 
         $model_aluno->cep  = $model_candidato->cep;
         $model_aluno->email  = $model_candidato->email;
         $model_aluno->datanascimento  = $model_candidato->datanascimento;
         $model_aluno->nacionalidade  = $model_candidato->nacionalidade;
         $model_aluno->pais  = $model_candidato->pais;
         $model_aluno->cpf  = $model_candidato->cpf; 
         $model_aluno->sexo  = $model_candidato->sexo;
         $model_aluno->telresidencial  = $model_candidato->telresidencial;
         $model_aluno->telcelular  = $model_candidato->telcelular;
         $model_aluno->regime  = $model_candidato->regime;
         $model_aluno->cursograd  = $model_candidato->cursograd;
         $model_aluno->instituicaograd  = $model_candidato->instituicaograd;
         $model_aluno->egressograd  = $model_candidato->egressograd;
         $model_aluno->dataformaturagrad  = $model_candidato->dataformaturagrad;
         $model_aluno->status  = $model_candidato->status;

         $model_candidato->resultado = 1;

         //mudança de atributos
         $model_aluno->area  = $model_candidato->idLinhaPesquisa;
         $model_aluno->curso  = $model_candidato->cursodesejado;
         $model_aluno->idUser = $id_usuario;


        if ($model_aluno->load(Yii::$app->request->post()) && $model_aluno->save()) {


                     $model_candidato->save();



            return $this->redirect(['/aluno/view', 'id' => $model_aluno->id]);
        } else {


                     var_dump($model_aluno->getErrors());



            return $this->render('/aluno/create', [
                'model' => $model_aluno,
            ]);
        }

    }



    public function actionAprovar2($id,$idEdital)
    {
        $model = $this->findModel($id);

        $cartas_respondidas = new Recomendacoes();
        $cartas_respondidas = $cartas_respondidas->getCartasRespondidas($id);

        if($cartas_respondidas <2){
            $this->mensagens('danger', 'Cartas de Recomendação', 'Não foi possível avaliar o candidato, pois faltam cartas a serem respondidas.');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        if($model->resultado === 0 || $model->resultado === 1 ){
            $this->mensagens('danger', 'Candidato Reprovado', 'Este Candidato já foi Avaliado');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

            $sql = "INSERT INTO `j17_aluno`(`senha`, `nome`, `endereco`, `bairro`, `cidade`, `uf`, `cep`, `email`, `datanascimento`, `nacionalidade`, `pais`,  `cpf`, `sexo`, `telresidencial`, `telcelular`, `regime`,  `cursograd`, `instituicaograd`, `egressograd`, `dataformaturagrad`, `status`) 
            SELECT `senha`, `nome`, `endereco`, `bairro`, `cidade`, `uf`, `cep`, `email`, `datanascimento`, `nacionalidade`, `pais`,  `cpf`, `sexo`, `telresidencial`, `telcelular`, `regime`,  `cursograd`, `instituicaograd`, `egressograd`, `dataformaturagrad`, `status` FROM j17_candidatos WHERE id = ".$id;

            Yii::$app->db->createCommand($sql)->execute();

            $model->resultado = 1;

            if($model->save(false)){
                $this->mensagens('success', 'Candidato Aprovado', 'Candidato Aprovado com sucesso.');
            }
            else{
                $this->mensagens('warning', 'Erro', 'Erro ao Aprovar Candidato. Entre com contato com o administrador do sistema.');
            }

        return $this->redirect(['candidatos/index','id'=>$idEdital]);
    }

    public function actionReprovar($id,$idEdital)
    {   
        $model = $this->findModel($id);

        $cartas_respondidas = new Recomendacoes();
        $cartas_respondidas = $cartas_respondidas->getCartasRespondidas($id);

        if($cartas_respondidas <2){
            $this->mensagens('danger', 'Cartas de Recomendação', 'Não foi possível avaliar o candidato, pois faltam cartas a serem respondidas.');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        if($model->resultado === 0 || $model->resultado === 1){
            $this->mensagens('danger', 'Candidato Avaliado', 'Este Candidato já foi Avaliado');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

            $model->resultado = 0;

            if($model->save(false)){
                $this->mensagens('success', 'Candidato Reprovado', 'Candidato Reprovado com sucesso.');
            }
            else{
                $this->mensagens('warning', 'Erro', 'Erro ao Aprovar Candidato. Entre com contato com o administrador do sistema.');
            }

        return $this->redirect(['candidatos/index','id'=>$idEdital]);
    }


    public function actionPdf($documento){

        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $mudarDiretorioParaFrontEnd = "../../frontend/web/";

        $localArquivo = $mudarDiretorioParaFrontEnd.$model->getDiretorio().$documento;

       if(!file_exists($localArquivo))
            throw new NotFoundHttpException('A Página solicitada não existe.');

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.$documento.'"');
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($mudarDiretorioParaFrontEnd.$model->getDiretorio().$documento));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        readfile($localArquivo);
    }

    public function actionReenviarcartas($id, $idEdital){
        $recomendacoesArray = Recomendacoes::findAll(['idCandidato' => $id, 'dataResposta' => '0000-00-00 00:00:00']);

        for ($i=0; $i < count($recomendacoesArray); $i++) { 
            $recomendacoesArray[$i]->prazo = date("Y-m-d", strtotime('+5 days'));
            if(!$recomendacoesArray[$i]->save()){
                $this->mensagens('danger', 'Erro ao Reenviar Cartas', 'As cartas de Recomendações não poderam ser enviadas.');
                return $this->redirect(['candidatos/index','id'=>$idEdital]);
            }
        }

        $this->notificarCartasRecomendacao($recomendacoesArray, $id);

        $this->mensagens('success', 'Cartas de Recomendações Reenviadas', 'As cartas de Recomendações foram reenviadas.');
        return $this->redirect(['candidatos/index','id'=>$idEdital]);
    }

    public function notificarCartasRecomendacao($recomendacoesArray, $id){

        $model = Candidato::findOne(['id' => $id]);

        foreach ($recomendacoesArray as $recomendacoes) {
            echo "<script>console.log('$recomendacoes->nome')</script>";
            $link = "http://localhost/MyProjects/ppgi/frontend/web/index.php?r=recomendacoes/create&token=".$recomendacoes->token;
            // subject
            $subject  = "[PPGI/UFAM] Solicitacao de Carta de Recomendacao para ".$model->nome;

            $mime_boundary = "<<<--==-->>>";
            $message = '';
            // message
            $message .= "Caro(a) ".$recomendacoes->nome.", \r\n\n";
            $message .= "Você foi requisitado(a) por ".$model->nome." (email: ".$model->email.") para escrever uma carta de recomendação para o processo de seleção do Programa de Pós-Graduação em Informática (PPGI) da Universidade Federal do Amazonas (UFAM).\r\n";
            $message .= "\nPara isso, a carta deve ser preenchida eletronicamente utilizando o link: \n ".$link."\r\n";
            $message .= "O prazo para preenchimento da carta é ".$recomendacoes->prazo.".\r\n";
            $message .= "Em caso de dúvidas, por favor nos contate. Agradecemos sua colaboração.\r\n";
            $message .= "\nCoordenação do PPGI - ".date(DATE_RFC822)."\r\n";
            $message .= $mime_boundary."\r\n";

            /*Envio das cartas de Email*/
           try{
               Yii::$app->mailer->compose()
                ->setFrom("secretariappgi@icomp.ufam.edu.br")
                ->setTo($recomendacoes->email)
                ->setSubject($subject)
                ->setTextBody($message)
                ->send();
            }catch(Exception $e){
                $this->mensagens('warning', 'Erro ao enviar Email(s)', 'Ocorreu um Erro ao Enviar as Solicitações de Cartas de Recomendação.
                    Tente novamente ou contate o adminstrador do sistema');
            }
        }
    }
    
    /**
     * Finds the Candidato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Candidato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Candidato::findOne($id)) !== null) {
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
