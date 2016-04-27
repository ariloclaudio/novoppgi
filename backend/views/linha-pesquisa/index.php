<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Linhas de Pesquisa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-pesquisa-index">
    <p>
        <?= Html::a('<span class="fa fa-plus"></span> Nova Linha Pesquisa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nome',
            'sigla',
            [   'attribute' => 'icone',
                'format' => 'html',
                'value' => function ($model){
                  return "<span class='fa ". $model->icone ." fa-lg'/> ";
                }
            ],
            [   'label' => 'Cor',
                'attribute' => 'cor',
                'contentOptions' => function ($model){
                  return ['style' => 'background-color: '.$model->cor];
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
