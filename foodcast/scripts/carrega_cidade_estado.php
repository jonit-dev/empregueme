<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');

//pega variaveis passadas por post
$acao = mysqli_secure_query($_POST['acao']);


//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");



switch($acao)
{
	case 'carrega_estado'://cliente está requisitando estados para construção de formulário
			$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
			$stmt = $mysqli->prepare($qry);
			$stmt->execute();
			$stmt->bind_result($r_sigla,$r_cod_estado);
			$tem_resultado = false;
			$html_string = '<option value="0">Selecione seu estado primeiro...</option>';

			while($stmt->fetch())
				{
					$tem_resultado = true;
					
					$html_string .= '<option value="'.$r_cod_estado.'">'.$r_sigla.'</option>';
						
				}
				if($tem_resultado == true)
					{
				echo $html_string;
					}
					else
					{
						echo "Erro ao carregar lista de estados";	
					}
	break;	
	
	case 'carrega_cidades':
	
		$estado_selecionado = $_POST['estado_selecionado'];
	
		$qry = "SELECT cid.nome, cid.cod_cidades FROM cidades as cid WHERE estados_cod_estados = ?";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('i',$estado_selecionado);
			$stmt->execute();
			$stmt->bind_result($r_cidade_nome,$r_cod_cidades);
			$tem_resultado = false;
			$html_string = "";
			while($stmt->fetch())
				{
					$tem_resultado = true;
					$html_string .= '<option value="'.$r_cod_cidades.'">'.$r_cidade_nome.'</option>';
						
				}
				if($tem_resultado == true)
					{
				echo $html_string;
					}
					else
					{
						echo "Erro ao carregar lista de cidades";	
					}
	break;
	
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
			echo $html_string;
				}
				else
					{
						echo "Erro ao carregar lista de cidades";	
					}
	
	break;
}




?>