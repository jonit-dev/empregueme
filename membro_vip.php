<?php
require_once('class_display.php');
require_once('classes/display_main.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/session_functions.php');

if(!check_session())
{
session_start();	
}
$url = curPageURL();
?>

<!--- CODIGO EXPERIMENTO AQUI-->

<?php

$display_main = new display_main();
$display_site = new display();
$display_site->top();


if(isset($ultima_pagina))
{
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
}
$display_main->head('@import url(\'css/index_membro_vip.css\');','

<script type="text/javascript" src="plugins_jquery/animatescroll.js-master/animatescroll.min.js"></script>


<script type="text/javascript" src="js/control_plano_recrutador.js"></script>


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





<div id="background_image2">
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
<iframe width="388" height="270" src="https://www.youtube.com/embed/KOrrtxzN4cc" frameborder="0" allowfullscreen></iframe>

<a href="javascript:void(0)">
<img src="gfx/plano_recrutador_novo/conta_vip_agora.png" alt="criar vip agora" class="btm_cadastrar" style="margin-left:20%;"/>
</a>
</div>






<div id="txt_principal">
	Encontre Emprego <span class="txt_bold">Rapidamente</span>

</div>

<div id="txt_subprincipal">
	Quer aumentar em 27x suas chances de entrar para o mercado de trabalho? <span class="txt_bold">Nós temos a Solução</span>!
</div>


<a href="javascript:void(0)" target="_self">
<div id="beneficios_bolas" style="top:-30px;">
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

<div id="fb_pos">
	<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="323" data-height="56" data-max-rows="1" data-colorscheme="light" data-size="medium" data-show-count="true"></div>
</div>







<div id="box_content_all"><!--INIT BOX CONTENT ALL-->


<div class="box_content" style="margin-top:0px;">

<div class="box_detail"></div>

<div class="box_content_title">Porque Você Deve Ser Membro VIP?</div>

<div class="box_content_subtitle" style="margin-left:150px;">Você merece ter acesso a melhores chances de ser empregado!</div>




<div class="box_content_txt">
Sabemos que as coisas não vão muito bem e entendemos as suas preocupações quanto ao futuro: A sensação de incerteza e a angústia de ter de ficar nessa situação - correndo até mesmo o risco de passar necessidades por não poder pagar suas próprias contas - assombra qualquer um. 

Mas fique calmo! O Empregue-me possui a missão de não apenas melhorar, mas de mudar sua vida para melhor: Com a nossa ajuda você terá dinheiro para pagar por seus estudos, construir sua casa própria e ajudar sua família a ter muita dignidade.

<b>Para isso, criamos este pacote de benefícios a um preço extremamente acessível que aumenta ainda mais as suas chances de ter o que você mais quer: Um emprego.</b></div>
<br />

<div class="box_content_subsubtitle">Veja quais são os benefícios do Membro VIP:</div>

<div class="beneficio_box">

	<div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/economize.png" alt="economize"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">VALOR ACESSÍVEL</div>
        <div class="beneficio_box_subtitle">Sabemos que você não pode se dar ao luxo de gastar valores exorbitantes, por isso criamos uma solução compatível com seu bolso.</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/favoritos.png" width="53" height="50" alt="favoritos" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ACESSO A OPORTUNIDADES EXCLUSIVAS</div>
        <div class="beneficio_box_subtitle">Quer driblar a concorrência e ter acesso a vagas que nenhum outro membro pode ter? Então o Membro VIP é para você!</div>
        
    </div>
    
    
    <div class="beneficio_item">

		<img src="gfx/plano_recrutador_novo/clock.png" alt="rapidez"  width="53" height="50" class="beneficio_box_img"/>
        
        <div class="beneficio_box_title">ACELERE SUA RECOLOCAÇÃO NO MERCADO</div>
        <div class="beneficio_box_subtitle">Cansado de ficar meses ou anos na mesma situação? Como o membro VIP oferece vantagens exclusivas para você, você se destaca e tem maiores chances de ser contratado.</div>
        
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
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>

<div class="box_content" style="margin-top:0px;">

<div class="box_detail"></div>

<div class="box_content_title">VÍDEO: Veja Como Funciona</div>

<div class="box_content_subtitle" >Saiba passo-a-passo sobre o funcionamento de todas as vantagens exclusivas dos membros VIP</div>



<div class="box_content_txt">
<p><strong>Clique abaixo</strong> para ver o vídeo que irá lhe mostrar como o Membro VIP funciona:</p>

<div class="beneficio_box">
</div>
    <iframe width="90%" height="500" id="video_explicacao" src="http://www.youtube.com/embed/1ZFVeHFqzF0" frameborder="0" allowfullscreen></iframe>
</div>

</div>

<div class="cta">
	<div class="cta_line"></div>

    
    <div class="cta_line_2"></div>
    
          <div class="btm_cta_cadastre">
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png" alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>




<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title"><span id="produto_target">Membro VIP: Vantagens</span></div>

<div class="box_content_subtitle" style="margin-left:-60px;">Descubra agora mesmo porque algumas pessoas conseguem facilmente um emprego enquanto você luta sem resultados.</div>


<div class="box_content_txt">
	Para acelerar sua contratação nosso sistema inteligente conta com diversos benefícios especialmente desenvolvidos para você. 
</div>
<br />

<div class="box_content_subsubtitle">Aqui você terá:</div>

<div class="beneficio_box">


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
        	<img src="gfx/plano_recrutador_novo/beneficios/visualizacoes.png"  width="54" height="52" alt="veja quais empresas visitaram seu curriculo" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Saiba Quais Empresas Viram Seu Currículo</div>
        
        <div class="plano_rec_beneficio_txt">
     		Quer saber quais empresas visualizaram seu currículo? Seja Membro VIP e tenha acesso à uma lista completa com dados de contato de todas elas.
        </div>

     </div>
     
     
	<div class="plano_recr_beneficio">	
    
    	<div class="plano_rec_beneficio_img">
        	<img src="gfx/plano_recrutador_novo/beneficios/candidato_destaque.png"  width="54" height="52" alt="veja quais empresas visitaram seu curriculo" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Seu Currículo em Destaque para Empresas</div>
        
        <div class="plano_rec_beneficio_txt">
     		Diariamente milhares de empresas buscam por currículos como o seu! Deixe-o em destaque para tornar muito mais provável que uma empresa encontre
            suas habilidades durante uma pesquisa em nosso site.</div>

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
        	<img src="gfx/plano_recrutador_novo/beneficios/enviomensagem.png"  width="45" height="45" alt="envio de mensagens para empresas" />
        </div>	
        
        <div class="plano_rec_beneficio_titulo">Envio de Mensagens Para Empresas</div>
        
        <div class="plano_rec_beneficio_txt">
      	Quer dizer algo para empresa anunciante? Seja Membro VIP e convença as empresas sobre o seu potencial!
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
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png" alt="botao cadastrar" class="btm_cadastrar" /></a>
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
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>





<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" >Nossos Planos de Assinatura</div>

<div class="box_content_subtitle" style="margin-left:90px;">Planos compatíveis com suas necessidades de realocação no mercado</div>

<div class="box_content_subsubtitle" id="planos">Escolha o seu plano:</div>


<div class="beneficio_box">

  
    
  	<div class="plano_item"  >
    
   <!-- INICIO FORMULARIO BOTAO PAGSEGURO
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
 NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO 
<input type="hidden" name="itemCode" value="322CA00339396F4774078FA54DA57E72" />
<input type="image" src="gfx/plano_recrutador_novo/planos/vip_trimestral.png" class="fechabanner" style="border:0"   name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
FINAL FORMULARIO BOTAO PAGSEGURO -->
   <a href="membro_vip_pag.php?conta=trimestral" class="fechabanner" style="border:0"   name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!"><img src="gfx/plano_recrutador_novo/planos/vip_trimestral.png" /></a>
   
    </div>
    
    
    
    	<div class="plano_item" style="margin-left:65px;" >
        
        <!-- INICIO FORMULARIO BOTAO PAGSEGURO 
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO 
<input type="hidden" name="itemCode" value="F586B1AD20206EF224586FB2A14C6115" />
<input type="image" src="gfx/plano_recrutador_novo/planos/vip_mensal.png" style="border:0" class="fechabanner" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
 FINAL FORMULARIO BOTAO PAGSEGURO -->
   <a href="membro_vip_pag.php?conta=mensal" class="fechabanner" style="border:0"   name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!"><img src="gfx/plano_recrutador_novo/planos/vip_mensal.png" /></a>
   
    </div>
    
        
<div class="plano_item">
    
    <!-- INICIO FORMULARIO BOTAO PAGSEGURO
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
 NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO 
<input type="hidden" name="itemCode" value="FB6EB0671B1BDD0444A31F91B393F9E8" />
<input type="image" src="gfx/plano_recrutador_novo/planos/vip_semestral.png" style="border:0" class="fechabanner" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
 FINAL FORMULARIO BOTAO PAGSEGURO -->
    <a href="membro_vip_pag.php?conta=semestral" class="fechabanner" style="border:0"   name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!"><img src="gfx/plano_recrutador_novo/planos/vip_semestral.png" /></a>
   

</div>



	
</div>

<!--
<div id="satisfacao_garantida">
	<img src="gfx/plano_recrutador_novo/planos/satisfacao_garantida.png" alt="satisfacao garantida" />
</div>
-->
<div id="pagseguro_logo" style="left:-950px;">
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
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
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
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>






<div class="box_content">

<div class="box_detail"></div>

<div class="box_content_title" id="duvidas">Dúvidas Mais Frequentes</div>

<div class="box_content_subtitle" style="margin-left:60px;" >Tem alguma pergunta sobre o funcionamento do Empregue-me?</div>


<div class="beneficio_box" >

<div class="duvidas_item_scroll">

<div class="duvidas_title">1)E se eu pagar a conta VIP e não tiver mais dinheiro para continuar? Posso cancelar meu plano?</div>

