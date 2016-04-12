<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReservaSala */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reserva-sala-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dataReserva')->textInput() ?>

    <?= $form->field($model, 'sala')->textInput() ?>

    <?= $form->field($model, 'idSolicitante')->textInput() ?>

    <?= $form->field($model, 'atividade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataInicio')->textInput() ?>

    <?= $form->field($model, 'dataTermino')->textInput() ?>

    <?= $form->field($model, 'horaInicio')->textInput() ?>

    <?= $form->field($model, 'horaTermino')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
