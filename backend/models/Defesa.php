<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_defesa".
 *
 * @property integer $idDefesa
 * @property string $titulo
 * @property string $tipoDefesa
 * @property string $data
 * @property string $conceito
 * @property string $horario
 * @property string $local
 * @property string $resumo
 * @property integer $numDefesa
 * @property string $examinador
 * @property string $emailExaminador
 * @property integer $reservas_id
 * @property integer $banca_id
 * @property integer $aluno_id
 * @property string $previa
 */
class Defesa extends \yii\db\ActiveRecord
{

    public $nome_aluno;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_defesa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resumo', 'banca_id', 'aluno_id'], 'required'],
            [['resumo', 'examinador', 'emailExaminador'], 'string'],
            [['numDefesa', 'reservas_id', 'banca_id', 'aluno_id'], 'integer'],
            [['titulo'], 'string', 'max' => 180],
            [['tipoDefesa'], 'string', 'max' => 2],
            [['data', 'horario'], 'string', 'max' => 10],
            [['conceito'], 'string', 'max' => 9],
            [['local'], 'string', 'max' => 100],
            [['previa'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDefesa' => 'Id Defesa',
            'titulo' => 'Titulo',
            'tipoDefesa' => 'Tipo Defesa',
            'data' => 'Data',
            'conceito' => 'Conceito',
            'horario' => 'Horario',
            'local' => 'Local',
            'resumo' => 'Resumo',
            'numDefesa' => 'Num Defesa',
            'examinador' => 'Examinador',
            'emailExaminador' => 'Email Examinador',
            'reservas_id' => 'Reservas ID',
            'banca_id' => 'Banca ID',
            'aluno_id' => 'Aluno ID',
            'previa' => 'Previa',
        ];
    }
}
