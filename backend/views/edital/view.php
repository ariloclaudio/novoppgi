<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Edital */

$this->title = $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Editais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                [
                     'attribute' => 'cartarecomendacao',
                     'format'=>'raw',
                     'value' => $model->cartarecomendacao == 1 ? 'Sim' : 'Não'
                ],
            'datainicio',
            'datafim',
            'documento',
        ],
    ]) ?>

</div>
