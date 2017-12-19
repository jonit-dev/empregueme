<?php
require_once('../funcoes/db_functions.php');
$userid = mysqli_secure_query($_POST['userid']); //captura variável passada pelo ajax
//inicia conexão
require_once('../classes/connect_class.php');
$connect = new ConnectionFactory;
$mysqli = $connect->getConnection();
mysqli_set_charset($mysqli, "utf8");
$qry = "SELECT usu_login,usu_telefone1,usu_telefone2 FROM usuario WHERE usu_codigo = ?";
$stmt = $mysqli->prepare($qry) or die('Could not prepare qry');
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->bind_result($r_usu_login, $r_usu_telefone1, $r_usu_telefone2);


//se tiver resultado
$tem_resultado = false;

while ($stmt->fetch()) {//quando tiver resultado
    $tem_resultado = true;
}

$stmt->close();
$mysqli->close();



//retorna resultado para o AJAX
if ($tem_resultado == true) {
    ?>
    <html>
        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> </head>
        <body>
            <form action="perfil.php?id=<?php echo $userid; ?>" method="post">
                Assunto: <input type="text" name="assunto" /><br />
                Mensagem: <textarea name="mensagem" rows="4" cols="50"></textarea><br /><br />
                <input type="hidden" name="mensagem_candidato" value="1" />
                <input type="hidden" name="login" value="<?php echo $r_usu_login ?>" />    
                <input type="submit" class="botao_cta" />
            </form>
        </body>
    </html>

    <?php
} else {
    echo 'error';
}
?>