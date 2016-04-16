<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BancaControleDefesas */

$this->title = 'Create Banca Controle Defesas';
$this->params['breadcrumbs'][] = ['label' => 'Banca Controle Defesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banca-controle-defesas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
