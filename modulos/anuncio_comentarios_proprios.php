<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');


$display_main = new display_main;//associa uma variával à classe de carregamento do layout

//update session vars
check_loggedin();//check if user is logged in!

//o HEAD dessa página é diferente... cuidado
?>
<!DOCTYPE><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>:: Sociallia :: A maior rede social de compras do Brasil</title>
<!--CSS-->
<style type="text/css">
@import url('css/estrutura_index.css');
@import url('css/banner.css');
@import url('css/system_message.css');

@import url('css/autocomplete.css');
@import url('css/anuncio.css');
@import url('fonts/fonts.css');
@import url('css/comentarios.css');
@import url('css/menu.css');
@import url('css/anuncio_interno.css');
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
<?php


$display_main->topo();




$display_main->painel_esquerda();





if(isset($_GET['id']))//se tem script nos passando parametro por GET ID é porque quer mostrar dados do anúncio
{
	
//primeiro, vamos nos conectar à base de dados para capturar informações
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Não foi possível se conectar à base de dados');

//prepara variável
@ $produto_id = mysqli_secure_query($_GET['id']);


//seleciona dados necessáriso
$qry = "SELECT 
produtos.produto_id,
produtos.userid,
produtos.produto_tag,
produtos.produto_titulo, 
produtos.produto_tipo,
categoria.nome_categoria,
subcategoria.subcategoria_nome,
produtos.produto_youtube,
produtos.produto_descricao,
produtos.produto_data,
produtos.produto_preco,
produtos.produto_total_compras,
produtos.produto_tipo_envio,
produtos.produto_div_prazo,
produtos.produto_tipo_a_vista,
produtos.produto_tipo_cartao_deb,
produtos.produto_tipo_cartao_cred,
produtos.produto_foto,
perfil_usuario.CEP,
perfil_usuario.nickname,
tb_cidades.uf,
tb_cidades.nome,
auth.email,
produtos.produtos_likes,
reputacao_usuario.qpositivas,
reputacao_usuario.qnegativas,
reputacao_usuario.transacoes_vendas,
reputacao_usuario.reputacao
 FROM produtos, perfil_usuario, tb_cidades, categoria, subcategoria, auth, reputacao_usuario WHERE reputacao_usuario.userid = produtos.userid AND produtos.userid = auth.userid AND produtos.produto_id = ? AND produtos.userid = perfil_usuario.userid AND perfil_usuario.estado_id = tb_cidades.estado AND perfil_usuario.cidade_id = tb_cidades.id AND produtos.produto_categoria = categoria.id_categoria AND produtos.produto_subcategoria = subcategoria.subcategoria_id";	
$stmt = $mysqli->prepare($qry) or die("Error preparing query");
$stmt->bind_param('i',$produto_id) or die("Error binding parameters");
$stmt->execute() or die("Error executing query");
$stmt->bind_result($r_produto_id,$r_userid,$r_produto_tag,$r_produto_titulo,$r_produto_tipo,$r_produto_categoria,$r_produto_subcategoria,$r_produto_youtube,$r_produto_descricao,$r_produto_data,$r_produto_preco,$r_produto_total_compras,$r_produto_tipo_envio,$r_produto_div_prazo,$r_produto_tipo_a_vista,$r_produto_tipo_cartao_deb,$r_produto_tipo_cartao_cred,$r_produto_foto,$r_vendedor_cep,$r_vendedor_nickname,$r_vendedor_estado,$r_vendedor_cidade,$vendedor_email,$r_produto_likes,$r_qpositivas,$r_qnegativas,$r_transacoes_vendedor,$r_vendedor_reputacao) or die("Error binding result");

//vamos armazenar nosso email em uma variável
$comprador_email = $_SESSION['login'];

$tem_resultado = false;

while($stmt->fetch())//se tiver resultado
{
$tem_resultado = true;

//analisa reputação
//essa variável retorna o percentual de qualificação do vendedor, baseando-se apenas nas qualificações positivas e negativas (neutras não conta, pois, como o nome ja diz, é NEUTRA)
require_once("funcoes/reputacao_function.php");
$mostra_estrelas = mostra_estrelas($r_qpositivas,$r_qnegativas);




//convertendo a data
$data = getdate($r_produto_data);
$dia = $data['mday'];
$mes = $data['mon'];
$ano = $data['year'];
//verificando se divide no prazo
if($r_produto_div_prazo <= 0)
{
	$r_produto_div_prazo = "Não efetuamos parcelamentos.";
}
else
{
$r_produto_div_prazo = $r_produto_div_prazo."x";	
}
$tipo_envio = "";
//forma de entrega ==> formatando tipo de envio
switch($r_produto_tipo_envio)
	{
		case 'fc':
		$tipo_envio = "Frete por conta do comprador";
		break;
		case 'fg':
		$tipo_envio = "Frete grátis";
		break;
	
		case 'rnl':
		$tipo_envio = "Retirar no local de venda";
		break;
		case 'ead':
		$tipo_envio = "Entrega à domicílio";
		break;
	}
	
if ($r_produto_tipo_envio == 'fc')//vamos mostrar opção para calcular frete somente se o tipo de anúncio é FRETE POR CONTA DO COMPRADOR... fora isso, nao tem sentido mostrar algo 
	{
	$frete_string = '<strong>Frete:</strong> <span class="link">Clique aqui para calcular</span> <br />';	
	}
	else
	{
	$frete_string = "";	
	}

//verifica tipos de pagamentos aceitos
$pagamentos_aceitos = "";//cria array para armazenar pagamentos aceitos
if($r_produto_tipo_a_vista == 1)
{
	$pagamentos_aceitos .= "À vista,";
}
elseif($r_produto_tipo_cartao_cred== 1)
{
$pagamentos_aceitos .= "Cartão de crédito,";
}
elseif($r_produto_tipo_cartao_deb == 1)
{
$pagamentos_aceitos .= "Cartão de débito,";
}
$pagamentos_aceitos = rtrim($pagamentos_aceitos,",");

//vamos acertar o preço para inserirmos no anúncio

settype($r_produto_preco,'string');
				$preco = explode(".",$r_produto_preco);
				$reais = $preco[0];
					if (isset($preco[1]))
						{
				$centavos = $preco[1];
				
				//concertar centavos
				if(strlen($centavos) == 1)
					{
					//se só tem um dígito é porque cortou o 0
					$centavos = $centavos."0";//adiciona 0 no final	
					}	
						}
						else
						{
						$centavos = "00";
						}
	
//concertar URL do youtube, para mostrar o video	
if(!strpos($r_produto_youtube,"https://"))//se nao encontrarmos a string correta
{//vamos concertar
	$r_produto_youtube = str_ireplace('http://','https://',$r_produto_youtube);
	$r_produto_youtube = str_ireplace('www.youtube.com/','www.youtube.com/embed/',$r_produto_youtube);
	$r_produto_youtube = str_ireplace('watch?v=','',$r_produto_youtube);
}
	

	
	
				//como vamos mostrar a foto grande aqui, vamos substituir a string _pequena da variável produto_foto
				$r_produto_foto = str_ireplace("_pequena","_grande",$r_produto_foto);
$local_foto = '../upload/gfx/produtos/'.$r_userid.'/'.$r_produto_id.'/'.$r_produto_foto;


$title = ucfirst($r_produto_tag);
/*
$r_produto_tipo_a_vista,$r_produto_tipo_cartao_deb,$r_produto_tipo_cartao_cred,$r_produto_foto,$r_vendedor_cep,$r_vendedor_nickname,$r_vendedor_estado,$r_vendedor_cidade*/
//mostra resultados

//vamos concertar o CEP para o google maps funcionar
$cep = substr_replace($r_vendedor_cep, "-", 5, 0);





$display_main->conteudo('

<!-- GOOGLE MAPS API-->
<div id="panel">

      <input id="address" type="hidden" value="'.$cep.'">
      
    </div>
    <div id="map-canvas"></div>

<!-- GOOGLE MAPS API-->

<!-- ZOOM FOTO-->

<div id="zoom_bkg">&amp;</div>


      <div id="zoom_wrap">
          <div id="zoom_foto_box">
              <img src="'.'../upload/gfx/produtos/'.$r_userid.'/'.$r_produto_id.'/'.$r_produto_id.'_grande.jpeg'.'" />
          </div>
          
          <div id="zoom_close"></div>
          
	</div>
<!-- END ZOOM FOTO-->




<div class="anuncio_nome">'.$title.'</div>
	<div id="anuncio_cat"><a href="main.php" target="_self">Principal</a> > '.utf8_encode($r_produto_categoria).' > '.utf8_encode($r_produto_subcategoria).'</div>

      <div id="anuncio_foto">
      <a href="javascript:void(0)" id="zoom_foto">
		     <img src="'.'../upload/gfx/produtos/'.$r_userid.'/'.$r_produto_id.'/'.$r_produto_id.'_pequena.jpeg'.'" />
       </a>     
       </div>
   	<div id="anuncio_desc">Clique na imagem para aumentar de tamanho</div>
      
<div class="anuncio_titulo">'.$r_produto_titulo.'</div>      

<div class="anuncio_info">
<strong>Tipo do produto: </strong>'.$r_produto_tipo.'
<br />
<strong>Anunciado em:</strong> '.$dia.'/'.$mes.'/'.$ano.'<br/>
<strong>Vendidos:</strong> '.$r_produto_total_compras.'<br />
<strong>Forma de entrega:</strong> '.$tipo_envio.'<br />
'.$frete_string.'

<div id="anuncio_comprar_box">

		<div id="anuncio_prec_txt">
        	<span class="anuncio_txt">Preço:</span>
		</div>
        
		<div id="preco">
        <div id="preco_reais">'.$reais.'
		
				 
		</div>
		<div id="preco_centavos">,'.$centavos.'</div>
		
		</div>
         
		  
		  	<a href="anuncio.php?id='.$r_produto_id.'&&comprar=true">
		<img src="gfx/ui/btm_preco.png" id="anuncio_btm_comprar"/>
			</a>

</div>




<div id="anuncio_vendedor">
	<div id="anuncio_vendedor_titulo">Informações do vendedor</div>
	

	<div id="anuncio_vendedor_reputacao">
		
	'.$mostra_estrelas.' <span class="anuncio_rep"> ('.$r_vendedor_reputacao.')</span>
		
	</div>
	
	
	
    <div id="anuncio_vendedor_info">
    	<strong>Apelido:</strong><span class="link"><strong> <a href="mostra_reputacao.php?id='.$r_userid.'" target="_self">'.$r_vendedor_nickname.'</strong></a></span><br />
		<strong>CEP:</strong> '.$r_vendedor_cep.'<br />
		<strong>Estado:</strong> '.$r_vendedor_estado.'<br />
		<strong>Cidade:</strong> '.$r_vendedor_cidade.'<br />
    
    </div>
</div>

<div id="anuncio_condicoes">
	<div id="anuncio_condicoes_titulo">Condições de pagamento</div>
    <div id="anuncio_condicoes_info">
    	<strong>Formas de pagamento:</strong>'.$pagamentos_aceitos.'
<br />
<strong>Divisões no prazo: </strong>'.$r_produto_div_prazo.'
    	
    
    </div>
</div>


</div>



');

if(!empty($r_produto_youtube))// se o produto tiver vídeo..
	{
	echo '<div id="anuncio_video">
	<div id="anuncio_video_titulo">Vídeo do produto</div>
    <div id="anuncio_video_info">
    	<iframe width="304" height="213" src="'.$r_produto_youtube.'" frameborder="0" allowfullscreen></iframe>
    
    </div>
</div>
';	
	}


//===============>> SISTEMA DE COMENTÁRIOS

?>

<?php
echo '
<div id="anuncio_descricao_fundo">
	<strong>Descrição:</strong>'.$r_produto_descricao.'';
?>


<div id="comentarios_box">

<a href="javascript:void(0)" class="curtir_produto">
<span class="like_txt" id="curtir_produto">Curtir</span>
</a>
<span class="comentar_txt"><a href="javascript:void(0)" id="comentar">Comentar</a></span>
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
			
				<div class="remover_comentario" id="'.$r_comentario_id.'"></div>
			
			<div class="img_comentario">
				<img src="'.$local_foto_comentario.'" />
			</div>
			
			<strong>'.$r_nickname.': </strong>'.$r_comentario.'<br />
			
			<div> <a href="javascript:void(0)">
			
				<div class="like_comment" id="'.$r_comentario_id.'">Curtir </div>
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

echo '<input type="hidden" id="userid" value="'.$_SESSION['userid'].'" />';
echo '<input type="hidden" id="produto_id" value="'.$r_produto_id.'" />';
echo '<input type="hidden" id="user_nickname" value="'.$_SESSION['nickname'].'" />';
?>
    <textarea maxlength="200" name="mensagem" placeholder="Escreva um comentário..." class="textarea_comentario"></textarea> 
<a href="javascript:void(0)" id="send_cmt" class="enviar_comentario">
Enviar 
</a>
</div>

</div><!--end comentario box-->

<?php
echo '</div>';//fecha div descrição (o posicionamento dos comentários é relativo à descrição

}

if($tem_resultado == false)
{
//se por algum motivo nao achar o produto, mostra pagina de error e encerra carregamento de dados
$display_main->show_system_message('Produto não encontrado!','error');	
$display_main->painel_direita();
$display_main->fundo();
exit;
}








//==========> COMPRA DE PRODUTO

if(isset($_GET['comprar']))//se usuário passou parametro por get para comprar produto
	{

//primeiro, vamos verificar se o usuário tem os dados preenchidos por completo. Se não, vamos capturar o restante dos dados!
if($_SESSION['estado_id'] == 0)
{
	//vamos mostrar um banner com um formulário para captar os dados dele (estado, cidade, telefone, CEP
			require_once('funcoes/funcoes_estruturais.php');
			banner_restante_dados('comprar');
//Código javascript para atualizar SELECT da cidade
?>
 <script type="text/javascript" src="js/estado_cidade_load.js"></script>

<script type="text/javascript">
//código javascript para mostrar o banner
$(document).ready(function(e) {

	$("#banner_bkg").show();//mostra fundo
		$("#show_banner").fadeIn(500);//mostra banner

	});//end ready
</script>

<?php
}//end estado id
else//se já tiver dados preenchidos, prossiga!
{


		//primeiro vamos checar se não é o usuário tentando comprar o próprio produto!
			if($_SESSION['userid'] == $r_userid)//se o usuário da sessão é o mesmo que está registrado no anúncio
				{
echo "
	<script type='text/javascript'>
		$(document).ready(function(){
				alert('Você não pode comprar o próprio produto!');
			});
	</script>
";
$display_main->painel_direita();
$display_main->fundo();
exit;
				}


//se não é o usuário tentando comprar o próprio produto, vamos prosseguir

	
		
		  //mostra mensagem de confirmação e envia email
			  $display_main->show_banner('Comprar produto','
			  <form action="minhas_compras.php" method="post">
			  <p>Antes de prosseguir com a compra, informe ao vendedor os seguintes dados:</p>
			  
			  	<ul>
					Quantidade: <li><input type="text" onkeypress="return isNumber(event)" maxlength="3" name="quantidade" class="ddd"/></li>
					Mensagem para vendedor:<span class="campo_opcional">*.opcional</span> 
					<li>
						<textarea name="mensagem" placeholder="Insira aqui alguma observação relacionada com sua compra (opcional)" cols="50" rows="2" maxlength="150" style="resize:none"></textarea>
					</li>
				</ul>
				
				<input type="hidden" name="comprador_email" value="'.$comprador_email.'"/>
				<input type="hidden" name="produto_id" value="'.$r_produto_id.'"/>
			  	<input type="hidden" name="vendedor_id" value="'.$r_userid.'"/>
			  	<input type="hidden" name="produto_nome" value="'.$r_produto_tag.'"/>
			  	<input type="hidden" name="vendedor_nome" value="'.$r_vendedor_nickname.'"/>
			  	<input type="hidden" name="vendedor_email" value="'.$vendedor_email.'"/>
			  
			  <input type="submit" value="Confirmar compra"/>
			  
			  </form>
			  
			  
			  ','small');
			  
		
		
				
	}
	}//end else estado id = 0



//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if(isset($_GET['show_message']))//mostra a mensagem de alteração
{
	switch($_GET['tipo'])//verifica o tipo da mensagem
		{
			case 'sucesso'://se for de sucesso...
	$display_main->show_system_message($_GET['show_message'],'sucesso');
			break;	
			case 'error'://se for de sucesso...
	$display_main->show_system_message($_GET['show_message'],'error');
			break;	
			
			
				}
}



//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();


}//end GET['id']
else
{
	$display_main->show_system_message('Produto não encontrado','error');	
$display_main->painel_direita();
$display_main->fundo();
exit;
}

//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();

?>


