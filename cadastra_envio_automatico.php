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

if (isset($_POST['envio_auto'])) {
    $usu_codigo = $_SESSION['userid'];
    $tag1 = $_POST['tag1'];
    $tag2 = $_POST['tag2'];
    $tag3 = $_POST['tag3'];
    if ($tag1 != "" || $tag2 != "" || $tag3 != "") {
        $opcoes = "";
        if ($tag1 != "") {
            $opcoes .= $tag1 . "/";
        }
        if ($tag2 != "") {
            $opcoes .= $tag2 . "/";
        }
        if ($tag3 != "") {
            $opcoes .= $tag3 . "/";
        }
        //grava no bd
        $mysqli = mysqli_full_connection();
        $mysqli->set_charset('utf8');
        $qry = "UPDATE usuario set usu_tags=? WHERE usu_codigo =?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('si', $opcoes, $usu_codigo);
        if ($stmt->execute()) {
            echo "<strong>Cadastro realizado com sucesso! Envio automático em funcionamento.</strong>";
        } else {
            echo "<strong>Ocorreu um problema, tente novamente mais tarde.</strong>";
        }
    } else {
        echo "<strong>É necessário selecionar pelo menos uma opção de vaga</strong>";
    }
} else {
    $tags = '<option value="">Selecione uma opção</option>';
    $mysqli = mysqli_full_connection();
    $mysqli->set_charset('utf8');
    $qry = "SELECT DISTINCT vag_tag FROM vagas where vag_ativo = 1 and vag_tag !='' and vag_tag is not NULL order by vag_tag";

    $stmt = $mysqli->prepare($qry);
    $stmt->execute();

    $stmt->store_result();
    $stmt->bind_result($r_vag_tag);

    while ($stmt->fetch()) {
        $tags .= '<option value="' . $r_vag_tag . '">' . $r_vag_tag . '</option>';
    }

    $stmt->close();

    $display_main->conteudo('<h1>Envio Automático de Currículo</h1><p>' . $primeiro_nome . ' selecione até <strong>três opções</strong> de cargos que você deseja enviar seu currículo.</p>');
    ?>
    <form action="" method="post">
        <p>Primeira Opção <select name="tag1"><?php echo $tags; ?></select></p>
        <p>Segunda Opção <select name="tag2"><?php echo $tags; ?></select></p>
        <p>Terceira Opção <select name="tag3"><?php echo $tags; ?></select></p>
        <input type="submit" value="Cadastrar opções"/>        
        <input type="hidden" value="1" name="envio_auto" />
    </form>
<?php } ?>

<?php
$display_main->painel_direita();
$display_main->fundo();
?>


