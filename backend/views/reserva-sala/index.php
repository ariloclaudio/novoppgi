<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Reserva de Salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-index">
    <p>Escolha uma das salas abaixo para realizar ou visualizar as reservas</p>
    
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
                    return $model->reservasAtivas;
                },
            ],

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{calendario} {listagem}',
                'buttons'=>[
                  'calendario' => function ($url, $model) {     
                    return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['reserva-sala/calendario', 'idSala' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar no Calendário'),
                    ]);
                  },
                  'listagem' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-list"></span>', ['reserva-sala/listagemreservas', 'idSala' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar em Listagem'),
                            ]);
                  },
                ]
            ],
        ],
    ]); ?>
    
</div>
