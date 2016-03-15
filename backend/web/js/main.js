
$(document).ready( function() {
	$('input[name="Edital[mestrado]"]').on('switchChange.bootstrapSwitch', function(data, state) { 
        if(state){
            $('#divVagasMestrado').css('display', 'block');
            $('#form_mestrado').val('1');
        }else{
            $('#divVagasMestrado').css('display', 'none');
            $('#form_mestrado').val('');
        }
    });

    $('input[name="Edital[doutorado]"]').on('switchChange.bootstrapSwitch', function(data, state) { 
        if(state){
            $('#divVagasDoutorado').css('display', 'block');
            $('#form_doutorado').val('1');
        }else{
            $('#divVagasDoutorado').css('display', 'none');
            $('#form_doutorado').val('');
        }
    });
});



$( window ).load(function(){

/*Inicio das exibições das vagas e cotas do Edital*/
	if($('#form_mestrado').val() == 1){
		$('#divVagasMestrado').css('display', 'block');
	}
	if($('#form_doutorado').val() == 1)
		$('#divVagasDoutorado').css('display', 'block');
/*Fim das exibições das vagas e cotas do Edital*/
});
