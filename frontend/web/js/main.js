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

  $('#maisInstituicoes').click(function () {
    if($('#divInstituicao2').css('display') == 'none')
      $('#divInstituicao2').css('display', 'block');
    else if($('#divInstituicao3').css('display') == 'none')
      $('#divInstituicao3').css('display', 'block');
  });

   $('#maisCartasRecomendacoes').click(function(){
      if($('#divCartaRecomendacao0').css('display') == 'none')
        $('#divCartaRecomendacao0').css('display', 'block');
      else if($('#divCartaRecomendacao1').css('display') == 'none')
        $('#divCartaRecomendacao1').css('display', 'block');
      else if($('#divCartaRecomendacao2').css('display') == 'none')
        $('#divCartaRecomendacao2').css('display', 'block');
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