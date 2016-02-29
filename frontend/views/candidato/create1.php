<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Dados Pessoais';
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-create">

            <table border="0" cellpadding="0" cellspacing="2">
            <tbody>
            <tr>
                <td style="width: 4%;"><img src="../web/img/step1_on.gif" border="0" height="36" width="36"></td>
                <td style="width: 18%;"><font size="2"><b> Dados Pessoais</b></font></td>
                <td style="width: 2%;"><img src="../web/img/next.gif" border="0" height="21" width="14"></td>
                <td style="width: 4%;"><img src="../web/img/step2_off.gif" border="0" height="36" width="36"></td>
                <td style="width: 21%;"><font size="2" color="#7f7f7f"><b> Hist&#243;rico Acad&#234;mico/Profissional</b></font></td>
                <td style="width: 2%;"><img src="../web/img/next.gif" border="0" height="21" width="14"></td>
                <td style="width: 4%;"><img src="../web/img/step3_off.gif" border="0" height="36" width="36"></td>
                <td style="width: 21%;"><font size="2" color="#7f7f7f"><b> Proposta de Trabalho e Documentos</b></font></td>
                <td style="width: 2%;"><img src="../web/img/next.gif" border="0" height="21" width="14"></td>
                <td style="width: 4%;"><img src="../web/img/step4_off.gif" border="0" height="36" width="36"></td>
                <td style="width: 18%;"><font size="2" color="#7f7f7f"><b> Tela de Confirma&#231;&#227;o</b></font></td>
            </tr>
            </tbody>
            </table>
            

    <?= $this->render('_form1', [
        'model' => $model,
        'editalCurso' => $editalCurso,
    ]) ?>


</div>
