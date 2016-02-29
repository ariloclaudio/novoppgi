<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\MaskedInput;

$ufs = ["AC" => "AC", "AL" => "AL", "AM" => "AM", "AP" => "AP", "BA" => "BA", "CE" => "CE", "DF" => "DF",
"ES" => "ES", "GO" => "GO", "MA" => "MA", "MG" => "MG", "MS" => "MS", "MT" => "MT", "PA" => "PA",
"PB" => "PB", "PE" => "PE", "PI" => "PI", "PR" => "PR", "RJ" => "RJ", "RN" => "RN", "RO" => "RO",
"RR" => "RR", "RS" => "RS", "SC" => "SC", "SE" => "SE", "SP" => "SP", "TO" => "TO"];

$estadoscivil = ['Solteiro(a)' => 'Solteiro(a)', 'Casado(a)' => 'Casado(a)', 'Divorciado(a)' => 'Divorciado(a)', 
'Viúvo(a)' => 'Viúvo(a)', "União Estável" => "União Estável"];

$labelCartaEmpregador = "<b>Carta Do Empregador (Adicionar nova carta. Apenas arquivos PDF):</b><br>Atual Arquivo com a Carta do Empregador:";
if(isset($model->cartaempregador)) $labelCartaEmpregador .= "<a target='resource window' href='documentos/$model->cartaempregador'><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>"; else $labelCartaEmpregador .= " <i>Nenhum arquivo de carta do empregador carregado.<i>";
?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <input type="hidden" id = "form_hidden" value ="passo_form_1"/>

