<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_reservas_salas".
 *
 * @property integer $id
 * @property string $nome
 * @property integer $numero
 * @property string $localizacao
 *
 * @property J17Reservas[] $j17Reservas
 */
class Sala extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_reservas_salas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'localizacao'], 'required'],
            [['numero'], 'integer'],
            [['nome'], 'string', 'max' => 30],
            [['localizacao'], 'string', 'max' => 50],
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
            'numero' => 'Numero',
            'localizacao' => 'Localizacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJ17Reservas()
    {
        return $this->hasMany(J17Reservas::className(), ['sala' => 'id']);
    }

    public function getReservasAtivas(){
        return ReservaSala::find()->where(['idSolicitante' => Yii::$app->user->identity->id])->andWhere(['sala' => $this->id])
        ->andWhere('dataInicio >= \''.date('Y-m-d').'\'')
        ->count();
    }
}
