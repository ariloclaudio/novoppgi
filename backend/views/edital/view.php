<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Edital */

$this->title = "Número: ".$model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Editais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-view">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['edital/index', 'id' => $model->numero], ['class' => 'btn btn-warning']) ?>    
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Editar  ', ['update', 'id' => $model->numero], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span> Excluir', ['delete', 'id' => $model->numero], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(' <span class="glyphicon glyphicon-list-alt"></span> Lista de Inscritos  ', ['candidatos/index', 'id' => $model->numero], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(' <span class="glyphicon glyphicon-download"></span> Baixar Documentação ', ['candidatos/downloadscompletos', 'id' => $model->numero], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numero',
            'datainicio',
            'datafim',
                [
                     'attribute' => 'quantidadeinscritos',
                     'label' => "Nº de Inscrições Iniciadas",
                     'format'=>'raw',
                     'value' => $model->quantidadeInscritos
                ],
                [
                     'attribute' => 'quantidadeinscritosfinalizados',
                     'label' => "Nº de Inscrições Encerradas",
                     'format'=>'raw',
                     'value' => $model->quantidadeinscritosfinalizados
                ],
                [
                     'attribute' => 'cartarecomendacao',
                     'format'=>'raw',
                     'value' => $model->cartarecomendacao == 1 ? 'Sim' : 'Não'
                ],
                [
                     'attribute' => 'nomecurso',
                     'label' => "Curso",
                     'format'=>'raw',
                ],
                [
                     'attribute' => 'vagasmestrado',
                     'label' => "Vagas para Mestrado",
                     'format'=>'raw',

                ],
                [
                     'attribute' => 'vagasdoutorado',
                     'label' => "Vagas para Doutorado",
                     'format'=>'raw',

                ],
                [
                     'attribute' => 'datacriacao',
                     'format'=>'raw',
                     'label' => 'Data da Criação no sistema',
                     'value' => date('d-m-Y',strtotime($model->datacriacao))." às ".date('H:m:s',strtotime($model->datacriacao))
                ],
                [
                     'attribute' => 'documento',
                     'label' => 'Edital em PDF',
                     'format'=>'raw',
                     'value' => "<a href='editais/".$model->documento."' target = '_blank'> Baixar </a>"
                ],
        ],
    ]) ?>

</div>
