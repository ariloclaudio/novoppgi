<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Histórico Acadêmico Profissional';
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-create">

<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li class="visited first">
      <a href="index.php?r=candidato%2Fpasso1">Dados <br> Pessoais</a>
    </li>
    
    <li class="active">
        Histórico<br>Acadêmico/Profissional
    </li>
    
    <li class="next">Proposta de Trabalho <br> e Documentos</li>
    
    <li class="next"> Tela de<br> Confirmação</li>
       
  </ul>
  <br><br><br><br><br>

</div>

    <?= $this->render('_form2', [
        'model' => $model,
        'itensPeriodicos' => $itensPeriodicos,
        'itensConferencias' => $itensConferencias,
    ]) ?>

</div>
