<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visualizacao_candidatos')->textInput() ?>

    <?= $form->field($model, 'visualizacao_candidatos_finalizados')->textInput() ?>

    <?= $form->field($model, 'visualizacao_cartas_respondidas')->textInput() ?>

    <?= $form->field($model, 'administrador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coordenador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretaria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'professor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aluno')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
