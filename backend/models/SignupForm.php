<?php
namespace backend\models;
use yiibr\brvalidator\CpfValidator;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $nome;

    public $perfil;
    public $perfilAtual;
    public $administrador;
    public $coordenador;
    public $secretaria;
    public $professor;
    public $aluno;

    public $visualizacao_candidatos;
    public $visualizacao_candidatos_finalizados;
    public $visualizacao_cartas_respondidas;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['perfil', 'required'],
            ['username', 'required'],
            ['nome', 'required'],
            ['nome', 'string'],
            
            ['perfil', 'safe'],
            ['administrador', 'string'],
            ['coordenador', 'string'],
            ['secretaria', 'string'],
            ['professor', 'string'],
            ['aluno', 'string'],

            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Já existe usuário cadastrado com esse CPF'],
            [['username'], CpfValidator::className(), 'message' => 'CPF Inválido'],
            ['username', 'string'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['nome', 'string', 'max' => 255],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email já em uso.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Esta senha não é igual à anterior" ],

        ];
    }

public function attributeLabels()
    {

        return [
            'username' => 'CPF (Digite somente números)',
            'password' => 'Senha',
            'password_repeat' => 'Senha novamente',
            'email' => 'E-mail',
         ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->nome = $this->nome;
            $user->setPassword($this->password);

            foreach ($this->perfil as $value) {
                switch ($value) {
                    case '1':
                        $user->administrador = '1';            
                        break;
                    case '2':
                        $user->coordenador = '1';            
                        break;
                    case '3':
                        $user->secretaria = '1';
                        break;
                    case '4':
                        $user->professor = '1';            
                        break;
                    case '5':
                        $user->aluno = '1';            
                        break;
                }
            }
            
            $user->generateAuthKey();
            $user->visualizacao_candidatos =  date("Y-m-d H:i:s");
            $user->visualizacao_candidatos_finalizados =  date("Y-m-d H:i:s");
            $user->visualizacao_cartas_respondidas =  date("Y-m-d H:i:s");

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }


    protected function findModel($id)
    {
        if (($model = SignupForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}