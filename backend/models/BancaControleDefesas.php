<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_banca_controledefesas".
 *
 * @property integer $id
 * @property integer $status_banca
 * @property string $justificativa
 */
class BancaControleDefesas extends \yii\db\ActiveRecord
{

    public $aluno_nome;
    public $linhaSigla;
    public $cursoAluno;
    public $titulo;
    public $local;
    public $horario;
    public $data;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_banca_controledefesas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_banca'], 'integer'],
            [['justificativa'], 'required'],
            [['justificativa'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_banca' => 'Status Banca',
            'justificativa' => 'Justificativa',
        ];
    }

    public function getNomeAluno(){
        return $this->aluno_nome;
    }

}
