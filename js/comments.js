// JavaScript Document
$(document).ready(function(e) {
    
	$(".caixa_comentario,.inserir_comentario").show();//esconde comentários e caixa para comentar
	var mostra_comentarios = false;
	
	
	$(".comentar_txt").click(function(){
			if(mostra_comentarios == false)
			{	
		$(this).siblings('.caixa_comentario,.inserir_comentario').show();
			mostra_comentarios = true;
			}
			else
			{
			$(this).siblings('.caixa_comentario,.inserir_comentario').hide();
			mostra_comentarios = false;	
			}
		});//end comment action click
	

//==============================>> ENVIANDO COMENTÁRIO
	
	$(".enviar_comentario").click(function(){	
	
	var nickname = $("#user_nickname").val();
	var message = $(this).siblings('.textarea_comentario').val();//pega o valor do textarea

	var $this_button = $(this);//registro o objeto em clique para utilizá-lo dentro do callback do ajax (não dá pra referenciar diretamente por lá!!)

	var $userid = $('#userid').val();
	var $produto_id = $('#produto_id').val();

//vamos iniciar requisição ajax!

//só pra testar, a userid = 26! REMOVA DEPOIS!

//vamos verificar se o usuário digitou algo

if (message.length > 0)//se digitou algo, inicia requisição ajax
{

$.post('ajax/enviar_comentario.php',
{
	message:message,
	userid:$userid,
	produto_id:$produto_id
},function(comment_id)
{
		  if(comment_id != 'error')
		  {
			  $this_button.siblings('.textarea_comentario').val('');
			  			  
			//	$this_button.parent('.inserir_comentario').('.caixa_comentario').prepend  
	  $('.mostra_curtidas + .caixa_comentario').prepend('<!--inicia comentario--><div class="comentario" id="'+comment_id+'"><div class="remover_comentario" id="'+comment_id+'"></div><div class="img_comentario"><img src="../upload/gfx/perfil/'+$userid+'/perfil_fotos/foto_comentario.jpeg" /></div><strong>'+nickname+': </strong>'+message+'<br /><div><a href="javascript:void(0)"><div class="like"> <a href="javascript:void(0)"><div class="like_comment" id="'+comment_id+'">Curtir</div><div class="pessoas_curtiram"></div></a></div></div><!-- end comentario-->');//registra comentário inserido dentro da caixa de comentários
		
		//esconde x do remover do primeiro comentário
		$('.caixa_comentario > .comentario').first().children('.remover_comentario').hide();
		
		//esconde botão de remover comentário
		$this_button.parent('.inserir_comentario').parent('.caixa_comentario').children('.comentario').children('.remover_comentario').hide();
		
		
		  }
		  else//é porque registrou
		  {
		alert("Mostra mensagem de error");
		  }
			  
		  
}

);//end $.post

}

	});//end send comment click


//==============================>> MOSTRANDO X DO REMOVER
	
	$(".remover_comentario").hide();//esconde botão de remover comentario
	

$(document).on('mouseover','.comentario',function(){

		$(this).children('.remover_comentario').css('display','block');

	});//comentario mouse over
	
	$(document).on('mouseleave','.comentario',function(){

		$(this).children('.remover_comentario').css('display','none');

	});//comentario mouse over
	
	

//==============================>> REMOVENDO COMENTÁRIOS

//tem que ser feito nessa forma pois a classe remover comentário foi gerada de forma dinamica
$(document).on('click','.remover_comentario',function(){
	
	var $userid = $("#userid").val();//vamos enviar a ID do usuário para verificar se o comentário realmente é dele mesmo
	
	
	var c_id = $(this).attr('id');	
	$this_obj = $(this);
	
	//vamos enviar requisição ajax para remover comentario
	$.post('ajax/remover_comentario.php',{
		comment_id:c_id,
		userid:$userid
		},function(data){
			//alert(data);
			switch(data)
				{
					case 'sucesso':
					//alert('remover comentário');
						$this_obj.parent('.comentario').remove();;
					break;
					case 'error':
					alert('Não foi possível remover seu comentário');
					break;	
					case 'not_user':
					alert('Não é possível remover o comentário de outros usuários');
					break;
				}
			
			});
	});//remove comment	click
	
	

//==============================>> CURTINDO COMENTÁRIOS

$(document).on('click','.like_comment',function(){
	
	var comentario_id = $(this).attr('id');
	var pessoas_curtiram = $(this).siblings('.pessoas_curtiram');//registra objeto, para chama-lo no ajax
	
	var $userid = $("#userid").val();
	
	//inicia requisição ajax para alterar base de dados
	$.post('ajax/curtir_comentario.php',
	{
	comentario_id:comentario_id,//envia ID do comentário
	userid:$userid //<<<<<<<<<<<<============== ALTERAR VARIÁVEL [ATENÇÃO]
	},function(data)
		{
		//callback	
		//alert(data);
				
		//se ja curtiu comentário
					if(data == "already_liked")
						{
							alert("Você já curtiu esse comentário");
							exit;//para de executar script
						}		
				
				
				
				//se chegar até aqui é porque ainda não curtiu comentário
						var text_curtiram = "";
						if(data == 1)
							{
								text_curtiram = "pessoa curtiu";
							}
						if (data > 1)
							{
								text_curtiram = "pessoas curtiram";
							}
						
						
					pessoas_curtiram.text('·'+data+' '+text_curtiram);
				
				
				
		
		
		});
		
	
	});//end click like	
	
	
//=====================================>> CURTINDO PRODUTOS <<<<<<<<<<<<<<<<<<<<<<
$(document).on('click','.curtir_produto',function(){

//quando clicar em curtir produto, vamos fazer uma requisição ajax para checar se usuário já curtiu esse produto. Se sim, não faz nada. Se não, cadastra novo like


//pega userid e produto id para mandarmos pro ajax
var $userid = $("#userid").val();
var $produto_id = $("#produto_id").val();

$this_obj = $(this);

$.post('ajax/curtir_produto.php',
{
userid:$userid,
produto_id:$produto_id
},function($r_produto_likes)
{
	//alert($r_produto_likes);
	
	if($r_produto_likes == 'error')
		{
		alert('Você já curtiu esse produto!');
		exit;	
		}
	
	//retorna numero de likes TOTAIS do produto
	
	//vamos atualizar os likes do anuncio então
	var $mensagem_likes = "";//vamos criar a variável primeiro
	if($r_produto_likes == 1)//vamos configurar a frase de acordo com o n° de likes
		{
			$mensagem_likes = $r_produto_likes+" pessoa curtiu isso";
		}
	 if($r_produto_likes > 1)
	{	
		$mensagem_likes = $r_produto_likes+" pessoas curtiram isso";
	}
	if($r_produto_likes = 0)
	{	
		$mensagem_likes = "";
	}
	
	
		//se chegou até aqui é porque comentário não foi curtido. Portando, vamos atualizar os novos dados retornados pelo ajax (após curtir o comentário)
			$this_obj.siblings('.mostra_curtidas').children('.pessoas_curtiram_top').text($mensagem_likes);
			$this_obj.siblings('.mostra_curtidas').children('.pessoas_curtiram_top').append('<div class="coracao_curtir"></div>');
	
	
	
	//se tiver resposta é porque inseriu os likes e retornou com valor de total de likes
	
	//vamos atualizar e mostrar os likes
	//$this_obj.parent('.like_txt').parent('a[href=#curtir_produto]').siblings('.mostra_curtidas').children('.pessoas_curtiram_top').text($mensagem_likes);
				
			
			
			
	
});//end ajax post



});//end click curtir produtos
	
	
	
	
	
});//end ready