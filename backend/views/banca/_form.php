<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banca */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banca-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idAluno')->textInput() ?>

    <?= $form->field($model, 'idMembro')->textInput() ?>

    <?= $form->field($model, 'nomeMembro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instituicaoMembro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'funcao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipoDefesa')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
