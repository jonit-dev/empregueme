<?php

include("PHPMailerAutoload.php");
//instancia a objetos
$mail = new PHPMailer();
// mandar via SMTP
$mail->IsSMTP();
$mail->Charset = 'UTF-8';
// Setando o conteudo
$mail->IsHTML(true);
// Seu servidor smtp
$mail->Host = "mail.empreguemeagora.com.br";
// habilita smtp autenticado
$mail->SMTPAuth = true;
$mail->port = 26;
// usuário deste servidor smtp
$mail->Username = "empregueme@empreguemeagora.com.br";
$mail->Password = "4htiaIr6o61M"; // senha
//email utilizado para o envio 
//pode ser o mesmo de username
$mail->From = "empregueme@empreguemeagora.com.br";
$mail->FromName = "empregue-me";

//Enderecos que devem ser enviadas as mensagens
//$mail->AddAddress("diogokdc@gmail.com", "Diogo");
//$mail->AddAddress("joaopaulofurtado@live.com", "João Paulo");
//wrap seta o tamanhdo do texto por linha
//$mail->WordWrap = 50;
?>
