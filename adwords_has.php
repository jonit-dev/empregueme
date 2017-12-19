<?php
require_once('class_display.php');
require_once('classes/display_main.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');



$display_main = new display_main();
$display_site = new display();
$display_site->top('Viva Melhor: Vencendo a Hipertensão');

if(isset($ultima_pagina))
{
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
}
$display_main->head('@import url(\'css/index_has_adwords.css\');','

<script type="text/javascript" src="plugins_jquery/animatescroll.js-master/animatescroll.min.js"></script>


<script type="text/javascript" src="js/control_plano_recrutador.js"></script>


');

//CÓDIGO GOOGLE ANALYTICS
		
//ficaria aqui

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

<?php
//------------------------- RASTREIO DE CONVERSÃO - CPA

if(isset($_GET['checkout']))
{
	switch($_GET['checkout'])
	{
		case 2990:
			$display_main->show_banner('Plano Empregue-me Trimestral','<p>Obrigado pelo interesse em se tornar membro Empregue-me. <strong>Clique no botão abaixo para
			que a janela do PagSeguro seja aberta, onde poderá efetuar o pagamento com maior segurança.</strong></p>
			
			<center>
			<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="E407751A1C1CA97334C46F954C413DE5" />
<input type="image" class="fechabanner" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/209x48-pagar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
</center>
			
			','small');
			
			//rastreia conversão no adwords - 29,90

?>
<!-- Google Code for Conversao_VIP_29.90 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 966613173;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "9up-CKPE5AkQtbH1zAM";
var google_conversion_value = 29.900000;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/966613173/?value=29.900000&amp;label=9up-CKPE5AkQtbH1zAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php

		break;
		case 4990:
		
		$display_main->show_banner('Plano Empregue-me Semestral','<p>Obrigado pelo interesse em se tornar membro Empregue-me. <strong>Clique no botão abaixo para
			que a janela do PagSeguro seja aberta, onde poderá efetuar o pagamento com maior segurança.</strong></p>
			
			<center>
			<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="FBF8BECDD4D4CEFEE4DE4FA56F7D0257" />
<input type="image" class="fechabanner" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/209x48-pagar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
			</center>
			','small');
		
		
?>

<!-- Google Code for Conversao_VIP_4990 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 966613173;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "N9rLCOvK5AkQtbH1zAM";
var google_conversion_value = 49.900000;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/966613173/?value=49.900000&amp;label=N9rLCOvK5AkQtbH1zAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php	
		
		
		
		break;
		
	}
	
	
	
	
}
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
        	<a href="javascript:void(0)" id="link_beneficios" target="_self">Benefícios</a>
        </div>
                
        
       
        
        
        <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_planos" target="_self">Planos</a>
        </div>
        
        
           
            <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_anunciantes" style="margin-left:-20px;" target="_self">Depoimentos</a>
        </div>
           
             <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_duvidas" target="_self" style="margin-left:10px;">Dúvidas</a>
        </div>
     
         <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_diferenciais" target="_self">Diferenciais</a>
        </div>   
       
    </div>


	<div id="top_header_cadastrese">
	<a href="javascript:void(0)"><img src="gfx/plano_recrutador_novo/cadastresesmall.png" alt="cadastrese small" /></a>
	</div>
<div id="top_header">

</div>

	<div id="logo">
    	
    </div>

</div><!--END TOP HEADER-->

<!--TEXTO PRINCIPAL-->

<div id="video">

<!--
<iframe width="388" height="270" src="https://www.youtube.com/embed/KOrrtxzN4cc" frameborder="0" allowfullscreen></iframe>
-->
<div id="book_cover">


</div>


<a href="adwords_membro_vip.php?freetrial=true" id="7dias">
<img style="margin-left:80px;" src="gfx/plano_recrutador_novo/7diasgratis.png" alt="7 dias grátis"/>
</a>


</div>



<?php
$keyword_dinamica = $_GET['keyword'];
$var_keyword_dinamica = $_GET['var'];

//valores padrão
$question = false;
$second_keyword = 'rapidamente';
if(empty($_GET['keyword']))
{
$keyword_dinamica = 'Saiba Tudo Sobre';	
}

if(isset($_GET['s_keyword']))
{
$second_keyword = $_GET['s_keyword'];
}
if(isset($_GET['question']))
{
$question = $_GET['question'];
}
if($question == true)
{
	$question = '?';
}
if($_GET['s_keyword'] == '')
	{
		$second_keyword = 'Pressão Alta';
	}
echo '
<div id="txt_principal">
	'.ucfirst($keyword_dinamica).'<span class="txt_bold"> '.$second_keyword.$question.'</span>



</div>


<div id="txt_subprincipal">
	Está suspeitando que você tenha pressão alta?<span class="txt_bold"> Confira nosso guia completo</span>!
</div>
';
?>

<a href="javascript:void(0)" target="_self">
<div id="beneficios_bolas" style="top:-30px;">
	<div class="item_beneficio">
		<img src="gfx/pagina_ebooks/comida_saudavel.png" class="img_beneficio" alt="maca"/>
        <div class="beneficio_txt" style="top:97px;"><center>DIETA PARA HIPERTENSOS</center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/pagina_ebooks/sintomas.png" class="img_beneficio"  alt="sintomas"/>
        <div class="beneficio_txt" style="top:97px;"><center>PRINCIPAIS SINTOMAS</center></div>
    </div>

	<div class="item_beneficio">
		<img src="gfx/pagina_ebooks/trat.png" class="img_beneficio"  alt="tratamento"/>
        <div class="beneficio_txt" style="top:90px;"><center>OPÇÕES DE TRATAMENTO</center></div>
    </div>

</div>
</a>

<div id="fb_pos">
	<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="323" data-height="56" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>
</div>








<div id="box_content_all"><!--INIT BOX CONTENT ALL-->


<div class="box_content" style="margin-top:0px;">

<div class="box_detail"></div>

<div class="box_content_title" style="margin-left:-40px;">Porque Você Deve Ser Membro Empregue-me?</div>

<div class="box_content_subtitle" style="margin-left:150px;">Você merece ter acesso a melhores chances de ser empregado!</div>




<div class="box_content_txt">
Sabemos que as coisas não vão muito bem e entendemos as suas preocupações quanto ao futuro: A sensação de incerteza e a angústia de ter de ficar nessa situação - correndo até mesmo o risco de passar necessidades por não poder pagar suas próprias contas - assombra qualquer um. 

Mas fique calmo! O Empregue-me possui a missão de não apenas melhorar, mas de mudar sua vida para melhor: Com a nossa ajuda você terá dinheiro para pagar por seus estudos, construir sua casa própria e ajudar sua família a ter muita dignidade.

<b>Para isso, criamos este pacote de benefícios a um preço extremamente acessível que aumenta ainda mais as suas chances de ter o que você mais quer: Um emprego.</b></div>
<br />

<div class="box_content_subsubtitle">Veja quais são os benefícios do membro Empregue-me:</div>

<div class="beneficio_box">

	<div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/economize.png" alt="economize"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">VALOR ACESSÍVEL</div>
        <div class="beneficio_box_subtitle">Sabemos que você não pode se dar ao luxo de gastar valores exorbitantes, por isso criamos uma solução compatível com seu bolso.</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/favoritos.png" width="53" height="50" alt="favoritos" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ACESSO A OPORTUNIDADES EXCLUSIVAS</div>
        <div class="beneficio_box_subtitle">Quer driblar a concorrência e ter acesso a vagas que nenhum outro membro pode ter? Então o membro Empregue-me é para você!</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/clock.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ACELERE SUA RECOLOCAÇÃO NO MERCADO</div>
        <div class="beneficio_box_subtitle">Cansado de ficar meses ou anos na mesma situação? Como o membro Empregue-me oferece vantagens exclusivas para você, você se destaca e tem maiores chances de ser contratado.</div>
        
    </div>
    
        <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/facilidade.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">FACILIDADE E PRATICIDADE</div>
        <div class="beneficio_box_subtitle">Nossos benefícios foram especialmente desenvolvidos para que você tenha uma menor "dor de cabeça" ao procurar emprego. Comprove!</div>
        
    </div>
    

    
</div>



<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>




<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title"><span id="produto_target">Membro Empregue-me: Vantagens</span></div>

<div class="box_content_subtitle" style="margin-left:-60px;">Descubra agora mesmo porque algumas pessoas conseguem facilmente um emprego enquanto você luta sem resultados.</div>


<div class="box_content_txt">
	Para acelerar sua contratação nosso sistema inteligente conta com diversos benefícios especialmente desenvolvidos para você. 
</div>
<br />

<div class="box_content_subsubtitle">Aqui você terá:</div>

<div class="beneficio_box">

	<div class="plano_recr_beneficio">	
    
    	<div class="plano_rec_beneficio_img">
        	<img src="gfx/plano_recrutador_novo/beneficios/visualizacoes.png"  width="54" height="52" alt="veja quais empresas visitaram seu curriculo" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Saiba Quais Empresas Viram Seu Currículo</div>
        
        <div class="plano_rec_beneficio_txt">
     		Quer saber quais empresas visualizaram seu currículo? Seja Membro VIP e tenha acesso à uma lista completa com dados de contato de todas elas.
        </div>

     </div>



	<div class="plano_recr_beneficio">	
    
    	<div class="plano_rec_beneficio_img">
        	<img src="gfx/plano_recrutador_novo/beneficios/sem_filas.png"  width="54" height="52" alt="sem filas para envio de currículo" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Sem Filas para Envio de Currículo</div>
        
        <div class="plano_rec_beneficio_txt">
      Cansado de ter seu currículo enviado somente após 2 dias? Seja Membro VIP e tenha seu CV enviado imediatamente para a empresa, logo após você clicar no botão candidatar.</div>

     </div>
    	
        
       <div class="plano_recr_beneficio">	
    
    	<div class="plano_rec_beneficio_img">
        	<img src="gfx/plano_recrutador_novo/beneficios/enviomensagem.png"  width="45" height="45" alt="envio de mensagens para empresas" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Envio de Mensagens Para Empresas</div>
        
        <div class="plano_rec_beneficio_txt">
      	Quer dizer algo para empresa anunciante? Seja Membro VIP e convença as empresas sobre o seu potencial!
      </div>

     </div>
    	 
        
        
        
       	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/envio_automatico.png" width="54" height="52" alt="Envio automático de currículos" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Envio Automático de Currículos</div>
                
                <div class="plano_rec_beneficio_txt">
                Já imaginou curtir a vida enquanto procuramos um emprego para você? Agora isso é possível! Com essa funcionalidade enviaremos seu currículo para as vagas de seu interesse, sem que você tenha que acessar o site ou clicar em absolutamente NADA!
                </div>

    	 </div>
         
         
         
           	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/vaga_destaque.png" width="54" height="52" alt="Vaga em Destaque" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Vagas Exclusivas</div>
                
                <div class="plano_rec_beneficio_txt">Com o membro VIP você poderá se candidatar a vagas exclusivas, eliminando assim sua concorrência e aumentando as suas chances de forma significativa!</div>

    	 </div>
         
         
             	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/contato.png" width="45" height="35" alt="Acesso ao contato de empresas" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Acesso ao Telefone e E-mail Das Empresas</div>
                
                <div class="plano_rec_beneficio_txt">
                Quer ser mais pro-ativo e entrar em contato diretamente com as empresas? Sendo Membro VIP você poderá ter acesso ao e-mail das vagas e ao telefone, para poder ligar ou enviar mensagens personalizadas quando quiser.

                </div>
                </div>
         
         
         
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/video.png" width="54" height="50" alt="Salve candidatos em favoritos" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Cursos Online</div>
                
                <div class="plano_rec_beneficio_txt">
                Quer se preparar melhor para o momento decisivo de sua entrevista de emprego? Nós podemos te ajudar! Contamos com video-aulas exclusivas sobre como preparar um excelente currículo, dicas para entrevista de emprego e muito mais!


                </div>

    	 </div>

			
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/anuncio_vagas.png" width="54" height="52" alt="Anuncie suas vagas" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Currículo Com Design Profissional</div>
                
                <div class="plano_rec_beneficio_txt">Cerca de 70% dos currículos que nossos clientes empresarios recebem são mal feitos, com erros de ortografia e com uma identidade visual pobre. Seja membro VIP e tenha acesso a um modelo de curriculo com design diferenciado, que você pode editar com suas informações e sair na frente da concorrência!
</div>

    	 </div>
         
         
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/descontos.png" width="54" height="52" alt="Descontos em Cursos de Qualificação" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Descontos em Cursos de Qualificação</div>
                
                <div class="plano_rec_beneficio_txt">Nosso clube do desconto conta com as melhores empresas para sua qualificação, como por exemplo: escolas de idiomas, empresas de cursos profissionalizantes e da área de informática. Assine nosso membro VIP e adquira descontos bem maiores do que os usuários gratuitos!</div>

    	 </div>
        
        
             
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/alerta.png" width="54" height="48" alt="imprimir cv" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Alerta Automático de Vagas</div>
                
                <div class="plano_rec_beneficio_txt">Está sem paciência para ficar entrando no site todos os dias e procurando sua vaga? Apenas selecione sua área de atuação que avisaremos a você por e-mail assim que surgirem oportunidades. Simples, não?

</div>

    	 </div>
         
                	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/atendimento_prioritario.png" width="54" height="48" alt="imprimir cv" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Prioridade no atendimento</div>
                
                <div class="plano_rec_beneficio_txt">Seja atendido prontamente por nossa equipe, resolvendo rápidamente todas as suas questões em relação ao funcionamento do website ou do membro VIP</div>

    	 </div>
        
        
        
	
    
</div> <!---END BOX BENEFICIO-->


<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png" alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>



<div class="box_content">
<span id="anunciantes_target"></span>
<div class="box_detail"></div>

<div class="box_content_title">Confiam em Nosso Trabalho</span></div>

<div class="box_content_subtitle">Veja algumas milhares de empresa e candidatos que estão se beneficiando com nosso sistema.</div>

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
            <div class="item_resumo_txt" >Tenha acesso a vantagens exclusivas</div>
          </div>
          <div class="item_resumo_benef">
        	<img src="gfx/plano_recrutador_novo/check.png" alt="check"/>
                        <div class="item_resumo_txt" >Tenha maior destaque para as empresas</div>
          </div>
    </div>
   
   
   
   
    </div>
	
</div>





<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>





<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" >Nossos Planos de Assinatura</div>

<div class="box_content_subtitle" style="margin-left:90px;">Planos compatíveis com suas necessidades de realocação no mercado</div>

<div class="box_content_subsubtitle" id="planos">Escolha o seu plano:</div>


<div class="beneficio_box" style="margin-left:140px;">

  
    
 
        

   
    
  	<div class="plano_item">
    <a href="adwords_membro_vip.php?keyword=Encontre%20Emprego&s_keyword=rapidamente&checkout=2990">
	<img src="gfx/plano_recrutador_novo/planos/vip_trimestral.png" alt="plano vip trimestral"/>    
	</a>
    </div>
    
    
 
  	<div class="plano_item" style="margin-left:100px;">
    <a href="adwords_membro_vip.php?keyword=Encontre%20Emprego&s_keyword=rapidamente&checkout=4990">
	<img src="gfx/plano_recrutador_novo/planos/vip_semestral.png" alt="plano vip semestral"/>    
	</a>
    </div>
   



	
</div>

<!--
<div id="satisfacao_garantida">
	<img src="gfx/plano_recrutador_novo/planos/satisfacao_garantida.png" alt="satisfacao garantida" />
</div>
-->
<div id="pagseguro_logo">
	<img src="gfx/plano_recrutador_novo/planos/pagseguro_logo.png" alt="logo pagseguro" />
</div>

<div id="site_protegido">
	<img src="gfx/plano_recrutador_novo/planos/site_protegido.png" />
</div>






</div>

<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>











<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="diferenciais">Nossos Diferenciais de Mercado</div>

<div class="box_content_subtitle" style="margin-left:100px;">Compare e veja porque somos sua melhor opção em vantagens e benefícios.</div>


<div class="beneficio_box" >


<div class="diferencial_item">
	<div class="diferencial_title">Preços Competitivos:</div>
    
    <div class="diferencial_content">
    	<img src="gfx/plano_recrutador_novo/diferenciais/vip_diferencial.png" />
    </div>
	
</div>



<div class="diferencial_item">
	<div class="diferencial_title">Nossos Números:</div>
    
    <div class="diferencial_content">
    	<img src="gfx/plano_recrutador_novo/diferenciais/vip_numeros.png" />
    </div>
	
</div>




</div>
</div>

<div class="cta" style="margin-top:20px;">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>






<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="duvidas">Dúvidas Mais Frequentes</div>

<div class="box_content_subtitle" style="margin-left:60px;" >Tem alguma pergunta sobre o funcionamento do Empregue-me?</div>


<div class="beneficio_box" >

<div class="duvidas_item_scroll">

<div class="duvidas_title">1)E se eu pagar a conta Empregue-me e não tiver mais dinheiro para continuar? Posso cancelar meu plano?</div>

<div class="duvidas_txt">
Sim! Você pode cancelar seu plano a qualquer momento! Caso você crie sua conta Empregue-me e sua situação financeira fique ainda mais difícil por algum motivo, basta parar de pagar que o plano é automaticamente cancelado. Não temos nenhuma intenção de prejudicar ninguém! Muito pelo contrário. O nosso plano de benefícios foi criado com o intúido de oferecer maiores vantagens a quem está disposto a investir em si mesmo. Pague enquanto quiser e puder usufruir de maiores benefícios para conseguir um emprego mais rapidamente.</div>

<div class="duvidas_title">
2) Quanto tempo demora para ativar minha conta Empregue-me após o pagamento?
</div>

<div class="duvidas_txt">
Geralmente a ativação ocorre em até 3 dias úteis após a aprovação do pagamento. Se o prazo correr além disso, entre em contato com sac@empreguemeagora.com.br que resolvemos prontamente seu problema.</div>


<div class="duvidas_title">
3) Irei receber algum produto em casa?
</div>
<div class="duvidas_txt">
Não. Após a aprovação de seu pagamento iremos lhe enviar por e-mail sua conta Empregue-me, com a liberação dos benefícios do plano escolhido. Ou seja, é tudo feito pela internet.
</div>

