// JavaScript Document
$(document).ready(function(e) {
	
	$(".periodo_geral").change(function(){//ao mudarmos o select
		
		var $selected = $(this).children('option:selected').val();//selecione o valor da opção selecionada pelo select clicado pelo usuário =) confuso, mas tem que ser assim!
		
		console.log("Usuário selecionou:"+$selected);
		
		switch($selected)
			{
				case 'dia_inteiro'://se selecionou o dia inteiro, vamos desarmar os inputs específicos
					$(this).next().val('').attr('disabled',true);
					$(this).next().next().val('').attr('disabled',true);
				break;
				
				case 'horario_especifico':
						$(this).next().attr('disabled',false);
					$(this).next().next().attr('disabled',false);
				break;
				
				case 'nao_funciona':
				$(this).next().val('').attr('disabled',true);
					$(this).next().next().val('').attr('disabled',true);
				break;	
			}
		
		});
	
	
	
	
	
	
	//gerencia inputs de tempo
    $('.time').timepicker({ 'timeFormat': 'H:i' });
});