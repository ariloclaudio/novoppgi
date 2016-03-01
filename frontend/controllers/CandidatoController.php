<?php

namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use app\models\Recomendacoes;
use app\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\UploadForm;
use yii\web\UploadedFile;

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

            if($model->passoatual == 2){
                $model->passoatual = 3;
            }

            /*Envio das cartas de Email*/
            /*Yii::$app->mailer->compose()
            ->setFrom('fjsl@icomp.ufam.edu.br')
            ->setTo('fabriciolima31@gmail.com')
            ->setSubject("[SGE] RecuperaÃ§Ã£o de Senha")
            ->setTextBody("Serviço de Recuperação de senha"."\n\n"."Olá Fulano, você solicitou a recuperação da sua senha. Geramos automaticamente uma nova senha de acesso para você. \nPor favor efetue o login no sistema com esta nova senha e modifique-a se achar necessário:\n\nSenha: 123")
            ->send();*/


            if($model->uploadPasso3(UploadedFile::getInstance($model, 'propostaFile'), UploadedFile::getInstance($model, 'comprovanteFile'))){
                if($model->save(false)){
                    $this->mensagens('success', 'Alterações Salvas com Sucesso', 'Suas informações de Proposta de Trabalho e Documentos foram salvas');
                    return $this->redirect(['passo4']);
                }
            }
            else{
                $this->mensagens('danger', 'Erro ao Enviar arquivos', 'Ocorreu um Erro ao enviar os arquivos submetidos');
            }


            return $this->redirect(['passo4']);
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

    public function getCursoDesejado($model){
        $ambos = 0;
        if(Edital::findOne(['numero' => $model->idEdital])->curso == 3)
            $ambos = 3;
        else
            $model->cursodesejado = Edital::findOne(['numero' => $model->idEdital])->curso;
        return $ambos;
    }
}