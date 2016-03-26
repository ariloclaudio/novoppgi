<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aluno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    echo $form->field($model, 'nome')->textInput(['maxlength' => true]);

    echo $form->field($model, 'email')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'senha')->textInput(['maxlength' => true]);

    echo $form->field($model, 'matricula')->textInput(['maxlength' => true]);

    echo $form->field($model, 'area')->textInput();

    echo $form->field($model, 'curso')->textInput();

    echo $form->field($model, 'endereco')->textInput(['maxlength' => true]);

    echo $form->field($model, 'bairro')->textInput(['maxlength' => true]);

    echo $form->field($model, 'cidade')->textInput(['maxlength' => true]);

    echo $form->field($model, 'uf')->textInput(['maxlength' => true]);

    echo $form->field($model, 'cep')->textInput(['maxlength' => true]);

    echo $form->field($model, 'datanascimento')->textInput(['maxlength' => true]);

    echo $form->field($model, 'sexo')->textInput(['maxlength' => true]);

    echo $form->field($model, 'nacionalidade')->textInput();

    //echo $form->field($model, 'estadocivil')->textInput(['maxlength' => true]);

    echo $form->field($model, 'cpf')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'rg')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'orgaoexpeditor')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'dataexpedicao')->textInput(['maxlength' => true]);

    echo $form->field($model, 'telresidencial')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'telcomercial')->textInput(['maxlength' => true]);

    echo $form->field($model, 'telcelular')->textInput(['maxlength' => true]);

    echo $form->field($model, 'nomepai')->textInput(['maxlength' => true]);

    echo $form->field($model, 'nomemae')->textInput(['maxlength' => true]);

    echo $form->field($model, 'regime')->textInput();

    echo $form->field($model, 'bolsista')->textInput(['maxlength' => true]);

    echo $form->field($model, 'agencia')->textInput(['maxlength' => true]);

    echo $form->field($model, 'pais')->textInput(['maxlength' => true]);

    echo $form->field($model, 'status')->textInput();

    echo $form->field($model, 'anoingresso')->textInput(['maxlength' => true]);

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
    echo $form->field($model, 'cursograd')->textInput(['maxlength' => true]);

    echo $form->field($model, 'instituicaograd')->textInput(['maxlength' => true]);

    //echo $form->field($model, 'crgrad')->textInput(['maxlength' => true]);

    echo $form->field($model, 'egressograd')->textInput();

    echo $form->field($model, 'dataformaturagrad')->textInput(['maxlength' => true]);

    echo $form->field($model, 'idUser')->textInput();

    echo $form->field($model, 'orientador')->textInput();

    echo $form->field($model, 'anoconclusao')->textInput();

    echo $form->field($model, 'sede')->textInput(['maxlength' => true]) 

   ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
