<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recomendacoes */

$this->title = 'Create Recomendacoes';
$this->params['breadcrumbs'][] = ['label' => 'Recomendacoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recomendacoes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
