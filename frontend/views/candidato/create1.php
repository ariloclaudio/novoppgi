<?php

use yii\helpers\Html;

$this->title = "Dados Pessoais";
?>

<div class="candidato-create">

<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li class="active">
      <a href="index.php?r=candidato%2Fpasso1">Dados <br> Pessoais</a>
    </li>
    
    <li class="next">Histórico<br>Acadêmico/Profissional</li>
    
    <li class="next">Proposta de Trabalho <br> e Documentos</li>
    
    <li class="next"> Tela de<br> Confirmação</li>
       
  </ul>
  <br><br><br><br><br>

</div>
    <?= $this->render('_form1', [
        'model' => $model,
        'editalCurso' => $editalCurso,
    ]) ?>


</div>
