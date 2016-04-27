<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;
use yii\widgets\MaskedInput;

$uploadEdital = 0;

if(isset($model->documento))
	$uploadEdital = 1;
	

?>

<div class="edital-form">
	<div class="grid">
	    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

	    	<input type='hidden' id = 'form_mestrado' value =<?= $model->mestrado ?> />
	    	<input type='hidden' id = 'form_doutorado' value =<?= $model->doutorado?> />
	    	<input type="hidden" id = "form_upload" value = '<?=$uploadEdital?>' />

		    <div class="row">
            <?= $form->field($model, 'numero', ['options' => ['class' => 'col-md-4']])->widget(MaskedInput::className(), [
        'mask' => '999-9999'])->hint('Ex.: 001-2016, sendo o <b>\'001\'</b> o número do edital e <b>\'2016\'</b> o ano')->textInput(['readonly' => $read ])->label("<font color='#FF0000'>*</font> <b>Número do edital:</b>") ?> 

		     </div>
		     <div class="row">
				<?php 
		        if(isset($model->documento)){
		            echo "<div class='col-md-8'> <b>Edital em formato PDF:<br> 
		                Você já fez o upload do edital, <a href='editais/".$model->documento."' >clique aqui </a>para visualizá-lo.</b><br></div>";
		            
		            echo $form->field($model, 'editalUpload', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
		            'pluginOptions' => [
		                'onText' => 'Sim',
		                'offText' => 'Não',
		                ]])->label("<font color='#FF0000'>*</font> <b>Deseja mudar o arquivo?</b>");

		        }
		        else{
		            echo $form->field($model, 'documentoFile')->FileInput(['accept' => '.pdf'])->label("<font color='#FF0000'>*</font> <b>Edital em formato PDF:</b>");
		        }
		        ?>

		        <?php if(isset($model->documento)){ ?>
		            <div id="divDocumentoFile" style="display: none; clear: both;">
		                <?= $form->field($model, 'documentoFile')->FileInput(['accept' => '.pdf'])->label(false); ?>
		            </div>
		        <?php } ?>
	        </div>

		    <div class="row">
		        <?= $form->field($model, 'datainicio', ['options' => ['class' => 'col-md-4']])->widget(DatePicker::classname(), [
	                'language' => Yii::$app->language,
	                'options' => ['placeholder' => 'Selecione a Data de Início ...',],
				    'pluginOptions' => [
				        'format' => 'dd-mm-yyyy',
				        'todayHighlight' => true
				    ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data de Início das Inscrições:</b>")
		    ?>

		        <?= $form->field($model, 'datafim', ['options' => ['class' => 'col-md-4']])->widget(DatePicker::classname(), [
	                'language' => Yii::$app->language,
	                'options' => ['placeholder' => 'Selecione a Data de Término ...',],
				    'pluginOptions' => [
				        'format' => 'dd-mm-yyyy',
				        'todayHighlight' => true
				    ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data de Término das Inscrições:</b>")
		    ?>
		    </div>
		    <div class="row">
			    <?= $form->field($model, 'cartarecomendacao', ['options' => ['class' => 'col-md-2']])->widget(SwitchInput::classname(), ['pluginOptions' => [
			    	'size' => 'large',
			        'onText' => 'Sim',
			        'offText' => 'Não',
			    ]])->label("<font color='#FF0000'>*</font> <b>Carta de Recomendação?</b>") ?>
			</div>
		    <div class="row">
			    <?= $form->field($model, 'mestrado', ['options' => ['class' => 'col-md-2']])->widget(SwitchInput::classname(), [
			    	'pluginOptions' => [
			    		'size' => 'large',
				        'onText' => 'Sim',
				        'offText' => 'Não',
			    ]])->label("<font color='#FF0000'>*</font> <b>Mestrado?</b>") ?>
			</div>
			<div class="row" id="divVagasMestrado" style="display:none">
		    	<?= $form->field($model, 'vagas_mestrado', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number', 'maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Vagas para Mestrado:</b>") ?>

		    	<?= $form->field($model, 'cotas_mestrado', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number'])->label("<font color='#FF0000'>*</font> <b>Vagas para Regime de Cotas:</b>") ?>
		    </div>
			<div class="row">
			    <?= $form->field($model, 'doutorado', ['options' => ['class' => 'col-md-2']])->widget(SwitchInput::classname(), [
			    	'pluginOptions' => [
			    	'size' => 'large',
			        'onText' => 'Sim',
			        'offText' => 'Não',
			    ]])->label("<font color='#FF0000'>*</font> <b>Doutorado?</b>") ?>
			</div>

		    <div id="divVagasDoutorado" style="display:none">
		    <div class ="row">

		    	<?= $form->field($model, 'vagas_doutorado', ['options' => ['class' => 'col-md-2']])->textInput(['type' => 'number', 'maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Vagas para Doutorado:</b>") ?>

		    	<?= $form->field($model, 'cotas_doutorado', ['options' => ['class' => 'col-md-2']])->textInput(['type' => 'number'])->label("<font color='#FF0000'>*</font> <b>Vagas para Regime de Cotas:</b>") ?>

			</div>

			<div class = "row">

			    <?= $form->field($model, 'cartaorientador', ['options' => ['class' => 'col-md-2']])->widget(SwitchInput::classname(), [
			    	'pluginOptions' => [
			    		'size' => 'large',
				        'onText' => 'Sim',
				        'offText' => 'Não',
			    ]])->label("<font color='#FF0000'>*</font> <b>Carta Orientador?</b>") ?>


		     </div>
		    </div>

		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Alterar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
