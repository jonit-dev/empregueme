	function mostra_mensagem(mensagem,tipo)
	{
		switch(tipo)
			{
		case 'sucesso':
			$("#system_message").hide().html("").append('<div class="sucesso"><div class="msg_text_sucess">'+mensagem+'</div></div>').fadeIn(500);
		setTimeout('$("#system_message").fadeOut(500,0,function(){$("#system_message").html("");});',10000);//limpa os resultados em 5 segundos
		
		break;	
		case 'error':
			$("#system_message").hide().html("").append('<div class="system_error"><div class="msg_text_error">'+mensagem+'</div></div>').		fadeIn(500);	
		setTimeout('$("#system_message").fadeOut(500,0,function(){$("#system_message").html("");});',10000);//limpa os resultados em 5 segundos
				
			
		break;
		
		
			}//end switch
	}//end function mostra message
