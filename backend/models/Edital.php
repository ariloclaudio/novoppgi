<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_edital".
 *
 * @property string $numero
 * @property string $prazocarta
 * @property string $datainicio
 * @property string $datafim
 * @property string $documento
 */
class Edital extends \yii\db\ActiveRecord
{
    public $documentoFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_edital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'datainicio', 'datafim', 'cartarecomendacao', 'curso', 'cotas', 'documentoFile', 'documento'], 'required'],
            [['numero', 'curso'], 'string'],
            [['cotas'], 'integer', 'min' => 0],
            [['datainicio', 'datafim', 'documentoFile'], 'safe'],
            [['documentoFile'], 'file', 'extensions' => 'pdf'],
            [['documento'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'datainicio' => 'Data Ínicio',
            'datafim' => 'Data Fim',
            'documento' => 'Documento',
            'cartarecomendacao' => 'Carta de Recomendação',
            'curso' => 'Curso',
            'cotas' => 'Cotas',
            'documentoFile' => 'Edital PDF',
        ];
    }
}
