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

            <li>Após confirmar o cadastro, você será direcionado ao formulário de inscrição. Você pode retornar ao formulário sempre que desejar usando o seu e-mail e senha informados abaixo.</li>
            </ul>

        </div>

    <div class ="row">
    <div class="col-*-*">
        <table style="align-text:center; border: 0px solid gray; border-radius: 0px; display: block; height: 440px; 
                        overflow-y: scroll; float: left ;width:51%;  margin: 15px 15px 15px 15px;">
            <tr>
                <td style="width: 500px; padding:10px 20px 0px 20px">

                    <?php 

                        $tamanho_vetor = sizeof($edital);

                        if($tamanho_vetor != 0){

                        echo "<div style=\" color:red; text-align:center; font-size: 15px; \"> <b> Editais Disponíveis </b> </div>
                        <hr>";


                            for($i=0; $i<$tamanho_vetor; $i++){

                                echo "<b> Numero do edital: </b> ".$edital[$i]->numero."<br>";
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
                                echo "<hr>";
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

                <table style="border-left: 0px solid black; width: 44%;
                padding:20px 20px 20px 20px; margin: 15px 15px 15px 15px; ">
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
                        <td style="text-align:center;padding-top: 15px">
                            <div class="form-group">
                                <?= Html::submitButton('Salvar Candidato', ['class' => 'btn btn-success']) ?>
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
