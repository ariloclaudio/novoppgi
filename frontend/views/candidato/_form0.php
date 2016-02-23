<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form ActiveForm */
?>
<div class="candidato-index">

    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" id = "form_hidden" value ="passo_form_0"/>

        <div class ="row">
        <?= $form->field($model, 'email' , ['options' => ['class' => 'col-md-3']]  )->label("<font color='#FF0000'>*</font> <b>Email:</b>") ?>
        </div>
        <div class ="row">
        <?= $form->field($model, 'senha' , ['options' => ['class' => 'col-md-3']] )->passwordInput(['value' => ""])->label("<font color='#FF0000'>*</font> <b>Senha:</b>") ?>
        </div>
        <div class= "row">
        <?= $form->field($model, 'repetirSenha' , ['options' => ['class' => 'col-md-3']] )->passwordInput(['value' => ""])->label("<font color='#FF0000'>*</font> <b>Repetir Senha:</b>") ?>
        </div>
    <br>
        <div class="form-group">
            <?= Html::submitButton('Salvar Candidato', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- candidato-index -->
