<?php

namespace common\models;

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



}
