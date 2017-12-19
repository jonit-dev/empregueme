<?php
session_start();
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/funcoes_estruturais.php');

if (!check_session()) {
    session_start();
}

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}

$display_main->head('', '');
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
/*
  if ($_SESSION['importou_email'] == 1) {
  redireciona('main.php');
  }
 */
$link_skip = "";
if ($_SESSION['tipo_conta'] == 0) {
    $link_skip = '<a href="main.php?tipo=usuario" class="texto_verde" id="email_list_skip">Pular essa etapa</a>';
}
if ($_SESSION['tipo_conta'] == 1) {
    $link_skip = '<a href="main.php?tipo=empresa" class="texto_verde" id="email_list_skip">Pular essa etapa</a>';
}



$nomecurto = explode(' ', $_SESSION['nome']);
echo '<h2>Expanda seus contatos e faça bons negócios!</h2>';
echo '
	<p>Olá ' . $nomecurto[0] . ', tudo certo? Você sabia que <strong>77% das oportunidades de trabalho são provenientes de amigos próximos?</strong> Por isso que ressaltamos que uma das melhores formas de se conseguir uma vaga de emprego <strong>é a partir da criação de sua rede de relacionamentos profissionais</strong>.
	Seguem abaixo alguns dos principais motivos pelos quais você já deveria ter criado a sua:	
	</p>	
		<ul>
			<li>Quanto <strong>mais amigos</strong> você trouxer, maior a chance de algum deles conhecer uma <strong>oportunidade</strong> e anunciar por aqui</li>
			<li>Uma rede de relacionamentos profissionais pode lhe ajudar a encontrar as melhores oportunidades mais facilmente, através da troca de informações</li>
		</ul>
		
		
	<p><span style="text-decoration:underline;">Clique abaixo</span> para compartilhar o empregue-me no seu facebook e desfrutar todos os benefícios de uma boa rede de contatos:</p>';
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=139718396183875&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<center>

<div class="fb-send" data-href="http://empregue-me.com/novo/index.php?fonte=facebook" data-width="200" data-height="200" data-colorscheme="light"></div>   
  
  <br />

    <?php 

	
	echo $link_skip;
	
	
	//código pra fazer clicar no botão de compartilhar e já ir para as vagas
	echo '<script type="text/javascript">
	$(document).ready(function(e) {
    
	$("#sharefb").click(function(){
		
window.location.replace(\'main.php?tipo=usuario\')
		
		
		});
	
	
});//end ready
	
	
	</script>';
	
	
	 ?>
</center>
<?php
$display_main->painel_direita();
$display_main->fundo();
?>


