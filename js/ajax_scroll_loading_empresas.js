// JavaScript Document

$(document).ready(function(e) {

//VARIAVEIS INICIAIS
 var inicio = 1, fim = 2; //logo de cara, são carregadas apenas essas vagas
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


//================>> PÁGINA MAIN.php - EMPRESA

if (url_atual.indexOf('pesquisa') == -1)//==========>> SE NÃO ESTÁ na página de pesquisa
{
//checa se usuário deu scroll até o final da página!
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height() && terminou_mostrar == false) {//se chegou ao fundo e ainda nao terminou de mostrar
       
	  
	
	   //se deu scroll até o final da página, vamos fazer uma requisição em ajax para carregar o restante dos dados
	   $.post('ajax/load_on_scroll_ajax_empresas.php',
	   {
		   inicio:inicio,
		   fim:fim
		},function(data){//on call back
		
	//	alert(data);
		
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
