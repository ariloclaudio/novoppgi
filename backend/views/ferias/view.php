<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ferias */

$this->title = "Detalhes - Férias";
$this->params['breadcrumbs'][] = ['label' => 'Ferias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ferias-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'idusuario',
            'nomeusuario',
            'emailusuario:email',
            'tipo',
            'dataSaida',
            'dataRetorno',
            'dataPedido',
        ],
    ]) ?>


    <?php var_dump($model)?>

</div>
