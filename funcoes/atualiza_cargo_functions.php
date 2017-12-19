<?php
//------------ ATUALIZACAO DE CARGO (Se estiver como Nenhum)-------------//
require_once('db_functions.php');
require_once('session_functions.php');
require_once('url_functions.php'); //para lidarmos com a sessão de usuário


function atualiza_cargo()
{
$mysqli = mysqli_full_connection();
if(isset($_SESSION['curriculo']) && $_SESSION['curriculo'] != 0)//se user está logado e com cv cadastrado
	{
		
		//consulta cargo do usuário
		
		$qry = "SELECT formacao.fk_area_formacao_id FROM formacao, curriculos as cur WHERE 
		
		cur.fk_usu_codigo = ? AND
		cur.fk_formacao_id = formacao.id";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$_SESSION['userid']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($habilidades_id);

while ($stmt->fetch()) {
 $habilidades_id = $habilidades_id; //capta habilidades ID do usuário
 
}
//se for igual a 'nenhum', redirecione para atualizar o CV

if($habilidades_id == 259)
	{
		redireciona('atualiza_cargo.php');	
	}





$stmt->close();
	$mysqli->close();	
		
		
	}

}
?>