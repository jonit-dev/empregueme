<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$userid = mysqli_secure_query($_POST['empresaid']);//captura variável passada pelo ajax




//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

//vamos diminuir 1 crédito da empresa
$qry = "UPDATE creditos_contato_empresa SET creditos = creditos - 1 WHERE empresa_id = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$userid);
$stmt->execute();


if($stmt->affected_rows > 0)
{
	  //retorna resultado para o AJAX
	  echo 'success';
}
else
{
echo 'error->'.$userid;	
}




?>