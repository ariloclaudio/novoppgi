<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\bootstrap\Button;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Defesa */
/* @var $form yii\widgets\ActiveForm */


if ($model->curso == "Doutorado" && $titulo == "Qualificação 1"){
    $required = 0;
}
else {
    $required = 1;
}

?>



<input type="hidden" id = "membrosObrigatorios" value = <?php echo $required; ?> />

<div class="defesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data', ['options' => []])->widget(DatePicker::classname(), [
        'language' => Yii::$app->language,
        'options' => ['placeholder' => 'Selecione a Data da Defesa ...',],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]
    ])->label("<font color='#FF0000'>*</font> <b>Data da Defesa: </b>")
?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'local')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resumo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'examinador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emailExaminador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'previa')->FileInput(['accept' => '.pdf'])->label("Prévia (PDF)"); ?>

    <?php if ($required == 1){ ?>

            <?= $form->field($model, 'membrosBancaInternos')->widget(Select2::classname(), [
                'data' => $membrosBancaInternos,
                'value' => $model->membrosBancaInternos,
                'language' => 'pt-BR',
                'options' => [
                'placeholder' => 'Selecione os membros internos ...', 'multiple' => true,],
            ]);

            ?>

            <?= $form->field($model, 'membrosBancaExternos')->widget(Select2::classname(), [
                'data' => $membrosBancaExternos,
                'value' => $model->membrosBancaExternos,
                'language' => 'pt-BR',
                'options' => [
                'id' => 'idsMembrosBancaInternos',
                'placeholder' => 'Selecione os membros externos ...', 'multiple' => true,],
            ]);

            ?>

    <?php } ?>

<br><br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Salvar Alterações', ['onclick' => 'alertar()' ,  'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
