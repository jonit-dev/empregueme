<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');


$display_main = new display_main;//associa uma variával à classe de carregamento do layout

//update session vars
//session_start();
check_loggedin();//check if user is logged in!

$display_main->head();

?>
<!--CÓDIGO PRA SOMENTE PERMITIR NUMEROS NO INPUT-->
<script type="text/javascript">
   
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<?php


$display_main->topo();
$display_main->painel_esquerda();

echo "<h2>Meus dados</h2>";

//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if(isset($_GET['show_message']))//mostra a mensagem de alteração
{
	switch($_GET['tipo'])//verifica o tipo da mensagem
		{
			case 'sucesso'://se for de sucesso...
	$display_main->show_system_message($_GET['show_message'],'sucesso');
			break;	
			case 'error'://se for de sucesso...
	$display_main->show_system_message($_GET['show_message'],'error');
			break;	
			
			
				}
}

?>


<?php


//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$local_foto_perfil = '../upload/gfx/perfil/'.$_SESSION['userid'].'/perfil_fotos/foto_usuario.jpeg';
$display_main->conteudo('

<p>
<strong>Nome Completo:</strong> '.$_SESSION['nome'].'<br />
<strong>Apelido: </strong>'.$_SESSION['nickname'].'<br />
<strong>Telefone: </strong>'.$_SESSION['telefone'].' <a href="edit_profile.php?banner=alterar_telefone">[Alterar]</a><br />
<strong>CEP: </strong>'.$_SESSION['CEP'].'<a href="edit_profile.php?banner=alterar_CEP">[Alterar]</a><br />
<strong>Foto: </strong><img src="'.$local_foto_perfil.'" width=25 height=25/ ><a href="edit_profile.php?banner=alterar_foto">[Alterar]</a>
</p>');

//CÓDIGO DOS BANNERS
if(isset($_GET["banner"]))//se tá passando parametro por get do banner é porque quer mostrar o banner
{
	switch($_GET["banner"])//avalia conteúdo da variável
	{
		case 'alterar_telefone'://se quiser alterar o telefone..
			$display_main->show_banner('Modifique seu telefone','
				<form action="edit_profile.php" method="post">
					<ul>
						<li>Novo telefone: <input type="tel" name = "novo_telefone" type="number" onkeypress="return isNumber(event)" maxlength="9" placeholder="Somente números"/></li>
					</ul>				
						<input type="submit" value="Alterar telefone">
				</form>
				
			
			','small');
		break;
		
		case 'alterar_foto'://se quiser alterar o telefone..
			$display_main->show_banner('Modifique sua foto','Caro usuário, essa funcionalidade estará disponível em breve','small');
		
		break;
		
				case 'alterar_CEP'://se quiser alterar o telefone..
			$display_main->show_banner('Modifique seu CEP','
				<form action="edit_profile.php" method="post">
					<ul>
						<li>Novo CEP: <input name = "novo_cep" placeholder="Somente números" maxlength="8" onkeypress="return isNumber(event)"/>
					</ul>				
						<input type="submit" value="Alterar CEP">
				</form>
				
			
			','small');
		break;
		
	}
	
}

//ALTERAÇÕES QUE O BANNER DESENCADEIA FICAM AQUI


//---------------------------ALTERAR TELEFONE-----------------------------


if(isset($_POST['novo_telefone']))//se tem conteúdo nessa variável é porque o usuário deseja alterar o telefone
{

//secure query
@ $novo_telefone = mysqli_secure_query($_POST['novo_telefone']);

//valida novo telefone
if(checa_vazio(array($novo_telefone),array("Novo Telefone")))
{
	$display_main->show_system_message("Os seguintes campos encontram-se vazios: ".$resultados_vazios.". Por favor, tente novamente.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
}

if(strlen($novo_telefone) < 8)//n min de digitos validos é 8
{
		$display_main->show_system_message("O telefone inserido não possui 8 ou 9 dígitos. Por favor, tente novamente.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
}



//faz conexão com base de dados
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database.');

$qry = "UPDATE perfil_usuario SET telefone = ? WHERE userid = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('si',$novo_telefone,$_SESSION['userid']);
$stmt->execute();

if($stmt->affected_rows > 0){//se alterou alguma coluna
	//é porque deu certo
	session_refresh();//atualiza variáveis de sessão e carrega a pagina novamente, para mostrar alterações
	redireciona('edit_profile.php?show_message=Telefone atualizado com sucesso&&tipo=sucesso');
	}
		else
	{
	$display_main->show_system_message("Não foi possível realizar modificações. Provavelmente, o novo telefone é o mesmo que o antigo.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
	}
}

//-----------------------------ALTERAR CEP---------------


if(isset($_POST['novo_cep']))//se tem conteúdo nessa variável é porque o usuário deseja alterar o telefone
{

//secure query
@ $novo_cep = mysqli_secure_query($_POST['novo_cep']);

//primeiro valida dados

//valida novo telefone
if(checa_vazio(array($novo_cep),array("Novo CEP")))
{
	$display_main->show_system_message("Os seguintes campos encontram-se vazios: ".$resultados_vazios.". Por favor, tente novamente.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
}

if(strlen($novo_cep) < 8)//n min de digitos validos é 8
{
		$display_main->show_system_message("O CEP inserido não possui 8 dígitos. Por favor, tente novamente.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
}



//valida CEP
if (!validarCep($novo_cep))//se retornar false é pq é inválido
{
	$display_main->show_system_message("O CEP inserido é inválido. Tente novamente, inserindo somente números!",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;

}



//Inicia inserção de dados

//faz conexão com base de dados
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database.');

$qry = "UPDATE perfil_usuario SET CEP = ? WHERE userid = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('si',$novo_cep,$_SESSION['userid']);
$stmt->execute();

if($stmt->affected_rows > 0){//se alterou alguma coluna
	//é porque deu certo
	session_refresh();//atualiza variáveis de sessão e carrega a pagina novamente, para mostrar alterações
	redireciona('edit_profile.php?show_message=CEP atualizado com sucesso&&tipo=sucesso');
	}
	else//error
	{
		$display_main->show_system_message("Não foi possível realizar modificações. Provavelmente, o novo CEP é o mesmo que o antigo.",'error');
				//vamos mostrar o final do site, para não bugar
				$display_main->painel_direita();
				$display_main->fundo();
				exit;
	}
	
}







$display_main->painel_direita();
$display_main->fundo();





?>


