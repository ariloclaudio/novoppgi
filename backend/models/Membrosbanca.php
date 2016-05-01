<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_membrosbanca".
 *
 * @property integer $id
 * @property string $nome
 * @property string $email
 * @property string $filiacao
 * @property string $telefone
 * @property string $cpf
 * @property string $dataCadastro
 * @property integer $idProfessor
 */
class Membrosbanca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_membrosbanca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'filiacao', 'telefone', 'cpf'], 'required'],
            [['dataCadastro'], 'safe'],
            [['idProfessor'], 'integer'],
            [['nome', 'email', 'filiacao'], 'string', 'max' => 100],
            [['telefone'], 'string', 'max' => 20],
            [['cpf'], 'string', 'max' => 15],
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
            'email' => 'Email',
            'filiacao' => 'Filiacao',
            'telefone' => 'Telefone',
            'cpf' => 'Cpf',
            'dataCadastro' => 'Data Cadastro',
            'idProfessor' => 'Id Professor',
        ];
    }
}
