<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */
/* @var $form yii\widgets\ActiveForm */
$divRow = "<div class='row' style=\"margin-bottom:10px;\">";
$divFechar = "</div>";

$ufs = ["AC" => "AC", "AL" => "AL", "AM" => "AM", "AP" => "AP", "BA" => "BA", "CE" => "CE", "DF" => "DF",
"ES" => "ES", "GO" => "GO", "MA" => "MA", "MG" => "MG", "MS" => "MS", "MT" => "MT", "PA" => "PA",
"PB" => "PB", "PE" => "PE", "PI" => "PI", "PR" => "PR", "RJ" => "RJ", "RN" => "RN", "RO" => "RO",
"RR" => "RR", "RS" => "RS", "SC" => "SC", "SE" => "SE", "SP" => "SP", "TO" => "TO"];

?>

<div class="aluno-form">

<div class="container">

  
    <?php $form = ActiveForm::begin(); ?>

    <?php

    echo $divRow;

        echo $form->field($model, 'nome' , ['options' => ['class' => 'col-md-6']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>");

        echo $form->field($model, 'datanascimento', ['options' => ['class' => 'col-md-2']])->widget(MaskedInput::className(), ['clientOptions' => 
            ['alias' =>  'date']])->label("<font color='#FF0000'>*</font> <b>Data de Nascimento:</b>");

        echo $form->field($model, 'sexo', ['options' => ['class' => 'col-md-2']])->radioList(['M' => 'Masculino', 'F' => 'Feminino'])->label("<font color='#FF0000'>*</font> <b>Sexo:</b>");

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'cep', ['options' => ['class' => 'col-md-2']])->widget(MaskedInput::className(), [
    'mask' => '99999-999'])->label("<font color='#FF0000'>*</font> <b>CEP:</b>");

        echo $form->field($model, 'uf', ['options' => ['class' => 'col-md-2']])->dropDownList($ufs, ['prompt' => 'Selecione UF..'])->label("<font color='#FF0000'>*</font> <b>Estado:</b>");

        echo $form->field($model, 'cidade' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Cidade:</b>");

        echo $form->field($model, 'bairro' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Bairro:</b>");

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'endereco' , ['options' => ['class' => 'col-md-6']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Endereço:</b>");        

        echo $form->field($model, 'email' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Email:</b>");

    echo $divFechar;

    echo $divRow;        

        echo $form->field($model, 'nacionalidade', ['options' => ['class' => 'col-md-12']])->radioList(['1' => 'Brasileira', '2' => 'Estrangeira'])->label("<font color='#FF0000'>*</font> <b>Nacionalidade:</b>"); ?>

        <div id="divEstrangeiro" style='display: none;'>
            <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Estrangeira</b></p>
            
            <?= $form->field($model, 'pais', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>País:</b>") ?>
        </div>
        <div id="divBrasileiro" style="display: none;">
            <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Brasileira</b></p>
            <?= $form->field($model, 'cpf', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
        'mask' => '999.999.999-99'])->label("<font color='#FF0000'>*</font> <div style='display:inline;' id = 'corCPF'><b>CPF:</b> </div>") ?>   
            <div id = "errocpf" style="color:#a94442; display:none;"> CPF é campo obrigatório para brasileiros </div>
        </div>
    
    <?php
    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'telresidencial', ['options' => ['class' => 'col-md-3']])->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '(99) 99999-9999'])->label("<font color='#FF0000'>*</font> <b>Telefone Principal:</b>");

        echo $form->field($model, 'telcelular', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
            'mask' => '(99) 99999-9999'])->label("Telefone Alternativo:");

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'nomepai' , ['options' => ['class' => 'col-md-5']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'nomemae' , ['options' => ['class' => 'col-md-5']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'regime', ['options' => ['class' => 'col-md-3']])->radioList(['1' => 'Integral', '2' => 'Parcial'])->label("<font color='#FF0000'>*</font> <b>Regime de Dedicação:</b>");

        echo $form->field($model, 'bolsista' , ['options' => ['class' => 'col-md-2']] )->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sim',
                'offText' => 'Não',
        ]])->label("Bolsista?");

        echo "<div id='divAgencia' style='display: none;'>";
        echo $form->field($model, 'agencia' , ['options' => ['class' => 'col-md-4']]  )->textInput(['maxlength' => true])->label("Qual Agência ?");
        echo "</div>";

    echo $divFechar;

        //echo $form->field($model, 'status')->textInput();

    /*

    echo $form->field($model, 'idiomaExameProf')->textInput(['maxlength' => true]);

    echo $form->field($model, 'conceitoExameProf')->textInput(['maxlength' => true]);

    echo $form->field($model, 'dataExameProf')->textInput(['maxlength' => true]);

    echo $form->field($model, 'tituloQual2')->textInput(['maxlength' => true]);

    echo $form->field($model, 'dataQual2')->textInput(['maxlength' => true]);

    echo $form->field($model, 'conceitoQual2')->textInput(['maxlength' => true]);

    echo $form->field($model, 'tituloTese')->textInput(['maxlength' => true]);

    echo $form->field($model, 'dataTese')->textInput(['maxlength' => true]);

    echo $form->field($model, 'conceitoTese')->textInput(['maxlength' => true]);

    echo $form->field($model, 'horarioQual2')->textInput(['maxlength' => true]);

    echo $form->field($model, 'localQual2')->textInput(['maxlength' => true]);

    echo $form->field($model, 'resumoQual2')->textarea(['rows' => 6]);

    echo $form->field($model, 'horarioTese')->textInput(['maxlength' => true]);

    echo $form->field($model, 'localTese')->textInput(['maxlength' => true]);

    echo $form->field($model, 'resumoTese')->textarea(['rows' => 6]);

    echo $form->field($model, 'tituloQual1')->textInput(['maxlength' => true]);

    echo $form->field($model, 'numDefesa')->textInput();

    echo $form->field($model, 'dataQual1')->textInput(['maxlength' => true]);

    echo $form->field($model, 'examinadorQual1')->textInput(['maxlength' => true]);

    echo $form->field($model, 'conceitoQual1')->textInput(['maxlength' => true]);
*/

    echo $divRow;

        echo $form->field($model, 'cursograd' , ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]);

        echo $form->field($model, 'instituicaograd' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true]);

        //echo $form->field($model, 'crgrad')->textInput(['maxlength' => true]);

        echo $form->field($model, 'egressograd' , ['options' => ['class' => 'col-md-2']] )->textInput();

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'anoconclusao' , ['options' => ['class' => 'col-md-3']] )->textInput(['type' => 'number']);

        echo $form->field($model, 'dataformaturagrad' , ['options' => ['class' => 'col-md-2']] )->widget(MaskedInput::className(), ['clientOptions' => 
            ['alias' =>  'date']]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'matricula' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Matricula:</b>");

        echo $form->field($model, 'orientador' , ['options' => ['class' => 'col-md-4']] )->textInput()->label("<font color='#FF0000'>*</font> <b>Orientador:</b>");

        echo $form->field($model, 'anoingresso', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number'])->label("<font color='#FF0000'>*</font> <b>Ano de Ingresso:</b>");

    echo $divFechar;

    echo $divRow;

    echo $form->field($model, 'curso', ['options' => ['class' => 'col-md-3']])->radioList(['1' => 'Mestrado', '2' => 'Doutorado'])->label("<font color='#FF0000'>*</font> <b>Curso:</b>");

    echo $form->field($model, 'area' , ['options' => ['class' => 'col-md-4']] )->dropDownlist($linhasPesquisas, ['prompt' => 'Selecione uma Linha de Pesquisa'])->label("<font color='#FF0000'>*</font> <b>Linha de Pesquisa:</b>");

    echo $divFechar;

   ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>
