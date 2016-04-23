<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ferias */

$this->title = 'Registrar Férias';
$this->params['breadcrumbs'][] = ['label' => 'Ferias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if( isset($_GET["ano"]) && isset($_GET["prof"]) && isset($_GET["id"]) ){
	$anoVoltar = $_GET["ano"];
	$profVoltar = $_GET["prof"];
	$idVoltar = $_GET["id"];
}

?>
<div class="ferias-create">

    <p>

        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['detalhar', "id" => $idVoltar , "ano" => $anoVoltar , "prof" => $profVoltar  ], ['class' => 'btn btn-warning']) ?> 
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
