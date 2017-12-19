<?php
//carrega arquivo com o layout

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');

if (session_id() == '') {
    session_start();
}

$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head('','');


//verifica se usuario esta logado
check_loggedin();


$display_main->topo();
$display_main->painel_esquerda();

//conteúdo

echo '<h2>Selecione seu Plano</h2>';

echo '<p>Selecione um dos planos abaixo para prosseguir:</p>


<a href="membro_vip.php" target="new">
<img src="gfx/membro_vip/Planos/plano_vip.png"/>
</a>

<a href="main.php?tipo=usuario" target="_self">
<img src="gfx/membro_vip/Planos/plano_gratuito.png"/>
</a>







';



?>
    

</body>
</html>

<?php
///

$display_main->painel_direita();
$display_main->fundo();



?>