<!-- Inicio da Identificação do Candidato -->
    
    <div style="width: 100%; clear: both;"><p align="justify"><b>Identificação do Candidato</b></p></div>
    <div class ="row">
    <?= $form->field($model, 'nome', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>

    <?= $form->field($model, 'estadocivil', ['options' => ['class' => 'col-md-3']])->dropDownList($estadoscivil, ['prompt' => 'Selecione um estado Civil..'])->label("<font color='#FF0000'>*</font> <b>Estado Civil:</b>") ?>

    <?= $form->field($model, 'sexo', ['options' => ['class' => 'col-md-3']])->radioList(['M' => 'Masculino', 'F' => 'Feminino'], ['style' => 'height: 34px;'])->label("<font color='#FF0000'>*</font> <b>Sexo:</b>") ?>
    </div>
    <div class="col-md-12">
    <div class ="row">
        <?= $form->field($model, 'cep', ['options' => ['class' => 'col-md-4', 'style' => 'padding-left: 0px;']])->widget(MaskedInput::className(), [
    'mask' => '99999-999'])->label("<font color='#FF0000'>*</font> <b>CEP:</b>") ?>

        <?= $form->field($model, 'uf', ['options' => ['class' => 'col-md-4']])->dropDownList($ufs, ['prompt' => 'Selecione UF..'])->label("<font color='#FF0000'>*</font> <b>Estado:</b>") ?>

        <?= $form->field($model, 'cidade', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Cidade:</b>") ?>
    </div>
    </div>
    <div class ="row">
    <?= $form->field($model, 'endereco', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Endereço:</b>") ?>

    <?= $form->field($model, 'bairro', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Bairro:</b>") ?>

    <?= $form->field($model, 'datanascimento', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
    'clientOptions' => ['alias' =>  'date']])->label("<font color='#FF0000'>*</font> <b>Data de Nascimento:</b>")
    ?>
    </div>
    <div class ="row">
    <?= $form->field($model, 'nacionalidade', ['options' => ['class' => 'col-md-12']])->radioList(['1' => 'Brasileira', '2' => 'Estrangeira'])->label("<font color='#FF0000'>*</font> <b>Nacionalidade:</b>") ?>

    <div id="divEstrangeiro" style='display: none;'>
        <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Estrangeira</b></p>
        
        <?= $form->field($model, 'pais', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>País:</b>") ?>

        <?= $form->field($model, 'passaporte', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Passaporte:</b>") ?>
    </div>
    </div>
    <div id="divBrasileiro" style="display: none;">
    <div class="row">
        <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Brasileira</b></p>
        <?= $form->field($model, 'cpf', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
    'mask' => '999.999.999-99'])->label("<font color='#FF0000'>*</font> <div style='display:inline;' id = 'corCPF'><b>CPF:</b> </div>") ?>   
    </div>
    <div class="row" style="margin-left:0px; margin-bottom:10px; ">
            <div id = "errocpf" style="color:#a94442; display:none;"> CPF é campo obrigatório para brasileiros </div>
    </div>
    <div class="row">
        <?= $form->field($model, 'rg', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>RG:</b>") ?>

        <?= $form->field($model, 'orgaoexpedidor', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Orgão Expedidor:</b>") ?>

        <?= $form->field($model, 'dataexpedicao', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
    'clientOptions' => ['alias' =>  'date']])->label("<font color='#FF0000'>*</font> <b>Data de Expedição:</b>")
    ?>
    </div>  
    </div>

<!-- Fim da Identificação do Candidato -->

    <div style="width: 100%; clear: both;"><p align="justify"><b>Telefones de Contato</b></p></div>
    <div class = "row">
    <?= $form->field($model, 'telresidencial', ['options' => ['class' => 'col-md-3']])->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '(99) 99999-9999'])->label("<font color='#FF0000'>*</font> <b>Telefone Residencial:</b>") ?>

    <?= $form->field($model, 'telcomercial', ['options' => ['class' => 'col-md-3', 'style' => 'margin-left: 50px;']])->widget(MaskedInput::className(), [
    'mask' => '(99) 99999-9999']) ?>

    <?= $form->field($model, 'telcelular', ['options' => ['class' => 'col-md-3', 'style' => 'margin-left: 50px;']])->widget(MaskedInput::className(), [
    'mask' => '(99) 99999-9999']) ?>
    </div>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Filiação</b></p></div>
    <div class = "row">
    <?= $form->field($model, 'nomepai', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome do Pai:</b>") ?>

    <?= $form->field($model, 'nomemae', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome da Mãe:</b>") ?>
    </div>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Dados do PosComp</b></p></div>
    <div class = "row">
    <?= $form->field($model, 'inscricaoposcomp', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anoposcomp', ['options' => ['class' => 'col-md-3']])->textInput() ?>

    <?= $form->field($model, 'notaposcomp', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
    </div>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Dados da Inscrição</b></p></div>
    <div class = "row">
    <?php if($editalCurso == 3){ ?>
    <?= $form->field($model, 'cursodesejado', ['options' => ['class' => 'col-md-6']])->radioList(['1' => 'Mestrado', '2' => 'Doutorado'])->label("<font color='#FF0000'>*</font> <b>Curso Desejado:</b>")  ?>
    <?php } ?>

    <?= $form->field($model, 'regime', ['options' => ['class' => 'col-md-6']])->radioList(['1' => 'Integral', '2' => 'Parcial'])->label("<font color='#FF0000'>*</font> <b>Regime de Dedicação:</b>") ?>
    </div>

    <div class = "row">
    <?= $form->field($model, 'vinculoconvenio', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Vinculado a algum Convênio?</b>")  ?>
    
    <?= $form->field($model, 'cotas', ['options' => ['class' => 'col-md-6']])->radioList(['1' => 'Sim', '0' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Cotas?</b>")  ?>
    
    </div>
    <div id="divConvenio" class = "row">
    <?= $form->field($model, 'convenio', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<b>Quais (ex: PICTD)?</b>") ?>
    </div>

    <div class = "row">
        <?= $form->field($model, 'solicitabolsa', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Solicita Bolsa de Estudo?</b>")  ?>

        
        <?= $form->field($model, 'vinculoemprego', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Manterá Vínculo Empregatício?</b>") ?>
    </div>
</div>
    <div id="divVinculo" style="border-radius: 25px; border: 2px solid #73AD21; padding: 20px; width: 100%; height: 100%; display:none">
    <p align="justify"><b>Estes campos n&#227;o s&#227;o obrigat&#243;rios </b> (Se desejado, anexe o arquivo contendo a carta do empregador comprometendo-se a limitar a carga de trabalho do candidato a 24 horas semanais, ou meio expediente de trabalho)</p>

    <?= $form->field($model, 'empregador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cartaempregadorFile')->FileInput(['accept' => '.pdf'])->label($labelCartaEmpregador) ?>
    
    </div>

    <div class="form-group" style="margin-top:10px">

        <?= Html::submitButton($model->isNewRecord ? 'Salvar e Continuar' : 'Update', ['onclick' => 'validacao()','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


