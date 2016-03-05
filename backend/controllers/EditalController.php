<?php

namespace backend\controllers;

use Yii;
use app\models\Edital;
use app\models\SearchEdital;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * EditalController implements the CRUD actions for Edital model.
 */
class EditalController extends Controller
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
     * Lists all Edital models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchEdital();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Edital model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        $model->datainicio = date("d-m-Y", strtotime($model->datainicio));
        $model->datafim = date("d-m-Y", strtotime($model->datafim));

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Edital model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Edital();

        $model->cartarecomendacao = 1;
        $model->cotas = 0;

        if ($model->load(Yii::$app->request->post())) {

            $diainicio = explode("/", $model->datainicio);
            $model->datainicio = $diainicio[2]."-".$diainicio[1]."-".$diainicio[0];

            $diafim = explode("/", $model->datafim);
            $model->datafim =$diafim[2]."-".$diafim[1]."-".$diafim[0];

            if($model->uploadDocumento(UploadedFile::getInstance($model, 'documentoFile'))){
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->numero]);
            }
        }



        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Edital model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $diainicio = explode("/", $model->datainicio);
            $model->datainicio = $diainicio[2]."-".$diainicio[1]."-".$diainicio[0];

            $diafim = explode("/", $model->datafim);
            $model->datafim =$diafim[2]."-".$diafim[1]."-".$diafim[0];

            if($model->uploadDocumento(UploadedFile::getInstance($model, 'documentoFile'))){
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->numero]);
            }
        } else {

            //modelo de conversão de data
            // este modelo de conversão, difere dos demais
            $diainicio = explode("-", $model->datainicio);
            $model->datainicio = $diainicio[2]."/".$diainicio[1]."/".$diainicio[0];

            $diafim = explode("-", $model->datafim);
            $model->datafim =$diafim[2]."/".$diafim[1]."/".$diafim[0];

            //fim do modelo de conversão de data

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Edital model.
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
     * Finds the Edital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Edital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Edital::findOne($id)) !== null) {
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
