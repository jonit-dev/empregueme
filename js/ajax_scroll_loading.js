// JavaScript Document

$(document).ready(function(e) {

//VARIAVEIS INICIAIS
 var inicio = 6, fim = 7; //logo de cara, são carregadas apenas essas vagas
		var terminou_mostrar = false; //boolean que armazena se terminou ou nao as vagas da base de dados...
	
//armazena url atual da página... iremos usar isso para evitar de fazer o auto carregamento em ajax em páginas de busca
var url_atual = String(window.location);//armazena como string para podermos pesquisar com o IndexOf depois... ;)

if (url_atual.indexOf('pesquisa') >= 0)//==========>> SE ESTÁ NA PÁGINA DE PESQUISA
{

//checa se usuário deu scroll até o final da página!
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height() && terminou_mostrar == false) {//se chegou ao fundo e ainda nao terminou de mostrar

	
	   //se deu scroll até o final da página, vamos fazer uma requisição em ajax para carregar o restante dos dados
	   $.post('ajax/load_on_scroll_ajax.php',
	   {
		   inicio:inicio,
		   fim:fim,
		   query:query
		},function(data){//on call back
		
		
				
			if(data.length == 0)//se nao ta enviando mais dados é porque terminou de mostrar!
				{
					terminou_mostrar = true;	
					//alert('terminou de mostrar')
					//alert(data);
					
				}
				
					
			if(terminou_mostrar == false)//se ainda nao terminou de mostrar...
			{		
			//data armazena os dados da vaga carregada
			$("#conteudo").append(data);//primeiro insere o conteudo no html
			//agora esconde
			$(".vaga").last().hide();
			//e depois da o efeito do fadeIn	
			$(".vaga").last().fadeIn(500);
			
	//ESSE DEVE SER O MESMO CODIGO DO ENVIO_CURRICULO.jS ====> PORQUE ESSE CODIGO N FUNCIONA PARA CONTEUDOS CARREGADOS PELO AJAX!
					$('.vaga,.vaga_exclusiva').on('click','.candidatar',function(){
						
						
						
								$candidatar = $(this);
		var userid = $(this).siblings('input[name=userid]').val(),
		vaga_codigo = $(this).siblings('input[name=vaga_codigo]').val()
		
		;
		
		
$.post('ajax/envia_curriculo.php',
{
	userid:userid,
	vaga_codigo:vaga_codigo
	},function(data){
		//callback




String(data);

if(data.indexOf('VIP') > 0 && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
					  
					  var n = noty(
			  {
				  text: 'Seu currículo de membro VIP foi enviado com sucesso e já se encontra no e-mail da empresa!',
				  type: 'success',
				  layout:'topCenter',
				  timeout:6000
			  });
			  
			  //vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Membro VIP: Seu currículo foi enviado para essa vaga</h4>');


	}
	/*
if(data.indexOf('VIP') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
										  var n = noty(
						  {
							  text: 'Seu currículo de membro VIP não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	
	}	*/



if((data.indexOf('normal') > 0 || data.indexOf('empresa') > 0  ) && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
				noty({
  text: 'Seu currículo foi adicionado à fila e somente após 48 horas será enviado para a empresa. Caso queira ter o envio realizado AGORA MESMO, clique em ENVIAR AGORA para criar sua conta VIP.',type:'success',layout:'topCenter'
  
  ,
  buttons: [
    {addClass: 'btn btn-warning', text: 'Enviar AGORA', onClick: function($noty) {

        // this = button element
        // $noty = $noty element

        $noty.close();
  document.location.href="membro_vip.php";//redireciona para pagina VIP
      }
    },
    {addClass: 'btn btn-danger', text: 'Continuar na Fila', onClick: function($noty) {
        $noty.close();
        noty({text: 'Seu currículo está na fila junto com outros candidatos, e só será enviado após 48 horas.', type: 'error', timeout:6000});
      }
    }
  ]
});
		
	//vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Seu currículo será enviado para essa vaga.</h4>');	
		
		
	}
	
	/*
if(data.indexOf('normal') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
  var n = noty(
						  {
							  text: 'Seu currículo não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	}	

*/


		
		
		
		
		
		});


						
						
						
						
						
						
						});
					//alert(data)

					
	
			
			//altera variaveis de inicio e fim
			inicio += 1;
			fim  += 1;
					//FB.XFBML.parse();//isso é para mostrar os plugins do facebook, no conteúdo carregado dinamicamente pelo ajax
			}

			
			
			});//finaliza requisição ajax
			
		
			
			
	   
   }
});



}


