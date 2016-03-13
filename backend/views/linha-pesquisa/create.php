<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LinhaPesquisa */

$this->title = 'Create Linha Pesquisa';
$this->params['breadcrumbs'][] = ['label' => 'Linha Pesquisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-pesquisa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
