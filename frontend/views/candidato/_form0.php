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

    <?php $form = ActiveForm::begin(['id' => 'forum_post', 'method' => 'post',]); ?>
    <input type="hidden" id = "form_hidden" value ="passo_form_0"/>

    <table style="border: 1px solid black; height: 425px; overflow-y: scroll; display: block; width: 30%;  margin: 15px 15px 15px 15px; float:left">
        <tr>
            <td style="padding:10px 20px 0px 20px">

                <?php 

                    $tamanho_vetor = sizeof($edital);

                    if($tamanho_vetor != 0){

                    echo "<div style=\" text-align:center; font-size: 15px; \"> <b> Editais Disponíveis </b> </div><hr>";

                        for($i=0; $i<$tamanho_vetor; $i++){

                            echo "<b> Numero: </b> ".$edital[$i]->numero."<br>";

                            echo "<b> Inscrições abertas em: </b> ".date("d/m/Y", strtotime($edital[$i]->datainicio))."<br>";
                            echo "<b> Inscrições encerradas em: </b> ".date("d/m/Y", strtotime($edital[$i]->datafim))."<br>";

                            if($edital[$i]->curso == 1){
                                echo "<b> Curso: </b> Mestrado <br>";
                                echo "<b> Vagas: </b>".$edital[$i]->vagas_mestrado."<br>";
                            }
                            else if ($edital[$i]->curso == 2){
                                echo "<b> Curso: </b> Doutorado <br>";
                                echo "<b> Vagas: </b>".$edital[$i]->vagas_doutorado."<br>";
                            }
                            else{
                                echo "<b> Curso: </b> Mestrado e Doutorado <br>";
                                echo "<b> Vagas para Mestrado: </b>".$edital[$i]->vagas_mestrado."<br>";   
                                echo "<b> Vagas para Doutorado: </b>".$edital[$i]->vagas_doutorado."<br>";   
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
            <?php if($tamanho_vetor != 0){ ?>
                <table style="border: 1px solid black; width: 62%; padding:20px 20px 20px 20px; margin: 15px 15px 15px 15px; float:right;">
                    <tr>
                        <td style="padding:10px 20px 0px 20px">

                            <div style="text-align:center;font-size:15px; font-weight: bold;"> FORMULÁRIO DE INSCRIÇÃO</div>
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
                        <td style="text-align:center">
                            <div class="form-group">
                                <?= Html::submitButton('Salvar Candidato', ['class' => 'btn btn-success']) ?>
                            </div>
                        </td>
                    </tr>
                </table>
        <?php }?>

    <br>

    <?php ActiveForm::end(); ?>

</div><!-- candidato-index -->