<div class="duvidas_txt">
Sim! Você pode cancelar seu plano a qualquer momento! Caso você crie sua conta VIP e sua situação financeira fique ainda mais difícil por algum motivo, basta parar de pagar que o plano é automaticamente cancelado. Não temos nenhuma intenção de prejudicar ninguém! Muito pelo contrário. O nosso plano de benefícios foi criado com o intúido de oferecer maiores vantagens a quem está disposto a investir em si mesmo. Pague enquanto quiser e puder usufruir de maiores benefícios para conseguir um emprego mais rapidamente.</div>

<div class="duvidas_title">
2) Quanto tempo demora para ativar minha conta VIP após o pagamento?
</div>

<div class="duvidas_txt">
Geralmente a ativação ocorre em até 3 dias úteis após a aprovação do pagamento. Se o prazo correr além disso, entre em contato com sac@empreguemeagora.com.br que resolvemos prontamente seu problema.</div>


<div class="duvidas_title">
3) Irei receber algum produto em casa?
</div>
<div class="duvidas_txt">
Não. Após a aprovação de seu pagamento sua conta GRATUITA sofre uma migração para a CONTA VIP, com a liberação dos benefícios do plano escolhido. Ou seja, é tudo feito pela internet.
</div>

<div class="duvidas_title">
4) O sistema de pagamento do Empregue-me é seguro?
</div>

