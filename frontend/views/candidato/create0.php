<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Formulário de Inscrição no Mestrado/Doutorado no PPGI/UFAM - Realizar Cadastro';
$this->params['breadcrumbs'][] = ['label' => 'Editais', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Realizar Cadastro";
?>
<div class="candidato-create">
	<h2> INSCRIÇÃO AO PROGRAMA DE PÓS GRADUAÇÃO EM INFORMÁTICA </h2>
	<hr style="width: 100%; height: 2px; border-top: 1px solid black;">
	<font size="2" style="line-height: 150%">
		<p align="justify">Preencha os campos e-mail, senha e repetir senha para cadastrar um novo candidato.</p>
		<p align="justify">O campo <b>Repetir Senha</b> deve ser preenchido com o mesmo valor preenchido no campo <b>Senha</b>.</p>
		<p align="justify">Após confirmar o cadastro, você será direcionado ao formulário de inscrição. Você pode retornar ao formulário sempre que desejar usado o seu e-mail e senha informados abaixo.</p>
	</font>
	<hr style="width: 100%; height: 2px; border-top: 1px solid black;">

    <?= $this->render('_form0', [
        'model' => $model,
        'edital'=> $edital,
    ]) ?>


</div>