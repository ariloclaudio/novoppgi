<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use xj\bootbox\BootboxAsset;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);

$this->title = $model->atividade;
$this->params['breadcrumbs'][] = ['label' => 'Reserva Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->salaDesc->nome, 'url' => ['calendario', 'idSala' => $model->sala]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-sala-view">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-calendar"></span> Voltar ao Calendário', ['calendario', 'idSala' => $model->sala], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja remover a reserva \''.$model->atividade.'\'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'dataReserva',
                'value' => date("d-m-Y H:i:s", strtotime($model->dataReserva)),
            ],
            'salaDesc.nome',
            'atividade',
            'tipo',
            [
                'attribute' => 'dataInicio',
                'value' => date("d-m-Y", strtotime($model->dataInicio)),

            ],
            'horaInicio',
            [
                'attribute' => 'dataTermino',
                'value' => date("d-m-Y", strtotime($model->dataTermino)),
            ],
            'horaTermino',
        ],
    ]) ?>

</div>
