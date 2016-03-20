<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CandidatosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Candidatos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-index">

<script>
function goBack() {
    window.history.back();
}
</script>

<?= Html::a('Voltar', ['edital/view', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-warning']) ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'senha',
            //'inicio',
            //'fim',
            //'passoatual',
             'nome',
            // 'endereco',
            // 'bairro',
            // 'cidade',
            // 'uf',
            // 'cep',
             'email:email',
            // 'datanascimento',
            // 'nacionalidade',
            // 'pais',
            // 'estadocivil',
            // 'rg',
            // 'orgaoexpedidor',
            // 'dataexpedicao',
            // 'passaporte',
            // 'cpf',
            // 'sexo',
            // 'telresidencial',
            // 'telcomercial',
            // 'telcelular',
            // 'nomepai',
            // 'nomemae',
            [   'label' => 'Curso Desejado',
                'attribute' => 'cursodesejado',
                'value' => function ($model) {
                     return $model->cursodesejado == 0 ? 'Mestrado' : 'Doutorado';
                },
            ],
            // 'regime',
            // 'inscricaoposcomp',
            // 'anoposcomp',
            // 'notaposcomp',
            // 'solicitabolsa',
            // 'vinculoemprego',
            // 'empregador',
            // 'cargo',
            // 'vinculoconvenio',
            // 'convenio',

            [   'label' => 'Linha Pesquisa',
                'attribute' => 'nomeLinhaPesquisa',
            ],
    
            // 'tituloproposta',
            // 'diploma:ntext',
            // 'historico:ntext',
            // 'motivos:ntext',
            // 'proposta:ntext',
            // 'curriculum:ntext',
            // 'cartaempregador:ntext',
            // 'comprovantepagamento:ntext',
            // 'cursograd',
            // 'instituicaograd',
            // 'crgrad',
            // 'egressograd',
            // 'dataformaturagrad',
            // 'cursoesp',
            // 'instituicaoesp',
            // 'egressoesp',
            // 'dataformaturaesp',
            // 'cursopos',
            // 'instituicaopos',
            // 'tipopos',
            // 'mediapos',
            // 'egressopos',
            // 'dataformaturapos',
            // 'periodicosinternacionais',
            // 'periodicosnacionais',
            // 'conferenciasinternacionais',
            // 'conferenciasnacionais',
            // 'instituicaoingles',
            // 'duracaoingles',
            // 'nomeexame',
            // 'dataexame',
            // 'notaexame',
            // 'empresa1',
            // 'empresa2',
            // 'empresa3',
            // 'cargo1',
            // 'cargo2',
            // 'cargo3',
            // 'periodoprofissional1',
            // 'periodoprofissional2',
            // 'periodoprofissional3',
            // 'instituicaoacademica1',
            // 'instituicaoacademica2',
            // 'instituicaoacademica3',
            // 'atividade1',
            // 'atividade2',
            // 'atividade3',
            // 'periodoacademico1',
            // 'periodoacademico2',
            // 'periodoacademico3',
            // 'resultado',
            // 'periodo',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{download} {view} {delete} {update}',
                'buttons'=>[
                  'download' => function ($url, $model) {     
                    return Html::a('<span class="glyphicon glyphicon-download"></span>', ['candidatos/downloads', 'id' => $model->id, 'idEdital' => $model->idEdital], [
                            'target' => '_blank','title' => Yii::t('yii', 'Download do Edital'),
                    ]);                                

                  }
              ]                            
            ],
        ],
    ]); ?>
</div>
