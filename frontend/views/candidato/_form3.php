<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Identificação do Candidato</b></p></div>
    

    <?= $form->field($model, 'senha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'fim')->textInput() ?>

    <?= $form->field($model, 'passoatual')->textInput() ?>
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linhapesquisa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tituloproposta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diploma')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'motivos')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proposta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comprovantepagamento')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dataformaturagrad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataformaturaesp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataformaturapos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resultado')->textInput() ?>

    <?= $form->field($model, 'periodo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
