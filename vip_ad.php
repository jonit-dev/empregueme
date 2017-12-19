<?php
//carrega arquivo com o layout

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');



$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head('@import url(\'css/lista_email.css\');');

//verifica se usuario esta logado
check_loggedin();


$display_main->topo();
$display_main->painel_esquerda();

//conteúdo

echo '<h2>Aumente suas chances de conseguir um emprego!</h2>';


//redireciona usuário para main, se importou email = 1 ( ou seja, se já importou);




echo '
<center>
<iframe width="600" height="300" src="https://www.youtube.com/embed/ky1b0Gq0YyI" frameborder="0" allowfullscreen></iframe>
</center>
';			
			


echo "<br />

<center>
<a href='http://www.empregue-me.com/novo/membro_vip_pag.php?conta=trimestral' target='_self'>
<img src='gfx/plano_recrutador_novo/conta_vip_agora.png' alt='criar_conta_vip'/>
</a>

</center>
<br />
<br />

";			
			
			
echo '<center>
<a href="main.php?tipo=usuario" >Agora não, obrigado</a>
</center>
';

?>
    

</body>
</html>

<?php
///

$display_main->painel_direita();
$display_main->fundo();



?>