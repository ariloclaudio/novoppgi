<?php

namespace backend\controllers;

use Yii;
use app\models\Edital;
use common\models\User;
use common\models\Recomendacoes;
use app\models\Candidato;
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
            'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'rules' => [
                            [
                                'allow' => true,
                                'roles' => ['@'],
                                'matchCallback' => function ($rule, $action) {
                                       return Yii::$app->user->identity->checarAcesso('coordenacao');
                                }
                            ],
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

        $model->datainicio = date("d-M-Y", strtotime($model->datainicio));
        $model->datafim = date("d-M-Y", strtotime($model->datafim));

        return $this->render('view', [
            'model' => $model,
        ]);
    }



//funções responsáveis pelas notificações de novas INSCRIÇÕES
    public function actionListacandidatos()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_candidatos;
            $candidato = Candidato::find()->where("inicio > '".$ultima_visualizacao."'")->orderBy("inicio DESC")->all(); 

            for ($i=0; $i<count($candidato); $i++){
                echo "<li><a href='#'>";
                echo "<div class='pull-left'>
                <img src='../web/img/candidato.png' class='img-circle'
                alt='user image'/>
                </div>";
                echo("<p>"."Email: ".$candidato[$i]->email)."<br>";
                echo("Data: ".$candidato[$i]->inicio)."</p></a></li>";
            }

    }

    public function actionQuantidadecandidatos()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_candidatos;
            $candidato = Candidato::find()->where("inicio > '".$ultima_visualizacao."'")->all(); 

            echo count($candidato);

    }

    public function actionZerarnotificacaoinscricoes()
    {       
            $usuario = new User();
            $usuario = $usuario->findIdentity(Yii::$app->user->identity->id);
            $usuario->visualizacao_candidatos = date("Y-m-d H:i:s");
            $usuario->save();
    }
    
//fim das funções responsáveis pelas notificações de novas INSCRIÇÕES

//inicio das funcoes responsáveis pelas notificações de ENCERRAMENTO de novas inscrições:


    public function actionListaencerrados()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_candidatos_finalizados;
            $candidato = Candidato::find()->where("fim > '".$ultima_visualizacao."'")->orderBy("fim DESC")->all(); 

            for ($i=0; $i<count($candidato); $i++){
                echo "<li><a href='#'>";
                echo "<div class='pull-left'>
                <img src='../web/img/candidato.png' class='img-circle'
                alt='user image'/>
                </div>";
                echo("<p>"."Email: ".$candidato[$i]->email)."<br>";
                echo("Data: ".$candidato[$i]->fim)."</p></a></li>";
            }

    }

    public function actionQuantidadeencerrados()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_candidatos_finalizados;
            $candidato = Candidato::find()->where("fim > '".$ultima_visualizacao."'")->all(); 

            echo count($candidato);

    }

    public function actionZerarnotificacaoencerrados()
    {       
            $usuario = new User();
            $usuario = $usuario->findIdentity(Yii::$app->user->identity->id);
            $usuario->visualizacao_candidatos_finalizados = date("Y-m-d H:i:s");
            $usuario->save();
    }
//fim das funções responsáveis pelas notificações de encerramento de novas inscrições

//funções responsáveis pelas notificações das cartas respondidas


    public function actionCartasrespondidas()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_cartas_respondidas;
            $recomendacao = Recomendacoes::find()->innerJoin('j17_candidatos','j17_candidatos.id = j17_recomendacoes.idCandidato')->
                where("dataResposta > '".$ultima_visualizacao."'")->orderBy("dataResposta DESC")->all();

            for ($i=0; $i<count($recomendacao); $i++){
                echo "<li><a href='#'>";
                echo "<div class='pull-left'>
                <img src='../web/img/candidato.png' class='img-circle'
                alt='user image'/>
                </div>";
                echo("<p>"."Candidato: ".$recomendacao[$i]->candidato->nome)."<br>";
                echo("<p>"."Recomendado por: ".$recomendacao[$i]->nome)."<br>";
                echo("Data Resposta: ".$recomendacao[$i]->dataResposta)."</p></a></li>";
            }

    }

    public function actionQuantidadecartasrecebidas()
    {       

            $ultima_visualizacao = Yii::$app->user->identity->visualizacao_cartas_respondidas;
            $recomendacao = Recomendacoes::find()->innerJoin('j17_candidatos','j17_candidatos.id = j17_recomendacoes.idCandidato')->
                where("dataResposta > '".$ultima_visualizacao."'")->all();

            echo count($recomendacao);

    }

    public function actionZerarnotificacaocartas()
    {       
            $usuario = new User();
            $usuario = $usuario->findIdentity(Yii::$app->user->identity->id);
            $usuario->visualizacao_cartas_respondidas = date("Y-m-d H:i:s");
            $usuario->save();
    }


//fim das funções responsáveis pelas notificações das cartas respondidas


    public function actionCreate()
    {
        $model = new Edital();

        $model->cartarecomendacao = 1;
        $model->mestrado = 1;
        $model->doutorado = 1;

        if ($model->load(Yii::$app->request->post())) {
            
            if($model->mestrado == 1 && $model->doutorado == 1)
                $model->curso = '3';
            else if($model->mestrado == 1)
                $model->curso = '1';
            else if($model->doutorado == 1)
                $model->curso = '2';
            else
                $model->curso = '0';

            if($model->uploadDocumento(UploadedFile::getInstance($model, 'documentoFile'))){
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->numero]);
                else
                    return $this->render('create', [
                        'model' => $model,
                    ]);
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

        $model->datainicio = date('d-m-Y', strtotime($model->datainicio));
        $model->datafim =  date('d-m-Y', strtotime($model->datafim));

        if ($model->load(Yii::$app->request->post())) {
            //return $model->mestrado." ".$model->doutorado;
            if($model->mestrado == 1 && $model->doutorado == 1)
                $model->curso = '3';
            else if($model->mestrado == 1)
                $model->curso = '1';
            else if($model->doutorado == 1)
                $model->curso = '2';
            else
                $model->curso = '0';


            if($model->uploadDocumento(UploadedFile::getInstance($model, 'documentoFile'))){
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->numero]);
                }
                else{
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
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


    /*Apenas para para evitar a listagem dos editais*/
    public function actionDelete2($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;

        $model->salve();

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
