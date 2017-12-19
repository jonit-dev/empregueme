<?php
function alerta_e_redireciona($content ='',$link)
{
	//chama mensagem em alert do javascript (depois mude para algo mais profissional) e redireciona usuário
	echo '<script type="text/javascript">
			$(document).ready(function(e) { 
			
						
						
						
						function redireciona_agora()
								{
								window.location.replace("'.$link.'");
								exit;
								}
							
							
							
						alert("'.$content.'");
						redireciona_agora();
					
											
						
							
						
			});//end ready
						
				</script>';
	
	
}


?>