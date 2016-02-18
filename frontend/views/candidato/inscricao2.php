<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Candidato */

$this->title = 'Fomulário de Inscrição no Mestrado/Doutorado no PPGI/UFAM';
$this->params['breadcrumbs'][] = ['label' => 'Candidato', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Passo 2";
?>
<div class="candidato-create">

<hr style="width: 100%; height: 2px; border-top: 1px solid #000">
  <font size="2" style="line-height: 150%">
  <table border="0" cellpadding="0" cellspacing="2">
    <tbody>
      <tr>
				<td style="width: 4%;"><img src="img/step1_off.gif" border="0" height="36" width="36"></td>
				<td style="width: 18%;"><font size="2"><b> Dados Pessoais</b></font></td>
				<td style="width: 2%;"><img src="img/next.gif" border="0" height="21" width="14"></td>
				<td style="width: 4%;"><img src="img/step2_on.gif" border="0" height="36" width="36"></td>
				<td style="width: 21%;"><font size="2" color="#7f7f7f"><b> Hist&#243;rico Acad&#234;mico/Profissional</b></font></td>
				<td style="width: 2%;"><img src="img/next.gif" border="0" height="21" width="14"></td>
				<td style="width: 4%;"><img src="img/step3_off.gif" border="0" height="36" width="36"></td>
				<td style="width: 21%;"><font size="2" color="#7f7f7f"><b> Proposta de Trabalho e Documentos</b></font></td>
				<td style="width: 2%;"><img src="img/next.gif" border="0" height="21" width="14"></td>
				<td style="width: 4%;"><img src="img/step4_off.gif" border="0" height="36" width="36"></td>
				<td style="width: 18%;"><font size="2" color="#7f7f7f"><b> Tela de Confirma&#231;&#227;o</b></font></td>
      </tr>
    </tbody>
   </table>
   </font>
  <br>
   <hr style="width: 100%; height: 2px; border-top: 1px solid #000">
  <b>Como proceder: </b> <ul>
   <li>Preencha os campos com os dados de sua forma&#231;&#227;o acad&#234;mica e profissional.<font color="#FF0000"><br>(* Campos Obrigat&#243rios.)</font></li>
</ul>
   <hr style="width: 100%; height: 2px;">
<form method="post" enctype="multipart/form-data" name="passo2" action="index.php?option=com_inscricaoppgi&Itemid=<?php echo $Itemid;?>" onsubmit="javascript:return ValidatePasso2(this)">
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Curso de Gradua&#231;&#227;o</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 15%;"><font color="#FF0000">*</font> <b>Curso:</b></td>
        <td style="width: 35%;"><input maxlength="50" size="40" name="cursograd" class="inputbox" value="<?php echo $candidato->cursograd;?>"></td>
        <td style="width: 30%;"><font color="#FF0000">*</font> <b>Coeficiente de Rendimento:</b></td>
        <td style="width: 25%;"><input maxlength="5" size="5" name="crgrad" class="inputbox" value="<?php echo $candidato->crgrad;?>"></td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font> <b>Institui&#231;&#227;o:</b></font></td>
        <td><input maxlength="50" size="40" name="instituicaograd" class="inputbox" value="<?php echo $candidato->instituicaograd;?>"></td>
        <td><font color="#FF0000">*</font> <b>Ano de Egresso:</b></td>
        <td><input maxlength="4" size="5" name="egressograd" class="inputbox" value="<?php echo $candidato->egressograd;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Curso de Especialização (ou Aperfeiçoamento)</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 7%;"><b>Curso:</b></td>
        <td style="width: 30%;"><input maxlength="50" size="30" name="cursoesp" class="inputbox" value="<?php echo $candidato->cursoesp;?>"></td>
        <td style="width: 10%;"><b>Institui&#231;&#227;o:</b></font></td>
        <td style="width: 30%;"><input maxlength="50" size="30" name="instituicaoesp" class="inputbox" value="<?php echo $candidato->instituicaoesp;?>"></td>
        <td style="width: 15%;"><b>Ano de Egresso:</b></td>
        <td style="width: 8%;"><input maxlength="4" size="4" name="egressoesp" class="inputbox" value="<?php echo $candidato->egressoesp;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Curso de Pos-Gradua&#231;&#227;o Stricto-Senso</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 15%;"><b>Curso:</b></td>
        <td style="width: 35%;"><input maxlength="50" size="30" name="cursopos" class="inputbox" value="<?php echo $candidato->cursopos;?>"></td>
        <td style="width: 10%;"><b>Tipo:</b></td>
        <td style="width: 40%;" colspan="3"><input name="tipopos" value="1" type="radio" <?php if ($candidato->tipopos == 1) echo 'CHECKED';?>>Mestrado<input name="tipopos" value="2" type="radio" <?php if ($candidato->tipopos == 2) echo 'CHECKED';?>>Doutorado</font></td>
      </tr>
      <tr>
        <td style="width: 15%;"><b>Institui&#231;&#227;o:</b></font></td>
        <td style="width: 35%;"><input maxlength="50" size="30" name="instituicaopos" class="inputbox" value="<?php echo $candidato->instituicaopos;?>"></td>
        <td style="width: 10%;"><b>M&#233;dia:</b></td>
        <td style="width: 10%;"><input maxlength="5" size="5" name="mediapos" class="inputbox" value="<?php echo $candidato->mediapos;?>"></td>
        <td style="width: 20%;"><b>Ano de Egresso:</b></td>
        <td style="width: 10%;"><input maxlength="4" size="4" name="egressopos" class="inputbox" value="<?php echo $candidato->egressopos;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>


 <!-- PARTE DO DIPLOMA OCULTADA 

 <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><font color="#FF0000">*</font><b>Diploma de Mestrado ou de Gradua&#231;&#227;o (ou declara&#231;&#227;o de conclus&#227;o de curso de gradua&#231;&#227;o):</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
         <td>Arquivo contendo seu diploma/declara&#231;&#227;o: <?php if($candidato->diploma <>"") {?><a target="resource window" href="<?php echo $candidato->diploma;?>"><img src="components/com_inscricaoppgi/images/icon_pdf.gif" border="0" height="16" width="16"></a><?php } else echo "Nenhum arquivo de diploma/declara&#231;&#227;o carregado.";?></td>
      </tr>
      <tr>
         <td>Novo Arquivo (apenas no formato PDF): <input type="file" name="diploma" size="60"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>

FIM DA PARTE DE DIPLOMA
-->

  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><font color="#FF0000">*</font><b>Hist&#243;rico Escolar (mesmo que incompleto para os formandos):</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
         <td>Arquivo contendo seu hist&#243;rico escolar: <?php if($candidato->historico <>"") {?>
		 <a target="resource window" href="index.php?option=com_inscricaoppgi&task=viewpdf&doc=hi&id=<?php echo $candidato->id;?>">
		  <!--<a target="resource window" href="<?php echo $candidato->historico;?>">-->
			<img src="components/com_inscricaoppgi/images/icon_pdf.gif" border="0" height="16" width="16">
		 </a><?php } else echo "Nenhum arquivo de hist&#243;rico carregado.";?></td>
      </tr>
      <tr>
         <td>Novo Arquivo (apenas no formato PDF): <input type="file" name="historico" size="60"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Publica&#231;&#245;es</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 30%;"><font color="#FF0000">*</font> <b>Peri&#243;dicos Internacionais:</b></td>
        <td style="width: 20%;"><input maxlength="3" size="3" name="periodicosinternacionais" class="inputbox" value="<?php echo $candidato->periodicosinternacionais;?>"></td>
        <td style="width: 30%;"><font color="#FF0000">*</font> <b>Peri&#243;dicos Nacionais:</b></td>
        <td style="width: 20%;"><input maxlength="3" size="3" name="periodicosnacionais" class="inputbox"  value="<?php echo $candidato->periodicosnacionais;?>"></td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font> <b>Confer&#234;ncias Internacionais:</b></font></td>
        <td><input maxlength="3" size="3" name="conferenciasinternacionais" class="inputbox" value="<?php echo $candidato->conferenciasinternacionais;?>"></td>
        <td><font color="#FF0000">*</font> <b>Confer&#234;ncias Nacionais:</b></td>
        <td><input maxlength="3" size="3" name="conferenciasnacionais" class="inputbox" value="<?php echo $candidato->conferenciasnacionais;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><font color="#FF0000">*</font><b>Curriculum Vittae (no formato Lattes - http://lattes.cnpq.br):</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
         <td>Arquivo contendo seu Curriculum Lattes: <?php if($candidato->curriculum <>"") {?>
		 <a target="resource window" href="index.php?option=com_inscricaoppgi&task=viewpdf&doc=cr&id=<?php echo $candidato->id;?>">
		 <!--<a target="resource window" href="<?php echo $candidato->curriculum;?>">-->
			<img src="components/com_inscricaoppgi/images/icon_pdf.gif" border="0" height="16" width="16">
		 </a><?php } else echo "Nenhum arquivo de curriculum vitae carregado.";?></td>
      </tr>
      <tr>
         <td>Novo Arquivo (apenas no formato PDF): <input type="file" name="curriculum" size="60"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Idioma - L&#237;ngua Inglesa - Exame de Proefici&#234;ncia</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 25%;"><b>Institui&#231;&#227;o:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="30" name="instituicaoingles" class="inputbox" value="<?php echo $candidato->instituicaoingles;?>"></td>
        <td style="width: 15%;"><b>Anos de Estudo:</b></td>
        <td style="width: 35%;" colspan="3"><input maxlength="4" size="4" name="duracaoingles" class="inputbox" value="<?php echo $candidato->duracaoingles;?>"></td>
      </tr>
      <tr>
        <td style="width: 25%;"><b>Exame de Proefici&#234;ncia:</b></font></td>
        <td style="width: 25%;"><input maxlength="50" size="30" name="nomeexame" class="inputbox" value="<?php echo $candidato->nomeexame;?>"></td>
        <td style="width: 15%;"><b>Data:</b></td>
        <td style="width: 15%;"><input maxlength="10" size="10" name="dataexame" class="inputbox" value="<?php echo $candidato->dataexame;?>"></td>
        <td style="width: 7%;"><b>Nota:</b></td>
        <td style="width: 12%;"><input maxlength="5" size="5" name="notaexame" class="inputbox" value="<?php echo $candidato->notaexame;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Experi&#234;ncia Profissional</b></p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 13%;"><b>Institui&#231;&#227;o/ Empresa 1:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="empresa1" class="inputbox" value="<?php echo $candidato->empresa1;?>"></td>
        <td style="width: 10%;"><b>Cargo/ Fun&#231;&#227;o:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="cargo1" class="inputbox" value="<?php echo $candidato->cargo1;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoprofissional1" class="inputbox" value="<?php echo $candidato->periodoprofissional1;?>"></td>
      </tr>
      <tr>
        <td style="width: 13%;"><b>Institui&#231;&#227;o/ Empresa 2:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="empresa2" class="inputbox" value="<?php echo $candidato->empresa2;?>"></td>
        <td style="width: 10%;"><b>Cargo/ Fun&#231;&#227;o:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="cargo2" class="inputbox" value="<?php echo $candidato->cargo2;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoprofissional2" class="inputbox" value="<?php echo $candidato->periodoprofissional2;?>"></td>
      </tr>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 13%;"><b>Institui&#231;&#227;o/ Empresa 3:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="empresa3" class="inputbox" value="<?php echo $candidato->empresa3;?>"></td>
        <td style="width: 10%;"><b>Cargo/ Fun&#231;&#227;o:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="cargo3" class="inputbox" value="<?php echo $candidato->cargo3;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoprofissional3" class="inputbox" value="<?php echo $candidato->periodoprofissional3;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <hr style="width: 100%; height: 2px;">
  <fieldset>
  <p align="justify"><b>Experi&#234;ncia Acad&#234;mica </b>(Monitoria, PIBIC, PET, Instutor, Professor)</p>
  <table border="0" cellpadding="1" cellspacing="2" width="100%">
    <tbody>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 13%;"><b>Institui&#231;&#227;o 1:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="instituicaoacademica1" class="inputbox" value="<?php echo $candidato->instituicaoacademica1;?>"></td>
        <td style="width: 10%;"><b>Atividades:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="atividade1" class="inputbox" value="<?php echo $candidato->atividade1;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoacademico1" class="inputbox" value="<?php echo $candidato->periodoacademico1;?>"></td>
      </tr>
      <tr>
        <td style="width: 13%;"><b>Institui&#231;&#227;o 2:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="instituicaoacademica2" class="inputbox" value="<?php echo $candidato->instituicaoacademica2;?>"></td>
        <td style="width: 10%;"><b>Atividades:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="atividade2" class="inputbox" value="<?php echo $candidato->atividade2;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoacademico2" class="inputbox" value="<?php echo $candidato->periodoacademico2;?>"></td>
      </tr>
      <tr style="background-color: #D0D0D0;">
        <td style="width: 13%;"><b>Institui&#231;&#227;o 3:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="instituicaoacademica3" class="inputbox" value="<?php echo $candidato->instituicaoacademica3;?>"></td>
        <td style="width: 10%;"><b>Atividades:</b></td>
        <td style="width: 25%;"><input maxlength="50" size="25" name="atividade3" class="inputbox" value="<?php echo $candidato->atividade3;?>"></td>
        <td style="width: 12%;"><b>Per&#237;odo <br>(De X at&#233; Y):</b></td>
        <td style="width: 15%;"><input maxlength="15" size="15" name="periodoacademico3" class="inputbox" value="<?php echo $candidato->periodoacademico3;?>"></td>
      </tr>
    </tbody>
  </table>
  </fieldset>

  <br>

  <link rel="stylesheet" type="text/css" href="components/com_inscricaoppgi/css/template_css.css">
  <table border="0" cellpadding="0" cellspacing="2" width="100%"  class="adminform">
    <tbody>
      <tr style="text-align: center;">
         <th id="cpanel" width="50%"><div class="icon"><a href="javascript: document.passo2.task.value='passo1';document.passo2.submit();">
           <div class="iconimage"><img src="components/com_inscricaoppgi/images/back.gif" border="0" height="32" width="32"><br><b> Passo Anterior</b></div>
         </a></div></th>
        <th id="cpanel" width="50%"><div class="icon"><a href="javascript: if(ValidatePasso2(document.passo2)) document.passo2.submit()">
           <div class="iconimage"><img src="components/com_inscricaoppgi/images/forward.gif" border="0" height="32" width="32"><br><b>Salvar e Continuar</b></div>
         </a></div></th>
      </tr>
    </tbody>
  </table>

  <input name='task' type='hidden' value='passo3'>
  <input name='idCandidato' type='hidden' value='<?php echo $candidato->id; ?>'>
<!--  <input name='diplomaCandidato' type='hidden' value='<?php echo $candidato->diploma;?>'> -->
  <input name='curriculumCandidato' type='hidden' value='<?php echo $candidato->curriculum;?>'>
  <input name='historicoCandidato' type='hidden' value='<?php echo $candidato->historico;?>'>

</form>
</div>