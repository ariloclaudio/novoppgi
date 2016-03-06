<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CpfValidator;
use yii\web\UploadedFile;


class Candidato extends \yii\db\ActiveRecord
{
    public $recomendacoes;
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
            [['email', 'senha', 'repetirSenha', 'idEdital'], 'required', 'when' => function($model){ return $model->passoatual == 0;},
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

            [['nome', 'estadocivil', 'sexo', 'cep', 'uf',  'cidade', 'endereco', 'bairro' , 'datanascimento', 'nacionalidade', 'telresidencial' , 'nomepai', 'nomemae', 'cursodesejado', 'solicitabolsa' , 'vinculoconvenio', 'cotas', 'regime', 'vinculoemprego', 'solicitabolsa'], 'required', 'when' => function($model){ return $model->passoatual == 1;},
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

            [['cursograd', 'instituicaograd', 'egressograd', 'crgrad', 'periodicosinternacionais','periodicosnacionais','conferenciasinternacionais', 'conferenciasnacionais' ], 'required', 'when' => function($model){ return $model->passoatual == 2;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_2';
            }"],
            [['historicoFile'], 'required', 'when' => function($model){ return !isset($model->historico) && $model->passoatual == 2;}, 
                'whenClient' => "function (attribute, value) {
                    return $('#form_hidden').val() == 'passo_form_2' && ($('#form_upload').val() == 2 || $('#form_upload').val() == 0);
                }"],
            [['curriculumFile'], 'required', 'when' => function($model){ return !isset($model->curriculum) && $model->passoatual == 2;},
                'whenClient' => "function (attribute, value) {
                    return $('#form_hidden').val() == 'passo_form_2' && ($('#form_upload').val() == 1 || $('#form_upload').val() == 0);
                }"],
/*FIM Validações para passo 2*/
/*Inicio Validações para passo 3*/
            [['linhapesquisa', 'tituloproposta', 'motivos'], 'required', 'when' => function($model){ return $model->passoatual == 3;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_3';
            }"],
            [['propostaFile'], 'required', 'when' => function($model){ return !isset($model->proposta) && $model->passoatual == 3;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_3' && ($('#form_upload').val() == 2 || $('#form_upload').val() == 0);
            }"],
            [['comprovanteFile'], 'required', 'when' => function($model){ return !isset($model->comprovantepagamento) && $model->passoatual == 3;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_3' && ($('#form_upload').val() == 1 || $('#form_upload').val() == 0);
            }"],

            [['linhapesquisa', 'tituloproposta', 'motivos' , 'propostaFile','comprovanteFile', 'cartaNomeReq1', 'cartaNomeReq2', 'cartaEmailReq1' , 'cartaEmailReq2'], 'required', 'when' => function($model){ return $model->passoatual == 3 && $model->edital->cartarecomendacao == 1;},
            'whenClient' => "function (attribute, value) {
                return $('#form_hidden').val() == 'passo_form_3_carta';
            }"],
/*FIM Validações para passo 3*/

        
            [['crgrad'], 'number', 'min' => 1, 'max' => 10],
            [['cartaNome', 'cotaTipo'], 'string'],
            [['cartaEmail'], 'email'],
            [['cpf'], CpfValidator::className(), 'message' => 'CPF Inválido'],
 
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'safe'],
            [['historicoFile', 'curriculumFile', 'cartaempregadorFile', 'propostaFile', 'comprovanteFile'], 'file', 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 2],
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
            'idEdital' => 'Edital',
        ];
    }


    /*Relacionamento*/
    public function getEdital()
    {
        return $this->hasOne(Edital::className(), ['numero' => 'idEdital']);
    }


    //fim do relacionamento


    

    public function getDiretorio(){
        $salt1 = "programadeposgraduacaoufamicompPPGI";
        $salt2 = $this->id * 777;
        $id = $this->id;
        $idCriptografado = md5($salt1+$id+$salt2);
        //definição de um caminho padrão, baseado no ID do candidato
        $caminho = 'documentos/'.$this->idEdital.'/'.$idCriptografado.'/';
        //fim da definição do caminho padrão
        return $caminho;

    }

    public function gerarDiretorio($id,$idEdital){

        $caminho = $this->getDiretorio();

        //verificação se o diretório a ser criado já existe, pois se já existe, não há necessidade de criar outro
        $caminho_ja_existe = is_dir($caminho);
        $edital_ja_existe =  is_dir('documentos/'.$idEdital);
        
        if($edital_ja_existe != true)
            mkdir('documentos/'.$idEdital);

        if($caminho_ja_existe != true){
            mkdir($caminho); //cria de fato o diretório
        }
        //fim da verificação

        return $caminho;
    }

/*Uploads dos Pdfs correspondentes a cada passo*/

    public function uploadPasso1($cartaFile,$idEdital){
        if(!isset($cartaFile)) return true;

        //obtenção o ID do usuário pelo meio de sessão
        $id = Yii::$app->session->get('candidato');
        //fim da obtenção

        //método que gera o diretório, retornando o caminho do diretório
        $caminho = $this->gerarDiretorio($id,$idEdital);
        //fim do método que gera o diretório

        if(isset($cartaFile)){
            $this->cartaempregador = "cartaempregador.".$cartaFile->extension;
            $cartaFile->saveAs($caminho.$this->cartaempregador);
            return true;
        }else if ($this->cartaempregador) {
            return true;
        } else {
            return false;
        }
    }
    
    public function uploadPasso2($historicoFile, $curriculumFile, $idEdital){

        if (isset($historicoFile) && isset($curriculumFile)) {

            //obtenção o ID do usuário pelo meio de sessão
            $id = Yii::$app->session->get('candidato');
            //fim da obtenção

            //método que gera o diretório, retornando o caminho do diretório
        $caminho = $this->gerarDiretorio($id,$idEdital);
            //fim do método que gera o diretório

            $this->historico = "Historico.".$historicoFile->extension;
            $this->curriculum = "Curriculum.".$curriculumFile->extension;

            $historicoFile->saveAs($caminho.$this->historico);
            $curriculumFile->saveAs($caminho.$this->curriculum);

             return true;
        } else if(isset($this->historico) && isset($this->curriculum)){
            return true;
        }else{
            return false;
        }
    }

    public function uploadPasso3($propostaFile, $comprovanteFile, $idEdital)
    {
        if (isset($propostaFile) && isset($comprovanteFile)) {

            //obtenção o ID do usuário pelo meio de sessão
            $id = Yii::$app->session->get('candidato');
            //fim da obtenção

            //método que gera o diretório, retornando o caminho do diretório
            $caminho = $this->gerarDiretorio($id,$idEdital);
            //fim do método que gera o diretório

            $this->proposta = "Proposta.".$propostaFile->extension;
            $this->comprovantepagamento = "Comprovante.".$comprovanteFile->extension;

            $propostaFile->saveAs($caminho.$this->proposta);
            $comprovanteFile->saveAs($caminho.$this->comprovantepagamento);

            return true;
        } else if(isset($this->proposta) && isset($this->comprovantepagamento)){
            return true;
        } else {
            return false;
        }
    }

    public function afterFind(){
        $this->recomendacoes = Recomendacoes::findAll(['idCandidato' => $this->id]);
        if(count($this->recomendacoes) != 0){
            $this->cartaNomeReq1 = $this->recomendacoes[0]->nome;
            $this->cartaNomeReq2 = $this->recomendacoes[1]->nome;
            $this->cartaEmailReq1 = $this->recomendacoes[0]->email;
            $this->cartaEmailReq2 = $this->recomendacoes[1]->email;
        }
        
        for($i = 2 ; $i < count($this->recomendacoes) ; $i++){
            $this->cartaNome[$i-2] = $this->recomendacoes[$i]->nome;
            $this->cartaEmail[$i-2] = $this->recomendacoes[$i]->email;
        }

        return true;
    }



    public function beforeSave()
    {
        if($this->passoatual == 1 || $this->passoatual == 2 || $this->passoatual == 4 || !Candidato::find()->where(['idEdital' => $this->idEdital])->andWhere(['email' => $this->email])->count())
            return true;
        else if($this->passoatual == 3){
            $cartas = $this->arrayCartas();

            Recomendacoes::deleteAll(['idCandidato' => $this->id]);
            for ($i=0; $i < count($cartas['nome']); $i++) {
                $recomendacao = new Recomendacoes();
                $recomendacao->idCandidato = $this->id;
                $recomendacao->dataEnvio = '0000-00-00 00:00:00';
                $recomendacao->prazo = date("Y-m-d", strtotime('+1 days'));
                $recomendacao->nome = $cartas['nome'][$i];
                $recomendacao->email = $cartas['email'][$i];
                $recomendacao->token = md5($this->id.$cartas['email'][$i].time());
                $this->recomendacoes[$i] = $recomendacao;
                if(!$recomendacao->save())
                    return false;
                    
            }
            return true;
        }else
            return false;
    }


    public function arrayCartas(){
        $array = [];

        $array['nome'] = [$this->cartaNomeReq1, $this->cartaNomeReq2];
        $array['email'] = [$this->cartaEmailReq1, $this->cartaEmailReq2];
        
        if(isset($this->cartaNome) && isset($this->cartaEmail)){
            $this->cartaNome = array_filter($this->cartaNome);
            $this->cartaEmail = array_filter($this->cartaEmail);
        }
        
        for ($i=0; $i < count($this->cartaNome); $i++){ 
            if($this->cartaNome[$i] != "" && $this->cartaEmail[$i] != ""){
                array_push($array['nome'], $this->cartaNome[$i]);
                array_push($array['email'], $this->cartaEmail[$i]);
            }
        }
        return $array;
    }

    public function getCotaTipoDesc(){
        if($this->cotaTipo == 1)
            return "Negro";
        else if($this->cotaTipo == 2)
            return "Pardo";
        else if($this->cotaTipo == 3)
            return "Índio";
        else
            return "NAO INFORMADO";
    }
}
