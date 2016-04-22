<?php

namespace backend\controllers;

use Yii;
use yii\base\NotSupportedException;
use app\models\ReservaSala;
use app\models\ReservaSalaSearch;
use app\models\SalaSearch;
use app\models\Sala;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservaSalaController implements the CRUD actions for ReservaSala model.
 */
class ReservaSalaController extends Controller
{

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

    public function actionIndex()
    {
        $searchModel = new SalaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCalendario($idSala){
        $reservasCalendario = array();

        $modelSala = Sala::findOne(['id' => $idSala]);
        $reservas = ReservaSala::findAll(['sala' => $idSala]);

        foreach ($reservas as $reserva) {
            $reservaItem = new \yii2fullcalendar\models\Event();
            $reservaItem->id = $reserva->id;
            $reservaItem->title = $reserva->atividade;
            $reservaItem->start = $reserva->dataInicio.'T'.$reserva->horaInicio;
            $reservaItem->end = $reserva->dataTermino.'T'.$reserva->horaTermino;
            $reservasCalendario[] = $reservaItem;
        }

        return $this->render('calendario',[
            'modelSala' => $modelSala,
            'reservasCalendario' => $reservasCalendario,
        ]);
    }

    public function actionCreate()
    {
        $model = new ReservaSala();
        $model->sala = filter_input(INPUT_GET, 'sala');
        $model->idSolicitante = Yii::$app->user->identity->id;
        $model->dataReserva = date('Y-m-d H:i:s');      
        
        $model->dataInicio = date('d-m-Y', strtotime(filter_input(INPUT_GET, 'dataInicio')));
        $model->horaInicio = filter_input(INPUT_GET, 'horaInicio') == '00:00' ? "" : filter_input(INPUT_GET, 'horaInicio');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['calendario', 'idSala' => $model->sala]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->dataInicio = date('d-m-Y', strtotime($model->dataInicio));
        $model->dataTermino = date('d-m-Y', strtotime($model->dataTermino));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ReservaSala::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
