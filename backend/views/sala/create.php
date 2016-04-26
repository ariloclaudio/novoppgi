<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sala */

$this->title = 'Nova Sala';
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sala-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
