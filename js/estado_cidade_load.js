$(document).ready(function(e) {
	

	var $mudou_estado_primeiro_banner = false;
	var $mudou_estado_primeiro = false;
	
	
	//se tentarmos alterar a cidade sem termos mudado o estado primeiro...
	$("#cidade2").click(function(){
		if($mudou_estado_primeiro == false)
		{//mostra mensagem de erro!
			alert('Altere primeiro o estado!');
			
		}//end if
		
		});

	
	//se tentarmos alterar a cidade sem termos mudado o estado primeiro...
	$("#cidade").click(function(){
		if($mudou_estado_primeiro_banner == false)
		{//mostra mensagem de erro!
			alert('Altere primeiro o estado!');
		}//end if
		
		});
			
	
	
	//ao alterarmos o select da categoria
		
        
	$("#estado").on('change',function(){//atualiza quando clicar e trocar o select
			
			//vamos limpar nosso conteúod
			$("#estado option[value=none]").remove();
				
			//primeiro, vamos limpar o conteúdo do select subcategoria
			$("#cidade option").html('');
		//altera variável que registra que mudamos primeiro a categoria
		$mudou_estado_primeiro_banner = true;
		
		
		//REQUISIÇÃO AJAX!
		var qry = $("#estado").val();//armazena o valor selecionado no select estado, que corresponde à ID da estado (iremos enviar isso ao nosso script de processamento ajax, para que este retorne os dados de subcategoria referentes a esta categoria selecionada)		
		
		//agora, vamos fazer a requisição ajax do conteúdo do select
		$.post('ajax/get_estado_cidade_content.php',
		{
		estado_id:qry,
		}
		,function(data)
		{
		//inicia manejo de resposta do servidor
		//alert(data);// importante para debugar
		//seleciona subcategoria e atualiza seu valor
				$("#cidade").html(data);
		
			
			
		});//end requisição AJAX
		
		
	
		
		});//end select estado
		
	
		

	
	//ao alterarmos o select da categoria
		
        
	$("#estado2").on('change',function(){//atualiza quando clicar e trocar o select
			
		

			if($("#estado2").val() == "all")
				{				
					$("#cidade2").html('<option value="all">Todas as cidades...</option');
				}
				else
				{
			
				
			//primeiro, vamos limpar o conteúdo do select subcategoria
			$("#cidade2 option").html('');
		//altera variável que registra que mudamos primeiro a categoria
		$mudou_estado_primeiro = true;
		
		
		//REQUISIÇÃO AJAX!
		var qry = $("#estado2").val();//armazena o valor selecionado no select estado, que corresponde à ID da estado (iremos enviar isso ao nosso script de processamento ajax, para que este retorne os dados de subcategoria referentes a esta categoria selecionada)		
		
		//agora, vamos fazer a requisição ajax do conteúdo do select
		$.post('ajax/get_estado_cidade_content.php',
		{
		estado_id:qry,
		}
		,function(data)
		{
		//inicia manejo de resposta do servidor
		//alert(data);// importante para debugar
		//seleciona subcategoria e atualiza seu valor
				$("#cidade2").html(data);//depois carrega o resto das cidades
				$("#cidade2").append('<option value="all" selected="selected">Todas as cidades...</option');//adiciona primeiro todas as opções, como default ;)
			
			
		});//end requisição AJAX
		
		
				}//end if all
		
		});//end select categoria
		
	
	
							
		
		
});//end ready// JavaScript Document