//================>> PÁGINA MAIN.php - USUÁRIO

if (url_atual.indexOf('pesquisa') == -1)//==========>> SE NÃO ESTÁ na página de pesquisa
{
//checa se usuário deu scroll até o final da página!
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height() && terminou_mostrar == false) {//se chegou ao fundo e ainda nao terminou de mostrar
       
	  
	
	   //se deu scroll até o final da página, vamos fazer uma requisição em ajax para carregar o restante dos dados
	   $.post('ajax/load_on_scroll_ajax.php',
	   {
		   inicio:inicio,
		   fim:fim
		},function(data){//on call back
		
		
		
			if(data.length == 0)//se nao ta enviando mais dados é porque terminou de mostrar!
				{
					terminou_mostrar = true;	
					//alert('terminou de mostrar')
					
				}
				
					
			if(terminou_mostrar == false)//se ainda nao terminou de mostrar...
			{		
			//data armazena os dados da vaga carregada
			$("#conteudo").append(data);//primeiro insere o conteudo no html
			//agora esconde
			$(".vaga").last().hide();
			//e depois da o efeito do fadeIn	
			$(".vaga").last().fadeIn(500);
			
			
			//ESSE DEVE SER O MESMO CODIGO DO ENVIO_CURRICULO.jS ====> PORQUE ESSE CODIGO N FUNCIONA PARA CONTEUDOS CARREGADOS PELO AJAX!
				$('.vaga,.vaga_exclusiva').on('click','.candidatar',function(){
						
						
						
								$candidatar = $(this);
		var userid = $(this).siblings('input[name=userid]').val(),
		vaga_codigo = $(this).siblings('input[name=vaga_codigo]').val()
		
		;
		
		
$.post('ajax/envia_curriculo.php',
{
	userid:userid,
	vaga_codigo:vaga_codigo
	},function(data){
		//callback
		//alert(data);



String(data);

if(data.indexOf('VIP') > 0 && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
					  
					  var n = noty(
			  {
				  text: 'Seu currículo de membro VIP foi enviado com sucesso e já se encontra no e-mail da empresa!',
				  type: 'success',
				  layout:'topCenter',
				  timeout:6000
			  });
			  
			  //vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Membro VIP: Seu currículo foi enviado para essa vaga</h4>');


	}
	/*
if(data.indexOf('VIP') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
										  var n = noty(
						  {
							  text: 'Seu currículo de membro VIP não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	
	}	*/



if((data.indexOf('normal') > 0 || data.indexOf('empresa') > 0  ) && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
				noty({
  text: 'Seu currículo foi adicionado à fila e somente após 48 horas será enviado para a empresa. Caso queira ter o envio realizado AGORA MESMO, clique em ENVIAR AGORA para criar sua conta VIP.',type:'success',layout:'topCenter'
  
  ,
  buttons: [
    {addClass: 'btn btn-warning', text: 'Enviar AGORA', onClick: function($noty) {

        // this = button element
        // $noty = $noty element

        $noty.close();
  document.location.href="membro_vip.php";//redireciona para pagina VIP
      }
    },
    {addClass: 'btn btn-danger', text: 'Continuar na Fila', onClick: function($noty) {
        $noty.close();
        noty({text: 'Seu currículo está na fila junto com outros candidatos, e só será enviado após 48 horas.', type: 'error', timeout:6000});
      }
    }
  ]
});
		
	//vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Seu currículo será enviado para essa vaga.</h4>');	
		
		
	}
	
	/*
if(data.indexOf('normal') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
  var n = noty(
						  {
							  text: 'Seu currículo não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	}	

*/


		
		
		
		
		
		});


						
						
						
						
						
						
						});
					//alert(data)
			
			
			//altera variaveis de inicio e fim
			inicio += 1;
			fim  += 1;
					//FB.XFBML.parse();//isso é para mostrar os plugins do facebook, no conteúdo carregado dinamicamente pelo ajax
			}

			
			});//finaliza requisição ajax
	   
   }
});
}


});//end ready;
