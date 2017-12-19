<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$comentario_id = mysqli_secure_query($_POST['comentario_id']);
$userid = mysqli_secure_query($_POST['userid']);
//captura variável passada pelo ajax




//A CONEXÃO NO AJAX TEM QUE SER FEITA DESSA FORMA, SENÃO NÃO FUNCIONA!
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


//primeiro, verifica se vc já curtiu o comentário

$qry = "SELECT userid, comentario_id FROM comentarios_like WHERE userid=? AND comentario_id = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ii',$userid,$comentario_id);
$stmt->execute();
$stmt->bind_result($r_userid,$r_comentario_id);

$tem_resultado = false;
while($stmt->fetch())
	{
		$tem_resultado = true;//se tiver resultado é porque já curtimos, então não faça nada!!
	}

if($tem_resultado == false)//se nao tiver resultado é porque ainda não curtimos o comentário, então vamos curtir!
{
	clean_stmt();//fecha stmt
	$qry = "INSERT INTO comentarios_like VALUES (NULL, ?,?)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ii',$userid,$comentario_id);
$stmt->execute();


		//vamos registrar no comentário mais um like!
		
		clean_stmt();//fecha stmt
		$qry = "UPDATE comentarios SET likes = likes + 1 WHERE comentario_id = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$comentario_id);
		$stmt->execute();

		
				clean_stmt();//fecha stmt
				$qry = "SELECT likes FROM comentarios WHERE comentario_id = ?";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('i',$comentario_id);
				$stmt->execute();
				$stmt->bind_result($r_likes);
				
				$tem_resultado = false;
				while($stmt->fetch())//enquanto tiver resultado
					{
						$tem_resultado = true;
						echo $r_likes;
					}
														
							
								
								
					
			
		
	

}




//retorna resultado para o AJAX




?>