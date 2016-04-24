<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Reserva de Salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>Escolha uma das salas abaixo para realizar ou visualizar as reservas</p>
<div class="edital-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model) { if($model->reservasAtivas > 4) return ['class' => 'danger'];},
        'summary' => false,
        'columns' => [
            'nome',
            'numero',
            'localizacao',
            [
                'attribute' => 'reservasAtivas',
                'value' => function ($model){
                    return $model->reservasAtivas.'/5';
                },
            ],

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}',
                'buttons'=>[
                  'view' => function ($url, $model) {     
                    return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['reserva-sala/calendario', 'idSala' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar Calendário'),
                    ]);
                  },
                ]
            ],
        ],
    ]); ?>
    
</div>
