<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;


$tipos = ['Aula' => 'Aula', 'Defesa' => 'Defesa', 'Exame' => 'Exame', 'Reunião' => 'Reunião'];



$horarios = ["07:59" => "08:59", "09:30" => "10:59", "11:59" => "12:59", "13:59" => "14:59", "15:59" => "16:59", "17:59" => "18:59", "20:59" => "21:59",
"22:59" => "10:30", "11:00" => "11:00", "11:30" => "11:30", "12:00" => "12:00", "12:30" => "12:30", "13:00" => "13:00", "13:30" => "13:30",
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

    <div class ="row">

    <?php echo $form->field($model, 'diasSemana[]' , ['options' => ['class' => 'col-md-6']])->checkboxList(['0' => "Domingo" , '1' => 'Segunda-Feira', '2' => 'Terça-Feira', '3' => 'Quarta-Feira', '4' => 'Quinta-Feira', '5' => 'Sexta-Feira', '6' => 'Sábado' ]); ?>

    </div>

    <div class ="row">

    <?= $form->field($model, 'sala' , ['options' => ['class' => 'col-md-3']])->dropDownlist($arraySalas, ['prompt' => 'Selecione uma das salas'])->label("<font color='#FF0000'>*</font> <b>Sala:</b>") ?>

    </div>

    <div class ="row">

    <?= $form->field($model, 'dataInicio', ['options' => ['class' => 'col-md-4']])->widget(DatePicker::classname(), [
        'language' => Yii::$app->language,
        'options' => ['placeholder' => 'Selecione a Data de Início ...',],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]
    ])->label("<font color='#FF0000'>*</font> <b>Data Inicial:</b>")
    ?>

    <?= $form->field($model, 'dataTermino', ['options' => ['class' => 'col-md-4']])->widget(DatePicker::classname(), [
        'language' => Yii::$app->language,
        'options' => ['placeholder' => 'Selecione a Data de Término ...',],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]
    ])->label("<font color='#FF0000'>*</font> <b>Data Final:</b>")
    ?>
    </div>
    
    <div class="row">

        <?= $form->field($model, 'horaInicio', ['options' => ['class' => 'col-md-3']])->textInput()->label("<font color='#FF0000'>*</font> <b>Hora de Início:</b>") ?>

        <?= $form->field($model, 'horaTermino', ['options' => ['class' => 'col-md-3']])->textInput()->label("<font color='#FF0000'>*</font> <b>Hora de Término  :</b>") ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
