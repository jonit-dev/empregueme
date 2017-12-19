<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/top_functions.php');



$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();

//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd

//}
?>

<?php


$display_main->head('','');

$display_main->topo();
$display_main->painel_esquerda();

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
   
   
$display_main->conteudo('<h1 class="vermelho_destaque">Cadastre-se Grátis e Acesse Currículos</h1>

<p>Para poder postar vagas e acessar currículos em nossa rede social é necessário que você crie sua conta.</p>


	
	
	<form action="new_user.php"  method="post">

<ul style="list-style:none">
	<li>Nome completo:<input type="text" name="name" maxlength="30"  placeholder="Seu nome completo" /></li>
    
<li>Apelido:<input type="text" name="nickname" maxlength="8"  placeholder="Seu apelido (8 letras)" /></li>
   	
 <li>E-mail:<input type="email" name="email" maxlength="30"  placeholder="Seu e-mail" /></li>

<li>Repita seu e-mail:<input type="email" autocomplete="off" name="email2" maxlength="30"  placeholder="Insira seu e-mail novamente" /></li>

 <li>Senha:<input type="password" name="password"  placeholder="Sua nova senha" /></li>

<li>Repita sua senha:<input type="password" name="password2"   placeholder="Insira sua nova senha novamente"  /></li>
  <li>Estado:<select name="estado" id="estado" class="input_create_account"><option name="">Selecione seu estado...</option>' . $estados . '</select></li>
    <li>Cidade:<select name="cidade" id="cidade" class="input_create_account" ><option value="">Selecione o estado primeiro...</option></select></li>

		<input type="hidden" name="tipo_conta" value="e"/>  
		
		        <li>
			<span class="fonte_pequena"><input type="checkbox" value="1" checked="checked" name="receber_vagas"/>Gostaria de Receber Dicas Sobre Recrutamento por E-mail</span>
	
	
	</li>    
       </br>
       <input type="submit" class="botao_cta" value="Criar nova conta" style="margin-left:60px" id="btm_nova_conta" class="input_btm_nova_conta"/>
       <br />
    </ul>
 
    
</form>



	');
		
if(isset($_GET['conta_criada']))
	{
	//se user criou a conta
	redireciona('index_empresa.php?conta_criada=true');
	
		
	}
		
		
//SCRIPT GERENCIADOR DE ERROS -> NOVA CONTA
require_once('funcoes/error_functions.php');
gerencia_erros_nova_conta();
//se nao mostrar o erro, mostra banner de curtir facebook
//mostra banner curtir facebook
//somente se ainda nao curtiu
//CRIOU CONTA COM SUCESSo
		
			
$display_main->painel_direita();
$display_main->fundo();
?>


