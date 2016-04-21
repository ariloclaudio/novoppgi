<?php

namespace backend\controllers;

use Yii;
use app\models\Ferias;
use common\models\User;
use app\models\FeriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeriasController implements the CRUD actions for Ferias model.
 */
class FeriasController extends Controller
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
                    'deletesecretaria' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ferias models.
     * @return mixed
     */
    public function actionIndex()
    {

     $idUser = Yii::$app->user->identity->id;


        $searchModel = new FeriasSearch();
        $dataProvider = $searchModel->searchMinhasFerias(Yii::$app->request->queryParams , $idUser);
        


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListar($ano)
    {


        $idUser = Yii::$app->user->identity->id;

        if (Yii::$app->user->identity->professor == 1 || Yii::$app->user->identity->coordenador == 1){
            $direitoQtdFerias = 45;
        }
        else{
            $direitoQtdFerias = 30;   
        }


        $model = new Ferias();
        $todosAnosFerias = $model->anosFerias($idUser);

        $qtd_ferias_oficiais = $model->feriasAno($idUser,$ano,1);
        $qtd_usufruto_ferias = $model->feriasAno($idUser,$ano,2);



        $searchModel = new FeriasSearch();
        $dataProvider = $searchModel->searchMinhasFerias(Yii::$app->request->queryParams , $idUser ,$ano);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'todosAnosFerias' => $todosAnosFerias,
            'direitoQtdFerias' => $direitoQtdFerias,
            "qtd_ferias_oficiais" => $qtd_ferias_oficiais,
            "qtd_usufruto_ferias" => $qtd_usufruto_ferias,

        ]);
    }

    public function actionDetalhar($ano,$id)
    {


        $idUser = $id;

        $model = new Ferias();

        $ehProf = $model->verificarSeEhProfessor($id);

        if ($ehProf == 1){
            $direitoQtdFerias = 45;
        }
        else{
            $direitoQtdFerias = 30;   
        }
       
        $todosAnosFerias = $model->anosFerias($idUser);

        $qtd_ferias_oficiais = $model->feriasAno($idUser,$ano,1);
        $qtd_usufruto_ferias = $model->feriasAno($idUser,$ano,2);



        $searchModel = new FeriasSearch();
        $dataProvider = $searchModel->searchMinhasFerias(Yii::$app->request->queryParams , $idUser ,$ano);

        return $this->render('detalhar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'todosAnosFerias' => $todosAnosFerias,
            'direitoQtdFerias' => $direitoQtdFerias,
            "qtd_ferias_oficiais" => $qtd_ferias_oficiais,
            "qtd_usufruto_ferias" => $qtd_usufruto_ferias,
            "id" => $id,

        ]);
    }
    
    public function actionListartodos($ano)
    {


        $idUser = Yii::$app->user->identity->id;

        if (Yii::$app->user->identity->professor == 1 || Yii::$app->user->identity->coordenador == 1){
            $direitoQtdFerias = 45;
        }
        else{
            $direitoQtdFerias = 30;   
        }


        $model = new Ferias();
        $todosAnosFerias = $model->anosFerias(null);

        $qtd_ferias_oficiais = $model->feriasAno($idUser,$ano,1);
        $qtd_usufruto_ferias = $model->feriasAno($idUser,$ano,2);



        $searchModel = new FeriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams , $ano);

        return $this->render('listarTodos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'todosAnosFerias' => $todosAnosFerias,
        ]);
    }

    /**
     * Displays a single Ferias model.
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
     * Creates a new Ferias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Ferias();
        $model->idusuario = Yii::$app->user->identity->id;
        $model->nomeusuario = Yii::$app->user->identity->nome;
        $model->emailusuario = Yii::$app->user->identity->email;
        $model->dataPedido = date("Y-m-d H:i:s");

        $ehProfessor = Yii::$app->user->identity->professor;
        $ehCoordenador = Yii::$app->user->identity->coordenador;
        $ehSecretario = Yii::$app->user->identity->secretaria;

        if ($model->load(Yii::$app->request->post())) {


                $model->dataSaida = date('Y-m-d', strtotime($model->dataSaida));
                $model->dataRetorno =  date('Y-m-d', strtotime($model->dataRetorno));


                $feriasAno = new Ferias();
                $anoSaida = date('Y', strtotime($model->dataSaida));
                $totalDiasFeriasAno = $feriasAno->feriasAno($model->idusuario,$anoSaida,$model->tipo);


                $datetime1 = new \DateTime($model->dataSaida);
                $datetime2 = new \DateTime($model->dataRetorno);
                $interval = $datetime1->diff($datetime2);
                $diferencaDias =  $interval->format('%a');

                if( $diferencaDias == 0 || $interval->format('%R') == "-"){

                    $this->mensagens('danger', 'Registro Férias',  'Datas inválidas!');

                        $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                        $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                    return $this->render('create', [
                            'model' => $model,
                        ]);

                }

                    if( ($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) <=45 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');

                        return $this->redirect(['view', 'id' => $model->id]);

                    }
                    else if( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) <= 30 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');
                    
                        return $this->redirect(['view', 'id' => $model->id]);
                    
                    }
                    else if ((($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) >=45)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 45 dias');
                    }

                    else if (( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) >= 30)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 30 dias');

                    }

                $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                return $this->render('create', [
                        'model' => $model,
                    ]);


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreatesecretaria($id)
    {

        $model = new Ferias();

        $model_User = User::find()->where(["id" => $id])->one();


        $model->idusuario = $id;
        $model->nomeusuario = $model_User->nome;
        $model->emailusuario = $model_User->email;
        $model->dataPedido = date("Y-m-d H:i:s");

        $ehProfessor = $model_User->professor;
        $ehCoordenador = $model_User->coordenador;
        $ehSecretario = $model_User->secretaria;

        if ($model->load(Yii::$app->request->post())) {


                $model->dataSaida = date('Y-m-d', strtotime($model->dataSaida));
                $model->dataRetorno =  date('Y-m-d', strtotime($model->dataRetorno));


                $feriasAno = new Ferias();
                $anoSaida = date('Y', strtotime($model->dataSaida));
                $totalDiasFeriasAno = $feriasAno->feriasAno($model->idusuario,$anoSaida,$model->tipo);


                $datetime1 = new \DateTime($model->dataSaida);
                $datetime2 = new \DateTime($model->dataRetorno);
                $interval = $datetime1->diff($datetime2);
                $diferencaDias =  $interval->format('%a');

                if( $diferencaDias == 0 || $interval->format('%R') == "-"){

                    $this->mensagens('danger', 'Registro Férias',  'Datas inválidas!');

                        $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                        $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                    return $this->render('createsecretaria', [
                            'model' => $model,
                        ]);

                }

                    if( ($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) <=45 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');

                        return $this->redirect(['detalhar', 'id' => $model->idusuario, 'ano' => date("Y")]);

                    }
                    else if( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) <= 30 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');
                    
                        return $this->redirect(['detalhar', 'id' => $model->idusuario , 'ano' => date("Y")]);
                    
                    }
                    else if ((($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) >=45)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 45 dias');
                    }

                    else if (( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) >= 30)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 30 dias');

                    }

                $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                return $this->render('createsecretaria', [
                        'model' => $model,
                    ]);


        } else {
            echo "oi";
            return $this->render('createsecretaria', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ferias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $ehProfessor = Yii::$app->user->identity->professor;
        $ehCoordenador = Yii::$app->user->identity->coordenador;
        $ehSecretario = Yii::$app->user->identity->secretaria;

        if ($model->load(Yii::$app->request->post())) {


                $model->dataSaida = date('Y-m-d', strtotime($model->dataSaida));
                $model->dataRetorno =  date('Y-m-d', strtotime($model->dataRetorno));


                $feriasAno = new Ferias();
                $anoSaida = date('Y', strtotime($model->dataSaida));
                $totalDiasFeriasAno = $feriasAno->feriasAno($model->idusuario,$anoSaida,$model->tipo);


                $datetime1 = new \DateTime($model->dataSaida);
                $datetime2 = new \DateTime($model->dataRetorno);
                $interval = $datetime1->diff($datetime2);
                $diferencaDias =  $interval->format('%a');

                if( $diferencaDias == 0 || $interval->format('%R') == "-"){

                    $this->mensagens('danger', 'Registro Férias',  'Datas inválidas!');

                        $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                        $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                    return $this->render('create', [
                            'model' => $model,
                        ]);

                }

                    if( ($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) <=45 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');

                        return $this->redirect(['view', 'id' => $model->id]);

                    }
                    else if( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) <= 30 && $model->save()){

                        $this->mensagens('success', 'Registro Férias',  'Registro de Férias realizado com sucesso!');
                    
                        return $this->redirect(['view', 'id' => $model->id]);
                    
                    }
                    else if ((($ehProfessor == 1 || $ehCoordenador == 1) && ($totalDiasFeriasAno+$diferencaDias) >=45)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 45 dias');
                    }

                    else if (( $ehSecretario == 1  && ($totalDiasFeriasAno+$diferencaDias) >= 30)) {

                        $this->mensagens('danger', 'Registro Férias', 'Não foi possível registrar o pedido de férias. Você ultrapassou o limite de 30 dias');

                    }

                $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

                return $this->render('create', [
                        'model' => $model,
                    ]);

        } else {

                $model->dataSaida = date('d-m-Y', strtotime($model->dataSaida));
                $model->dataRetorno =  date('d-m-Y', strtotime($model->dataRetorno));

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ferias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     //funcao usada por cada professor/técnico
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        

        return $this->redirect(['listar','ano'=> date("Y")]);
    }
    //função usada na view da Secretaria, o qual lista todos os membros
    public function actionDeletesecretaria($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(['listartodos','ano'=> date("Y")]);
    }

    /**
     * Finds the Ferias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ferias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ferias::findOne($id)) !== null) {
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
