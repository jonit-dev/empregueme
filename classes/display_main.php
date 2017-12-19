<?php

class display_main
{

    function head($import_extra = "", $js_extra = "")
    {

        //RESOLVENDO PROBLEMAS DE CHARSET
        ini_set('default_charset', 'UTF-8'); //seta o charset padrão para UTF-8


        require_once('funcoes/url_functions.php');
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:: empregue-me :: A maior rede profissional do Brasil</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Acesse o Empregue-me gratuitamente e fique por dentro de milhares oportunidades anunciadas em seu estado!" />
<meta name="keywords" content="empregos, oportunidades, vagas, anunciar vagas es, anunciar vagas sp, trabalho no es, trabalho em es, trabalhar em vitória, empregos em vitória, empregos es" />
<meta name="author" content="Empregue-me"
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="http://empreguemeagora.com.br/images/favicon.ico" type="image/x-icon" />

<!--CSS-->
<style type="text/css">
@import url(\'css/painel_propaganda.css\');
@import url(\'css/estrutura_index.css\');
@import url(\'css/banner.css\');
@import url(\'css/system_message.css\');
@import url(\'css/autocomplete.css\');
@import url(\'css/anuncio.css\');
@import url(\'fonts/fonts.css\');
@import url(\'css/comentarios.css\');
@import url(\'css/menu.css\');
@import url(\'css/menu_anunciar.css\');
@import url(\'css/get_image.css\');
@import url(\'css/vaga.css\');
@import url(\'css/busca.css\');
@import url(\'css/box_feedback.css\');
@import url(\'css/botoes.css\');
@import url(\'css/info_box.css\');

' . $import_extra . '
</style>
<!--end css-->

<!--LOAD jQUERY-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

<!--Código do banner-->
<script type="text/javascript" src="js/script_banner.js">
</script>

<!--Função para mostrar mensagens do sistema-->
<script type="text/javascript" src="js/system_message.js"></script>

<!--Função para mostrar comentários-->
<script type="text/javascript" src="js/comments.js"></script>

<!-- Gerenciador Ajax - Select Estado / Cidade-->
 <script type="text/javascript" src="js/estado_cidade_load.js"></script>

<!--SCRIPT MENU SETTINGS-->

 <script type="text/javascript" src="js/settings_menu.js"></script>
 
 <!--ANUNCIO-->
 <script type="text/javascript" src="js/anuncio.js"></script>
 
 <!--CONTROLE BOTAO ANUNCIAR PRODUTO-->
  <script type="text/javascript" src="js/menu_anunciar.js"></script>
  
  <!--MOSTRA AJUDA-->
  <script type="text/javascript" src="js/ajuda.js"></script>
  

  <!--CAIXA FEEDBACK-->
  <script type="text/javascript" src="js/feedback_box.js"></script>
 
 <!--PLUGINS DE MENSAGEM - NOTY -->
  <script type="text/javascript" src="plugins_jquery/noty-2.2.4/js/noty/packaged/jquery.noty.packaged.min.js"></script>
 
 
 
   <!--BANNER CARREGADO DIRETO NO JAVASCRIPT-->
  <script type="text/javascript" src="js/banner_direto_js.js"></script>
  
   <!--FILTRO PARA TELEFONE-->
  <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
  <script type="text/javascript">
  jQuery(function($){
    $("input[type=tel]").mask("(99) 9999-9999?9").ready(function(event) {
        var target, phone, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        phone = target.value.replace(/\D/g, "");
        element = $(target);
        element.unmask();
        if (phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    });
    });
  </script>
  
 
  
 
 ' . $js_extra . ' ';


//SESSION TIME OUT - Evitando que usuário fique muito tempo logado

        /* if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 18000)) {
             // last request was more than 30 minutes ago
             session_unset();     // unset $_SESSION variable for the run-time
             session_destroy();   // destroy session data in storage
             redireciona("index.php"); //volta pra pag login
         }
         $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

         if (!isset($_SESSION['CREATED'])) {
             $_SESSION['CREATED'] = time();
         } else if (time() - $_SESSION['CREATED'] > 18000) {
             // session started more than 30 minutes ago
             session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
             $_SESSION['CREATED'] = time();  // update creation time

             redireciona("index.php"); //volta pra pag login
         }*/
    }

    function topo($load_fb_code = false)
    {
        //primeiro, identifica tipo de conta para saber qual barra rapida criar (se para pessoa física ou empresa)
        if (isset($_SESSION['tipo_conta'])) {
            if ($_SESSION['tipo_conta'] == 0)//pessoa física
            {
                $barra_rapida_codigo = '<form action="main.php?pesquisa=true" method="post">
		
			<input name="p_estado" value="all" type="hidden"/>
			<input name="p_cidade" value="all" type="hidden"/>
			<input name="p_categoria" value="all" type="hidden"/>
		
			
		<input type="search" name="p_vaga" id="busca_rapida" placeholder="Digite o nome da vaga..."/>		
	
<div style="display:none;">
<input type="submit" value="Encontrar"/>
</div>
</form>';

            } else//conta empresa
            {
                $barra_rapida_codigo = '<form action="main.php?pesquisa=true" method="post">
		
			<input name="p_estado" value="all" type="hidden"/>
			<input name="p_cidade" value="all" type="hidden"/>
			<input name="p_categoria" value="all" type="hidden"/>
				<input name="p_cnh" value="all" type="hidden"/>
						
		<input type="search" name="p_vaga" id="busca_rapida" placeholder="Digite um cargo específico..."/>		
	
<div style="display:none;">
<input type="submit" value="Encontrar"/>
</div>
</form>';
            }

        }//if isset tipo conta
        else//usuário não logado
        {
            $barra_rapida_codigo = '<form action="main.php?pesquisa=true" method="post">
		
			<input name="p_estado" value="all" type="hidden"/>
			<input name="p_cidade" value="all" type="hidden"/>
			<input name="p_categoria" value="all" type="hidden"/>
		
			
		<input type="search" name="p_vaga" id="busca_rapida" placeholder="Digite o nome da vaga..."/>		
	
<div style="display:none;">
<input type="submit" value="Encontrar"/>
</div>
</form>';
        }


        //barra de busca rápida
        echo '</head>
		
		' . $barra_rapida_codigo . '
		
		
		
		<body>';


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


        //CÓDIGO FACEBOOK

        if ($load_fb_code == true) {//se é para carregarmos código para funcionar plugins do facebook...
            echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/pt_BR/all.js#xfbml=1&appId=392928604125411";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
        }

        echo '<!--HEADER-->
<div class="top_header">
	<a href="main.php" target="_self"><div class="logo"><img src="gfx/logo.png" width="200" height="46"/></div></a>
	';
        if (isset($_SESSION['login'])) {//se usuário está logado
            echo '
    <div class="settings"><div class="settings_txt"><a href="javascript:void(0)" target="_self">Minha Conta</a></div></div>
    <div id="menu_settings">
   	  <div class="menu_detail"></div>

     <div class="menu_option"> <img src="gfx/ui/mixer.png" class="menu_img"/><a href=\'change_pw.php\'>Alterar Senha</a></div><br />

     <div class="menu_option">	<img src="gfx/ui/logout.png" class="menu_img"/><a href=\'logout.php\'>Sair</a></div>

  </div>';
        }
        echo '
	
</div>
<!--END HEADER-->
';
    }

    function painel_esquerda($mostra_busca = false)
    {


        //====> GERENCIAMENTO DA FOTO E BOTÕES

        if (isset($_SESSION['login'])) {//se usuário estiver logado
            if ($_SESSION['usu_foto_perfil'] != "") {//se TEM foto
                $local_foto_perfil = '../upload/gfx/perfil/' . $_SESSION['usu_foto_perfil']; //mostra foto 
            } else {
                $local_foto_perfil = ""; //mostra nada
            }

            $user_name = $_SESSION['nickname']; //mostra nome e foto correspondente
        } else {//se nao estiver logado, mostra nome e foto de visitante
            $local_foto_perfil = 'gfx/ui/visitante.png';
            $user_name = 'Visitante';
        }

        if (!isset($_SESSION['login'])) {//se nao ta logado, mostra botao de se cadastrar e enviar produto

            if (isset($_SESSION['adwords'])) {
                $anunciar_ou_cadastrar = '';
            } else {

                if (isset($_SESSION['tipo_conta'])) {
                    if ($_SESSION['tipo_conta'] == 1) {
                        $link_cadastrar = "index_empresa.php";
                    }

                } else {
                    $link_cadastrar = "index.php#content_index";
                }

                $anunciar_ou_cadastrar = '<a href="' . $link_cadastrar . '">
		<img src="gfx/ui/btm_cadastre_se.png"/>
			</a>
			<br />

			<a href="index_empresa.php">
			<img src="gfx/ui/btm_postar_vaga.png" id="anunciar_sem_login" />
        	</a>
						
			<script type="text/javascript">
			$(document).ready(function(e) { 
			
					$("#anunciar_sem_login").click(function(c){
						
						
						
						function redireciona_agora()
								{
								window.location.replace("index.php");
								exit;
								}
							
							
							
						alert("CRIE SUA CONTA ou faça LOGIN para anunciar sua vaga!");
					
											
						
						});//end click
							
						
			});//end ready
						
				</script>
			
			';
            }
        } else {//se tá logado, vamos verificar qual o tipo de conta
            switch ($_SESSION['tipo_conta']) {
                case 0://se é conta tipo PESSOA FÍSICA

                    if ($_SESSION['curriculo'] == 0)//se o currículo NÃO foi postado
                    {
                        $link = "curriculo.php";
                        $anunciar_ou_cadastrar = '<a href="' . $link . '">
			<img src="gfx/ui/btm_postar_curriculo.png" />
        	</a>	';
                    }//1 = ativo, 2 = pendente, 3 = inativo
                    else//se o currículo FOI postado, vamos fazer propaganda VIP SE O USUÁRIO AINDA NÃO FOR VIP
                    {
                        if ($_SESSION['membro_vip_ativo'] == 2 || $_SESSION['membro_vip_ativo'] == 3 || empty($_SESSION['membro_vip_ativo']))//nao ativo
                        {

                            $anunciar_ou_cadastrar = '<a href="membro_vip.php">
			<img src="gfx/ui/btm_criar_conta_vip.png" />
        	</a>	';
                        }
                        if ($_SESSION['membro_vip_ativo'] == 1)//ativo
                        {
                            $anunciar_ou_cadastrar = '
			<img src="gfx/ui/btm_conta_vip_ativa.png" />
        	';
                        }
                    }
                    break;

                case 1://se é conta tipo EMPRESA
                    $anunciar_ou_cadastrar = '
		
				
				<!-- INICIA CODIGO MENU ANUNCIAR-->
<div id="menu_anunciar">
	<img id="arrow_anunciar" src="gfx/ui/arrow_box.png"/>
    
    <div class="opcao_anunciar">
    	<img src="gfx/ui/heart.png" class="opcao_anunciar_img"/>
        <div class="opcao_anunciar_txt"><a href="cadastra_vaga.php" target="_self">Anunciar Vaga</a></div>
    </div>
    
    <div class="opcao_anunciar">
    	<img src="gfx/ui/Bullhorn.png" class="opcao_anunciar_img"/>
        <div class="opcao_anunciar_txt"><a href="plano_recrutador.php" target="_self">Busca Avançada de Currículos</a> </div>
    </div>
    
</div>
<!--TERMINA CODIGO MENU ANUNCIAR-->
		

		<a href="javascript:void(0)">
			<img src="gfx/ui/btm_postar_vaga.png" id="abrir_menu" />
        	</a>			';
                    break;
            }
        }

        echo '<!--PAINEL ESQUERDA-->
<div id="box_wrapper">';

//ajusta tamanho da caixa preta de acordo com necessidade de botões
        if (isset($_SESSION['login'])) {
            echo '<div id="box_top" >';
        } else {
            echo '<div id="box_top" style="height:170px;">';
        }


        echo '<a href="edit_profile.php?alterar_foto=true" target="_self">';
        if (file_exists($local_foto_perfil)) {//se usuário já tem foto cadastrada
            echo '
    	<div id="foto_perfil">
			  	<img src="' . $local_foto_perfil . '" width="75" height="75"/>
            <div id="foto_mask" width="75" height="75"></div>
        </div>    
        ';
        } else {//se nao, vamos inserir uma foto padronizada
            echo '<div id="foto_perfil">
			  	<img src="gfx/ui/sem_foto.png" width="75" height="75"/>
            <div id="foto_mask" width="75" height="75"></div>
        </div>   ';
        }

        echo '</a>';
        echo '
        <div id="nome_usuario">' . $user_name . '</div>
        ';
        if (isset($_SESSION['login'])) {//se estiver logado, mostra link para  perfil
            echo '<div id="editar_perfil">
			<a href="edit_profile.php" target="_self">
			Editar Perfil
			</a>
			</div>';
        }
        echo '
        <div id="btm_anunciar">
        		 ' . $anunciar_ou_cadastrar . '
		</div>
        
	</div>';

        if (isset($_SESSION['login'])) {//mostra caixa de opções se usuario está logado somente.
            echo '<div id="box_meio">';


//vamos armazenar em variáveis as opções que são próprias de quem já é vip e de quem não é VIP, para facilitar na organização
            /*
                        $opcoes_nao_vip = '<div class="painel_opcao">
                                <a href="membro_vip.php"><b>Aumente suas chances</b></a>
                                </div>

                                <div class="painel_opcao">
                                <a href="membro_vip.php?beneficio=envio_automatico" target="new"><b>Envio Automático de CV</b></a>
                                </div>


                            ';
            */

            $opcoes_do_vip = '		
<div class="painel_opcao">
			<a href="vagas_exclusivas.php"><strong>Vagas exclusivas</strong></a>
					</div>

<div class="painel_opcao">
			<a href="atendimento_vip.php"><strong>Atendimento</strong></a>
					</div>
					
			<!--				<div class="painel_opcao">
			<a href="curso_online.php"><strong>Cursos Online</strong></a>
					</div>-->
					<!--
							<div class="painel_opcao">
			<a href=\'cadastra_envio_automatico.php\'><strong>Envio automático de CV</strong></a>
					</div> -->
				';
            /*
                        $opcao_de_renovacao_contavip = '
                                        <div class="painel_opcao">
                        <a href="vagas_exclusivas.php"><strong>Renovar Plano</strong></a>
                                </div>';

                        $opcoes_do_vip_nao_ativo = '<div class="painel_opcao">
                                <a href="membro_vip_pag.php">Situação da minha conta</a>
                                </div>
                                                    <div class="painel_opcao">
                                <a href="membro_vip_pag.php?status=1">Renovar conta VIP</a>
                                </div>


                            ';
            */

//agora vamos verificar se o user é vip ou não e mostrar o menu de acordo.
            /*            if ($_SESSION['membro_vip_ativo'] == 0) {//se nao está ativo
                            $lista_opcoes_vip = $opcoes_nao_vip;
                        }
                        if ($_SESSION['membro_vip_ativo'] == 1) {//se está ativo
                            $lista_opcoes_vip = $opcoes_do_vip;
                        }
                           if ($_SESSION['membro_vip_ativo'] == 2) {//se indivíduo pagou mas ainda não foi ativado
                            $lista_opcoes_vip = $opcoes_do_vip_nao_ativo;
                        }
            */
//OPÇÃO CADASTRO DE CURRÍCULo

//vamos verificar se o usuário já tem currículo cadastrado. Se sim, mostra opção. Caso contrário, não mostra


            if ($_SESSION['curriculo'] == 0)//se user n tem cv cadastrado..
            {
                $opcao_cadastra_cv = '<div class="painel_opcao">
					<a href=\'curriculo.php\'>Cadastrar meu currículo</a>
				</div>';
            } else//se já tem...
            {
                $opcao_cadastra_cv = '';//nao mostra opção pra cadastrar o cv
            }


            $opcoes_de_cv_cadastrado = '';
            if ($_SESSION['curriculo'] != 0)//se tiver o CV cadastrado no sistema...
            {
                $cv_destaque = '';
                if ($_SESSION['membro_vip_ativo'] != 1)//se nao for VIP ativo mostra opcao
                {
                    $cv_destaque = '	<div class="painel_opcao">
					<a href="membro_vip.php?beneficio=cv_destaque"><b>Deixar CV em destaque</b></a>
				</div>';
                }


                $opcoes_de_cv_cadastrado = '
	
				<div class="painel_opcao">
					<a href="visitas_perfil.php"><b>Quem viu meu CV?</b></a>
				</div>
			' . $cv_destaque . '
				
				<div class="painel_opcao">
					<a href=\'perfil.php?id=' . $_SESSION['userid'] . '\'>Ver meu currículo</a>
				</div>
				<div class="painel_opcao">
					<a href=\'editar_curriculo.php?id=' . $_SESSION['userid'] . '\'>Editar meu currículo</a>
				</div>';
            }


            switch ($_SESSION['tipo_conta']) {
                case 0://pessoa física
                    echo '
					<div class="painel_titulo">VAGAS</div>
       	 	<div class="painel_opcao">
				<a href="main.php" target="_self">
			Últimas vagas</a></div>
					<div class="painel_opcao">
			<a href="vagas_exclusivas.php"><strong>Vagas exclusivas</strong></a>
					</div>
			
			<div class="painel_titulo">CURRÍCULO</div>
    				' . $opcao_cadastra_cv . '
					
					' . $opcoes_de_cv_cadastrado . '
			
				
					<!---<div class="painel_opcao">
						<a href=\'#\'>Editar meu currículo</a>
					</div>--->
                                        
                                    <div class="painel_titulo">PRESTADOR DE SERVIÇO</div>
                        <div class="painel_opcao"><a href=\'cadastra_freelancer.php\'>Cadastro de Serviço</a></div>                        
                        <div class="painel_opcao"><a href=\'busca_freelancer.php\'>Procurar Prestador</a></div>
                        <div class="painel_opcao"><a href=\'meus_servicos.php\'>Meus serviços</a></div>
					
							
			
					
	
			
			
			';
                    break;
                case 1://empresa

                    if (isset($_SESSION['plano_recrutador_ativo'])) {
                        if ($_SESSION['plano_recrutador_ativo'] == 1)//se o plano recrutador estiver ativo
                        {
                            echo '<div class="painel_titulo">PLANO RECRUTADOR</div>
					
					
					<div class="painel_opcao">
						<a href="busca_avancada.php" target="_self">
					<b>Buscar Currículos</b></a></div>
					
					<div class="painel_opcao">
						<a href="painel_gerencia_cv.php" target="_self">
					<b>Gerenciar CVs</b></a></div>
					
					<div class="painel_opcao">
						<a href="cv_favoritos.php" target="_self">
					<b>Candidatos Favoritos</b></a></div>
					
							<div class="painel_opcao">
						<a href="atendimento_recrutador.php" target="_self">
					<b>Atendimento</b></a></div>
					
							<div class="painel_opcao">
						<a href="cadastra_vaga_destaque.php" target="_self">
					<b>Vaga Destaque</b></a></div>
					
					
					
					';

                        }

                        if ($_SESSION['plano_recrutador_ativo'] == 0)//se o plano recrutador não estiver ativo
                        {
                            echo '<div class="painel_titulo">PLANO RECRUTADOR</div>
					
					
					<div class="painel_opcao">
						<a href="plano_recrutador.php" target="_self">
					<b>Criar Plano Recrutador</b></a></div>';
                        }

                    }


                    echo '<div class="painel_titulo">PRINCIPAL</div>
       	 	<div class="painel_opcao">
				<a href="main.php" target="_self">
			Últimos candidatos</a></div>
			
			<div class="painel_titulo">BUSCA</div>
       	 	<div class="painel_opcao">
				<a href="busca_avancada.php" target="_self">
			Pesquisar Currículos</a></div>
			
			
			<div class="painel_titulo">ANÚNCIOS</div>
        	<div class="painel_opcao">
				<a href=\'meus_anuncios.php\'>Meus anúncios</a></div>
					<div class="painel_opcao">
				<a href=\'cadastra_vaga.php\'>Anunciar uma vaga</a>
			</div>
                        
                                    <div class="painel_titulo">PRESTADOR DE SERVIÇO</div>
                        <div class="painel_opcao"><a href=\'cadastra_freelancer.php\'><strong>Cadastro de serviço</strong></a></div>                        
                        <div class="painel_opcao"><a href=\'busca_freelancer.php\'>Procurar Prestador de Serviços</a></div>
                        <div class="painel_opcao"><a href=\'meus_servicos.php\'>Meus serviços</a></div>
			
			';
                    break;
            }
        } else {//se nao estiver logado
            //mostra apenas fundo cinza
            echo '<div id="box_meio">
    	<div class="painel_titulo">PRINCIPAL</div>
       	 	<div class="painel_opcao">
				<a href="main.php" target="_self">
			Últimos Candidatos</a></div>';
        }

        echo '
	
	
    </div><!-- end box meio-->



</div>



<!--END PAINEL ESQUERDA-->';

        echo '<div id="conteudo">'; //inicia painel de conteúdo!!

        if ($mostra_busca == true) {
            require_once('funcoes/funcoes_busca.php');

            if (!isset($_SESSION['tipo_conta'])) { //se nao estiver logado...
                carrega_busca();
            } else { //se estiver logado
                //verifica tipo de conta do usuário
                if ($_SESSION['tipo_conta'] == 0) {//PESSOA FÍSICA
                    carrega_busca();
                }
                if ($_SESSION['tipo_conta'] == 1) {//EMPRESA
                    carrega_busca_empresa();
                }
            }
        }


        echo '<div id="system_message"></div>'; //carrega div de mostrar resultados
    }

    function painel_direita()
    {
        echo '</div>'; //fecha conteúdo (content)


    }

    function painel_propaganda()
    {

        if (isset($_SESSION['userid'])) {

            if (($_SESSION['membro_vip_ativo'] == 0 || $_SESSION['membro_vip_ativo'] == 2) && $_SESSION['tipo_conta'] == 0)//se tá logado e nao é membro VIP (conta vencida ou não é VIP msm)
            {

                $propaganda_width = 100;
                $propaganda_height = 100;
                if (isset($_SESSION['nome'])) {
                    $primeiro_nome = explode(' ', $_SESSION['nome']);
                } else {
                    $primeiro_nome = '';
                }


                if ($_SESSION['tipo_conta'] == 0) {
                    $tipo_painel_propaganda = 'painel_propaganda';
                }
                if ($_SESSION['tipo_conta'] == 1) {
                    $tipo_painel_propaganda = 'painel_propaganda_empresa';
                }

                /*
                <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso de assistente administrativo</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=F1903981O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/455aaddd-276e-4bac-91a3-510a9ff4bc88/cursoAssistenteAdministrativo.jpg" alt="curso assistente administrativo" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Ganhe dinheiro fabricando trufas, bombons, pirulitos e ovos de páscoa</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=A1904224O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/f9582594-c720-4fcf-9509-e776f8c64066/moduloII.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso de Excel</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1904177O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/060d7b8b-59b1-4307-a04d-800f462ba1b8/13511015738588096416543331776871.tmp" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>

                        </div>
                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Ganhe dinheiro com Roupas de marcas importadas</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=D1904238O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/01d182db-0448-4b17-9fb9-dc149a828d1c/ea1a75c8245f913cc4eaacf9af9.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso Ganhe dinheiro no Mercado Livre</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=M1904048O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/ed9cf975-d348-44e8-9eaf-37cacbb6c7f8/cursomercadolivre.jpg" alt="curso de mercado livre" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Guia da vida profissional</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=M1904115O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/61aa19e0-c704-4893-8827-2f490931c17a/capahotmart_b.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso Técnica de Vendas</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1904135O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/29a34e10-b8a4-4863-afbf-b425f210a6d5/13511016641715456113282541056124.tmp" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Fabrique perfumes para vender</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=E1907130O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/ada63ef8-fdd2-4ceb-b5d2-d5021d8b80f0/comoimportarperfumes2.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>



                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso ganhar dinheiro com Fábrica de Chinelos</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=M1904225O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/67d1baaf-b1c4-4bb2-8ae0-150a7c52736b/capaebookcomomontarsuafabricadechinelos.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso - Como montar a sua pizzaria</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=c1907128O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/56ff48f5-c8ba-40f2-8be6-f11862018010/capadoebookpizzaiolo3.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>

                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Ganhe dinheiro fabricando Queijo Minas</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1907112O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/5ecc3a0a-828c-4935-9a9d-5feba6433690/1351101369856629478210703366657.tmp" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                                <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso: Ganhe dinheiro fabricando cosméticos artesanais</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=v1904243O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/3e0b1ce5-f878-40c4-80c4-67912ba2cbf5/ebookoficial.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>









                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Guia de Emagrecimento rápido</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=V1904075O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/2de721d9-506a-41a5-870d-ea18fa614f93/ebookhotmart.jpg" alt="guia emagrecimento rápido" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Guia Aprovação em Concursos</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=L1904061O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/e70e7a79-719c-4e6e-ad3b-1e9c510c8578/aformuladaaprovacao250X250.jpg" alt="guia aprovação em concursos" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>



                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso de Recepcionista de Hotel</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1904092O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/9b412448-a087-4519-8ecb-d4f3b6417669/13511016419805732165833473506049.tmp" alt="guia aprovação em concursos" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Guia Entrevista de Emprego</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1904099O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/3cee5e86-8643-414e-9dbb-a4824435098f/13511013992983083441426276582377.tmp" alt="guia aprovação em concursos" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>



                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso Como Importar da China</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=e1904085O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/65c257cf-c2df-4157-80fb-f498a8707524/CIDCDvdfechadoJPG.jpg" alt="guia aprovação em concursos" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>




                            <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso de Inglês - Definitivo</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=M1904121O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/ef18652a-5ba7-4cd8-a6f4-e1f8fe4a1558/CAIGD3d.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>



                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso Nova Ortografia da Língua Portuguesa</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=C1904186O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/53df4b27-d6da-4da5-9464-7096331f6a70/13511015885743583487367085505652.tmp" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Curso ganhar dinheiro com Cupcakes</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=V1904204O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/a082234a-3ad3-49cf-b619-5a4ecc1b06e9/hotmart2.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>


                        <div class="item_propaganda">
                            <div class="titulo_propaganda"><strong>Ganhe dinheiro importando suplementos</strong></div>
                        <a href="http://hotmart.net.br/show.html?a=R1904218O" target="new">
                        <div class="foto_propaganda">

                        <img src="https://hotmart.s3.amazonaws.com/product_pictures/d2bd4d25-9f35-4594-b259-d60f32492d35/beforeafterleftinside.jpg" width="'.$propaganda_width.'" height="'.$propaganda_height.'">
                        </div>

                        </a>
                        </div>
                */
                echo '
			<div id="' . $tipo_painel_propaganda . '">
			
			
			
			<strong style="margin-left:15px;font-size:13px;" >:: SEJA MEMBRO VIP ::</strong>
	<p class="propaganda_txt">
			Ei, ' . $primeiro_nome[0] . '!  Já pensou você ter<strong> acesso a vagas super valiosas com quase ninguém concorrendo?</strong> Que tal garantir um futuro melhor? <strong  class="vermelho_destaque">Conseguir um emprego mais rápido?</strong> Crie já sua conta VIP e faça parte dessa seleta comunidade!
			</p>
			
<center>			<div class="fb-facepile" data-href="https://www.facebook.com/empreguemeoficial" data-width="200" data-height="100" data-max-rows="1" data-colorscheme="light" data-size="small" data-show-count="true"></div>
		</center>	<br />

			 <a href="membro_vip.php" style="margin-left:0%;" class="botao_cta">Quero um Emprego</a>
	
 				
			</div>
			
			
		
			
		
		';
            }//end if set membro_vip_ativo
        }


    }


    function conteudo($content = '')
    {

        echo $content;
    }

    function fundo()
    {
        /* 	echo '<div id="bottom">
          <div class="copyright"><center>Projeto RSC - CopyRight - 2014</center></div>
          </div>
         */


        echo '
</body>
</html>';
    }

    function show_banner($title, $content, $banner_type = 'big')
    {
        if ($banner_type == 'small') {
            echo '
	<!--Código do banner-->
<div id="show_banner">
    <div id="banner_bkg">
    </div>
  <div id="wrap">
    <div id="banner_small">
  
      <div id="close"></div>
      <div id="banner_title">' . $title . '</div>
      <div id="banner_txt">' . $content . '</div>
  </div>    
    </div>
</div>';

//código javascript para mostrar o banner
            echo '<script type="text/javascript">
$(document).ready(function(e) {

	
		
		$("#banner_bkg").show(0,0,function(){
			$("#show_banner").fadeIn(200)			
			});
			
	
	});//end ready

</script>';
        } elseif ($banner_type == 'big') {
            echo '
	<!--Código do banner-->
<div id="show_banner">
    <div id="banner_bkg">
    </div>
  <div id="wrap">
    <div id="banner_big">
  
      <div id="close"></div>
      <div id="banner_title">' . $title . '</div>
      <div id="banner_txt">' . $content . '</div>
  </div>    
    </div>
</div>';

//código javascript para mostrar o banner
            echo '<script type="text/javascript">
$(document).ready(function(e) {

	
		
		$("#banner_bkg").show(0,0,function(){
			$("#show_banner").fadeIn(200)			
			});
			
	
	});//end ready

</script>';
        } elseif ($banner_type == 'giant') {
            echo '
	<!--Código do banner-->
<div id="show_banner">
    <div id="banner_bkg">
    </div>
  <div id="wrap">
    <div id="banner_giant">
  
      <div id="close"></div>
      <div id="banner_title">' . $title . '</div>
      <div id="banner_txt">' . $content . '</div>
  </div>    
    </div>
</div>';

//código javascript para mostrar o banner
            echo '<script type="text/javascript">
$(document).ready(function(e) {

	
		
		$("#banner_bkg").show(0,0,function(){
			$("#show_banner").fadeIn(200)			
			});
			
	
	});//end ready

</script>';
        }
    }

//end show banner

    function show_system_message($content, $type = 'sucesso')
    {
        switch ($type) {
            case 'sucesso':
                echo '<script type="text/javascript">
		$(document).ready(function(e) {
			mostra_mensagem("' . $content . '","sucesso");
			
		});//end ready
		</script>';
                break;

            case 'error':
                echo '<script type="text/javascript">
		$(document).ready(function(e) {
		
			mostra_mensagem("' . $content . '","error");
		});//end ready
		</script>';

                break;
        }
    }

    function head_pagamento($js_extra = "")
    {

        //RESOLVENDO PROBLEMAS DE CHARSET
        ini_set('default_charset', 'UTF-8'); //seta o charset padrão para UTF-8


        require_once('funcoes/url_functions.php');
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="http://empreguemeagora.com.br/images/favicon.ico" type="image/x-icon" />
<title>:: empregue-me :: A maior rede profissional do Brasil</title>
<!--CSS-->
<style type="text/css">
@import url(\'css/estrutura_index.css\');
@import url(\'css/banner.css\');
@import url(\'css/system_message.css\');
@import url(\'css/autocomplete.css\');
@import url(\'css/anuncio.css\');
@import url(\'fonts/fonts.css\');
@import url(\'css/comentarios.css\');
@import url(\'css/menu.css\');
@import url(\'css/menu_anunciar.css\');
@import url(\'css/get_image.css\');
@import url(\'css/vaga.css\');
@import url(\'css/busca.css\');
@import url(\'css/box_feedback.css\');
</style>
<!--end css-->

<!--LOAD jQUERY-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

 ' . $js_extra . ' ';

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

//SESSION TIME OUT - Evitando que usuário fique muito tempo logado

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 18000)) {
            // last request was more than 30 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
            redireciona("index.php"); //volta pra pag login
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 18000) {
            // session started more than 30 minutes ago
            session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
            $_SESSION['CREATED'] = time();  // update creation time

            redireciona("index.php"); //volta pra pag login
        }
    }

    function show_mini_popup($mensagem)
    {
        echo '<script type="text/javascript">
		$(document).ready(function(e) {
			mostra_mini_popup("' . $mensagem . '");
			
		});//end ready
		</script>';
    }

    function noty($texto, $tipo, $posicao, $timeout)
    {
        echo '<script type="text/javascript">
	var n = noty(
			  {
				  text: "' . $texto . '",
				  type: "' . $tipo . '",
				  layout:"' . $posicao . '",
				  timeout:' . $timeout . '
			  });	
			  
			  </script>';
    }

//end show message
}

//end class
?>