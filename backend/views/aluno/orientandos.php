<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Collapse;

BootboxAsset::register($this);
BootboxAsset::registerWithOverride($this);


/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acompanhar Orientandos';
$this->params['breadcrumbs'][] = $this->title;

if( Yii::$app->user->identity->checarAcesso('coordenador') == 1){
  $action = "{view} {banca} {aprovar} {reprovar}";
}
if ( Yii::$app->user->identity->checarAcesso('professor') == 1){
  $action = "{view} {banca}";
}
else if( Yii::$app->user->identity->checarAcesso('secretaria') == 1){
  $action = "{view} {aprovar} {reprovar}";
}


?>
<div class="orientandos-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'attribute' => 'linhaPesquisa.sigla',
            ],
			 'email:email',
			 'telresidencial',
            ['class' => 'yii\grid\ActionColumn',
              'template'=> $action,
                'buttons'=>[
				
                  'view' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                

                  },
                  'aprovar' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>', ['aprovar', 'aluno_id' => $model->id], [
                            'title' => Yii::t('yii', 'Aprovar Candidato'),
                    ]);                                

                  },
                  'reprovar' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['reprovar', 'aluno_id' => $model->id], [
                            'title' => Yii::t('yii', 'Reprovar Candidato'),
                    ]);                                

                  },

              ]                            
            ],
        ],
    ]); ?>
    
</div>
