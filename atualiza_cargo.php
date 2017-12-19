<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/funcoes_estruturais.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
//}

$display_main->head();

$display_main->topo();
$display_main->painel_esquerda();

check_loggedin();

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

//carrega cargos da base de dados e salva em opcoes

  $mysqli = mysqli_full_connection();
	$mysqli->set_charset("utf8");
    $qry = "SELECT af.id, af.descricao FROM area_formacao as af WHERE af.id >=254 ORDER BY descricao ASC";
	$stmt = $mysqli->prepare($qry);
	$stmt->execute();
	$stmt->bind_result($af_id,$af_descricao);
	
	$cargos = '';
	$outros_cargos = '';
	while($stmt->fetch())
		{
			
		if($af_id == 349)
			{
				$cargos .= '<option value="'.$af_id.'" selected="selected">'.$af_descricao.'</option>';		
			}
			else
				{
					$cargos .= '<option value="'.$af_id.'" >'.$af_descricao.'</option>';	
				}
			
			if($af_id == 259)//deixa o "Nenhum como default"
			{
				$outros_cargos .= '<option value="'.$af_id.'" selected="selected">'.ucwords($af_descricao).'</option>';			
			}
				else
				{
					$outros_cargos .= '<option value="'.$af_id.'">'.ucwords($af_descricao).'</option>';	
				}
		
		}

$stmt->close();

$display_main->conteudo('

<h1>Atualize seu cargo de interesse</h1>

<p>Atualizamos nosso sistema de currículos e precisamos que você nos informe seu cargo(s) de interesse no site. <strong>Você poderá selecionar até 3, sendo que 1 deverá ser o principal.</strong></p>

<p>Essa medida é importante para que as <strong>empresas possam encontrá-lo mais facilmente em nossa rede social</strong></p>

<p>Selecione os cargos abaixo que são de seu interesse:</p>

<form action="atualiza_cargo.php" method="post">

<ul>
	<li>Cargo de interesse principal: <select name="cargo_principal">'.$cargos.'</select><span class="campo_obrigatorio">* Campo obrigatório</span></li></li>
	<li>Cargo de interesse secundário: <select name="cargo_secundario">'.$outros_cargos.'</select></li>
	<li>Cargo de interesse terciário: <select name="cargo_terciario" >'.$outros_cargos.'</select></li>
</ul>

<br />
<br />

<center>
<input type="submit" class="botao_cta" value="Atualizar Cargo"/>
</center>


</form>



');

//================== >> ATUALIZACAO DOS CARGOS

if(isset($_POST['cargo_principal']))
{
	$atualizacoes = '';//var registra o que foi atualizado
	//captura variáveis passadas por post
	@$cargo_principal = mysqli_secure_query($_POST['cargo_principal']);
	@$cargo_secundario = mysqli_secure_query($_POST['cargo_secundario']);
	@$cargo_terciario = mysqli_secure_query($_POST['cargo_terciario']);
	
	//realiza validação rápida
		if (empty($cargo_principal)) {
        $display_main->show_system_message('Você esqueceu de preencher seu cargo de principal interesse!', 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
    }
	
		if ($cargo_principal == 259) {//se usuário selecionou "Nenhum" como cargo principal...
        $display_main->show_system_message('Você precisa selecionar algum cargo principal para que as empresas te encontrem.', 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
    }
	
	
	//conecta com base de dados para atualizar dados
		
 $mysqli = mysqli_full_connection();
	$mysqli->set_charset("utf8");
    $qry = "SELECT cur.fk_formacao_id FROM curriculos as cur WHERE cur.fk_usu_codigo = ?";
	$stmt = $mysqli->prepare($qry);	
	$stmt->bind_param('i',$_SESSION['userid']);
	$stmt->execute();
	
	$stmt->bind_result($formacao_id);
	while($stmt->fetch())
		{
			$formacao_id = $formacao_id;	
		}
	$stmt->close();
	
	
	 $qry = "UPDATE formacao SET fk_area_formacao_id = ? WHERE id = ?";
	$stmt = $mysqli->prepare($qry);	
	$stmt->bind_param('ii',$cargo_principal,$formacao_id);
	$stmt->execute();
	
	
	if($stmt->affected_rows > 0 )
		{
			$atualizacoes .= 'Cargo Principal';	
		}
	
	$stmt->close();
	
	//registra cargo secundário e terciário
	
	//primeiro verifica se os dados ainda não foram registrados na tabela outros_cargos
	
	$qry = "SELECT id FROM outros_cargos WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$_SESSION['curriculo']);
	$stmt->execute();
	$stmt->bind_result($id);
	
	$tem_resultado = false;
	while($stmt->fetch())
		{
			$tem_resultado = true;
		}
	
	
	if($tem_resultado == false)//se nao tem os outros cargos registrados, vamos registrar um novo
		{
			$qry = "INSERT INTO outros_cargos VALUES (null,?,?,?)";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$_SESSION['curriculo'],$cargo_secundario,$cargo_terciario);
	$stmt->execute();
			
		}
		
			if($tem_resultado == true)//se já possui dados na table outros_cargos, vamos atualizá-los!
		{
			$qry = "UPDATE outros_cargos SET cargo_secundario = ?, cargo_terciario = ? WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$cargo_secundario,$cargo_terciario,$_SESSION['curriculo']);
	$stmt->execute();
			
		}

		
		if($stmt->affected_rows > 0 )
		{
			$atualizacoes .= 'Cargo Secundário e Terciário';	
		}		
	$stmt->close();
	
	
	
	
	//Mostra mensagem final de atualização
	
	if(strlen($atualizacoes) > 0)//se atualizou algo
		{
			 $display_main->show_system_message('Dados atualizados com sucesso! Redirecionando para página principal', 'sucesso');
			 redireciona('main.php',3000);
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
		}
		else//se nao conseguiu atualizar nada!
		{
			 $display_main->show_system_message('Algum erro ocorreu e os dados não foram atualizados. Tente novamente ou comunique o sac@empreguemeagora.com.br', 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
		}
	
	
	
	}//end isset POST cargo principal



$display_main->painel_direita();
$display_main->fundo();
?>


