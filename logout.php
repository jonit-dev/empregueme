<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário

$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head();

//update session vars
//session_start();

//check if user has directly for this page, without login!
if (empty($_SESSION['login']) || !isset($_SESSION['login']))
{
 redireciona("index.php");
 exit;
}


$display_main->topo();
$display_main->painel_esquerda();
$display_main->conteudo('<h2>Logout</h2>
	Muito obrigado por sua visita! Retorne diariamente pois temos novas oportunidades todos os dias!');
$display_main->painel_direita();
$display_main->fundo();


session_clean();//destroi sessão
 redireciona("index.php",5000);
?>
