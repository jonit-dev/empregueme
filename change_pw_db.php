<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');
$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//antes de mais nada, atualiza vars da sessão (iremos usar isso na consulta em nossa base de dados
//session_start() or die ("Error: Sessão não pode ser iniciada");

check_loggedin();

$display_main->head();
$display_main->topo();
$display_main->painel_esquerda();


echo '<div id="conteudo">';
//Script functions
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/array_functions.php');

//form vars
@$old_pw = $_POST['old_pw'];
@$new_pw = $_POST['new_pw'];
@$new_pw2 = $_POST['new_pw2'];

//VALIDATION//
//Check if vars were filled
if (validate(array($old_pw, $new_pw, $new_pw2)) == 1) {
    echo "
<h2>Opps!</h2>
<p>Formulário vazio. Preencha novamente.</p>";
    echo "</div>"; //fecha conteúdo
    $display_main->painel_direita();
    $display_main->fundo();
    exit;
} elseif (validate(array($old_pw, $new_pw, $new_pw2)) == 2) {

    echo'<h2>Opps!</h2>
<p>Caracteres inválidos em seu formulário. Tente novamente!</p>';
    echo "</div>"; //fecha conteúdo
    $display_main->painel_direita();
    $display_main->fundo();
    exit;
}

//primeiro, verifica se os novos password estão inseridos corretamente
if ($new_pw != $new_pw2) {
    echo "As novas senhas não correspondem. Volte e tente novamente.";
    echo '<div>'; //fecha div conteúdo
    $display_main->painel_direita();
    $display_main->fundo();

    exit;
} elseif ($new_pw == $old_pw) {

    echo "O password antigo e o novo são os mesmos! Por favor, insira um novo password diferente do antigo!";
    echo '<div>'; //fecha div conteúdo
    $display_main->painel_direita();
    $display_main->fundo();

    exit;
}

//end validation
//if everything is ok.. go to DB check old password
//DB connection
//connect to db
$mysqli = mysqli_full_connection();
mysqli_set_charset($mysqli, 'UTF-8');

//prepara query
$old_pw = mysqli_secure_query($_POST['old_pw']);
$new_pw = mysqli_secure_query($_POST['new_pw']);

//Primeiro, verifica se o password está correto
$qry = "SELECT usu_codigo,usu_login,usu_senha FROM usuario WHERE usu_login=? and usu_senha=?";
$stmt = $mysqli->prepare($qry);
//variaveis para bind
$login = $_SESSION['login'];
$senha_antiga = sha1($old_pw);
$stmt->bind_param('ss', $login, $senha_antiga); //lembre-se sempre de encryptar para comparar com a base de dados! Se não nunca vai corresponder (já que o pw da BD está encriptado!!)
$stmt->execute();
$stmt->bind_result($usu_codigo, $usu_login, $usu_senha);
$tem_resultado = false;
while ($stmt->fetch()) {//se encontrar algo no resultado é PORQUE O USUÁRIO DIGITOU O PASSWORD ANTIGO CORRETAMENTE!
    $stmt->close(); //ATENÇÃO =====> FECHA CONSULTA ANTERIOR (se deixar aberta vai dar pau e buga oa próxima consulta à DB!!!)
    $tem_resultado = true;

//Vamos prosseguir com a mudança do password


    $qry = "UPDATE usuario SET usu_senha = ? WHERE usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    //variaveis para o bind
    $nova_senha = sha1($new_pw);
    $stmt->bind_param("si", $nova_senha, $usu_codigo);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p><strong>Sua senha foi alterada com sucesso!</strong></p>";

//Após registro ==> Envia email/password para usuário, via e-mail
//após alterarmos a BD, vamos enviar o email
        require_once('php_mailer/EmailConfig.php'); //PHPmail (envia o email com a nova senha)	
// Setando o endereço de recebimento
        $mail->AddAddress($_SESSION['login'], $_SESSION['nome']);
        $mail->Subject = 'Sua senha foi alterada!';
        $mail->Body = "Ei! Tudo certo? Sua senha foi alterada recentemente. Por favor, anote seus novos dados:</br></br>

<strong>Nova senha:</strong> $new_pw
</br></br>
Obrigado!
";
        $mail->AltBody = "Ei! Tudo certo? Sua senha foi alterada recentemente. Por favor, anote seus novos dados:

Nova senha: $new_pw

Obrigado!
";

        if (!$mail->send()) {
            echo 'Nova senha não pode ser enviada via e-mail';
            echo 'Error: ' . $mail->ErrorInfo;
            exit;
        }

        echo '<p>Sua nova senha foi enviada para ' . $_SESSION['login'] . '</p>

<p> Por favor, escreva-a em algum lugar <strong>seguro!</strong></p>';

        echo "<a href='main.php' target='_self'>
<p><strong>Clique aqui para retornar à página principal...</strong></p></a>";

        echo '</div>'; //fecha div conteúdo
        $display_main->painel_direita();
        $display_main->fundo();
    }
}


if ($tem_resultado == false) {//se não encontrou resultado é porque inseriu o password antigo errado
    echo "A senha antiga que você inseriu está errada. por favor, volte e digite a correta.";
    echo "
<a href='main.php' target='_self'>
<p>Retornar ao perfil...</p></a>";

    echo '<div>'; //fecha div conteúdo
    $display_main->painel_direita();
    $display_main->fundo();
}

$stmt->close();
$mysqli->close();
?>