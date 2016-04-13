<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Minhas Solicitações de Férias';
$this->params['breadcrumbs'][] = $this->title;

?>

<script type="text/javascript">
        
        function anoSelecionado(){
            var x = document.getElementById("comboBoxAno").value;

            window.location="index.php?r=ferias/listar&ano="+x; 

        }

</script>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registrar Novas Férias', ['create'], ['class' => 'btn btn-success']) ?>
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

<p>
    Selecione um ano: <select id= "comboBoxAno" onclick="anoSelecionado();" class="form-control" style="margin-bottom: 20px; width:10%;">
        <?php for($i=0; $i<count($todosAnosFerias); $i++){ 

            $valores = $todosAnosFerias[$i];

            ?>
            <option <?php if($valores == $_GET["ano"]){echo "SELECTED";} ?> > <?php echo $valores ?> </option>
        <?php } ?>
    </select>
</p>

<div class="ferias-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
             ['attribute' => 'dataPedido',
             'value' => function ($model){
                        return date('d-m-Y', strtotime($model->dataSaida));
             },
             ],
            //'idusuario',
            //'nomeusuario',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
