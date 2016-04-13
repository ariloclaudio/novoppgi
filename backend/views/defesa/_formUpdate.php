<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Defesa */
/* @var $form yii\widgets\ActiveForm */

if($model_aluno->curso == 1){
    $arrayCurso = array ("1" => "Mestrado");
}
else{
    $arrayCurso = array ("2" => "Doutorado");   
}


?>

<div class="defesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model_aluno, 'nome')->textInput(['readonly' => true]) ?>

    <?= $form->field($model_aluno, 'curso')->dropDownList($arrayCurso,['readonly' => true]) ?>

    <?= $form->field($model, 'numDefesa')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'tipoDefesa')->textInput(['readonly' => true,'maxlength' => true]) ?>

    <?= $form->field($model, 'conceito')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

		        <?= $form->field($model, 'data', ['options' => []])->widget(DatePicker::classname(), [
	                'language' => Yii::$app->language,
	                'options' => ['placeholder' => 'Selecione a Data de Início ...',],
				    'pluginOptions' => [
				        'format' => 'dd-mm-yyyy',
				        'todayHighlight' => true
				    ]
		        ]);
		    ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resumo')->textarea(['rows' => 13]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Confirmar Alterações', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
