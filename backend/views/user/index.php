<?php

use yii\helpers\Html;
use yii\grid\GridView;
use xj\bootbox\BootboxAsset;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
?>
<div class="user-index">
    <p>
        <?= Html::a('<span class="fa fa-plus"></span> Adicionar Usuário', ['site/signup'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'nome',
            'username',
            'email:email',
			[   'label' => 'Coordenador PPGI',
                'attribute' => 'coordenador',
				'value' => function ($model) {
                        return $model->coordenador == 1 ? 'Sim' : 'Não';
                },
            ],
			[   'label' => 'Professor',
                'attribute' => 'professor',
				'value' => function ($model) {
                        return $model->professor == 1 ? 'Sim' : 'Não';
                },
            ],
			[   'label' => 'Secretaria',
                'attribute' => 'secretaria',
				'value' => function ($model) {
                        return $model->secretaria == 1 ? 'Sim' : 'Não';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
