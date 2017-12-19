<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("phpmailer/class.phpmailer.php");

ini_set('display_errors', 1); error_reporting(E_ALL);

$mail = new PHPMailer();
 
// Charset para evitar erros de caracteres
$mail->Charset = 'UTF-8';
 
// Dados de quem está enviando o email
$mail->From = 'emailfrom@email.com';
$mail->FromName = 'Nome de quem enviou';
 
// Setando o conteudo
$mail->IsHTML(true);
// Validando a autenticação
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host     = "192.185.176.30";
//$mail->Port     = 465;
$mail->Username = 'admin@sociallia.com.br';
$mail->Password = '32258190';	
 
// Setando o endereço de recebimento
$mail->AddAddress('joaopaulofurtado@live.com', 'JP');
 
// Enviando o e-mail
if ($mail->Send())
    echo 'E-mail enviado com sucesso';
else
    echo 'Erro ao enviar e-mail';
?>
</body>
</html>