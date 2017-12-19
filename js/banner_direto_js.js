
    function mostra_banner($title,$content)
{
	//CARREGA HTML DO BANNER
	$("body").append('<div id="show_banner"><div id="banner_bkg"></div><div id="wrap"><div id="banner_small"><div id="close"></div><div id="banner_title">'+$title+'</div><div id="banner_txt">'+$content+'</div></div></div></div>');	
	

//PARA MOSTRAR O BANNER
		$("#banner_bkg").show(0,0,function(){
			$("#show_banner").fadeIn(200)			
			});
//PARA FECHAR O BANNER
$("#close,#banner_bkg,#ok_btm").click(function(){
		//agora, se clicar no fundo ou no botão close, fecha o 		banner
		
					
	
		$("#show_banner,#banner_bkg").fadeOut(200);
		
		
		
		});//end click - fechar				
			
			
}
