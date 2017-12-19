<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');
require_once('classes/gerenciador_painel_class.php');
require_once('funcoes/db_functions.php');

if (session_id() == '') {
    session_start();
}




check_plano_recrutador();


$painel_cv = new class_painel_cv;//cria classe de gerenciamento de painel 


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado




$display_main->head('@import url(\'css/painel_gerenciamento_cv.css\');',
'
<!--Painel de Gerenciamento de Currículos-->
<script type="text/javascript" src="js/painel_gerenciamento.js"></script>

');

$display_main->topo(false);


$display_main->painel_esquerda();

echo '<h1>Gerenciar Currículos</h1>

<p>Nessa página você pode ver <b>suas vagas anunciadas</b> e <b>analisar os currículos</b> interessados pelas mesmas.</p>

<h5>Minhas Últimas Vagas Anunciadas</h5>
';

//vamos nos conectar à base de dados para saber quais vagas o usuario anunciou

    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");

	require_once('classes/date_management.php');
	$data_management = new date_management;
	$data_hoje = $data_management->gera_data(time(),'eng');
	
	
	
	$qry = "SELECT 
	v.vag_codigo, 
	v.vag_dt_inicio,
	v.vag_nome
	
	
	FROM vagas as v
	
	WHERE
	
	v.usu_codigo = ? 
	AND
	v.vag_ativo = 1 AND 
	v.vag_dt_termino >= ?

	";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('is',$_SESSION['userid'],$data_hoje);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($vag_codigo,$vag_dt_inicio,$vag_nome);
	
	$tem_resultado = false;
	while($stmt->fetch())
		{
			
	$tem_resultado = true;
			$vag_codigo = $vag_codigo;
			
    $mysqli2 = mysqli_full_connection();
    mysqli_set_charset($mysqli2, "utf8");
				$qry2 = "SELECT count(*) 
	FROM curriculos_vagas as cuv,
	vagas as v
	WHERE 
	v.usu_codigo = ? AND
	v.vag_codigo = cuv.vag_codigo AND
	cuv.vag_codigo = ?
	";
	$stmt2 = $mysqli2->prepare($qry2);
	$stmt2->bind_param('ii',$_SESSION['userid'],$vag_codigo);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($qt_candidatos);
	
	while($stmt2->fetch())
		{
	$qt_candidatos = $qt_candidatos;
		}
	
			//esconde nome de usuário se nao for plano recrutador ativo
	if($_SESSION['plano_recrutador_ativo'] == 0)
		{
		$data = explode(' ',$vag_nome);
		
		$sobrenome = '';
		for($i=1;$i<count($data);$i++)
			{
				$sobrenome .= substr($data[$i],0,1).'. ';
			}
		
		
		$vag_nome = $data[0].' '.strtoupper($sobrenome);	
		}
			
			
			$vag_dt_inicio = $data_management->converte_data($vag_dt_inicio,'eng','pt-br');
			
			
			if($tem_resultado == true)
			{
			$painel_cv->constroi_vaga_compactada($vag_codigo,$vag_dt_inicio,$vag_nome,$qt_candidatos);
				
			}
		
			
		}
		
		
			if($tem_resultado == false)
				{
				echo '<p class="vermelho_destaque">Você ainda não anunciou nenhuma vaga. <a href="cadastra_vaga.php" target="_self"><b>Clique aqui para anunciar</b></a></p>	';
				}

//----------------------- REJEIÇÃO DE CANDIDATO --------------//

if(isset($_GET['rejeita']))
{
$vag_codigo = mysqli_secure_query($_GET['vaga']);
$usu_codigo = mysqli_secure_query($_GET['rejeita']);
	
//carrega opcoes de rejeicao
$stmt->close();
$qry = "SELECT 
fo.codigo,
fo.descricao

FROM feedback_opcoes as fo
WHERE
fo.ativo = 1";	
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($fo_codigo,$fo_descricao);

$feedback_opcoes_positivas = '';
$feedback_opcoes_negativas = '';
while($stmt->fetch())
	{
		if($fo_codigo == 1)//gostei do cv
			{
			$feedback_opcoes_positivas = '<li><input type="radio" name="motivo_rej" value="'.$fo_codigo.'"/>'.$fo_descricao.'<br /></li>';
			}
			else
			{
		$feedback_opcoes_negativas .= '<li><input type="radio" name="motivo_rej" value="'.$fo_codigo.'"/>'.$fo_descricao.'<br /></li>';
			}
	}
	
		//rejeição autorizada
				$feed_dt_cad = $data_management->gera_data(time(),'eng',true);
		
		$display_main->show_banner('Selecione o motivo','		
			<form action="painel_gerencia_cv.php?confirma_rejeicao='.$usu_codigo.'" method="post">
			
			<input type="hidden" name="vaga_codigo" value="'.$vag_codigo.'"/>
						<input type="hidden" name="usu_codigo" value="'.$usu_codigo.'"/>
				<p><b style="color:green;">Opções de Feedback Positivo:</b></p>
				<ul>
					
					'.$feedback_opcoes_positivas.'

				</ul>
				
					<p><b class="vermelho_destaque">Opções de Feedback Negativas:</b></p>
				<ul>
					
					'.$feedback_opcoes_negativas.'

				</ul>
				
				<input type="submit" value="Cadastrar Feedback"/>
			</form>
		
		','small');
		
		


//adiciona feedback

}

if(isset($_GET['confirma_rejeicao']))
	{
@$vag_codigo = mysqli_secure_query($_POST['vaga_codigo']);
@$usu_codigo = mysqli_secure_query($_POST['usu_codigo']);
@$feedback = mysqli_secure_query($_POST['motivo_rej']);	


//verifica se feedback não está vazio!
if(empty($feedback))
	{
	$display_main->show_system_message('Você precisa selecionar alguma opção do feedback para rejeitar o currículo do usuário','error');
	$display_main->painel_direita();
$display_main->fundo();
	exit;	
	}
		
	
$stmt->close();

//verifica se o candidato realmente é um candidato que se candidatou em sua vaga do usuario (e não outro candidato qualquer)
$qry = "SELECT curv.curr_codigo FROM curriculos_vagas as curv, curriculos as cv , usuario as usu, vagas as vag
WHERE
curv.vag_codigo = ? AND
curv.curr_codigo = cv.id AND
cv.fk_usu_codigo = usu.usu_codigo AND 
usu.usu_codigo = ? AND
curv.vag_codigo = vag.vag_codigo AND
vag.usu_codigo = ?
";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('iii',$vag_codigo,$usu_codigo,$_SESSION['userid']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($curr_codigo);

$tem_resultado = false;
while($stmt->fetch())
	{
		$tem_resultado = true;
	}
	
if($tem_resultado == true)
	{	
		//confirma rejeição do candidato
		
		$stmt->close();
		$qry = "SELECT fbk.feed_codigo FROM feedback as fbk WHERE 
		fbk.fk_usu_codigo = ? AND
		fbk.fk_vag_codigo = ?
		";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('ii',$usu_codigo,$vag_codigo);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($feed_codigo);
			$tem_resultado = false;
		while($stmt->fetch())
			{
				$tem_resultado = true;	
			}
			
			if($tem_resultado == true)	
				{
					$display_main->show_system_message('O feedback já foi enviado para o candidato.','error');
						$display_main->painel_direita();
						$display_main->fundo();
					exit;	
				}
		
		//$feed_dt_cad = $data_management->gera_data(time(),'pt-br',true);
		
		//verifica se o feedback já não foi registrado
		$data = getdate(time());
		$feed_dt_cad = $data['year'].'-'.$data['mon'].'-'.$data['mday'].' '.$data['hours'].':'.$data['minutes'].':'.$data['seconds'];
		
		
		$stmt->close();
		$qry = "INSERT INTO feedback VALUES (null, ?, ?, ?, ?, null, 0)";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('iisi',$usu_codigo,$vag_codigo,$feed_dt_cad,$feedback);
		$stmt->execute();
		
		if($stmt->affected_rows > 0)//se realmente inseriu o feedback
			{
				$display_main->show_system_message('Feedback Enviado com Sucesso.','sucesso');
			}
		
		
	}
	else
	{
		$display_main->show_system_message('Você não pode rejeitar esse candidato.','error');	
	}
	}


//--------------------------------------CÓDIGO DE GERENCIAMENTO DE BANNER

if(isset($_GET['banner']))
	{
		
@$id_candidato = mysqli_secure_query($_GET['id']);

	if($_SESSION['plano_recrutador_ativo'] == 1 && $_SESSION['tipo_conta'] == 1)//se for plano recrutador e for empresa, aparece banner para assinar
	{
		echo '
		<script type="text/javascript">
		$(document).ready(function(e) {
    
	var userid = '.$id_candidato.';
	
	$.post(\'ajax/carrega_contato.php\',
	{
	userid:userid	
	},function(data)
	{
	$("#resposta_contato").html(data);
	});
	
	
	
});//end ready
		</script>
		
		';
		
		
		$display_main->show_banner('Contato usuário','<p>Entre em contato com o candidato através dos dados abaixo:</p><div id="resposta_contato"></div>','small');
		
	}

	if($_SESSION['plano_recrutador_ativo'] == 0 && $_SESSION['tipo_conta'] == 1)//se nao for plano recrutador e for empresa, aparece banner para assinar
	{
	$display_main->show_banner('Área Exclusiva para Assinantes','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Economize tempo para contratar funcionários!
		</div>
		
		<div class="descr_assinatura">
		Reconhecemos que o seu tempo é valioso, por isso criamos um sistema de <b>Busca Avançada de Currículos</b> para que você encontre exatamente quem precisa em nossa base de dados atualizada..
			
		</div>
		
		<div class="btm_cta_assinatura">
		<center>
			<a href="plano_recrutador.php" target="_self"  class="botao_cta">Saiba Mais</a>
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas?</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');
	
	}
	

	
	
		
	}


//----------------------- CÓDIGO ADICIONAR AOS FAVORITOS

if(isset($_GET['add_favoritos']))
{
@$add_favoritos = mysqli_secure_query($_GET['add_favoritos']);

//primeiro verifica se o cv já foi add

$fav_data_registro = $data_management->gera_data(time(),'eng',true);

$stmt->close();

$qry = "SELECT fv.fav_id FROM cv_favoritos as fv WHERE fv.fav_cv_favoritado = ? AND fv.fav_quem_favoritou = ?";
$stmt = $mysqli->prepare($qry);	
$stmt->bind_param('ii',$add_favoritos,$_SESSION['userid']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($fav_id);
$tem_resultado = false;
while($stmt->fetch())
	{
		$tem_resultado = true;	
	}
if($tem_resultado == true)
	{
		$display_main->show_system_message('O candidato já foi adicionado aos favoritos.','error');
		exit;	
	}


$qry = "INSERT INTO cv_favoritos VALUES (null,?,?,?)";
$stmt = $mysqli->prepare($qry);	
$stmt->bind_param('iis',$add_favoritos,$_SESSION['userid'],$fav_data_registro);
$stmt->execute();

if($stmt->affected_rows >= 1)
	{
		$display_main->show_system_message('O candidato foi adicionado aos favoritos com sucesso.');	
	}
}



if(isset($mysqli))
{
$mysqli->close();
}
if(isset($mysqli2))
{
$mysqli2->close();
}
$display_main->painel_direita();
$display_main->fundo();
?>


