<?php

namespace app\models;

use Yii;

class Candidato extends \yii\db\ActiveRecord
{

        public $nomeLinhaPesquisa;
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


        // MODEL RELACIONADO AO BACK END !


        return [
            [['senha', 'periodo'], 'required'],
            [['inicio', 'fim'], 'safe'],
            [['passoatual', 'nacionalidade', 'cursodesejado', 'regime', 'anoposcomp', 'egressograd', 'egressoesp', 'tipopos', 'egressopos', 'periodicosinternacionais', 'periodicosnacionais', 'conferenciasinternacionais', 'conferenciasnacionais', 'duracaoingles', 'resultado'], 'integer'],
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
            [['periodoacademico1', 'periodoacademico2', 'periodoacademico3'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'senha' => 'Senha',
            'inicio' => 'Data da Inicialização da Inscrição',
            'fim' => 'Data da Finalização da Inscrição',
            'passoatual' => 'Passoatual',
            'nome' => 'Nome',
            'endereco' => 'Endereço',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Estado',
            'cep' => 'CEP',
            'email' => 'E-mail',
            'datanascimento' => 'Data de nascimento',
            'nacionalidade' => 'Nacionalidade',
            'pais' => 'País',
            'estadocivil' => 'Estadocivil',
            'rg' => 'RG',
            'orgaoexpedidor' => 'Orgaoexpedidor',
            'dataexpedicao' => 'Dataexpedicao',
            'passaporte' => 'Passaporte',
            'cpf' => 'CPF',
            'sexo' => 'Sexo',
            'telresidencial' => 'Telefone Principal',
            'telcelular' => 'Telefone Alternativo',
            'nomepai' => 'Nomepai',
            'nomemae' => 'Nomemae',
            'cursodesejado' => 'Curso desejado',
            'regime' => 'Regime de Dedicação',
            'inscricaoposcomp' => 'Inscrição poscomp',
            'anoposcomp' => 'Ano poscomp',
            'notaposcomp' => 'Nota poscomp',
            'solicitabolsa' => 'Solicita Bolsa?',
            'cotas' => 'Cotista?',
            'deficiencia' => 'Possui Deficiência?',
            'vinculoemprego' => 'Vinculoemprego',
            'empregador' => 'Empregador',
            'cargo' => 'Cargo',
            'vinculoconvenio' => 'Vinculoconvenio',
            'convenio' => 'Convenio',
            //'idLinhaPesquisa' => 'idLinhaPesquisa',
            'tituloproposta' => 'Tituloproposta',
            'diploma' => 'Diploma',
            'historico' => 'Historico',
            'motivos' => 'Motivos',
            'proposta' => 'Proposta',
            'curriculum' => 'Curriculum',
            'cartaempregador' => 'Cartaempregador',
            'comprovantepagamento' => 'Comprovantepagamento',
            'cursograd' => 'Curso de graduação',
            'instituicaograd' => 'Instituicao da graduação',
//            'crgrad' => 'Coeficiente de Rendimento da graduação',
            'egressograd' => 'Ano de Egresso na Graduação',
            'dataformaturagrad' => 'Data da formatura (graduação)',
            'cursoesp' => 'Cursoesp',
            'instituicaoesp' => 'Instituicaoesp',
            'egressoesp' => 'Egressoesp',
            'dataformaturaesp' => 'Dataformaturaesp',
            'cursopos' => 'Curso de pós Graduação',
            'instituicaopos' => 'Instituição da Pós Graduação',
            'tipopos' => 'Tipo de Pós Graduação',
            'mediapos' => 'Mediapos',
            'egressopos' => 'Ano de Egresso Na Pós Graduação',
            //'dataformaturapos' => 'Dataformaturapos',
            'periodicosinternacionais' => 'Periodicosinternacionais',
            'periodicosnacionais' => 'Periodicosnacionais',
            'conferenciasinternacionais' => 'Conferenciasinternacionais',
            'conferenciasnacionais' => 'Conferenciasnacionais',
            'instituicaoingles' => 'Instituicaoingles',
            'duracaoingles' => 'Duracaoingles',
            'nomeexame' => 'Nomeexame',
            'dataexame' => 'Dataexame',
            'notaexame' => 'Notaexame',
            'empresa1' => 'Empresa1',
            'empresa2' => 'Empresa2',
            'empresa3' => 'Empresa3',
            'cargo1' => 'Cargo1',
            'cargo2' => 'Cargo2',
            'cargo3' => 'Cargo3',
            'periodoprofissional1' => 'Periodoprofissional1',
            'periodoprofissional2' => 'Periodoprofissional2',
            'periodoprofissional3' => 'Periodoprofissional3',
            'instituicaoacademica1' => 'Instituicaoacademica1',
            'instituicaoacademica2' => 'Instituicaoacademica2',
            'instituicaoacademica3' => 'Instituicaoacademica3',
            'atividade1' => 'Atividade1',
            'atividade2' => 'Atividade2',
            'atividade3' => 'Atividade3',
            'periodoacademico1' => 'Periodoacademico1',
            'periodoacademico2' => 'Periodoacademico2',
            'periodoacademico3' => 'Periodoacademico3',
            'resultado' => 'Resultado',
            'periodo' => 'Periodo',
        ];
    }


    public function download($idCandidato,$idEdital){

        return Candidato::findOne(['id' => $idCandidato]);
    }

}
