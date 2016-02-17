<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "j17_candidatos".
 *
 * @property string $id
 * @property string $senha
 * @property string $inicio
 * @property string $fim
 * @property integer $passoatual
 * @property string $nome
 * @property string $endereco
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $email
 * @property string $datanascimento
 * @property integer $nacionalidade
 * @property string $pais
 * @property string $estadocivil
 * @property string $rg
 * @property string $orgaoexpedidor
 * @property string $dataexpedicao
 * @property string $passaporte
 * @property string $cpf
 * @property string $sexo
 * @property string $telresidencial
 * @property string $telcomercial
 * @property string $telcelular
 * @property string $nomepai
 * @property string $nomemae
 * @property integer $cursodesejado
 * @property integer $regime
 * @property string $inscricaoposcomp
 * @property integer $anoposcomp
 * @property string $notaposcomp
 * @property string $solicitabolsa
 * @property string $vinculoemprego
 * @property string $empregador
 * @property string $cargo
 * @property string $vinculoconvenio
 * @property string $convenio
 * @property string $linhapesquisa
 * @property string $tituloproposta
 * @property string $diploma
 * @property string $historico
 * @property string $motivos
 * @property string $proposta
 * @property string $curriculum
 * @property string $cartaempregador
 * @property string $comprovantepagamento
 * @property string $cursograd
 * @property string $instituicaograd
 * @property string $crgrad
 * @property integer $egressograd
 * @property string $dataformaturagrad
 * @property string $cursoesp
 * @property string $instituicaoesp
 * @property integer $egressoesp
 * @property string $dataformaturaesp
 * @property string $cursopos
 * @property string $instituicaopos
 * @property integer $tipopos
 * @property string $mediapos
 * @property integer $egressopos
 * @property string $dataformaturapos
 * @property integer $periodicosinternacionais
 * @property integer $periodicosnacionais
 * @property integer $conferenciasinternacionais
 * @property integer $conferenciasnacionais
 * @property string $instituicaoingles
 * @property integer $duracaoingles
 * @property string $nomeexame
 * @property string $dataexame
 * @property string $notaexame
 * @property string $empresa1
 * @property string $empresa2
 * @property string $empresa3
 * @property string $cargo1
 * @property string $cargo2
 * @property string $cargo3
 * @property string $periodoprofissional1
 * @property string $periodoprofissional2
 * @property string $periodoprofissional3
 * @property string $instituicaoacademica1
 * @property string $instituicaoacademica2
 * @property string $instituicaoacademica3
 * @property string $atividade1
 * @property string $atividade2
 * @property string $atividade3
 * @property string $periodoacademico1
 * @property string $periodoacademico2
 * @property string $periodoacademico3
 * @property integer $resultado
 * @property string $periodo
 */
