<?php

use yii\helpers\Html;

?>
<div class="candidato-create">

<div class="checkout-wrap">
  <ul class="checkout-bar">

    <li class="visited first">
      <a href="index.php?r=candidato%2Fpasso1">Dados <br> Pessoais</a>
    </li>
    
    <li class="previous visited">
      <a href="index.php?r=candidato%2Fpasso2">Histórico <br> Acadêmico/Profissional</a>
      </li>
    
    <li class="active">Proposta de Trabalho <br> e Documentos</li>
    
    <li class="next"> Tela de<br> Confirmação</li>
       
  </ul>
  <br><br><br><br><br>

</div>

    <?= $this->render('_form3', [
        'model' => $model,
        'linhasPesquisas' => $linhasPesquisas,
    ]) ?>

</div>
