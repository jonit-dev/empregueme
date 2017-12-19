<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/atualiza_cargo_functions.php');

        require_once('funcoes/url_functions.php');
		require_once('funcoes/alert_functions.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado
//verifica se está logado
//check_loggedin();

if (session_id() == '') {
    session_start();
}


if(isset($_SESSION['userid']))
{
session_refresh();

atualiza_cargo();//verifica se cargo do usuário está atualizado. Se não estiver, redireciona-o para atualizar!
}




//o HEAD dessa página é diferente... cuidado

$display_main->head('@import url(\'css/anuncio_interno.css\');@import url(\'css/botoes.css\');', '

<!--CÓDIGO PRA SOMENTE PERMITIR NUMEROS NO INPUT-->
<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>


<!--GOOGLE MAPS API-->
<!--Load google maps API-->
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHfuxs8gZVjrDuI7sB9-kNgOobvVEPBBc&sensor=true">
    </script>
<script type="application/javascript" src="js/google_maps_api.js"></script> 


<script type="text/javascript" src="js/zoom_foto.js"></script> 

<script type="text/javascript">
$(document).ready(function(e) {
    
$("body").attr("onload","codeAddress()");//isso é para api do google maps funcionar
});//end ready
</script>


   <!--- ENVIO DE CURRICULOS-->
      <script type="text/javascript" src="js/envio_curriculo.js"></script>

');
?>


<?php
$display_main->topo();
?>
<!--JAVASCRIPT SDK - FACEBOOK -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=457411647692763";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php
//no caso do painel a esquerda, vamos verificar. Se estiver logado, mostra versão original. Se não, vai mostrar o painel do visitante.
//veja scripts internos
$display_main->painel_esquerda();





if (isset($_GET['id'])) {//se tem script nos passando parametro por GET ID é porque quer mostrar dados do anúncio
//primeiro, vamos nos conectar à base de dados para capturar informações
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");

//prepara variável
    @ $vaga_id = mysqli_secure_query($_GET['id']);

//seleciona dados necessáriso
    $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla,cid.cep, 
        cat.cat_nome,usu.usu_cep
        FROM vagas vagas, cidades cid, estados es, categoria cat, usuario usu
        WHERE vagas.cid_codigo = cid.cod_cidades
        AND cid.estados_cod_estados = es.cod_estados 
        AND vagas.vag_codigo = ? 
        AND vagas.cat_codigo = cat.cat_codigo 
        AND vagas.usu_codigo = usu.usu_codigo";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $vaga_id);
    $stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome, $r_cep, $r_vag_categoria, $r_usu_cep);






    require_once('funcoes/string_functions.php');

    $tem_resultado = false;

    while ($stmt->fetch()) {//se tiver resultado
        $tem_resultado = true;

//VAGAS VIP --> se usuário for VIP vamos fazer verificação de status da conta do usuário e barrá-lo se não for vip
        if ($r_vag_exclusivo == 1) {//se a vaga for exclusiva para VIPs
            check_vip(); //verifica se é VIP. Se não for, avisa usuário e redireciona para pag do plano VIP
        }


        //sql com quantidade de cadidatos por vagas
        $mysqli = mysqli_full_connection();
        $qry = "SELECT count(*) as cont FROM vagas vag,curriculos_vagas currVag 
            WHERE currVag.vag_codigo = vag.vag_codigo
            AND vag.vag_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $r_vag_codigo);
        $stmt->execute();
		
	$stmt->store_result();
        $stmt->bind_result($r_vag_candidatos);
        while ($stmt->fetch()) {
            
        }
        //$stmt->close();

        $title = ucfirst($r_vag_nome);

//mostra resultados
//vamos concertar o CEP para o google maps funcionar
        if ($r_usu_cep != "") {
            $cep = substr_replace($r_usu_cep, "-", 5, 0);
        } else {
            $cep = substr_replace($r_cep, "-", 5, 0);
        }


        //ajusta salário
        if ($r_vag_salario == "0.00") {
            $r_vag_salario = "À combinar";
        } else {
            $r_vag_salario = "R$ " . $r_vag_salario; //ajusta com simbolo de R$	
        }



//AJUSTE DE VARIÁVEIS
//se nao tiver nome da empresa, coloque como nome do empregue-me
        if ($r_vag_empresa == "") {
            $r_vag_empresa = "empregue-me";
        }

//ajusta referencias

		//verifica se o usuário é membro VIP para mostrar email
		$mostra_email = '';
		
		if(isset($_SESSION['membro_vip_ativo']))
		{
			if($_SESSION['membro_vip_ativo'] == 1)
				{
					$mostra_email = '<strong>E-mail:</strong> ' . $r_vag_email. '<br />';
				}
			else
			{
				$mostra_email = "<strong>E-mail:</strong> <span class='vermelho_destaque'><a href='membro_vip.php'>Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</a></span><br />";	
			}
		}
		else
		{
					$mostra_email = "<strong>E-mail:</strong> <span class='vermelho_destaque'><a href='membro_vip.php'>Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</a></span><br />";	
		
		}



//verifica se precisa mostrar telefone
        if ($r_vag_telefone == "") {
            $mostra_telefone = "";
        } else {
			
			if(isset($_SESSION['membro_vip_ativo']))
		{
			//verifica se o usuário é membro VIP
			if($_SESSION['membro_vip_ativo'] == 1)
				{
					$mostra_telefone = '<strong>Telefone:</strong> ' . $r_vag_telefone . '<br />';
				}
			else
			{
				$mostra_telefone = "<strong>Telefone:</strong> <span class='vermelho_destaque'><a href='membro_vip.php'>Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</a></span><br />";	
			}
		}
		else
		{
							$mostra_telefone = "<strong>Telefone:</strong> <span class='vermelho_destaque'><a href='membro_vip.php'>Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</a></span><br />";	

		}
		
			
			
            
        }

 $page_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//botão candidatar
        //verifica curriculo e mostra se ele é habilitado ou não para enviar para vaga
        if (empty($_SESSION['login']) || !isset($_SESSION['login'])) {//se usuário não estiver logado, vamos abrir form de login/criar conta
		
		if(isset($_SESSION['adwords']))//se é user vindo do adwords...
			{
				            $r_curriculo = '<a class="btm_cadastrar" href="main.php?freetrial=true">Candidatar</a>';
			}
			else
			{
				            $r_curriculo = '<a class="btm_cadastrar" href="'.$page_url.'&login=true">Candidatar</a>';
			}
		
		

        } else {
            //vamos verificar se é vaga VIP
            //verifica curriculo e mostra se ele é habilitado ou não para enviar para vaga
            if ($_SESSION['curriculo'] == 0) { // curriculo = 0 o candidato nao criou o curriculo
                if ($_SESSION['tipo_conta'] == 0) {
                    //se uusário não criou currículo e for pessoa física ==> redireciona para criar currículo
					$r_curriculo = '<a class="btm_cadastrar" href="main.php?mostra_alerta=semcv&ref='.$vaga_id.'">Candidatar</a>';
					
					
					
                } else {
                    $r_curriculo = "";//se o tipo de conta não for 0 é pq é empresa.. então nao pode enviar currículo
                }
            } else {
                //verifica se o candidato ja enviou currículo
                $qry = "SELECT count(*) as qtd FROM curriculos_vagas where curr_codigo = ? and vag_codigo = ?";
                $stmt = $mysqli->prepare($qry);
                $curriculo = $_SESSION['curriculo'];
                $stmt->bind_param('ii', $curriculo, $r_vag_codigo);
                $stmt->execute();
				$stmt->store_result();
                $stmt->bind_result($r_qtd);
                while ($stmt->fetch()) {
                    
                }
                if ($r_qtd == 1) { //se o resultado for 1 o candidato nao pode se candidatar, caso contrario ele está apto.
                    $r_curriculo = '<h4 style="color: red;">Voce já se candidatou a essa vaga</h4>';
                } else {
                    if ($r_vag_exclusivo == 1 && $_SESSION['membro_vip_ativo'] == 0) {//Se a vaga é exclusiva e o cara não é VIP
                        $r_curriculo = '<a class="btm_cadastrar" href="membro_vip.php">Seja VIP</a>'; //mostra pra ser VIP
                    } else {// se não for exclusiva, pode candidatar
                       
					   
					   // $link = "http://www.empregue-me.com/novo/curriculo/envio/envia_curriculo/" . $_SESSION['userid'] . "/" . $r_vag_codigo; //online			
					   
                        $r_curriculo = '
						<input type="hidden" name="userid" value="'.$_SESSION['userid'].'"/>
						<input type="hidden" name="vaga_codigo" value="'.$vaga_id.'"/>
						<a class="btm_cadastrar" href="javascript:void(0)">Candidatar</a>';
                    }
                }
            }
        }

//verifica URL da página (uso no botão abaixo e no facebook)

        $page_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        //verifica o tipo de usuário, empresa nao precisa do botao candidatar
        if (isset($_SESSION['tipo_conta'])) {//verifica se user está logado
            if ($_SESSION['tipo_conta'] == 0) {
                $botao_candidatar = '<div id="candidatar_box"><center>' . $r_curriculo . '</center></div>';
            } else {
                $botao_candidatar = '';
            }
        } else { //se nao estiver logado, vamos mostrar o botão com o link pro user logar ou criar conta rapidamente
		
			if(isset($_SESSION['adwords']))//se é user vindo do adwords...
			{
				                      $botao_candidatar = '<div id="candidatar_box"><center><a href=""><a class="btm_cadastrar" href="main.php?freetrial=true">Candidatar</a></a></center></div>'; //se não está logado mostra botão que redireciona para fazer login

			}
		else
		{
		
            $botao_candidatar = '<div id="candidatar_box"><center><a href=""><a class="btm_cadastrar" href="' . $page_url . '&login=true">Candidatar</a></a></center></div>'; //se não está logado mostra botão que redireciona para fazer login
		}
		
		}

        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");
        $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
        $stmt = $mysqli->prepare($qry);

        $stmt->execute();
		
	$stmt->store_result();
        $stmt->bind_result($r_sigla, $r_cod_est);

        $estados = '';
        while ($stmt->fetch()) {
            $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
        }
//================ BANNER DE LOGIN OU CRIAR CONTA!
        if (isset($_GET['login'])) {
			
		require_once('funcoes/Mobile_Detect.php');
		$detect = new Mobile_Detect;
		
		//se for celular, redirecione para pagina inicial e faça user crair conta
		
		if($detect->isMobile())
			{
				redireciona('index.php?vaga_id='.$vaga_id);
				
			}
		
			
            $display_main->show_banner('Faça Login ou Crie sua Conta', '

<center>
	<form action="login_user.php?loadafter=' . $page_url . '" method="post">
	<h2 class="vermelho_destaque">Já é registrado? Faça Login</h2>

		
		<ul>
			<li>
				 <span class="small_txt">E-mail:</span> <input type="email" name="login" class="input_index" id="focus_here" placeholder="Digite seu e-mail">	
			</li>
			<li>
			<span class="small_txt">Senha:</span>&nbsp;&nbsp;<input type="password" name="password" class="input_index" placeholder="Digite sua senha">
			</li>
			<li>
				<span class="detalhe"><a href="index.php?esqueci_senha=true" target="_new">Esqueci minha senha</a></span>
			</li>
			
		</ul>
           	<input type="submit" class="botao_cta" style="margin-left:40px;"value="Entrar"/>
					
	
	</form>

	<h2 class="vermelho_destaque">Novo por aqui? Crie sua Conta</h2>
	
	
	<div style="margin-left:40px;">
<a href="index.php?vaga_id='.$vaga_id.'">
<input type="button" class="botao_cta" value="Criar Minha Conta"/></a>
	</div>
	</center>
	
	
	
	', 'small');
        }//end banner login
//--------------- END BANNER LOGIN-------------------//
//CÓDIGO DO FACEBOOk
        echo '
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=392928604125411";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';




		
	$facebook_code = '<div class="fb-like" data-href="' . $page_url . '/vaga.php?id=' . $r_vag_codigo . '" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>';//código padrão, se nao encontrar estado específico para mostrar fan page


        switch($r_vag_estado_nome)//vamos analisar o nome do estado e mostrar fan page do estado de acordo
			{
				case 'ES':
					$facebook_code = '<div class="fb-like" data-href="http://www.facebook.com/empreguemeoficial" data-width="400" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>';//fan page do ES
				break;
				case 'SP'://fan page sp
							$facebook_code = '<div class="fb-like" data-href="http://www.facebook.com/empreguemesp" data-width="400" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>';//fan page do SP
				break;	
			}
		
	

        $sistema_viral = '
		
		
		<div id="like_box">
'.$facebook_code.'

<br />
<br />

<div class="fb-comments" data-href="' . $page_url . '/vaga.php?id=' . $r_vag_codigo . '" data-numposts="10" data-colorscheme="light"></div>

</div>';

//ajusta data
        //ajusta data
        $data = explode('-', $r_vag_dt_inicio);
        $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];

        $display_main->conteudo('

<!-- GOOGLE MAPS API-->
<div id="panel">

      <input id="address" type="hidden" value="' . $cep . '">
      
    </div>
    
<!-- GOOGLE MAPS API-->

<div class="anuncio_nome">' . $title . '</div>
	<div id="anuncio_cat"><a href="main.php" target="_self">Principal</a> > ' . ($r_vag_categoria) . '</div>

<div class="anuncio_info">
<strong>Tipo da vaga: </strong>' . $r_vag_tipo . '
<br />
<strong>Anunciado em:</strong> ' . $data_ajustada . '<br/>
<strong>Candidatos:</strong> ' . $r_vag_candidatos . '<br />
<strong>Empresa:</strong> ' . $r_vag_empresa . '<br />
<strong>Local:</strong> ' . $r_vag_estado_nome . ', ' . $r_vag_cidade_nome . '<br />
<strong>Salário:</strong> ' . $r_vag_salario . '<br />		
<strong>Regime de contratação:</strong> ' . $r_vag_tipo . '<br />
' . $mostra_telefone . '
'.$mostra_email.'
<strong>Quantidade de vagas:</strong>' . $r_vag_qtd . '</br>
<strong>Descrição:</strong> ' . nl2br($r_vag_descricao) . '<br />' . $botao_candidatar . $sistema_viral . ' 
   
   
   
    <div id="anuncio_vendedor">
    <div id="anuncio_vendedor_titulo">Informações do anunciante</div>
    <div id="anuncio_vendedor_info">
			  <strong>Empresa:</strong><span class="link">' . $r_vag_empresa . '</span><br />
			  <strong>CEP:</strong> ' . $cep . '<br />
			  <div id="map-canvas"></div>

	</div>
	</div>

<div id="anuncio_vip">
    <div id="anuncio_vip_titulo">Consiga um emprego rápido</div>
    <div id="anuncio_vip_info">
			 Crie já sua <strong>conta VIP</strong> exclusiva e aumente suas chances de conseguir um emprego em 17x!
			 <br />
<br />

			 <a href="membro_vip.php" style="margin-left:0%;" class="botao_cta">Criar conta VIP</a>
			 
			  
			  </div>

	</div>
	</div>





</div>




');
?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0726154942329779";
/* empregueme_cabecalho */
google_ad_slot = "5762670690";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<?php


//===============>> SISTEMA DE COMENTÁRIOS + BOTÕES SOCIAIS



        /*
          echo '
          <div id="anuncio_descricao_fundo">
          <strong>Descrição:</strong>'.$r_vag_descricao.'';

          ?>


          <div id="comentarios_box">
          <?php
          if(isset($_SESSION['login']))
          {
          echo '<a href="javascript:void(0)" class="curtir_produto">
          <span class="like_txt" id="curtir_produto">Curtir</span>
          </a>';
          }
          ?>

          <span class="comentar_txt"><a href="javascript:void(0)" id="comentar">Comentar</a></span>

          <?php
          if(!isset($_SESSION['login']))
          {
          echo '<script type="text/javascript">
          $(document).ready(function(){
          $("#comentar").click(function(){
          alert("Você precisa fazer LOGIN ou CRIAR SUA CONTA para comentar.");

          });

          });
          </script>';
          }
          ?>

          <!--Comment box CSS-->
          <div class="mostra_curtidas">

          <?php
          //vamos ajusta o texto dos likes do produto
          $mensagem_likes = "";//vamos criar a variável primeiro
          if($r_produto_likes == 1)//vamos configurar a frase de acordo com o n° de likes
          {
          $mensagem_likes = $r_produto_likes." pessoa curtiu isso";
          }
          elseif($r_produto_likes > 1)
          {
          $mensagem_likes = $r_produto_likes." pessoas curtiram isso";
          }
          elseif($r_produto_likes = 0)
          {
          $mensagem_likes = "";
          }



          echo '<span class="pessoas_curtiram_top">'.$mensagem_likes.'</span>';

          if($r_produto_likes > 0)//só vamos mostrar o coração do curtir se o produto tem mais de 1 like
          {
          echo '	<div class="coracao_curtir"></div>';
          }
          ?>

          </div>

          <div class="caixa_comentario"><!--inicia caixa comentario-->
          <!--inicia carregamento de comentários-->
          <?php

          $produto_id = $r_produto_id;	   //no caso, como exemplo, iremos carregar os comentários do produto 106!
          $mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to DB');

          $qry = "SELECT
          comentarios.comentario,
          comentarios.comentario_id,
          comentarios.likes,
          perfil_usuario.nickname,
          comentarios.userid

          FROM comentarios,perfil_usuario WHERE produto_id = ? AND perfil_usuario.userid = comentarios.userid ORDER BY comentario_id DESC";
          $stmt = $mysqli->prepare($qry);
          $stmt->bind_param("i",$produto_id);
          $stmt->execute();
          $stmt->bind_result($r_comentario,$r_comentario_id,$r_likes,$r_nickname,$r_comentarista_id);

          $tem_comment = false;



          while($stmt->fetch())
          {

          //isso daqui é pra variar a palavra conforme o numero de likes

          if ($r_likes == 1)
          {
          $curt = "pessoa curtiu";
          $r_likes = "·".$r_likes;
          }
          elseif($r_likes > 1)
          {
          $curt = "pessoas curtiram";
          $r_likes = "·".$r_likes;
          }
          elseif($r_likes == 0)
          {
          $curt = "";
          $r_likes = "";
          }


          $tem_comment = true;

          //upload\gfx\perfil\27\perfil_fotos


          $local_foto_comentario = '../upload/gfx/perfil/'.$r_comentarista_id.'/perfil_fotos/foto_comentario.jpeg';


          echo '<!--inicia comentario-->

          <div class="comentario" id="'.$r_comentario_id.'">
          ';
          if(isset($_SESSION['login']))
          {
          echo'
          <div class="remover_comentario" id="'.$r_comentario_id.'"></div>
          ';
          }
          echo'
          <div class="img_comentario">
          <img src="'.$local_foto_comentario.'" />
          </div>

          <strong>'.$r_nickname.': </strong>'.$r_comentario.'<br />

          <div> <a href="javascript:void(0)">
          ';
          if(isset($_SESSION['login']))
          {
          echo '<div class="like_comment" id="'.$r_comentario_id.'">Curtir </div>';
          }
          echo '
          <div class="pessoas_curtiram">'.$r_likes.' '.$curt.'</div>
          </a>



          </div></div><!-- end comentario-->';
          }



          ?>
          <!--finaliza carregamento de comentários-->




          </div><!--end caixa comentario-->
          <div class="inserir_comentario">

          <?php
          //esses dois inputs servem para captar valores e passar pro script de enviar comentário e curtir produto
          require_once('funcoes/url_functions.php');
          $page_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          if(isset($_SESSION['login']))
          {

          echo '<input type="hidden" id="userid" value="'.$_SESSION['userid'].'" />';
          echo '<input type="hidden" id="produto_id" value="'.$r_produto_id.'" />';
          echo '<input type="hidden" id="user_nickname" value="'.$_SESSION['nickname'].'" />';
          ?>
          <textarea maxlength="200" name="mensagem" placeholder="Escreva um comentário..." class="textarea_comentario"></textarea>
          <a href="javascript:void(0)" id="send_cmt" class="enviar_comentario">
          Enviar
          </a>
          <?php
          }
          ?>

          </div>

          </div><!--end comentario box-->

          <?php

          echo '</div>';//fecha div descrição (o posicionamento dos comentários é relativo à descrição
         */
//esse daqui é o botão de curtir / compartilhar
    }

    if ($tem_resultado == false) {
//se por algum motivo nao achar o produto, mostra pagina de error e encerra carregamento de dados
        $display_main->show_system_message('Vaga não encontrada!', 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }



//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
    if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
        switch ($_GET['tipo']) {//verifica o tipo da mensagem
            case 'sucesso'://se for de sucesso...
                $display_main->show_system_message($_GET['show_message'], 'sucesso');
                break;
            case 'error'://se for de sucesso...
                $display_main->show_system_message($_GET['show_message'], 'error');
                break;
        }
    }



//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
    $display_main->painel_direita();
    $display_main->fundo();
}//end GET['id']
else {
    $display_main->show_system_message('Vaga não encontrada', 'error');
    $display_main->painel_direita();
    $display_main->fundo();
    exit;
}

//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();
?>


