// JavaScript Document
$(document).ready(function(e) {
    $('.disable_submit').click(function(){
		
		$(this).attr('disabled','disabled');//desarma botão
		$(this).attr('value','Aguarde...');//altera valor
		
		$(this).parent('form').submit();
		
		});//end disable
});//end ready