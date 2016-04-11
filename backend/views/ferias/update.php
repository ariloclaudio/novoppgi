<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ferias */

$this->title = 'Editar Férias: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ferias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ferias-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
