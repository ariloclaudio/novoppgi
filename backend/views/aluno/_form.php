<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */
/* @var $form yii\widgets\ActiveForm */
$divRow = "<div class='row' style=\"margin-bottom:10px;\">";
$divFechar = "</div>";

?>

<div class="aluno-form">

<div class="container">

  
    <?php $form = ActiveForm::begin(); ?>

    <?php

    echo $divRow;

        echo $form->field($model, 'nome' , ['options' => ['class' => 'col-md-6']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'email' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'endereco' , ['options' => ['class' => 'col-md-6']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'bairro' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'cidade' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'uf' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'cep' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'datanascimento' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'sexo' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'nacionalidade' , ['options' => ['class' => 'col-md-3']] )->dropDownList(['1' => 'Brasileira', '2' => 'Estrangeira']);

    echo $divFechar;

    //echo $form->field($model, 'estadocivil')->textInput(['maxlength' => true]);

    echo $divRow;
        echo $form->field($model, 'cpf' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'pais' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true])->label("País");

    echo $divFechar;



    //echo $form->field($model, 'rg')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'orgaoexpeditor')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'dataexpedicao')->textInput(['maxlength' => true]);

    echo $divRow;

        echo $form->field($model, 'telresidencial' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        //echo $form->field($model, 'telcomercial')->textInput(['maxlength' => true]);

        echo $form->field($model, 'telcelular' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

    echo $form->field($model, 'nomepai' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true]);

    echo $form->field($model, 'nomemae' , ['options' => ['class' => 'col-md-4']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'regime' , ['options' => ['class' => 'col-md-2']] )->dropDownList(['1' => 'Integral', '2' => 'Parcial']);

        echo $form->field($model, 'bolsista' , ['options' => ['class' => 'col-md-2']] )->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sim',
                'offText' => 'Não',
        ]])->label("Bolsista?");

        echo $form->field($model, 'agencia' , ['options' => ['class' => 'col-md-4']]  )->textInput(['maxlength' => true])->label("Se sim, Qual Agência ?");

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

        echo $form->field($model, 'cursograd' , ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]);

        echo $form->field($model, 'instituicaograd' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        //echo $form->field($model, 'crgrad')->textInput(['maxlength' => true]);

        echo $form->field($model, 'egressograd' , ['options' => ['class' => 'col-md-2']] )->textInput();

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'anoconclusao' , ['options' => ['class' => 'col-md-2']] )->textInput();

        echo $form->field($model, 'dataformaturagrad' , ['options' => ['class' => 'col-md-2']] )->textInput(['maxlength' => true]);

    echo $divFechar;

    //echo $form->field($model, 'idUser')->textInput();

    echo $divRow;

        echo $form->field($model, 'area' , ['options' => ['class' => 'col-md-4']] )->dropDownlist($linhasPesquisas, ['prompt' => 'Selecione uma Linha de Pesquisa']);

        echo $form->field($model, 'curso' , ['options' => ['class' => 'col-md-3']])->dropDownList(['1' => 'Mestrado', '2' => 'Doutorado']);

        echo $form->field($model, 'anoingresso', ['options' => ['class' => 'col-md-4']])->widget(DatePicker::classname(), [
        'language' => Yii::$app->language,
        'options' => ['placeholder' => 'Selecione a Data de Início ...',],
        'pluginOptions' => [
            'format' => 'dd-M-yyyy',
            'todayHighlight' => true
        ]
                ])->label("<font color='#FF0000'>*</font> <b>Data Ingresso</b>");

    echo $divFechar;

    echo $divRow;

        echo $form->field($model, 'matricula' , ['options' => ['class' => 'col-md-3']] )->textInput(['maxlength' => true]);

        echo $form->field($model, 'orientador' , ['options' => ['class' => 'col-md-5']] )->textInput();

    echo $divFechar;

    //echo $form->field($model, 'sede')->textInput(['maxlength' => true]) 

   ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>
