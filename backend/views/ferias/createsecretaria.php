<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ferias */

if( isset($_GET["ano"]) && isset($_GET["prof"]) && isset($_GET["id"]) ){
	$anoVoltar = $_GET["ano"];
	$profVoltar = $_GET["prof"];
	$idVoltar = $_GET["id"];
}


$this->title = 'Registrar Férias';
$this->params['breadcrumbs'][] = ['label' => 'Solicitações de Férias', 'url' => ['listartodos' , "ano" => $_GET["ano"]]];
$this->params['breadcrumbs'][] = ['label' => 'Detalhes de Férias', 'url' => ['detalhar' , "id" => $idVoltar , "ano" => $anoVoltar , "prof" => $profVoltar ]];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="ferias-create">

    <p>

        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['detalhar', "id" => $idVoltar , "ano" => $anoVoltar , "prof" => $profVoltar  ], ['class' => 'btn btn-warning']) ?> 
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
