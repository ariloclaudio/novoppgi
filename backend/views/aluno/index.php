<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alunos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-index">

    <p>
        <?= Html::a('Novo Aluno', ['create'], ['class' => 'btn btn-success']) ?>
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
            [   'label' => 'Linha Pesquisa',
                'attribute' => 'siglaLinhaPesquisa',
            ],
             'email:email',
             'telresidencial',
             'dataingresso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
