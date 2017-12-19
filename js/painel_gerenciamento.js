// JavaScript Document

$(document).ready(function(e) {
    
	
//-------------------------- MOSTRAR CURRÍCULOS DE CANDIDATOS---------------	
	
	//deixa cvs das vagas escondidos, como default
	$('.box_content').hide();
	
	$('.mostra_cv').click(function(){
		
		var box_content_visible = $(this).parent().parent().parent().siblings('.box_content').is(':visible');
		
				var $this_block_content = $(this).parent().parent().parent().siblings('.box_content');
		
		if(box_content_visible == false)//se conteúdo ainda nao está visível, vamos mostrá-lo
		{

		
		$this_block_content.fadeIn(300);
		}
		if(box_content_visible == true)//se conteúdo ainda nao está visível, vamos mostrá-lo
		{
					$this_block_content.fadeOut(300);
		}
		
		
		
		
		});//end click
		
		

		
	
});//end ready