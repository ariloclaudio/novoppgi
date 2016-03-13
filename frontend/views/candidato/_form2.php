<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Collapse;
use yii\bootstrap\Modal;

$uploadRealizados = 0;
$uploadXML = 0;

if(count($itensPeriodicos) + count($itensConferencias) > 0){
    $uploadXML = 1;
    $hidePublicacoes = 'block';
    $hideInputPublicacoes = 'none';
}else{
    $hidePublicacoes = 'none';
    $hideInputPublicacoes = 'block';
}

$labelHistorico = "<font color='#FF0000'>*</font> <b>Histórico Escolar (mesmo que incompleto para os formandos):</b><br>Arquivo contendo seu Histórico:";
if(isset($model->historico)){
    $labelHistorico .= "<a target='resource window' href=".$model->diretorio.$model->historico."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados = 1;
}else{
    $labelHistorico.= " <i>Nenhum arquivo de histórico carregado.</i>";
}

$labelCurriculum = "<font color='#FF0000'>*</font> <b>Curriculum Vittae PDF (no formato Lattes - http://lattes.cnpq.br):</b><br>Arquivo contendo seu Curriculum:";
if(isset($model->curriculum)){
    $labelCurriculum .= "<a target='resource window' href=".$model->diretorio.$model->curriculum."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados += 2;
}else{
    $labelCurriculum .= " <i>Nenhum arquivo de Curriculum carregado.</i>";
}

if($model->instituicaoacademica2 == ""){
    $hideInstituicao2 = 'none';
}else{
    $hideInstituicao2 = 'block';
}

if($model->instituicaoacademica3 == ""){
    $hideInstituicao3 = 'none';
}else{
    $hideInstituicao3 = 'block';
}

?>
<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <input type="hidden" id = "form_hidden" value ="passo_form_2"/>
        <input type="hidden" id = "form_upload" value = '<?=$uploadRealizados?>' />
        <input type="hidden" id = "form_uploadxml" value = '<?= $uploadXML ?>' />
        

    <div style="clear: both;"><legend>Curso de Graduação</legend></div>

    <div class="row">
        <?= $form->field($model, 'cursograd', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Curso:</b>") ?>

        <?= $form->field($model, 'instituicaograd', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição:</b>") ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'egressograd', ['options' => ['class' => 'col-md-3']])->widget(MaskedInput::className(), [
    'mask' => '9999'])->label("<font color='#FF0000'>*</font> <b>Ano de Egresso:</b>") ?>
    </div>
    
    <div style="clear: both;"><legend>Curso de Pós-Graduação Stricto-Senso</legend></div>

    <div class="row">
        <?= $form->field($model, 'cursopos', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])?>

        <?= $form->field($model, 'tipopos', ['options' => ['class' => 'col-md-6 col-xs-12']])->radioList(['0' => 'Mestrado Acadêmico', '1' => 'Mestrado Profissional', '2' => 'Doutorado']) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'instituicaopos', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])?>

        <?= $form->field($model, 'egressopos',['options' => ['class' => 'col-md-2']] )->widget(MaskedInput::className(), [
        'mask' => '9999']) ?>
    </div>
    
    <?= $form->field($model, 'historicoFile')->FileInput(['accept' => '.pdf'])->label($labelHistorico) ?>

    <?= $form->field($model, 'curriculumFile')->FileInput(['accept' => '.pdf'])->label($labelCurriculum) ?>


    <div style="clear: both;"><legend>Publicações</legend></div>

    <?= $form->field($model, 'publicacoesFile')->FileInput(['accept' => '.xml'])->label("<div><font color='#FF0000'>*</font> <b>Curriculum Vittae XML (no formato Lattes - http://lattes.cnpq.br):</b></div>") ?>


    <div id="divPublicacoes" style="display: <?= $hidePublicacoes ?>;">
        <p>Foram encontradas total de <?= count($itensPeriodicos) + count($itensConferencias) ?> Publicações</p>

        <p><?= Html::button('Periódicos <span class=\'label label-primary\'>'.count($itensPeriodicos).'</span>', ['id' => 'btnPeriodicos', 'class' => 'btn btn-success'])?></p>

        <div id="divPeriodicos" style="display: none;">
            <?php if($hidePublicacoes != 'none')
                    echo  Collapse::widget(['items' => $itensPeriodicos,]);
                else
                    echo "<div>Nenhuma Publicação</div>";
            ?>
        </div>

        <p><?= Html::button('Conferências <span class=\'label label-primary\'>'.count($itensConferencias).'</span>', ['id' => 'btnConferencias', 'class' => 'btn btn-success']); ?></p>
        <div id="divConferencias" style="display: none;">
            <?php
                if($hidePublicacoes != 'none')
                    echo Collapse::widget(['items' => $itensConferencias,]);
                else
                    echo "<div>Nenhuma Publicação</div>";
            ?> 
        </div>
    </div>
    
    <div style="clear: both;"><legend>Experiência Acadêmica</b> (Monitoria, PIBIC, PET, Instutor, Professor)</legend></div>

    <div class="row">
        <?= $form->field($model, 'instituicaoacademica1', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'atividade1', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'periodoacademico1', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
    </div>
    
    
    <div class="row" id="divInstituicao2" style="display: <?=$hideInstituicao2?>;">
        <?= $form->field($model, 'instituicaoacademica2', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'atividade2', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'periodoacademico2', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
    </div>
    
   
   <div class="row" id="divInstituicao3" style="display: <?=$hideInstituicao3?>;">
        <?= $form->field($model, 'instituicaoacademica3', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'atividade3', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'periodoacademico3', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
    </div>
    <p>
        <?= Html::button("<span class='glyphicon glyphicon-plus'></span>", ['id' => 'maisInstituicoes', 'class' => 'btn btn-default btn-lg btn-success']); ?>
    </p>
    
    <div class="form-group">
        <p><?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'name' => 'salvar']) ?></p>
        <p><?= Html::submitButton('Salvar e Continuar', ['class' => 'btn btn-success', 'name' => 'enviar']) ?></p>
    </div>

    <?php ActiveForm::end(); ?>

</div>
