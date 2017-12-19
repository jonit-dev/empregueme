// JavaScript Document
$(document).ready(function(e) {
    
	$(".caixa_comentario").hide();//esconde comentários e caixa para comentar
	var mostra_comentarios = false;
	
	
	$(".comentar_txt").click(function(){
			if(mostra_comentarios == false)
			{	
		$(this).siblings('.caixa_comentario').show();
			mostra_comentarios = true;
			}
			else
			{
			$(this).siblings('.caixa_comentario').hide();
			mostra_comentarios = false;	
			}
		});//end comment action click
	

//==============================>> ENVIANDO COMENTÁRIO
	
	$(".enviar_comentario").click(function(){	
	
	
			  var txt_remove = $('.caixa_comentario').find('div:contains("&nbsp;")');
 				txt_remove.text(txt_remove.text().replace('&nbsp;',''));
	
	var message = $(this).siblings('.textarea_comentario').val();//pega o valor do textarea

	var $this_button = $(this);//registro o objeto em clique para utilizá-lo dentro do callback do ajax (não dá pra referenciar diretamente por lá!!)

//vamos iniciar requisição ajax!

//só pra testar, a userid = 26! REMOVA DEPOIS!

//vamos verificar se o usuário digitou algo

if (message.length > 0)//se digitou algo, inicia requisição ajax
{

$.post('ajax/enviar_comentario.php',
{
	message:message,
	userid:'26',//<<<<<<<<<<<<<<<<<<<< ALTERAR VARÀVEIS [ ATENÇÃO ]
	produto_id:'106'
},function(comment_id)
{
		  if(comment_id != 'error')
		  {
			  $this_button.siblings('.textarea_comentario').val('');
			  			  
			  
	  	$this_button.parent('.inserir_comentario').parent('.caixa_comentario').prepend('<!--inicia comentario--><div class="comentario" id="'+comment_id+'"><div class="remover_comentario" id="'+comment_id+'"></div><div class="img_comentario"><img src="foto.jpg" /></div><strong>João Paulo Furtado:</strong>'+message+'<br /><div class="like"> <a href="#"><div class="like_comment" id="'+comment_id+'">Curtir</div><div class="pessoas_curtiram"></div></a></div></div><!-- end comentario-->');//registra comentário inserido dentro da caixa de comentários
		
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
	
	var c_id = $(this).attr('id');	
	$this_obj = $(this);
	
	//vamos enviar requisição ajax para remover comentario
	$.post('ajax/remover_comentario.php',{
		comment_id:c_id
		},function(data){
			switch(data)
				{
					case 'sucesso':
						$this_obj.parent('.comentario').remove();;
					break;
					case 'error':
					alert('Não foi possível remover seu comentário');
					break;	
				}
			
			});
	});//remove comment	click
	
	

//==============================>> CURTINDO COMENTÁRIOS

$(document).on('click','.like_comment',function(){
	
	var comentario_id = $(this).attr('id');
	var pessoas_curtiram = $(this).siblings('.pessoas_curtiram');//registra objeto, para chama-lo no ajax
	
	
	
	//inicia requisição ajax para alterar base de dados
	$.post('ajax/curtir_comentario.php',
	{
	comentario_id:comentario_id,//envia ID do comentário
	userid:'26' //<<<<<<<<<<<<============== ALTERAR VARIÁVEL [ATENÇÃO]
	},function(data)
		{
		//callback	
					if(data != "")
					{
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
					}
		
		
		});
		
	
	});//end click like	
	
	
	
	
	
});//end ready