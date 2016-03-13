<?php

use yii\helpers\Html;

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
