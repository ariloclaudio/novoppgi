<?php

namespace app\models;
use yiibr\brvalidator\CpfValidator;
use Yii;

class User extends \yii\db\ActiveRecord
{
    public $password;
    public $password_repeat;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'visualizacao_candidatos', 'visualizacao_candidatos_finalizados', 'visualizacao_cartas_respondidas'], 'required'],
            [['password_repeat'], 'required', 'when' => function($model){ return $model->password != "";}, 'whenClient' => "function (attribute, value) {
                return $('#user-password').val() != '';}"],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Esta senha não é igual à anterior", 'when' => function($model){ return $model->password != "";}, 'whenClient' => "function (attribute, value) {
                return $('#user-password').val() != '';}"],
            [['status'], 'integer'],
            ['password', 'string', 'min' => 6],
            [['username'], CpfValidator::className(), 'message' => 'CPF Inválido'],
            [['visualizacao_candidatos', 'visualizacao_candidatos_finalizados', 'visualizacao_cartas_respondidas'], 'safe'],
            [['nome', 'username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['created_at', 'updated_at'], 'string', 'max' => 10],
            [['administrador', 'coordenador', 'secretaria', 'professor', 'aluno'], 'string', 'max' => 1],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'username' => 'CPF',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Data de Criação',
            'updated_at' => 'Updated At',
            'visualizacao_candidatos' => 'Visualizacao Candidatos',
            'visualizacao_candidatos_finalizados' => 'Visualizacao Candidatos Finalizados',
            'visualizacao_cartas_respondidas' => 'Visualizacao Cartas Respondidas',
            'administrador' => 'Administrador',
            'coordenador' => 'Coordenador',
            'secretaria' => 'Secretaria',
            'professor' => 'Professor',
            'aluno' => 'Aluno',
            'perfis' => 'Perfil(s)'
        ];
    }

    public function setPassword(){
        if($this->password != ""){
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
    }

    public function getPerfis(){
        $perfis = "";

        if($this->administrador)
            $perfis .= "Administrador / ";
        if($this->secretaria)
            $perfis .= "Secretaria / ";
        if($this->coordenador)
            $perfis .= "Secretaria / ";
        if($this->professor)
            $perfis .= "Professor, / ";
        if($this->aluno)
            $perfis .= "Aluno";

        return $perfis;
    }
}
