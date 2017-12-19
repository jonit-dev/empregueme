<?php
require_once('class_display.php');
$display_site = new display;
$display_site->top();
?>


<form action="forgot_pw.php" method="post">
<fieldset>
<legend>Esqueceu sua senha?</legend>
<p>Por favor, insira seu e-mail abaixo que iremos lhe enviar uma nova senha</p>
<ul style="list-style:none">
	E-mail: <li><input type="email" name="login" /></li>
	<input type="submit" value="Enviar nova senha" style="margin-left:10px";/>
    
</ul>


</fieldset>



</form>


<body>
</body>
</html>