<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cadastro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['index'], ['class' => 'btn btn-warning']) ?>    
    <br><br>
    <p>Entre com os seguintes dados para cadastro no sistema do PPGI: </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Cadastrar-se', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
