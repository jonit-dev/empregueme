<?php
//carrega arquivo com o layout

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');


$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head('','<script type="text/javascript" src="js/meus_anuncios.js"></script>');

//update session vars
//session_start();

//verifica se usuario esta logado
check_loggedin();



$display_main->topo();



$display_main->painel_esquerda();

//conteúdo

echo '<h2>Meus anúncios</h2>';

$display_main->conteudo(carrega_vagas($_SESSION['userid'],true,'all',false));



$display_main->painel_direita();
$display_main->fundo();



?>