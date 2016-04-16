<?php

namespace backend\controllers;

use Yii;
use app\models\BancaControleDefesas;
use app\models\BancaControleDefesasSearch;
use app\models\BancaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BancaControleDefesasController implements the CRUD actions for BancaControleDefesas model.
 */
class BancaControleDefesasController extends Controller
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
     * Lists all BancaControleDefesas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BancaControleDefesasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BancaControleDefesas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        $model = BancaControleDefesas::find()->select("bcd.*, d.*, a.nome as aluno_nome, l.sigla as linhaSigla, if(a.curso = 1, ('Mestrado'),('Doutorado')) as cursoAluno")->where("bcd.id = ".$id)->alias("bcd")->innerJoin("j17_defesa as d","d.banca_id = bcd.id")->innerJoin("j17_aluno as a","d.aluno_id = a.id")
            ->innerJoin("j17_linhaspesquisa as l","l.id = a.area")->one();

        $model_banca = new BancaSearch();
        $dataProvider = $model_banca->search(Yii::$app->request->queryParams,$id);


        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAprovar($id){

        $model = $this->findModel($id);

        var_dump("FALTA A JUSTIFICATIVA");
        exit;


        $model->status_banca = 1;

        $x = $model->save();

        return $this->redirect(['index']);

    }

    /**
     * Creates a new BancaControleDefesas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BancaControleDefesas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BancaControleDefesas model.
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
     * Deletes an existing BancaControleDefesas model.
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
     * Finds the BancaControleDefesas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BancaControleDefesas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BancaControleDefesas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
