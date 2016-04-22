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
            'dataReserva' => 'Data da Reserva',
            'sala' => 'Sala',
            'idSolicitante' => 'Id Solicitante',
            'atividade' => 'Atividade',
            'tipo' => 'Tipo',
            'dataInicio' => 'Data de Início',
            'dataTermino' => 'Data de Término',
            'horaInicio' => 'Hora de Início',
            'horaTermino' => 'Hora de Término',
            'salaDesc.nome' => 'Sala',
        ];
    }

    public function getSalaDesc()
    {
        return $this->hasOne(Sala::className(), ['id' => 'sala']);
    }

    public function beforeSave(){
        $this->dataInicio = date('Y-m-d', strtotime($this->dataInicio));
        $this->dataTermino =  date('Y-m-d', strtotime($this->dataTermino));

        return true;
    }
}
