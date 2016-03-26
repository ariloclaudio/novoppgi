<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord
{
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
            [['status'], 'integer'],
            [['visualizacao_candidatos', 'visualizacao_candidatos_finalizados', 'visualizacao_cartas_respondidas'], 'safe'],
            [['nome', 'username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['created_at', 'updated_at'], 'string', 'max' => 10],
            [['administrador', 'coordenador', 'secretaria', 'professor', 'aluno'], 'string', 'max' => 1],
            [['username'], 'unique'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'visualizacao_candidatos' => 'Visualizacao Candidatos',
            'visualizacao_candidatos_finalizados' => 'Visualizacao Candidatos Finalizados',
            'visualizacao_cartas_respondidas' => 'Visualizacao Cartas Respondidas',
            'administrador' => 'Administrador',
            'coordenador' => 'Coordenador',
            'secretaria' => 'Secretaria',
            'professor' => 'Professor',
            'aluno' => 'Aluno',
        ];
    }
}
