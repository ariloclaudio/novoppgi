<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Proposta de Trabalho e Documentos';
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-create">

<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li class="visited first">
      <a href="#">Dados <br> Pessoais</a>
    </li>
    
    <li class="previous visited">Histórico<br>Acadêmico/Profissional</li>
    
    <li class="active">Proposta de Trabalho <br> e Documentos</li>
    
    <li class="next"> Tela de<br> Confirmação</li>
       
  </ul>
  <br><br><br><br><br>

</div>

    <?= $this->render('_form3', [
        'model' => $model,
    ]) ?>

</div>
