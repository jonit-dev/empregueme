// JavaScript Document

$(document).ready(function(e) {
    var beneficio_visivel = false;
	
$('.beneficio_txt').on('click',function(){
	
	var desc = $(this).siblings('.beneficio_desc');
	
	//se descricao nao está visivel
	if(desc.css('display') == 'none')
		{
			desc.fadeIn(1000);
		}
		else
		{
		desc.fadeOut(1000);	
		}
	
	});	
	
	
	
});//end ready