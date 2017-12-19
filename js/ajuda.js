// JavaScript Document
$(document).ready(function(e) {
    $(".mostra_ajuda").on('click',function(){
		
			var message = $(this).siblings('.ajuda_mensagem').text();
		alert(message);
		
		
		});//end click
});//end ready