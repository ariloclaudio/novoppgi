<?php

namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use app\models\Recomendacoes;
use app\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\UploadForm;
use yii\web\UploadedFile;
use mPDF;
use kartik\mpdf\Pdf;


/**
 * CandidatoController implements the CRUD actions for Candidato model.
 */
class CandidatoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Exibe Formulário no passo 1
     */
    public function actionPasso1(){

        $this->layout = '@app/views/layouts/main2.php';

        //obtendo o id do candidato por sessão.
        $model = new Candidato();
        $session = Yii::$app->session;
        $id = $session->get('candidato');
        //fim do recebimento do id por sessão

        $model = $this->findModel($id);

        /*Atribuindo o curso do Edital selecionado para o candidato*/
        $editalCurso = $this->getCursoDesejado($model);
        
        if ($model->load(Yii::$app->request->post())) {

            if($model->passoatual == 0){
                $model->passoatual = 1;
            }
            
            if($model->uploadPasso1(UploadedFile::getInstance($model, 'cartaempregadorFile'))){
                if($model->save(false)){
                    $this->mensagens('success', 'Informações Salvas com Sucesso', 'Suas informações referente aos dados pessoais foram salvas');
                    return $this->redirect(['passo2']);
                }

            }else{
                $this->mensagens('danger', 'Erro ao Enviar Arquivos', 'Ocorreu um Erro ao Enviar os Arquivos. Tente novamente mais tarde');

                return $this->render('create1', [
                    'model' => $model,
                    'editalCurso' => $editalCurso,
                ]);
            }

         }else {
            return $this->render('create1', [
                'model' => $model,
                'editalCurso' => $editalCurso,
            ]);
        }
    }

    /**
     * Exibe Formulário no passo 2
     */
    public function actionPasso2()
    {

        $this->layout = '@app/views/layouts/main2.php';

        $session = Yii::$app->session;
        $id = $session->get('candidato');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){

            if($model->passoatual == 1){
                $model->passoatual = 2;
            }
            
            if($model->uploadPasso2(UploadedFile::getInstance($model, 'historicoFile'), UploadedFile::getInstance($model, 'curriculumFile'))){
                if($model->save(false)){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações Histórico Acadêmico/Profissional foram salvas');
                    return $this->redirect(['passo3']);
                }
            }
            else{
                $this->mensagens('danger', 'Erro ao Enviar arquivos', 'Ocorreu um Erro ao enviar os arquivos submetidos');
            }
        

        }
        else if( $model->passoatual == 0){
                return $this->redirect(['passo1']);
        }

        return $this->render('create2', [
                'model' => $model,
            ]);
    }

    /**
     * Exibe Formulário no passo 3
     */
    public function actionPasso3()
    {

        $this->layout = '@app/views/layouts/main2.php';

        $session = Yii::$app->session;
        $id = $session->get('candidato');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->passoatual == 2) 
                $model->passoatual = 3;
            
            if($model->uploadPasso3(UploadedFile::getInstance($model, 'propostaFile'), UploadedFile::getInstance($model, 'comprovanteFile'))){
                if($model->save(false)){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações de Proposta de Trabalho e Documentos foram salvas');
                    if(isset($_POST['finalizar'])){
                        echo "<script>alert('Finalizar Inscrição? Após este passo seus dados serão submetidos para avaliação e não poderão ser alterados')</script>";
                        
                        /*ENVIAR EMAILS CADASTRADOS*/
                        //$this->notificarCartasRecomendacao($model);
                        
                        return $this->redirect(['passo4']);
                    }
                }else{
                    $this->mensagens('danger', 'Erro ao Salvar Alterações', 'Ocorreu um Erro ao salvar os dados.');
                }
            
            }else{
                $this->mensagens('danger', 'Erro ao Enviar arquivos', 'Ocorreu um Erro ao enviar os arquivos submetidos');
            }
            
            return $this->render('create3', [
                'model' => $model,
            ]);
        } 
        else if( $model->passoatual <= 1){
            return $this->redirect(['passo1']);
        }
        else {
            return $this->render('create3', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Exibe Formulário no passo 4
     */
    public function actionPasso4()
    {

        $this->layout = '@app/views/layouts/main2.php';


        $session = Yii::$app->session;
        $id = $session->get('candidato');
        $model = $this->findModel($id);

        $diretorio = $model->getDiretorio($id);

        if( $model->passoatual <= 2){
            return $this->redirect(['passo1']);
        }

            return $this->render('passo4', [
                'model' => $model,
                'diretorio' => $diretorio,
            ]);
        
    }

    public function actionCartarecomendacao($token){
        
        return $this->render('cartarecomendacao', [
            'model' => $model,
            'diretorio' => $diretorio,
        ]);
        
    }


    /**
     * Lists all Candidato models.
     * @return mixed
     */
    public function actionIndex()

    {
        $searchModel = new CandidatoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * @param string $id
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
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Candidato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
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

 function actionPdf() {

        $session = Yii::$app->session;
        $id = $session->get('candidato');
        $candidato = $this->findModel($id);

        $pdf = new mPDF('utf-8');
    
    $sexo = array ('M' => "Masculino",'F' => "Feminimo");
    $cursoDesejado = array (1 => "Mestrado",2 => "Doutorado");
    $regimeDedicacao = array (1 => "Integral",2 => "Parcial");
    
    //$comprovantePDF = "/formulario".$candidato->id.".pdf";

    //$arqPDF = fopen($comprovantePDF, 'w') or die('CREATE ERROR');


    //$pdf->selectFont('pdf-php/fonts/Helvetica.afm');
    //$optionsText = array(justification=>'center', spacing=>1.3);
    $dados = array(justification=>'justify', spacing=>1.0);
    $optionsTable = array(fontSize=>10, titleFontSize=>12, xPos=>'center', width=>500, cols=>array('Código'=>array('width'=>60, 'justification'=>'center'),'Período'=>array('width'=>50, 'justification'=>'center'),'Disciplina'=>array('width'=>285), 'Conceito'=>array('width'=>50, 'justification'=>'center'), 'FR%'=>array('width'=>45, 'justification'=>'center'), 'CR'=>array('width'=>30, 'justification'=>'center'), 'CH'=>array('width'=>30, 'justification'=>'center')));

            $pdf->SetHTMLHeader('
                <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
                    <tr>
                        <td width="20%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 175%;"> <img src = "../web/img/logo-brasil.jpg" height="90px" width="90px"> </td>
                        <td width="60%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 135%;">  PODER EXECUTIVO <br> UNIVERSIDADE FEDERAL DO AMAZONAS <br> INSTITUTO DE COMPUTAÇÃO <br> PROGRAMA DE PÓS-GRADUAÇÃO EM INFORMÁTICA </td>
                        <td width="20%" align="center" style="font-family: Helvetica;font-weight: bold; font-size: 175%;"> <img src = "../web/img/ufam.jpg" height="90px" width="70px"> </td>
                    </tr>
                </table>
                <hr>
            ');

            $pdf->SetHTMLFooter('
                <hr>
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



                $pdf->WriteHTML(' <br>
                    <table style= "margin-top:80px" width="100%" border = "1"> 
                    <tr>
                        <td>
                            Data: '.date("d/m/Y").'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Hora: '.date("H:i").'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nome: '.$candidato->nome.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CEP: '.$candidato->cep.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Endereço: '.$candidato->endereco.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            bairro: '.$candidato->bairro.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            cidade: '.$candidato->cidade.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            País: '.$candidato->pais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            estado civil: '.$candidato->estadocivil.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            sexo: '.$sexo[$candidato->sexo].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            nacionalidade: '.$candidato->nacionalidade.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            rg: '.$candidato->rg.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            orgão de expedição: '.$candidato->orgaoexpedidor.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            data expedição: '.$candidato->dataexpedicao.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            cpf: '.$candidato->cpf.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            datanascimento: '.$candidato->datanascimento.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            telresidencial: '.$candidato->telresidencial.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            telcelular: '.$candidato->telcelular.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            nome mae: '.$candidato->nomemae.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            nome pai: '.$candidato->nomepai.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            cursoDesejado: '.$cursoDesejado[$candidato->cursodesejado].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            regimeDedicacao: '.$regimeDedicacao[$candidato->regime].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            inscricao poscomp: '.$candidato->inscricaoposcomp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ano pos comp: '.$candidato->anoposcomp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            nota pos comp: '.$candidato->notaposcomp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            solicita bolsa: '.$candidato->solicitabolsa.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            vinculo emprego: '.$candidato->vinculoemprego.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            empregador: '.$candidato->empregador.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            cargo: '.$candidato->cargo.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Vinculo Convenio: '.$candidato->vinculoconvenio.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Convenio: '.$candidato->convenio.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->cursograd.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->crgrad.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->instituicaograd.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->cursoesp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->instituicaoesp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->egressoesp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->cursopos.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Empregador: '.$candidato->egressoesp.'
                        </td>
                    </tr>




                    <tr>
                        <td>
                                Empregador: '.$candidato->instituicaopos.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$cursoDesejado[$candidato->tipopos].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->mediapos.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->periodicosinternacionais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->periodicosnacionais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->conferenciasinternacionais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->conferenciasnacionais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Empregador: '.$candidato->egressoesp.'
                        </td>
                    </tr>
                            </table>
                        ');


    $pdf->Output('');


    $pdf->ezText("     <b>Instituição: </b>".utf8_decode($candidato->instituicaoingles),10,$dados);
    $pdf->addText(350,310,10,"<b>Anos de Estudo: </b>$candidato->duracaoingles",0,0);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Exame de Proficiência</b>",10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("     <b>Nome do Exame: </b>".utf8_decode($candidato->nomeexame),10,$dados);
    $pdf->addText(350,264,10,"<b>Data: </b>$candidato->dataexame",0,0);
    $pdf->addText(480,264,10,"<b>Nota: </b>$candidato->notaexame",0,0);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Experiência Profissional</b>",10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $experienciaProfissional = array(
                               array('Instituição/Empresa'=>utf8_decode($candidato->empresa1),'Cargo/Função'=>utf8_decode($candidato->cargo1), 'Período (de X até Y)'=>utf8_decode($candidato->periodoprofissional1))
                               ,array('Instituição/Empresa'=>utf8_decode($candidato->empresa2),'Cargo/Função'=>utf8_decode($candidato->cargo2), 'Período (de X até Y)'=>utf8_decode($candidato->periodoprofissional2))
                               ,array('Instituição/Empresa'=>utf8_decode($candidato->empresa3),'Cargo/Função'=>utf8_decode($candidato->cargo3), 'Período (de X até Y)'=>utf8_decode($candidato->periodoprofissional3))
    );

    $pdf->ezTable($experienciaProfissional,$cols,'',$optionsTable);

    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Experiência Acadêmica (Monitoria, PIBIC, PET, Instutor, Professor)</b>",10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $experienciaAcademica = array(
                               array('Instituição'=>utf8_decode($candidato->instituicaoacademica1),'Atividade'=>utf8_decode($candidato->atividade1), 'Período (de X até Y)'=>utf8_decode($candidato->periodoacademico1))
                               ,array('Instituição'=>utf8_decode($candidato->instituicaoacademica2),'Atividade'=>utf8_decode($candidato->atividade2), 'Período (de X até Y)'=>utf8_decode($candidato->periodoacademico2))
                               ,array('Instituição'=>utf8_decode($candidato->instituicaoacademica3),'Atividade'=>utf8_decode($candidato->atividade3), 'Período (de X até Y)'=>utf8_decode($candidato->periodoacademico3))
    );


    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText('<b>PROPOSTA DE TRABALHO</b>',10,$optionsText);
    $pdf->setLineStyle(1);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Título da Proposta: </b>".utf8_decode($candidato->tituloproposta),10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Linha de Pesquisa: </b>".utf8_decode(verLinhaPesquisa($candidato->linhapesquisa, 1)),10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Exposição de motivos (exponha resumidamente os motivos que o levaram a se candidatar ao Curso)</b>",10,$dados);
    $pdf->ezText(utf8_decode($candidato->motivos),10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Cartas de Recomendação</b>",10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Nome: </b>".utf8_decode($candidato->cartanome1)."     <b>E-mail: </b>".$candidato->cartaemail1,10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("<b>Nome: </b>".utf8_decode($candidato->cartanome2)."     <b>E-mail: </b>".$candidato->cartaemail2,10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText('');  //Para quebra de linha
    $pdf->ezText("OBS: anexar a este documento sua proposta de trabalho e demais documentos inseridos no formulário de inscrição",10,$dados);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->addText(30,130,10,'Declaro que as informações prestadas neste formulário são verdadeiras, sob pena de exclusão do Curso.',0,0);
    $pdf->addText(30,100,10,'Data: ____/____/_______ , Assinatura: ______________________________________',0,0);
    $pdf->line(20, 80, 580, 80);
    $pdf->ezText('');  //Para quebra de linha
    $pdf->addText(80,40,8,'Av. Rodrigo Otávio, 6.200 • Campus Universitário Senador Arthur Virgílio Filho • CEP 69077-000 •  Manaus, AM, Brasil',0,0);
    $pdf->addJpegFromFile('components/com_portalsecretaria/images/icon_telefone.jpg', 140, 30, 8, 8);
    $pdf->addJpegFromFile('components/com_portalsecretaria/images/icon_email.jpg', 229, 30, 8, 8);
    $pdf->addJpegFromFile('components/com_portalsecretaria/images/icon_casa.jpg', 383, 30, 8, 8);
    $pdf->addText(150,30,8,'Tel. (092) 3305 1193       E-mail: secretaria@icomp.ufam.edu.br        www.ppgi.ufam.edu.br',0,0);

    $pdfcode = $pdf->output();
    fwrite($arqPDF,$pdfcode);
    fclose($arqPDF);

}
    /*Função que retorna o curso do edital ou se o curso deverá ser escolhido no formulário*/
    public function getCursoDesejado($model){
        $ambos = 0;
        if(Edital::findOne(['numero' => $model->idEdital])->curso == 3)
            $ambos = 3;
        else
            $model->cursodesejado = Edital::findOne(['numero' => $model->idEdital])->curso;
        return $ambos;
    }

    public function notificarCartasRecomendacao($model){

        $recomendacoesArray = Recomendacoes::findAll(['idCandidato' => $model->id]);

        foreach ($recomendacoesArray as $recomendacoes) {
            echo "<script>console.log('$recomendacoes->nome')</script>";
            $link = "http://localhost/MyProjects/ppgi/frontend/web/index.php?r=candidato/cartaderecomendacao&token=".$recomendacoes->token;
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

}