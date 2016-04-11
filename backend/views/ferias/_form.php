<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ferias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ferias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idusuario')->textInput() ?>

    <?= $form->field($model, 'nomeusuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emailusuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput() ?>

    <?= $form->field($model, 'dataSaida')->textInput() ?>

    <?= $form->field($model, 'dataRetorno')->textInput() ?>

    <?= $form->field($model, 'dataPedido')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Férias' : 'Editar Férias', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
