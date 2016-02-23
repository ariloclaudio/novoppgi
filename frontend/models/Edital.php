<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_edital".
 *
 * @property integer $numero
 * @property string $cartarecomendacao
 * @property string $datainicio
 * @property string $datafim
 * @property string $documento
 *
 * @property J17Candidatos[] $j17Candidatos
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
            [['numero', 'cartarecomendacao', 'datainicio', 'datafim', 'documento'], 'required'],
            [['numero'], 'integer'],
            [['datainicio', 'datafim'], 'safe'],
            [['cartarecomendacao'], 'string', 'max' => 1],
            [['documento'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'cartarecomendacao' => 'Cartarecomendacao',
            'datainicio' => 'Datainicio',
            'datafim' => 'Datafim',
            'documento' => 'Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJ17Candidatos()
    {
        return $this->hasMany(J17Candidatos::className(), ['idEdital' => 'numero']);
    }
}
