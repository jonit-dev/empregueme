<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$apelido_string = mysqli_secure_query($_POST['nickname']);//captura variável passada pelo ajax

//$apelido_string = "'%".$apelido."%'";//prepara query

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "SELECT usu_nickname FROM usuario WHERE usu_nickname = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$apelido_string);
$stmt->execute();
$stmt->bind_result($r_nickname);
$tem_resultado = false;
while($stmt->fetch())
{
	$tem_resultado = true;	
	
}

if($tem_resultado == false)
{
	echo 0;//nickname vazio	
}
else
{
	echo 1;//nickname ocupado	
}


?>