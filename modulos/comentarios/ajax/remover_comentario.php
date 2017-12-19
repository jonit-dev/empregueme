<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$comment_id = mysqli_secure_query($_POST['comment_id']);
//captura variavel passada pelo ajax

//A CONEXÃO NO AJAX TEM QUE SER FEITA DESSA FORMA, SENÃO NÃO FUNCIONA!
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


$qry = "DELETE FROM comentarios WHERE comentario_id = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$comment_id);
$stmt->execute();

if($stmt->affected_rows > 0)//se deletou comentario
	{
		//vamos apagar da lista de comentarios_like
		clean_stmt();
		$qry = "DELETE FROM comentarios_like WHERE comentario_id = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$comment_id);
		$stmt->execute();
		
		
		echo 'sucesso';//retorna ID do comentario
	}
	else
	{
		echo "error";	
	}

		$stmt->close();
		$mysqli->close();



//retorna resultado para o AJAX




?>