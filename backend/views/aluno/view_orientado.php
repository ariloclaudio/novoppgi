<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Aluno */

$this->title = "Dados do Aluno: ".$model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Aluno: ".$model->nome;

$statusAluno = array(0 => 'Aluno Corrente',1 => 'Aluno Egresso',2 => 'Aluno Desistente',3 => 'Aluno Desligado',4 => 'Aluno Jubilado',5 => 'Aluno com Matrícula Trancada');

?>
<div class="aluno-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar', ['orientandos'], ['class' => 'btn btn-warning']) ?>
		<?= Html::a('Pedir Banca', ['defesa/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                     'attribute' => 'endereco',
                     'format'=>'raw',
                     'label' => 'Endereço',
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
            'conceitoExameProf',
            'dataExameProf',
        ],
    ]) ?>

</div>
