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

   $('#candidato-vinculoemprego').click(function(){
      if($( "input[name='Candidato[vinculoemprego]']:checked" ).val() == "SIM"){
        $('#divVinculo').css('display', 'block');
      }else{
        $('#divVinculo').css('display', 'none');
      }
   });

   $('#candidato-vinculoconvenio').click(function(){
      if($( "input[name='Candidato[vinculoconvenio]']:checked" ).val() == "SIM"){
        $('#divConvenio').css('display', 'block');
      }else{
        $('#divConvenio').css('display', 'none');
      }
   });

   function verificacpf(cpf){
      if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
        return false;
     add = 0;

     for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);

     rev = 11 - (add % 11);
     if (rev == 10 || rev == 11)
        rev = 0;

     if (rev != parseInt(cpf.charAt(9)))
        return false;

     add = 0;
     for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);

     rev = 11 - (add % 11);
     if (rev == 10 || rev == 11)
         rev = 0;

     if (rev != parseInt(cpf.charAt(10)))
         return false;

     return true;
   }
/*
   function validacaoCPF(){
            var cpf = $('#candidato-cpf').val();

      if (cpf == ''){

          $('#errocpf').css('display', 'block');
          $('#errocpf').text("CPF é de preenchimento obrigatório");
          $('#candidato-cpf').css('border-color', '#a94442');
          $('#corCPF').css('color', '#a94442');
          return 0;
      }
      else{
        cpf = verificacpf(cpf);

        if(cpf == true){
          $('#errocpf').css('display', 'none');
          $('#candidato-cpf').css('border-color', '#3c763d');
          $('#corCPF').css('color', '#3c763d');
        }
        else{
          $('#errocpf').css('display', 'block');
          $('#errocpf').text("CPF inserido é inválido");
          $('#candidato-cpf').css('border-color', '#a94442');
          $('#corCPF').css('color', '#a94442');
        }

      }
   }

     $('#candidato-cpf').blur(function(){

        validacaoCPF();

     });
*/
});


function validacao(){

    var x = $("#form_hidden").val();    




    //var x = $("input:radio[name=\"Candidato[nacionalidade]\"]:checked").val();
    //alert(x);

    //validacaoCPF();
}