<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
@import url('css/pagina_inicial.css');
@import url('css/reset.css');
@import url('fonts/fonts.css');
</style>

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

</head>

<body>
<div id="header_topo">
	<div id="logo">
    </div>
    
    <div id="login_box">
    	<form action="login_user.php" method="post">
        
        <div id="email_txt">E-mail:</div>
        <div id="senha_txt">Senha:</div>
        
     		  <input type="email" name="login" class="input_index">
        	<input type="password" name="password" class="input_index">
            
            <input type="submit" value="Entrar" class="input_submit"/>
        </form>
    </div>
    
    

</div>

<div id="ultimas_vagas">
	<!--CARREGA ULTIMAS VAGAS-->
    <span class="title">Últimas Vagas</span>
</div>

<div id="content_index">
	<span class="title">Cadastre-se Grátis!</span>
	<div class="subtitle">E comece a comprar e vender agora mesmo!</div>


<form action="new_user.php"  enctype="multipart/form-data" method="post" id="form_create_account">

<ul style="list-style:none">
	<li><input type="text" name="name" maxlength="30" class="input_create_account" placeholder="Seu nome completo"/></li>
    
<li><input type="text" name="nickname" maxlength="8" class="input_create_account" placeholder="Seu apelido ( 8 letras )" /></li>
   	
 <li><input type="email" name="login" maxlength="30" class="input_create_account" placeholder="Seu e-mail" /></li>

<li><input type="email" autocomplete="off" name="login2" maxlength="30" class="input_create_account" placeholder="Insira seu e-mail novamente" /></li>

 <li><input type="password" name="password" class="input_create_account" placeholder="Sua nova senha" /></li>

<li><input type="password" name="password2"  class="input_create_account" placeholder="Insira sua nova senha novamente"  /></li>
    
    
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    
    <img src="gfx/ui/user_foto.png" id="user_foto"/>
    
    
   <li><input type="file" name="usuario_foto" id="input_upload"/><div id="foto_detalhe">* Máximo: 1Mb - Formato:.jpeg, .bmp, .png</div>   
   <li>
     <li><br />
       
       </br>
       <input type="submit" value="Criar nova conta" style="margin-left:10px" id="btm_nova_conta" class="input_btm_nova_conta"/>
       <br />
    </ul>
 
    
</form>
    
    
    
    
</div>




</body>
</html>