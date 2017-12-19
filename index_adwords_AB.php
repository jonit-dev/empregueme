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
$display_main->head('@import url(\'css/index_adwords.css\');','

<script type="text/javascript" src="plugins_jquery/animatescroll.js-master/animatescroll.min.js"></script>


<script type="text/javascript" src="js/control_plano_recrutador.js"></script>


');

?>
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='67548758-2',d=document,l=d.location,c=d.cookie;
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
        	<a href="javascript:void(0)" id="link_beneficios" target="_self">Benefícios</a>
        </div>
                
        
       
        
        
        <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_planos" target="_self">Planos</a>
        </div>
        
        
           
            <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_anunciantes" style="margin-left:-20px;" target="_self">Depoimentos</a>
        </div>
           
             <div class="opcao_item">
        	<a href="javascript:void(0)" id="link_duvidas" target="_self" style="margin-left:10px;">Contato</a>
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

<a href="index.php" target="_self">
	<div id="logo">
    	
    </div>
    </a>

</div><!--END TOP HEADER-->

<!--TEXTO PRINCIPAL-->
<div id="video">
<iframe width="388" height="270" src="https://www.youtube.com/embed/Uvnztv_k_Xk" frameborder="0" allowfullscreen></iframe>

<a href="javascript:void(0)" id="saiba_mais">
<img src="gfx/plano_recrutador_novo/saibamais.png" alt="saiba mais" />
</a>
</div>



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
<div id="beneficios_bolas" style="top:-30px;">
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

<div id="fb_pos">
	<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="323" data-height="56" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>
</div>







<div id="box_content_all"><!--INIT BOX CONTENT ALL-->


<div class="box_content" style="margin-top:0px;">

<div class="box_detail"></div>

<div class="box_content_title">Porque Usar os Nosso Serviços?</div>

<div class="box_content_subtitle">Você merece contratar os melhores profissionais para sua empresa rapidamente e gastando menos.</div>




<div class="box_content_txt">
	O objetivo desta página não é ficar discutindo o porquê das empresas terem tanta dificuldade de encontrar mão de obra qualificada para sua instituição. Isso todo mundo já sabe. Venho aqui para lhe dar a solução. Afinal, uma contratação equivocada de um talento gera despesas desnecessárias- e tenho certeza que não é isso que você quer -.
</div>
<br />

<div class="box_content_subsubtitle">Veja quais são os nossos benefícios:</div>

<div class="beneficio_box">

	<div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/economize.png" alt="economize"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ECONOMIZE NO RECRUTAMENTO</div>
        <div class="beneficio_box_subtitle">Somos a plataforma com os preços mais competitivos do mercado! Compare e comprove.</div>
        
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
    
          <div class="btm_cta_cadastre">
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>




<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title"><span id="produto_target">Plano Recrutador: A sua Solução</span></div>

<div class="box_content_subtitle">Descubra agora mesmo porque algumas empresas conseguem facilmente recrutar talentos.</div>


<div class="box_content_txt">
	Para resolver de uma vez por todas as dificuldades de contratação de nossos milhares de clientes empresariais criamos o Plano Recrutador, nosso sistema inteligente para gerenciar e facilitar todo processo de recrutamento. 
</div>
<br />

<div class="box_content_subsubtitle">Aqui você terá:</div>

<div class="beneficio_box">

	<div class="plano_recr_beneficio">	
    
    	<div class="plano_rec_beneficio_img">
        	<img src="gfx/plano_recrutador_novo/beneficios/contato_candidatos.png"  width="54" height="52" alt="contato candidatos" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Acesso ao Contato dos Candidatos</div>
        
        <div class="plano_rec_beneficio_txt">Encontrou algum talento compatível com sua empresa mas não consegue entrar em contato? Com nosso Plano Recrutador você terá acesso a informações de contato dos candidatos para poder marcar suas entrevistas rapidamente!</div>

     </div>
    	
        
       	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/busca_avancada.png" width="54" height="52" alt="busca avançada de currículos" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Busca Avançada de Currículos</div>
                
                <div class="plano_rec_beneficio_txt">Busque o melhor profissional para sua empresa exatamente no perfil que você deseja, acessando milhares de currículos em nosso banco de dados atualizado.</div>

    	 </div>
         
         
         
           	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/vaga_destaque.png" width="54" height="52" alt="Vaga em Destaque" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Vaga em Destaque</div>
                
                <div class="plano_rec_beneficio_txt">Acelere em 10x a captação de currículos para suas vagas anunciadas, agilizando seu processo seletivo.</div>

    	 </div>
         
         
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/favoritos.png" width="54" height="50" alt="Salve candidatos em favoritos" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Salve os Melhores Currículos Encontrados</div>
                
                <div class="plano_rec_beneficio_txt">Favorite os melhores currículos encontrados para que você possa acessá-los mais tarde, em outros processos seletivos.

</div>

    	 </div>

			
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/anuncio_vagas.png" width="54" height="52" alt="Anuncie suas vagas" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Anúncio de Vagas</div>
                
                <div class="plano_rec_beneficio_txt">Divulgue suas vagas e aguarde chegar os currículos captados de nossos melhores candidatos.</div>

    	 </div>
         
         
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/painel_gerenciamento.png" width="54" height="52" alt="painel de gerenciamento" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Painel de Gerenciamento de Processo Seletivo</div>
                
                <div class="plano_rec_beneficio_txt">Espaço exclusivo para você gerenciar todo seu processo seletivo de maneira simples e eficiente!</div>

    	 </div>
        
        
             
               	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/imprimir.png" width="54" height="52" alt="imprimir cv" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Imprima os currículos selecionados</div>
                
                <div class="plano_rec_beneficio_txt">Gostou de algum currículo em particular? Imprima-o e analise com mais calma depois.</div>

    	 </div>
         
                	<div class="plano_recr_beneficio">	
    
                <div class="plano_rec_beneficio_img">
                    <img src="gfx/plano_recrutador_novo/beneficios/atendimento_prioritario.png" width="54" height="48" alt="imprimir cv" />
                </div>	
                
                <div class="plano_rec_beneficio_titulo">Prioridade no atendimento</div>
                
                <div class="plano_rec_beneficio_txt">Seja atendido prontamente por nossa equipe, resolvendo rápidamente todas as suas questões em relação ao funcionamento do website ou do plano recrutador.</div>

    	 </div>
        
        
        
	
    
</div> <!---END BOX BENEFICIO-->


<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png" alt="botao cadastrar" class="btm_cadastrar" /></a>
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
    
          <div class="btm_cta_cadastre">
 
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>





<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title">Nossos Planos de Assinatura</div>

<div class="box_content_subtitle" style="margin-left:110px;">Planos compatíveis com suas necessidades de contratação</div>

<div class="box_content_subsubtitle">Escolha o seu plano:</div>


<div class="beneficio_box">

<!--	<div class="plano_item">
    <a href="cadastro_rapido_empresa.php" target="_self">
    	<img src="gfx/plano_recrutador_novo/planos/plano_gratis.png" alt="plano grátis" />
    </a>
    </div>
    -->
    
    
	<div class="plano_item" style="margin-left:200px;">
    
<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="11D08D7CD5D580988409DF9E536F9C16" />
<input type="image" id="planos" class="fechabanner"  src="gfx/plano_recrutador_novo/planos/plano_mensal.png" style="border:none;background:none;padding:0;" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" /></form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
      </div>
    
    
	<div class="plano_item">
    
    <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="9040D8C537371D3884439FB46287909E" />
<input type="image" class="fechabanner"  src="gfx/plano_recrutador_novo/planos/plano_trimestral.png" style="border:none;background:none;padding:0;" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" /></form>
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
    </div>

	
</div>

<div id="satisfacao_garantida">
	<img src="gfx/plano_recrutador_novo/planos/satisfacao_garantida.png" alt="satisfacao garantida" />
</div>

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
 
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
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
    	<img src="gfx/plano_recrutador_novo/diferenciais/comparativo_preco.png" />
    </div>
	
</div>



<div class="diferencial_item">
	<div class="diferencial_title">Nossos Números:</div>
    
    <div class="diferencial_content">
    	<img src="gfx/plano_recrutador_novo/diferenciais/numeros.png" />
    </div>
	
</div>




</div>
</div>

<div class="cta" style="margin-top:20px;">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>






<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="duvidas">Dúvidas Mais Frequentes</div>

<div class="box_content_subtitle" style="margin-left:60px;" >Tem alguma pergunta sobre o funcionamento do Empregue-me?</div>


<div class="beneficio_box" >

<div class="duvidas_item_scroll">

<div class="duvidas_title">1)E se eu pagar o plano recrutador e não tiver mais interesse em continuar? Posso cancelar meu plano?</div>

