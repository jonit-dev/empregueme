<?php


	require_once('../classes/connect_class.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

//------VARIÁVEIS DE CONFIGURAÇÃO---------/
$max_envio_hora = 250;

//------------------------//


//Conecta com base de dados e carrega lista de emails que não foram enviados


$qry = "SELECT lista_email.email_contato FROM lista_email";//vamos selecionar os endereços para os quais não enviamos nada ainda
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($r_email_contato);

$contatos = array();
$i=0;
while($stmt->fetch())//quando tiver resultado
	{
		$contatos[$i] = $r_email_contato;
		$i++;
	}

//agora escreve em arquivo
$fid = fopen('lista.txt','wb');

for($i=0;$i<1999;$i++)
	{
		fwrite($fid,$contatos[$i]);
		fwrite($fid,PHP_EOL);	
	}
	
	fclose($fid);

?>