<div class="duvidas_title">
4) O sistema de pagamento do Empregue-me é seguro?
</div>

<div class="duvidas_txt">
Sim! Contamos com uma solução integrada do PagSeguro, um dos mais completos e seguros meios de pagamento na internet.</div>

<div class="duvidas_title">
6) O membro Empregue-me realmente funciona?
</div>

<div class="duvidas_txt">
Sim! A proposta do membro Empregue-me é aumentar suas chances de entrar no mercado de trabalho lhe concedendo diversos benefícios exclusivos que farão com que você saia na frente da concorrência. Isso não significa que vendemos uma fórmula mágica e que você não precisará se esforçar. É claro que terá que enviar os currículos para as oportunidades de seu interesse e ficar muito ligado, caso queira ter resultados satisfatórios como vários de nossos membros vêm tendo.</div>


<div class="duvidas_title">
7) Funciona para qualquer cargo?
</div>

<div class="duvidas_txt">
Sim! Independente se você é auxiliar administrativo, vendedor, atendente, operador de caixa ou de telemarketing. O membro Empregue-me concede maiores chances a todos os cargos.</div>

<div class="duvidas_title">
8) É fácil de usar? E se eu não conseguir utilizar os benefícios?</div>

<div class="duvidas_txt">
Pode ficar tranquilo que é bem fácil sim. Todos os benefícios foram especialmente desenvolvidos para usuários como você, que não querem perder tempo aprendendo a utilizar ferramentas complicadas. Caso tenha alguma dúvida sobre como utilizar, basta solicitar ajuda através do suporte de atendimento prioritário que estaremos prontos para lhe auxiliar com o que for necessário.</div>

