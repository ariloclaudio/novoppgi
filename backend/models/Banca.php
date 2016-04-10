<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_banca".
 *
 * @property integer $id
 * @property integer $idAluno
 * @property integer $idMembro
 * @property string $nomeMembro
 * @property string $instituicaoMembro
 * @property string $funcao
 * @property string $tipoDefesa
 */
class Banca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_banca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idAluno', 'nomeMembro', 'instituicaoMembro', 'tipoDefesa'], 'required'],
            [['idAluno', 'idMembro'], 'integer'],
            [['nomeMembro', 'instituicaoMembro'], 'string', 'max' => 60],
            [['funcao', 'tipoDefesa'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idAluno' => 'Id Aluno',
            'idMembro' => 'Id Membro',
            'nomeMembro' => 'Nome Membro',
            'instituicaoMembro' => 'Instituicao Membro',
            'funcao' => 'Funcao',
            'tipoDefesa' => 'Tipo Defesa',
        ];
    }
}
