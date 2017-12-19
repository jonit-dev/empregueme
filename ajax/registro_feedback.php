<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$feedback_assunto = mysqli_secure_query($_POST['feedback_assunto']);//captura variável passada pelo ajax
$feedback_txt = mysqli_secure_query($_POST['feedback_txt']);//captura variável passada pelo ajax
$userid = mysqli_secure_query($_POST['userid']);//captura variável passada pelo ajax

if(empty($feedback_txt) || !isset($feedback_txt))//se o feedback está vazio, vamos enviar msg de erro
	{
		$resultado = "Por favor, envie um feedback com a descrição detalhada. Só assim podemos melhorar nossos serviços ainda mais! Obrigado.";
		echo $resultado; //envia resultado a usuário
		exit; 
	}

//se nao está vazio, vamos registrar o feedback na BD e depois mandar mensagem confirmatória

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "INSERT INTO criticas VALUES(null, ?, ?, ? )";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('iss',$userid,$feedback_assunto,$feedback_txt);
$stmt->execute();

if($stmt->affected_rows > 0)//se realmente inseriu
	{
		$resultado = 'Sua mensagem foi enviada com sucesso! Sua opinião será usada para melhorar cada vez mais nossos serviços. Muito obrigado!';
		//retorna resultado para o AJAX
		echo $resultado;
		exit;
	}
	else
	{
		$resultado = 'Sua mensagem não pode ser enviada. Por favor, tente novamente.';
		echo $resultado;
		exit;
	}







?>