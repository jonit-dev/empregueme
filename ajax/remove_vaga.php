<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');

$id_vaga = mysqli_secure_query($_POST['id_vaga']);

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "UPDATE vagas set vag_ativo = 0 WHERE vag_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$id_vaga);
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