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

$display_main->head('',' <!--- ENVIO DE CURRICULOS-->
      <script type="text/javascript" src="js/envio_curriculo.js"></script>');

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


$display_main->conteudo('<h1>Vagas exclusivas</h1><p>Ei ' . $primeiro_nome . ', tudo certo? As oportunidades abaixo são selecionadas apenas para que VIPs como você possam se candidatar sem enfrentar a enorme concorrência das vagas que os membros do plano gratuito enfrentam. Envie seu currículo e <strong>boa sorte!</strong></p>
<p class="vermelho_destaque">' . $convite_vip . '</p>');

carrega_vagas('all', false, 'all', true);





$display_main->painel_direita();
$display_main->fundo();
?>


