<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Cadastro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['index'], ['class' => 'btn btn-warning']) ?>    
    <br><br>
    <p>Entre com os seguintes dados para cadastro no sistema do PPGI: </p>
    
        <div style= "text-align:right">
            <font color='#FF0000'>*</font> Campos Obrigatórios
        </div>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'nome')->label("<font color='#FF0000'>*</font> <b>Nome Completo:</b>") ?>

                <?= $form->field($model, 'username')->widget(MaskedInput::className(), [
                'mask' => '999.999.999-99'])->label("<font color='#FF0000'>*</font> <b>CPF:</b>") ?>   

                <?= $form->field($model, 'email')->label("<font color='#FF0000'>*</font> <b>E-mail:</b>") ?>

                <?= $form->field($model, 'password')->passwordInput()->label("<font color='#FF0000'>*</font> <b>Senha:</b>")  ?>

                <?= $form->field($model, 'password_repeat')->passwordInput()->label("<font color='#FF0000'>*</font> <b>Repetir Senha:</b>")  ?>

                <div class="form-group">
                    <?= Html::submitButton('Cadastrar-se', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
