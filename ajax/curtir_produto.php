<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$produto_id = mysqli_secure_query($_POST['produto_id']);
$userid = mysqli_secure_query($_POST['userid']);
//captura variável passada pelo ajax




//A CONEXÃO NO AJAX TEM QUE SER FEITA DESSA FORMA, SENÃO NÃO FUNCIONA!
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


//primeiro, verifica se vc já curtiu o comentário

$qry = "SELECT userid, produto_id FROM produtos_like WHERE userid=? AND produto_id = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ii',$userid,$produto_id);
$stmt->execute();
$stmt->bind_result($r_userid,$r_produto_id);

$tem_resultado = false;
while($stmt->fetch())
	{
		$tem_resultado = true;//se tiver resultado é porque já curtimos, então não faça nada!!
		echo 'error';//retorna mensagem de erro pra falar pro ajax enviar mensagem de erro pro usuário
		exit;
	}

if($tem_resultado == false)//se nao tiver resultado é porque ainda não curtimos o comentário, então vamos curtir!
{
	clean_stmt();//fecha stmt
	$qry = "INSERT INTO produtos_like VALUES (NULL, ?,?)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ii',$userid,$produto_id);
$stmt->execute();


		//vamos registrar no comentário mais um like!
		
		clean_stmt();//fecha stmt
		$qry = "UPDATE produtos SET produtos_likes = produtos_likes + 1 WHERE produto_id = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$produto_id);
		$stmt->execute();

		
				clean_stmt();//fecha stmt
				$qry = "SELECT produtos_likes FROM produtos WHERE produto_id = ?";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('i',$produto_id);
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