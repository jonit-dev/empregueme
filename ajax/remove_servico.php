<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');

$id_servico = mysqli_secure_query($_POST['id_servico']);

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "UPDATE freelancer set free_ativo = 0 WHERE free_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$id_servico);
$stmt->execute();

if($stmt->affected_rows > 0)
	{
	//se deletou alguma coisa
	echo 'sucesso';	
	}
	else
	{
	echo 'erro';	
	}





?>