<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_funcionarios".
 *
 * @property integer $id
 * @property string $nome
 * @property string $cpf
 * @property string $email
 * @property string $endereco
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $tel_residencial
 * @property string $tel_celular
 * @property string $data_ingresso
 * @property integer $siape
 * @property string $cargo
 * @property integer $idUser
 */
class Funcionario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_funcionarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'cpf', 'email', 'endereco', 'bairro', 'cidade', 'uf', 'cep', 'tel_residencial', 'tel_celular', 'data_ingresso', 'cargo', 'idUser'], 'required'],
            [['data_ingresso'], 'safe'],
            [['siape', 'idUser'], 'integer'],
            [['nome'], 'string', 'max' => 80],
            [['cpf', 'tel_residencial', 'tel_celular'], 'string', 'max' => 15],
            [['email', 'endereco'], 'string', 'max' => 100],
            [['bairro', 'cidade', 'cargo'], 'string', 'max' => 30],
            [['uf'], 'string', 'max' => 2],
            [['cep'], 'string', 'max' => 9],
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
            'cpf' => 'Cpf',
            'email' => 'Email',
            'endereco' => 'Endereco',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Uf',
            'cep' => 'Cep',
            'tel_residencial' => 'Tel Residencial',
            'tel_celular' => 'Tel Celular',
            'data_ingresso' => 'Data Ingresso',
            'siape' => 'Siape',
            'cargo' => 'Cargo',
            'idUser' => 'Id User',
        ];
    }
}