<div class="duvidas_txt">
Sim! Você pode cancelar seu plano a qualquer momento! Caso você crie seu plano recrutador e não tenha mais interesse em continuar por algum motivo -como, por exemplo, ter conseguido contratar quem você precisava - basta parar de pagar que o plano é automaticamente cancelado.
</div>

<div class="duvidas_title">
2) Quanto tempo demora para ativar o plano recrutador após o pagamento?
</div>

<div class="duvidas_txt">
Geralmente a ativação ocorre em até 3 dias úteis após a aprovação do pagamento - O pagseguro irá lhe informar através do e-mail-. Se o prazo correr além disso, entre em contato com sac@empreguemeagora.com.br que resolvemos prontamente seu problema.
</div>


<div class="duvidas_title">
3) O sistema de pagamento do Empregue-me é seguro?
</div>
<div class="duvidas_txt">
Sim! Contamos com uma solução integrada do PAGSEGURO, um dos mais completos e seguros meios de pagamento na internet.
</div>

<div class="duvidas_title">
4) Tem garantia? E se eu pagar e minha conta não for ativada como Plano Recrutador?
</div>

<div class="duvidas_txt">
Nós garantimos que você terá sua conta com plano recrutador ativada em até 3 dias, entretanto, se por algum motivo técnico ela não for você pode solicitar a devolução de seu valor junto ao PAGSEGURO, sem questionamentos. Vale ressaltar que tal problema nunca ocorreu conosco.
</div>

