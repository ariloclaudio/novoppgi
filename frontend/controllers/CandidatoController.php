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
            
            if($model->uploadPasso1(UploadedFile::getInstance($model, 'cartaempregadorFile'),$model->idEdital)) {
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
            
            if($model->uploadPasso2(UploadedFile::getInstance($model, 'historicoFile'), UploadedFile::getInstance($model, 'curriculumFile'),$model->idEdital)){
                if($model->save(false)){
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
                if($model->save(false)){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações de Proposta de Trabalho e Documentos foram salvas');
                    if(isset($_POST['finalizar'])){
                        /*ENVIAR EMAILS CADASTRADOS*/
                        //$this->notificarCartasRecomendacao($model);
                        
                        return $this->redirect(['passo4']);
                    }
                }else{
                    //$this->mensagens('danger', 'Erro ao Salvar Alterações', 'Ocorreu um Erro ao salvar os dados.');
                    return var_dump($model->getErrors());
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

        $pdf = new mPDF('utf-8');
    
    $sexo = array ('M' => "Masculino",'F' => "Feminimo");
    $cursoDesejado = array (1 => "Mestrado",2 => "Doutorado");
    $regimeDedicacao = array (1 => "Integral",2 => "Parcial");
    $nacionalidade = array (1 => "Brasileira",2 => "Estrangeira");
    
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
                    <table style= "margin-top:80px;" width="100%"> 
                    <tr>
                        <td colspan = "3" style="padding-left:32%; border-bottom: 1px solid #000">
                            <b> COMPROVANTE DE INSCRIÇÃO </b>
                        </td>   
                        <td colspan="3" align="left" width="140px" style="border-bottom: 1px solid #000">
                            <b>Hora: '.date("H:i").'</b> <br> <b> Data: '.date("d/m/Y").'</b>
                        </td>                        
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px;">
                            <b> Dados Pessoais </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Número da inscrição: '.$candidato->id.'
                        </td>   
                    </tr>
                    <tr>
                        <td colspan="3">
                            Nome: '.$candidato->nome.'
                        </td>   
                    </tr>
                    <tr>
                        <td colspan="3">
                            Endereço: '.$candidato->endereco.'
                        </td>
                    <tr>

                        <td>
                            CEP: '.$candidato->cep.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            bairro: '.$candidato->bairro.'
                        </td>
                        <td colspan="2">
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
                        <td>
                            sexo: '.$sexo[$candidato->sexo].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            nacionalidade: '.$nacionalidade[$candidato->nacionalidade].'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            rg: '.$candidato->rg.'
                        </td>
                        <td>
                            orgão de expedição: '.$candidato->orgaoexpedidor.'
                        </td>
                        <td>
                            data expedição: '.$candidato->dataexpedicao.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            cpf: '.$candidato->cpf.'
                        </td>
                        <td>
                            datanascimento: '.$candidato->datanascimento.'
                        </td>
                    </tr>
                    <tr>

                        <td>
                            telresidencial: '.$candidato->telresidencial.'
                        </td>
                        <td>
                            telcelular: '.$candidato->telcelular.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Filiação </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" >
                            nome mae: '.$candidato->nomemae.'1111111111111111111
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            nome pai: '.$candidato->nomepai.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Dados do PosComp </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            inscricao poscomp: '.$candidato->inscricaoposcomp.'
                        </td>
                        <td>
                            ano pos comp: '.$candidato->anoposcomp.'
                        </td>
                        <td>
                            nota pos comp: '.$candidato->notaposcomp.'
                        </td>                        
                    </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td colspan="3" style= "height:55px; text-align:center; border-bottom: 1px solid #000; border-top: 1px solid #000 ">
                                <b> DADOS DA INSCRIÇÃO </b>
                            </td>
                        </tr>
                    </table>
                    <table>
                    <tr>
                        <td> 
                            Curso Desejado:'.$cursoDesejado[$candidato->cursodesejado].' 
                        </td>
                        <td>
                            Regime de Dedicação: '.$regimeDedicacao[$candidato->regime].'
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
                </table>');

  
    $pdf->addPage();    
    $pdf->WriteHTML('
        <br>
        <table style= "margin-top:80px" width="100%" border = "0"> 

                    <tr>
                        <td colspan="3" style= "height:55px; text-align:center; border-bottom: 1px solid #000;">
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
                            Coeficiente de Rendimento: '.$candidato->crgrad.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Instituição: '.$candidato->instituicaograd.'
                        </td>
                        <td>
                            Ano Egresso: '.$candidato->egressograd.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Curso de Especialização(ou Aperfeiçoamento) </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Curso: '.$candidato->cursoesp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Instituição: '.$candidato->instituicaoesp.'
                        </td>
                        <td>
                            Ano Egresso: '.$candidato->egressoesp.'
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
                            Ano Egresso: '.$candidato->egressoesp.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Instituição: '.$candidato->instituicaopos.'
                        </td>
                        <td>
                                Tipo: '.$cursoDesejado[$candidato->tipopos].'
                        </td>
                        <td>
                                Média: '.$candidato->mediapos.'
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
                        <td colspan="3" style= "height:35px">
                            <b> Língua Inglesa</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                instituicao ingles: '.$candidato->instituicaoingles.'
                        </td>
                        <td>
                                duração ingles: '.$candidato->duracaoingles.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:35px">
                            <b> Exame de Proeficiência </b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                nome exame: '.$candidato->nomeexame.'
                        </td>
                        <td>
                                data exame: '.$candidato->dataexame.'
                        </td>
                        <td>
                                nota exame: '.$candidato->notaexame.'
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style= "height:55px">
                            <b> Experiência Profissional </b>
                        </td>
                    </tr>
                </table>
                <table width="100%" border = "1"> 
                    <tr>
                        <th>
                            Empresa
                        </th>
                        <th>
                            Cargo/Função
                        </th>
                        <th>
                            Período
                        </th>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$candidato->empresa1.'
                        </td>
                        <td>
                                '.$candidato->cargo1.'
                        </td>
                        <td>
                                '.$candidato->periodoprofissional1.'
                        </td>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$candidato->empresa2.'
                        </td>
                        <td>
                                '.$candidato->cargo2.'
                        </td>
                        <td>
                                '.$candidato->periodoprofissional2.'
                        </td>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$candidato->empresa3.'
                        </td>
                        <td>
                                '.$candidato->cargo3.'
                        </td>
                        <td>
                                '.$candidato->periodoprofissional3.'
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan="3" style= "height:55px" border = "0">
                            <b> Experiência Acadêmica </b>
                        </td>
                    </tr>
                </table>
                <table width="100%" border = "1">
                    <tr>
                        <th>
                            Instituicao
                        </th>
                        <th>
                            Cargo/Função
                        </th>
                        <th>
                            Período (de X até Y)
                        </th>
                    </tr>
                    <tr>
                    <tr>
                        <td height="22">
                                '.$candidato->instituicaoacademica1.'
                        </td>
                        <td>
                                '.$candidato->atividade1.'
                        </td>
                        <td>
                                '.$candidato->periodoacademico1.'
                        </td>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$candidato->instituicaoacademica2.'
                        </td>
                        <td>
                                '.$candidato->atividade2.'
                        </td>
                        <td>
                                '.$candidato->periodoacademico2.'
                        </td>
                    </tr>
                    <tr>
                        <td height="22">
                                '.$candidato->instituicaoacademica3.'
                        </td>
                        <td>
                                '.$candidato->atividade3.'
                        </td>
                        <td>
                                '.$candidato->periodoacademico3.'
                        </td>
                    </tr>
        </table>
    ');
                
    $pdf->addPage();

    $pdf->WriteHTML('
        <br>
        <table style= "margin-top:80px" width="100%" border = "0"> 

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
                        <td colspan = "3" height = "100px">
                            <b> Exposição de motivos (exponha resumidamente os motivos que o levaram a se candidatar ao Curso):  </b>'.$candidato->motivos.'
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