<?php

require_once('../funcoes/db_functions.php');

header('Content-type: text/html; charset=utf-8');

//$estado = mysqli_secure_query($_POST['estado']);//captura variável passada pelo ajax
$cidade = mysqli_secure_query($_POST['cidade']); //captura variável passada pelo ajax
//$telefone = mysqli_secure_query($_POST['telefone']);//captura variável passada pelo ajax
//$ddd = mysqli_secure_query($_POST['ddd']);//captura variável passada pelo ajax
$CEP = mysqli_secure_query($_POST['CEP']); //captura variável passada pelo ajax
//$endereco = mysqli_secure_query($_POST['endereco']);//captura variável passada pelo ajax
//$bairro = mysqli_secure_query($_POST['bairro']);//captura variável passada pelo ajax
//$n_residencial = mysqli_secure_query($_POST['n_residencial']);//captura variável passada pelo ajax
$userid = mysqli_secure_query($_POST['userid']); //captura variável passada pelo ajax
//VALIDAÇÃO DE DADOS
require_once('../funcoes/top_functions.php');
if (checa_vazio(array($cidade), array('Cidade'))) {
    echo "Os seguintes campos encontram-se vazios: " . $resultados_vazios . ". Por favor, tente novamente.";
    exit;
}


if ($cidade == "") {
    echo 'erro:estadocidade';
    exit;
}


//inicia conexão para atualizar dados
require_once('../classes/connect_class.php');
$connect = new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "UPDATE usuario SET cid_codigo = ?, usu_cep= ? WHERE usu_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('isi', $cidade, $CEP, $userid);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo 'sucesso';
} else {
    echo 'nao_alterou';
}
?>