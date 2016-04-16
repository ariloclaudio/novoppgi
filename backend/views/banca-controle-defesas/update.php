<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BancaControleDefesas */

$this->title = 'Update Banca Controle Defesas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Banca Controle Defesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banca-controle-defesas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
