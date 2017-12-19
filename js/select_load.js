$(document).ready(function(e) {
	

	var $mudou_categoria_primeiro = false;
	
	//ao alterarmos o select da categoria
		
        
	$("#categoria").on('change',function(){//atualiza quando clicar e trocar o select
			
			//vamos limpar nosso conteúod
			$("#categoria option[value=none]").remove();
				
			//primeiro, vamos limpar o conteúdo do select subcategoria
			$("#subcategoria option").html('');
		//altera variável que registra que mudamos primeiro a categoria
		$mudou_categoria_primeiro = true;
		
		
		//REQUISIÇÃO AJAX!
		var qry = $("#categoria").val();//armazena o valor selecionado no select categoria, que corresponde à ID da categoria (iremos enviar isso ao nosso script de processamento ajax, para que este retorne os dados de subcategoria referentes a esta categoria selecionada)		
		
		//agora, vamos fazer a requisição ajax do conteúdo do select
		$.post('ajax/get_select_content.php',
		{
		categoria_id:qry,
		}
		,function(data)
		{
		//inicia manejo de resposta do servidor
		//alert(data);// importante para debugar
		//seleciona subcategoria e atualiza seu valor
				$("#subcategoria").html(data);
		
			
			
		});//end requisição AJAX
		
		
	
		
		});//end select categoria
		
	
	//se tentarmos alterar a subcategoria sem termos mudado a categoria primeiro...
	$("#subcategoria").click(function(){
		if($mudou_categoria_primeiro == false)
		{//mostra mensagem de erro!
			alert('Altere primeiro a categoria!');
		}//end if
		
		});
		
		
		
});//end ready// JavaScript Document