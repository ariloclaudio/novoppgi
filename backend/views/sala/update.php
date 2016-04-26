<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sala */

$this->title = 'Alterar Sala: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="sala-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
