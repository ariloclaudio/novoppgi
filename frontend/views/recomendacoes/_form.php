<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$titulacao = ['1' => 'Mestrado', '2' => 'Doutorado', '3' => 'Epecialização', '4' => 'Graduação', '5' => 'Ensino Médio']

/* @var $this yii\web\View */
/* @var $model app\models\Recomendacoes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recomendacoes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>

    <?= $form->field($model, 'titulacao', ['options' =>['class' => 'col-md-4']])->dropDownList($titulacao, ['prompt' => 'Selecione uma Titulação'])->label("<font color='#FF0000'>*</font> <b>Titulação:</b>") ?>

    <?= $form->field($model, 'instituicaoTitulacao', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição:</b>") ?>

    <?= $form->field($model, 'anoTitulacao', ['options' =>['class' => 'col-md-4']])->textInput()->label("<font color='#FF0000'>*</font> <b>Ano de Titulação:</b>") ?>

    <?= $form->field($model, 'instituicaoAtual', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição Atual:</b>") ?>

    <?= $form->field($model, 'cargo', ['options' =>['class' => 'col-md-4']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Cargo Atual:</b>") ?>


    <?= $form->field($model, 'anoContato')->textInput() ?>

    <?= $form->field($model, 'conheceGraduacao')->textInput() ?>

    <?= $form->field($model, 'conhecePos')->textInput() ?>

    <?= $form->field($model, 'conheceEmpresa')->textInput() ?>

    <?= $form->field($model, 'conheceOutros')->textInput() ?>



    <?= $form->field($model, 'dominio')->textInput() ?>

    <?= $form->field($model, 'aprendizado')->textInput() ?>

    <?= $form->field($model, 'assiduidade')->textInput() ?>

    <?= $form->field($model, 'relacionamento')->textInput() ?>

    <?= $form->field($model, 'iniciativa')->textInput() ?>

    <?= $form->field($model, 'expressao')->textInput() ?>

    <?= $form->field($model, 'ingles')->textInput() ?>

    <?= $form->field($model, 'classificacao')->textInput() ?>

    <?= $form->field($model, 'informacoes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'outrosLugares')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orientador')->textInput() ?>

    <?= $form->field($model, 'professor')->textInput() ?>

    <?= $form->field($model, 'empregador')->textInput() ?>

    <?= $form->field($model, 'coordenador')->textInput() ?>

    <?= $form->field($model, 'colegaCurso')->textInput() ?>

    <?= $form->field($model, 'colegaTrabalho')->textInput() ?>

    <?= $form->field($model, 'outrosContatos')->textInput() ?>

    <?= $form->field($model, 'outrasFuncoes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary', 'name' => 'salvar']) ?>
        <?= Html::submitButton('Enviar Carta', ['class' => 'btn btn-success', 'name' => 'enviar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
