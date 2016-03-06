<?php
//use xj\bootbox\BootboxAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

//BootboxAsset::register($this);
//BootboxAsset::registerWithOverride($this);

$uploadRealizados = 0;

/*Estático temporariamente*/
$linhasPesquisa = ['1' => 'Banco de Dados e Recuperação de Informação', '2' => 'Sistemas Embarcados e Engenharia de Software', '3' => 'Inteligência Artificial', '4' => 'Visão Computacional e Robótica', '5' => 'Redes e Telecomunicações',  '6' => 'Otimização, Alg. e Complexidade Computacional'];

$labelProposta = "<font color='#FF0000'>*</font> <b>Proposta de Trabalho:</b></b><br>Atual Arquivo com o Curriculum:";
if(isset($model->proposta)){
    $labelProposta .= "<a target='resource window' href=".$model->diretorio.$model->proposta."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados = 1;
}else{
    $labelProposta .= " <i>Nenhum arquivo de Proposta carregado.</i>";
}

$labelComprovante = "<font color='#FF0000'>*</font> <b>Comprovante de Pagamento da taxa de inscrição (Comprovante emitido por bancos e lotéricas):</b><br>Atual Arquivo com o Comprovante:";
if(isset($model->curriculum)){
    $labelComprovante .= "<a target='resource window' href=".$model->diretorio.$model->comprovantepagamento."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados += 2;
}else{
    $labelComprovante .= " <i>Nenhum arquivo de Comprovante carregado.</i>";
}

?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <input type='hidden' id = 'form_upload' value ='passo_form_3'/>
        <input type='hidden' id = 'form_hidden' value ='<?= $model->edital->cartarecomendacao ?>'/>
        <input type='hidden' id = 'form_upload' value ='<?= $uploadRealizados ?>'/>


    <div style="width: 100%; clear: both;"><p align="justify"><b>Proposta do Candidato</b></p></div>

    <?= $form->field($model, 'linhapesquisa', ['options' => ['class' => 'col-md-6']])->dropDownlist($linhasPesquisa, ['prompt' => 'Selecione uma Linha de Pesquisa'])->label("<font color='#FF0000'>*</font> <b>Linha de Pesquisa:</b>") ?>

    <?= $form->field($model, 'tituloproposta', ['options' => ['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Titulo da Proposta:</b>") ?>

    <?php if($model->edital->cartarecomendacao == 1){ ?>
        <div style="width: 100%; clear: both;"><p align="justify"><b>Carta de Recomendação</b></p></div>

        <p align="justify">Você precisa apenas preencher corretamente o nome e email das pessoas que devem fornecer as cartas de recomendação. Feito isso, assim que você finalizar e submeter sua inscrição os indicados receberão um email com as instruções de como preencher de forma online sua carta de recomendação. Ao menos 2 nomes são obrigatórios.</p>
        
        <div class="col-md-12" style="padding-left: 0px;">
            <?= $form->field($model, 'cartaNomeReq1', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome 1:</b>") ?>
        
            <?= $form->field($model, 'cartaEmailReq1', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email 1:</b>") ?>
        </div>
        
        <div class="col-md-12" style="padding-left: 0px;">
        <?= $form->field($model, 'cartaNomeReq2', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome 2:</b>") ?>

        <?= $form->field($model, 'cartaEmailReq2', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email 2:</b>") ?>
        </div>

        <?= $form->field($model, 'cartaNome[0]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 3:</b>") ?>

        <?= $form->field($model, 'cartaEmail[0]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 3:</b>") ?>

        <?= $form->field($model, 'cartaNome[1]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 4:</b>") ?>

        <?= $form->field($model, 'cartaEmail[1]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 4:</b>") ?>
        
        <?= $form->field($model, 'cartaNome[2]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 5:</b>") ?>    
        
        <?= $form->field($model, 'cartaEmail[2]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 5:</b>") ?>

    <?php } ?>

    <?= $form->field($model, 'motivos')->textarea(['rows' => 6])->label("<font color='#FF0000'>*</font> <b>Exposição dos Motivos </b>(Descreva os motivos que o levaram a se candidatar ao curso):") ?>

    <?= $form->field($model, 'propostaFile')->FileInput(['accept' => '.pdf'])->label($labelProposta) ?>

    <?= $form->field($model, 'comprovanteFile')->FileInput(['accept' => '.pdf'])->label($labelComprovante) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'salvar']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar e Continuar', ['class' => 'btn btn-success', 
            'data' => [
                'confirm' => 'Finalizar Inscrição? Após esse passo seus dados serão submetidos para avaliação e não poderão ser alterados.',
            ],'name' => 'finalizar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
