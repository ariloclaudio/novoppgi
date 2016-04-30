<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;


$tipos = ['Aula' => 'Aula', 'Defesa' => 'Defesa', 'Exame' => 'Exame', 'Reunião' => 'Reunião'];

$horarios = ["" => "", "07:30" => "07:30", "07:59" => "07:59", "08:30" => "08:30", "08:59" => "08:59", "09:30" => "09:30", "09:59" => "09:59", "10:30" => "10:30", 
            "10:59" => "10:59", "11:30" => "11:30", "11:59" => "11:59", "12:30" => "12:30", "12:59" => "12:59", "13:30" => "13:30", "13:59" => "13:59",
            "14:30" => "14:30", "14:59" => "14:59", "15:30" => "15:30", "15:59" => "15:59", "16:30" => "16:30", "16:59" => "16:59", "17:30" => "17:30", 
            "17:59" => "17:59", "18:30" => "18:30", "18:59" => "18:59", "19:30" => "19:30", "19:59" => "19:59", "20:30" => "20:30", "20:59" => "20:59",
            "21:30" => "21:30", "21:59" => "21:59", "22:30" => "22:30", "22:59" => "22:59"];

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

        <?= $form->field($model, 'horaInicio', ['options' => ['class' => 'col-md-3']])->widget(DateControl::classname(), [
            'language' => 'pt-BR',
            'name'=>'kartik-date',
            'value' => date(''),
            'type'=>DateControl::FORMAT_TIME,
            'displayFormat' => 'php: H:i',
        ])->label("<font color='#FF0000'>*</font> <b>Hora de Início:</b>") ?>

        <?= $form->field($model, 'horaTermino', ['options' => ['class' => 'col-md-3']])->dropDownList($horarios)->label("<font color='#FF0000'>*</font> <b>Hora de Término  :</b>") ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
