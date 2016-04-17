<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MembrosBancaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Membros Bancas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membros-banca-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Membros Banca', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'email:email',
            'filiacao',
            'telefone',
            // 'cpf',
            // 'dataCadastro',
            // 'idProfessor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
