<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Edital;

/* @var $this yii\web\View */
/* @var $model app\models\Candidato */
/* @var $form ActiveForm */
?>
<div class="candidato-index">

<div class="login-box" style="width:60%;">
    <div class="login-logo">
        <p align="center"><h3> Formulário de Inscrição no Mestrado/Doutorado - PPGI/UFAM</h3></p>
    </div>
<div class="login-box-body">

        <div style="float:inline; border-bottom: solid 1px; text-align: justify; text-justify: inter-word;">
            <h3  style="text-align:left; margin-top: 0px"> <b>Instruções: </b> </h3>
            <ul>
            <li>Preencha os campos <b>e-mail, senha, repetir senha e escolha um edital</b> para cadastrar um novo candidato.</li>

            <li>O campo Repetir Senha deve ser preenchido com o mesmo valor preenchido no campo Senha.</li>

            <li>Após confirmar o cadastro, você será direcionado ao formulário de inscrição.</li>
            </ul>

        </div>

    <div class ="row">
    <div class="col-*-*">
        <table style="text-align:left; border: 0px solid gray; border-radius: 0px; display: block; height: 440px; 
                        overflow-y: scroll; float: left ;min-width:25%;  margin: 15px 15px 15px 15px;">
            <tr>
                <td style="padding:10px 20px 0px 20px">

                    <?php 

                        $tamanho_vetor = sizeof($edital);

                        if($tamanho_vetor != 0){

                        echo "<div style=\" color:red; text-align:center; font-size: 15px; \"> <b> Editais Disponíveis </b> </div>
                        <hr>";


                            for($i=0; $i<$tamanho_vetor; $i++){

                                echo "<div style= \"padding-left:10px; padding-right:10px; border-bottom:solid 1px; padding-bottom:10px; margin-bottom: 10px\">";
                                echo "<div style=\"text-align:left\"> <b> Número do Edital: </b> ".$edital[$i]->numero."<br> </div>";
                                echo "<b> Período das Inscrições:</b> ";
                                echo "<ul style=\"margin-bottom:0px \"> <li> <b> Início: </b>".date("d/m/Y", strtotime($edital[$i]->datainicio))."</li>";
                                echo "<li> <b> Término: </b>".date("d/m/Y", strtotime($edital[$i]->datafim))."</li></ul>";

                                if($edital[$i]->curso == 1){
                                    echo "<b> Vagas para Mestrado: </b><br>";
                                    echo "<ul style=\" margin-bottom:0px \"> <li> <b> Ampla Concorrência: </b>".$edital[$i]->vagas_mestrado."</li>";
                                    echo "<li> <b> Cotista: </b> </b>".$edital[$i]->cotas_mestrado."</li>";
                                    echo "</ul>";
                                }
                                else if ($edital[$i]->curso == 2){
                                    echo "<b> Vagas para Doutorado: </b><br>";
                                    echo "<ul style=\" margin-bottom:0px \"> <li> <b> Ampla Concorrência: </b>".$edital[$i]->vagas_doutorado."</li>";
                                    echo "<li> <b> Cotista: </b> </b>".$edital[$i]->cotas_doutorado."</li>";
                                    echo "</ul>";
                                }
                                else{
                                    echo "<b> Curso: </b> Mestrado e Doutorado <br>";
                                    echo "<b> Vagas para Mestrado: </b><br>";
                                    echo "<ul style=\" margin-bottom:0px \"> <li> <b> Ampla Concorrência: </b>".$edital[$i]->vagas_mestrado."</li>";
                                    echo "<li> <b> Cotista: </b> </b>".$edital[$i]->cotas_mestrado."</li>";
                                    echo "</ul>";
                                    echo "<b> Vagas para Doutorado: </b><br>";
                                    echo "<ul style=\" margin-bottom:0px \"> <li> <b> Ampla Concorrência: </b>".$edital[$i]->vagas_doutorado."</li>";
                                    echo "<li> <b> Cotista: </b> </b>".$edital[$i]->cotas_doutorado."</li>";
                                    echo "</ul>";
                                }
                                
                                echo "<b> Baixar Edital: </b> <a href=../../backend/web/editais/".$edital[$i]->documento." target= '_blank'> Clique aqui</a> <br>";
                                echo "</div>";
                            }
                        }
                        else{
                            echo "<font color='red'> <b> Não há editais disponíveis nesta presente data. </b> </font>";
                        }


                    ?>
                    

                </td>
            </tr>

        </table>

    </div>
    <div class="col-*-*">


            <?php if($tamanho_vetor != 0){ ?>

                <?php $form = ActiveForm::begin(['id' => 'forum_post', 'method' => 'post',]); ?>
                <input type="hidden" id = "form_hidden" value ="passo_form_0"/>

                <table style="border: 0px solid black; min-width: 40%; padding:20px 20px 20px 20px; float:right; margin: 15px 225px 15px 15px;">
                    <tr>
                        <td style="padding:10px 20px 0px 20px">

                            <div style="color:red; text-align:center;font-size:15px; font-weight: bold;"> Formulário de Inscrição</div>
                            <hr>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 20px 0px 20px">

                            <?= $form->field($model, 'email')->label("<font color='#FF0000'>*</font> <b>Email:</b>") ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 20px 0px 20px">

                            <?= $form->field($model, 'senha')->passwordInput(['value' => ""])->label("<font color='#FF0000'>*</font> <b>Senha:</b>") ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 20px 0px 20px">

                            <?= $form->field($model, 'repetirSenha')->passwordInput(['value' => ""])->label("<font color='#FF0000'>*</font> <b>Repetir Senha:</b>") ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0px 20px 10px 20px">

                            <?= $form->field($model, 'idEdital')->dropDownList(ArrayHelper::map($edital,'numero','numero'),['prompt'=>'Selecione o Edital'])->label("<font color='#FF0000'>*</font> <b>Número do Edital:</b>") ; ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;padding-top: 10px">
                            <div class="form-group row">
                            <div class="col-md-6">
                                <div style="display: block; margin-left:25%">
                                    <?= Html::submitButton('Salvar Candidato', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="display:block; margin-right:25%">
                                    <?= Html::a('Voltar',['index'], ['class' => 'btn btn-warning']) ?>
                                </div>
                            </div>

                            </div>
                        </td>
                    </tr>
                </table>
        <?php }?>
             <br>

                <?php ActiveForm::end(); ?>

    </div>
</div>
</div>

</div><!-- candidato-index -->
