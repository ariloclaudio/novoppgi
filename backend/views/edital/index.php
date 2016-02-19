<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEdital */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editals';
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
            'cartarecomendacao',
            'datainicio',
            'datafim',
            'documento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
