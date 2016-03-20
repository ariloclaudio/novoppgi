<?php

namespace frontend\controllers;

use Yii;
use app\models\Recomendacoes;
use app\models\RecomendacoesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecomendacoesController implements the CRUD actions for Recomendacoes model.
 */
class RecomendacoesController extends Controller
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
     * Displays a single Recomendacoes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Recomendacoes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($token){
        
        $this->layout = '@app/views/layouts/main2.php';
        $model = Recomendacoes::findOne(['token' => $token]);

        $erro = array();

        if(!isset($model)){
            $erro['titulo'] = 'Token Inválido';
            $erro['menssagem'] = 'Confirme-o no email que você recebeu do PPGI.';

            return $this->render('cartarecomendacaoerro', [
                'erro' => $erro,
            ]);
        }

        $erroCarta = $model->erroCartaRecomendacao();

        if($erroCarta == 1){
            $erro['titulo'] = 'Carta de Recomendação Já Enviada';
            $erro['menssagem'] = 'Esta carta já foi submetida ao PPGI.';

            return $this->render('cartarecomendacaoerro', [
                'erro' => $erro,
            ]);
        }else if($erroCarta == 2){
            $erro['titulo'] = 'Carta de Recomendação Fora do Prazo';
            $erro['menssagem'] = 'Prazo esgotado para envio da carta. Contate o PPGI.';

            return $this->render('cartarecomendacaoerro', [
                'erro' => $erro,
            ]);
        }
        $model->passo = 2;

        if ($model->load(Yii::$app->request->post())){            
            if(isset($_POST['enviar']))
                $model->setDataEnvio();
                $model->setDataResposta();
                $model->setCheckbox();
                if($model->save()){
                    if(isset($_POST['enviar']))
                        return $this->render('cartarecomendacaomsg', ['model' => $model,]);
                    else
                        $this->mensagens('success', 'Salvo com sucesso', 'As informações da carta de recomendação foram salvas com sucesso.');
                }else
                    $this->mensagens('danger', 'Erro ao salvar carta', 'Ocorreu um erro ao salvar as informações da carta de recomendação. 
                        Verifique os campos e tente novamente');
        }
            
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Recomendacoes model.
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
     * Finds the Recomendacoes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recomendacoes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recomendacoes::findOne($id)) !== null) {
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
