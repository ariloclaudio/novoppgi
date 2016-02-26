<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CpfValidator;
use yii\web\UploadedFile;

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

    public $repetirSenha;
    public $auth_key;

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
/*Inicio Validações para passo 0*/
            [['email', 'senha', 'repetirSenha'], 'required', 'when' => function($model){ return $model->passoatual == 0;},
                'whenClient' => "function (attribute, value) {
                    return $('#form_hidden').val() == 'passo_form_0';
                }"],
            [['repetirSenha'], 'compare', 'compareAttribute' => 'senha', 'message' => '"Repetir Senha" deve ser igual ao campo "Senha"', 'when' => function($model){ return $model->passoatual == 0;},
                'whenClient' => "function (attribute, value) {
                    return $('#form_hidden').val() == 'passo_form_0';
                }"],
            [['idEdital'], 'string'],
            [['email'], 'email'],
/*FIM Validações para passo 0*/

/*Inicio Validações para passo 1*/

            [['nome', 'estadocivil', 'sexo', 'cep', 'uf',  'cidade', 'endereco', 'bairro' , 'datanascimento', 'nacionalidade', 'telresidencial' , 'nomepai', 'nomemae', 'cursodesejado', 'solicitabolsa' , 'vinculoconvenio', 'regime', 'vinculoemprego', 'solicitabolsa'], 'required', 'when' => function($model){ return $model->passoatual == 1;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_1';
            }"],

            [['rg','cpf','orgaoexpedidor','dataexpedicao'], 'required', 'when' => function($model){ return $model->passoatual == 1 && $model->nacionalidade == 1;},
            'whenClient' => "function (attribute, value) {
                return $('input:radio[name=\"Candidato[nacionalidade]\"]:checked').val() == 1;
            }"],


            [['pais', 'passaporte'], 'required', 'when' => function($model){ return $model->passoatual == 1 && $model->nacionalidade == 2;},
            'whenClient' => "function (attribute, value) {
                return $('input:radio[name=\"Candidato[nacionalidade]\"]:checked').val() == 2;
            }"],
/*FIM Validações para passo 1*/

/*Inicio Validações para passo 2*/

            [['cursograd', 'instituicaograd', 'egressograd', 'crgrad', 'historicoFile' , 'curriculumFile' , 'periodicosinternacionais','periodicosnacionais','conferenciasinternacionais', 'conferenciasnacionais' ], 'required', 'when' => function($model){ return $model->passoatual == 2;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_2';
            }"],
/*FIM Validações para passo 2*/
/*Inicio Validações para passo 3*/
            [['linhapesquisa', 'tituloproposta', 'cartaNomeReq1', 'cartaNomeReq2', 'motivos' , 'curriculumFile' , 'propostaFile','comprovanteFile', 'cartaEmailReq1' , 'cartaEmailReq2'], 'required', 'when' => function($model){ return $model->passoatual == 3;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_3';
            }"],
/*FIM Validações para passo 3*/

            

            [['crgrad'], 'number', 'min' => 1, 'max' => 10],
            [['cartaNome'], 'string'],
            [['cartaEmail'], 'email'],
            [['cpf'], CpfValidator::className(), 'message' => 'CPF Inválido'],
 
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'safe'],
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'file', 'extensions' => 'pdf'],
            [['inicio', 'fim'], 'safe'],
            [['passoatual', 'nacionalidade', 'cursodesejado', 'regime', 'anoposcomp', 'linhapesquisa', 'egressograd', 'egressoesp', 'tipopos', 'egressopos', 'periodicosinternacionais', 'periodicosnacionais', 'conferenciasinternacionais', 'conferenciasnacionais', 'duracaoingles', 'resultado'], 'integer', 'min' => 0, 'max' => 2099],
            [['diploma', 'historico', 'motivos', 'proposta', 'curriculum', 'comprovantepagamento'], 'string'],
            [['cidade'], 'string', 'max' => 40],
            [['nome', 'nomepai', 'nomemae'], 'string', 'max' => 60],
            [['endereco'], 'string', 'max' => 160],
            [['bairro', 'empregador', 'cargo', 'convenio', 'cursograd', 'instituicaograd', 'instituicaoesp', 'cursopos', 'instituicaopos', 'instituicaoingles', 'nomeexame', 'empresa1', 'empresa2', 'empresa3', 'cargo1', 'cargo2', 'cargo3', 'instituicaoacademica1', 'instituicaoacademica2', 'instituicaoacademica3', 'atividade1', 'atividade2', 'atividade3'], 'string', 'max' => 50],
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


    /*Relacionamento*/
    public function getEdital()
    {
        return $this->hasOne(Edital::className(), ['idEdital' => 'numero']);
    }

/*Uploads dos Pdf correspondente a cada passo*/

    public function uploadPasso1($cartaFile)
    {
        if(!isset($cartaFile)){
            return true;
        }else if ($this->validate()) {
            $this->cartaempregador = "cartaempregador-".date('dmYHis') . '.' . $cartaFile->extension;
            $cartaFile->saveAs('documentos/' . $this->cartaempregador . '.' . $cartaFile->extension);
            return true;
        } else {
            return false;
        }
    }
    
    public function uploadPasso2($historicoFile, $curriculumFile)
    {
        if ($this->validate()) {

            $this->historico = "Historico-".date('dmYHis'). '.' . $historicoFile->extension;
            $this->curriculum = "Curriculum-".date('dmYHis'). '.' . $curriculumFile->extension;

            $historicoFile->saveAs('documentos/' . $this->historico . '.' . $historicoFile->extension);
            $curriculumFile->saveAs('documentos/' . $this->curriculum . '.' . $curriculumFile->extension);

            return true;
        } else {

            return false;
        }
    }

    public function uploadPasso3($propostaFile, $comprovanteFile)
    {
        if ($this->validate()) {

            $this->proposta = "Proposta-".date('dmYHis'). '.' . $propostaFile->extension;
            $this->comprovante = "Comprovante-".date('dmYHis'). '.' . $comprovanteFile->extension;

            $propostaFile->saveAs('documentos/' . $this->proposta . '.' . $propostaFile->extension);
            $comprovanteFile->saveAs('documentos/' . $this->comprovante . '.' . $comprovanteFile->extension);

            return true;
        } else {
            return false;
        }
    }



}
