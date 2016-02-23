<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Realizar Cadastro';
$this->params['breadcrumbs'][] = ['label' => 'Candidatos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-create">

    <?= $this->render('_form0', [
        'model' => $model,
    ]) ?>


</div>