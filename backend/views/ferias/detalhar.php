<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalhes de Férias';

$this->params['breadcrumbs'][] = ['label' => 'Solicitações de Férias', 'url' => ['listartodos',  "ano" => $_GET["ano"] ]];
$this->params['breadcrumbs'][] = $this->title;



if( isset($_GET["ano"]) && isset($_GET["prof"]) ){
    $anoVoltar = $_GET["ano"];
    $profVoltar = $_GET["prof"];
}

?>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Voltar  ', ['listartodos', "ano" => $anoVoltar ], ['class' => 'btn btn-warning']) ?>  
        <?= Html::a('Registrar Novas Férias', ['createsecretaria' , "id" => $id, "ano" => $anoVoltar , "prof" => $profVoltar ], ['class' => 'btn btn-success']) ?>
    </p>

 <table class="table" style ="width: 20%;border:solid 2px;">
    <tbody>
      <tr class="success">
        <td> <b> Total de dias de férias oficiais: </b> </td>
        <td  style="width:10%" > <b> <?= $qtd_ferias_oficiais ?> </b> </td>
      </tr>
      <tr class="warning">
        <td> <b> Total de dias de usufruto de férias: </b> </td>
        <td> <b> <?= $qtd_usufruto_ferias ?> </b> </td>
      </tr>
      <tr class="info">
        <td> <b> Dias restantes de usufruto de férias: </b> </td>
        <td> <b> <?php echo ($direitoQtdFerias-$qtd_usufruto_ferias) ?>  </b> </td>
      </tr>
    </tbody>
  </table>


<div class="ferias-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
             ['attribute' => 'dataPedido',
             'value' => function ($model){
                        return date('d-m-Y', strtotime($model->dataPedido));
             },
             ],
            //'idusuario',
            
            [
            'attribute' => 'nomeusuario',
            'label' => "Nome",

            ]
            ,
             ['attribute' => 'dataSaida',
             'value' => function ($model){
                        return date('d-m-Y', strtotime($model->dataSaida));
             },
             ],
             ['attribute' => 'dataRetorno',
             'value' => function ($model){
                        return date('d-m-Y', strtotime($model->dataRetorno));
             },
             ],
             [
                 'attribute' => 'diferencaData',
                 'label' => "Nº de Dias",
                 'value' => function ($model){
                            return ($model->diferencaData + 1);
                 },
            ],
                     
            [
            "attribute" =>'tipo',
            "value" => function ($model){

            	if($model->tipo == 1){
            		return "Oficial";
            	}
            	else{
            		return "Usufruto";
            	}

            },

            ],
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{delete}',
                'buttons'=>[
                  'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['deletesecretaria', 'id' => $model->id], [

                        'data' => [
                                        'confirm' => "Você realmente deseja excluir o registro dessas férias?",
                                        'method' => 'post',
                                    ],

                            'title' => Yii::t('yii', 'Remover Férias'),
                    ]);   
                  }
              ]                            
                ],
        ],
    ]); ?>
</div>
