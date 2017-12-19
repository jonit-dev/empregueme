<?php
require_once('class_display.php');
require_once('classes/display_main.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');



$display_main = new display_main();
$display_site = new display();
$display_site->top();

if(isset($ultima_pagina))
{
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
}
$display_main->head('@import url(\'css/index_nova_landing.css\');','

<script type="text/javascript" src="plugins_jquery/animatescroll.js-master/animatescroll.min.js"></script>


<script type="text/javascript" src="js/control_index_vip.js"></script>


');

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

echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "http://connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=392928604125411&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';

?>





<div id="background_image">
</div>

<div id="empresas_anunciantes">
<div class="item_anunciante" style="margin-top:20px;">Reportagens:</div>

	<div class="item_anunciante">
    <center>
    	<img src="gfx/plano_recrutador_novo/record.png" alt="record"/>
    </center>
    </div>

	<div class="item_anunciante">
    <center>
    <a href="http://gazetaonline.globo.com/_conteudo/2013/05/oportunidades/vagas/1435090-saiba-como-conseguir-emprego-usando-as-redes-sociais.html" target="_blank">
    	<img src="gfx/plano_recrutador_novo/gazeta_online.png" alt="gazeta online"/></a>
    </center>
    </div>
    <div class="item_anunciante">
     <center>
     <a href="http://m.folhavitoria.com.br/economia/noticia/2014/05/rede-social-profissional-voltada-para-empregos-ja-tem-mais-de-132-mil-usuarios-no-es.html" target="_blank">
    	<img src="gfx/plano_recrutador_novo/folha_vitoria.png" alt="folha vitória"/>
        </a>
    </center>
    </div>
    <div class="item_anunciante">
    <a href="http://www.youtube.com/watch?v=4Y4jiRnszKQ" target="_blank">
    	<img src="gfx/plano_recrutador_novo/sbt.png" alt="sbt"/>
        </a>
    </div>
    <div class="item_anunciante">
    <a href="http://site.faesa.br/noticia-lendo.aspx?id=689&titulo=Aluno+de+Computa%C3%A7%C3%A3o+cria+aplicativo+para+busca+de+emprego+no+facebook" target="_blank">
    	<img src="gfx/plano_recrutador_novo/faesa.png" style="margin-left:-20px;" alt="faesa"/>
        </a>
    </div>
    
    </div>
    
        <div id="opcoes_header">
    	
        <div class="opcao_item">
        	<a href="index_empresa.php"  target="_self" style="color:#f6e112;font-weight:bold;">Sou Empresa</a>
        </div>   
        
        <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_beneficios"  style="margin-left:15px;"target="_self">Benefícios</a>
        </div>
                
        
          
            <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_anunciantes" target="_self">Depoimentos</a>
        </div>
           
                
         
        
                 
       
    </div>

<div id="top_header">

</div>

<div id="login_box">
	
    <form action="login_user.php" method="post">
    
    
    
    
    
    <div class="login_input">
       <div class="login_input_txt">E-mail:</div>
    
    	 <input type="email" name="login_up" class="input_index" id="focus_here" placeholder="Digite seu e-mail">
    

       </div>
    
    
        <div class="login_input">
    
    
        <div class="login_input_txt">Senha:</div>
    
    
  <?php
  if(isset($_SERVER['HTTP_REFERER']))
  {
	   $ultima_pagina =  $_SERVER['HTTP_REFERER']; 
  }
  else
  {
	$ultima_pagina = '';  
  }


$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
    	echo '
		 <input type="password" name="password_up" class="input_index" placeholder="Digite sua senha">
          <div class="esqueci_senha_txt"><a href="'.$ultima_pagina.'?esqueci_senha=true" target="_self">Esqueci Minha Senha</a></div>
    ';
	?>  </div>
    
    <?php
	if (isset($_GET['load'])) {//se essa variável foi passada por get, é porque o usuário está vindo de algum link externo, e quer ir para determinada página após logar
    echo '
			<input type="hidden" name = "loadafter" value="' . $_GET['load'] . '"/>';
}
	?>
  
    <input type="submit" class="input_submit" value=""/>
  
    </form>
</div>


	<div id="logo">
    	
    </div>

</div><!--END TOP HEADER-->

<!--TEXTO PRINCIPAL-->


<div id="txt_principal">
Encontre seu Emprego <span class="txt_bold">Aqui</span>



</div>


<div id="txt_subprincipal">
	Está precisando de um emprego URGENTEMENTE? Você veio ao local certo! <span class="txt_bold"> Quem contrata está aqui</span>!
</div>





<a href="javascript:void(0)" target="_self">
<div id="beneficios_bolas">
	<div class="item_beneficio">
		<img src="gfx/index/suitcase.png" class="img_beneficio" alt="mala"/>
        <div class="beneficio_txt"><center>OPORTUNIDADES EXCLUSIVAS<center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/busca.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:97px;"><center>SEJA ENCONTRADO POR EMPRESAS</center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/curriculo.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:90px;"><center>ACELERE SUA RECOLOCAÇÃO NO MERCADO</center></div>
    </div>

</div>
</a>


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


echo '
<div id="box_cadastro">
	<div class="box_cadastro_title">Cadastre-se Grátis
    	<div class="box_cadastro_subtitle">E encontre milhares de oportunidades!</div>
    </div>
    
    <div id="box_cadastro_form">
    <form action="new_user.php"  method="post" id="form_create_account">

<ul style="list-style:none">
	<li><input type="text" name="name" id="meu_nome" value="" maxlength="30" class="input_create_account" placeholder="Seu Nome Completo" />
		<div class="alert">Você esqueceu de preencher seu nome.</div>
	</li>
    

<li><input type="text" name="nickname" id="nickname" maxlength="8" class="input_create_account" placeholder="Seu apelido ( 8 letras )" />
		<div class="alert">Você esqueceu de preencher seu apelido.</div>
	<div class="valid">Apelido válido!</div>
</li>
   	

 <li><input type="text" name="email" id="meu_email" value="" maxlength="60" class="input_create_account" placeholder="Seu e-mail" />
 		<div class="alert">Você esqueceu de preencher seu e-mail.</div>
 </li>

<li><input type="text" autocomplete="off" name="email2"  value="" maxlength="60" class="input_create_account" placeholder="Insira seu e-mail novamente" />		<div class="alert">Você esqueceu de preencher seu e-mail.</div></li>



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
		
			
		<input type="hidden" name="tipo_conta" class="txt_radio" checked="checked" value="e"/>
		
	</li>
	<li>
	<div id="disclaimer">
		<span class="fonte_pequena">Ao clicar em Criar Nova Conta, você concorda com nossos <a href="http://empregue-me.com/termos/termo_uso.html" target="_blank"><span class="vermelho_destaque">Termos de Uso</span></a> e que você leu nossa Política de Uso de Dados, incluindo nosso <a href="http://empregue-me.com/termos/privacidade.html" target="_blank"><span class="vermelho_destaque">Uso de cookies</span>.</a></span>
	</div>
	
	</li>
  
       	 <li>
			<span class="fonte_pequena"><input type="checkbox" value="1" checked="checked" name="receber_vagas"/>Gostaria de Receber Vagas Gratuitas em meu E-mail</span>
	
	
	</li>
       
		
		
	   <li>
	   <div id="btm_cta_registrar">
	   	 

		<input class="input_registrar" value="" type="submit" id="btm_nova_conta"/>

	   </div>
	   
	   </li>	
	   
       </ul>
 
   	
</form>
   
    </div>
	
	';
	
	
	
	?>
	

</div>

	
<div id="seta_cadastro"></div>
<?php

//SCRIPT GERENCIADOR DE ERROS -> NOVA CONTA
require_once('funcoes/error_functions.php');
gerencia_erros_nova_conta();

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
?>










<div id="box_content_all"><!--INIT BOX CONTENT ALL-->


<div class="box_content" style="margin-top:40px;">

<div class="box_detail"></div>

<div class="box_content_title" style="margin-left:-40px;" id="produto_target">Porque Você Deve Ser Membro Empregue-me?</div>

<div class="box_content_subtitle" style="margin-left:150px;">Você merece ter acesso a melhores chances de ser empregado!</div>




<div class="box_content_txt">
Sabemos que as coisas não vão muito bem e entendemos as suas preocupações quanto ao futuro: A sensação de incerteza e a angústia de ter de ficar nessa situação - correndo até mesmo o risco de passar necessidades por não poder pagar suas próprias contas - assombra qualquer um. 

Mas fique calmo! O Empregue-me possui a missão de não apenas melhorar, mas de mudar sua vida para melhor: Com a nossa ajuda você terá dinheiro para pagar por seus estudos, construir sua casa própria e ajudar sua família a ter muita dignidade.

<b>Para isso, criamos este site que tem como objetivo principal te levar de encontro ao que você mais quer: Um emprego.</b></div><br />

<br />

<div class="box_content_subsubtitle">Veja quais são os benefícios de ser um membro Empregue-me:</div>

<div class="beneficio_box">

	<div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/economize.png" alt="economize"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">CADASTRO GRATUITO</div>
        <div class="beneficio_box_subtitle">O cadastro em nossa rede social é totalmente gratuito. Anuncie seu currículo e candidate-se a milhares de vagas.</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/favoritos.png" width="53" height="50" alt="favoritos" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">OPORTUNIDADES EXCLUSIVAS</div>
        <div class="beneficio_box_subtitle">Milhares de empresas divulgam vagas exclusivamente em nosso sistema. Portanto, fique de olho diariamente!</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/clock.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">PARE DE PERDER TEMPO</div>
        <div class="beneficio_box_subtitle">Em um só lugar você terá acesso a tudo que precisa para conseguir seu emprego!</div>
        
    </div>
    
        <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/facilidade.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">FACILIDADE E PRATICIDADE</div>
        <div class="beneficio_box_subtitle">Nosso site foi desenvolvido para que você não tenha "dor de cabeça" ao procurar emprego. É fácil e extremamente eficaz.</div>
        
    </div>
    

    
</div>



<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
      	<a href="javascript:void(0);"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>

<div id="fb_pos">

<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="320" data-height="10" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>


</div>




<div class="box_content">
<span id="anunciantes_target"></span>
<div class="box_detail"></div>

<div class="box_content_title">Confiam em Nosso Trabalho</span></div>

<div class="box_content_subtitle">Veja algumas de milhares de empresas e candidatos que estão se beneficiando com nosso sistema.</div>

<div class="beneficio_box">

	
	<div class="anunciantes">
    
        	<div class="anunciantes_titulo">Anunciantes:</div>
        <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/bmw.png" alt="bmw" width="102" height="74"/>
        </div>
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/yanping.png" alt="yanping" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/wiseup.png" alt="wiseup" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/wizard.png" alt="wizard" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/mrv.png" alt="mrv" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/yazigi.png" alt="yazigi" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/nextel.png" alt="nextel" width="102" height="74"/>
        </div>
        
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/99taxis.png" alt="99taxis" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/sky.png" alt="sky" width="102" height="74"/>
        </div>
        
        
         <div class="benef_empresa_box">
            <img src="gfx/plano_recrutador_novo/empresas/splendido.png" alt="splendido" width="102" height="74"/>
        </div>
        
        
    
    </div>
    
    <div class="depoimentos">
    
    	<div class="depoimentos_titulo">Depoimentos:</div>
    	
        <div class="depoimento_item">
        	<div class="depoimento_img">
            	<img src="gfx/plano_recrutador_novo/depoimentos/depoimento_3.png" alt="depoimento 3" />
            </div>
            <div class="depoimento_title">Nane Santos, Secretária</div>
            <div class="depoimento_txt">Estou aqui para compartilhar a minha conquista. Depois de vários currículos enviados acabo de ser selecionada para fazer parte da equipe de uma loja de venda de óculos! Obrigado Empregue-me!</div>
        </div>
        
        <div class="depoimento_item">
        	<div class="depoimento_img">
            	<img src="gfx/plano_recrutador_novo/depoimentos/depoimento_4.png" alt="depoimento 4" />
            </div>
            <div class="depoimento_title">Andressa Lamberti, Auxiliar Administrativo</div>
            <div class="depoimento_txt">Queria agradecer aos administradores pela eficácia da página. Enviei o currículo do meu noivo para algumas vagas na segunda à noite e na terça pela manhã já ligaram marcando entrevista!! Funciona mesmo!!</div>
        </div>

   	<div class="barra_reportagem">
    	
        <div class="reportagem_titulo">Reportagens:</div>
		
        <div class="reportagem_item">
        	<img src="gfx/plano_recrutador_novo/reportagens/record.png" alt="record" />
        </div>
        
          <div class="reportagem_item">
          <a href="http://gazetaonline.globo.com/_conteudo/2013/05/oportunidades/vagas/1435090-saiba-como-conseguir-emprego-usando-as-redes-sociais.html" target="_blank">
        	<img src="gfx/plano_recrutador_novo/reportagens/gazeta.png" alt="gazeta" />
            </a>
        </div>
        
          <div class="reportagem_item">
        	<a href="http://m.folhavitoria.com.br/economia/noticia/2014/05/rede-social-profissional-voltada-para-empregos-ja-tem-mais-de-132-mil-usuarios-no-es.html" target="_blank">
            <img src="gfx/plano_recrutador_novo/reportagens/folha.png" alt="folha vitória" />
            </a>
        </div>
        
           <div class="reportagem_item">
           <a href="http://www.youtube.com/watch?v=4Y4jiRnszKQ" target="_blank">
        	<img src="gfx/plano_recrutador_novo/reportagens/sbt.png" alt="sbt" />
            </a>
        </div>
        
         <div class="reportagem_item">
        	<a href="http://site.faesa.br/noticia-lendo.aspx?id=689&titulo=Aluno+de+Computa%C3%A7%C3%A3o+cria+aplicativo+para+busca+de+emprego+no+facebook" target="_blank">
        	<img src="gfx/plano_recrutador_novo/reportagens/faesa.png" alt="faesa" />
            </a>
        </div>



    </div>
   
   	<div class="barra_resumo_benef">
    	<div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check" /><div class="item_resumo_txt" style="margin-top:110px;">Acelere sua recolocação no mercado</div>
          </div>
          
          <div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check"/>
            <div class="item_resumo_txt" >Seja visto por quem contrata</div>
          </div>
          <div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check"/>
                        <div class="item_resumo_txt" >Candidate-se na vaga que você quiser!</div>
          </div>
    </div>
   
   
   
   
    </div>
	
</div>





<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="javascript:void(0)" class="><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>




<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="diferenciais">Nossos Diferenciais de Mercado</div>

<div class="box_content_subtitle" style="margin-left:100px;">Compare e veja porque somos sua melhor opção em vantagens e benefícios.</div>


<div class="beneficio_box" >


<div class="diferencial_item">
	<div class="diferencial_title">Nossos Números:</div>
    
    <div class="diferencial_content">
    	<img src="gfx/plano_recrutador_novo/diferenciais/vip_numeros.png" />
    </div>
	
</div>



<div class="diferencial_item">



<div class="duvidas_item">
<div class="duvidas_subtitle">Fale Conosco:</div>
<br />


<?php

$url = curPageURL();
echo '

<form action="'.$url.'" method="post">
	<ul>
    	<li>Seu e-mail: <input type="email" name="email" class="email_contato" value="" placeholder="Seu e-mail..." /></li>
        <li>Mensagem: 
			<br />
       
        	<textarea name="mensagem" class="contato_textarea" value="" placeholder="Digite sua mensagem aqui..."></textarea>
        
        </li>
    </ul>
	
	<input type="submit" value="" class="btm_enviar_duvida" />
	</form>
';
?>




	
</div>




</div>
</div>

<br />
<br />
<br />
<br />
<br />

<div class="cta" style="margin-top:20px;">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="javascript:void(0);"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>






</div><!--END BOX CONTENT ALL-->

<?php

if(isset($_POST['email']))
{
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/email_functions.php');

@$email = mysqli_secure_query($_POST['email']);
@$mensagem = mysqli_secure_query($_POST['mensagem']);




//----------- VALIDAÇÃO DE DADOS DO FORM DE CONTATO


if(empty($email))//se email estiver vazio
{
$display_main->noty('Você esqueceu de preencher o e-mail de sua mensagem. Tente novamente','error','topCenter',6000);	
exit;
}

if(!check_email_address($email))//email inválido
	{
		$display_main->noty('O e-mail que você preencheu não é válido. Tente novamente','error','topCenter',6000);
		exit;
	}



if(empty($mensagem))//se email estiver vazio
{
$display_main->noty('Você esqueceu de escrever a sua mensagem de contato. Tente novamente','error','topCenter',6000);	
exit;
	
}

//----------------- ENVIA EMAIL E MOSTRA CONFIRMACAO

//Envia e-mail
//após alterarmos a BD, vamos enviar o email
        require_once('php_mailer/EmailConfig.php'); //PHPmail (envia o email com a nova senha)	
// Setando o endereço de recebimento
        $mail->AddAddress($email);
        $mail->Subject = 'CONTATO EMPRESA: '.$email;
        
		$body = "<strong>Empresa:</strong> $email<br />
<br />

<strong>Mensagem:</strong> 

$mensagem

</br></br>
";
		
		$mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        if (!$mail->send()) {
            		$display_main->noty('Error! Sua mensagem não pôde ser enviada via e-mail - Error:'.$mail->ErrorInfo,'error','topCenter',6000);
                       exit;
        }



$display_main->noty('Sua mensagem foi enviada com sucesso! Nós iremos entrar em contato o mais rápido possível','success','topCenter',6000);	



}//end isset

?>



</body>

</html>














