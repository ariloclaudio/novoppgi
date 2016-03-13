<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LinhaPesquisa */

$this->title = 'Update Linha Pesquisa: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Pesquisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-pesquisa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
