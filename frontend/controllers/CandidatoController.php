<?php

namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Recomendacoes;
use app\models\CandidatoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

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
    public function actionPasso1()
    {
        $model = new Candidato();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create1', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Exibe Formulário no passo 2
     */
    public function actionPasso2()
    {
        $model = new Candidato();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create2', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Exibe Formulário no passo 3
     */
    public function actionPasso3()
    {
        $model = new Candidato();        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
        $idCandidato = filter_input(INPUT_GET, 'idCandidato');
        /*
        if(!isset($idCandidato))
            return "FALTA ID DO CANDIDATO";
        */

        $model = new Candidato();    

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('passo4', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Lists all Candidato models.
     * @return mixed
     */
    public function actionIndex()

    {
        $searchModel = new CandidatoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Candidato model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
}
