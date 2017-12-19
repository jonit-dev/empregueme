<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de comentários</title>
<style type="text/css">
@import url('css/comentarios.css');
</style>



<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/comments.js"></script>

</head>

<body>

<p>Esse é o meu post! Produto ID = 106</p>



<span class="like_txt">Curtir</span>
<span class="comentar_txt"><a href="#">Comentar</a></span>

<!--Comment box CSS-->

<div class="mostra_curtidas">
	<div class="coracao_curtir"></div>
	<span class="pessoas_curtiram_top">10 pessoas curtiram isso</span>
</div>

<div class="caixa_comentario"><!--inicia caixa comentario-->
&nbsp;
       <!--inicia carregamento de comentários-->
       <?php
	   require_once('funcoes/db_functions.php');
	   
	   $produto_id = 106;	   //no caso, como exemplo, iremos carregar os comentários do produto 106!
	   $mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to DB');
	   
	   $qry = "SELECT comentario,comentario_id,likes FROM comentarios WHERE produto_id = ?  ORDER BY comentario_id DESC";
	   $stmt = $mysqli->prepare($qry);
	   $stmt->bind_param("i",$produto_id);
	   $stmt->execute();
	   $stmt->bind_result($r_comentario,$r_comentario_id,$r_likes);
	   
	   $tem_resultado = false;
	   
	
	   
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
	   
		
			$tem_resultado = true;
			echo '<!--inicia comentario-->
			
			<div class="comentario" id="'.$r_comentario_id.'">
			
				<div class="remover_comentario" id="'.$r_comentario_id.'"></div>
			
			<div class="img_comentario">
				<img src="foto.jpg" />
			</div>
			<strong>João Paulo Furtado:</strong>'.$r_comentario.'<br />
			
			<div> <a href="#">
			
				<div class="like_comment" id="'.$r_comentario_id.'">Curtir </div>
				<div class="pessoas_curtiram">'.$r_likes.' '.$curt.'</div>
				</a>
			
				
			
			</div></div><!-- end comentario-->';
		}
	   
	   
	   
	   ?> 
       <!--finaliza carregamento de comentários-->
          

<div class="inserir_comentario">
	<textarea maxlength="200" name="mensagem" placeholder="Escreva um comentário..." class="textarea_comentario"></textarea> 
<a href="#" class="enviar_comentario">
Enviar 
</a>
</div>

</div><!--end caixa comentario-->





</body>
</html>