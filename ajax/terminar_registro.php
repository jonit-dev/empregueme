<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');

$estado = $_POST['estado'];//captura variável passada pelo ajax
$cidade = $_POST['cidade'];//captura variável passada pelo ajax
$telefone = $_POST['telefone'];//captura variável passada pelo ajax
$cep = $_POST['CEP'];//captura variável passada pelo ajax
$userid = $_POST['userid'];

//vamos iniciar nova conexão com a base de dados para capturar as subcategorias
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();


			$qry = "UPDATE perfil_usuario SET estado_id=?, cidade_id=?, telefone=?, CEP=? WHERE userid=?";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('iissi',$estado,$cidade,$telefone,$cep,$userid);
			$stmt->execute();
				
			if($stmt->affected_rows > 0)//se conseguiu atualizar com sucesso
				{
					echo "sucesso";
				}
				else
				{
					echo "error";	
				}
		
		$stmt->close();
		$mysqli->close();

?>