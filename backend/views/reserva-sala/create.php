<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReservaSala */

$this->title = 'Create Reserva Sala';
$this->params['breadcrumbs'][] = ['label' => 'Reserva Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-sala-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
