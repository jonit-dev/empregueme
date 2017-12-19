<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$comment_id = mysqli_secure_query($_POST['comment_id']);
$userid = mysqli_secure_query($_POST['userid']);


//captura variavel passada pelo ajax

//A CONEXÃO NO AJAX TEM QUE SER FEITA DESSA FORMA, SENÃO NÃO FUNCIONA!
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


$qry = "SELECT comentario_id FROM comentarios WHERE userid = ? AND comentario_id = ?";//tenta verificar se o comentário tem a mesma userid que o usuário que está tentando remove lo
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ii',$userid,$comment_id);
$stmt->execute();
$stmt->bind_result($r_comentario_id);

$tem_comentario = false;
while($stmt->fetch())
	{
		$tem_comentario = true;//se tem é porque o comentário é do cara que quer remover mesmo.. vamos prosseguir com a remoção	
		
	}//end while


if($tem_comentario == false)
{
	echo 'not_user';//echoa error;	
}
else
{
clean_stmt();//fecha stmt
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



	
}


		//$stmt->close();
		//$mysqli->close();



//retorna resultado para o AJAX




?>