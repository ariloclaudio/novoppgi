<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEdital */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Edital', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'numero',

            [
                'label' => 'Carta de Recomendação',
                'attribute' => 'cartarecomendacao',
                'value' => function ($model) {
                        if($model->cartarecomendacao == 0){
                            return "Não";
                        }
                        else{
                            return "Sim";
                        }
                },
            ],
            [
                'label' => 'Data início',
                'attribute' => 'datainicio',
                'value' => function ($model) {
                        return date("d-m-Y", strtotime($model->datainicio));
                },
            ],
            [
                'label' => 'Data fim',
                'attribute' => 'datafim',
                'value' => function ($model) {
                        return date("d-m-Y", strtotime($model->datafim));
                },
            ],
            [
                'label' => 'Quantidade Inscritos',
                'attribute' => 'quantidadeInscritos',
                'value' => function ($model) {
                            return $model->numero;
                },
            ],
            //'documento',


            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{download} {view} {delete} {update}',
                'buttons'=>[
                  'download' => function ($url, $model) {     
                    return Html::a('<span class="glyphicon glyphicon-download"></span>', 'editais/'.$model->documento, [
                            'target' => '_blank','title' => Yii::t('yii', 'Download do Edital'),
                    ]);                                

                  }
              ]                            
                ],
        ],
    ]); ?>
</div>


