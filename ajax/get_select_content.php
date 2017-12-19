<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');

$categoria_id = $_POST['categoria_id'];//captura variável passada pelo ajax

//vamos iniciar nova conexão com a base de dados para capturar as subcategorias
			
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();			
			
			
			$qry = "SELECT * FROM subcategoria WHERE categoria_id = ? ORDER BY subcategoria_nome ASC";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('i',$categoria_id);
			$stmt->execute();
			$stmt->bind_result($r_id_categoria,$r_nome_subcategoria,$r_id_subcategoria);
			
			//se tiver resultado
			$tem_resultado = false;
			$resultado = '';//cria variável para armazenar opções retornadas pela subcategoria
			while($stmt->fetch())//quando tiver resultado
			{
				$tem_resultado = true;
				$resultado .= '<option value="'.$r_id_subcategoria.'">'.$r_nome_subcategoria.'</option>';
				
				
			}		
		
		$stmt->close();
		$mysqli->close();



//retorna resultado para o AJAX
echo $resultado;




?>