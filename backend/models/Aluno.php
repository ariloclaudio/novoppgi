<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_aluno".
 *
 * @property integer $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $matricula
 * @property integer $area
 * @property integer $curso
 * @property string $endereco
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $datanascimento
 * @property string $sexo
 * @property integer $nacionalidade
 * @property string $estadocivil
 * @property string $cpf
 * @property string $rg
 * @property string $orgaoexpeditor
 * @property string $dataexpedicao
 * @property string $telresidencial
 * @property string $telcomercial
 * @property string $telcelular
 * @property string $nomepai
 * @property string $nomemae
 * @property integer $regime
 * @property string $bolsista
 * @property string $agencia
 * @property string $pais
 * @property integer $status
 * @property string $anoingresso
 * @property string $idiomaExameProf
 * @property string $conceitoExameProf
 * @property string $dataExameProf
 * @property string $tituloQual2
 * @property string $dataQual2
 * @property string $conceitoQual2
 * @property string $tituloTese
 * @property string $dataTese
 * @property string $conceitoTese
 * @property string $horarioQual2
 * @property string $localQual2
 * @property string $resumoQual2
 * @property string $horarioTese
 * @property string $localTese
 * @property string $resumoTese
 * @property string $tituloQual1
 * @property integer $numDefesa
 * @property string $dataQual1
 * @property string $examinadorQual1
 * @property string $conceitoQual1
 * @property string $cursograd
 * @property string $instituicaograd
 * @property string $crgrad
 * @property integer $egressograd
 * @property string $dataformaturagrad
 * @property integer $idUser
 * @property integer $orientador
 * @property string $anoconclusao
 * @property string $sede
 */
class Aluno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_aluno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'senha', 'matricula', 'area', 'curso', 'estadocivil', 'cpf', 'rg', 'orgaoexpeditor', 'agencia', 'pais', 'resumoQual2', 'resumoTese', 'idUser', 'orientador', 'anoconclusao'], 'required'],
            [['area', 'curso', 'nacionalidade', 'regime', 'status', 'numDefesa', 'egressograd', 'idUser', 'orientador'], 'integer'],
            [['resumoQual2', 'resumoTese'], 'string'],
            [['anoconclusao'], 'safe'],
            [['nome', 'email', 'nomepai', 'nomemae', 'examinadorQual1'], 'string', 'max' => 60],
            [['senha', 'cidade'], 'string', 'max' => 40],
            [['matricula', 'estadocivil'], 'string', 'max' => 15],
            [['endereco'], 'string', 'max' => 160],
            [['bairro'], 'string', 'max' => 50],
            [['uf'], 'string', 'max' => 5],
            [['cep', 'conceitoExameProf', 'conceitoQual2', 'conceitoTese', 'conceitoQual1'], 'string', 'max' => 9],
            [['datanascimento', 'rg', 'orgaoexpeditor', 'dataexpedicao', 'dataExameProf', 'dataQual2', 'dataTese', 'horarioQual2', 'horarioTese', 'dataQual1', 'crgrad', 'dataformaturagrad'], 'string', 'max' => 10],
            [['sexo'], 'string', 'max' => 1],
            [['cpf'], 'string', 'max' => 14],
            [['telresidencial', 'telcomercial', 'telcelular'], 'string', 'max' => 18],
            [['bolsista'], 'string', 'max' => 3],
            [['agencia', 'pais'], 'string', 'max' => 30],
            [['anoingresso'], 'string', 'max' => 11],
            [['idiomaExameProf'], 'string', 'max' => 20],
            [['tituloQual2', 'tituloTese', 'tituloQual1'], 'string', 'max' => 180],
            [['localQual2', 'localTese', 'cursograd', 'instituicaograd'], 'string', 'max' => 100],
            [['sede'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
            'senha' => 'Senha',
            'matricula' => 'Matricula',
            'area' => 'Area',
            'curso' => 'Curso',
            'endereco' => 'Endereco',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Uf',
            'cep' => 'Cep',
            'datanascimento' => 'Datanascimento',
            'sexo' => 'Sexo',
            'nacionalidade' => 'Nacionalidade',
            'estadocivil' => 'Estadocivil',
            'cpf' => 'Cpf',
            'rg' => 'Rg',
            'orgaoexpeditor' => 'Orgaoexpeditor',
            'dataexpedicao' => 'Dataexpedicao',
            'telresidencial' => 'Telresidencial',
            'telcomercial' => 'Telcomercial',
            'telcelular' => 'Telcelular',
            'nomepai' => 'Nomepai',
            'nomemae' => 'Nomemae',
            'regime' => 'Regime',
            'bolsista' => 'Bolsista',
            'agencia' => 'Agencia',
            'pais' => 'Pais',
            'status' => 'Status',
            'anoingresso' => 'Anoingresso',
            'idiomaExameProf' => 'Idioma Exame Prof',
            'conceitoExameProf' => 'Conceito Exame Prof',
            'dataExameProf' => 'Data Exame Prof',
            'tituloQual2' => 'Titulo Qual2',
            'dataQual2' => 'Data Qual2',
            'conceitoQual2' => 'Conceito Qual2',
            'tituloTese' => 'Titulo Tese',
            'dataTese' => 'Data Tese',
            'conceitoTese' => 'Conceito Tese',
            'horarioQual2' => 'Horario Qual2',
            'localQual2' => 'Local Qual2',
            'resumoQual2' => 'Resumo Qual2',
            'horarioTese' => 'Horario Tese',
            'localTese' => 'Local Tese',
            'resumoTese' => 'Resumo Tese',
            'tituloQual1' => 'Titulo Qual1',
            'numDefesa' => 'Num Defesa',
            'dataQual1' => 'Data Qual1',
            'examinadorQual1' => 'Examinador Qual1',
            'conceitoQual1' => 'Conceito Qual1',
            'cursograd' => 'Cursograd',
            'instituicaograd' => 'Instituicaograd',
            'crgrad' => 'Crgrad',
            'egressograd' => 'Egressograd',
            'dataformaturagrad' => 'Dataformaturagrad',
            'idUser' => 'Id User',
            'orientador' => 'Orientador',
            'anoconclusao' => 'Anoconclusao',
            'sede' => 'Sede',
        ];
    }
}
