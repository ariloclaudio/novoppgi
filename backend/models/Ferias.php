<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_ferias".
 *
 * @property integer $id
 * @property integer $idusuario
 * @property string $nomeusuario
 * @property string $emailusuario
 * @property integer $tipo
 * @property string $dataSaida
 * @property string $dataRetorno
 * @property string $dataPedido
 */
class Ferias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_ferias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idusuario', 'nomeusuario', 'emailusuario', 'tipo', 'dataSaida', 'dataRetorno'], 'required'],
            [['idusuario', 'tipo'], 'integer'],
            [['dataSaida', 'dataRetorno', 'dataPedido'], 'safe'],
            [['nomeusuario', 'emailusuario'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idusuario' => 'Idusuario',
            'nomeusuario' => 'Nomeusuario',
            'emailusuario' => 'Emailusuario',
            'tipo' => 'Tipo',
            'dataSaida' => 'Data Saida',
            'dataRetorno' => 'Data Retorno',
            'dataPedido' => 'Data Pedido',
        ];
    }
}
