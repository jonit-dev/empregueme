<?php
//SESSION SCRIPTS





function session_clean()
{
//clean all session vars and destroy session
foreach($_SESSION as $key => $value)//remove todas as variáveis de sessão
{
unset($_SESSION[$key]);	
}
session_destroy(); //finaliza nossa sessão	
}

function check_loggedin()//check if a user is really logged in (avoid page acess without login
{
//check if user has directly for this page, without login!
if (empty($_SESSION['login']) || !isset($_SESSION['login']))
{
 header("Location:index.php");
 exit;
}	
}

function session_refresh()//atualiza todas as variáveis de função
{
//primeiro contecta-se à DB
//faz conexão com base de dados
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database.');
$qry = "SELECT userid, nome_completo, estado_id, cidade_id, nickname, telefone, ddd, CEP, foto, n_vendas, n_compras, ruaav, bairro, n_residencial FROM perfil_usuario WHERE userid=?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$_SESSION['userid']);
$stmt->execute();
$stmt->bind_result($r_userid,$r_nome,$r_estado_id,$r_cidade_id,$r_nickname,$r_telefone,$r_ddd,$r_cep,$r_foto,$r_n_vendas,$r_n_compras,$r_ruaav,$r_bairro,$r_n_residencial);

$tem_resultado = false;
	  while($stmt->fetch())//se houver resultado
	  {
	  $tem_resultado = true;
	  
	  //começa a atualizar variáveis de sessão$_SESSION['nome'] = $r_nome;
$_SESSION['nome'] = $r_nome;
$_SESSION['estado_id'] = $r_estado_id;
$_SESSION['cidade_id'] = $r_cidade_id;
$_SESSION['nickname'] = $r_nickname;
$_SESSION['telefone'] = $r_telefone;
$_SESSION['CEP'] = $r_cep;
$_SESSION['foto'] = $r_foto;
$_SESSION['n_vendas'] = $r_n_vendas;
$_SESSION['n_compras'] = $r_n_compras;
$_SESSION['ruaav'] = $r_ruaav;
$_SESSION['bairro'] = $r_bairro;
$_SESSION['n_residencial'] = $r_n_residencial;
	  }
	  	  
	  $stmt->close();
	  $mysqli->close();//termina requisição
	  
}//end functions



?>