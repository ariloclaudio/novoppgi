<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CpfValidator;

class Candidato extends \yii\db\ActiveRecord
{
    public $historicoFile;
    public $curriculumFile;
    public $cartaempregadorFile;
    public $propostaFile;
    public $comprovanteFile;

    public $cartaNomeReq1;
    public $cartaNomeReq2;
    public $cartaEmailReq1;
    public $cartaEmailReq2;

    public $cartaNome;
    public $cartaEmail;

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
            [['senha', 'sexo', 'periodo', 'nome', 'datanascimento', 'nacionalidade', 'nomepai', 'nomemae', 'cursodesejado', 'vinculoconvenio', 'regime', 'vinculoemprego', 'solicitabolsa', 'endereco', 'bairro', 'cidade', 'uf', 'cep', 'estadocivil', 'telresidencial', 'cursograd', 'egressograd', 'instituicaograd', 'crgrad', 'linhapesquisa', 'proposta', 'cartaNomeReq2', 'cartaEmailReq2','cartaNomeReq1', 'cartaEmailReq1', 'motivos'], 'required'],
            [['crgrad'], 'number', 'min' => 1, 'max' => 10],
            [['cartaNome'], 'string'],
            [['cartaEmail'], 'email'],

            [['cpf'], CpfValidator::className(), 'message' => 'CPF Inválido'],
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'safe'],
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'file', 'extensions' => 'pdf'],
            [['inicio', 'fim'], 'safe'],
            [['passoatual', 'nacionalidade', 'cursodesejado', 'regime', 'anoposcomp', 'linhapesquisa', 'egressograd', 'egressoesp', 'tipopos', 'egressopos', 'periodicosinternacionais', 'periodicosnacionais', 'conferenciasinternacionais', 'conferenciasnacionais', 'duracaoingles', 'resultado'], 'integer', 'min' => 0, 'max' => 2099],
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
            [['cpf'], 'string'],
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

            'nome' => 'Nome',
            'endereco' => 'Endereco',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'UF',
            'cep' => 'CEP',
            'email' => 'Email',
            'datanascimento' => 'Data Nascimento',
            'nacionalidade' => 'Nacionalidade',
            'pais' => 'Pais',
            'estadocivil' => 'Estado Civil',
            'rg' => 'RG',
            'orgaoexpedidor' => 'Orgao Expedidor',
            'dataexpedicao' => 'Data Expedicao',
            'passaporte' => 'Passaporte',
            'cpf' => 'CPF',
            'sexo' => 'Sexo',
            'telresidencial' => 'Telelefone Residencial',
            'telcomercial' => 'Telelefone Comercial',
            'telcelular' => 'Telelefone Celular',
            'nomepai' => 'Nome do Pai',
            'nomemae' => 'Nome da Mae',
            'cursodesejado' => 'Curso Desejado',
            'regime' => 'Regime',
            'inscricaoposcomp' => 'Inscricao PosComp',
            'anoposcomp' => 'Ano PosComp',
            'notaposcomp' => 'Nota PosComp',
            'solicitabolsa' => 'Solicita Bolsa de Estudo',
            'vinculoemprego' => 'Vinculo Emprego',
            'empregador' => 'Empregador',
            'cargo' => 'Cargo',
            
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
