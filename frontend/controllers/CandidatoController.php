<?php

namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use app\models\ExperienciaAcademica;
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
        
            if($model->save(false)){
                $this->mensagens('success', 'Informações Salvas com Sucesso', 'Suas informações referente aos dados pessoais foram salvas');
                return $this->redirect(['passo2']);
            }

            return $this->render('create1', [
                'model' => $model,
                'editalCurso' => $editalCurso,
            ]);
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

            if($model->uploadPasso2(UploadedFile::getInstance($model, 'historicoFile'), UploadedFile::getInstance($model, 'curriculumFile'), UploadedFile::getInstance($model, 'publicacoesFile'),$model->idEdital)){
                if($model->save(false) && $model->salvaExperienciaAcademica()){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações Histórico Acadêmico/Profissional foram salvas');
                    return $this->redirect(['passo3']);
                }else{
                    $this->mensagens('danger', 'Erro ao salvar informações', 'Ocorreu um ao salvar as informações. Contate o adminstrador do sistema.');
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
            
            if($model->uploadPasso3(UploadedFile::getInstance($model, 'propostaFile'), UploadedFile::getInstance($model, 'comprovanteFile'),$model->idEdital)){
                if($model->save(false) && $model->salvaCartaRecomendacao()){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações de Proposta de Trabalho e Documentos foram salvas');
                    if(isset($_POST['finalizar'])){
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


        $model->passoatual = 4;
        $model->fim = date("Y-m-d H:i:s");
        $model->save(false);

        $diretorio = $model->getDiretorio();


        if( $model->passoatual <= 2){
            return $this->redirect(['passo1']);
        }

        return $this->render('passo4', [
            'model' => $model,
            'diretorio' => $diretorio,
        ]);
        
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

function actionComprovanteinscricao() {

        $session = Yii::$app->session;
        $id = $session->get('candidato');
        $candidato = $this->findModel($id);

        $recomendacoesArray = Recomendacoes::findAll(['idCandidato' => $id]);
        $experienciaArray = ExperienciaAcademica::findAll(['idCandidato' => $id]);

        $instituicao = array(0 => null, 1 => null, 2=> null);
        $atividade = array(0 => null, 1 => null, 2=> null);
        $periodo  = array(0 => null, 1 => null, 2=> null);

        for ($i=0; $i<sizeof($experienciaArray); $i++){
            $instituicao[$i] = $experienciaArray[$i]->instituicao;
            $atividade[$i] = $experienciaArray[$i]->atividade;
            $periodo[$i] = $experienciaArray[$i]->periodo;
        }


        $pdf = new mPDF('utf-8');
    
    $sexo = array ('M' => "Masculino",'F' => "Feminimo");
    $cursoDesejado = array (1 => "Mestrado",2 => "Doutorado");
    $tipoCursoPos = array (0 => "Mestrado Acadêmico", 1 => "Mestrado Profissional", 2 => "Doutorado");
    $regimeDedicacao = array (1 => "Integral",2 => "Parcial");
    $nacionalidade = array (1 => "Brasileira",2 => "Estrangeira");
    $simOuNao = array (0 => "Não", 1 => "Sim");


    if ($candidato->nacionalidade == 1){
        $campoCPFouPassaporte = "CPF: ".$candidato->cpf;
    }   
    else{
        $campoCPFouPassaporte = "Passaporte: ".$candidato->passaporte;
    }
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
                    <table style= "margin-top:65px;" width="100%;"> 
                    <tr>
                        <td colspan = "1" style="text-align:right;">
                            <b> COMPROVANTE DE INSCRIÇÃO </b>
                        </td>   
                        <td align="right" width="35%">
                            <b>Hora: '.date("H:i").'</b> <br> <b> Data: '.date("d/m/Y").'</b>
                        </td>                        
                    </tr>
                    </table>
                    <table width="100%" style="border-top: solid 1px; ">
                    <tr>
                        <td style= "height:35px;">
                            <b> Dados Pessoais </b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%">
                            Número da inscrição: '.$candidato->id.'
                        </td>   
                        <td colspan="2">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Nome: '.$candidato->nome.'
                        </td> 
                        <td colspan="2">
                            Nome Social: '.$candidato->nomesocial.'
                        </td>   
                    </tr>
                    <tr>
                        <td colspan="2">
                            Endereço: '.$candidato->endereco.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            CEP: '.$candidato->cep.'
                        </td>

                        <td colspan="2">
                            Bairro: '.$candidato->bairro.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Cidade: '.$candidato->cidade.'
                        </td>
                        <td colspan="2">
                            País: '.$candidato->pais.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Data de Nascimento: '.$candidato->datanascimento.'
                        </td>
                        <td colspan="2">
                            Sexo: '.$sexo[$candidato->sexo].'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Nacionalidade: '.$nacionalidade[$candidato->nacionalidade].'
                        </td>
                        <td colspan="2">
                            '.$campoCPFouPassaporte.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Telefone Celular: '.$candidato->telcelular.'
                        </td>
                        <td>
                            Telefone Residencial: '.$candidato->telresidencial.'
                        </td>
                    </tr>
                    <tr>
                        <td style= "height:35px">
                            <b> Dados do PosComp </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Número da Inscrição: '.$candidato->inscricaoposcomp.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Ano: '.$candidato->anoposcomp.'
                        </td>
                        <td colspan="2">
                            Nota: '.$candidato->notaposcomp.'
                        </td>                        
                    </tr>
                    </table>
                    <table width="100%">
                    <tr>
                        <td style= "height:35px">
                            <b> Dados da Inscrição </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"  style="width:50%">
                            Curso Desejado:'.$cursoDesejado[$candidato->cursodesejado].' 
                        </td>

                        <td>
                            Regime de Dedicação: '.$regimeDedicacao[$candidato->regime].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Solicita Bolsa de Estudos? '.$simOuNao[$candidato->solicitabolsa].'
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </table>');

  
    $pdf->WriteHTML('

        <table width="100%" border = "0"> 

                    <tr>
                        <td colspan="3" style= "height:55px; text-align:center; border-bottom: 1px solid #000;border-top: 1px solid #000">
                            <b> FORMAÇÃO ACADÊMICA / PROFISSIONAL </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px;">
                            <b> Curso de Graduação</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Curso: '.$candidato->cursograd.'
                        </td>
                        <td>
                            Instituição: '.$candidato->instituicaograd.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ano Egresso: '.$candidato->egressograd.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Curso de Pos-Graduação Stricto-Senso </b>
                        </td>
                    </tr>                    
                    <tr>
                        <td>
                            Curso: '.$candidato->cursopos.'
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Instituição: '.$candidato->instituicaopos.'
                        </td>
                        <td>
                                Tipo: '.$tipoCursoPos[$candidato->tipopos].'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Publicações </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Períodicos Internacionais: '.$candidato->periodicosinternacionais.'
                        </td>
                        <td>
                                Períodicos Nacionais: '.$candidato->periodicosnacionais.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Conferencias Internacionais: '.$candidato->conferenciasinternacionais.'
                        </td>
                        <td>
                                Conferencias Nacionais: '.$candidato->conferenciasnacionais.'
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style= "height:55px" border = "0">
                            <b> Experiência Acadêmica </b>
                        </td>
                    </tr>
                </table>
                <table width="100%" border = "1">
                    <tr>
                        <th>
                            Instituição
                        </th>
                        <th>
                            Cargo/Função
                        </th>
                        <th>
                            Período
                        </th>
                    </tr>
                    <tr>
                        <td width = "35%" height="22">
                                '.$instituicao[0].'
                        </td>
                        <td width = "35%">
                                '.$atividade[0].'
                        </td>
                        <td>
                                '.$periodo[0].'
                        </td>
                    </tr>
                    <tr>
                        <td  height="22">
                                '.$instituicao[1].'
                        </td>
                        <td>
                                '.$atividade[1].'
                        </td>
                        <td>
                                '.$periodo[1].'
                        </td>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$instituicao[2].'
                        </td>
                        <td>
                                '.$atividade[2].'
                        </td>
                        <td>
                                '.$periodo[2].'
                        </td>
                    </tr>
        </table>
    ');
                
    $pdf->addPage();

    $pdf->WriteHTML('
        <br>
        <table style= "margin-top:65px" width="100%" border = "0"> 

                    <tr>
                        <td colspan="3" style= "height:55px; text-align:center; border-bottom: 1px solid #000;">
                            <b> PROPOSTA DE TRABALHO </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Título da proposta: </b>'.$candidato->tituloproposta.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Linha de pesquisa: </b>'.$candidato->linhapesquisa.'
                        </td>
                    </tr>
                    <tr>
                        <td  style= "vertical-align: text-top;" colspan = "3">
                            <b> Exposição de motivos (exponha resumidamente os motivos que o levaram a se candidatar ao Curso):  </b>
                        </td>
                    </tr>
                    <tr>
                        <td  style= "border: solid 1px; vertical-align: text-top;" colspan = "3" height = "200px">
                            '.$candidato->motivos.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:55px" border = "0">
                            <b> Cartas de Recomendação </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> Nome:  </b>'.$recomendacoesArray[0]->nome.'
                        </td>
                        <td>
                           <b> Email:  </b>'.$recomendacoesArray[0]->email.'
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <b> Nome:  </b>'.$recomendacoesArray[1]->nome.'
                        </td>
                        <td>
                           <b> Email: </b>'.$recomendacoesArray[1]->email.'
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2">
                        <br><br>
                            OBS: anexar a este documento sua proposta de trabalho e demais documentos inseridos no formulário de inscrição
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align: bottom; padding-bottom: 20px" height = "300px">
                            Declaro que as informações prestadas neste formulário são verdadeiras, sob pena de exclusão do Curso.
                            <br><br>
                            Data: ____/____/_______ , Assinatura: __________________________________________________________
                            <br>

                        </td>
                    </tr>


        </table>
        ');

    $pdf->Output('');

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
    /*Curso Desejado:
         1 - Mestrado
         2 - Doutorado
     */
    public function getCursoDesejado($model){
        $ambos = 0;
        $edital = Edital::findOne(['numero' => $model->idEdital]);
        if( $edital->curso == 3)
            $ambos = 3;
        else
            $model->cursodesejado = $edital->curso;

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