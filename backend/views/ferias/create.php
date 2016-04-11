<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ferias */

$this->title = 'Criar Férias';
$this->params['breadcrumbs'][] = ['label' => 'Ferias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ferias-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
