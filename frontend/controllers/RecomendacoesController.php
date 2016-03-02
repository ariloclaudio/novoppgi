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
     * Lists all Recomendacoes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecomendacoesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
    public function actionCreate($token)
    {
        $this->layout = '@app/views/layouts/main2.php';
        $model = Recomendacoes::findOne(['token' => $token]);

        if(!isset($model))
            return "TOKEN INVÁLIDO";

        $erroCarta = $model->erroCartaRecomendacao();

        if($erroCarta == 1)
            return "CARTA JÁ ENVIADA";
        else if($erroCarta == 2)
            return "CARTA FORA DO PRAZO";


        if ($model->load(Yii::$app->request->post()))
                if($model->save())            
                    return $this->render('cartarecomendacaomsg', [
                        'model' => $model,
                    ]);
                else
                    $this->mensagens('danger', 'Erro ao enviar carta', 'Ocorreu um erro ao enviar a carta de recomendação. 
                        Verifique os campos e tente novamente');
            
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
     * Deletes an existing Recomendacoes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
