<?php
require_once('class_display.php');
require_once('classes/display_main.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');

//CADASTRA CONVERSÃO FB ADS


if(isset($_GET['conta_criada']))
{
?>
<!-- Google Code for Cadastro Empresa Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 966613173;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "sxnTCKuX8QkQtbH1zAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/966613173/?label=sxnTCKuX8QkQtbH1zAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php	
}

$display_main = new display_main();
$display_site = new display();
$display_site->top();

if(isset($ultima_pagina))
{
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
}




$display_main->head('@import url(\'css/index_adwords.css\');','

<script type="text/javascript" src="plugins_jquery/animatescroll.js-master/animatescroll.min.js"></script>


<script type="text/javascript" src="js/control_plano_recrutador.js"></script>

<!--CONTROLE FORM CRIAÇÃO DE CONTA-->
  <script type="text/javascript" src="js/form_criar_conta.js"></script>


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
        	<a href="javascript:void(0)" id="link_porque_usar" target="_self">Benefícios</a>
        </div>
                
        
               
           
            <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_anunciantes" target="_self">Depoimentos</a>
        </div>
           
             <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_duvidas" target="_self" style="margin-left:10px;">Contato</a>
        </div>
    
    
       
    </div>




<div id="top_header">

</div>



<div id="login_box">
	
   <?php
   
    $form_login = 'login_user.php';
	if(isset($_GET['vaga_id']))
	{
		$form_login = 'login_user.php?vaga_id='.$_GET['vaga_id'];	
	}
    echo '<form action="'.$form_login.'" method="post">';
   ?> 
    
    
    
    
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




<a href="index.php" target="_self">
	<div id="logo">
    	
    </div>
    </a>

</div><!--END TOP HEADER-->

<!--TEXTO PRINCIPAL-->



<?php
$keyword_dinamica = $_GET['keyword'];
$var_keyword_dinamica = $_GET['var'];

//valores padrão
$question = false;
$second_keyword = 'em 10 minutos';


$second_keyword = $_GET['s_keyword'];
$question = $_GET['question'];

if($question == true)
{
	$question = '?';
}
if($_GET['s_keyword'] == '')
	{
		$second_keyword = 'em 10 minutos';
	}
echo '
<div id="txt_principal">
	'.ucfirst($keyword_dinamica).'<span class="txt_bold"> '.$second_keyword.$question.'</span>



</div>


<div id="txt_subprincipal">
	Está precisando correr contra o tempo para '.$var_keyword_dinamica.' os melhores talentos para sua empresa ou evento? <span class="txt_bold">Nós podemos lhe ajudar</span>!
</div>
';
?>
<a href="javascript:void(0)" target="_self">
<div id="beneficios_bolas">
	<div class="item_beneficio">
		<img src="gfx/index/suitcase.png" class="img_beneficio" alt="mala"/>
        <div class="beneficio_txt"><center>POSTE SUAS VAGAS<center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/busca.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:97px;"><center>PESQUISE CURRÍCULOS DE CANDIDATOS</center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/index/curriculo.png" class="img_beneficio"  alt="busca_cv"/>
        <div class="beneficio_txt" style="top:90px;"><center>ENCONTRE PRESTADORES DE SERVIÇO</center></div>
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
<div id="seta_cadastro"></div>

<div id="box_cadastro">
	<div class="box_cadastro_title">Cadastre-se Grátis
    	<div class="box_cadastro_subtitle">E encontre os melhores profissionais!</div>
    </div>
    
    <div id="box_cadastro_form">
    <form action="new_user.php"  method="post" id="form_create_account">

<ul style="list-style:none">
	<li><input type="text" name="name" id="meu_nome" value="" maxlength="30" class="input_create_account" placeholder="Nome da sua Empresa" />
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
			<span class="fonte_pequena"><input type="checkbox" value="1" checked="checked" name="receber_vagas"/>Receber Novos Currículos em Meu E-mail</span>
	
	
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

?>


<div id="fb_pos">
	<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="323" data-height="56" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>
</div>







<div id="box_content_all"><!--INIT BOX CONTENT ALL-->


<div class="box_content" id="porque_usar">

<div class="box_content_title" style="margin-top:70px;">Porque Usar os Nosso Serviços?</div>

<div class="box_content_subtitle">Você merece contratar os melhores profissionais para sua empresa rapidamente e gastando menos.</div>




<div class="box_content_txt">
	O objetivo desta página não é ficar discutindo o porquê das empresas terem tanta dificuldade de encontrar mão de obra qualificada para sua instituição. Isso todo mundo já sabe. Venho aqui para lhe dar a solução. Afinal, uma contratação equivocada de um talento gera despesas desnecessárias- e tenho certeza que não é isso que você quer -.
</div>
<br />

<div class="box_content_subsubtitle">Veja quais são os nossos benefícios:</div>

<div class="beneficio_box">

	<div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/economize.png" alt="economize"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ACESSO GRATUITO</div>
        <div class="beneficio_box_subtitle">Tenha acesso a milhares de candidatos GRATUITAMENTE!</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/favoritos.png" width="53" height="50" alt="favoritos" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ENCONTRE OS MELHORES TALENTOS</div>
        <div class="beneficio_box_subtitle">Busque o melhor profissional para sua empresa exatamente no perfil que você deseja, acessando milhares de currículos em nosso banco de dados atualizado.</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/clock.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">RAPIDEZ EM CONTRATAÇÂO</div>
        <div class="beneficio_box_subtitle">Encontre profissionais qualificados para sua empresa em 10 minutos.</div>
        
    </div>
    
        <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/facilidade.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">FACILIDADE E PRATICIDADE</div>
        <div class="beneficio_box_subtitle">Otimize o seu tempo usando nossa plataforma de recrutamento, especialmente desenvolvida para tornar o processo prático e de fácil. manejo.</div>
        
    </div>
    

    
</div>



<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="criar_conta">
      	<a href="javascript:void(0)"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>








<div class="box_content">
<span id="anunciantes_target"></span>
<div class="box_detail"></div>

<div class="box_content_title">Confiam em Nosso Trabalho</span></div>

<div class="box_content_subtitle">Veja algumas das milhares de empresas que estão se beneficiando com nosso sistema.</div>

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
            	<img src="gfx/plano_recrutador_novo/depoimentos/depoimento_1.png" alt="depoimento 1" />
            </div>
            <div class="depoimento_title">Théa Furtado, Empresária - Intros Móveis</div>
            <div class="depoimento_txt">Sempre utilizo a plataforma do Empregue-me para contratações e tive ótimos resultados! Recomendo!</div>
        </div>
        
        <div class="depoimento_item">
        	<div class="depoimento_img">
            	<img src="gfx/plano_recrutador_novo/depoimentos/depoimento_2.png" alt="depoimento 2" />
            </div>
            <div class="depoimento_title">Nilo Saldanha, Empresário - Vértice</div>
            <div class="depoimento_txt">Parabéns. O Empregue-me  é uma ferramenta muito completa. Não tenho precisado de outros meios de recrutamento para encontrar candidatos qualificados rapidamente.  Nota 10!</div>
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
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check" /><div class="item_resumo_txt" style="margin-top:110px;">Redução de Gastos com Recrutamento</div>
          </div>
          
          <div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check"/>
            <div class="item_resumo_txt" >Praticidade e facilidade na contratação</div>
          </div>
          <div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check"/>
                        <div class="item_resumo_txt" >Encontre mão-de-obra qualificada para sua empresa</div>
          </div>
    </div>
   
   
   
   
    </div>
	
</div>





<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="criar_conta">
 
      	<a href="javascript:void(0)"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>

















<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="duvidas">Contato</div>

<div class="box_content_subtitle" style="margin-left:60px;" >Tem alguma pergunta sobre o funcionamento do Empregue-me?</div>


<div class="beneficio_box" >


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

<div class="cta" style="margin-top:20px;">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="criar_conta">
 
      	<a href="javascript:void(0)"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>





</div><!--END BOX CONTENT ALL-->



<?php
// CRIAÇÃO DE CONTA
if(isset($_GET['conta_criada']))
	{
		$display_main->noty('Sua conta foi criada com sucesso! Faça login através no painel no canto superior direito.','success','topCenter',6000);
		echo '<script type="text/javascript">
		$(document).ready(function(e) {
    $("#focus_here").focus();
		});	
	
		</script>';
		
		exit;
		
	}


if(isset($_POST['email']))
{
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/email_functions.php');

@$email = mysqli_secure_query($_POST['email']);
@$mensagem = mysqli_secure_query($_POST['mensagem']);




//----------- VALIDAÇÃO DE DADOS


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

//----------------- REGISTRA EM BASE DE DADOS E MOSTRA MENSAGEM DE CONFIRMAÇÃO

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














