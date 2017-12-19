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

$display_main->conteudo('

<h1>Dicas sobre Recrutamento</h1>

<p>Bom dia! Caso esteja interessado em receber dicas sobre como recrutar os melhores talentos para fazer sua empresa crescer, assine nossa lista de e-mails abaixo. Iremos lhe enviar semanalmente tudo o que você precisa saber para alavancar o crescimento de sua empresa e torná-la muito mais competitiva.</p>

<div class="AW-Form-620423551"></div>
<script type="text/javascript">(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "http://forms.aweber.com/form/51/620423551.js";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, "script", "aweber-wjs-3mmcarji2"));
</script>

');

$display_main->painel_direita();
$display_main->fundo();
?>


