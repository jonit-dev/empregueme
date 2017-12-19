<?php
//registra no aweber e redireciona

function registraaweber_redirecina($lista,$url,$usu_nome,$usu_login)
{
							//--------------- REGISTRO NO AWEBER------------------//
							
echo '<form method="post" action="http://www.aweber.com/scripts/addlead.pl" id="form1">
<input type="hidden" name="listname" value="'.$lista.'" />
<input type="hidden" name="redirect" value="'.$url.'" />
<input type="hidden" name="meta_adtracking" value="customform" />
<input type="hidden" name="meta_message" value="1" /> 
<input type="hidden" name="meta_required" value="name,email" /> 
<input type="hidden" name="meta_forward_vars" value="0" /> 
<input type="hidden" name="name" value="'.$usu_nome.'" /> 
<input type="hidden" name="email" value="'.$usu_login.'" /> 
</form>';

//REGISTRO DE DADOS - AWEBER FORM
echo '<script type="text/javascript">
	

$(document).ready(function(e) {
    	
		
		
		$("#form1").submit();
	
	
});//end ready

</script>';	
	
}


?>