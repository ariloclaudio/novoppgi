<?php

namespace app\models;

use Yii;

class Recomendacoes extends \yii\db\ActiveRecord
{
    public $conhece;
    public $funcoesCartaArray;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_recomendacoes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
            return [
            [['anoTitulacao', 'prazo', 'nome', 'email', 'token', 'titulacao', 'cargo', 'instituicaoTitulacao', 'instituicaoAtual', 'dominio', 'aprendizado', 'assiduidade', 'relacionamento', 'iniciativa', 'expressao', 'ingles', 'classificacao', 'informacoes', 'funcoesCartaArray', 'conhece'], 'required',
            'when' => function($model){ return $model->passo == 2;},],
            [['anoTitulacao', 'dominio', 'aprendizado', 'assiduidade', 'relacionamento', 'iniciativa', 'expressao', 'ingles', 'classificacao', 'anoContato'], 'integer'],
            [['dataEnvio', 'prazo'], 'safe'],
            [['informacoes'], 'string'],
            [['nome', 'email', 'instituicaoTitulacao', 'instituicaoAtual'], 'string', 'max' => 100],
            [['token', 'titulacao', 'cargo'], 'string', 'max' => 50],
            [['outrosLugares', 'outrasFuncoes'], 'string', 'max' => 60],
            [['conheceGraduacao', 'conhecePos', 'conheceEmpresa', 'conheceOutros', 'orientador', 'professor', 'empregador', 'colegaCurso', 'coordenador', 'colegaTrabalho'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idCandidato' => 'Id Candidato',
            'dataEnvio' => 'Data Envio',
            'prazo' => 'Prazo',
            'nome' => 'Nome',
            'email' => 'Email',
            'token' => 'Token',
            'titulacao' => 'Titulacao',
            'cargo' => 'Cargo',
            'instituicaoTitulacao' => 'Instituicao Titulacao',
            'anoTitulacao' => 'Ano Titulacao',
            'instituicaoAtual' => 'Instituicao Atual',
            'dominio' => 'Dominio',
            'aprendizado' => 'Aprendizado',
            'assiduidade' => 'Assiduidade',
            'relacionamento' => 'Relacionamento',
            'iniciativa' => 'Iniciativa',
            'expressao' => 'Expressao',
            'ingles' => 'Ingles',
            'classificacao' => 'Classificacao',
            'informacoes' => 'Informacoes',
            'anoContato' => 'Ano Contato',
            'conheceGraduacao' => 'Conhece Graduacao',
            'conhecePos' => 'Conhece Pos',
            'conheceEmpresa' => 'Conhece Empresa',
            'conheceOutros' => 'Conhece Outros',
            'outrosLugares' => 'Outros Lugares',
            'orientador' => 'Orientador',
            'professor' => 'Professor',
            'empregador' => 'Empregador',
            'coordenador' => 'Coordenador',
            'colegaCurso' => 'Colega Curso',
            'colegaTrabalho' => 'Colega Trabalho',
            'outrosContatos' => 'Outros Contatos',
            'outrasFuncoes' => 'Outras Funcoes',
        ];
    }

    public function getCandidato(){
        return $this->hasOne(Candidato::className(), ['id' => 'idCandidato']);
    }

    public function afterFind(){
        $this->conhece = array();
        $this->funcoesCartaArray = array();

        if($this->conheceGraduacao == '1')
            array_push($this->conhece, '1');

        if($this->conhecePos == '1')
            array_push($this->conhece, '2');

        if($this->conheceEmpresa == '1')
            array_push($this->conhece, '3');

        if($this->conheceOutros == '1')
            array_push($this->conhece, '4');

        if($this->orientador == '1')
            array_push($this->funcoesCartaArray, '1');
        if($this->professor == '1')
            array_push($this->funcoesCartaArray, '2');
        if($this->empregador == '1')
            array_push($this->funcoesCartaArray, '3');
        if($this->coordenador == '1')
            array_push($this->funcoesCartaArray, '4');
        if($this->colegaCurso == '1')
            array_push($this->funcoesCartaArray, '5');
        if($this->colegaTrabalho == '1')
            array_push($this->funcoesCartaArray, '6');
        if($this->outrosContatos == '1')
            array_push($this->funcoesCartaArray, '7');
    }

    public function setCheckbox(){
        if(in_array('1', $this->conhece))
            $this->conheceGraduacao = '1';
        else
            $this->conheceGraduacao = '0';
        if(in_array('2', $this->conhece))
            $this->conhecePos = '1';
        else
            $this->conhecePos = '0';
        if(in_array('3', $this->conhece))
            $this->conheceEmpresa = '1';
        else
            $this->conheceEmpresa = '0';
        if(in_array('4', $this->conhece))
            $this->conheceOutros = '1';
        else
            $this->conheceOutros = '0';

        if(in_array('1', $this->funcoesCartaArray))
            $this->orientador = '1';
        else
            $this->orientador = '0';

        if(in_array('2', $this->funcoesCartaArray))
            $this->professor = '1';
        else
            $this->professor = '0';
        if(in_array('3', $this->funcoesCartaArray))
            $this->empregador = '1';
        else
            $this->empregador = '0';
        if(in_array('4', $this->funcoesCartaArray))
            $this->coordenador = '1';
        else
            $this->coordenador = '0';
        if(in_array('5', $this->funcoesCartaArray))
            $this->colegaCurso = '1';
        else
            $this->colegaCurso = '0';
        if(in_array('6', $this->funcoesCartaArray))
            $this->colegaTrabalho = '1';
        else
            $this->colegaTrabalho = '0';
        if(in_array('7', $this->funcoesCartaArray))
            $this->outrosContatos = '1';
        else
            $this->outrosContatos = '0';
    }

    /*Retorna erro da relacionado a status da carta
        0 - Sem Erros
        1 - Carta Já Enviada
        2 - Carta Fora do Prazo
    */
    public function erroCartaRecomendacao(){
        if($this->dataEnvio == '0000-00-00 00:00:00')
            if($this->prazo >= date('Y-m-d'))
                return 0;
            else
                return 2;
        
        return 1;
    }

    public function setDataEnvio(){
        $this->dataEnvio = date('Y-m-d H:i:s');
    }
    public function setDataResposta(){
        $this->dataResposta = date('Y-m-d H:i:s');
    }

}
