// JavaScript Document
$(document).ready(function(e) {
    
	
	//vamos capturar as variáveis para utilizar
	var telefone1 = $("input[name=telefone1]").val(),
	telefone2 = $("input[name=telefone2]").val(),
	email = $("input[name=email_user]").val();
	
	//Ao clicarmos no contato para candidato
	$("#btm_contato_candidato").click(function(){
		
		
		//primeiro vamos checar se o telefone secundário foi especificado
		String(telefone2);
		
		if(telefone2.length > 0)//se a str telefone 2 foi setada
		{
		mostra_banner('<strong>Entre em contato usando os dados abaixo</strong>','<strong>Telefone Principal: </strong>'+telefone1+'<br/>'+'<strong>Telefone Secundário: </strong>'+telefone2+'<br/>'+'<strong>E-mail: </strong>'+email+'<br/>');
		}
		else// se nao, vamos mostrar a versão do banner sem o telefone secundário
		{
				mostra_banner('<strong>Entre em contato usando os dados abaixo</strong>','<strong>Telefone Principal: </strong>'+telefone1+'<br/>'+'<strong>E-mail: </strong>'+email+'<br/>');
		}
		
		
		
		
		
		});
	
	
	
});//end ready;