<?php

//script semanal para renovar crédito de empresas free


//conecta diretamente
require_once('../classes/connect_class.php');
require_once('../funcoes/db_functions.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "UPDATE creditos_contato_empresa SET creditos = 3";
$stmt = $mysqli->prepare($qry) or die("Could not prepare query");
$stmt->execute();
$stmt->close();
$mysqli->close();




?>