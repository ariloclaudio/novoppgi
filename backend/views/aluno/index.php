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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aluno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'email:email',
            'senha',
            'matricula',
            // 'area',
            // 'curso',
            // 'endereco',
            // 'bairro',
            // 'cidade',
            // 'uf',
            // 'cep',
            // 'datanascimento',
            // 'sexo',
            // 'nacionalidade',
            // 'estadocivil',
            // 'cpf',
            // 'rg',
            // 'orgaoexpeditor',
            // 'dataexpedicao',
            // 'telresidencial',
            // 'telcomercial',
            // 'telcelular',
            // 'nomepai',
            // 'nomemae',
            // 'regime',
            // 'bolsista',
            // 'agencia',
            // 'pais',
            // 'status',
            // 'anoingresso',
            // 'idiomaExameProf',
            // 'conceitoExameProf',
            // 'dataExameProf',
            // 'tituloQual2',
            // 'dataQual2',
            // 'conceitoQual2',
            // 'tituloTese',
            // 'dataTese',
            // 'conceitoTese',
            // 'horarioQual2',
            // 'localQual2',
            // 'resumoQual2:ntext',
            // 'horarioTese',
            // 'localTese',
            // 'resumoTese:ntext',
            // 'tituloQual1',
            // 'numDefesa',
            // 'dataQual1',
            // 'examinadorQual1',
            // 'conceitoQual1',
            // 'cursograd',
            // 'instituicaograd',
            // 'crgrad',
            // 'egressograd',
            // 'dataformaturagrad',
            // 'idUser',
            // 'orientador',
            // 'anoconclusao',
            // 'sede',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
