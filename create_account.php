<?php
require_once('class_display.php');
require_once('funcoes/db_functions.php');
$display_site = new display;
$display_site->top();
?>
<p>Então você quer criar uma conta, certo? Preencha o formulário abaixo!</p>

<form action="new_user.php"  enctype="multipart/form-data" method="post">
<fieldset>
<legend>Nova conta</legend>

<ul style="list-style:none">
	Nome completo: <li><input type="text" name="name" maxlength="30"/></li>
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    Foto:<li><input type="file" name="usuario_foto"/><span class="campo_obrigatorio">* Tamanho máximo: 1Mb - Formato:.jpeg, .bmp, .png</span>
	<br />
Apelido: <li><input type="text" placeholder="Máximo de 8 letras" name="nickname" maxlength="8" /></li>
   	
    
   	E-mail: <li><input type="email" name="login" maxlength="30" /></li>
Digite seu e-mail novamente: <li><input type="email" autocomplete="off" name="login2" maxlength="30" /></li>
	Senha: <li><input type="password" name="password" /></li>
    Digite sua senha novamente: <li><input type="password" name="password2" /></li>
    
    </br>
	<input type="submit" value="Criar nova conta" style="margin-left:10px";/>
    <br />
    </ul>
 
 
    
    <a href="index.php" target="_self">
    <p style="margin-left:10px";>Voltar para o formulário de login...</p></a>
    
</fieldset>
</form>
<?php
$display_site->down();

?>



</body>
</html>