<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_recomendacoes".
 *
 * @property integer $id
 * @property integer $idCandidato
 * @property string $dataEnvio
 * @property string $prazo
 * @property string $nome
 * @property string $email
 * @property string $token
 * @property string $titulacao
 * @property string $cargo
 * @property string $instituicaoTitulacao
 * @property integer $anoTitulacao
 * @property string $instituicaoAtual
 * @property integer $dominio
 * @property integer $aprendizado
 * @property integer $assiduidade
 * @property integer $relacionamento
 * @property integer $iniciativa
 * @property integer $expressao
 * @property integer $ingles
 * @property integer $classificacao
 * @property string $informacoes
 * @property integer $anoContato
 * @property integer $conheceGraduacao
 * @property integer $conhecePos
 * @property integer $conheceEmpresa
 * @property integer $conheceOutros
 * @property string $outrosLugares
 * @property integer $orientador
 * @property integer $professor
 * @property integer $empregador
 * @property integer $coordenador
 * @property integer $colegaCurso
 * @property integer $colegaTrabalho
 * @property integer $outrosContatos
 * @property string $outrasFuncoes
 */
class Recomendacoes extends \yii\db\ActiveRecord
{
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
            [['idCandidato', 'prazo', 'nome', 'email', 'token', 'titulacao', 'cargo', 'instituicaoTitulacao', 'instituicaoAtual', 'dominio', 'aprendizado', 'assiduidade', 'relacionamento', 'iniciativa', 'expressao', 'ingles', 'classificacao', 'informacoes'], 'required'],
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
}
