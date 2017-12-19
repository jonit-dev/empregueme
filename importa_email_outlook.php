<?php
//carrega arquivo com o layout

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');



$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head('@import url(\'css/lista_email.css\');');

//verifica se usuario esta logado
check_loggedin();


$display_main->topo();
$display_main->painel_esquerda();

//conteúdo

echo '<h2>Expanda seus contatos e melhore suas oportunidades!</h2>';


//redireciona usuário para main, se importou email = 1 ( ou seja, se já importou);

if($_SESSION['importou_email'] == 1)
{
	redireciona('main.php');	
}


if($_SESSION['tipo_conta'] == 0)
{
$link_skip = '<a href="main.php?tipo=usuario" class="texto_verde" id="email_list_skip">Agora não, obrigado</a>';
}
if($_SESSION['tipo_conta'] == 1)
{
$link_skip = '<a href="main.php?tipo=empresa" class="texto_verde" id="email_list_skip">Agora não, obrigado</a>';	
}

//***************************************MSN START********************************
$client_id = '000000004811A9D0';
$client_secret = 'F7ME5YZ3b99Zm8gQrfu1DUrsnjBNcbo9';
$redirect_uri = 'http://www.empregue-me.com/novo/oauth-hotmail.php';
$urls_ = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;

$nomecurto = explode(' ',$_SESSION['nome']);
$msn_link =  '<a href="'.$urls_.'" ><img style="margin-left:20%;" src="gfx/ui/outlook.png"/></a>';
	echo '
	<p>Olá '.$nomecurto[0].', tudo certo? Você sabia que <strong>77% das oportunidades de trabalho são provenientes de amigos próximos?</strong> Por isso que ressaltamos que uma das melhores formas de se conseguir uma vaga de emprego <strong>é a partir da criação de sua rede de relacionamentos profissionais</strong>.
	Seguem abaixo alguns dos principais motivos pelos quais você já deveria ter criado a sua:	
	</p>	
		<ul>
			<li>Quanto <strong>mais amigos</strong> você trouxer, maior a chance de algum deles conhecer uma <strong>oportunidade</strong> e anunciar por aqui</li>
			<li>Uma rede de relacionamentos profissionais pode lhe ajudar a encontrar as melhores oportunidades mais facilmente, através da troca de informações</li>
		</ul>
	<p><span style="text-decoration:underline;">Clique abaixo</span> para importar seus contatos do hotmail e desfrutar todos os benefícios de uma boa rede de contatos:</p>
	'.$msn_link.'
		<br />
<br />
<br />
      
		
				'.$link_skip.'';


//***************************************MSN ENDS********************************
?>
    

</body>
</html>

<?php
///

$display_main->painel_direita();
$display_main->fundo();



?>