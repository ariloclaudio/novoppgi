<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MembrosBanca */

$this->title = 'Create Membros Banca';
$this->params['breadcrumbs'][] = ['label' => 'Membros Bancas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membros-banca-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
