
$(document).ready( function() {

    $('#edital-curso').click(function(){


		if($( "input[name='Edital[curso]']:checked" ).val() == 1){
			$('#divVagasMestrado').css('display', 'block');
			$('#divVagasDoutorado').css('display', 'none');
		}
		else if ($( "input[name='Edital[curso]']:checked" ).val() == 2){
			$('#divVagasMestrado').css('display', 'none');
			$('#divVagasDoutorado').css('display', 'block');
		}
		else if ($( "input[name='Edital[curso]']:checked" ).val() == 3){
			$('#divVagasMestrado').css('display', 'block');
			$('#divVagasDoutorado').css('display', 'block');	
		}

   });


});