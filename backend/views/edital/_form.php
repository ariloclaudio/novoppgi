<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Edital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edital-form">
	<div class="grid">
	    <?php $form = ActiveForm::begin(); ?>

		    <div class="row">
		    	<?= $form->field($model, 'numero', ['options' => ['class' => 'col-md-4']])->textInput() ?>
		     </div>

		    <div class="row" style ="border:1px">
				<?= $form->field($model, 'documento', ['options' => ['class' => 'col-md-4']])->FileInput(['accept' => '.pdf'])->label("<b>Selecionar o Edital em formato PDF</b>") ?>
		    </div>

		    <div class="row">
		        <?= $form->field($model, 'datainicio', ['options' => ['class' => 'col-md-2']])->widget(DatePicker::classname(), [
		            'pluginOptions' => [
		                'format' => 'dd/mm/yyyy',
		                'autoclose'=>true
		            ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data Inicial</b>")
		    ?>

		        <?= $form->field($model, 'datafim', ['options' => ['class' => 'col-md-2']])->widget(DatePicker::classname(), [
		            'pluginOptions' => [
		                'format' => 'dd/mm/yyyy',
		                'autoclose'=>true
		            ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data Final</b>")
		    ?>
		    </div>

		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
