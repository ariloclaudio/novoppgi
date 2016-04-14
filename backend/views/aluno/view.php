<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'id',
            'nome',
            'email:email',
            'senha',
            'matricula',
            'area',
            'curso',
            'endereco',
            'bairro',
            'cidade',
            'uf',
            'cep',
            'datanascimento',
            'sexo',
            'nacionalidade',
            'estadocivil',
            'cpf',
            'rg',
            'orgaoexpeditor',
            'dataexpedicao',
            'telresidencial',
            'telcomercial',
            'telcelular',
            'nomepai',
            'nomemae',
            'regime',
            'bolsista',
            'agencia',
            'pais',
            'status',
            'dataingresso',
            'idiomaExameProf',
            'conceitoExameProf',
            'dataExameProf',
            'tituloQual2',
            'dataQual2',
            'conceitoQual2',
            'tituloTese',
            'dataTese',
            'conceitoTese',
            'horarioQual2',
            'localQual2',
            'resumoQual2:ntext',
            'horarioTese',
            'localTese',
            'resumoTese:ntext',
            'tituloQual1',
            'numDefesa',
            'dataQual1',
            'examinadorQual1',
            'conceitoQual1',
            'cursograd',
            'instituicaograd',
            'crgrad',
            'egressograd',
            'dataformaturagrad',
            'idUser',
            'orientador',
            'anoconclusao',
            'sede',
        ],
    ]) ?>

</div>
