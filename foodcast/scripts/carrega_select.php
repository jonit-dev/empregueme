<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');

//pega variaveis passadas por post
$carregar_oque = mysqli_secure_query($_POST['carregar']);

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");

switch($carregar_oque)
{
	case 'carrega_estilo_comida':
		$qry = "SELECT culinaria_id, culinaria_nome FROM tipo_culinaria";
		$stmt = $mysqli->prepare($qry);
		$stmt->execute();
		$stmt->bind_result($cul_id,$cul_nome);
		
		$html_string = '';
		$tem_resultado = false;
		while($stmt->fetch())
			{
				$tem_resultado = true;
				$html_string .= '<option value="'.$cul_id.'" >'.$cul_nome.'</option>';	
			}
			
			if($tem_resultado == true)
				{
			echo $html_string;//se tudo for carregado corretamente, envie para o usuário os dados
				}
				else
					{
						echo "Erro ao carregar lista de estilos de culinária";	
					}
	
	break;
}




?>