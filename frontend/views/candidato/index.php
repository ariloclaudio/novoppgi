<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CandidatoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Candidatos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         
        <?= Html::a('Passo 1', ['candidato/passo1'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Passo 2', ['candidato/passo2'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Passo 3', ['candidato/passo3'], ['class' => 'btn btn-success']) ?>
        
    </p>

</div>
