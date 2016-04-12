<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReservaSala */

$this->title = 'Update Reserva Sala: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reserva Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reserva-sala-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
