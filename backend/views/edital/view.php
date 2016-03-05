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
        <?= Html::a('Voltar', ['edital/index', 'id' => $model->numero], ['class' => 'btn btn-warning']) ?>    
        <?= Html::a('Update', ['update', 'id' => $model->numero], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->numero], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Lista de Inscritos', ['candidatos/index', 'id' => $model->numero], ['class' => 'btn btn-info']) ?>
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
