$(document).ready(function(e) {
	
	$(".anuncio_descricao").hide();//esconde a descrição de todos os anúncios
    
	
	$("a[href*=anuncio]").mouseover(function(){
			
		//$(this).children('.anuncio_descricao').fadeIn(500);
	
	
	if($(this).children('.anuncio_descricao').text() == 0)//se descrição for = 0 nao mostra nada, porque é anuncio externo!!
		{
		return;	
		}
		
	
		$(this).children('.anuncio_descricao').show();
		$(this).children('.anuncio_descricao').animate(
			{
			bottom:'80px',
			right:'-1px',
			opacity:'.8'
			},500
		
		
		);
		
		
		
		});//anuncio mouse over
		
		
	$(".anuncio").mouseleave(function(){
			
			$(".anuncio_descricao").fadeOut(500);
		
		
		});//anuncio mouse over
	
	
});//end ready