<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Edital */

$this->title = 'Criar Edital';
$this->params['breadcrumbs'][] = ['label' => 'Editals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edital-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
