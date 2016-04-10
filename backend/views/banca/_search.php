<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BancaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banca-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idAluno') ?>

    <?= $form->field($model, 'idMembro') ?>

    <?= $form->field($model, 'nomeMembro') ?>

    <?= $form->field($model, 'instituicaoMembro') ?>

    <?php // echo $form->field($model, 'funcao') ?>

    <?php // echo $form->field($model, 'tipoDefesa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
