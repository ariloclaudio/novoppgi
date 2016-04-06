<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Collapse;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);


/* @var $this yii\web\View */
/* @var $searchModel app\models\CandidatosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Candidatos';

$this->params['breadcrumbs'][] = ['label' => 'Editais', 'url' => ['edital/index']];
$this->params['breadcrumbs'][] = ['label' => 'Número: '.Yii::$app->request->get('id'), 
    'url' => ['edital/view','id' => Yii::$app->request->get('id') ]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="candidato-index">

<script>
function goBack() {
    window.history.back();
}
</script>

<?= Html::a('Voltar', ['edital/view', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-warning']) ?>

<?= Html::a(' <span class="glyphicon glyphicon-download"></span> Baixar Documentação ', ['candidatos/downloadscompletos', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-success']) ?>

<h2> Inscrições Finalizadas </h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
            'rowOptions'=> function($model){
                    if($model->resultado === 1) {
                        return ['class' => 'info'];
                    }
                    else if($model->resultado === 0) {
                        return ['class' => 'danger'];
                    }
                    else if($model->cartas_respondidas < 2 && $model->carta_recomendacao == 1){
                        return ['class' => 'warning'];
                    }
                    else{
                        return ['class' => 'success'];
                    }
            },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [   'label' => 'Nº de Inscrição',
                'attribute' => 'id',
                'value' => function ($model) {
                     return $model->idEdital.'-'.str_pad($model->posicaoEdital, 3, "0", STR_PAD_LEFT);;
                },
            ],
             'nome',
             ['attribute' => 'qtd_cartas',
              'label' => 'Cartas Emitidas',
              'visible' => $cartarecomendacao,
              'value' => function ($model){
                return $model->qtd_cartas;
              }
             ],
             ['attribute' => 'cartas_respondidas',
              'label' => 'Cartas Respondidas',
              'visible' => $cartarecomendacao,
              'value' => function ($model){
                       return $model->cartas_respondidas;
              }
             ],
            [   'label' => 'Curso Desejado',
                'attribute' => 'cursodesejado',
                'value' => function ($model) {
                     return $model->cursodesejado == 1 ? 'Mestrado' : 'Doutorado';
                },
            ],
            [   'label' => 'Linha Pesquisa',
                'attribute' => 'nomeLinhaPesquisa',
            ],
            [   'label' => 'Fase',
                'attribute' => 'fase',
                'value' => function ($model) {

                    if($model->resultado === 1){
                        return "Aprovado";
                    }
                    else if($model->resultado === 0){

                        return "Reprovado";
                    }
                    else{
                        return "Não Julgado";
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{download} {view} {aprovar} {reprovar} {reenviar}',
                'buttons'=>[
                  'download' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-download"></span>', ['candidatos/downloads', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'target' => '_blank','title' => Yii::t('yii', 'Download da Documentação'),
                    ]);                                

                  },
                  'view' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['candidatos/view', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                

                  },
                  'aprovar' => function ($url, $model) {  

                    return $model->resultado === null ? Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['candidatos/aprovar', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Aprovar Aluno'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja APROVAR este candidato?'),
                    ]) : '';                               

                  },
                  'reprovar' => function ($url, $model) {  

                    return $model->resultado === null ? Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['candidatos/reprovar', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Reprovar Aluno'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja REPROVAR este candidato?'),
                    ]) : '';                   

                  },
                  'reenviar' => function ($url, $model) {  

                    return $model->carta_recomendacao == 1 && $model->qtd_cartas > $model->cartas_respondidas ? Html::a('<span class="glyphicon glyphicon-envelope"></span>', ['candidatos/reenviarcartas', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Reenviar Cartas'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja Reenviar cartas de recomendação deste candidato?'),
                    ]) : '';                   

                  }
              ]                            
            ],
        ],
    ]); ?>
    
<?php
echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Inscrições Em Andamento',
            'content' => GridView::widget([
            'dataProvider' => $dataProvider2,
            'rowOptions'=> function($model){
                    if($model->resultado === 1) {
                        return ['class' => 'info'];
                    }
                    else if($model->resultado === 0) {
                        return ['class' => 'danger'];
                    }
                    else if($model->cartas_respondidas < 2 && $model->carta_recomendacao == 1){
                        return ['class' => 'warning'];
                    }
                    else{
                        return ['class' => 'success'];
                    }
            },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [   'label' => 'Nº de Inscrição',
                'attribute' => 'id',
                'value' => function ($model) {
                     return $model->idEdital.'-'.str_pad($model->posicaoEdital, 3, "0", STR_PAD_LEFT);;
                },
            ],
             'nome',
             'email',
            [   'label' => 'Curso Desejado',
                'attribute' => 'cursodesejado',
                'value' => function ($model) {
                     return $model->cursodesejado == 1 ? 'Mestrado' : 'Doutorado';
                },
            ],
            [   'label' => 'Linha Pesquisa',
                'attribute' => 'nomeLinhaPesquisa',
            ],
            [   'label' => 'Etapa da Inscrição',
                'attribute' => 'passoatual',
                'value' => function ($model) {
                     return $model->passoatual."/4";
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{download} {view} {aprovar} {reprovar} {reenviar}',
                'buttons'=>[
                  'download' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-download"></span>', ['candidatos/downloads', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'target' => '_blank','title' => Yii::t('yii', 'Download da Documentação'),
                    ]);                                

                  },
                  'view' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['candidatos/view', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                

                  },
                  'aprovar' => function ($url, $model) {  

                    return $model->resultado === null ? Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['candidatos/aprovar', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Aprovar Aluno'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja APROVAR este candidato?'),
                    ]) : '';                               

                  },
                  'reprovar' => function ($url, $model) {  

                    return $model->resultado === null ? Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['candidatos/reprovar', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Reprovar Aluno'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja REPROVAR este candidato?'),
                    ]) : '';                   

                  },
                  'reenviar' => function ($url, $model) {  

                    return $model->carta_recomendacao == 1 && $model->qtd_cartas > $model->cartas_respondidas ? Html::a('<span class="glyphicon glyphicon-envelope"></span>', ['candidatos/reenviarcartas', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'title' => Yii::t('yii', 'Reenviar Cartas'),
                            'data-confirm' => \Yii::t('yii', 'Você deseja Reenviar cartas de recomendação deste candidato?'),
                    ]) : '';                   

                  }
              ]                            
            ],
        ],
    ]),
            // open its content by default
            'contentOptions' => ['class' => 'in']
        ],
    ]
]);

?>
</div>
