<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */

$this->title = 'Alterar: ' . ' ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aluno-update">

<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar', 'javascript:window.history.go(-1)', ['class' => 'btn btn-warning']) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'linhasPesquisas' => $linhasPesquisas,
        'orientadores' => $orientadores, 
    ]) ?>

</div>
