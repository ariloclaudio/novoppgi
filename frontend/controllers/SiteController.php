<?php
namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use PHPExcel;
use frontend\models\LoginForm;
use common\models\LinhaPesquisa;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

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
                'only' => ['signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
    
    
    
    
    public function planilhaHeaderCandidato ($objPHPExcel,$arrayColunas){
    
        // Criamos as colunas
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($arrayColunas[0], "Mestrado" )
                ->setCellValue($arrayColunas[1], "Nome" )
                ->setCellValue($arrayColunas[2], "Inscrição" )
                ->setCellValue($arrayColunas[3], "Linha" )
                ->setCellValue($arrayColunas[4], "Nível" )
                ->setCellValue($arrayColunas[5], "Comprovante" )
                ->setCellValue($arrayColunas[6], "Curriculum" )
                ->setCellValue($arrayColunas[7], "Histórico" )
                ->setCellValue($arrayColunas[8], "Proposta" )
                ->setCellValue($arrayColunas[9], "Cartas \n(2 no mínimo)" )
                ->setCellValue($arrayColunas[10], "Homologado" )
                ->setCellValue($arrayColunas[11], "Observações");
                
    }
    

    
    
    
    
    
    
    
    
    public function actionTesteplanilha(){

    $arrayCurso = array(1 => "Mestrado", 2 => "Doutorado");
    $arrayColunas = array(
        0 => "A1", 1 => "A2", 2 => "B2", 3 => "C2", 4 => "D2", 
        5 => "E2", 6 => "F2", 7 => "G2", 8 => "H2", 9 => "I2", 
        10 => "J2", 11 => "K2");

    $linhasPesquisas = ArrayHelper::map(LinhaPesquisa::find()->orderBy('nome')->all(), 'id', 'nome');

    $objPHPExcel = new \PHPExcel();

    for ($i=3; $i<999; $i++){
        $objPHPExcel->getActiveSheet()->getRowDimension(''.$i.'')->setRowHeight(40);
    }

    
    $model_candidato_mestrado = Candidato::find()->where("cursodesejado = 1")->all();
    $model_candidato_doutorado = Candidato::find()->where("cursodesejado = 2")->all();
    
    
    // Definimos o estilo da fonte

        $objPHPExcel->getActiveSheet()->getStyle( "A1:K999" )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle( "A1:K999" )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle( "B3:K999" )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle( "B3:K999" )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle( "A" )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:K999')
            ->getAlignment()
            ->setWrapText(true);

    $objPHPExcel->getActiveSheet()->getStyle("C3:C999")->getFont()->setSize(9);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
    $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
    
    $this->planilhaHeaderCandidato($objPHPExcel,$arrayColunas);

    // Podemos configurar diferentes larguras paras as colunas como padrão
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

    $objPHPExcel->getActiveSheet()->getRowDimension("1")->setRowHeight(50);
    $objPHPExcel->getActiveSheet()->getRowDimension("2")->setRowHeight(40);


    for($i=0; $i<count($model_candidato_mestrado); $i++){
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+3, $model_candidato_mestrado[$i]->nome);
        
        /*
        $objPHPExcel->getActiveSheet()
            ->setCellValueByColumnAndRow(1, $i+3, ($model_candidato_mestrado[$i]->idEdital.'-'.str_pad($model_candidato_mestrado[$i]->posicaoEdital, 3, "0", STR_PAD_LEFT)));
        */
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+3, $linhasPesquisas[$model_candidato_mestrado[$i]->idLinhaPesquisa]);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i+3, $arrayCurso[$model_candidato_mestrado[$i]->cursodesejado]);   


    }



    //parte referente ao doutorado

        $j = $i;

    $objPHPExcel->getActiveSheet()->getRowDimension($j+1)->setRowHeight(50);
    $objPHPExcel->getActiveSheet()->getRowDimension($j+2)->setRowHeight(40);

        $k = $j+4;
        $l = $j+3;



        $objPHPExcel->getActiveSheet()->mergeCells('A'.$l.':K'.$l.'');

        $arrayColunas = array(
            0 => "A".$l, 1 => "A".$k, 2 => "B".$k, 3 => "C".$k, 4 => "D".$k, 
            5 => "E".$k, 6 => "F".$k, 7 => "G".$k, 8 => "H".$k, 9 => "I".$k, 
            10 => "J".$k, 11 => "K".$k);
            
        $this->planilhaHeaderCandidato($objPHPExcel,$arrayColunas);


    for($i=0; $i<count($model_candidato_doutorado); $i++){
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $j+5, $model_candidato_doutorado[$i]->nome);
        
        /*$objPHPExcel->getActiveSheet()
            ->setCellValueByColumnAndRow(1, $j+5, ($model_candidato_doutorado[$i]->idEdital.'-'.str_pad($model_candidato_doutorado[$i]->posicaoEdital, 3, "0", STR_PAD_LEFT)));
        */
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $j+5, $linhasPesquisas[$model_candidato_doutorado[$i]->idLinhaPesquisa]);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $j+5, $arrayCurso[$model_candidato_doutorado[$i]->cursodesejado]);   


        $j++;
    }

    //fim da parte referente ao doutorado


    
    // Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
    /*
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Fulano");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, " da Silva");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "fulano@exemplo.com.br");
    
    // Exemplo inserindo uma segunda linha, note a diferença no segundo parâmetro
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Beltrano");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, " da Silva Sauro");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "beltrando@exemplo.com.br");
    */
    
    // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
    $objPHPExcel->getActiveSheet()->setTitle('Candidato');
    
    // Acessamos o 'Writer' para poder salvar o arquivo
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    
    // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
    $objWriter->save("arquivo.xls");
    
    echo "ok";
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public function actionCadastroppgi(){
        /*if(Yii::$app->session->get('candidato') !== null)
        $this->redirect(['candidato/passo1']);*/
    
        $this->layout = '@app/views/layouts/main-login.php';
        
        $model = new Candidato();  

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
                $this->mensagens('warning', 'Erro ao Enviar Email', 'Desculpe, o email não pode ser enviado. Verique sua conexão ou contate o administrador');
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
