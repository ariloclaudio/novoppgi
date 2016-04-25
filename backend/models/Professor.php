<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_professores".
 *
 * @property integer $id
 * @property integer $idLinhaPesquisa
 * @property string $nomeProfessor
 * @property string $SIAPE
 * @property string $CPF
 * @property string $endereco
 * @property string $email
 * @property string $dataIngresso
 * @property integer $idUser
 * @property integer $icomp
 * @property integer $ppgi
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $telresidencial
 * @property string $telcelular
 * @property string $cep
 * @property string $unidade
 * @property string $titulacao
 * @property string $classe
 * @property string $nivel
 * @property string $regime
 * @property string $turno
 * @property string $idLattes
 * @property string $formacao
 * @property string $resumo
 * @property string $alias
 * @property string $ultimaAtualizacao
 * @property integer $idRH
 */
class Professor extends \yii\db\ActiveRecord
{

    public $idUsuarioProfessor;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_professores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idLinhaPesquisa', 'nomeProfessor', 'SIAPE', 'CPF', 'endereco', 'email', 'dataIngresso', 'idUser', 'bairro', 'cidade', 'uf', 'telresidencial', 'telcelular', 'cep', 'unidade', 'titulacao', 'classe', 'nivel', 'regime', 'turno', 'idLattes', 'formacao', 'resumo', 'alias', 'ultimaAtualizacao', 'idRH'], 'required'],
            [['idLinhaPesquisa', 'idUser', 'icomp', 'ppgi', 'idLattes', 'idRH'], 'integer'],
            [['resumo'], 'string'],
            [['nomeProfessor', 'email', 'bairro', 'cidade'], 'string', 'max' => 80],
            [['SIAPE', 'dataIngresso', 'regime'], 'string', 'max' => 10],
            [['CPF', 'cep'], 'string', 'max' => 14],
            [['endereco'], 'string', 'max' => 100],
            [['uf'], 'string', 'max' => 2],
            [['telresidencial', 'telcelular', 'classe', 'alias'], 'string', 'max' => 20],
            [['unidade'], 'string', 'max' => 60],
            [['titulacao'], 'string', 'max' => 15],
            [['nivel'], 'string', 'max' => 5],
            [['turno'], 'string', 'max' => 30],
            [['formacao'], 'string', 'max' => 300],
            [['ultimaAtualizacao'], 'string', 'max' => 19],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idLinhaPesquisa' => 'Id Linha Pesquisa',
            'nomeProfessor' => 'Nome Professor',
            'SIAPE' => 'Siape',
            'CPF' => 'Cpf',
            'endereco' => 'Endereco',
            'email' => 'Email',
            'dataIngresso' => 'Data Ingresso',
            'idUser' => 'Id User',
            'icomp' => 'Icomp',
            'ppgi' => 'Ppgi',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Uf',
            'telresidencial' => 'Telresidencial',
            'telcelular' => 'Telcelular',
            'cep' => 'Cep',
            'unidade' => 'Unidade',
            'titulacao' => 'Titulacao',
            'classe' => 'Classe',
            'nivel' => 'Nivel',
            'regime' => 'Regime',
            'turno' => 'Turno',
            'idLattes' => 'Id Lattes',
            'formacao' => 'Formacao',
            'resumo' => 'Resumo',
            'alias' => 'Alias',
            'ultimaAtualizacao' => 'Ultima Atualizacao',
            'idRH' => 'Id Rh',
        ];
    }

}
