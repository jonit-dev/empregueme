<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');
require_once('funcoes/db_functions.php');
require_once('classes/date_management.php');
require_once('funcoes/url_functions.php');

if (session_id() == '') {
    session_start();
}


check_loggedin();


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado

//gerenciamento de datas
$gerencia_data = new date_management;



$display_main->head('
@import url(\'css/artigo.css\');
@import url(\'css/visitas.css\');
');

$display_main->topo(false);


$display_main->painel_esquerda();

?>
<h1>Últimas Empresas Interessadas em meu Currículo</h1>

<?php

//envia requisição para mostrar visitantes do meu perfil

$mysqli = mysqli_full_connection();
$qry = "SELECT * FROM visitas_perfil WHERE
visitado_id = ?";

$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$_SESSION['userid']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($visita_id,$visitante_id,$visitado_id,$visita_data,$visualizada);
$tem_resultado = false;
$mostra_mensagem = false;
$mostra_assinatura = false;


while($stmt->fetch())
	{
		$tem_resultado = true;
		if($mostra_mensagem == false)
		{
		echo '<p>Abaixo estão os últimos visitantes de seu currículo. <b class="vermelho_destaque">Entre em contato!</b> Demonstrar interesse é o primeiro passo para se conseguir uma entrevista ou emprego.</p>';
		$mostra_mensagem = true;//só para impedir de ficar mostrando essa mensagem toda hora...
		}
		//verifica se realmente é VIP. Se não for, mostra mensagem embaçada
		if($_SESSION['membro_vip_ativo'] == 1)
		{
		
		
		
		$mysqli2 = mysqli_full_connection();
		$qry2 = "SELECT usu_nome, usu_login,usu_codigo FROM usuario WHERE usu_codigo = ?";
		$stmt2 = $mysqli2->prepare($qry2);
		$stmt2->bind_param('i',$visitante_id);
		$stmt2->execute();
		$stmt2->bind_result($nome_empresa,$email_empresa,$empresa_id);
		while($stmt2->fetch())
			{
			
				$url_imagem = "../upload/gfx/perfil/usu_".$empresa_id.".jpeg";
				
				if(file_exists($url_imagem))
					{
				$img_empresa = '<img src="'.$url_imagem.'" width="58" height="40" alt="logomarca" />';
					}
					else
					{
					$img_empresa = '<img src="gfx/ui/visitas_perfil/empresa_default.png" width="58" height="40" alt="logomarca" />';	
					}
				
				
			$data_visita = $gerencia_data->converte_data($visita_data,'eng','pt-br',true);
			
			$data_visita = str_ireplace('-','/',$data_visita);
			
			echo '<div class="visitas_box">
			
				<div class="visita_data"><b class="vermelho_destaque">Data: </b>'.$data_visita.'</div>
				<div class="visita_nome"><b>Visitante: </b>'.$nome_empresa.'</div>
				<div class="visita_email"><b>E-mail: </b>'.$email_empresa.'</div>
				<div class="visita_img">'.$img_empresa.'</div>
			
			</div>';
			
					
				
			}
			
			
			//atualiza na base de dados, informando que usuário já visualizou quem viu o perfil dele!
			$stmt2->close();
			$qry2 = "UPDATE visitas_perfil SET visualizada = 1 WHERE visitado_id = ?";
			$stmt2 = $mysqli2->prepare($qry2);
			$stmt2->bind_param('i',$_SESSION['userid']);
			$stmt2->execute();
			
			
			
		}
		else//se nao for VIP, mostra mensagem embaçada
		{
			if($mostra_assinatura == false)
			{
		
		//mostra_mensagem de acesso exclusivo para VIPS
		
			echo '
			<p>Veja a lista de empresas que visitaram seu perfil nos últimos dias:</p>
			<a href="membro_vip.php" target="new">
			<img src="gfx/ui/visitas_perfil/vip_acesso_visitas.png" alt="acesso somente para vips"/>
			</a>
			';
			
			
	$display_main->show_banner('Área Exclusiva para Membros VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Saiba Quais Empresas Visualizaram seu Currículo
		</div>
		
		<div class="descr_assinatura">
		Hoje em dia, informações privilegiadas fazem toda a diferença para sair na frente da concorrência quando o assunto é procurar emprego. 
		Com a possibilidade de saber <b>quais empresas visualizaram seu currículo</b> você terá acesso aos dados de contato das empresas que estão interessadas 
		em seu currículo. Dessa forma, com e-mails de possíveis empregadores em mãos, você poderá entrar em contato e demonstrar interesse em uma entrevista.
			
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="membro_vip.php" target="new"  class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');	
	$mostra_assinatura = true;
			}
			
			
		}
		
		
		
		
		
		
		
	}
	
	
		  if($tem_resultado == false)
		  {
			  
		  if($_SESSION['membro_vip_ativo'] == 1)//se é membro VIP ativo e nenhuma empresa visualizou o CV
		  {	
		  echo 'Nenhuma empresa visualizou seu currículo ainda através do site. Lembrando que, através do e-mail, pode ser que já tenha sido visualizado.';	
		  }
		  else//se nao for membro VIP... mostra informação e banner
		  {
			  echo '
			  <a href="membro_vip.php">
			  <p class="vermelho_destaque">Essa informação é <b>exclusiva para Membros VIP</b>. <b>Clique aqui</b> para criar sua conta</p>
			  
			  </a>
			  ';
	$display_main->show_banner('Área Exclusiva para Membros VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Saiba Quais Empresas Visualizaram seu Currículo
		</div>
		
		<div class="descr_assinatura">
		Hoje em dia, informações privilegiadas fazem toda a diferença para sair na frente da concorrência quando o assunto é procurar emprego. 
		Com a possibilidade de saber <b>quais empresas visualizaram seu currículo</b> você terá acesso aos dados de contato das empresas que estão interessadas 
		em seu currículo. Dessa forma, com e-mails de possíveis empregadores em mãos, você poderá entrar em contato e demonstrar interesse em uma entrevista.
			
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="membro_vip.php" target="new"  class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');				
		  
	
	  
		  
		  }
}




$display_main->painel_direita();
$display_main->fundo();
?>


