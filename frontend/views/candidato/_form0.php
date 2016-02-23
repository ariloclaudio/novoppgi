<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form ActiveForm */
?>
<div class="candidato-index">

    <?php $form = ActiveForm::begin(); ?>

        <div class ="row">
        <?= $form->field($model, 'email' , ['options' => ['class' => 'col-md-3']]  )->label("*E-mail") ?>
        </div>
        <div class ="row">
        <?= $form->field($model, 'senha' , ['options' => ['class' => 'col-md-3']] )->label("*Senha") ?>
        </div>
        <div class= "row">
        <?= $form->field($model, 'senha' , ['options' => ['class' => 'col-md-3']] )->label("*Repetir Senha") ?>
        </div>
    <br>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- candidato-index -->
