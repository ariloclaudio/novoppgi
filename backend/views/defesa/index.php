<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DefesaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Defesas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defesa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Defesa', ['create'], ['class' => 'btn btn-success']) 
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idDefesa',
            'nome_aluno',
            'titulo',
            'tipoDefesa',
            'data',
            'conceito',
             'horario',
             'local',
            // 'resumo:ntext',
            // 'numDefesa',
            // 'examinador:ntext',
            // 'emailExaminador:ntext',
            // 'reservas_id',
            // 'banca_id',
             'aluno_id',
            // 'previa',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
