// JavaScript Document
$(document).ready(function(e) {

//COMUNICAÇÃO COM SERVIDOR E REGISTRO DOS FEEDBACKS

$('#enviar_feedback').on('click',function(){
	
	
	//captura valores de campos no formulário
	var feedback_assunto = $('#feedback_assunto').val(),
		feedback_txt = $('#feedback_txt').val(),
		userid = $('#userid').val()
		;
	
		$.post('ajax/registro_feedback.php',{
			feedback_assunto:feedback_assunto,
			feedback_txt:feedback_txt,
			userid:userid
			
			},function(data){
				//callback		
				//alert(data);
								
				$('.feedback_content').html('');
				$('.feedback_content').html('<center><p>'+data+'</p></center>');
			
			$('.feedback_content').children('center').children('p').addClass('sucesso_feedback');
			
			
			//aguarda 3 segundos e feixa caixa
			
			
			
			
			
			setTimeout(function(){	
			$('#feedback').animate(
			{
				right:'-26.8em'
				
				
				}
				
				,500);
				feedback_visivel = false;
					},7000);
	
	
				
			});//end ajax callback

	
			
	//apaga valores dos formulários
	$('#feedback_txt').val('');
	
	
	});//ao clicar no enviar_feedback










///EVENTOS DE ANIMAÇÃO DA CAIXA DE FEEDBACK
    
	var feedback_visivel = false;
	
	$('.feedback_tag').click(function(){
		
		
		if (feedback_visivel == false)//se o campo de feedback nao está visível, vamos mostrar
		{
			$('#feedback').animate(
			{
				right:'0px'
				
				
				}
				
				,500);
				feedback_visivel = true
		}
		else
	{
			$('#feedback').animate(
			{
				right:'-26.8em'
				
				
				}
				
				,500);
				feedback_visivel = false;
		}
		
		
		});//end feedback_tag click
		
	
	
});//end ready