<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Edital */

$this->title = 'Update Edital: ' . ' ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Editals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'id' => $model->numero]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="edital-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
