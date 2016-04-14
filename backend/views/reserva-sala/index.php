<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReservaSalaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reserva de Salas';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- ENVIAR DATA -->    
<script type="text/javascript">     
    function enviarData(form, dia, mes, ano, qtde) {
        if (qtde == <?php echo $qtdeMaxima; ?>)
            alert('Você não poderá realizar uma nova reserva até o momento! É permitido, apenas, cinco reservas ativas por vez.');
        else {
            form.dia.value = dia;
            form.mes.value = mes;
            form.ano.value = ano;           
            form.task.value = 'verTabelaHorario';
            form.submit();
        }
    }
</script>

<div class="reserva-sala-index">
    <div>
        <?= Html::a('<span class="fa fa-arrow-left"></span> Voltar', ['sala/index'], ['class' => 'btn btn-warning']); ?>

        <?= Html::a('<span class="fa fa-list"></span> Listagem', ['sala/index'], ['class' => 'btn btn-success']); ?>

        <?php if(Yii::$app->user->identity->checarAcesso('secretaria')) { ?>
            <?= Html::a('<span class="fa fa-building"></span> Salas', ['sala/index'], ['class' => 'btn btn-success']); ?>
            
            <?= Html::a('<span class="fa fa-calendar-plus-o"></span> Reservar Período', ['sala/reservarperiodo'], ['class' => 'btn btn-info']); ?>
        <?php } ?>
    </div>
    
    <form method="post" name="formData" action="index.php?option=com_reserva&Itemid=0" class="form-horizontal">

    <?php
        // NAVEGAÇÃO ENTRE OS MESES
        if(empty($data)) {
            $dia = date('d');
            $month = ltrim(date('m'),"0");
            $ano = date('Y');
        } else {
            $dataExplodida = explode('/',$data); // NOVA DATA
            $dia = $dataExplodida[0];
            $month = $dataExplodida[1];
            $ano = $dataExplodida[2];
        }

        if($month==1) { // MES ANTERIOR DE JANEIRO
            $mes_ant = 12;
            $ano_ant = $ano - 1;
        } else {
            $mes_ant = $month - 1;
            $ano_ant = $ano;
        }
        
        if($month==12) { // PROXIMO MES DE DEZEMBRO
            $mes_prox = 1;
            $ano_prox = $ano + 1;
        } else {
            $mes_prox = $month + 1;
            $ano_prox = $ano;
        }

        $hoje = date('j'); // DIA ATUAL
        
        $mesAtual = date('m'); // MES ATUAL
        if ($data) {
            $mesCalendar = explode('/',$data); // MES DO CALENDARIO
            $mesCalendar = $mesCalendar[1];
        } else {
            $mesCalendar = $mesAtual; // EXIBIÇÃO INICIAL DO CALENDÁRIO
        }
        
        // IDENTIFICAR O MES E A QUANTIDADE DE DIAS
        switch($month){
            case 1: $mes = "JANEIRO";
                    $n = 31;
            break;
            case 2: $mes = "FEVEREIRO";
                    $bi = $ano % 4; // VERIFICAÇÃO PARA ANO BISSEXTO (MULTIPLO DE 4)
                    if($bi == 0){
                        $n = 29;
                    }else{
                        $n = 28;
                    }
            break;
            case 3: $mes = "MARÇO";
                    $n = 31;
            break;
            case 4: $mes = "ABRIL";
                    $n = 30;
            break;
            case 5: $mes = "MAIO";
                    $n = 31;
            break;
            case 6: $mes = "JUNHO";
                    $n = 30;
            break;
            case 7: $mes = "JULHO";
                    $n = 31;
            break;
            case 8: $mes = "AGOSTO";
                    $n = 31;
            break;
            case 9: $mes = "SETEMBRO";
                    $n = 30;
            break;
            case 10: $mes = "OUTUBRO";
                    $n = 31;
            break;
            case 11: $mes = "NOVEMBRO";
                    $n = 30;
            break;
            case 12: $mes = "DEZEMBRO";
                    $n = 31;
            break;
        }

        $pdianu = mktime(0,0,0,$month,1,$ano); // PRIMEIRO DIA DO MES
        $dialet = date('D', $pdianu); // ESCOLHE PELO DIA DA SEMANA
        
        // VERIFICA O DIA QUE CAI
        switch($dialet){ 
            case "Sun": $branco = 0; break;
            case "Mon": $branco = 1; break;
            case "Tue": $branco = 2; break;
            case "Wed": $branco = 3; break;
            case "Thu": $branco = 4; break;
            case "Fri": $branco = 5; break;
            case "Sat": $branco = 6; break;
        }            
       
        echo '<div style="width:574px; height:auto; margin:auto;">';
        
        // NOME DO MES
        echo '<div id="safe-mes">';
            echo $mes.'/'.$ano;
        echo '</div>';
        
        // MES ANTERIOR
        echo '<a href="index.php?option=com_reserva&Itemid='.$Itemid.'&task=addReserva&data='.$dia.'/'.$mes_ant.'/'.$ano_ant.'"> <div class="nav"> <i class="icone-chevron-left"></i> Anterior </div> </a>';
        
        // PROXIMO MES
        echo '<a href="index.php?option=com_reserva&Itemid='.$Itemid.'&task=addReserva&data='.$dia.'/'.$mes_prox.'/'.$ano_prox.'"> <div class="nav"> Próximo <i class="icone-chevron-right"></i> </div> </a>';
        
        // DIAS DA SEMANA
        echo '
            <div class="diasNome">Domingo</div>
            <div class="diasNome">Segunda</div>
            <div class="diasNome">Terça</div>
            <div class="diasNome">Quarta</div>
            <div class="diasNome">Quinta</div>
            <div class="diasNome">Sexta</div>
            <div class="diasNome">Sábado</div>';
    
        $dt = 1;
    
        if($branco > 0){
            for($x = 0; $x < $branco; $x++){
                print '<div class="dias diabranco">&nbsp;</div>'; // DIAS EM BRANCO
                $dt++;
            }
        }
    
        // DIAS DO MES
        for($i = 1; $i <= $n; $i++ ){ // FUNÇÃO PARA VERIFICAR RESERVAS
        
            $qtdeReservas = verificarReservas($i, $mesCalendar, $ano); // QUANTIDADE DE RESERVAS DO DIA
        
            if(($i == $hoje) && ($mesAtual == $mesCalendar)){ // DIA ATUAL ?>
                <a href="javascript:enviarData(document.formData,'<?php echo $i; ?>','<?php echo $mesCalendar; ?>','<?php echo $ano; ?>','<?php echo $qtde; ?>')">
                    <?php if ($qtdeReservas) { 
                    
                        // LISTAGEM DAS INFORMAÇÕES DAS RESERVAS
                        $itens = identificarReservas($i, $mesCalendar, $ano); ?>
                        
                        <div class="dias diasContent">                        
                            <span class="diasContentQtde">
                                <?php echo $qtdeReservas.'<span class="txtreserva">reserva(s)</span>'; ?>
                            </span>
                        
                            <p class="hint"> <!-- EXIBE SE HOUVER RESERVA PARA O DIA -->
                                <?php foreach ($itens as $itensReserva) 
                                    echo '<i class="icone-flag icone-white"></i> '
                                    .$itensReserva->nome.': '
                                    .horaBr($itensReserva->horaInicio).' às '.horaBr($itensReserva->horaTermino).' ['
                                    .$itensReserva->name.'] '
                                    .$itensReserva->atividade.'<br />'; ?>
                            </p>
                            
                            <div><b><?php echo $i; ?></b></div>
                        </div>
                        
                    <?php } else { ?>
                       <div class="dias diahoje"><?php echo $i; ?></div>
                    <?php } ?>
                    
                </a>
                
                <?php $dt++;
                
            }elseif($dt == 1){ // DOMINGOS
                echo '<div id="dom" class="dias" style="background-color:#eaeaea;">'.$i.'</div>';
                $dt++;
    
            }else{ // DIAS NORMAIS  ?> 
                <a href="javascript:enviarData(document.formData,'<?php echo $i; ?>','<?php echo $mesCalendar; ?>','<?php echo $ano; ?>','<?php echo $qtde; ?>')">                
                
                    <?php if ($qtdeReservas) { 
                    
                        // LISTAGEM DAS INFORMAÇÕES DAS RESERVAS
                        $itens = identificarReservas($i, $mesCalendar, $ano); ?>
                        
                        <div class="dias diasContent">                        
                            <span class="diasContentQtde">
                                <?php echo $qtdeReservas.'<span class="txtreserva">reserva(s)</span>'; ?>
                            </span>
                        
                            <p class="hint"> <!-- EXIBE SE HOUVER RESERVA PARA O DIA -->
                                <?php foreach ($itens as $itensReserva) 
                                    echo '<i class="icone-flag icone-white"></i> '
                                    .$itensReserva->nome.': '
                                    .horaBr($itensReserva->horaInicio).' às '.horaBr($itensReserva->horaTermino).' ['
                                    .$itensReserva->name.'] '
                                    .$itensReserva->atividade.'<br />'; ?>
                            </p>
                            
                            <?php echo $i; ?>
                        </div>
                        
                    <?php } else { ?>
                       <div class="dias"><?php echo $i; ?></div>
                    <?php } ?>
                    
                   </a>
                <?php $dt++;
            }
    
            if($dt > 7){ // QUEBRA NO SÁBADO
                echo '</br>';
                $dt = 1;
            }
        }
    
        echo '</div>';
    ?>
    
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="dia" value="" />
    <input type="hidden" name="mes" value="" />
    <input type="hidden" name="ano" value="" />    
    
    </form>
    
</div>
