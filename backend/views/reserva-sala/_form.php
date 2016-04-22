<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$tipos = ['Aula' => 'Aula', 'Defesa' => 'Defesa', 'Exame' => 'Exame', 'Reunião' => 'Reunião'];
?>

<div class="reserva-sala-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dataReserva')->textInput() ?>

    <?= $form->field($model, 'sala')->textInput() ?>

    <?= $form->field($model, 'idSolicitante')->textInput() ?>

    <?= $form->field($model, 'atividade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList($tipos, ['prompt' => 'Selecione um tipo']) ?>

    <?= $form->field($model, 'dataInicio')->textInput() ?>

    <?= $form->field($model, 'dataTermino')->textInput() ?>

    <?= $form->field($model, 'horaInicio')->textInput() ?>

    <?= $form->field($model, 'horaTermino')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
