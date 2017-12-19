<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/funcoes_estruturais.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}

$display_main->head();

$display_main->topo();
$display_main->painel_esquerda();

//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
    switch ($_GET['tipo']) {//verifica o tipo da mensagem
        case 'sucesso'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'sucesso');
            break;
        case 'error'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'error');
            break;
    }
}

$data = explode(' ', $_SESSION['nome']);
$primeiro_nome = ucwords($data[0]);

if (isset($_SESSION['membro_vip_ativo'])) {

    if ($_SESSION['membro_vip_ativo'] == 0) {//se não é vip
        $convite_vip = '<a href="membro_vip.php" target="_self">' . $primeiro_nome . ', você ainda não faz parte de nossa exclusiva comunidade Membro VIP Empregue-me. <strong>Clique aqui para criar sua conta VIP!</strong></a>';
    } else {
        $convite_vip = '';
    }
}

if (isset($_POST['envia_email'])) {
    require_once('php_mailer/EmailConfig.php');

// Setando o endereço de recebimento
    $mail->AddAddress('sac@empreguemeagora.com.br', 'empregue-me');
    $mail->Subject = "VIP - " . $_POST['assunto'];
    $mail->Body = "E-mail do VIP: ".$_SESSION['login']."<br />".utf8_encode($_POST['corpo_mensagem']);
    $mail->From = $_SESSION['login'];
    $mail->FromName = $_SESSION['nome'];
    if ($mail->send()) { //envia e-mail para o usuario com sua senha
        $mail->ClearAllRecipients();
        echo "<h1>Atendimento VIP</h1><p>E-mail enviado com sucesso</p>";
    } else {
        echo "<h1>Atendimento VIP</h1><p>Ocorreu um problema, se persistir entre em contato com o sac@empreguemeagora.com.br</p>";
    }
} else {
    $display_main->conteudo('<h1>Atendimento VIP</h1><p>' . $primeiro_nome . ' para entrar em contato conosco preencha o formuário abaixo. Seu atendimento é prioritário.</p>
<p class="vermelho_destaque">' . $convite_vip . '</p>');
    ?>
    <form action="" method="post">
        Assunto: <input type="text" name="assunto" id="assunto" /><span class="campo_obrigatorio">*</span><br />
        Mensagem:<br /> <textarea name="corpo_mensagem" id="corpo_mensagem" cols=28 rows=4></textarea><span class="campo_obrigatorio">*</span>
        <br />
        <input type="submit" value="Enviar Email"/>        
        <input type="hidden" value="1" name="envia_email" />
    </form>
<?php } ?>

<?php
$display_main->painel_direita();
$display_main->fundo();
?>


