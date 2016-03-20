<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'senha',
                [
                     'attribute' => 'inicio',
                     'format'=>'raw',
                     'value' => date("d/m/Y", strtotime($model->inicio)).' às '.date("H:i:s", strtotime($model->inicio))
                ],
                [
                     'attribute' => 'fim',
                     'format'=>'raw',
                     'value' => $model->fim != null ? date("d/m/Y", strtotime($model->fim)).' às '.date("H:i:s", strtotime($model->fim)) : null
                ],
            'passoatual',
            'nome',
            'endereco',
            'bairro',
            'cidade',
            'uf',
            'cep',
            'email:email',
            'datanascimento',
                [
                     'attribute' => 'nacionalidade',
                     'format'=>'raw',
                     'value' => $model->nacionalidade == 1 ? 'Brasileira' : 'Estrangeira'
                ],
            'pais',
//            'estadocivil',
//            'rg',
//            'orgaoexpedidor',
//            'dataexpedicao',
            'passaporte',
            'cpf',
                [
                     'attribute' => 'sexo',
                     'format'=>'raw',
                     'value' => $model->sexo == 'M' ? 'Masculino' : 'Feminino'
                ],
            'telresidencial',
//            'telcomercial',
            'telcelular',
//            'nomepai',
//            'nomemae',
                [
                     'attribute' => 'cursodesejado',
                     'format'=>'raw',
                     'value' => $model->cursodesejado == 1 ? 'Mestrado' : 'Doutorado'
                ],
                [
                     'attribute' => 'regime',
                     'format'=>'raw',
                     'value' => $model->regime == 1 ? 'Integral' : 'Parcial'
                ],
            'inscricaoposcomp',
            'anoposcomp',
            'notaposcomp',
            'solicitabolsa',
//            'vinculoemprego',
//            'empregador',
//            'cargo',
//            'vinculoconvenio',
//           'convenio',
                [
                     'attribute' => 'idLinhaPesquisa',
                     'label'=> 'Linha de Pesquisa',
                ],
                [
                     'attribute' => 'tituloproposta',
                     'label'=> 'Título da Proposta',
                ],
            'diploma:ntext',
            //'historico:ntext',
            'motivos:ntext',
            //'proposta:ntext',
            //'curriculum:ntext',
            //'cartaempregador:ntext',
            //'comprovantepagamento:ntext',
            'cursograd',
            'instituicaograd',
//            'crgrad',
            'egressograd',
            'dataformaturagrad',
//            'cursoesp',
//            'instituicaoesp',
//            'egressoesp',
//            'dataformaturaesp',
            'cursopos',
            'instituicaopos',
            'tipopos',
//            'mediapos',
            'egressopos',
            'dataformaturapos',
            'periodicosinternacionais',
            'periodicosnacionais',
            'conferenciasinternacionais',
            'conferenciasnacionais',
/*
            'instituicaoingles',
            'duracaoingles',
            'nomeexame',
            'dataexame',
            'notaexame',
            'empresa1',
            'empresa2',
            'empresa3',
            'cargo1',
            'cargo2',
            'cargo3',
            'periodoprofissional1',
            'periodoprofissional2',
            'periodoprofissional3',

            'instituicaoacademica1',
            'instituicaoacademica2',
            'instituicaoacademica3',
            'atividade1',
            'atividade2',
            'atividade3',
            'periodoacademico1',
            'periodoacademico2',
            'periodoacademico3',
*/  
            'resultado',
//            'periodo',
        ],
    ]) ?>

</div>
