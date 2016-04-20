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
              'template'=> "{view} {banca} {update} {delete}",
                'buttons'=>[
				
                  'view' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                

                  },

                  'banca' => function ($url, $model) {  

                    return Html::a('<span class="glyphicon glyphicon-check"></span>', ['defesa/create', 'aluno_id' => $model->id], [
                            'title' => Yii::t('yii', 'Solicitar Banca'),
                    ]);                                

                  },
              ]                            
            ],
        ],
    ]); ?>
    
</div>
