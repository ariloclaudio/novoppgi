<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CandidatoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*Estático para abrir pagina*/
$candidato['id']= "12";

$this->title = 'Inscrição realizada com sucesso!!!';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidato-index">

	<p align="center"><font size="3"><b>Inscrição realizada com sucesso!!!</b></font></p>
   	<p><font size="2" style="line-height: 150%"><br>Seus dados foram cadastrados com sucesso. Sua proposta será analisada e em breve teremos a divulgação dos aprovados no processo de seleção do PPGI.<br /> Clique no link "Imprimir Formulário de Inscrição" e imprima a página contendo os dados de sua incrição para seu controle. Quando solicitado, assine e entregue este formulário na secretaria do PPGI/UFAM que fica no Departamento de Ciência da Computação, localizado na Rua Gen. Rodrigo Octávio Jordão Ramos, 3000 SETOR NORTE do Campus Universitário Manaus - AM - CEP 69.077-000.</font></p>
   	<br /><p align="right"><font size="2" style="line-height: 150%">Ass: Coordenação do PPGI/UFAM</font></p><br />



   		<div style="text-align: center;">
   		<a target="resource window" href="index.php?option=com_inscricaoppgi&task=viewpdf&doc=fo&id=<?php echo $candidato['id'];?>">
			<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/edit_f2.png" border="0" height="32" width="32"><br><b>Imprimir Formul&#225;rio de Inscri&#231;&#227;o</b></div></a>

		<a target="resource window" href="<?php echo $diretorio;?>Proposta.pdf">
			<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/edit_f2.png" border="0" height="32" width="32"><br><b>Imprimir Proposta de Trabalho</b></div></a>
        <div id="cpanel" width="25%"></div>
		
		<a target="resource window" href="<?php echo $diretorio;?>Historico.pdf">
				<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/historico.gif" border="0" height="32" width="32"><br><b>Imprimir Hist&#243;rico Escolar</b></div></a>
		<a target="resource window" href="<?php echo $diretorio;?>Curriculum.pdf">
				<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/curriculum.gif" border="0" ><br><b>Imprimir Curriculum Lattes</b></div></a>
		<a target="resource window" href="<?php echo $diretorio;?>Comprovante.pdf">
				<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/comprovante.png" border="0" height="32" width="32"><br><b>Imprimir Comprovante de Pagamento</b></div></a>
		<a target="resource window" href="<?php echo $diretorio;?>cartaempregador.pdf">
			<div class="iconimage" style="float: left; width: 200px; margin-top: 20px;"><img src="img/carta.jpg" border="0" height="32" width="32"><br><b>Imprimir Carta do Empregador</b></div></a>
			</div>
		<div style="clear: both;"></div>

</div>
