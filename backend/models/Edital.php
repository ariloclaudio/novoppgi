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
            [['numero', 'datainicio', 'datafim', 'documento'], 'required'],
            [['numero'], 'integer'],
            [['datainicio', 'datafim'], 'safe'],
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
            'datainicio' => 'Datainicio',
            'datafim' => 'Datafim',
            'documento' => 'Documento',
        ];
    }
}
