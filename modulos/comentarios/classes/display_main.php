<?php
class display_main
{
	function head()
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Projeto RSC</title>
<!--CSS-->
<style type="text/css">
@import url(\'css/estrutura_index.css\');
@import url(\'css/reset.css\');
@import url(\'css/banner.css\');
@import url(\'css/system_message.css\');
@import url(\'css/autocomplete.css\');
@import url(\'css/anuncio.css\');
@import url(\'fonts/fonts.css\');
</style>
<!--end css-->

<!--LOAD jQUERY-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

<!--Código do banner-->
<script type="text/javascript" src="js/script_banner.js">
</script>

<!--Função para mostrar mensagens do sistema-->
<script type="text/javascript" src="js/system_message.js"></script>
';

//SESSION TIME OUT - Evitando que usuário fique muito tempo logado

		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800000)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	header("Location:index.php");//volta pra pag login
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800000) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
	
	header("Location:index.php");//volta pra pag login
}


	}
	
	

function topo()
{
	echo "</head>";//finaliza head


echo '<div id="topo">
      
  <div id="titulo">
      Projeto RSC
      </div>	  
    <div class="botao" id="anunciar_vaga"><a href="main.php?banner=anunciar">Anunciar Grátis</a></div>
</div>';
}

	function painel_esquerda()
	{
		echo '<div id="painel_esquerda">
    <div id="pe_content">
   <strong><center>:: Perfil ::</center></strong>
	
    <div id="dados_usuario">
    	<div id="nome_usuario">
        <strong>'.$_SESSION['nickname'].'</strong>
        </div>
    	<div id="editar_perfil">
		  <a href="edit_profile.php" target="_self">
		  <span class="small_txt"> Editar Perfil</span>
		  </a>
        </div>
    
        <div id="photo_box">
            <img src="'.$_SESSION['foto'].'" width="75"	height="75"/>
        </div>
    </div>
    
        <div id="menu_pe">
			<strong>Gerenciamento de conta</strong><br />
<a href=\'change_pw.php\'>Alterar Senha</a><br />
<a href=\'logout.php\'>Sair</a>


<br />
<br />
	<strong>Meus anúncios</strong><br />
<a href=\'\'>Ver anúncios</a><br />
<a href=\'\'>Editar Anúncios</a>

<br />
<br />

<strong>Transações</strong><br />
<a href=\'minhas_compras.php\'>Minhas Compras</a><br />

<a href=\'minhas_vendas.php\'>Minhas Vendas</a><br />
<br />
<br />




        </div>
        
    
  </div>
</div>';
echo '<div id="conteudo">';//inicia painel de conteúdo!!
echo '<div id="results"></div>';//carrega div de mostrar resultados
	}
	function painel_direita()
	{
			echo '</div>';//fecha conteúdo (content)
		echo '<div id="painel_direita">
  <strong><center>:: Social ::</center></strong>
</div>
';
	}

	function conteudo($content = '<div id="filtros"><strong>:: Busca ::</strong></div>' )
	{
	
	echo $content;
	
	}
	
	function fundo()
	{
		echo '<div id="bottom">
<div class="copyright"><center>Projeto RSC - CopyRight - 2014</center></div>
</div>
</body>
</html>
';
		
	}	

	
	function show_banner($title,$content,$banner_type = 'big')
	{
	if($banner_type == 'small')
	{
		echo '
	<!--Código do banner-->
<div id="show_banner">
    <div id="banner_bkg">
    </div>
  <div id="wrap">
    <div id="banner_small">
  
      <div id="close"></div>
      <div id="banner_title">'.$title.'</div>
      <div id="banner_txt">'.$content.'</div>
  </div>    
    </div>
</div>';

//código javascript para mostrar o banner
echo '<script type="text/javascript">
$(document).ready(function(e) {

		$("#banner_bkg").show();//mostra fundo
		$("#show_banner").fadeIn(500);//mostra banner
			
		
		
	});//end ready

</script>';




	}
	elseif($banner_type == 'big')
	{
		echo '
	<!--Código do banner-->
<div id="show_banner">
    <div id="banner_bkg">
    </div>
  <div id="wrap">
    <div id="banner_big">
  
      <div id="close"></div>
      <div id="banner_title">'.$title.'</div>
      <div id="banner_txt">'.$content.'</div>
  </div>    
    </div>
</div>';

//código javascript para mostrar o banner
echo '<script type="text/javascript">
$(document).ready(function(e) {

	$("#banner_bkg").show();//mostra fundo
		$("#show_banner").fadeIn(500);//mostra banner
			
		
		
	});//end ready

</script>';



	}
		
	}//end show banner

function show_system_message($content,$type = 'sucesso')
{
	switch($type)
	{
		case 'sucesso':
		echo '<script type="text/javascript">
		$(document).ready(function(e) {
			mostra_mensagem("'.$content.'","sucesso");
			
		});//end ready
		</script>';
		break;
		
		case 'error':
		echo '<script type="text/javascript">
		$(document).ready(function(e) {
		
			mostra_mensagem("'.$content.'","error");
		});//end ready
		</script>';

		break;
			
	}
	
	
}//end show message

	
}//end class




?>