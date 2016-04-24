<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;


$tipos = ['Aula' => 'Aula', 'Defesa' => 'Defesa', 'Exame' => 'Exame', 'Reunião' => 'Reunião'];


$horarios = ["07:00" => "07:00", "07:30" => "07:30", "08:00" => "08:00", "08:30" => "08:30", "09:00" => "09:00", "09:30" => "09:30", "10:00" => "10:00",
"10:30" => "10:30", "11:00" => "11:00", "11:30" => "11:30", "12:00" => "12:00", "12:30" => "12:30", "13:00" => "13:00", "13:30" => "13:30",
"14:00" => "14:00", "14:30" => "14:30", "15:00" => "15:00", "15:30" => "15:30", "16:00" => "16:00", "16:30" => "16:30", "17:00" => "17:00", 
"17:30" => "17:30", "18:00" => "18:00", "18:30" => "18:30", "19:00" => "19:00", "19:30" => "19:30", "20:00" => "20:00", "20:30" => "20:30", 
"21:00" => "21:00", "21:30" => "21:30"];

?>

<div class="reserva-sala-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?= $form->field($model, 'atividade', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Atividade:</b>") ?>
    </div>
     <div class="row">
        <?= $form->field($model, 'tipo', ['options' => ['class' => 'col-md-4']])->dropDownList($tipos, ['prompt' => 'Selecione um tipo'])->label("<font color='#FF0000'>*</font> <b>Tipo:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'dataInicio', ['options' => ['class' => 'col-md-3']])->widget(DatePicker::classname(), [
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ])->label("<font color='#FF0000'>*</font> <b>Data de Início:</b>")

        ?>

        <?= $form->field($model, 'horaInicio', ['options' => ['class' => 'col-md-3']])->textInput()->label("<font color='#FF0000'>*</font> <b>Hora de Início:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'dataTermino', ['options' => ['class' => 'col-md-3']])->widget(DatePicker::classname(), [
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ])->label("<font color='#FF0000'>*</font> <b>Data de Término:</b>")

        ?>

        <?= $form->field($model, 'horaTermino', ['options' => ['class' => 'col-md-3']])->textInput()->label("<font color='#FF0000'>*</font> <b>Hora de Término  :</b>") ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
