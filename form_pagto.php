<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
@import url('css/form_pagto.css');
@import url('css/fonts.css');
</style>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/form_pagamento.js"></script>
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

</head>

<body>
<?php
//carrega arquivo com o layout


if(!isset($_SESSION['categorias']))//se ainda nao carregou, vamos carregar
{
require_once('funcoes/db_functions.php');

//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
$_SESSION['categorias'] = "";
$mysqli = mysqli_full_connection();

$qry = "SELECT cat_codigo, cat_nome FROM categoria";

$stmt = $mysqli->prepare($qry);
$stmt->execute();

$stmt->bind_result($r_cat_codigo,$cat_nome);

while($stmt->fetch())
	{
		$_SESSION['categorias'] .= '<input type="checkbox" name="categoria" value="'.$r_cat_codigo.'" />'.utf8_encode($cat_nome).'<br />';
	}
}
?>

<!--FORMULARIO DE PAGAMENTO-->
<form action="" method="post">
<div id="checkout">

<div class="tab_panel">
	<div class="tab" id="tab1" ><img src="gfx/membro_vip/checkout/step1.png" alt="selecione seu plano" /></div>
    <div class="tab" id="tab2"><img src="gfx/membro_vip/checkout/step2.png" alt="Preencha o formulário" /></div>
    <div class="tab" id="tab3"><img src="gfx/membro_vip/checkout/step3.png" alt="Informações de pagamento" /></div>
</div>
<br />
<br />
<br />


<div class="content">

<div id="content1">

<h4>Selecione seu Plano</h4>
	<div id="box_planos">
    <div class="planos">
    	<input type="radio" name="plano"  value="mensal" id="plano_mensal" checked="checked"/><span class="planos_txt">Mensal</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$30,90</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">22</div>
                <div class="plano_valor_menor">,90</div>
                </div>
                
       
       </div> 

<div class="planos">
    	<input type="radio" name="plano"  value="trimestral" id="plano_trimestral"/><span class="planos_txt">Trimestral</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$68,90</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">44</div>
                <div class="plano_valor_menor">,90</div>
                </div>
                
       
       </div> 
        
        
        
        </div>
        <br />
<br />

<h4>Escolha as áreas de seu interesse:</h4>

<div id="categorias">
	<?php
	echo $_SESSION['categorias'];
	?>
</div>

<br />
<br />

<center>
<input type="button" class="btm_checkout" id="go2" value="Prosseguir">
</center>
</div>

<div id="content2">

<h4>Preencha seus dados:</h4>
    <ul>
    	<li>Nome completo: <input type="text" name="nome" placeholder="Insira seu nome completo" class="form_txt_big"/></li>
        <li>E-mail: <input type="email" name="email" placeholder="Insira seu e-mail" class="form_txt_big"/></li>
        <li>Endereço: <input type="text" name="endereco" placeholder="Rua/Avenida" class="form_txt_big"/></li>
        <li>Número residencial: <input type="text" name="n_residencial" placeholder="Somente números"  onkeypress="return isNumber(event)" class="form_txt_big"/></li>
        <li>Complemento: <input type="text" name="complemento" placeholder="Sua residência é próxima do quê?" class="form_txt_big"/></li>
        <li>Bairro: <input type="text" name="bairro" placeholder="Nome do seu bairro" class="form_txt_big"/></li>
        <li>CEP: <input type="text"  name="cep"   onkeypress="return isNumber(event)" placeholder="Somente números" class="form_txt_big"/></li>
        
        <li>Estado: <select name="estado" id="estado" >
    	<option value="none">Selecione seu estado...</option>
	<option value="1">AC</option><option value="2">AL</option><option value="3">AM</option><option value="4">AP</option><option value="5">BA</option><option value="6">CE</option><option value="7">DF</option><option value="8">ES</option><option value="9">GO</option><option value="10">MA</option><option value="11">MG</option><option value="12">MS</option><option value="13">MT</option><option value="14">PA</option><option value="15">PB</option><option value="16">PE</option><option value="17">PI</option><option value="18">PR</option><option value="19">RJ</option><option value="20">RN</option><option value="21">RO</option><option value="22">RR</option><option value="23">RS</option><option value="24">SC</option><option value="25">SE</option><option value="26">SP</option><option value="27">TO</option>
		 			 </select>
		<li> Cidade: <select name="cidade" id="cidade" >
    	<option value="none">Selecione seu estado primeiro...</option>
    </select>
         
        
    </ul>
 
 
 
    <!-- AJAX DO CARREGAMENTO DA CIDADE-->
    <script type="text/javascript" src="js/estado_cidade_load.js"></script>






<center>
<span class="texto_contrato">Ao clicar em continuar você concorda com o contrato de prestação de serviços referente ao Membro VIP Empregue-me.<a href="#"> Clique aqui para realizar a leitura</a></span>
</center>
<br />
<br />
<center>
<input type="button" class="btm_checkout" id="go3" value="Prosseguir">
</center>
</div>

<div id="content3">
          <div id="forma_pagto">
          <h4>Escolha a sua forma de pagamento:</h4>
              Boleto bancário: <input type="radio" name="forma_pagto" value="boleto" checked="checked"/><br />
              Cartão de Crédito: <input type="radio" name="forma_pagto" value="cartao" /><br />
                      
          </div>
          
          <div id="info_pagto">
          
          		
<div id="content3_boleto">
<h4>Informações para pagamento por boleto:</h4>

