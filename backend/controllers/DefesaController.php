<?php

namespace backend\controllers;

use Yii;
use app\models\Defesa;
use app\models\DefesaSearch;
use app\models\BancaControleDefesas;
use app\models\Banca;
use app\models\BancaSearch;
use app\models\MembrosBanca;
use app\models\MembrosBancaSearch;
use app\models\Aluno;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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

        $model_defesa = $this->findModel($idDefesa, $aluno_id);

        $model_banca = new BancaSearch();
        $dataProvider = $model_banca->search(Yii::$app->request->queryParams,$model_defesa->banca_id);

        return $this->render('view', [
            'model' => $model_defesa,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Defesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($aluno_id)
    {

        $membrosBancaInternos = ArrayHelper::map(MembrosBanca::find()->where("filiacao = 'PPGI/UFAM'")->orderBy('nome')->all(), 'id', 'nome','filiacao');

        $membrosBancaExternos = ArrayHelper::map(MembrosBanca::find()->where("filiacao <> 'PPGI/UFAM'")->orderBy('nome')->all(), 'id', 'nome','filiacao');


        $model = new Defesa();

        $model->aluno_id = $aluno_id;

        $cont_Defesas = Defesa::find()->where("aluno_id = ".$aluno_id)->count();
        $curso = Aluno::find()->select("curso")->where("id =".$aluno_id)->one()->curso;

            if($cont_Defesas == 0){
                $model->tipoDefesa = "Q1";
                $titulo = "Qualificação 1";
            }
            else if ($cont_Defesas == 1 && $curso == 1){
                $model->tipoDefesa = "D";
                $titulo = "Dissertação";
            }
            else if ($cont_Defesas == 1 && $curso == 2){
                $model->tipoDefesa = "Q2";
                $titulo = "Qualificação 2";
            }
            else if ($cont_Defesas == 2 && $curso == 2){
                $model->tipoDefesa = "T";
                $titulo = "Tese";
            }

        if ($model->load(Yii::$app->request->post() ) ) {

            $model_ControleDefesas = new BancaControleDefesas();
            $model_ControleDefesas->status_banca = null;
            $model_ControleDefesas->save(false);

            $model->banca_id = $model_ControleDefesas->id;

            $model->save();

            return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
        }
        else if ( ($curso == 1 && $cont_Defesas >= 2) || ($curso == 2 && $cont_Defesas >= 3) ){
            $this->mensagens('danger', 'Solicitar Banca', 'Não foi possível solicitar banca, pois esse aluno já possui '.$cont_Defesas.' defesas cadastradas');
            return $this->redirect(['aluno/orientandos',]);
        }
         else {

            return $this->render('create', [
                'model' => $model,
                'titulo' => $titulo,
                'membrosBancaInternos' => $membrosBancaInternos,
                'membrosBancaExternos' => $membrosBancaExternos,
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


        //SÓ PODE EDITAR A DEFESA SE ELA NÃO FOI CONCEITUADA! TEM DE CHECAR SE CONCEITO == NULL

        $model_aluno = Aluno::find()->where("id = ".$aluno_id)->one();


        $model = $this->findModel($idDefesa, $aluno_id);

        if($model->conceito != null){
            $this->mensagens('danger', 'Não é possível editar', 'Não foi possível editar, pois essa defesa já possui conceito');
            return $this->redirect(['index']);
        }

        $model->data = date('d-m-Y', strtotime($model->data));
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->data = date('Y-m-d', strtotime($model->data));
            $model->save();
            
            
            return $this->redirect(['view', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_aluno' => $model_aluno,

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

        //SÓ PODE EXCLUIR A DEFESA SE ELA NÃO NÃO POSSUIR BANCA! TEM DE CHECAR SE banca_id == 0
        $model = $this->findModel($idDefesa, $aluno_id);

        if($model->banca_id != 0){
            $this->mensagens('danger', 'Não Excluído', 'Não foi possível excluir, pois essa defesa já possui banca aprovada');
            return $this->redirect(['index']);
        }

        $model->delete();

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
