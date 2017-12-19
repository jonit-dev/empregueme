// JavaScript Document
$(document).ready(function(e) {
	var mostra_menu = false;
	
    $("#abrir_menu").click(function(){
		
			
		
		if(mostra_menu == false)//se menu estiver escondido, vamos mostrá-lo
			{
				$("#menu_anunciar").show();
				mostra_menu = true;
			}
	else
				{
					$("#menu_anunciar").hide();
					mostra_menu = false;
				}
					
		});//end click
});//end ready