<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$ufs = ["AC" => "AC", "AL" => "AL", "AM" => "AM", "AP" => "AP", "BA" => "BA", "CE" => "CE", "DF" => "DF",
"ES" => "ES", "GO" => "GO", "MA" => "MA", "MG" => "MG", "MS" => "MS", "MT" => "MT", "PA" => "PA",
"PB" => "PB", "PE" => "PE", "PI" => "PI", "PR" => "PR", "RJ" => "RJ", "RN" => "RN", "RO" => "RO",
"RR" => "RR", "RS" => "RS", "SC" => "SC", "SE" => "SE", "SP" => "SP", "TO" => "TO"];

$estadoscivil = ['Solteiro(a)' => 'Solteiro(a)', 'Casado(a)' => 'Casado(a)', 'Divorciado(a)' => 'Divorciado(a)', 
'Viúvo(a)' => 'Viúvo(a)', "União Estável" => "União Estável"];

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidato-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

<!-- Inicio da Identificação do Candidato -->

    <div style="width: 100%; clear: both;"><p align="justify"><b>Identificação do Candidato</b></p></div>

    <?= $form->field($model, 'nome', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>") ?>

    <?= $form->field($model, 'estadocivil', ['options' => ['class' => 'col-md-3']])->dropDownList($estadoscivil, ['prompt' => 'Selecione um estado Civil..'])->label("<font color='#FF0000'>*</font> <b>Estado Civil:</b>") ?>

    <?= $form->field($model, 'sexo', ['options' => ['class' => 'col-md-3']])->radioList(['M' => 'Masculino', 'F' => 'Feminino'], ['style' => 'height: 34px;'])->label("<font color='#FF0000'>*</font> <b>Sexo:</b>") ?>

    <div class="col-md-12">
        <?= $form->field($model, 'cep', ['options' => ['class' => 'col-md-4', 'style' => 'padding-left: 0px;']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>CEP:</b>") ?>

        <?= $form->field($model, 'uf', ['options' => ['class' => 'col-md-4']])->dropDownList($ufs, ['prompt' => 'Selecione UF..'])->label("<font color='#FF0000'>*</font> <b>Estado:</b>") ?>

        <?= $form->field($model, 'cidade', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Cidade:</b>") ?>
    </div>

    <?= $form->field($model, 'endereco', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Endereço:</b>") ?>

    <?= $form->field($model, 'bairro', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Bairro:</b>") ?>

    <?= $form->field($model, 'datanascimento', ['options' => ['class' => 'col-md-3']])->widget(DatePicker::classname(), [
        'pluginOptions' => [
            'format' => 'dd/mm/yyyy',
            'autoclose'=>true
        ]
    ])->label("<font color='#FF0000'>*</font> <b>Data de Nascimento:</b>")
    ?>

    <?= $form->field($model, 'nacionalidade', ['options' => ['class' => 'col-md-12']])->radioList(['1' => 'Brasileira', '2' => 'Estrangeira'])->label("<font color='#FF0000'>*</font> <b>Nacionalidade:</b>") ?>

    <div id="divEstrangeiro" style='display: none;'>
        <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Estrangeira</b></p>
        
        <?= $form->field($model, 'pais', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>País:</b>") ?>

        <?= $form->field($model, 'passaporte', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Passaporte:</b>") ?>
    </div>

    <div id="divBrasileiro" style="display: none;">
        <p align="justify" class="col-md-12"><b>Estes campos são obrigatórios para candidatos com nacionalidade Brasileira</b></p>

        <?= $form->field($model, 'cpf', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>CPF:</b>") ?>   

        <?= $form->field($model, 'rg', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>RG:</b>") ?>

        <?= $form->field($model, 'orgaoexpedidor', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Orgão Expedidor:</b>") ?>

        <?= $form->field($model, 'dataexpedicao', ['options' => ['class' => 'col-md-3']])->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',
                'autoclose'=>true
            ]
        ])->label("<font color='#FF0000'>*</font> <b>Data de Expedição:</b>")
    ?>
    </div>

<!-- Fim da Identificação do Candidato -->
    
    <div style="width: 100%; clear: both;"><p align="justify"><b>Telefones de Contato</b></p></div>

    <?= $form->field($model, 'telresidencial', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Telefone Residencial:</b>") ?>

    <?= $form->field($model, 'telcomercial', ['options' => ['class' => 'col-md-3', 'style' => 'margin-left: 50px;']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcelular', ['options' => ['class' => 'col-md-3', 'style' => 'margin-left: 50px;']])->textInput(['maxlength' => true]) ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Filiação</b></p></div>

    <?= $form->field($model, 'nomepai', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome do Pai:</b>") ?>

    <?= $form->field($model, 'nomemae', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome da Mãe:</b>") ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Dados do PosComp</b></p></div>

    <?= $form->field($model, 'inscricaoposcomp', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anoposcomp', ['options' => ['class' => 'col-md-3']])->textInput() ?>

    <?= $form->field($model, 'notaposcomp', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>

    <div style="width: 100%; clear: both;"><p align="justify"><b>Dados da Inscrição</b></p></div>

    <?= $form->field($model, 'cursodesejado', ['options' => ['class' => 'col-md-6']])->radioList(['1' => 'Mestrado' , '2' => 'Doutorado'])->label("<font color='#FF0000'>*</font> <b>Curso Desejado:</b>")  ?>

    <?= $form->field($model, 'regime', ['options' => ['class' => 'col-md-6']])->radioList(['1' => 'Integral', '2' => 'Parcial'])->label("<font color='#FF0000'>*</font> <b>Regime de Dedicação:</b>") ?>

    <?= $form->field($model, 'vinculoconvenio', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Vinculado a algum Convênio?</b>")  ?>

    <?= $form->field($model, 'convenio', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label("<b>Quais (ex: PICTD)?</b>") ?>

    <?= $form->field($model, 'solicitabolsa', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Solicita Bolsa de Estudo?</b>")  ?>

    
    <?= $form->field($model, 'vinculoemprego', ['options' => ['class' => 'col-md-6']])->radioList(['SIM' => 'Sim', 'NAO' => 'Não'])->label("<font color='#FF0000'>*</font> <b>Manterá Vínculo Empregatício?</b>") ?>

    <div id="divVinculo">
    <p align="justify" class="col-md-12"><b>Estes campos n&#227;o s&#227;o obrigat&#243;rios </b> (Se desejado, anexe o arquivo contendo a carta do empregador comprometendo-se a limitar a carga de trabalho do candidato a 24 horas semanais, ou meio expediente de trabalho)</p>

    <?= $form->field($model, 'empregador', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cartaempregador', ['options' => ['class' => 'col-md-12']])->FileInput(['accept' => '.pdf'])->label("<b>Carta Do Empregador (Adicionar nova carta. Apenas arquivos PDF):</b>") ?>
    </div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar e Continuar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
