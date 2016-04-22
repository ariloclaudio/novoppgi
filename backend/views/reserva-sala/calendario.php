<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\bootstrap\Modal;


$this->title = 'Reserva: '.$modelSala->nome;
$this->params['breadcrumbs'][] = ['label' => 'Reserva de Sala', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
  <p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning']) ?></p>
  <?php
    Modal::begin([
      'header' => '<h2>Reserva de Sala</h2>',
      'id' => 'modal',
      'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
  ?>

      <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
          'events'=> $reservasCalendario,
          'clientOptions' => [
            'allDayDefault' => false,
            'weekends' => true,
            'defaultView' => 'agendaWeek',
            'minTime' => '05:00:00',
            'dayClick' => new JsExpression("function(date, jsEvent, view) {
              var dateStr = date;
              var data = (new Date(dateStr)).toISOString().slice(0, 10);
              var hora = (new Date(dateStr)).toISOString().slice(11, 16);
              $.get('index.php?r=reserva-sala/create', {'sala': '$modelSala->id', 'dataInicio': data,'horaInicio': hora, 'requ': 'AJAX'}, function(data){
                  $('#modal').modal('show')
                  .find('#modalContent')
                  .html(data);
              });

            }"),
            'eventClick' => new JsExpression("function(calEvent, jsEvent, view) {
              window.location.href = 'index.php?r=reserva-sala/view&id='+calEvent.id;
            }"),
        ],
      ));
  ?>
    
</div>
