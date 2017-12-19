<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');


$nome = mysqli_secure_query($_POST['nome']);
$apelido = mysqli_secure_query($_POST['apelido']);
$email = mysqli_secure_query($_POST['email']);
$senha = mysqli_secure_query($_POST['senha']);
$estado = mysqli_secure_query($_POST['estado']);
$cidade = mysqli_secure_query($_POST['cidade']);
$estilo_comida = $_POST['estilo_comida'];


//joga tudo para uma array e começa a verificar se dados estão totalmente preenchidos ou são maior que 3 caracteres
$dados = array($nome,$apelido,$email,$senha,$estado,$cidade);
$nomes_dados = array("Nome","Apelido","E-mail","Senha","Estado","Cidade");
$tem_campo_vazio = false;
		$campos_vazios = "";
for($i=0;$i<count($dados);$i++)
	{

		
		if(empty($dados[$i]))//caso esteja vazio ou seja < 3 caracteres...
			{
				$tem_campo_vazio = true;
				$campos_vazios .= $nomes_dados[$i].", ";
			}
			
	}
	if($tem_campo_vazio == true)
		{
			$campos_vazios = rtrim($campos_vazios,", ");
			echo "Não foi possível criar sua nova conta. Os seguintes campos estão vazios: ".$campos_vazios."";		
			exit;
		}
		
//verifica se o usuário escolheu algum tipo de comida
if(empty($estilo_comida))
	{
			echo "Escolha algum tipo de culinária de sua preferência antes de criar sua conta.";		
			exit; 	
	}
		

//vamos verificar se o nome ou apelido já existem
//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "SELECT usu_nome FROM usuario WHERE usu_nome = ?";
$stmt = $mysqli->prepare($qry);
$mysqli->set_charset("utf8");
$stmt->bind_param('s',$nome);
$stmt->execute();
$stmt->bind_result($r_usu_nome);
$nome_existe = false;
while($stmt->fetch())
	{
		$nome_existe = true;	
	}

//se tem resultado é pq o nome já existe! Vamos echoar um erro
if($nome_existe == true)
	{
		echo "O nome selecionado já está em uso"; 	
		exit;
	}
	
//agora verifica que o apelido já existe	
	$qry = "SELECT usu_nickname FROM usuario WHERE usu_nickname = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$apelido);
$stmt->execute();
$stmt->bind_result($r_usu_apelido);
$apelido_existe = false;
while($stmt->fetch())
	{
		$apelido_existe = true;	
	}

//se tem resultado é pq o nome já existe! Vamos echoar um erro
if($apelido_existe == true)
	{
		echo "O apelido selecionado já está em uso. Por favor, tente utilizar outro."; 	
		exit;
	}
	

//verifica se o e-mail já está registrado na base de dados
	$qry = "SELECT usu_login FROM usuario WHERE usu_login = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$email);
$stmt->execute();
$stmt->bind_result($r_usu_email);
$email_existe = false;
while($stmt->fetch())
	{
		$email_existe = true;	
	}

//se tem resultado é pq o nome já existe! Vamos echoar um erro
if($email_existe == true)
	{
		echo "O e-mail selecionado já está em uso. Por favor, tente utilizar outro."; 	
		exit;
	}
	
	
	


//com tudo validado, vamos iniciar a criação da conta!

if($nome_existe == false && $apelido_existe == false && $email_existe == false)//se ele não tem nenhum dado duplicado....
{
//vamos iniciar nossa classe de gerenciamento de data
require_once('../classes/date_management.php');

$gerencia_data = new date_management;

$data_atual = $gerencia_data->gera_data(time(),'eng',false);//

$qry = "INSERT INTO usuario VALUES (null, ?, ?, ?, ?, ?, ?, 0, 0, 0, 0)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('isssss',$cidade,$nome,$apelido,$data_atual,$email,sha1($senha));
$stmt->execute();
$user_id = $mysqli->insert_id;

if($stmt->affected_rows >= 1)//se conseguiu inserir
	{

//vamos inserir no sistema

for($i=0;$i<count($_POST['estilo_comida']);$i++)
	{
		if($_POST['estilo_comida'][$i] != 0)//se nao for 0 o valor...vamos inserir!
			{
		
		$estilo_comida = $_POST['estilo_comida'][$i];
		$qry = "INSERT INTO user_culinaria VALUES (null,?,?)";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('ii',$user_id,$estilo_comida);
		$stmt->execute();
			}

	}

		

		
		echo "Conta criada com sucesso! Faça seu login.";//se tudo der certo, avise o usuário
	}
	else
	{
		echo "Erro na criação da conta.";	
	}
}//end 


?>