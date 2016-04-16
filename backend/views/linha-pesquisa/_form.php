<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\LinhaPesquisa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="linha-pesquisa-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<?= $form->field($model, 'nome', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome</b>") ?>
    </div>
	<div class="row">
    	<?= $form->field($model, 'descricao', ['options' => ['class' => 'col-md-5']])->textarea(['rows' => 6]) ?>
    </div>
    <div class="row">
    	<?= $form->field($model, 'sigla', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Sigla</b>") ?>
    </div>

	<div class="row">
	    <?= $form->field($model, 'cor', ['options' => ['class' => 'col-md-5']])->widget(ColorInput::classname(), [
	    	'options' => ['placeholder' => 'Selecione uma cor ...'],
			]);
		?>
	</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Alterar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
