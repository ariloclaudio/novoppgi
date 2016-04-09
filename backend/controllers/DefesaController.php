<?php

namespace backend\controllers;

use Yii;
use app\models\Defesa;
use app\models\DefesaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->render('view', [
            'model' => $this->findModel($idDefesa, $aluno_id),
        ]);
    }

    /**
     * Creates a new Defesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Defesa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
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
        $model = $this->findModel($idDefesa, $aluno_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $this->findModel($idDefesa, $aluno_id)->delete();

        return $this->redirect(['index']);
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
}
