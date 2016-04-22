<?php

namespace app\models;

use Yii;

class ReservaSala extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_reservas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dataReserva', 'dataInicio', 'dataTermino', 'horaInicio', 'horaTermino'], 'safe'],
            [['sala', 'idSolicitante', 'atividade', 'dataInicio', 'dataTermino', 'horaInicio', 'horaTermino', 'tipo'], 'required'],
            [['sala', 'idSolicitante'], 'integer'],
            [['atividade'], 'string', 'max' => 50],
            [['tipo'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dataReserva' => 'Data Reserva',
            'sala' => 'Sala',
            'idSolicitante' => 'Id Solicitante',
            'atividade' => 'Atividade',
            'tipo' => 'Tipo',
            'dataInicio' => 'Data Início',
            'dataTermino' => 'Data Término',
            'horaInicio' => 'Hora Início',
            'horaTermino' => 'Hora Término',
        ];
    }
}
