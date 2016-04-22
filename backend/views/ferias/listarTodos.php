<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitações de Férias';
$this->params['breadcrumbs'][] = $this->title;

?>

<script type="text/javascript">
        
        function anoSelecionado(){
            var x = document.getElementById("comboBoxAno").value;

            window.location="index.php?r=ferias/listartodos&ano="+x; 

        }

</script>


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

             ['attribute' => 'dataPedido',
             'value' => function ($model){
                        return date('d-m-Y', strtotime($model->dataPedido));
             },
             ],

            'nomeusuario',
            'nomeProfessor',

           [
                'label' => 'Férias Oficiais' ,
                 'value' => function ($model){
                            return $model->feriasAno($model->idusuario, $_GET["ano"] , 1 );
                 },
            ],
            [
                'label' => 'Usufruto de Férias' ,
                 'value' => function ($model){
                            return $model->feriasAno($model->idusuario, $_GET["ano"] , 2 );
                 },
            ],
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                'buttons'=>[
                  'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['detalhar', 'id' => $model->idusuario , 'ano' => $_GET["ano"]], [
                            'title' => Yii::t('yii', 'Remover Férias'),
                    ]);   
                  }
              ]                            
                ],
        ],
    ]); ?>
</div>
