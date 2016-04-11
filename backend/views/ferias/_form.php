<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Ferias */
/* @var $form yii\widgets\ActiveForm */

$arrayTipoferias = array ("1" => "Oficial", "2" => "Usufruto"); 

?>

<div class="ferias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo')->dropDownlist($arrayTipoferias, ['prompt' => 'Selecione um tipo de Férias'] ) ?>


	        <?= $form->field($model, 'dataSaida', ['options' => ['class' => 'col-md-12']])->widget(DatePicker::classname(), [
	                'language' => Yii::$app->language,
	                'options' => ['placeholder' => 'Selecione a Data de Saída ...',],
				    'pluginOptions' => [
				        'format' => 'dd-mm-yyyy',
				        'todayHighlight' => true
				    ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data Saída:</b>")
		    ?>
		    
	        <?= $form->field($model, 'dataRetorno', ['options' => ['class' => 'col-md-12']])->widget(DatePicker::classname(), [
	                'language' => Yii::$app->language,
	                'options' => ['placeholder' => 'Selecione a Data de Retorno ...',],
				    'pluginOptions' => [
				        'format' => 'dd-mm-yyyy',
				        'todayHighlight' => true
				    ]
		        ])->label("<font color='#FF0000'>*</font> <b>Data Retorno:</b>")
		    ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Férias' : 'Editar Férias', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
