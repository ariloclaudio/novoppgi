<?php
use xj\bootbox\BootboxAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\LinhaPesquisa;
use yii\helpers\ArrayHelper;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);

$this->title = "Proposta de Trabalho e Documentos";


//$linhasPesquisas = ArrayHelper::map(LinhaPesquisa::find()->all(), 'id', 'nome');
//$linhasPesquisas = ['1' => '12'];


$uploadRealizados = 0;

$labelProposta = "<font color='#FF0000'>*</font> <b>Proposta de Trabalho:</b></b><br>Arquivo contendo sua Proposta:";
if(isset($model->proposta)){
    $labelProposta .= "<a target='resource window' href=".$model->diretorio.$model->proposta."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados = 1;
}else{
    $labelProposta .= " <i>Nenhum arquivo com Proposta carregado.</i>";
}

$labelComprovante = "<font color='#FF0000'>*</font> <b>Comprovante de Pagamento da taxa de inscrição (Comprovante emitido por bancos e lotéricas):</b><br>Arquivo contendo seu Comprovante de Pagamento:";
if(isset($model->comprovantepagamento)){
    $labelComprovante .= "<a target='resource window' href=".$model->diretorio.$model->comprovantepagamento."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados += 2;
}else{
    $labelComprovante .= " <i>Nenhum arquivo de Comprovante carregado.</i>";
}

if(!isset($model->cartaNome[0]) || $model->cartaNome[0] == ""){
    $hideCartaRecomendacao0 = 'none';
}else{
    $hideCartaRecomendacao0 = 'block';
}

if(!isset($model->cartaNome[1]) || $model->cartaNome[1] == ""){
    $hideCartaRecomendacao1 = 'none';
}else{
    $hideCartaRecomendacao1 = 'block';
}

if(!isset($model->cartaNome[2]) || $model->cartaNome[2] == ""){
    $hideCartaRecomendacao2 = 'none';
}else{
    $hideCartaRecomendacao2 = 'block';
}

?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <input type='hidden' id = 'form_hidden' value ='passo_form_3'/>
        <input type='hidden' id = 'form_carta' value ='<?= $model->edital->cartarecomendacao ?>'/>
        <input type='hidden' id = 'form_upload' value ='<?= $uploadRealizados ?>'/>


    <div style="clear: both;"><legend>Proposta do Candidato</legend></div>

   <div class="row">
        <?= $form->field($model, 'idLinhaPesquisa', ['options' => ['class' => 'col-md-6']])->dropDownlist($linhasPesquisas, ['prompt' => 'Selecione uma Linha de Pesquisa'])->label("<font color='#FF0000'>*</font> <b>Linha de Pesquisa:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'tituloproposta', ['options' => ['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Titulo da Proposta:</b>") ?>
    </div>

    <?php if($model->edital->cartarecomendacao == 1){ ?>
        <div style="clear: both;"><legend>Carta de Recomendação</legend></div>
        <div class="row">
            <p align="justify" style="padding-left: 10px;">Você precisa apenas preencher corretamente o nome e email das pessoas que devem fornecer as cartas de recomendação. Feito isso, assim que você finalizar e submeter sua inscrição os indicados receberão um email com as instruções de como preencher de forma online sua carta de recomendação. Ao menos 2 nomes são obrigatórios.</p>
        </div>
            
        <div class="row">
            <?= $form->field($model, 'cartaNomeReq1', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome 1:</b>") ?>
            
            <?= $form->field($model, 'cartaEmailReq1', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email 1:</b>") ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'cartaNomeReq2', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome 2:</b>") ?>

            <?= $form->field($model, 'cartaEmailReq2', ['options' => ['class' => 'col-md-6']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email 2:</b>") ?>
        </div>
        <div class="row" id="divCartaRecomendacao0" style="display: <?= $hideCartaRecomendacao0?>">
            <?= $form->field($model, 'cartaNome[0]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 3:</b>") ?>

            <?= $form->field($model, 'cartaEmail[0]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 3:</b>") ?>
        </div>
        <div class="row" id="divCartaRecomendacao1" style="display: <?= $hideCartaRecomendacao1?>">
            <?= $form->field($model, 'cartaNome[1]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 4:</b>") ?>

            <?= $form->field($model, 'cartaEmail[1]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 4:</b>") ?>
        </div>
        <div class="row" id="divCartaRecomendacao2" style="display: <?= $hideCartaRecomendacao2 ?>">
            <?= $form->field($model, 'cartaNome[2]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Nome 5:</b>") ?>    
            
            <?= $form->field($model, 'cartaEmail[2]', ['options' => ['class' => 'col-md-6']])->textInput()->label("<b>Email 5:</b>") ?>
        </div>
        <p>
            <?= Html::button("<span class='glyphicon glyphicon-plus'></span>", ['id' => 'maisCartasRecomendacoes', 'class' => 'btn btn-default btn-lg btn-success']); ?>
        </p>
    <?php } ?>

    <div class="row">

        <?= $form->field($model, 'motivos')->textarea(['rows' => 6, 'id' => 'txtMotivos'])->label("<font color='#FF0000'>*</font> <b> Descreva os motivos que o levaram a se candidatar ao curso (máximo de caracteres: 1000): </b>") ?>
    </div>

    <?= $form->field($model, 'propostaFile')->FileInput(['accept' => '.pdf'])->label($labelProposta) ?>

    <?= $form->field($model, 'comprovanteFile')->FileInput(['accept' => '.pdf'])->label($labelComprovante) ?>

     <div style="clear: both;"><legend>Declaração de Veracidade de Informações</legend></div>
     <div align="justify">

     <?= $form->field($model, 'declaracao')->checkBoxList(['1' => 'Declaro a veracidade das informações fornecidas neste formulário e nos documentos enviados, e desde já autorizo a verificação dos dados.'])->label(false) ?>
     
     </div>
    <p>
    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'salvar']) ?>
    </div>
    </p>
    

    <div class="form-group">
        <?= Html::submitButton('Salvar e Finalizar', ['class' => 'btn btn-success', 
            'data' => [
                'confirm' => 'Finalizar Inscrição? Após esse passo seus dados serão submetidos para avaliação e não poderão ser alterados.',
            ],'name' => 'finalizar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