<ul> 
<li>1. O boleto <strong>deve ser impresso para ser pago </strong>(em alguma casa lotérica ou no banco).<strong>Não enviamos boletos impressos para sua residência!</strong>
</li>
<li>2. Caso não tenha impressora em sua residência, efetue o pagamento através do cartão de crédito</li>
</ul>
<br /><br />
<br />
<br />
<br />
<br />
<br />

<center>
<input type="button" class="btm_checkout" id="confirmar_boleto" value="Confirmar">
</center>
</div>



<div id="content3_cartao">

<h4>Preencha os dados de seu cartão:</h4>
    <ul>
    	<li>Cartão de Crédito: <select name="cartao" class="form_txt_big">
        	<option value="Visa">Visa</option>
            <option value="MasterCard">MasterCard</option>
            <option value="AmEx">American Express</option>
            <option value="elo">Elo</option>
            <option value="aura">Aura</option>
            <option value="DinersClub">Diners Club</option>
            <option value="hipercard">HiperCard</option>
            
            
        </select></li>
    	<li>Parcelamento: <select name="parcelamento" class="form_txt_small">
        	<option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            
            
        </select> x</li>
        <div class="cartao_container">
    	<li>Número do cartão: <input type="text" name="n_cartao"  onkeypress="return isNumber(event)" placeholder="Somente números" class="form_txt_big"/>
        	<div class="checa_valido">Número de cartão inválido. Verifique se foi digitado corretamente.</div>
            
            <div class="box_cartao" style="position:absolute; top:-40px;  left:350px;">
            	<div class="seta_box_cartao">
            	<img src="gfx/membro_vip/checkout/cartoes/seta.png" alt="seta" />
            </div>

                <img src="gfx/membro_vip/checkout/cartoes/cartao_numero.png" alt="numero do cartao" />
  
            </div>
       		
            
            </div>
        
        </li>
        <li>
        <?php
		$meses = '';
		for($i= 0;$i <= 12;$i++)	
			{
				$meses .= '<option>'.$i.'</option>';	
			}
			
			$ano = '';
			for($i=2014;$i<=2040;$i++)
			{
				$ano .= '<option>'.$i.'</option>';
	
			}
			
		?>
        
        <div class="cartao_container">
        Data de expiração do cartão:<select name="mes_expira" class="form_txt_small">
        	<?php
			echo $meses;
			?>
        </select>
        <select name="ano_expira" class="form_txt_small">
        	<?php
			echo $ano;
			
			?>
            </select>
             <div class="box_cartao" style="position:absolute; top:-40px;  left:320px;">
            	<div class="seta_box_cartao">
            	<img src="gfx/membro_vip/checkout/cartoes/seta.png" alt="seta" />
            </div>

                <img src="gfx/membro_vip/checkout/cartoes/cartao_expiracao.png" alt="expiracao do cartao" />
  
            </div>
            
            
            </div>
            
        </li>
        <div class="cartao_container">
        <li>Código de segurança (CVV): <input type="text" name="cvv_cartao" maxlength="4" onkeypress="return isNumber(event)" placeholder="Últimos 3 números atrás do cartão" class="form_txt_medio"/>
        <div class="box_cartao" style="position:absolute; top:-40px;  left:320px;">
            	<div class="seta_box_cartao">
            	<img src="gfx/membro_vip/checkout/cartoes/seta.png" alt="seta" />
            </div>

                <img src="gfx/membro_vip/checkout/cartoes/cartao_cvv.png" alt="cvv do cartao" />
  
            </div>
        </div></li>
        
        
        <div class="cartao_container">
        <li>Nome do dono do cartão: <input type="text" name="nome_cartao" placeholder="Nome COMPLETO do dono do cartão" class="form_txt_big"/>
        <div class="box_cartao" style="position:absolute; top:-40px;  left:390px;">
            	<div class="seta_box_cartao">
            	<img src="gfx/membro_vip/checkout/cartoes/seta.png" alt="seta" />
            </div>

                <img src="gfx/membro_vip/checkout/cartoes/cartao_nome.png" alt="cvv do cartao" />
  
            </div>
        
        </div>
        </li>
         
         
         
         
         
         <li>CPF do dono do cartão: <input type="text" name="cpf_cartao" placeholder="CPF do dono do cartão. Somente números"   onkeypress="return isNumber(event)" class="form_txt_big"/><div class="checa_valido">CPF inválido. Verifique se foi digitado corretamente.</div></li>
          <li>Telefone do dono do cartão: <input type="text" name="telefone_cartao" placeholder="Telefone do dono do cartão"  onkeypress="return isNumber(event)" class="form_txt_big"/></li>
           <li>Data de nascimento: <input type="text" name="data_nasc_cartao" placeholder="Data de nascimento"  class="form_txt_big"/></li>
</ul>

<br />

<center>
<input type="button" class="btm_checkout" id="confirmar_cartao" value="Confirmar">
</center>
</div>



          </div>

</div>




</div>
<center>
<div id="selos_garantia">
<img src="gfx/membro_vip/site-protegido.jpg" alt="site protegido" id="site_protegido" class="selo_seguranca"/> 
<img src="gfx/membro_vip/selo_bcash.jpg" alt="site bcash" id="site_protegido" height="39" class="selo_seguranca"/> 
</div>
</center>
</div>
</form>
<!--END FORMULARIO DE PAGAMENTO-->


</body>
</html>