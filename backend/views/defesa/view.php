<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Defesa */

$this->title = "Detalhes da Defesa";
$this->params['breadcrumbs'][] = ['label' => 'Defesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="defesa-view">

    <p>

        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['defesa/index',], ['class' => 'btn btn-warning']) ?>  

		<?= Html::a('Editar', ['update', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'idDefesa' => $model->idDefesa, 'aluno_id' => $model->aluno_id], [
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
            //'idDefesa',
            'nome',
            'curso',
            'titulo',
            [
            'attribute' => 'numDefesa',
            'label' => 'Nº da Defesa',
            ]
            ,
            [
            "attribute" => 'tipodefesa',
            "label" => "Tipo",
            ],

            [
            "attribute" => 'data',
            "value" => date("d/m/Y", strtotime($model->data))
            ],
            [
            "attribute" => 'conceitodefesa',
            'format' => 'html',
            "label" => "Conceito",
            ],
            [
            "attribute" => 'previa',
            'format' => 'html',
            "value" => "<a href='previa/".$model->previa."' target = '_blank'> Baixar </a>"
            ],

            'horario',
            'local',
            'resumo:ntext',
            //'banca_id',
        ],
    ]) ?>

<h3> Detalhes da Banca </h3>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        "summary" => "",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'banca_id',
            //'membrosbanca_id',
            [
                'attribute'=>'membro_nome',
                'label' => "Nome do Membro",
            ],
            [
                'attribute'=>'membro_filiacao',
                'label' => "Filiação do Membro",
            ],
            [
                "attribute" => 'funcaomembro',
                "label" => "Função",
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
