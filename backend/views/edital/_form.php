<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Edital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edital-form">
	<div class="grid">
	    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

		    <div class="row">
		    	<?= $form->field($model, 'numero', ['options' => ['class' => 'col-md-4']])->textInput() ?>
		     </div>

		    <div class="row" style ="border:1px">
				<?= $form->field($model, 'documentoFile', ['options' => ['class' => 'col-md-4']])->FileInput(['accept' => '.pdf'])->label("<font color='#FF0000'>*</font> <b>Selecionar o Edital em formato PDF:</b>") ?>
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
		    <div class="row">
			    <?= $form->field($model, 'cartarecomendacao', ['options' => ['class' => 'col-md-2']])->widget(SwitchInput::classname(), ['pluginOptions' => [
			        'onText' => 'Sim',
			        'offText' => 'Não',
			    ]])->label("<font color='#FF0000'>*</font> <b>Carta de Recomendação?</b>") ?>
			</div>
			<div class="row">
		    	<?= $form->field($model, 'cotas', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number'])->label("<font color='#FF0000'>*</font> <b>Cotas (0 senão houver cotas):</b>") ?>
		    </div>
		    <div class = "row">
			    <?= $form->field($model, 'curso', ['options' => ['class' => 'col-md-3']])->radioList(['1' => 'Mestrado' , '2' => 'Doutorado', '3' => 'Ambos'])->label("<font color='#FF0000'>*</font> <b>Curso:</b>")  ?>
			</div>

		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Alterar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
