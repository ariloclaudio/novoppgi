<?php

namespace app\models;

use Yii;


class Defesa extends \yii\db\ActiveRecord
{

    public $nome_aluno;
    public $curso_aluno;
    public $membrosBancaInternos = [];
    public $membrosBancaExternos = [];
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
            [['membrosBancaExternos', 'membrosBancaInternos'], 'safe'],
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

    public function getModelAluno(){

        return Aluno::find()->where("id =".$this->aluno_id)->one();

    }

    public function getNome(){

        $aluno = $this->getModelAluno();

        return $aluno->nome;
    }


    public function getCurso(){

        $aluno = $this->getModelAluno();

        return $aluno->curso == 1 ? "Mestrado" : "Doutorado" ;
    }

    public function getTipoDefesa(){

        if ($this->tipoDefesa == "Q1"){
            $defesa = "Qualificação 1";
        }
        else if ($this->tipoDefesa == "Q2"){
            $defesa = "Qualificação 2";
        }
        else if ($this->tipoDefesa == "T"){
            $defesa = "Tese";
        }
        else if ($this->tipoDefesa == "D"){
            $defesa = "Dissertação";
        }

        return $defesa;
    }

    public function salvaMembrosBanca(){
        $this->beforeDelete();

        $this->membrosBancaExternos = $this->membrosBancaExternos == "" ? array() : $this->membrosBancaExternos;
        $this->membrosBancaInternos = $this->membrosBancaInternos == "" ? array() : $this->membrosBancaInternos;
        
        for ($i = 0; $i < count($this->membrosBancaExternos); $i++) {
            $sql = "INSERT INTO j17_banca_has_membrosbanca (banca_id, membrosbanca_id, funcao) VALUES ('$this->banca_id', '".$this->membrosBancaExternos[$i]."', 'E');";
            Yii::$app->db->createCommand($sql)->execute();
        }

        for ($i = 0; $i < count($this->membrosBancaInternos); $i++) {
            $sql = "INSERT INTO j17_banca_has_membrosbanca (banca_id, membrosbanca_id, funcao) VALUES ('$this->banca_id', '".$this->membrosBancaInternos[$i]."', 'I');";
            Yii::$app->db->createCommand($sql)->execute();
        }

        return true;
    }

    public function beforeDelete(){
        try{
            $sql = "DELETE FROM j17_banca_has_membrosbanca WHERE banca_id = '$this->banca_id'";
            Yii::$app->db->createCommand($sql)->execute();
        } catch (ErrorException $e){
             return false;
        }
        
        return true;
    }

    public function getConceitoDefesa(){

        return $this->conceito == null ? "<div style = \"color:red \"><b>Não Julgado</b></div>" : $this->conceito;
    }
}
