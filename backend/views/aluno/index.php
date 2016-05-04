<?php

use yii\helpers\Html;
use yii\grid\GridView;
use xj\bootbox\BootboxAsset;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alunos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-index">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Novo Aluno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
       <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'matricula',
            'nome',
            [   'label' => 'Status',
                'attribute' => 'status',
                'value' => function ($model) {
                    $statusAluno = array (0 => "Aluno Corrente",1 => "Aluno Egresso",2 => "Aluno Desistente",3 => "Aluno Desligado",4 => "Aluno Jubilado",5 => "Aluno com Matrícula Trancada");
                    return $statusAluno[$model->status];
                },
            ],
            [   'label' => 'Linha de Pesquisa',
                'attribute' => 'siglaLinhaPesquisa',
                'format' => 'html',
                'contentOptions' => function ($model){
                  return ['style' => 'background-color: '.$model->corLinhaPesquisa];
                },
                'value' => function ($model){
                  return " <span class='fa ". $model->icone ." fa-lg'/> ".$model->siglaLinhaPesquisa;
                },
            ],
             'email:email',
             'telresidencial',
             'dataingresso',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view} {delete} {update}',
                'buttons'=>[
                  'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Remover o Aluno \''.$model->nome.'\'?',
                                'method' => 'post',
                            ],
                            'title' => Yii::t('yii', 'Remover Edital'),
                    ]);   
                  }
              ]                            
            ],
        ],
    ]); ?>
</div>
