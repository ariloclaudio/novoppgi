<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de Férias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ferias-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registrar Férias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'dataPedido',
            //'idusuario',
            'nomeusuario',
             'dataSaida',
             'dataRetorno',
            [
            "attribute" =>'tipo',
            "value" => function ($model){

            	if($model->tipo == 1){
            		return "Oficial";
            	}
            	else{
            		return "Usufruto";
            	}

            },

            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
