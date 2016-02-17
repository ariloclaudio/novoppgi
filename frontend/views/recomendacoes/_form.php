<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Recomendacoes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recomendacoes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idCandidato')->textInput() ?>

    <?= $form->field($model, 'dataEnvio')->textInput() ?>

    <?= $form->field($model, 'prazo')->textInput() ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instituicaoTitulacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anoTitulacao')->textInput() ?>

    <?= $form->field($model, 'instituicaoAtual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dominio')->textInput() ?>

    <?= $form->field($model, 'aprendizado')->textInput() ?>

    <?= $form->field($model, 'assiduidade')->textInput() ?>

    <?= $form->field($model, 'relacionamento')->textInput() ?>

    <?= $form->field($model, 'iniciativa')->textInput() ?>

    <?= $form->field($model, 'expressao')->textInput() ?>

    <?= $form->field($model, 'ingles')->textInput() ?>

    <?= $form->field($model, 'classificacao')->textInput() ?>

    <?= $form->field($model, 'informacoes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'anoContato')->textInput() ?>

    <?= $form->field($model, 'conheceGraduacao')->textInput() ?>

    <?= $form->field($model, 'conhecePos')->textInput() ?>

    <?= $form->field($model, 'conheceEmpresa')->textInput() ?>

    <?= $form->field($model, 'conheceOutros')->textInput() ?>

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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
