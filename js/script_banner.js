// JavaScript Document
//ESSE SCRIPT CONTROLA TODAS AS FUNÇÕES DO BANNER


$(document).ready(function(e) {
	
	
	
    //primeiro esconde tudo
	$("#show_banner,#banner_bkg").hide();
		
		
		//NOTA: a ação de fazer o banner aparecer está na classe display_main->show_banner
		
				
	$("#close,#banner_bkg,#ok_btm,.fechabanner").click(function(){
		//agora, se clicar no fundo ou no botão close, fecha o 		banner
		
					
	
		$("#show_banner,#banner_bkg").fadeOut(200);
		
		//FECHA BANNER x ATUALIZA $_SESSION['curriculo']
		//esse código abaixo é para dar refresh na página de o usuário estiver fechando um banner de cadastro de currículo (é importante que de refresh no main.php para atualizar as variáveis de sessão!
		var url = window.location.href;

	String(url);
	//alert(url)
	if(url.indexOf('banner=curriculo') != -1)
		{
			//alert('redirecionando para main');
			document.location.href="main.php";//redireciona para o main	
		}
		
		
		
		
		});//end click - fechar	
		
		$("#go_login").click(function(){
			
			
					$("#show_banner,#banner_bkg").fadeOut(200);//fecha banner
					
					//poe foco no login
					$("#focus_here").focus();
			
			});
		

	
	
});//end ready