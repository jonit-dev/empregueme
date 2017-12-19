<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');

//pega variaveis passadas por post
$acao = mysqli_secure_query($_POST['acao']);


//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");


if($acao == "todos")
	{
	$html_response = "";

	$qry = "SELECT prato_id FROM pratos LIMIT 10";//10 primeiros pratos apenas
	$stmt = $mysqli->prepare($qry);
	$stmt->execute();
	$stmt->bind_result($prato_id);
	$tem_resultado = false;
	while($stmt->fetch())
		{		
		$tem_resultado = true;
			$html_response .= "$prato_id#";
		}
	
	if($tem_resultado == true)//se tem prato para carregar
		{
			echo $html_response;	//vamos enviar ao usuário
		}
	}



?>