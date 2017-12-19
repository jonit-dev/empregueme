<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$userid = mysqli_secure_query($_POST['userid']);//captura variável passada pelo ajax


//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


			$qry = "SELECT usu_login,usu_telefone1,usu_telefone2 FROM usuario WHERE usu_codigo = ?";
			$stmt = $mysqli->prepare($qry) or die ('Could not prepare qry');
			$stmt->bind_param('i',$userid);
			$stmt->execute();
			$stmt->bind_result($r_usu_login,$r_usu_telefone1,$r_usu_telefone2);
			
		
			//se tiver resultado
			$tem_resultado = false;
		
			while($stmt->fetch())//quando tiver resultado
			{
				$tem_resultado = true;
			
				
			}		
		
		$stmt->close();
		$mysqli->close();



//retorna resultado para o AJAX
if($tem_resultado == true)
	{
		echo '<strong>E-mail: </strong>'.$r_usu_login."<br />
				<strong>Telefone Principal: </strong>".$r_usu_telefone1."<br />
				<strong>Telefone Secundário: </strong>".$r_usu_telefone2."<br />
";	
	}
else
{
	echo 'error';	
}




?>