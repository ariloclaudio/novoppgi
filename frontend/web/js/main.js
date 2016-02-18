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

                        console.log("Cidade: "+data.cidade);
 
                        $('#candidato-numero').focus();
                    }
                },
                error: function(data){
                	console.log("Erro ao Buscar endereço");
                }
           });   
   return false;    
   })

   $('#candidato-nacionalidade').click(function(){
   		if($( "input[name='Candidato[nacionalidade]']:checked" ).val() == 1){
   			$('#divBrasileiro').css('display', 'block');
   			$('#divEstrangeiro').css('display', 'none');

   		}else{
   			$('#divEstrangeiro').css('display', 'block');
   			$('#divBrasileiro').css('display', 'none');
   		}
   });
});