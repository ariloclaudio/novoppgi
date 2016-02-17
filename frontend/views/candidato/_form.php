<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Curso de Gradua&#231;&#227;o</b></p></div>

    <?= $form->field($model, 'cursograd', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Curso:</b>") ?>

    <?= $form->field($model, 'crgrad', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number', 'maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Coeficiente de Rendimento:</b>") ?>

    <?= $form->field($model, 'instituicaograd', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Instituição:</b>") ?>

    <?= $form->field($model, 'egressograd', ['options' => ['class' => 'col-md-3']])->textInput(['type' => 'number', 'maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Ano de Egresso:</b>") ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Curso de Especialização (ou Aperfeiçoamento)</b></p></div>

    <?= $form->field($model, 'cursoesp', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'instituicaoesp', ['options' => ['class' => 'col-md-5']])->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'egressoesp', ['options' => ['class' => 'col-md-2']])->textInput(['type' => 'number', 'maxlength' => true])?>

    
    <div style="margin-top: 100px; clear: both;"><p align="justify"><b>Curso de Pos-Gradua&#231;&#227;o Stricto-Senso</b></p></div>

    <?= $form->field($model, 'cursopos', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'tipopos', ['options' => ['class' => 'col-md-6', 'style' => 'padding-left: 100px;']])->radioList(['1' => 'Mestrado', '2' => 'Doutorado'], ['style' => 'height: 34px;']) ?>

    <?= $form->field($model, 'instituicaopos', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'mediapos', ['options' => ['class' => 'col-md-3', 'style' => 'padding-left: 100px;']])->textInput(['type' => 'number', 'maxlength' => true]) ?>

    <?= $form->field($model, 'egressopos',['options' => ['class' => 'col-md-2']] )->textInput(['type' => 'number']) ?>


    <?= $form->field($model, 'historicoFile')->FileInput(['accept' => '.pdf'])->label("<font color='#FF0000'>*</font> <b>Histórico Escolar (mesmo que incompleto para os formandos):</b>") ?>

    <div style="margin-top: 100px; clear: both;"><p align="justify"><b>Publicações</b></p></div>

    <?= $form->field($model, 'periodicosinternacionais', ['options' => ['class' => 'col-md-6']])->textInput() ?>

    <?= $form->field($model, 'periodicosnacionais', ['options' => ['class' => 'col-md-6']])->textInput() ?>

    <?= $form->field($model, 'conferenciasinternacionais', ['options' => ['class' => 'col-md-6']])->textInput() ?>

    <?= $form->field($model, 'conferenciasnacionais', ['options' => ['class' => 'col-md-6']])->textInput() ?>



    <?= $form->field($model, 'senha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'fim')->textInput() ?>

    <?= $form->field($model, 'passoatual')->textInput() ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datanascimento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nacionalidade')->textInput() ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estadocivil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orgaoexpedidor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataexpedicao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passaporte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telresidencial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcomercial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcelular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomepai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomemae')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cursodesejado')->textInput() ?>

    <?= $form->field($model, 'regime')->textInput() ?>

    <?= $form->field($model, 'inscricaoposcomp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anoposcomp')->textInput() ?>

    <?= $form->field($model, 'notaposcomp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solicitabolsa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vinculoemprego')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empregador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vinculoconvenio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'convenio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'linhapesquisa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tituloproposta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diploma')->textarea(['rows' => 6]) ?>

    

    <?= $form->field($model, 'motivos')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proposta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'curriculum')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cartaempregador')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comprovantepagamento')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dataformaturagrad')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'dataformaturaesp')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'dataformaturapos')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'instituicaoingles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracaoingles')->textInput() ?>

    <?= $form->field($model, 'nomeexame')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataexame')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notaexame')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empresa1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empresa2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empresa3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoprofissional1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoprofissional2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoprofissional3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instituicaoacademica1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instituicaoacademica2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instituicaoacademica3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atividade1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atividade2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atividade3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoacademico1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoacademico2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'periodoacademico3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resultado')->textInput() ?>

    <?= $form->field($model, 'periodo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