<div class="duvidas_title">
5) O plano recrutador realmente funciona?
</div>

<div class="duvidas_txt">
Sim! A proposta do plano recrutador é facilitar a vida do empresário, economizando seu tempo e dinheiro, para contratar o profissional ideal para sua empresa. Isso não significa que vendemos uma fórmula mágica e que você não precisará se esforçar. É claro que terá que ler os currículos para ver exatamente os de seu interesse e ficar muito ligado, caso queira ter resultados satisfatórios como vários de nossos usuários vêm tendo.
</div>


<div class="duvidas_title">
6) O plano recrutador funciona para qualquer cargo?
</div>

<div class="duvidas_txt">
Sim! Independente se você está buscando um auxiliar administrativo, vendedor, atendente, operador de caixa ou de telemarketing. O plano recrutador irá facilitar a sua contratação, deixando o processo mais prático, ágil e eficaz.
</div>

<div class="duvidas_title">
7) É fácil de usar? E se eu não conseguir utilizar as funcionalidades?
</div>

<div class="duvidas_txt">
Pode ficar tranquilo que é bem fácil sim. Todos os benefícios foram especialmente desenvolvidos para usuários como você, que não querem perder tempo aprendendo a utilizar ferramentas complicadas. Caso tenha alguma dúvida sobre como utilizar, basta solicitar ajuda através do suporte de atendimento prioritário que estaremos prontos para lhe auxiliar com o que for necessário.
</div>

<div class="duvidas_title">
8) E se eu não quiser que os outros saibam o nome de minha empresa? Podem guardar sigilo?
</div>

<div class="duvidas_txt">
Sim. Basta que você não informe o nome de sua empresa ao cadastrar uma vaga. 
</div>
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
 
      	<a href="index_adwords.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
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

?>



</body>

</html>














