<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style type="text/css">
@import url('anuncio.css');
@import url('fonts/fonts.css');
</style>

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
	
	
	  var currentMousePos = { x: -1, y: -1 };
    $(document).mousemove(function(event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });
	
	
	$(".anuncio_descricao").hide();//esconde a descrição de todos os anúncios
    
	$(".anuncio").mouseover(function(){
			
		//$(this).children('.anuncio_descricao').fadeIn(500);
		
		$(this).children('.anuncio_descricao').show();
		$(this).children('.anuncio_descricao').animate(
			{
			bottom:'80px',
			right:'-1px',
			opacity:'.8'
			},500
		);
		
		
		
		
		});//anuncio mouse over
		
		
	$(".anuncio").mouseleave(function(){
			
			$(".anuncio_descricao").fadeOut(500);
		
		
		});//anuncio mouse over
	
	/*
$("#dica").hide();//esconde dica

$(".box_tipo").mouseover(function(){
	
		$("#dica").fadeIn(400);
		$("#dica").css('top',currentMousePos.y);
		$("#dica").css('left',currentMousePos.x);
		
	
	});//mostra dica

setInterval('$("#dica").hide()',5000);*/

});//end ready



</script>
</head>

<body>
<h1>Últimos anúncios</h1>

<div id="anuncios_box">

<div class="anuncio">

<div class="box_tipo"></div>
<div class="produtos_vendidos"><center>10</center></div>

<img src="exemplo.png" />

<div class="price_tag">
</div>
<span class="reais_grande">19999</span><span class="centavos_grande">,99</span>




<div class="anuncio_descricao"><div class="description_txt">Iphone 5S Original, Direto dos EUA! Frete Grátis</div></div>


<div class="produto_nome">
Iphone 5S
</div>

<div class="produto_local">
Bom Jesus do Itabapoana, ES
</div>

<div class="produto_data">
20/09/1990
</div>

<img src="gfx/ui/map_point.png" class="produto_map_point"/>




<div class="info">

<div class="info_txt">

<div class="dados_vendedor">
<span class="nome_vendedor">jonit_se</span><span class="reputacao_vendedor"> (1400)</span>
</div>
</div><!--end dados vendedor-->


<div class="reputacao_div">
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
</div>

</div><!--end info txt-->

</div><!--end anuncios box--></div>


<!--DICAS-->
<!--
<div id="dica"><span class="dica_text">
Essa é uma dica!</span>
</div>
-->

</body>
</html>