<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$comentario = mysqli_secure_query($_POST['message']);
$userid = mysqli_secure_query($_POST['userid']);
$produto_id = mysqli_secure_query($_POST['produto_id']);
//captura variável passada pelo ajax




//A CONEXÃO NO AJAX TEM QUE SER FEITA DESSA FORMA, SENÃO NÃO FUNCIONA!
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "INSERT INTO comentarios VALUES (NULL,?, ?,?,0)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('isi',$produto_id,$comentario,$userid);
$stmt->execute();
$comment_id = $stmt->insert_id;//vamos capturar id do comentário para enviar também

if($stmt->affected_rows > 0)//se inseriu comentario
	{
		echo $comment_id;//retorna ID do comentario
	}
	else
	{
		echo "error";	
	}


//retorna resultado para o AJAX




?>