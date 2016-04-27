<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LinhaPesquisa */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Linhas de Pesquisa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-pesquisa-view">
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar', ['index'], ['class' => 'btn btn-warning']) ?>
		<?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Remover Linha de Pesquisa \''. $model->nome.'\'?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nome',
            'sigla',
			'icone',
			[   'label' => 'Cor',
                'attribute' => 'cor',
                'contentOptions' => function ($model){
                  return ['style' => 'background-color: '.$model->cor];
                },
            ],
        ],
    ]) ?>

</div>
