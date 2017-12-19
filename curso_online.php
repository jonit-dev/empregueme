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
$display_main->conteudo('<h1>Cursos Online</h1><p>Bem vindo a área de cursos online, aqui você encontra videos com o objetivo de ampliar sua carreira profissional.</p>');

$titulo1 = '<p>Como fazer um curriculum vitae excelente<p>';
$video1 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/DVy9MuywGfU" frameborder="0" allowfullscreen></iframe>';
$titulo2 = '<p>Currículo Design<p>';
$video2 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/6GXDDZUTNT4" frameborder="0" allowfullscreen></iframe>';
$titulo3 = '<p>Guia entrevista de emprego<p>';
$video3 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/k2UvFxS0Zss" frameborder="0" allowfullscreen></iframe>';
$titulo4 = '<p>Aula informática Básica Introdução ao curso<p>';
$video4 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/hMAX8IA2njU" frameborder="0" allowfullscreen></iframe>';
$titulo5 = '<p>Informática básica - Aula I<p>';
$video5 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/tW3131M8GYk" frameborder="0" allowfullscreen></iframe>';
$titulo6 = '<p>Informática básica - Aula II - Windows Explorer<p>';
$video6 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/nf9og7koJ6U" frameborder="0" allowfullscreen></iframe>';
?>
<ol>
    <li>
        <?php echo $titulo1 . $video1; ?>
    </li>
    <li>
        <?php echo $titulo2 . $video2; ?>
        <p><a href="gfx/arquivos/modelo_curriculo.doc" target="_blank" /><b>Clique aqui</b></a> e faça o download gratuitamente o modelo de currículo.</p> 
    </li>
    <li>
        <?php echo $titulo3 . $video3; ?>
    </li>
    <li>
        <?php echo $titulo4 . $video4; ?>
    </li>
    <li>
        <?php echo $titulo5 . $video5; ?>
    </li>
    <li>
        <?php echo $titulo6 . $video6; ?>
    </li>                       
</ol>
<?php

$display_main->painel_direita();
$display_main->fundo();
?>


