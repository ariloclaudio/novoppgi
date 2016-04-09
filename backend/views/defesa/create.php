<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Defesa */

$this->title = 'Create Defesa';
$this->params['breadcrumbs'][] = ['label' => 'Defesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defesa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
