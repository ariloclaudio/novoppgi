<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MembrosBanca */

$this->title = 'Alterar Membro: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Membros Bancas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="membros-banca-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