class Candidato extends \yii\db\ActiveRecord
{
    public $historicoFile;
    public $curriculumFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'j17_candidatos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['senha', 'periodo', 'cursograd', 'egressograd', 'instituicaograd', 'crgrad'], 'required'],
            [['crgrad'], 'number', 'min' => 1, 'max' => 10],
            [['historicoFile', 'curriculumFile'], 'safe'],
            [['historicoFile', 'curriculumFile'], 'file', 'extensions' => 'pdf'],
            [['inicio', 'fim'], 'safe'],
            [['passoatual', 'nacionalidade', 'cursodesejado', 'regime', 'anoposcomp', 'linhapesquisa', 'egressograd', 'egressoesp', 'tipopos', 'egressopos', 'periodicosinternacionais', 'periodicosnacionais', 'conferenciasinternacionais', 'conferenciasnacionais', 'duracaoingles', 'resultado'], 'integer', 'min' => 0],
            [['diploma', 'historico', 'motivos', 'proposta', 'curriculum', 'cartaempregador', 'comprovantepagamento'], 'string'],
            [['senha', 'cidade'], 'string', 'max' => 40],
            [['nome', 'nomepai', 'nomemae'], 'string', 'max' => 60],
            [['endereco'], 'string', 'max' => 160],
            [['bairro', 'email', 'empregador', 'cargo', 'convenio', 'cursograd', 'instituicaograd', 'instituicaoesp', 'cursopos', 'instituicaopos', 'instituicaoingles', 'nomeexame', 'empresa1', 'empresa2', 'empresa3', 'cargo1', 'cargo2', 'cargo3', 'instituicaoacademica1', 'instituicaoacademica2', 'instituicaoacademica3', 'atividade1', 'atividade2', 'atividade3'], 'string', 'max' => 50],
            [['uf'], 'string', 'max' => 2],
            [['cep'], 'string', 'max' => 9],
            [['datanascimento', 'rg', 'orgaoexpedidor', 'dataexpedicao', 'crgrad', 'dataformaturagrad', 'dataformaturaesp', 'mediapos', 'dataformaturapos', 'dataexame', 'notaexame', 'periodo'], 'string', 'max' => 10],
            [['pais', 'passaporte', 'inscricaoposcomp'], 'string', 'max' => 20],
            [['estadocivil', 'periodoprofissional1', 'periodoprofissional2', 'periodoprofissional3'], 'string', 'max' => 15],
            [['cpf'], 'string', 'max' => 14],
            [['sexo'], 'string', 'max' => 1],
            [['telresidencial', 'telcomercial', 'telcelular'], 'string', 'max' => 18],
            [['notaposcomp'], 'string', 'max' => 5],
            [['solicitabolsa', 'vinculoemprego', 'vinculoconvenio'], 'string', 'max' => 3],
            [['tituloproposta'], 'string', 'max' => 100],
            [['cursoesp'], 'string', 'max' => 70],
            [['periodoacademico1', 'periodoacademico2', 'periodoacademico3'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            
            'cursograd' => 'Curso',
            'instituicaograd' => 'Instituição',
            'crgrad' => 'Coeficiente de Rendimento',
            'egressograd' => 'Ano de Egresso',
            
            'cursoesp' => 'Curso',
            'instituicaoesp' => 'Instituição',
            'egressoesp' => 'Ano de Egresso',

            'cursopos' => 'Curso',
            'instituicaopos' => 'Instituição',
            'tipopos' => 'Tipo',
            'mediapos' => 'Média',
            'egressopos' => 'Ano Egresso',

            'historico' => 'Histórico',

            'periodicosinternacionais' => 'Periódicos Internacionais',
            'periodicosnacionais' => 'Periódicos Nacionais',
            'conferenciasinternacionais' => 'Conferências Internacionais',
            'conferenciasnacionais' => 'Conferências Nacionais',

            'instituicaoingles' => 'Instituição',
            'duracaoingles' => 'Anos de Estudo',
            'nomeexame' => 'Exame de Proeficiência',
            'dataexame' => 'Data',
            'notaexame' => 'Nota',

            'empresa1' => 'Empresa/Instituição 1',
            'empresa2' => 'Empresa/Instituição 2',
            'empresa3' => 'Empresa/Instituição 3',
            'cargo1' => 'Cargo/Função',
            'cargo2' => 'Cargo/Função',
            'cargo3' => 'Cargo/Função',
            'periodoprofissional1' => 'Período (De X até Y)',
            'periodoprofissional2' => 'Período (De X até Y)',
            'periodoprofissional3' => 'Período (De X até Y)',

            'instituicaoacademica1' => 'Instituição Acadêmica 1',
            'instituicaoacademica2' => 'Instituição Acadêmica 2',
            'instituicaoacademica3' => 'Instituição Acadêmica 3',
            'atividade1' => 'Atividade',
            'atividade2' => 'Atividade',
            'atividade3' => 'Atividade',
            'periodoacademico1' => 'Período Acadêmico',
            'periodoacademico2' => 'Período Acadêmico',
            'periodoacademico3' => 'Período Acadêmico',
            
            'senha' => 'Senha',
            'inicio' => 'Inicio',
            'fim' => 'Fim',
            'passoatual' => 'Passoatual',
            'nome' => 'Nome',
            'endereco' => 'Endereco',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Uf',
            'cep' => 'Cep',
            'email' => 'Email',
            'datanascimento' => 'Datanascimento',
            'nacionalidade' => 'Nacionalidade',
            'pais' => 'Pais',
            'estadocivil' => 'Estadocivil',
            'rg' => 'Rg',
            'orgaoexpedidor' => 'Orgaoexpedidor',
            'dataexpedicao' => 'Dataexpedicao',
            'passaporte' => 'Passaporte',
            'cpf' => 'Cpf',
            'sexo' => 'Sexo',
            'telresidencial' => 'Telresidencial',
            'telcomercial' => 'Telcomercial',
            'telcelular' => 'Telcelular',
            'nomepai' => 'Nomepai',
            'nomemae' => 'Nomemae',
            'cursodesejado' => 'Cursodesejado',
            'regime' => 'Regime',
            'inscricaoposcomp' => 'Inscricaoposcomp',
            'anoposcomp' => 'Anoposcomp',
            'notaposcomp' => 'Notaposcomp',
            'solicitabolsa' => 'Solicitabolsa',
            'vinculoemprego' => 'Vinculoemprego',
            'empregador' => 'Empregador',
            'cargo' => 'Cargo',
            'vinculoconvenio' => 'Vinculoconvenio',
            'convenio' => 'Convenio',
            'linhapesquisa' => 'Linhapesquisa',
            'tituloproposta' => 'Tituloproposta',
            'diploma' => 'Diploma',
            
            'motivos' => 'Motivos',
            'proposta' => 'Proposta',
            'curriculum' => 'Curriculum',
            'cartaempregador' => 'Cartaempregador',
            'comprovantepagamento' => 'Comprovantepagamento',
            
            'dataformaturagrad' => 'Dataformaturagrad',

            'dataformaturaesp' => 'Dataformaturaesp',
            
            'dataformaturapos' => 'Dataformaturapos',
            
            
            

            'resultado' => 'Resultado',
            'periodo' => 'Periodo',
        ];
    }
}
