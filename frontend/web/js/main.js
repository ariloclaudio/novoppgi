$(document).ready( function() {
   /* Executa a requisição quando o campo CEP perder o foco */
   $('#candidato-cep').blur(function(){
           /* Configura a requisição AJAX */
           console.log('cep=' + $('#candidato-cep').val());
           $.ajax({
                url : 'consultar_cep.php', /* URL que será chamada */ 
                type : 'POST', /* Tipo da requisição */ 
                data: 'cep=' + $('#candidato-cep').val(), /* dado que será enviado via POST */
                dataType: 'json', /* Tipo de transmissão */
                success: function(data){
                    if(data.sucesso == 1){
                        $('#candidato-endereco').val(data.rua);
                        $('#candidato-bairro').val(data.bairro);
                        $('#candidato-cidade').val(data.cidade);
                        $('#candidato-uf').val(data.estado);
 
                        $('#candidato-datanascimento').focus();
                    }
                },
                error: function(data){
                	console.log("Erro ao Buscar endereço");
                }
           });

   });




   $('#mais').click(function () {
    var tam = $('#teste').children(".row").length + 1;
    
    var instituicaoacademica = "instituicaoacademica"+tam;
    var atividade = 'atividade'+tam;
    var periodoacademico = 'periodoacademico'+tam;

    console.log(instituicaoacademica);
    console.log(atividade);
    console.log(periodoacademico);

    if($("#candidato-instituicaoacademica"+(tam-1)).val() != "" && $("#candidato-atividade"+(tam-1)).val() != "" && $("#candidato-periodoacademico"+(tam-1)).val() != ""){

      if(tam < 4)
        $('#teste').append("<div id='id"+instituicaoacademica+"'class='row'>"+
          "<div class='col-md-4 field-candidato-"+instituicaoacademica+"'>"+
            "<label class='control-label' for='candidato-"+instituicaoacademica+"'>Instituição Acadêmica "+tam+"</label>"+
            "<input id='candidato-"+instituicaoacademica+"' class='form-control' name='Candidato["+instituicaoacademica+"]' value='' maxlength='50' type='text'>"+
            "<div class='help-block'></div> </div>"+
            "<div class='col-md-4 field-candidato-"+atividade+"'>"+
              "<label class='control-label' for='candidato-"+atividade+"'>Atividade</label>"+
              "<input id='candidato-"+atividade+"' class='form-control' name='Candidato["+atividade+"]' value='' maxlength='50' type='text'><div class='help-block'></div>"+
            "</div>"+
            "<div class='col-md-4 field-candidato-"+periodoacademico+"'>"+
              "<label class='control-label' for='candidato-"+periodoacademico+"'>Período Acadêmico</label>"+
              "<input id='candidato-"+periodoacademico+"' class='form-control' name='Candidato["+periodoacademico+"]' value='' maxlength='30' type='text'><div class='help-block'>"+
              "</div>"+
            "</div>"+
          "</div>");
    }
  });

   $('#candidato-nacionalidade').click(function(){
   		if($( "input[name='Candidato[nacionalidade]']:checked" ).val() == 1){
   			$('#divBrasileiro').css('display', 'block');
   			$('#divEstrangeiro').css('display', 'none');

   		}else{
   			$('#divEstrangeiro').css('display', 'block');
   			$('#divBrasileiro').css('display', 'none');
   		}
   });

   $('#candidato-vinculoconvenio').click(function(){
      if($( "input[name='Candidato[vinculoconvenio]']:checked" ).val() == "SIM"){
        $('#divConvenio').css('display', 'block');
      }else{
        $('#divConvenio').css('display', 'none');
      }
   });

   $('#recomendacoes-conheceoutros').click(function(){
      if($("input[name='Recomendacoes[conheceOutros][]']" ).val() == 1){
        $("input[name='Recomendacoes[conheceOutros][]']").val(0);
        $('#outroslugarestexto').css('display', 'none');
      }else{
        $("input[name='Recomendacoes[conheceOutros][]']").val(1);
        $('#outroslugarestexto').css('display', 'block');
      }
   });

  $('#recomendacoes-outroscontatos').click(function(){
      if($("input[name='Recomendacoes[outrosContatos][]']" ).val() == 1){
        $("input[name='Recomendacoes[outrosContatos][]']").val(0);
        $('#outrasfuncoestexto').css('display', 'none');
      }else{
        $("input[name='Recomendacoes[outrosContatos][]']").val(1);
        $('#outrasfuncoestexto').css('display', 'block');
      }
  });

  $('input[name="Candidato[vinculoconvenio]"]').on('switchChange.bootstrapSwitch', function(data, state) { 
      if(state){
      $('#divConvenio').css('display', 'block');
    }else{
      $('#divConvenio').css('display', 'none');
    }
  });

  $('input[name="Candidato[cotas]"]').on('switchChange.bootstrapSwitch', function(data, state) { 
      if(state){
      $('#divCotas').css('display', 'block');
    }else{
      $('#divCotas').css('display', 'none');
    }
  });

  $('input[name="Candidato[vinculoemprego]"]').on('switchChange.bootstrapSwitch', function(data, state) { 
      if(state){
      $('#divVinculo').css('display', 'block');
    }else{
      $('#divVinculo').css('display', 'none');
    }
  });

});

$( window ).load(function() {

/*Para exibir a caixa de texto OUTROS ao carregar a view solicitação de carta de recomendadação*/
    if($("input[name='Recomendacoes[conheceOutros][]']" ).val() == 1){       
        $('#outroslugarestexto').css('display', 'block');
    }else{
        $('#outroslugarestexto').css('display', 'none');
    }

    if($("input[name='Recomendacoes[outrosContatos][]']" ).val() == 1){
        $('#outroslugarestexto').css('display', 'block');
    }else{
        $('#outroslugarestexto').css('display', 'none');
    }

    if($( "input[name='Candidato[vinculoemprego]']:checked" ).val() == "SIM"){
        $('#divVinculo').css('display', 'block');
    }

    if($("input[name='Candidato[nacionalidade]']:checked" ).val() == 1){
        $('#divBrasileiro').css('display', 'block');
        $('#divEstrangeiro').css('display', 'none');

    }else if($( "input[name='Candidato[nacionalidade]']:checked" ).val() == 2){
        $('#divEstrangeiro').css('display', 'block');
        $('#divBrasileiro').css('display', 'none');
    }

});