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



<p>
    Selecione um ano: <select id= "comboBoxAno" onclick="anoSelecionado();" class="form-control" style="margin-bottom: 20px; width:10%">
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
            'dataPedido',
            //'idusuario',
            'nomeusuario',
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
                 'attribute' => 'diferencadata',
                 'label' => "Qtd. Dias",
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
