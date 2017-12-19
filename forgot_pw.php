<?php
require_once('class_display.php');
require_once('funcoes/email_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/db_functions.php');

//RESET PASSWORD SCRIPT
require_once('funcoes/user_functions.php');

$display_site = new display;
$display_site->top();

//pega variável do formulário
@ $usu_login = mysqli_secure_query($_POST['login']);

//valida
if (!check_email_address(($usu_login))) {
    redireciona('index.php?error=20'); //20= email invalido
}

//gera password aleatório
$random_pw = random_password(10);
$usu_senha = sha1($random_pw);
//pega email e procura se existe na BD
$mysqli = mysqli_full_connection();

$qry = "SELECT usu_login,usu_nome FROM usuario WHERE usu_login=?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s', $usu_login);
$stmt->execute();

$stmt->bind_result($usu_login, $usu_nome);

$tem_resultado = false;
while ($stmt->fetch()) {//se tem resultado para nossa consulta realizada (ou seja, email existe em BD)
    $tem_resultado = true;
    $stmt->close(); //fecha ultima conexão, para realizarmos a alteração
    unset($stmt);

    $qry = "UPDATE usuario SET usu_senha = ? WHERE usu_login = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('ss',$usu_senha, $usu_login);
    $stmt->execute();
//após alterarmos a BD, vamos enviar o email
    require_once('php_mailer/EmailConfig.php'); //PHPmail (envia o email com a nova senha)
// Setando o endereço de recebimento
    $mail->AddAddress($usu_login, $usu_nome);
    $mail->Subject = 'Sua nova senha!';
    $mail->Body = 'Bom dia! Conforme solicitado, aqui esta sua nova senha:</br></br><b>' . $random_pw . '</b></br> Por favor, registre-a em algum lugar seguro e altere esta senha quando acessar seu perfil!';
    $mail->AltBody = 'Bom dia! Conforme solicitado, aqui esta sua nova senha:' . $random_pw . ' Por favor, registre-a em algum lugar seguro e altere esta senha quando acessar seu perfil!';

    if (!$mail->send()) {
        echo 'Nova senha não pode ser enviada por e-mail.';
        echo '</br>';
        echo 'Error: ' . $mail->ErrorInfo;
        exit;
    }

//criou conta!!
//echo 'Sua senha foi enviada por e-mail. Por favor, abra sua conta de e-mail e verifique se você recebeu uma mensagem com sua nova senha</br></br> <strong>Se você não receber nada em 10 minutos, verifique em sua caixa de SPAM</strong>';
    redireciona('index.php?sucesso=trocou_senha');
}
if ($tem_resultado == false) {//se nao conseguiu achar o email na base de dados é porque o usuário nao existe
    redireciona('index.php?error=21');
}
$display_site->fundo();
?>
