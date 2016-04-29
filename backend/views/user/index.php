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
            [   'label' => 'Telefones',
                'format' => 'html',
                'attribute' => 'telcelular',
                'value' => function ($model){
                  $imagens = '      ';
                  if($model->telcelular) $imagens = "<i class='fa fa-mobile fa-lg' title='".$model->telcelular."' aria-hidden='true'></i>". $imagens;
                  if($model->telresidencial) $imagens = $imagens . "<i class='fa fa-phone fa-lg' title='".$model->telresidencial."' aria-hidden='true'></i>";
                  return $imagens;
                }
            ],
            'perfis',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
