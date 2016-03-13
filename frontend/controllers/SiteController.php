<?php
namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@app/views/layouts/main-login.php';
        $model = new Candidato();
        return $this->render('opcoes',['model' => $model,
            ]);
    }

    public function actionCadastroppgi(){
        
    $this->layout = '@app/views/layouts/main-login.php';
    
    $model = new Candidato();

    //$model->idEdital = $id;    

        if ($model->load(Yii::$app->request->post())){                

            $model->inicio = date("Y-m-d H:i:s");
            $model->passoatual = 0;
            $model->repetirSenha = $model->senha = Yii::$app->security->generatePasswordHash($model->senha);
            $model->status = 10;
            
            try{
                if(!$model->save()){
                    $this->mensagens('warning', 'Candidato Já Inscrito', 'Candidato Informado Já se Encontra cadastrado para este edital, Efetue o seu Login.');

                    return $this->redirect(['site/login']);
                }else{
                    //setando o id do candidato via sessão
                        $session = Yii::$app->session;
                        $session->open();
                        $session->set('candidato',$model->id);
                    //fim -> setando id do candidato

                    return $this->redirect(['candidato/passo1']);
                }
            }catch(\Exception $e){ 
                return var_dump($e);
                $this->mensagens('danger', 'Erro ao salvar candidato', 'Verifique os campos e tente novamente');
                throw new \yii\web\HttpException(405, 'Erro com relação ao identificador do edital'); 
            }
        }

        $edital = new Edital();
        $edital = $edital->getEditaisDisponiveis();

        return $this->render('/candidato/create0', [
            'model' => $model,
            'edital' => $edital,
        ]);
    }

    public function actionLogin()
    {

        /*Redirecionamento para o formulário caso candidato esteja "logado"*/
        
        /*if(Yii::$app->session->get('candidato') !== null)
            $this->redirect(['candidato/passo1']);*/


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()){

            //setando o id do candidato via sessão
            $session = Yii::$app->session;
            $session->open();
            $session->set('candidato', Yii::$app->user->identity->id);
            //fim -> setando id do candidato
            $this->redirect(['candidato/passo1']);
        }else{

        $edital = new Edital();
        $edital = $edital->getEditaisDisponiveis();
            
            return $this->render('login', [
                'model' => $model,
                'edital' => $edital,

            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->session->destroy();

        return $this->goHome();
    }

    
    /*
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    public function actionAbout()
    {
        return $this->render('about');
    }

*/
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $this->mensagens('success', 'Email Enviado com Sucesso.', 'Verifique sua conta de email');

                return $this->goHome();
            } else {
                $this->mensagens('warning', 'Erro ao Enviar Email', 'Desculpe, o email não pode ser enviado. Verique sua conexão ou contate o admin');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
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
