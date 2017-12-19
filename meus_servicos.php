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
require_once('funcoes/funcoes_busca.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}

$display_main->head('','<script type="text/javascript" src="js/meus_anuncios.js"></script>');

$display_main->topo();
$display_main->painel_esquerda();
carrega_busca_freelancer();
if ($_GET['pesquisa'] == true) {
    area_busca_freelancer();
} else {
    constroi_freelancer(true);
}
$display_main->painel_direita();
$display_main->fundo();
?>


