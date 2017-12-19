<?php
//carrega arquivo com o layout
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('classes/display_main.php');


check_loggedin();//checa se usuario está logado
$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head();




$display_main->topo();
$display_main->painel_esquerda();
$display_main->conteudo('
<h2>Por favor, preencha o formulário abaixo para alterar sua senha</h2>


<form action="change_pw_db.php" method="post">


<ul style="list-style:none">
	Senha antiga: <li><input type="password" name="old_pw" /></li>
	Nova senha: <li><input type="password" name="new_pw" /></li>
    Digite sua nova senha novamente: <li><input type="password" name="new_pw2" /></li>
    
    </br>
	<input type="submit" value="Alterar minha senha"  style="margin-left:10px";/>
    <br />
    </ul>
   


</form>
');
$display_main->painel_direita();
$display_main->fundo();



?>