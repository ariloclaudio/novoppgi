<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
    public $mestrado;
    public $doutorado;
    

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
            [['numero', 'datainicio', 'datafim', 'cartarecomendacao'], 'required'],
            [['documentoFile'], 'required', 'when' => function($model){ return !isset($model->documento);}],
            [['vagas_mestrado'], 'required', 'when' => function($model){ return $model->curso == 1 || $model->curso == 3; },'whenClient' => "function (attribute, value) {
                return $('input:radio[name=\"Edital[curso]\"]:checked').val() == 1;
            }"],
            [['vagas_doutorado'], 'required','when' => function($model){ return $model->curso == 2 || $model->curso == 3; },'whenClient' => "function (attribute, value) {
                return $('input:radio[name=\"Edital[curso]\"]:checked').val() == 2;
            }"],
            [['numero', 'curso'], 'string'],
            [['numero'], 'unique', 'message' => 'Edital já criado'],
            [['vagas_mestrado','vagas_doutorado', 'cotas_mestrado', 'cotas_doutorado'], 'integer', 'min' => 0],
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
            'documentoFile' => 'Edital PDF',
        ];
    }

    public function beforeSave(){
        if($this->mestrado == 1 && $this->doutorado == 1)
            $this->curso = 3;
        else if($this->mestrado == 1)
            $this->curso = 1;
        else if($this->doutorado == 1)
            $this->curso = 2;

        return true;
    }

    /*Relacionamento*/
    public function getCandidato()
    {
        return $this->hasMany(Candidato::className(), ['idEdital' => 'numero']);
    }
    //fim do relacionamento



    public function uploadDocumento($documentoFile)
    {
        if (isset($documentoFile)) {
            $this->documento = "edital-".date('dmYHisu') . '.' . $documentoFile->extension;
            $documentoFile->saveAs('editais/' . $this->documento);
            return true;
        } else {
            return false;
        }
    }



    public function getQuantidadeInscritos($id)
    {

        $results = Candidato::find()->where("idEdital = '".$this->numero."'")->count(); 

        return $results;
    }

        public function getVagasMestrado()
    {

        return 'AC: '.$this->vagas_mestrado.' / Cota: '.$this->cotas_mestrado;
 
   }

        public function getVagasDoutorado()
    {

        return 'AC: '.$this->vagas_doutorado.' / Cota: '.$this->cotas_doutorado;
 
   }

}
