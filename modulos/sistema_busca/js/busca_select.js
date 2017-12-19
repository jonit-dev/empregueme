// JavaScript Document
$(document).ready(function(e) {
	
	//esconde menu
	$(".selector > .selector_options").hide();
	var opcoes_visiveis = false;
	


    $(".selector").click(function(){//ao clicar, vamos mostrar as opções
		
		if (opcoes_visiveis == false)
		{
		$(this).children('.selector_options').show();
		opcoes_visiveis = true;
		}
		else
		{
					$(this).children('.selector_options').hide();
					opcoes_visiveis = false;
		}
		});//end click
		
		
//============ >>> ao clicarmos em uma opção

	$(".selector_options").children('center').click(function(){
		var opcao = ($(this).text());
		//alert(opcao);
		
			//joga o valor selecionado para o select principal
		$(this).parent('.selector_options').parent('.selector').children('center').html(opcao)
		
		
			
			
		});//end clicar em opção
		
		
		
		//se clicar em qualquer lugar no corpo do html que nao seja o seletor

$(document).mouseup(function (e)
{
    var container = $(".selector_options");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
});
		
		
	
	
		
});//end ready