<?php
require_once('class_display.php');
require_once('classes/display_main.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');


$display_main = new display_main();
$display_site = new display();
$display_site->top();

$display_main->head('@import url(\'css/index_candidato.css\');','
<!--CONTROLE FORM CRIAÇÃO DE CONTA-->
  <script type="text/javascript" src="js/form_criar_conta.js"></script>');


//CÓDIGO TESTE A/B

?>
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='67548758-0',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->
<?php


echo "</head>"; //finaliza head
echo "<body>";


//CÓDIGO GOOGLE ANALYTICS
		
		echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34989993-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";


//CÓDIGO PARA FUNCIONAR PLUGINS DO FACEBOOK (CURTIR E COMPARTILHAR)

//CÓDIGO PARA FUNCIONAR PLUGINS DO FACEBOOK (CURTIR E COMPARTILHAR)
/*
echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "http://connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=392928604125411&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
*/
?>


<div id="background_image">
</div>

<div id="seta_cadastro"></div>

<div id="empresas_anunciantes">
<div class="item_anunciante" style="margin-top:10px;">Anunciam aqui:</div>

	<div class="item_anunciante">
    <center>
    	<img src="gfx/index/wiseup_logo.png" style="margin-top:10px;" alt="wiseup"/>
    </center>
    </div>

	<div class="item_anunciante">
    <center>
    	<img src="gfx/index/prepara_logo.png" alt="wiseup"/>
    </center>
    </div>
    <div class="item_anunciante">
     <center>
    	<img src="gfx/index/yanping_logo.png" alt="wiseup"/>
    </center>
    </div>
    <div class="item_anunciante">
    	<img src="gfx/index/yazigi_logo.png" alt="wiseup"/>
    </div>
    <div class="item_anunciante">
    	<img src="gfx/index/microlins_logo.png" alt="wiseup"/>
    </div>
    <div class="item_anunciante">
    	<img src="gfx/index/sky_logo.png" alt="wiseup"/>
    </div>
    
    </div>
    
    <div id="opcoes_header">
    	
        <div class="opcao_item">
        	<a href="index_empresa.php" target="_self">Sou Empresa</a>
        </div>
        
       
    </div>



<div id="top_header">
</div>

	<div id="logo">
    	
    </div>

<div id="login_box">
	
    <form action="login_user.php" method="post">
    
    
    
    
    
    <div class="login_input">
       <div class="login_input_txt">E-mail:</div>
    
    	 <input type="email" name="login_up" class="input_index" id="focus_here" placeholder="Digite seu e-mail">
    

       </div>
    
    
        <div class="login_input">
    
    
        <div class="login_input_txt">Senha:</div>
    
    
    	 <input type="password" name="password_up" class="input_index" placeholder="Digite sua senha">
              <div class="esqueci_senha_txt"><a href="index.php?esqueci_senha=true" target="_self">Esqueci Minha Senha</a></div>
    </div>
    
    <?php
	if (isset($_GET['load'])) {//se essa variável foi passada por get, é porque o usuário está vindo de algum link externo, e quer ir para determinada página após logar
    echo '
			<input type="hidden" name = "loadafter" value="' . $_GET['load'] . '"/>';
}
	?>
  
    <input type="submit" class="input_submit" value=""/>
  
    </form>
    

</div><!--END TOP HEADER-->

<!--TEXTO PRINCIPAL-->





<div id="main_txt">
	Encontre as melhores <span class="txt_bold">oportunidades</span>

</div>

<div id="submain_txt">
	Quer ter seu currículo disponível para milhares de empresas que acessam nosso site todos os dias? <span class="txt_bold">Nós podemos lhe ajudar</span>!
</div>


<div id="beneficios">
	<div class="item_beneficio">
		<img src="gfx/index/curriculum.png" style="margin-left:10px;" class="img_beneficio" alt="mala"/>
        <div class="beneficio_txt"><center>CADASTRE SEU CURRÍCULO<center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/busca.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:97px;"><center>PESQUISE POR VAGAS</center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/curriculo.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:90px;"><center>TENHA VISIBILIDADE PARA EMPRESAS</center></div>
    </div>






</div>
<?php

//CARREGA ESTADOS AQUI
//variáveis default para criação de conta
//vamos carregar os estados
$mysqli = mysqli_full_connection();
mysqli_set_charset($mysqli, "utf8");
$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
$stmt = $mysqli->prepare($qry);

$stmt->execute();
$stmt->bind_result($r_sigla, $r_cod_est);

$estados = '';
while ($stmt->fetch()) {
    $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
}


echo '<div id="box_cadastro">
	<div class="box_cadastro_title">Cadastre-se Grátis
    	<div class="box_cadastro_subtitle">E encontre um emprego que você ame!</div>
    </div>
    
    <div id="box_cadastro_form">
    <form action="new_user.php"  method="post" id="form_create_account">

<ul style="list-style:none">
	<li><input type="text" name="name" maxlength="30" class="input_create_account" placeholder="Seu nome completo" />
		<div class="alert">Você esqueceu de preencher seu nome.</div>
	</li>
    

<li><input type="text" name="nickname" id="nickname" maxlength="8" class="input_create_account" placeholder="Seu apelido ( 8 letras )" />
		<div class="alert">Você esqueceu de preencher seu apelido.</div>
	<div class="valid">Apelido válido!</div>
</li>
   	

 <li><input type="email" name="login" maxlength="60" class="input_create_account" placeholder="Seu e-mail" />
 		<div class="alert">Você esqueceu de preencher seu e-mail.</div>
 </li>

<li><input type="email" autocomplete="off" name="login2" maxlength="60" class="input_create_account" placeholder="Insira seu e-mail novamente" />		<div class="alert">Você esqueceu de preencher seu e-mail.</div></li>



 <li><input type="password" name="password" class="input_create_account" placeholder="Sua nova senha" />
 		<div class="alert">Você esqueceu de preencher sua senha.</div></li>

<li><input type="password" name="password2"  class="input_create_account" placeholder="Insira sua nova senha novamente"  />
		<div class="alert">Você esqueceu de preencher sua senha.</div>
</li>
<li><select name="estado" id="estado" class="input_create_account"><option name="">Selecione seu estado...</option>' . $estados . '</select>
		<div class="alert">Você esqueceu de preencher seu estado.</div>
</li>
    <li><select name="cidade" id="cidade" class="input_create_account" ><option value="">Selecione o estado primeiro...</option></select>
			<div class="alert">Você esqueceu de preencher sua cidade.</div>
	</li>
    <li style="margin-left:10px">
		
			<input type="hidden" name="tipo_conta"  checked="checked" value="pf" />
		
	</li>
	<li>
	<div id="disclaimer">
		<span class="fonte_pequena">Ao clicar em Criar Nova Conta, você concorda com nossos <a href="http://empregue-me.com/termos/termo_uso.html" target="_blank"><span class="vermelho_destaque">Termos de Uso</span></a> e que você leu nossa Política de Uso de Dados, incluindo nosso <a href="http://empregue-me.com/termos/privacidade.html" target="_blank"><span class="vermelho_destaque">Uso de cookies</span>.</a></span>
	</div>
	
	</li>
  
       
	   <li>
	   <div id="btm_cta_registrar">
	   	<input class="input_registrar" value="" type="submit" id="btm_nova_conta"/>

	   </div>
	   
	   </li>
	   
       </ul>
 
    
</form>
    </div>';
	
	?>
	

</div>

<?php

//*---------------VALIDAÇÃO DA CRIAÇÃO DE CONTA----------//*

if (isset($_GET['error'])) {//se ta passando error por get é porque quer mostrar codigo de erro
    switch ($_GET['error']) {
        case 1:
            $display_main->show_banner('Erro: Campo vazio no formulário!', '
			<p>Você esqueceu algum campo vazio no formulário. </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 2:
            $display_main->show_banner('Erro: Caracter inválido', '
			<p>Você inseriu algum caracter inválido no campo de formulário para criação de conta. </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 3:
            $display_main->show_banner('Erro: E-mail inválido', '
			<p>O e-mail que você inseriu é inválido. Verifique se está tudo digitado corretamente ou registre com outro e-mail </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 4:
            $display_main->show_banner('Erro: Senhas não são as mesmas', '
			<p>As novas senhas que você inseriu não são as mesmas! Escolha uma nova senha e depois digite-a novamente abaixo.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 5:
            $display_main->show_banner('Erro: Os e-mails não são os mesmos', '
			<p>Os e-mails que você inseriu não são os mesmos! Certifique-se de que os dois e-mails inseridos sejam os mesmos.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 6:
            $display_main->show_banner('Erro: Nome de usuário', '
			<p>O nome de usuário possui mais de 100 caracteres! Abrevie seu nome para evitar qualquer erro.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 7:
            $display_main->show_banner('Erro: Apelido', '
			<p>Seu apelido está muito grande. Tente um outro apelido com até 8 letras.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 8:
            $display_main->show_banner('Erro: Apelido', '
			<p>Comprimento inválido de senha! Tente alguma senha entre 6 a 16 caracteres</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 9:
            $display_main->show_banner('Erro: Tamanho da foto', '
			<p>O tamanho da foto excede o limite máximo de upload do servidor (1MB).</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 10:
            $display_main->show_banner('Erro: Foto enviada parcialmente', '
			<p>Algum erro ocasionou o envio parcial de sua foto.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 11:
            $display_main->show_banner('Erro: Esqueceu de enviar a foto', '
			<p>Você esqueceu de enviar sua foto.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 12:
            $display_main->show_banner('Erro: Arquivo de foto inválido', '
			<p>O arquivo que você tentou enviar como foto não corresponde aos formatos aceitos (.jpeg, .png ou .bmp)</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 13:
            $display_main->show_banner('Erro: Foto do perfil muito pequena', '
			<p>Sua foto de perfil está muito pequena! Insira uma foto com tamanho maior que 75x75 pixels.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;



        case 14:
            $display_main->show_banner('Erro: Usuário já existe', '
			<p>Já existe um usuário com a conta de e-mail que você está tentando registrar.</p>
			<br />
<p>Por favor, tente registrar novamente com outro e-mail!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 15:
            $display_main->show_banner('Erro: Apelido já existe', '
			<p>O apelido que você está tentando registrar já está em uso.</p>
			<br />
<p>Por favor, tente registrar novamente com outro apelido!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 16:
            $display_main->show_banner('Erro: Envio de conta por e-mail', '
			<p>Sua conta foi criada, porém não foi enviada via e-mail.</p>
			<p>Tente acessá-la agora e, caso não consiga efetuar login, crie uma nova conta.</p>
			<br />
		
			<center><input type="button" id="ok_btm" value="Ok" class="btm_error"/></center>
			
			', 'small');

            break;

        case 17:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Não foi possível criar pasta para salvar dados de usuário.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 18:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Não foi possível mover o arquivo de dados do usuário ao diretório de destino</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 19:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Possível ataque de upload. Abortando!!</p>
			<br />
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 20://para o esqueci minha senha
            $display_main->show_banner('Erro: E-mail inválido', '
			<p>O e-mail que você inseriu é inválido.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 21://para o esqueci minha senha
            $display_main->show_banner('Erro: E-mail inexistente', '
			<p>O e-mail não existe. Insira um registrado em nosso sistema!</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 22://para LOGIN

            $display_main->show_banner('Erro: Combinação e-mail ou senha incorreta', '
			<p>A combinação e-mail x senha inserida está incorreta.
			<br />
<br />
<p><strong>ATENÇÃO MEMBROS GRATUITOS:</strong> Como migramos para nossa nova rede social, é necessário que você crie uma NOVA CONTA.</p>

<p>
<strong>ATENÇÃO MEMBROS VIP:</strong> Sua conta é a mesma de antes. Caso não tenha recebido, envie um e-mail para sac@empreguemeagora.com.br</p>

Por favor, tente novamente! <strong>Caso não lembre de sua senha, <a href="index.php?esqueci_senha=true"><span style="text-decoration:underline">clique aqui</span></a></strong></p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');
            break;
        
        case 23://para o campo cidade
            $display_main->show_banner('Erro: Cidade Inválida', '
			<p>Selecione sua cidade.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
			
		  case 24:// esqueceu de especificar tipo de conta
		              $display_main->show_banner('Você esqueceu de especificar o tipo de sua conta', '
			<p>Você esqueceu de especificar o tipo de sua conta (empresa ou candidato) no formulário.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;	
			
    }
}//se nao mostrar o erro, mostra banner de curtir facebook
//mostra banner curtir facebook
//somente se ainda nao curtiu
//CRIOU CONTA COM SUCESSo
if (isset($_GET['sucesso'])) {
    switch ($_GET['sucesso']) {
        case 'nova_conta';
            $display_main->show_banner('Conta criada!', '
<p>Agora que você criou sua conta, realize o <strong>login no painel acima!</strong></p>

			<p>Obs.: Sua nova conta foi criada e enviada via e-mail. Por favor, acesse seu e-mail e verifique se você recebeu uma mensagem com sua senha!</br></br> <strong>Se você não receber nada em 10 minutos, verifique sua caixa de SPAM ou tente criar uma nova conta com um e-mail diferente.</p>
			
			
			<br />
			<center><input type="button" id="go_login" value="Fazer login" class="btm_error"/></center>
			
			', 'small');
            break;

        case 'trocou_senha':

            $display_main->show_banner('Nova senha criada', '
			<p>Sua nova senha foi criada e enviada via e-mail. Por favor, acesse seu e-mail e verifique se você recebeu uma mensagem com sua senha!</br></br> <strong>Se você não receber nada em 10 minutos, verifique sua caixa de SPAM ou tente novamente.</p>
			
			<center><input type="button" id="go_login" value="Fazer login" class="btm_error"/></center>
			
			', 'small');

            break;
    }
}


//--------------------------- ESQUECEU SENHA-------------//
if (isset($_GET['esqueci_senha'])) {

    $display_main->show_banner('Esqueci minha senha', '
	<p>Insira seu e-mail abaixo e clique em ok!</p>
	
	<form action="forgot_pw.php" method="post">
		E-mail: <input type="email" name="login" />
		
		<input type="submit" value="Solicitar nova senha"/>
	</form>
	
	', 'small');
}
//--------------------------- AVISO PARA LOGIN-------------//
if (isset($_GET['aviso'])) {
    switch ($_GET['aviso']) {
        case 1:
            $display_main->show_banner('Quero me candidatar', 'CRIE SUA CONTA ou faça LOGIN para se candidatar a uma vaga!', 'small');
    }
}

$display_site->fundo();

?>



