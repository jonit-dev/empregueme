<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/top_functions.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}
?>

<?php


$display_main->head('','');

$display_main->topo();
$display_main->painel_esquerda();

//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
    switch ($_GET['tipo']) {//verifica o tipo da mensagem
        case 'sucesso'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'sucesso');
            break;
        case 'error'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'error');
            break;
    }
}

//verifica se o usuário é membro VIP
if(!custom_check_vip())
{	
	echo '<h1>Envie sua Mensagem Para a Empresa Anunciante</h1>
	
	<p>Quer enviar uma mensagem personalizada para as empresas anunciantes? Crie sua conta VIP! Com ela você poderá entrar em contato diretamente com as empresas, 
		usando seu poder de convencimento para dizer o porquê você merece uma entrevista.</p>
		
		<center>
		<a href="membro_vip.php" class="botao_cta">Criar Conta VIP</a>
		</center>
	';

	$display_main->show_banner('Área Exclusiva para Membros VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Envie Mensagens para Empresas Anunciantes
		</div>
		
		<div class="descr_assinatura">
		Quer enviar uma mensagem personalizada para as empresas anunciantes? Crie sua conta VIP! Com ela você poderá entrar em contato diretamente com as empresas, 
		usando seu poder de convencimento para dizer o porquê você merece uma entrevista.
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="membro_vip.php" target="_self"  class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');
	exit;
	

	
}

if(isset($_GET['id']))
{
$_SESSION['vaga_envia_msg'] = $_GET['id'];//adiciona para variavel de sessão para podermos usar qd quiser..
//sempre que entrar numa vaga nova vai atualizar	
}

?>
<h1>Envie sua Mensagem Para a Empresa Anunciante</h1>

<p>Quer dizer algo para empresa anunciante? Envie sua mensagem por aqui! Lembre-se que para enviar seus dados de currículo você deve clicar no botão candidatar!</p>

<form action="envia_mensagem_empresa.php" method="post">

<ul>
	<li>Assunto: <input type="text" name="msg_titulo" placeholder="O título de sua mensagem" style="width:200px;"/> </li>
    <li>Mensagem:<br />
	<textarea name="msg_descricao" placeholder="Escreva sua mensagem" maxlength="400" style="width:400px;height:200px;"></textarea>
    
    </li>
    
    <br />
    <?php
	echo '<input type="hidden" name="vaga_id" value="'.mysqli_secure_query($_SESSION['vaga_envia_msg']).'"/>';
	?>

    <input type="submit" style="margin-left:90px;" class="botao_cta" value="Enviar"/>

</ul>


</form>



<?php       

//------------------ GERENCIA ENVIO DA MENSAGEM----------------------

if(isset($_POST['msg_titulo']))
{
	//prepara variaveis
	@$assunto = mysqli_secure_query($_POST['msg_titulo']);
	@$mensagem = mysqli_secure_query($_POST['msg_descricao']);
	@$vag_codigo = mysqli_secure_query($_POST['vaga_id']);
	
//inicia validação de dados
    if (checa_vazio(array($assunto,$mensagem), array('Assunto','Mensagem'))) {
		$display_main->noty('Não foi possível enviar a mensagem pois os seguintes campos encontram-se vazios:'.$resultados_vazios,'error','topCenter',6000);
        exit;
    }




//envia para empresa
$mysqli = mysqli_full_connection();
$mysqli->set_charset('utf8');
$qry = "SELECT vag_email FROM vagas WHERE vag_codigo = ?";
	
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$vag_codigo);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($r_vag_email);
	
	while($stmt->fetch())
		{
		$vaga_email = $r_vag_email;	
		}
	
	
	//inicia disparo de email
	
	  require_once('php_mailer/EmailConfig.php');
	  
	  //seta endereço de quem enviou
	  $endereco_envio = $_SESSION['login'];
	  

// Setando o endereço de recebimento
$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";
    $mail->AddAddress($endereco_envio, 'Candidato');
    $mail->Subject = $assunto;
    $mail->Body = $mensagem;
	$mail->AddReplyTo( $endereco_envio, $_SESSION['nome']);
    $mail->From = $_SESSION['login'];
    $mail->FromName = $_SESSION['nome'];
    if ($mail->send()) { //envia e-mail para o usuario com sua senha
        $mail->ClearAllRecipients();
        $display_main->noty('E-mail enviado com sucesso para o e-mail:'.$vaga_email,'success','topCenter',6000);
		
    } else {
			
			$display_main->noty('Ocorreu um problema ao enviar a mensagem para a empresa. Por favor, notifique o ocorrido para o e-mail sac@empreguemeagora.com.br que resolveremos rapidamente','error','topCenter',6000);

    }

	
}


$display_main->painel_direita();
$display_main->fundo();
?>


