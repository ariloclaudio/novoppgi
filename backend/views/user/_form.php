<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\widgets\SwitchInput;

$perfis = ['1' => 'Administrador', '2' => 'Coordenador', '3' => 'Secretaria', '4' => 'Professor', '5' => 'Aluno'];

?>
<div class="site-signup">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['index'], ['class' => 'btn btn-warning']) ?>    
    <br><br>
    <p>Entre com os seguintes dados para alterar o cadastro no sistema do PPGI: </p>
    
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

                <?= $form->field($model, 'password')->passwordInput()->label("Senha:")  ?>

                <?= $form->field($model, 'password_repeat')->passwordInput()->label("Repetir Senha:")  ?>

                <div style="margin-bottom: 20px;"><b><font color='#FF0000'>*</font> Escolha o(s) perfil(s) correspondente a este usuário</b></div>

                <div class = "row">
                    <?= $form->field($model, 'administrador', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                    ]]) ?>
                </div>
                <div class = "row">
                    <?= $form->field($model, 'coordenador', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                    ]]) ?>
                </div>
                <div class = "row">
                    <?= $form->field($model, 'secretaria', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                    ]])?>
                </div>
                <div class = "row">
                    <?= $form->field($model, 'professor', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                    ]])?>
                </div>
                <div class = "row">
                    <?= $form->field($model, 'aluno', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                    ]]) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton($label, ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
