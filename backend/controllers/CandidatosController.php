<?php

namespace backend\controllers;

use Yii;
use app\models\Candidato;
use app\models\CandidatosSearch;
use common\models\LinhaPesquisa;
use common\models\Recomendacoes;
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
            'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'only' => ['index','create','update','view','downloads','downloadscompletos'],
                        'rules' => [
                            // allow authenticated users
                            [
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                            // everything else is denied
                        ],
                    ], 
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
        
        //obtendo o nome linha de pesquisa através do id da linha de pesquisa
        $linhaPesquisa = new LinhaPesquisa();
        $linhaPesquisa = $linhaPesquisa->getLinhaPesquisaNome($model->idLinhaPesquisa);
        if ($linhaPesquisa != null){
            $model->idLinhaPesquisa = $linhaPesquisa->nome;
        }
        //fim de obter nome da linha de pesquisa

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

    public function actionAprovar($id,$idEdital)
    {
        $model = $this->findModel($id);

        $cartas_respondidas = new Recomendacoes();
        $cartas_respondidas = $cartas_respondidas->getCartasRespondidas($id);

        if($cartas_respondidas <2){
            $this->mensagens('warning', 'Cartas de Recomendação', 'Não foi possível avaliar o candidato, pois faltam cartas a serem respondidas.');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        if($model->resultado === 1){
            $this->mensagens('warning', 'Candidato Aprovado', 'Este Candidato já foi Aprovado');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        $model->resultado = 1;

        if ($model->save(false)){
            $this->mensagens('success', 'Candidato Aprovado', 'Candidato Aprovado com sucesso.');
        }
        else{
            $this->mensagens('warning', 'Erro no servidor', 'Consulte o administrador do sistema');
        }

        return $this->redirect(['candidatos/index','id'=>$idEdital]);
    }

    public function actionReprovar($id,$idEdital)
    {   
        $model = $this->findModel($id);

        $cartas_respondidas = new Recomendacoes();
        $cartas_respondidas = $cartas_respondidas->getCartasRespondidas($id);

        if($cartas_respondidas <2){
            $this->mensagens('warning', 'Cartas de Recomendação', 'Não foi possível avaliar o candidato, pois faltam cartas a serem respondidas.');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        if($model->resultado === 0){
            $this->mensagens('warning', 'Candidato Reprovado', 'Este Candidato já foi reprovado');
            return $this->redirect(['candidatos/index','id'=>$idEdital]);
        }

        $model->resultado = 0;
        if ($model->save(false)){
            $this->mensagens('success', 'Candidato Reprovado', 'Candidato Reprovado com sucesso.');
        }
        else{
            $this->mensagens('warning', 'Erro no servidor', 'Consulte o administrador do sistema');
        }

        return $this->redirect(['candidatos/index','id'=>$idEdital]);
    }


    public function actionPdf($documento){

        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $mudarDiretorioParaFrontEnd = "../../frontend/web/";

        $localArquivo = $mudarDiretorioParaFrontEnd.$model->getDiretorio().$documento;

       if(!file_exists($localArquivo))
            throw new NotFoundHttpException('A Página solicitada não existe.');

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.$documento.'"');
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($mudarDiretorioParaFrontEnd.$model->getDiretorio().$documento));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        readfile($localArquivo);
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