<div class="duvidas_title">
9) Se eu for membro Empregue-me será divulgado fora do Empregue-me que estou desempregado?</div>

<div class="duvidas_txt">
Não. Nossa política de privacidade assegura que sua situação não seja exposta para outras pessoas fora da rede social.</div>
</div>

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
    
          <div class="btm_cta_cadastre">
 
      	<a href="adwords_membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
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

//-------------- ADWORDS


if(isset($_GET['freetrial']))
{
$display_main->show_banner('Experimente 7 Dias Grátis','
<p>Bom dia, tudo certo? Antes de prosseguir com a promoção de 7 dias grátis, é importante que você <strong>entenda como ela funciona:</strong></p>
<ul style="margin-left:20px;">
	<li>Para participar você deve aderir ao <strong>Plano Trimestral após clicar no botão "7 Dias Grátis" abaixo</strong></li>
	<li>Nessa promoção <strong>só é aceito como forma de pagamento o cartão de crédito</strong>. Para pagamento com outros métodos (ex. Boleto), você deve aderir aos planos abaixo (não inclusos na promoção de 7 dias grátis)</li>
	<li><strong>Após a aprovação da transação pelo pagseguro</strong> você terá <strong>direito a um período de 7 dias gratuitos</strong>, para testar as nossas vantagens.</li>
	<li>Nos primeiros 7 dias após a transação ser aprovada pelo pagseguro você poderá cancelar o pagamento a qualquer momento. Para isso, basta que entre em contato através
	da seção Atendimento no painel à esquerda do membro VIP.</li>
	<li><strong>Caso opte pelo cancelamento nada será cobrado em seu cartão de crédito</strong> pois a transação será estornada em seu cartão de crédito, pelo pagseguro.</li>
	<li>Após aprovação da transação pelo pagseguro, você deve <strong>aguardar até 1 dia útil para a ativação</strong> de sua conta VIP Trimestral 7 Dias Grátis</li>
	<br />
<br />


<center>
		<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="21795C8790904A1444797FA7815732E5" />
<input type="image" src="gfx/plano_recrutador_novo/7dias_adwords.png" class="fechabanner" style="border:0;" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

</center>
</ul>


','small');	
	
	
}




?>



</body>

</html>














