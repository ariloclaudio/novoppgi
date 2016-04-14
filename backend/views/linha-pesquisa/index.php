<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Linhas de Pesquisa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-pesquisa-index">
    <p>
        <?= Html::a('Nova Linha Pesquisa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nome',
            [   'label' => 'Descrição',
                'format' => 'html',
                'attribute' => 'descricao',
                'value' => function ($model) {
                     return $model->descricao == "" ? "" : $model->descricao;
                },
            ],
            'sigla',
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