<div class="duvidas_txt">
Sim! Contamos com uma solução integrada do PagSeguro, um dos mais completos e seguros meios de pagamento na internet.</div>

<div class="duvidas_title">
6) O membro VIP realmente funciona?
</div>

<div class="duvidas_txt">
Sim! A proposta do membro VIP é aumentar suas chances de entrar no mercado de trabalho lhe concedendo diversos benefícios exclusivos que farão com que você saia na frente da concorrência. Isso não significa que vendemos uma fórmula mágica e que você não precisará se esforçar. É claro que terá que enviar os currículos para as oportunidades de seu interesse e ficar muito ligado, caso queira ter resultados satisfatórios como vários de nossos membros vêm tendo.</div>


<div class="duvidas_title">
7) Funciona para qualquer cargo?
</div>

<div class="duvidas_txt">
Sim! Independente se você é auxiliar administrativo, vendedor, atendente, operador de caixa ou de telemarketing. O membro VIP concede maiores chances a todos os cargos.</div>

<div class="duvidas_title">
8) É fácil de usar? E se eu não conseguir utilizar os benefícios?</div>

<div class="duvidas_txt">
Pode ficar tranquilo que é bem fácil sim. Todos os benefícios foram especialmente desenvolvidos para usuários como você, que não querem perder tempo aprendendo a utilizar ferramentas complicadas. Caso tenha alguma dúvida sobre como utilizar, basta solicitar ajuda através do suporte de atendimento prioritário que estaremos prontos para lhe auxiliar com o que for necessário.</div>

<div class="duvidas_title">
9) Se eu for membro VIP será divulgado fora do Empregue-me que estou desempregado?</div>

<div class="duvidas_txt">
Não. Nossa política de privacidade assegura que sua situação não seja exposta para outras pessoas fora da rede social.</div>

<div class="duvidas_title">
10) Como funciona a exclusividade das vagas?</div>

<div class="duvidas_txt">
A exclusividade a qual nos referimos diz respeito à nossa plataforma, ou seja, apenas membros VIPs podem se candidatar a determinadas vagas utilizando o nosso sistema. 

Isso não impede, entretanto, que algumas empresas também anunciem suas oportunidades em outros locais, fazendo com que estas recebam currículos de outros usuários externos ao site. Infelizmente, não temos como evitar que esse grupo de empresas realize tal prática, apesar de aconselharmos boa parte dessas instituições a anunciar somente conosco.</div>


</div>

