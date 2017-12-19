<?php

require_once('../funcoes/db_functions.php');

header('Content-type: text/html; charset=utf-8');

$estado_id = $_POST['estado_id']; //captura variável passada pelo ajax
//vamos iniciar nova conexão com a base de dados para capturar as subcategorias

require_once('../classes/connect_class.php');
$connect = new ConnectionFactory;
$mysqli = $connect->getConnection();
mysqli_set_charset($mysqli, "utf8");


$qry = "SELECT cod_cidades,nome FROM cidades WHERE estados_cod_estados = ? ORDER BY nome ASC";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i', $estado_id);
$stmt->execute();
$stmt->bind_result($r_id, $r_nome);

//se tiver resultado
$tem_resultado = false;
$resultado = ''; //cria variável para armazenar opções retornadas pela subcategoria
while ($stmt->fetch()) {//quando tiver resultado
    $tem_resultado = true;
    $resultado .= '<option value="' . $r_id . '">' . $r_nome . '</option>';
}

$stmt->close();
$mysqli->close();



//retorna resultado para o AJAX
echo $resultado;
?>