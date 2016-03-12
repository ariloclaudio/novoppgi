<?php

namespace backend\controllers;

use Yii;
use app\models\Candidato;
use app\models\CandidatosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CandidatosController implements the CRUD actions for Candidato model.
 */
class CandidatosController extends Controller
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
     * Lists all Candidato models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new CandidatosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idEdital' => $id,
        ]);
    }

    /**
     * Displays a single Candidato model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        switch ($model->linhapesquisa) {
            case 1:
                //return "BD e RI";
                $model->linhapesquisa = 'Banco de Dados e Recuperação de Informação';
                break;
            case 2:
                //return "SistEmb & EngSW";
                $model->linhapesquisa = 'Sistemas Embarcados e Engenharia de Software';
                break;
            case 3:
                //return "Int. Art.";
                $model->linhapesquisa = 'Inteligência Artificial';
                break;
            case 4:
                //return "Visão Comp. e Rob.";
                $model->linhapesquisa = 'Visão Computacional e Robótica';
                break;
            case 5:
                //return "Redes e Telec.";
                $model->linhapesquisa = 'Redes e Telecomunicações';
                break;
            case 5:
                //return "Ot., Alg. e Complex.";
                $model->linhapesquisa = 'Otimização, Alg. e Complexidade Computacional';
                break;
        }

        return $this->render('view', [
            'model' => $model,
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
     * Deletes an existing Candidato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionDownloadscompletos($id){

        $idEdital = $id;

        $resultado = shell_exec("cd ../../frontend/web/documentos/ && zip -r ".$idEdital.".zip ".$idEdital);

        if (is_dir('../../frontend/web/documentos/'.$idEdital)){

            header('Content-type: application/zip');
            header('Content-disposition: attachment; filename=Doc_Completos_'.$idEdital.".zip");
            readfile("../../frontend/web/documentos/".$idEdital.".zip");
            unlink("../../frontend/web/documentos/".$idEdital.".zip");

        }
        else{

        $this->mensagens('warning', 'Não há documentos', 'Nenhum candidato fez upload de sua documentação.');

        return $this->redirect(['edital/view','id'=>$id]);

        }

    }


    public function actionDownloads($id,$idEdital)
    {
        //$model = $this->findModel($id);

        $modelCandidato = new Candidato();
        $candidato = $modelCandidato->download($id,$idEdital);


        $salt1 = "programadeposgraduacaoufamicompPPGI";
        $salt2 = $id * 777;
        $idCriptografado = md5($salt1+$id+$salt2);


        $diretorio = '../../frontend/web/documentos/'.$idEdital.'/'.$idCriptografado;


        $zipFile = $candidato->nome.'_doc_ppgi.zip';
        $zipArchive = new \ZipArchive();

            if (!$zipArchive->open($zipFile, \ZIPARCHIVE::OVERWRITE))
                die("Failed to create archive\n");

                $options = array('add_path' => '/', 'remove_path' => $diretorio);

                $zipArchive->addGlob($diretorio.'/*', GLOB_BRACE, $options);

            if (!$zipArchive->status == \ZIPARCHIVE::ER_OK)
                echo "Failed to write files to zip\n";

            $zipArchive->close();
            header('Content-type: application/zip');
            header('Content-disposition: attachment; filename='.$zipFile);
            readfile($zipFile);
            unlink($zipFile);

    }



    /**
     * Finds the Candidato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
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



}
