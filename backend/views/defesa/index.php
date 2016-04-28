<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DefesaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de Defesas';
$this->params['breadcrumbs'][] = $this->title;

if( Yii::$app->user->identity->checarAcesso('coordenador') == 1){
  $action = "{view} {banca} {update} {delete}";
}
else if ( Yii::$app->user->identity->checarAcesso('professor') == 1){
  $action = "{view} {banca} {update} {delete}";
}
else if( Yii::$app->user->identity->checarAcesso('secretaria') == 1){
  $action = "{view}";
}


?>
<div class="defesa-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Defesa', ['create'], ['class' => 'btn btn-success']) 
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idDefesa',
            'nome_aluno',
            [   'label' => 'Curso Desejado',
                'attribute' => 'curso_aluno',
                'value' => function ($model) {
                     return $model->curso_aluno == 1 ? 'Mestrado' : 'Doutorado';
                },
            ],
            //'titulo',
            'tipoDefesa',
            'data',
            [
            "attribute" => 'conceito',

            "value" => function ($model){
                return $model->conceito == null ? "Não Julgado" : $model->conceito;

            },
            ],
             'horario',
             'local',
            // 'resumo:ntext',
            // 'numDefesa',
            // 'examinador:ntext',
            // 'emailExaminador:ntext',
            // 'reservas_id',
            // 'banca_id',
            //'aluno_id',
            // 'previa',

            ['class' => 'yii\grid\ActionColumn',
              'template'=> $action,
                'buttons'=>[
                
                  'view' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'idDefesa' => $model->idDefesa , 'aluno_id' => $model->aluno_id], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                

                  },
              ]                            
            ],
        ],
    ]); ?>
</div>
