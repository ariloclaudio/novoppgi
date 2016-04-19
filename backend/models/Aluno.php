<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CpfValidator;


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
            //[['nome', 'email', 'senha', 'curso', 'estadocivil', 'cpf', 'rg', 'orgaoexpeditor', 'agencia', 'pais', 'resumoQual2', 'resumoTese'], 'required'],
            [['nome', 'email', 'curso', 'cpf', 'cep', 'endereco', 'datanascimento', 'sexo', 'uf', 'cidade', 'bairro', 'telresidencial', 'regime', 'matricula', 'orientador', 'dataingresso', 'curso', 'area', 'nacionalidade'], 'required'],
            [['agencia', 'financiadorbolsa', 'dataimplementacaobolsa'], 'required', 'when' => function ($model) { return $model->bolsista; }, 'whenClient' => "function (attribute, value) {
                    return $('#form_bolsista').val() == '1';
                }"],
            [['area', 'curso', 'nacionalidade', 'regime', 'status', 'numDefesa', 'egressograd', 'idUser', 'orientador'], 'integer'],
            [['resumoQual2', 'resumoTese'], 'string'],
            [['nome', 'examinadorQual1'], 'string', 'max' => 60],
            [['email'],'email'],
            [['cidade'], 'string', 'max' => 40],
            [['senha'], 'string', 'max' => 255],
            [['matricula', 'estadocivil'], 'string', 'max' => 15],
            [['endereco'], 'string', 'max' => 160],
            [['bairro'], 'string', 'max' => 50],
            [['uf'], 'string', 'max' => 5],
            [['cep', 'conceitoExameProf', 'conceitoQual2', 'conceitoTese', 'conceitoQual1'], 'string', 'max' => 9],
            [['datanascimento', 'rg', 'orgaoexpeditor', 'dataexpedicao', 'dataExameProf', 'dataQual2', 'dataTese', 'horarioQual2', 'horarioTese', 'dataQual1'], 'string', 'max' => 10],
            [['sexo'], 'string', 'max' => 1],
            [['cpf'], CpfValidator::className(), 'message' => 'CPF Inválido'],
            [['telresidencial', 'telcomercial', 'telcelular'], 'string', 'max' => 18],
            [['bolsista'], 'string', 'max' => 3],
            [['agencia', 'pais'], 'string', 'max' => 30],
            [['financiadorbolsa'], 'string', 'max' => 45],
            [['idiomaExameProf'], 'string', 'max' => 20],
            [['tituloQual2', 'tituloTese', 'tituloQual1'], 'string', 'max' => 180],
            [['localQual2', 'localTese', 'cursograd', 'instituicaograd'], 'string', 'max' => 100],
            [['sede'], 'string', 'max' => 2],
            [['dataingresso', 'dataimplementacaobolsa'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'email' => 'Email',
            'senha' => 'Senha',
            'matricula' => 'Matrícula',
            'area' => 'Linha de Pesquisa',
            'curso' => 'Curso',
            'endereco' => 'Endereço',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'UF',
            'cep' => 'CEP',
            'datanascimento' => 'Data de Nascimento',
            'sexo' => 'Sexo',
            'nacionalidade' => 'Nacionalidade',
            'cpf' => 'CPF',
            'rg' => 'RG',
            'telresidencial' => 'Telefone Principal',
            'telcelular' => 'Telefone Alternativo',
            'regime' => 'Regime',
            'bolsista' => 'Bolsista',
            'agencia' => 'Agência',
            'pais' => 'País',
            'status' => 'Status',
            'dataingresso' => 'Data de Ingresso',
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
            'cursograd' => 'Curso da Graduação',
            'instituicaograd' => 'Instituicão da Graduação',
            'egressograd' => 'Egresso Graduação',
            'dataformaturagrad' => 'Data da Formatura',
            'orientador' => 'Orientador',
            'anoconclusao' => 'Ano de Conclusão',
            'sede' => 'Sede',
            'financiadorbolsa' => 'Financiador da Bolsa',
            'dataimplementacaobolsa' => 'Início da Vigência',

        ];
    }

    public function beforeSave(){
        $this->dataingresso = date('Y-m-d', strtotime($this->dataingresso));
        return true;
    }

    public function getlinhaPesquisa()
    {
        return $this->hasOne(LinhaPesquisa::className(), ['id' => 'area']);
    }
}
