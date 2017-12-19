<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$search_tag = mysqli_secure_query($_POST['qry']);//captura variável passada pelo ajax

$search_tag = "'%".$search_tag."%'";


//vamos iniciar nova conexão com a base de dados para capturar tags
			$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database');
			$qry = "SELECT tag_name FROM tags WHERE tag_name LIKE $search_tag";
			$stmt = $mysqli->prepare($qry) or die ('Could not prepare qry');
			$stmt->execute();
			$stmt->bind_result($r_tag_name);
			
		
			//se tiver resultado
			$tem_resultado = false;
			$resultado = '';//cria variável para armazenar opções retornadas pela subcategoria
			while($stmt->fetch())//quando tiver resultado
			{
				$tem_resultado = true;
				$resultado .= '<a href="#"><span class="not_selected" value="'.$r_tag_name.'">'.$r_tag_name.'</span></a>';
				
				
			}		
		
		$stmt->close();
		$mysqli->close();



//retorna resultado para o AJAX
echo $resultado;




?>