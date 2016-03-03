<?php

namespace app\models;

use Yii;

class Recomendacoes extends \yii\db\ActiveRecord
{
    public $conhece;
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
            [['anoTitulacao', 'prazo', 'nome', 'email', 'token', 'titulacao', 'cargo', 'instituicaoTitulacao', 'instituicaoAtual', 'dominio', 'aprendizado', 'assiduidade', 'relacionamento', 'iniciativa', 'expressao', 'ingles', 'classificacao', 'informacoes'], 'required'],
            
            [['idCandidato', 'anoTitulacao', 'dominio', 'aprendizado', 'assiduidade', 'relacionamento', 'iniciativa', 'expressao', 'ingles', 'classificacao', 'anoContato', 'conheceGraduacao', 'conhecePos', 'conheceEmpresa', 'conheceOutros', 'orientador', 'professor', 'empregador', 'coordenador', 'colegaCurso', 'colegaTrabalho', 'outrosContatos'], 'integer'],
            [['dataEnvio', 'prazo'], 'safe'],
            [['informacoes'], 'string'],
            [['nome', 'email', 'instituicaoTitulacao', 'instituicaoAtual'], 'string', 'max' => 100],
            [['token', 'titulacao', 'cargo'], 'string', 'max' => 50],
            [['outrosLugares', 'outrasFuncoes'], 'string', 'max' => 60]
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
}
