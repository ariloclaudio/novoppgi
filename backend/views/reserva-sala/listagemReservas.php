<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Reserva de Salas - Listagem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-index">
    <p><?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Lista de Salas', ['index'], ['class' => 'btn btn-warning']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'salaDesc.nome',
            'atividade',
            'dataInicio',
            'horaInicio',
            'dataTermino',
            'horaTermino',

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}',],
        ],
    ]); ?>
    
</div>
