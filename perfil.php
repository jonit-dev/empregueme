<?php


//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('classes/date_management.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');

$gerencia_data = new date_management;

$display_main = new display_main; //associa uma variával à classe de carregamento do layout

//verifica se está logado, se nao estiver, manda pro index.
check_loggedin();

//atualiza variáveis de sessão se usuário estiver logado
if (session_id() == '') {
    session_start();
}




$display_main->head('
@import url(\'css/anuncio_interno.css\');
@import url(\'css/botoes.css\');
', '

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

<!--CÓDIGO PARA CARREGARMOS A FUNCAO MOSTRA BANNER-->
<script type="text/javascript" src="js/banner_direto_js.js">
</script>


<!--CÓDIGO PARA MOSTRARMOS O BANNER DO PERFIL DO USUÁRIO, AO CLICARMOS EM CONTATO-->
<script type="text/javascript" src="js/perfil.js">
</script>

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









if (isset($_GET['id'])) 
{
			@ $user_id = mysqli_secure_query($_GET['id']);
				
				$mysqli = mysqli_full_connection();
				mysqli_set_charset($mysqli, "utf8");
	//verifica se o id do visitado não é igual ao id do visitante (evita de registrar como visita as visitas do próprio usuário
	if($_SESSION['userid'] != $user_id)
	{
	
				//se tem script nos passando parametro por GET ID é porque quer mostrar dados do usuário específico
		
			
		
				
				
			//verifica se a visita já foi registrada
			$qry = "SELECT vp.visita_id FROM visitas_perfil as vp WHERE 
			vp.visitante_id = ? AND
			vp.visitado_id = ?";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('ii',$_SESSION['userid'],$user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($r_visita_id);
			$tem_resultado = false;
			while($stmt->fetch())
				{
					$tem_resultado = true;
				}
				
				//gera data para ser utilizada depois
				$data_agora = $gerencia_data->gera_data(time(),'eng',true);
				
				
			if($tem_resultado == true)//se tem visita registrada dessa empresa no perfil desse usuário
				{
				$stmt->close();
				$qry = "UPDATE visitas_perfil SET visita_data = ? WHERE visitante_id = ? AND visitado_id = ?";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('sii',$data_agora,$_SESSION['userid'],$user_id);
				$stmt->execute();
				}
				
			if($tem_resultado == false)//se ainda não tem uma visita registrada, vamos registrar
			{
				$stmt->close();
				$qry = "INSERT INTO visitas_perfil VALUES (null, ?, ?, ?,0)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('iis',$_SESSION['userid'],$user_id,$data_agora);
				$stmt->execute();
			}

	}





//primeiro, vamos nos conectar à base de dados para capturar informações



//====== >>>   CARREGA VARIÁVEIS OBRIGATÓRIAS
if(isset($stmt))
{
$stmt->close();
	
}
//prepara variável


	$qry = "SELECT
		usuario.usu_nome,
		usuario.usu_dt_cad, 
		usuario.usu_sexo,
		usuario.usu_idade,
		usuario.usu_telefone1,
		cidades.nome,
		estados.sigla,
		usuario.usu_bairro,
		area_formacao.descricao,
		habilidades.pretensao_salarial,
		habilidades.disponivel_horario,
		habilidades.ingles,
		habilidades.office,
		curriculos.objetivo_profissional,
        escolaridade_formacao.descricao,
		usuario.usu_login,
		habilidades.ingles_nivel,
		habilidades.office_nivel,
		habilidades.cnh,
		habilidades.disponivel_viagem,
		curriculos.outras_informacoes,
		curriculos.id
		
	FROM usuario,curriculos, cidades, estados, area_formacao, habilidades, formacao,escolaridade_formacao
	
	
	WHERE 

	curriculos.ativo = 1 AND

	curriculos.fk_usu_codigo = ? AND

	usuario.usu_codigo = curriculos.fk_usu_codigo AND

	cidades.cod_cidades = usuario.cid_codigo AND
	cidades.estados_cod_estados = estados.cod_estados AND

	curriculos.fk_habilidades_id = habilidades.id AND

	curriculos.fk_formacao_id = formacao.id AND
	formacao.fk_area_formacao_id = area_formacao.id AND
    
    formacao.fk_escolaridade_formacao_id = escolaridade_formacao.id LIMIT 1
	";
	$stmt = $mysqli->prepare($qry);
	
	$stmt->bind_param('i',$user_id);//binda id do usuário para consulta
	
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($usu_nome, $usu_dt_cad, $usu_sexo, $usu_idade, $usu_telefone1, $usu_cidade, $usu_estado, $usu_bairro,$usu_formacao, $usu_pret_salarial, $usu_disp_horario, $usu_ingles, $usu_office, $usu_objetivo,$usu_escolaridade,$usu_email,$usu_ingles_nivel,$usu_office_nivel,$usu_cnh,$usu_disponivel_viagem,$outras_informacoes,$r_curriculo_id);
	
	$tem_resultado = false;
		
	
	while($stmt->fetch())
	{
		$curriculo_id = $r_curriculo_id;
		$pretensao_salarial = $usu_pret_salarial;
		$tem_resultado = true;
		
		
		//ajusta data de cadastro para exibição correta
	$data = explode('-',$usu_dt_cad);
	$data_ajustada =$data[2]."/".$data[1]."/".$data[0];
	
	//==> AJUSTE DE VARIÁVEIS
	
	//cnh
	if(empty($usu_cnh))
		{
		$usu_cnh = "Não possui CNH";	
		}
	
	if(empty($outras_informacoes))
		{
		$outras_informacoes = "Sem outras informações";	
		}
		
		
		
		
		
		
		
		//----------- CARREGAMENTO DE VARIÁVEIS OPCIONAIS -----------/
		
		
		
		//===> Link do facebook
		
		
		
			
 $mysqli2 = mysqli_full_connection();
  mysqli_set_charset($mysqli2, "utf8");
	
	
		$qry2 = "SELECT usuario.usu_link_facebook FROM usuario WHERE usuario.usu_codigo = ?";
		$stmt2 = $mysqli2->prepare($qry2);
		$stmt2->bind_param('i',$user_id);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($r_usu_link_facebook);
		
		$tem_link_facebook = false;
		while($stmt2->fetch())
			{
					if($_SESSION['plano_recrutador_ativo'] == 0)//se nao tem plano recrutador ativo, nao mostra o link do facebook
				{
					$usu_link_facebook = '';	//nao mostre nada!
				}
					if($_SESSION['plano_recrutador_ativo'] == 1)
				{
				
						$usu_link_facebook = '<strong>Perfil no facebook:</strong> <a href="'.$r_usu_link_facebook.'" target="_new"><img src="gfx/ui/facebook.png" alt="facebook icon"/></a><br />';
						
				}
				
			}
			if(empty($r_usu_link_facebook))//se string estiver vazia
				{
				$usu_link_facebook = '';	//nao mostre nada!
				}
				
		
				

//===> TELEFONE 2 (secundário )
				
 $mysqli3 = mysqli_full_connection();
  mysqli_set_charset($mysqli3, "utf8");
	
	
		$qry3 = "SELECT usuario.usu_telefone2 FROM usuario WHERE usuario.usu_codigo = ?";
		$stmt3 = $mysqli3->prepare($qry3);
		$stmt3->bind_param('i',$user_id);
		$stmt3->execute();
		$stmt3->store_result();
		$stmt3->bind_result($r_usu_telefone2);
		
		$tem_telefone2 = false;
		while($stmt3->fetch())
			{
						$usu_telefone2 ='	<strong>Telefone 2°:</strong>'.$r_usu_telefone2.'<br />';
				
			}
			if(empty($r_usu_telefone2))//se string estiver vazia
				{
				$usu_telefone2 = '';	//nao mostre nada!
				}


//===> CURSO_FORMACAO (secundário )
				
 $mysqli4 = mysqli_full_connection();
  mysqli_set_charset($mysqli4, "utf8");
	
	
		$qry4 = "SELECT 
		cf.curso,
		cf.inicio, 
		cf.termino, 
		cf.instituicao 
		
		
		FROM cursos_formacao as cf, curriculos as cv, usuario as usr, formacao as fr WHERE
		
		cf.fk_formacao_id = fr.id AND
		cv.fk_formacao_id = fr.id AND
        cv.fk_usu_codigo = usr.usu_codigo AND
        cv.ativo = 1 AND
        cv.fk_usu_codigo = ?;		
		";
		
		/*curriculos.id = cursos_formacao.id AND
		curriculos.fk_usu_codigo = usuario.usu_codigo AND
        curriculos.fk_usu_codigo = ?*/
		$stmt4 = $mysqli4->prepare($qry4);
		$stmt4->bind_param('i',$user_id);
		$stmt4->execute();
		$stmt4->store_result();
		$stmt4->bind_result($r_curso_formacao,$r_curso_formacao_inicio,$r_curso_formacao_termino,$r_curso_formacao_instituicao);
		
		$curso_formacao = '';//cria variável para armazenar resultados
		
		
		while($stmt4->fetch())
			{
		//ajusta dados
		if($r_curso_formacao_inicio == 0)
			{
			$r_curso_formacao_inicio = 'Não especificado.';	
			}
			if($r_curso_formacao_termino == 0)
			{
			$r_curso_formacao_termino = 'Não especificado.';	
			}
			if($r_curso_formacao_instituicao == '')
			{
			$r_curso_formacao_instituicao = 'Não especificada.';	
			}
		
				$curso_formacao .= '
				
	<div class="texto_cv">
			  <span class="titulo_cor"><strong>Curso:</strong> '.ucwords($r_curso_formacao).'</span><br />
			   <span class="texto_cv"><strong>Início: </strong>'.$r_curso_formacao_inicio.'</span><br />
			   <span class="texto_cv"><strong>Término:</strong>'.$r_curso_formacao_termino.'</span><br />
			   <span class="texto_cv"><strong> Instituição: </strong>'.$r_curso_formacao_instituicao.'</span><br/>
	</div>
				<br />
				';
								
			}
			if(empty($curso_formacao))//se string estiver vazia
				{
				$curso_formacao = '<div class="texto_cv"><p>Nenhum.</p></div>';	//nao mostre nada!
				}
				
				
				
				
	//===> HISTÓRICO PROFISSIONAL
				
 $mysqli5 = mysqli_full_connection();
  mysqli_set_charset($mysqli5, "utf8");
	
	
		$qry5 = "SELECT 
		historicos_profissionais.empresa, 
		historicos_profissionais.ano, 
		historicos_profissionais.periodo_dia, 
		historicos_profissionais.periodo_duracao,
		 historicos_profissionais.cargo,
		 historicos_profissionais.descricao		
		
		FROM historicos_profissionais, curriculos, usuario 
		
		WHERE
		
        curriculos.fk_usu_codigo = ? AND
        curriculos.ativo = 1 AND
		historicos_profissionais.fk_curriculos_id = curriculos.id AND
		curriculos.fk_usu_codigo = usuario.usu_codigo		
		";
		$stmt5 = $mysqli5->prepare($qry5);
		$stmt5->bind_param('i',$user_id);
		$stmt5->execute();
		$stmt5->store_result();
		$stmt5->bind_result($r_hist_empresa,$r_hist_ano,$r_hist_periodo_dia,$r_hist_empresa_periodo_duracao,$r_hist_empresa_cargo,$r_hist_descricao);
		
		
		$historico_profissional = '';//cria variável para armazenar resultados
		
		
		
		while($stmt5->fetch())
			{
				
				//ajusta periodo duracao
		if($r_hist_periodo_dia == 1 && $r_hist_empresa_periodo_duracao == 'mes')
			{
					$r_hist_empresa_periodo_duracao = "mês";
			}
			
		if($r_hist_periodo_dia >= 1 && $r_hist_empresa_periodo_duracao == 'mes')
			{
					$r_hist_empresa_periodo_duracao = "meses";
			}
			
		if($r_hist_periodo_dia == 1 && $r_hist_empresa_periodo_duracao == 'anos')
			{
					$r_hist_empresa_periodo_duracao = "ano";
			}
			
			if($r_hist_periodo_dia >= 1 && $r_hist_empresa_periodo_duracao == 'anos')
			{
					$r_hist_empresa_periodo_duracao = "anos";
			}
			
			if(empty($r_hist_ano))
			{
			$r_hist_ano = 'Não especificado.';	
			}
			if(empty($r_hist_empresa_cargo))
			{
			$r_hist_empresa_cargo = 'Não especificado.';	
			}
				if(empty($r_hist_descricao))
			{
			$r_hist_descricao = 'Sem descrição.';	
			}
			
					if($r_hist_periodo_dia == 0)
			{
			$r_hist_periodo_dia = 'Não especificado.';	
			}
				
				
				
				$historico_profissional .= '
				
	<div class="texto_cv">
			  <span class="titulo_cor"><strong>Empresa:</strong> '.ucwords($r_hist_empresa).'</span><br />
			  <span class="texto_cv"><strong>Ano: </strong>'.$r_hist_ano.'</span><br />
			   <span class="texto_cv"><strong>Duração:</strong>'.$r_hist_periodo_dia.' '.$r_hist_empresa_periodo_duracao.'</span><br />
			   <span class="texto_cv"><strong>Cargo: </strong>'.$r_hist_empresa_cargo.'</span><br/>
			   <span class="texto_cv"><strong>Descrição: </strong>'.$r_hist_descricao.'</span><br/>
	</div>
				<br />

				';
								
			}
			if(empty($historico_profissional))//se string estiver vazia
				{
				$historico_profissional = '<div class="texto_cv"><p>Nenhum.</p></div>';	//nao mostre nada!
				}


// ===== >> OUTRAS HABILIDADES

				
 $mysqli6 = mysqli_full_connection();
  mysqli_set_charset($mysqli6, "utf8");
	
	
		$qry6 = "SELECT 
		oh.habilidade,
		oh.inicio,
		oh.termino,
		oh.instituicao
		
		FROM outras_habilidades as oh, habilidades as h, curriculos as cur, usuario as usu
		
		WHERE
		
        cur.fk_habilidades_id = oh.fk_habilidades_id AND
        usu.usu_codigo = ? AND
        usu.usu_codigo = cur.fk_usu_codigo AND
        h.id = cur.fk_habilidades_id		
		";
		$stmt6 = $mysqli6->prepare($qry6);
		$stmt6->bind_param('i',$user_id);
		$stmt6->execute();
		$stmt6->store_result();
		$stmt6->bind_result($oh_habilidade,$oh_inicio,$oh_termino,$oh_instituicao);

$outras_habilidades = '';

while($stmt6->fetch())
{
	if($oh_inicio == 0)
			{
			$oh_inicio = 'Não especificado.';	
			}
			
			if($oh_termino == 0)
			{
			$oh_termino = 'Não especificado.';	
			}
			
			if(empty($oh_instituicao))
			{
			$oh_instituicao = 'Não especificada.';	
			}
	
	
	

$outras_habilidades .= '<div class="texto_cv">
	<strong>Habilidade: </strong>'.$oh_habilidade.'<br />
	<strong>Início: </strong>'.$oh_inicio.'<br />
	<strong>Término: </strong>'.$oh_termino.'<br />
	<strong>Instituição: </strong>'.$oh_instituicao.'<br />
	<br />
</div>';
}
if(empty($outras_habilidades))//se string estiver vazia
				{
				$outras_habilidades = '<div class="texto_cv"><p>Nenhuma.</p></div>';	//nao mostre nada!
				}


//Carrega outros cargos


				
 $mysqli7 = mysqli_full_connection();
  mysqli_set_charset($mysqli7, "utf8");
$qry7 = "SELECT af.descricao FROM outros_cargos as oc, area_formacao as af, curriculos as cur WHERE cur.fk_usu_codigo = ? AND cur.id = oc.fk_curriculos_id AND oc.cargo_secundario = af.id";
$stmt7 = $mysqli7->prepare($qry7);
$stmt7->bind_param('i',$user_id);
$stmt7->execute();
$stmt7->store_result();
$stmt7->bind_result($cargo_secundario);

while($stmt7->fetch())
	{
		$cargo_secundario = $cargo_secundario.',';	
	}
	
	

$stmt7->close();


$qry7 = "SELECT af.descricao FROM outros_cargos as oc, area_formacao as af, curriculos as cur WHERE cur.fk_usu_codigo = ? AND cur.id = oc.fk_curriculos_id AND oc.cargo_terciario = af.id";
$stmt7 = $mysqli7->prepare($qry7);
$stmt7->bind_param('i',$user_id);
$stmt7->execute();
$stmt7->store_result();
$stmt7->bind_result($cargo_terciario);

while($stmt7->fetch())
	{
		$cargo_terciario = $cargo_terciario;	
	}
	

$stmt7->close();


//ajusta strings
	if(stristr($cargo_secundario,'Nenhum'))
	{
		$cargo_secundario = '';	
	}
if(stristr($cargo_terciario,'Nenhum'))
	{
		$cargo_terciario = '';	
		//ajusta cargo secundario (,)
		$cargo_secundario = rtrim($cargo_secundario,',');
	}



$outros_cargos = '<span class="titulo_cor"><strong>Outros cargos de interesse: </strong></span> '.$cargo_secundario.' '.$cargo_terciario.' <br />';	

if(empty($cargo_terciario) && empty($cargo_secundario))
	{
		$outros_cargos = '';	//se nao tem nenhum cargo extra de interesse, nem mostra nada!
	}




			















//---------AJUSTES DE VARIÁVEIS

				//ajusta pretensão salarial
				
				if($pretensao_salarial == 0 || $pretensao_salarial == 0.00)
					{
						$usu_pret_salarial = "À combinar";
					}
				
				

//carregamento da foto do usuário
$usu_foto = '';

//como o usuário pode inserir foto em .jpg ou em .jpeg, vamos procurar o arquivo nas diferentes extensões. No que achar ele salva em uma var para usar depois

$extensoes = array('.png','.jpeg','.jpg');
//$local_foto = "upload/gfx/perfil/usu_".$usu_codigo;
$local_foto = "../upload/gfx/perfil/usu_".$user_id;

$local_foto_real = '';
for($i=0;$i<count($extensoes);$i++)
	{

		
		if(file_exists($local_foto.$extensoes[$i]))
			{
			$local_foto_real = $local_foto.$extensoes[$i];	
			}
		
	}
	
	if(file_exists($local_foto_real))
		{
			//se existe a imagem da foto do usuário, vamos acrescentála
		$usu_foto = '<img src="'.$local_foto_real.'" width="150" height="150"/>';
		}
	else//se nao tiver foto pro usuário, mostre a foto padrão
		{
			$usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" width="150" height="150"/>';
		}
	
	
	
	//ajusta nível do inglês
	$ingles = "Não";
	if($usu_ingles == 1)//se fala inglês
		{
			$ingles = "Inglês $usu_ingles_nivel";
		}
	
		//ajusta nível do office
	$office = "Não";
	if($usu_office == 1)//se fala inglês
		{
			$office = "Office $usu_office_nivel";
		}
		
		//verifica disponibilidade de viagem
		if($usu_disponivel_viagem == 1)
			{
				$usu_disponivel_viagem = "Disponível para viagem";	
			}
			else
			{
				$usu_disponivel_viagem = "Não";	
			}	
			
			
//ajusta disponibilidade de horário

$disp_horario = str_ireplace('/',',',$usu_disp_horario);
$disp_horario = rtrim($disp_horario,',');			
			
//ajusta CNH
$usu_cnh = str_replace('/',',',$usu_cnh);
$usu_cnh = rtrim($usu_cnh,',');			
			
			
//ajusta botao de contato
$botao_contato = '';
$tamanho_caixa_contato = '280';//valor padrão para o tamanho da caixa de contato (o tamanho ajusta conforme o tipo de usuário que está visualizando o perfil... serve para, por exemplo, nao ficar um espaço em branco gigantesco onde teria o botão de contato (na pagina de usuario nao aparece, só empresa)
if(isset($_SESSION['tipo_conta']))
	{
		if($_SESSION['tipo_conta'] == 1)
			{
			$botao_contato = '<a href="perfil.php?id='.$user_id.'&banner=contato" target="_self">
			  <div style="margin-left:-2px;">
			  <input type="button" class="botao_grande" value="Entrar em Contato" id="btm_contato_candidato">
			  </div>
			  </a>';	
			
			}
		if($_SESSION['tipo_conta'] == 0)
			{
			  $tamanho_caixa_contato = '230';	
			}
			
			
			
			
	}
			
//CARREGA CODIGO DO FACEBOOK

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


        require_once('funcoes/url_functions.php');
        $page_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $sistema_viral = '<div id="like_box">

<div class="fb-comments" data-href="' . $page_url . '/vaga.php?id=' . $user_id . '" data-numposts="10" data-colorscheme="light"></div>
<br />
<br />

<div class="fb-like" data-href="' . $page_url . '/perfil.php?id=' . $user_id . '" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>

</div>';

//AJUSTA FAVORITOS

$link_favoritos = '';

if(isset($_SESSION['plano_recrutador_ativo']) && $_SESSION['plano_recrutador_ativo'] == 1 && $_SESSION['tipo_conta'] == 1)//se está logado como empresa e com plano recrutador ativo
	{
		$link_favoritos = 'perfil.php?add_favoritos='.$user_id.'&id='.$user_id;//se é plano recrutador ativo, pode adicionar aos favoritos
		$link_imprimir = 'perfil.php?imprimir=true&id='.$user_id;
	}
	else
	{
	$link_favoritos = 'perfil.php?id='.$user_id.'&banner=favoritos';
	$link_imprimir = 'perfil.php?id='.$user_id.'&banner=imprimir';
	}

		
	
	
//============== CRIA HTML

//esconde nome de usuário se nao for plano recrutador ativo
	if($_SESSION['plano_recrutador_ativo'] == 0)
		{
		$data = explode(' ',$usu_nome);
		
		$sobrenome = '';
		for($i=1;$i<count($data);$i++)
			{
				$sobrenome .= substr($data[$i],0,1).'. ';
			}
		
		
		$usu_nome = $data[0].' '.strtoupper($sobrenome);	
		}
	
	//acrescenta dados de contato
	$dados_contato = '';
	if(isset($_SESSION['plano_recrutador_ativo']))
	{
	if($_SESSION['plano_recrutador_ativo'] == 1 && $_SESSION['tipo_conta'] == 1)
		{
		$mysqli = mysqli_full_connection();
		$qry = "SELECT usu_login, usu_telefone1, usu_telefone2
			FROM usuario as usu
			WHERE
			usu.usu_codigo = ?";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($r_usu_login,$r_usu_t1,$r_usu_t2);
		while($stmt->fetch())
			{
					$dados_contato = '<strong>E-mail: </strong>'.$r_usu_login.'<br />
<strong>Telefone Principal: </strong>'.$r_usu_t1.'<br />
<strong>Telefone Secundário: </strong>'.$r_usu_t2.'<br />';	
			}
			
			
		
					
				

		}
		else
		{
		$dados_contato = '';	
		}
	
	}
	
	
 
        $display_main->conteudo('
<div class="anuncio_nome">' . ucwords($usu_nome) . '</div>
	<div id="anuncio_cat"><a href="main.php" target="_self">Principal</a> > Currículum Vitae</div>

<div class="anuncio_info">

<h2 class="titulo_cor">Dados pessoais</h2>

<div class="texto_cv">
<strong>Nome Completo:</strong> '.ucwords($usu_nome).'<br/>
<strong>Idade:</strong> '.$usu_idade.' anos<br />
  <strong>Escolaridade:</strong> ' . ucwords($usu_escolaridade). '<br />
<strong>Data de cadastro no site:</strong> ' . $data_ajustada . '<br/>
<strong>Sexo:</strong> '.$usu_sexo.'<br />
<strong>Localização:</strong> ' . $usu_estado . ', ' . $usu_cidade. '<br />
<strong>Bairro:</strong> '.ucwords($usu_bairro).'<br />
'.$usu_link_facebook.'
'.$dados_contato.'


</div>



<h2 class="titulo_cor">Dados profissionais</h2>

<div class="texto_cv">
<h3>Objetivo Profissional</h3>

<div class="texto_cv">
<p>'.$usu_objetivo.' </p>
</div>
</div>

<div class="texto_cv">
<h3>Cargos de Interesse</h3>

<div class="texto_cv">
  
  <span class="titulo_cor"><strong>Cargo de Principal interesse: </strong> '.$usu_formacao.' </span><br />
  <strong>Pretensão salarial:</strong> ' . $usu_pret_salarial . '<br />
  
  <br />
  '.$outros_cargos.'		
</div>
</div>

<div class="texto_cv">
<h3>Cursos Realizados</h3>
'.$curso_formacao.'
</div>

<div class="texto_cv">
<h3>Históricos Profissionais</h3>
'.$historico_profissional.'

</div>


<h2 class="titulo_cor">Habilidades</h2>

<div class="texto_cv">
<h3>Habilidades gerais</h3>
<div class="texto_cv">
	<strong>CNH: </strong>'.$usu_cnh.'<br />
	<strong>Disponibilidade para viagem: </strong>'.$usu_disponivel_viagem.'<br />
	<strong>Disponibilidade de horário: </strong>'.$disp_horario.'<br />
	
	<strong>Inglês: </strong>'.$ingles.'<br />
	<strong>Pacote Office (Word, Excel):</strong> '.$office.'</strong><br />

</div>
</div>

<div class="texto_cv">
<h3>Outras Habilidades</h3>
'.$outras_habilidades.'
</div>


<div class="texto_cv">
<h3>Outras Informações</h3>
<div class="texto_cv">
'.$outras_informacoes.'
</div>
</div>

    <div id="informacoes_candidato" style="height:'.$tamanho_caixa_contato.'px;">
    <div id="anuncio_vendedor_titulo">Informações de contato</div>
    <div id="anuncio_vendedor_info">
<br />

    	<div style="margin-left:30px;">'.$usu_foto.'</div>
		<br />

   	
	'.$botao_contato.'
				
    
	
		</div>
</div>



<div id="anuncio_opcoes_recrutador">

  <div class="anuncio_titulo">Opções do Recrutador</div>
  
  
  <div class="anuncio_conteudo">
  	<span class="vermelho_destaque"><a href="'.$link_favoritos.'">- Adicionar aos favoritos</span></a><br />
  	<span class="vermelho_destaque"><a href="'.$link_imprimir.'" target="_self">- Imprimir Currículo</span></a><br />

  </div>

</div>

<a href="'.$link_imprimir.'" target="_self">
<div id="impressora">

</div>
</a>


<div id="favorito_item">
<a href="'.$link_favoritos.'">
	<img src="gfx/ui/favoritos.png" alt="adicionar aos favoritos" class="img_favoritos"/><span class="txt_favoritos">Adicionar aos favoritos</span>
</a>
	</div>
	
<h2 class="titulo_cor">Depoimentos</h2>
'.$sistema_viral.'
</div>

');
		
		
		
	}
	




    if ($tem_resultado == false) {
//se por algum motivo nao achar o produto, mostra pagina de error e encerra carregamento de dados
 $display_main->conteudo('
	<h2>Crie seu currículo!</h2>
	<p>Você está tentando visualizar seu currículo, porém ainda não o criou! <span style="text-decoration:underline;" class="vermelho_destaque"><a href="curriculo.php">Clique aqui</a> para criá-lo agora mesmo</span> e ter todos os seus talentos expostos para centenas de milhares de empresas que nos visitam diariamente</p>
	
	');
	
	
	
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




//----------------------- CÓDIGO ADICIONAR AOS FAVORITOS

if(isset($_GET['add_favoritos']))
{
if($_SESSION['plano_recrutador_ativo'] != 1)//nao faz nada se nao tem o plano recrutador ativo!
	{
	
	exit;	
	}
	
	
require_once('classes/date_management.php');
$data_management = new date_management;	
	
	
@$add_favoritos = mysqli_secure_query($_GET['add_favoritos']);

//primeiro verifica se o cv já foi add

$fav_data_registro = $data_management->gera_data(time(),'eng',true);

$mysqli = mysqli_full_connection();
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
			$display_main->noty('O candidato já foi adicionado aos favoritos.','error','topCenter',6000);
			exit;
			
	
	}


$qry = "INSERT INTO cv_favoritos VALUES (null,?,?,?)";
$stmt = $mysqli->prepare($qry);	
$stmt->bind_param('iis',$add_favoritos,$_SESSION['userid'],$fav_data_registro);
$stmt->execute();
if($stmt->affected_rows >= 1)
	{
		$display_main->noty('Candidato adicionado aos favoritos com sucesso.','success','topCenter',6000);
		exit;

	}
}

//------------------------------------ CÓDIGO GERENCIMENTO BANNER IMPRIMIR

if(isset($_GET['imprimir']))
	{
		if($_SESSION['plano_recrutador_ativo'] == 1)
		{
		echo "
<script type=\"text/javascript\">
$(document).ready(function(e) {
    
			window.print(); return false;

	
	
});//end ready// JavaScript Document
</script>
";	
		
	}
	}


//--------------------------------------CÓDIGO DE GERENCIAMENTO DE BANNER DE CONTATO

if(isset($_GET['banner']))
	{
		
@$id_candidato = mysqli_secure_query($_GET['id']);


switch($_GET['banner'])
{
	
		case 'contato':
			if($_SESSION['plano_recrutador_ativo'] == 1 && $_SESSION['tipo_conta'] == 1)//se for plano recrutador e for empresa, aparece banner com dados do contato
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

	if($_SESSION['plano_recrutador_ativo'] == 0 && $_SESSION['tipo_conta'] == 1)//se nao for plano recrutador e for empresa...
	{
		
		//primeiro, vê se empresa ainda não gastou todos os créditos semanais
		if(isset($stmt))
			{
			$stmt->close();	
			}
			$mysqli = mysqli_full_connection();
			$qry = "SELECT creditos FROM creditos_contato_empresa WHERE empresa_id = ?";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('i',$_SESSION['userid']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($creditos);
			$tem_resultado = false;
			while($stmt->fetch())
				{
					$tem_resultado = true;
					$creditos = $creditos;	
					if($creditos > 0)//se ainda tem algum crédito da semana
						{
							
		//pergunta se empresa realmente quer queimar o crédito dela nesse candidato
		echo '<input type="hidden" value="'.$id_candidato.'" name="id_candidato"/>';
			echo '<input type="hidden" value="'.$_SESSION['userid'].'" name="id_empresa"/>';
		echo '<script type="text/javascript" src="js/creditos_contato.js"></script>';
						}
						
						if($creditos == 0)//se Não te mais créditos de contato... pede para assinar!!
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
				if($tem_resultado == false)//se nao tem resultado é porque nem tem crédito registrado...
					{
						//registra novos créditos (3)
					$mysqli2 = mysqli_full_connection();
			$qry2 = "INSERT INTO creditos_contato_empresa VALUES (null, ?, 5);";
			$stmt2 = $mysqli->prepare($qry2);
			$stmt2->bind_param('i',$_SESSION['userid']);
			$stmt2->execute();
			$stmt2->close();
						//e pergunta...
						
		//pergunta se empresa realmente quer queimar o crédito dela nesse candidato
		echo '<input type="hidden" value="'.$id_candidato.'" name="id_candidato"/>';
			echo '<input type="hidden" value="'.$_SESSION['userid'].'" name="id_empresa"/>';
		echo '<script type="text/javascript" src="js/creditos_contato.js"></script>';
					}
					
		
		
		
		//verifica quantos contatos o usuário já fez na semana
		
		
		
		
		
		
		
	
	
	}

	break;
	case 'favoritos':
	
	$display_main->show_banner('Área Exclusiva para Assinantes','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Adicione talentos à lista de favoritos!
		</div>
		
		<div class="descr_assinatura">
		Encontrou alguém perfeito para sua empresa mas não pode contratar no momento? Com a ajuda de nossa <b>Lista de Favoritos</b> você poderá salvar seus currículos prediletos e depois utilizá-los conforme sua necessidade!			
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
	
	
	
	break;	
	
	case 'imprimir':
		$display_main->show_banner('Área Exclusiva para Assinantes','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			Imprima currículos e tenha praticidade!
		</div>
		
		<div class="descr_assinatura">
		Quer ganhar tempo e imprimir apenas os currículos interessantes para sua empresa? Assine o Plano Recrutador Empregue-me e adquira maior praticidade e comodidade durante seu processo de seleção de candidatos!			
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
	break;
}

	}







//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
    $display_main->painel_direita();
    $display_main->fundo();
}//end GET['id']
else {//SE NAO ENCONTROU O CURRÍCULO NA BASE DE DADOS, VAMOS FALAR PARA O USUÁRIO CRIÁ-LO
	
	$display_main->conteudo('
	<h2>Crie seu currículo!</h2>
	<p>Você está tentando visualizar seu currículo, porém ainda não o criou! <a href="curriculo.php">Clique aqui</a> para criá-lo agora mesmo e ter todos os seus talentos expostos para centenas de milhares de empresas que nos visitam diariamente</p>
	
	');
	
	
	
    $display_main->painel_direita();
    $display_main->fundo();
    exit;
}

//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();

//FECHA TODAS AS CONEXÕES
$mysqli->close();
$mysqli2->close();
$mysqli3->close();
$mysqli4->close();
$mysqli5->close();
$mysqli6->close();




?>



