<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\StarRating;
use yii\web\JsExpression;

$titulacao = ['1' => 'Mestrado', '2' => 'Doutorado', '3' => 'Epecialização', '4' => 'Graduação', '5' => 'Ensino Médio'];
$atributos = ['1' => '1 - Fraco', '2' => '2 - Regular', '3' => '3 - Bom', '4' => '4 - Muito Bom', '5' => '5 - Excelente', '6' => 'X - Sem Condições de Informar'];

/* @var $this yii\web\View */
/* @var $model app\models\Recomendacoes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recomendacoes-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?= $form->field($model, 'nome', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>

        <?= $form->field($model, 'titulacao', ['options' =>['class' => 'col-md-4']])->dropDownList($titulacao, ['prompt' => 'Selecione uma Titulação'])->label("<font color='#FF0000'>*</font> <b>Titulação:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'instituicaoTitulacao', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição:</b>") ?>

        <?= $form->field($model, 'anoTitulacao', ['options' =>['class' => 'col-md-4']])->textInput()->label("<font color='#FF0000'>*</font> <b>Ano de Titulação:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'instituicaoAtual', ['options' =>['class' => 'col-md-8']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição Atual:</b>") ?>

        <?= $form->field($model, 'cargo', ['options' =>['class' => 'col-md-4']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Cargo Atual:</b>") ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'anoContato', ['options' =>['class' => 'col-md-3']])->textInput()->label("<font color='#FF0000'>*</font> <b>Eu o(a) conheço desde o ano:</b>") ?>

        <?= $form->field($model, 'conheceGraduacao', ['options' =>['class' => 'col-md-2']])->checkBoxList(['1' => 'Curso de Graduação'])->label(false) ?>

        <?= $form->field($model, 'conhecePos', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Curso de Pós-Graduação'])->label(false) ?>

        <?= $form->field($model, 'conheceEmpresa', ['options' =>['class' => 'col-md-2']])->checkBoxList(['1' => 'Empresa'])->label(false) ?>

        <?= $form->field($model, 'conheceOutros', ['options' =>['class' => 'col-md-1']])->checkBoxList(['1' => 'Outros'])->label(false) ?>
    </div>
    <div class="row">
        <div>
            <font color='#FF0000'>*</font> <b>Com relação ao candidato, fui seu:</b>
        </div>
        <div style="margin-top:10px; " class="col-md-12">
            <?= $form->field($model, 'orientador', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Professor Orientador'])->label(false) ?>

            <?= $form->field($model, 'professor', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Professor De Disciplina(s)'])->label(false) ?>

            <?= $form->field($model, 'empregador', ['options' =>['class' => 'col-md-2']])->checkBoxList(['1' => 'Empregador'])->label(false) ?>

            <?= $form->field($model, 'coordenador', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Coordenador de Equipe'])->label(false) ?>

            <?= $form->field($model, 'colegaCurso', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Colega de Curso Superior'])->label(false) ?>

            <?= $form->field($model, 'colegaTrabalho', ['options' =>['class' => 'col-md-3']])->checkBoxList(['1' => 'Colega de Profissão'])->label(false) ?>

            <?= $form->field($model, 'outrasFuncoes', ['options' =>['class' => 'col-md-2']])->checkBoxList(['1' => 'Outras Funções'])->label(false) ?>
        </div>
    </div>
    <div  class="row">
        <p align="justify"><b>Como classifica o candidato quanto aos atributos indicados no quadro abaixo:</b></p>
        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Domínio em sua área de conhecimento cientifico</b>
        </div>
        <?= $form->field($model, 'dominio', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false)  ?>

        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Facilidade de aprendizado capacidade intelectual</b>
        </div>
        <?= $form->field($model, 'aprendizado', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false) ?>

        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Assiduidade, perceverança</b>
        </div>
        <?= $form->field($model, 'assiduidade', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false) ?>

        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Relacionamento com colegas e superiores</b>
        </div>
        <?= $form->field($model, 'relacionamento', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false) ?>

        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Iniciativa, desembaraço, originalidade e liderança</b>
        </div>
        <?= $form->field($model, 'iniciativa', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false) ?>
        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Capacidade de expressão escrita</b>
        </div>
        <?= $form->field($model, 'expressao', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false) ?>
        <div class="col-md-6">
            <font color='#FF0000'>*</font> <b>Conhecimento em inglês</b>
        </div>
        <?= $form->field($model, 'ingles', ['options' =>['class' => 'col-md-5']])->dropDownList($atributos, ['prompt' => 'Selecione um Nível'])->label(false)?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p align="justify"><font color="#FF0000">*</font> <b>Comparando este candidato com outros alunos ou profissionais, com similar n&#237;vel de educa&#231;&#227;o e experi&#234;ncia, que conheceu nos &#250;ltimos 2 anos, classifique a sua aptid&#227;o para realizar estudos avan&#231;ados e pesquisas. O candidato est&#225; entre (indique uma das alternativas):</b></p>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'classificacao')->radioList(['5' => 'os 5% mais aptos', '10' => 'os 10% mais aptos', '30' => 'os 30% mais aptos', '50' => 'os 50% mais aptos'])->label(false) ?>
        </div>
    </div>

    

    <?= $form->field($model, 'informacoes')->textarea(['rows' => 6])->label("<font color='#FF0000'>*</font> <b>Informações:</b>") ?>


    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary', 'name' => 'salvar']) ?>
        <?= Html::submitButton('Enviar Carta', ['class' => 'btn btn-success', 'name' => 'enviar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


    <!-- <?php echo StarRating::widget([
    'name' => 'rating_21',
    'pluginOptions' => [
        'min' => 0,
        'max' => 8,
        'step' => 2,
        //'size' => 'lg',
        'starCaptions' => [
            0 => 'Extremely Poor',
            2 => 'Fraco',
            4 => 'Regular',
            6 => 'Bom',
            8 => 'Muito Bom',
            10 => 'Excelente',
            
        ],
        'starCaptionClasses' => [
            0 => 'text-danger',
            2 => 'text-danger',
            4 => 'text-warning',
            6 => 'text-info',
            8 => 'text-primary',
            10 => 'text-success',
            12 => 'text-success'
        ],
    ],
]);
?> -->
