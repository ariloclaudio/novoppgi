<?php
use xj\bootbox\BootboxAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\LinhaPesquisa;
use yii\helpers\ArrayHelper;
use kartik\widgets\SwitchInput;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);

$this->title = "Proposta de Trabalho e Documentos";


//$linhasPesquisas = ArrayHelper::map(LinhaPesquisa::find()->all(), 'id', 'nome');
//$linhasPesquisas = ['1' => '12'];


$uploadRealizados = 0;

$labelProposta = "<font color='#FF0000'>*</font> <b>Proposta de Trabalho:</b></b><br>Arquivo contendo sua Proposta:";
if(isset($model->proposta)){
    $labelProposta .= "<a href=index.php?r=candidato/pdf&documento=".$model->proposta."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
    $uploadRealizados = 1;
}else{
    $labelProposta .= " <i>Nenhum arquivo com Proposta carregado.</i>";
}

$labelComprovante = "<font color='#FF0000'>*</font> <b>Comprovante de Pagamento da taxa de inscrição (Comprovante emitido por bancos e lotéricas):</b><br>Arquivo contendo seu Comprovante de Pagamento:";
if(isset($model->comprovantepagamento)){
    $labelComprovante .= "<a href=index.php?r=candidato/pdf&documento=".$model->comprovantepagamento."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a>";
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
        <?= $form->field($model, 'idLinhaPesquisa', ['options' => ['class' => 'col-md-5']])->dropDownlist($linhasPesquisas, ['prompt' => 'Selecione uma Linha de Pesquisa'])->label("<font color='#FF0000'>*</font> <b>Linha de Pesquisa:</b>") ?>

        <?= $form->field($model, 'tituloproposta', ['options' => ['class' => 'col-md-7']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Titulo da Proposta:</b>") ?>
    </div>

    <?php if($model->edital->cartarecomendacao == 1){ ?>
        <div style="clear: both;"><legend>Carta de Recomendação</legend></div>
        <div class="row">
            <p align="justify" style="padding-left: 10px;">Você precisa apenas preencher corretamente o nome e email das pessoas que devem fornecer as cartas de recomendação. Feito isso, assim que você finalizar e submeter sua inscrição os indicados receberão um email com as instruções de como preencher de forma online sua carta de recomendação. Ao menos 2 nomes são obrigatórios.</p>
        </div>
            
        <div class="row">
            <?= $form->field($model, 'cartaNomeReq1', ['options' => ['class' => 'col-md-5']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>
            
            <?= $form->field($model, 'cartaEmailReq1', ['options' => ['class' => 'col-md-5']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email:</b>") ?>
        </div>
        <div class="row">
            <?= $form->field($model, 'cartaNomeReq2', ['options' => ['class' => 'col-md-5']])->textInput()->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>

            <?= $form->field($model, 'cartaEmailReq2', ['options' => ['class' => 'col-md-5']])->textInput()->label("<font color='#FF0000'>*</font> <b>Email:</b>") ?>
        </div>
        <div class="row" id="divCartaRecomendacao0" style="display: <?= $hideCartaRecomendacao0?>">
            <?= $form->field($model, 'cartaNome[0]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Nome:</b>") ?>

            <?= $form->field($model, 'cartaEmail[0]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Email:</b>") ?>

            <?= Html::button("<span class='glyphicon glyphicon-remove'></span>", ['id' => 'removerCartaRecomendacao0', 'class' => 'btn btn-danger col-md-1 col-xs-12', 'style' => 'margin-top: 25px;']); ?>
        </div>
        <div class="row" id="divCartaRecomendacao1" style="display: <?= $hideCartaRecomendacao1?>">
            <?= $form->field($model, 'cartaNome[1]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Nome:</b>") ?>

            <?= $form->field($model, 'cartaEmail[1]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Email:</b>") ?>

            <?= Html::button("<span class='glyphicon glyphicon-remove'></span>", ['id' => 'removerCartaRecomendacao1', 'class' => 'btn btn-danger col-md-1 col-xs-12', 'style' => 'margin-top: 25px;']); ?>
        </div>
        <div class="row" id="divCartaRecomendacao2" style="display: <?= $hideCartaRecomendacao2 ?>">
            <?= $form->field($model, 'cartaNome[2]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Nome:</b>") ?>    
            
            <?= $form->field($model, 'cartaEmail[2]', ['options' => ['class' => 'col-md-5']])->textInput()->label("<b>Email:</b>") ?>

            <?= Html::button("<span class='glyphicon glyphicon-remove'></span>", ['id' => 'removerCartaRecomendacao2', 'class' => 'btn btn-danger col-md-1 col-xs-12', 'style' => 'margin-top: 25px;']); ?>
        </div>
        <p>
            <?= Html::button("<span class='glyphicon glyphicon-plus'></span>", ['id' => 'maisCartasRecomendacoes', 'class' => 'btn btn-default btn-lg btn-success']); ?>
        </p>
    <?php } ?>

    <div class="row">

        <?= $form->field($model, 'motivos')->textarea(['maxlength' => true, 'id' => 'txtMotivos', 'rows' => 6])->label("<font color='#FF0000'>*</font> <b> Descreva os motivos que o levaram a se candidatar ao curso (<span class='caracteres'>1000</span> Caracteres Restantes): </b>") ?>
    </div>

    <div class="row">

    <div style="padding: 3px 3px 3px 3px">
        <?php 
        if(!isset($model->proposta)){
            //echo $form->field($model, 'historicoFile')->FileInput(['accept' => '.pdf'])->label($labelHistorico) ;
            echo "<div style= padding: 3px 3px 3px 3px'> <b>Proposta de Trabalho:</b> 
                Você já fez o upload deste Arquivo, clique no icone ao lado para visualizá-lo: <a href=index.php?r=candidato/pdf&documento=".$model->proposta."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a></b><br> ";
            echo $form->field($model, 'propostaUpload', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sim',
                'offText' => 'Não',
                ]])->label("<font color='#FF0000'>*</font> <b>Deseja mudar o arquivo?</b>");
        }
        else{

            echo $form->field($model, 'propostaFile')->FileInput(['accept' => '.pdf'])->label("<font color='#FF0000'>*</font> <b>Proposta de Trabalho:</b><br>");
        }
        ?>
        <br><br><br>
        <div id="divPropostaFile" style="display: none">
        <br>
        <?= $form->field($model, 'propostaFile')->FileInput(['accept' => '.pdf'])->label(false) ?>
        <div style='border-bottom:solid 1px'> </div>
        <?php echo "</div>"; ?>
        </div>
    </div>

    <br>

    </div>


    <div class="row">

    <div style="padding: 3px 3px 3px 3px">
        <?php 
        if(!isset($model->comprovante)){
            //echo $form->field($model, 'historicoFile')->FileInput(['accept' => '.pdf'])->label($labelHistorico) ;
            echo "<div style= padding: 3px 3px 3px 3px'> <b>Proposta de Trabalho:</b> 
                Você já fez o upload deste Arquivo, clique no icone ao lado para visualizá-lo: <a href=index.php?r=candidato/pdf&documento=".$model->proposta."><img src='img/icon_pdf.gif' border='0' height='16' width='16'></a></b><br> ";
            echo $form->field($model, 'comprovanteUpload', ['options' => ['class' => 'col-md-5']])->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sim',
                'offText' => 'Não',
                ]])->label("<font color='#FF0000'>*</font> <b>Deseja mudar o arquivo?</b>");
        }
        else{

            echo $form->field($model, 'comprovanteFile')->FileInput(['accept' => '.pdf'])->label("<font color='#FF0000'>*</font> <b>Proposta de Trabalho:</b><br>");
        }
        ?>

        <div id="divComprovanteFile" style="display: none">
        <br><br><br><br>
        <?= $form->field($model, 'comprovanteFile')->FileInput(['accept' => '.pdf'])->label(false) ?>
        <div style='border-bottom:solid 1px'> </div>
        <?php echo "</div>"; ?>
        </div>
    </div>

    <br>
    </div>


    <div style="clear: both;"><legend>Declaração de Veracidade de Informações</legend></div>
    <div align="justify">
    <div class="row">
         <?= $form->field($model, 'declaracao')->checkBoxList(['1' => 'Declaro a veracidade das informações fornecidas neste formulário e nos documentos enviados, e desde já autorizo a verificação dos dados.'])->label(false) ?>
    </div>
     </div>
    <p>
    <div class="form-group">
        <?= Html::a('<img src="img/back.gif" border="0" height="32" width="32"><br><b> Passo Anterior</b>', ['candidato/passo2'], ['class' => 'btn btn-default col-md-4']) ?>
        <?= Html::submitButton('<img src="img/save.png" border="0" height="32" width="32"><br><b>Salvar</b>', ['class' => 'btn btn-default col-md-4', 'name' => 'salvar']) ?>

        <?= Html::submitButton('<img src="img/forward.gif" border="0" height="32" width="32"><br><b>Salvar e Finalizar</b>', ['class' => 'btn btn-default col-md-4',
            'data' => [
                'confirm' => 'Finalizar Inscrição? Após esse passo seus dados serão submetidos para avaliação e não poderão ser alterados, sob pena de exclusão do
            Curso.',
            ],'name' => 'finalizar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
