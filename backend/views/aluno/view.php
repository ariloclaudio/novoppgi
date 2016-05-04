<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */

$this->title = "Dados do Aluno: ".$model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Aluno: ".$model->nome;

$statusAluno = array(0 => 'Aluno Corrente',1 => 'Aluno Egresso',2 => 'Aluno Desistente',3 => 'Aluno Desligado',4 => 'Aluno Jubilado',5 => 'Aluno com Matrícula Trancada');

$exameProficienciaAluno = array(null => "Não Avaliado", 0 => 'Reprovado',1 => 'Aprovado');

?>
<div class="aluno-view">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar', ['index'], ['class' => 'btn btn-warning']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-edit"></span> Editar  ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove-sign"></span> Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Pedir Banca', ['defesa/create', 'aluno_id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="fa fa-file"></span> Exame de Proeficiência', ['aluno/exame', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           'matricula',
            'nome',
            'email:email',
            [
                     'attribute' => 'area',
                     'label'=> 'Linha de Pesquisa',
                ],
            [
                     'attribute' => 'curso',
                     'format'=>'raw',
                     'value' => $model->curso == 1 ? 'Mestrado' : 'Doutorado'
                ],
            [
                     'attribute' => 'status',
                     'format'=>'raw',
                     'value' => $statusAluno[$model->status] 
                ],
            'cpf',
            'telresidencial',
            'telcelular',
            [
                'attribute' => 'bolsista',
                'format'=>'raw',
                'value' => $model->bolsista == 1 ? 'SIM: '.$model->agencia : 'NÃO'
            ],
            [
                'attribute' => 'financiadorbolsa',
                'format'=>'raw',
                'visible' => $model->bolsista == 1,
            ],
            [   'label' => 'Status',
                'attribute' => 'status',
                'value' => $model->status == 0 ? 'Aluno Corrente': 'Aluno Egresso' 
            ],
            [
                'label' => 'Data de Ingresso',
                'attribute' => 'dataingresso',
                'value' => date("d-m-Y", strtotime($model->dataingresso)),

            ],
            'idiomaExameProf',
            [
            'attribute' => 'conceitoExameProf',
            'value' => $exameProficienciaAluno[$model->conceitoExameProf],
            ]
            ,
            'dataExameProf',
            'orientador1.nome',          
        ],
    ]) ?>

</div>
