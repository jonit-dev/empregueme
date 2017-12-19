// JavaScript Document

$(document).ready(function(e) {
	

    
	$('input[name=name],input[name=nickname],input[name=email],input[name=email2],input[name=password],input[name=password2],input[name=estado],input[name=cidade]').blur(function(){
		
			var $this = $(this);
			
			if ($this.val() == '')//se nome está vazio...
				{
					$this.css(
					{
						'background-color':'#ffe8e8',
						});	
						
					$this.siblings('.alert').css(
					{
						'display':'inline-block'
						}
						);	
				}
				else
				{
				$this.css(
					{
						'background-color':'white'
						});	
						
					$this.siblings('.alert').css(
					{
						'display':'none'
						}
						);		
				}
		
		});//end blur
		

		
//==================== >> VERIFICAÇÃO DE APELIDO ================= verifica se apelido já está em uso via AJAX

$("input[name=nickname]").blur(function(){
	
	var $this = $(this);
	
	if($this.val() != '')//se tem algo escrito...
	{
	
	var nickname = $("input[name=nickname]").val();
	$.post('ajax/verifica_apelido.php',
	{
		nickname:nickname
		},function(data){
			//callback
					  
				if(data == 0)//pode registrar
				{
					
					
										  $('#nickname').css(//deixa fundo verde
										  {
									  'background-color':'#e9fce4'
							  
									  });
					  
							  
							  	$('#nickname').siblings('.valid').css(
													  {
														  'display':'inline-block'
					  
													  }).text('Apelido válido!');
													  
													   $('#nickname').siblings('.alert').css(
													  {
														  'display':'none'
					  
													  });	
	

							
								//$("#nickname").siblings('alert')
				}
				if(data == 1)//nickname ocupado!
				{
					
					 $('#nickname').css(//deixa fundo verde
										  {
									  'background-color':'#ffe8e8'
							  
									  });
					  
							  var rdm = Math.floor((Math.random() * 10) + 1);//número entre 1 e 10
							  var nickname = $("#nickname").val();
							  var sugestoes = nickname.slice(0,5)+rdm;
							  
							  
							  	$('#nickname').siblings('.alert').css(
													  {
														  'display':'inline-block'
					  
													  }).text('O apelido já está em uso. Tente algo como: '+sugestoes);	
													  
													  $('#nickname').siblings('.valid').css(
													  {
														  'display':'none'
					  
													  });
					
					
					
					
				}
				
			
			});
	
	}
	});		


	
	
	
$('#btm_nova_conta').click(function(){

//====================>> VERIFICA SE OS DOIS EMAILS SÃO IGUAIS

if($("input[name=email]").val() != $("input[name=email2]").val())
{
alert('Os dois e-mails inseridos não são iguais. Por favor, verifique se você digitou corretamente os dois e-mails!');

var $login1 = $("input[name=email]"), $login2 = $("input[name=email2]");

$login1.css(
					{
						'background-color':'#ffe8e8',
						});	
$login1.siblings('.alert').css({'display':'inline-block'}).text('Esses dois e-mails devem ser os mesmos!')


$login2.css(
					{
						'background-color':'#ffe8e8',
						});	
$login2.siblings('.alert').css({'display':'inline-block'}).text('Esses dois e-mails devem ser os mesmos!')


return false;
	
}


		




//====================>> VERIFICA SE AS DUAS SENHAS

if($("input[name=password]").val() != $("input[name=password2]").val())
{
alert('As duas senhas inseridas não são iguais. Por favor, verifique se você digitou tudo corretamente');

var $password1 = $("input[name=password]"), $password2 = $("input[name=password2]");

$password1.css(
					{
						'background-color':'#ffe8e8',
						});	
$password1.siblings('.alert').css({'display':'inline-block'}).text('As duas senhas devem ser as mesmas!')


$password2.css(
					{
						'background-color':'#ffe8e8',
						});	
$password2.siblings('.alert').css({'display':'inline-block'}).text('As duas senhas devem ser as mesmas!')


return false;
	
}
		




//============ INICIA VALIDAÇÃO DE DADOS

	//vamos validar os dadosa

	var inputs_log = '';
	
	
	
		if($("input[name=name]").val() == '')
			{
			
			inputs_log += 'Nome, ';		
			}
			
		if($("input[name=nickname]").val() == '')
			{
			
			inputs_log += 'Apelido, ';		
			}
	
				
		
		if($("input[name=email]").val() == '')
			{
				inputs_log += 'E-mail(1), ';		
			}	
		
		if($("input[name=email2]").val() == '')
			{
				inputs_log += 'E-mail(2), ';		
			}	
		
		if($("input[name=password]").val() == '')
			{
				inputs_log += 'Senha(1), ';		
			}
		
		if($("input[name=password2]").val() == '')
			{
				inputs_log += 'Senha(2), ';		
			}	
			
		
		if($("input[name=estado]").val() == '')
			{
				inputs_log += 'Estado, ';		
			}
		
		if($("input[name=cidade]").val() == '')
			{
				inputs_log += 'Cidade, ';		
			}		
			
			
			
			
				
			
			
			
		
		String(inputs_log);
		
		
			if(inputs_log.length > 0)//ou seja, se tem erro
				{
					
					inputs_log = inputs_log.substring(0,inputs_log.length-2);//remove última vírgula
					
					alert('Você esqueceu de preencher os seguintes campos: '+inputs_log);
					
					
					//verifica para qual campo irá mandar o foco (sempre pro primeiro
		
		var foco = inputs_log.split(',');
		
		var foco_principal = foco[0];
		
		if(foco_principal == 'Nome') { $("input[name=name]").focus();	}
		if(foco_principal == 'Apelido') { $("input[name=nickname]").focus();}			
		if(foco_principal == 'E-mail(1)') { $("input[name=email]").focus();}		
		if(foco_principal == 'E-mail(2)') { $("input[name=email2]").focus();}	
		if(foco_principal == 'Senha(1)') { $("input[name=password]").focus();}		
		if(foco_principal == 'Senha(2)') { $("input[name=password2]").focus();}	
				if(foco_principal == 'Estado') { $("input[name=estado]").focus();}
						if(foco_principal == 'Cidade') { $("input[name=cidade]").focus();}	
						if(foco_principal == 'Tipo da Conta') { $("input[name=tipo_conta]").focus();}					
					return false;//impede de se candidatar.
					
					
					
					
				}
				
			



	
			
		
		
	
			
		
	
	
	
	
	});//ao clicar em criar nova conta	
	
	

	
});//end ready;