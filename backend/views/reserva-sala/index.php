<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Reserva de Salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>Escolha uma das salas abaixo para realizar a reserva</p>
<div class="edital-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'nome',
            'numero',
            'localizacao',

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}',
                'buttons'=>[
                  'view' => function ($url, $model) {     
                    return Html::a('<span class="glyphicon glyphicon-calendar"></span>', ['reserva-sala/calendario', 'idSala' => $model->id], [
                            'title' => Yii::t('yii', 'Escolher Horário'),
                    ]);
                  },
                ]
            ],
        ],
    ]); ?>
    
</div>
