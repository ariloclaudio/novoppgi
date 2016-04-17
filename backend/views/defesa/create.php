<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Defesa */

$this->title = 'Criar Defesa - '.$titulo;
$this->params['breadcrumbs'][] = ['label' => 'Defesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defesa-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