<div class="duvidas_item">
<div class="duvidas_subtitle">Fale Conosco:</div>
<br />


<?php


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
 
      	<a href="membro_vip.php#planos"><img src="gfx/plano_recrutador_novo/btm_cta_cadastrese.png"  alt="botao cadastrar" class="btm_cadastrar" /></a>
      </div>
</div>





</div><!--END BOX CONTENT ALL-->

<?php
//Mostra beneficios

if(isset($_GET['beneficio']))
{
switch($_GET['beneficio'])
	{
		case 'envio_automatico':
		$display_main->show_banner('Benefício Exclusivo para Membros VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Envie Automaticamente seu Currículo! Seja Membro VIP
		</div>
		
		<div class="descr_assinatura">
		Quer conforto e comodidade enquanto procuramos empregos para você? Crie sua conta VIP agora mesmo e tenha direito a enviar automaticamente seu currículo
		para vagas compatíveis com seu perfil profissional.
		
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="membro_vip.php" target="new"  class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');	
	
		
		break;
		
		case 'cv_destaque':
		$display_main->show_banner('Benefício Exclusivo para Membros VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Seja VIP e tenha seu currículo em destaque para as empresas!
		</div>
		
		<div class="descr_assinatura">
		Quer dar uma maior visualização ao seu currículo deixando-o no <strong>topo das buscas que as empresas realizam?</strong> Crie sua conta VIP e tenha as suas habilidades
		em destaque, aumentando suas chances de ser contratado!
		
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="membro_vip.php" class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');	
		
		
		
		
		break;
		
	}
	
	
}



//7 dias gratis
if(isset($_GET['freetrial']))
{
$display_main->show_banner('Experimente 7 Dias Grátis','
<p>Bom dia, tudo certo? Antes de prosseguir com a promoção de 7 dias grátis, é importante que você <strong>entenda como ela funciona:</strong></p>
<ul style="margin-left:20px;">
	<li>Para participar você deve aderir ao <strong>Plano Trimestral após clicar no botão "Prosseguir" abaixo</strong></li>
	<li>Nessa promoção <strong>só é aceito como forma de pagamento o cartão de crédito</strong>. Para pagamento com outros métodos (ex. Boleto), você deve aderir aos planos abaixo (não inclusos na promoção de 7 dias grátis)</li>
	<li><strong>Após a aprovação da transação pelo pagseguro</strong> você terá <strong>direito a um período de 7 dias gratuitos</strong>, para testar as nossas vantagens.</li>
	<li>Nos primeiros 7 dias após a transação ser aprovada pelo pagseguro você poderá cancelar o pagamento a qualquer momento. Para isso, basta que entre em contato através
	da seção Atendimento no painel à esquerda do membro VIP.</li>
	<li><strong>Caso opte pelo cancelamento nada será cobrado em seu cartão de crédito</strong> pois a transação será estornada em seu cartão de crédito, pelo pagseguro.</li>
	<li>Após aprovação da transação pelo pagseguro, você deve <strong>aguardar até 1 dia útil para a ativação</strong> de sua conta VIP Trimestral 7 Dias Grátis</li>
	<br />
<br />


	<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="C602AA3B8F8F63B224DD3F82DF923883" />
<input type="image" src="gfx/plano_recrutador_novo/prosseguir.png" class="fechabanner" style="border:none;margin-left:35%;" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

</ul>


','small');	
	
	
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

if(isset($_GET['promocao']))
{
			
								
	$display_main->show_banner('Promoção Relâmpago - <span class="vermelho_destaque">Somente para os 20 Primeiros</span>!','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Assine o plano Semestral pelo preço do Trimestral
		</div>
		
		<div class="descr_assinatura">
	Participe desta promoção e receba todos os benefícios do membro vip! Ao adquirir esse plano, você estará pagando o valor do plano trimestral (3 meses) e 
receberá o plano semestral (6 meses).<strong class="vermelho_destaque">Resumindo, irá pagar R$29,90 por 6 MESES de duração do plano VIP! Isso mesmo!</strong>
<br />
<br />
Esta promoção será <strong>apenas para os 20 primeiros usuários</strong> que irão adquirir e <strong>irá durar apenas 48 horas!</strong>
<br />
<br />

Aproveite essa promoção exclusiva, assine o empregue-me por 3 meses e ganhe os outros 3 por nossa conta.	
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
		<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="itemCode" value="06957FF06565878554B97F80247190F5" />
<input type="image" src="gfx/plano_recrutador_novo/adquirir_vip.png" class="fechabanner" style="border:none;" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
		
		
		
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');	
	
	
	

	
}

?>



</body>

</html>














