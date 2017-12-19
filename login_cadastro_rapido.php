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

if(isset($_GET['vaga_id']))
{

@$vaga_id = mysqli_secure_query($_GET['vaga_id']);
   $page_url = "vaga.php?id=".$vaga_id;
   
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
   
   
$display_main->conteudo('<h1>Faça Login ou Cadastre sua Conta</h1>

<p>Para ter acesso às vagas de nosso site você precisa efetuar login (se já for membro registrado) ou cadastrar uma nova conta.</p>

	<h2 class="vermelho_destaque">Novo por aqui? Crie sua Conta</h2>
	
	
	<form action="new_user.php?loadafter='.$vaga_id.'"  method="post">

<ul style="list-style:none">
	<li>Nome completo:<input type="text" name="name" maxlength="30"  placeholder="Seu nome completo" /></li>
    
<li>Apelido:<input type="text" name="nickname" maxlength="8"  placeholder="Seu apelido (8 letras)" /></li>
   	
 <li>E-mail:<input type="email" name="login" maxlength="30"  placeholder="Seu e-mail" /></li>

<li>Repita seu e-mail:<input type="email" autocomplete="off" name="login2" maxlength="30"  placeholder="Insira seu e-mail novamente" /></li>

 <li>Senha:<input type="password" name="password"  placeholder="Sua nova senha" /></li>

<li>Repita sua senha:<input type="password" name="password2"   placeholder="Insira sua nova senha novamente"  /></li>
  <li><select name="estado" id="estado" class="input_create_account"><option name="">Selecione seu estado...</option>' . $estados . '</select></li>
    <li><select name="cidade" id="cidade" class="input_create_account" ><option value="">Selecione o estado primeiro...</option></select></li>
    <li style="margin-left:30px">
		<span class="txt_radio">Sou Pessoa Física:</span>
		<input type="radio" name="tipo_conta" checked="checked"  value="pf" />
		<span class="txt_radio">Sou Empresa:</span>
		<input type="radio" name="tipo_conta" class="txt_radio"  value="e"/>
	</li>   
	<li>
			<span class="fonte_pequena"><input type="checkbox" value="1" checked="checked" name="receber_vagas"/>Gostaria de Receber Vagas Gratuitas em meu E-mail</span>
	
	
	</li>       
       </br>
       <input type="submit" value="Criar nova conta" style="margin-left:60px" id="btm_nova_conta" class="input_btm_nova_conta"/>
       <br />
    </ul>
 
    
</form>




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
           	<input type="submit" style="margin-left:70px;"value="Entrar"/>
					
	
	</form>

	');
		
}
else
{
$display_main->show_system_message('Vaga não encontrada','error');	
}
			

//SCRIPT GERENCIADOR DE ERROS -> NOVA CONTA
require_once('funcoes/error_functions.php');
gerencia_erros_nova_conta();
//CRIOU CONTA COM SUCESSo			
			
$display_main->painel_direita();
$display_main->fundo();
?>


