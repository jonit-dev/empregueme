<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado
if (session_id() == '') {
    session_start();
}

check_loggedin();//pra cadastrar CV usuário tem que tá logado


if (isset($_SESSION['nome'])) {

    $data = explode(' ', $_SESSION['nome']);
    $primeiro_nome = $data[0];
} else {//se nao tá logado, deixa em branco msm
    $primeiro_nome = '';
}



//o HEAD dessa página é diferente... cuidado

$display_main->head('
@import url(\'css/botoes.css\');
@import url(\'css/form_style.css\');
', '



<!--CARREGAMENTO DE CLICA MOSTRA BENEFICIOS MEMBRO VIP-->
<script type="text/javascript" src="js/membro_vip.js"></script>


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


<!--SCRIPT PARA GERENCIAR FORM DE PAGAMENTO-->
<script type="text/javascript" src="js/form_pagamento.js"></script>

<!--SCRIPT PARA GERENCIAR CADASTRO DE CV-->
<script type="text/javascript" src="js/cadastro_cv.js"></script>

');
?>
<!--SCRIPT DE CARREGAMENTO DOS SELECTS DOS BANNERS-->
<script type="text/javascript" src="js/select_load.js">
</script>

<script src="js/jquery.price_format.min.js" type="text/javascript"></script>

<!--CÓDIGO PRA SOMENTE PERMITIR SOMENTE NUMEROS NO INPUT-->
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

<!--carrega plugin jquery para manejo do input preço-->
<script type="text/javascript" src="plugins_jquery/numero/autoNumeric.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('.pretensao_salarial').autoNumeric('init');
		
    });//end ready
</script>

<?php



$display_main->topo(true);

//no caso do painel a esquerda, vamos verificar. Se estiver logado, mostra versão original. Se não, vai mostrar o painel do visitante.
//veja scripts internos
$display_main->painel_esquerda();
//Vamos verificar também se o usuário possui o currículo cadastrado


echo '<h1>Editar Currículo</h1>';

//===============>> CARREGAMENTO DOS DADOS ANTERIORES <<=================
if (isset($_GET['id'])) 
{
//primeiro, verifica se é realmente o dono do currículo que está tentando editar esse currículo
if($_GET['id'] != $_SESSION['userid'])
	{
		$display_main->show_system_message('Você não está autorizado a editar o currículo de outras pessoas.','error');
		$display_main->painel_direita();
		$display_main->fundo();
		exit;	
	}
	
if(isset($_GET['id']) && $_SESSION['curriculo'] == 0)
	{
		
	echo 'Você está tentando editar seu currículo, porém ainda não o criou! <a class="vermelho_destaque" href="curriculo.php" target="_self"><strong>Clique aqui para criá-lo</strong></a> agora mesmo e ter todos os seus talentos expostos para centenas de milhares de empresas que nos visitam diariamente';
	$display_main->painel_direita();
		$display_main->fundo();
	exit;
	}
	
	
	//se tem script nos passando parametro por GET ID é porque quer mostrar dados do usuário específico

//primeiro, vamos nos conectar à base de dados para capturar informações
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");


//====== >>>   CARREGA VARIÁVEIS OBRIGATÓRIAS
//carrega cargos da base de dados e salva em opcoes


//verifica cargo principal, secundario e terciário do user
	  $qry = "SELECT formacao.fk_area_formacao_id, oc.cargo_secundario, oc.cargo_terciario FROM formacao, outros_cargos as oc, curriculos as cur 
	  WHERE
	  cur.fk_usu_codigo = ? AND
	  cur.fk_formacao_id = formacao.id AND
	  cur.id = oc.fk_curriculos_id";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$_SESSION['userid']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($cargo_primario,$cargo_secundario,$cargo_terciario);
	
	while($stmt->fetch())
		{
			$cargo_primario = $cargo_primario;
			$cargo_secundario = $cargo_secundario;
			$cargo_terciario = $cargo_terciario;
		}


	$stmt->close();



    $qry = "SELECT af.id, af.descricao FROM area_formacao as af ORDER BY descricao ASC";
	$stmt = $mysqli->prepare($qry);
	$stmt->execute();
	$stmt->bind_result($af_id,$af_descricao);
	
	$cargo_primario_opt = '';
	$cargo_secundario_opt = '';
	$cargo_terciario_opt = '';
	
	while($stmt->fetch())
		{
			
		if($af_id == $cargo_primario)
			{
				$cargo_primario_opt .= '<option value="'.$af_id.'" selected="selected">'.$af_descricao.'</option>';		
			}
			else
				{
					$cargo_primario_opt .= '<option value="'.$af_id.'" >'.$af_descricao.'</option>';	
				}
			
			if($af_id == $cargo_secundario)//deixa o "Nenhum como default"
			{
				$cargo_secundario_opt .= '<option value="'.$af_id.'" selected="selected">'.ucwords($af_descricao).'</option>';			
			}
				else
				{
					$cargo_secundario_opt .= '<option value="'.$af_id.'">'.ucwords($af_descricao).'</option>';	
				}
		
			if($af_id == $cargo_terciario)//deixa o "Nenhum como default"
			{
				$cargo_terciario_opt .= '<option value="'.$af_id.'" selected="selected">'.ucwords($af_descricao).'</option>';			
			}
				else
				{
					$cargo_terciario_opt .= '<option value="'.$af_id.'">'.ucwords($af_descricao).'</option>';	
				}
		
		
		
		}

$stmt->close();




//prepara variável
    @ $user_id = mysqli_secure_query($_GET['id']);

	$qry = "SELECT
		usuario.usu_nome,
		usuario.usu_dt_cad, 
		usuario.usu_sexo,
		usuario.usu_idade,
		usuario.usu_telefone1,
			usuario.usu_telefone2,
				usuario.usu_link_facebook,
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
		curriculos.fk_categoria_codigo
		
		
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
	
    
    formacao.fk_escolaridade_formacao_id = escolaridade_formacao.id LIMIT 2
	";
	$stmt = $mysqli->prepare($qry);
	
	$stmt->bind_param('i',$user_id);//binda id do usuário para consulta
	
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($usu_nome, $usu_dt_cad, $usu_sexo, $usu_idade, $usu_telefone1,$usu_telefone2,$usu_link_facebook, $usu_cidade, $usu_estado, $usu_bairro,$usu_formacao, $usu_pret_salarial, $usu_disp_horario, $usu_ingles, $usu_office, $usu_objetivo,$usu_escolaridade,$usu_email,$usu_ingles_nivel,$usu_office_nivel,$usu_cnh,$usu_disponivel_viagem,$outras_informacoes,$usu_cat_codigo);
	
	$tem_resultado = false;
	while($stmt->fetch())
		{
		$tem_resultado = true;
		
		

		//ajusta variáveis para construção do currículo
		
		//constroi checkbox disponibilidade horário
		
		
		
		//constrói lista de cnh
		
				$lista_cnh = '';				
		
		$cnh_string = 'A/B/C/D';
		$cnh_padrao = explode('/',$cnh_string);
		
		$cnh_usuario = str_split($usu_cnh);
		
		
	$cnh_diff = array_diff($cnh_padrao,$cnh_usuario);
	
	
	for($i=0;$i<count($cnh_diff);$i++)
		{
			
			for($i=0;$i<count($cnh_padrao);$i++)
				{
							
					if(isset($cnh_diff[$i]))
					{
					
					if($cnh_diff[$i] == $cnh_padrao[$i])
						{
							$lista_cnh .= '<input type="checkbox" value="'.$cnh_padrao[$i].'" name="cnh[]"/>CNH '.$cnh_padrao[$i].' &nbsp;&nbsp;';
						}
						else
						{
						$lista_cnh .= '<input type="checkbox" checked="checked" value="'.$cnh_padrao[$i].'" name="cnh[]"/>CNH '.$cnh_padrao[$i].' &nbsp;&nbsp;';	
						}
					}
					else
					{
						$lista_cnh .= '<input type="checkbox"  checked="checked" value="'.$cnh_padrao[$i].'" name="cnh[]"/>CNH '.$cnh_padrao[$i].' &nbsp;&nbsp;';
					}
					
						
				}
			
					
				
		}
	
	//constrói lista disponibilidade de horário
	
	
	
				$lista_disp_horario = '';				
		
		$disp_horario_string = 'Manhã/Tarde/Noite/';
		$disp_horario_padrao = explode('/',$disp_horario_string);
		$usu_disp_horario = rtrim($usu_disp_horario,'/');
		$disp_horario_usuario = explode('/',$usu_disp_horario);
		
		
	$disp_horario_diff = array_diff($disp_horario_padrao,$disp_horario_usuario);
	
	
	for($i=0;$i<count($disp_horario_diff);$i++)
		{
			//<input type="checkbox" checked="checked" id="horario_focus" value="Manhã" name="horario_disp[]">
			for($i=0;$i<count($disp_horario_padrao)-1;$i++)
				{
					if(isset($disp_horario_diff[$i]))
					{
					
					if($disp_horario_diff[$i] == $disp_horario_padrao[$i])
						{
							$lista_disp_horario .= '<input type="checkbox" id="horario_focus" value="'.$disp_horario_padrao[$i].'" name="horario_disp[]"/>'.$disp_horario_padrao[$i].' &nbsp;&nbsp;';
						}
						else
						{
						$lista_disp_horario .= '<input type="checkbox" checked="checked" id="horario_focus" value="'.$disp_horario_padrao[$i].'" name="horario_disp[]"/>'.$disp_horario_padrao[$i].' &nbsp;&nbsp;';	
						}
						
					}
					else
					{
						$lista_disp_horario .= '<input type="checkbox"  checked="checked" id="horario_focus" value="'.$disp_horario_padrao[$i].'" name="horario_disp[]"/> '.$disp_horario_padrao[$i].' &nbsp;&nbsp;';
					}
				}
			
						
				
		}

			
			
		//verifica disponível para viagem
		$lista_disponivel_viagem = '';
	if($usu_disponivel_viagem == 1)
	{
				$lista_disponivel_viagem = '<input type="checkbox" value="1" checked="checked" name="disponivel_viagem"/>Disponível para Viagem';	
	}
	else
	{
				$lista_disponivel_viagem = '<input type="checkbox" value="1"  name="disponivel_viagem"/>Disponível para Viagem';
	}
		
		
		
		//ajusta sexo
		
			
		if($usu_sexo == 'Masculino')//seleciona o do usuário
			{
				$radio_sexo = '<input type="radio"  id="sexo"  name="usu_sexo" value="Masculino" checked="checked"/>Masculino <input type="radio" name="usu_sexo" value="Feminino"/>Feminino<span class="campo_obrigatorio"   >';
			}
			else//se for feminino
			{
					$radio_sexo = '<input type="radio"  id="sexo"  name="usu_sexo" value="Masculino" />Masculino <input type="radio" name="usu_sexo" value="Feminino" checked="checked"/>Feminino<span class="campo_obrigatorio"   >';
			}
			
			//gera idade
			$idade = '';
			for($i=1;$i<=120;$i++)
				{
			if($usu_idade == $i)//se estamos construindo a opção da idade do usuário
						{
							$idade .= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
						}
		$idade .= '<option value="'.$i.'">' . $i. '</option>';	
				}
		
			
		}
		
		

//carrega lista de estados
$stmt->close();
$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
$stmt = $mysqli->prepare($qry);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($r_sigla, $r_cod_est);

$estados = '';

while ($stmt->fetch()) {


if($r_sigla == $usu_estado)//seleciona o valor do usuário
	{
		$estados .= '<option value="' . $r_cod_est . '" selected="selected">' . $r_sigla . '</option>';	
		$cod_estado = $r_cod_est;
	}
	else
		{
			 		$estados .= '<option value="' . $r_cod_est . '" >' . $r_sigla . '</option>';
		}
				
 
		}
		
//carrega lista de cidades
$cidades = '';

$stmt->close();		
$qry = "SELECT cid.nome, cid.cod_cidades FROM cidades as cid WHERE cid.estados_cod_estados = ? ";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$cod_estado);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cid_nome, $cid_cod_cidades);
while($stmt->fetch())
	{
		if($cid_nome == $usu_cidade)
			{
			$cidades .= '<option value="' . $cid_cod_cidades . '" selected="selected" >' . $cid_nome. '</option>';	
			}
			else
			{
		$cidades .= '<option value="' . $cid_cod_cidades . '" >' . $cid_nome. '</option>';
			}
	}
		
		
		
	//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
$stmt->close();

$categorias = '';
$qry = "SELECT cat_codigo, cat_nome FROM categoria";

$stmt = $mysqli->prepare($qry);
$stmt->execute();

$stmt->store_result();
$stmt->bind_result($r_cat_codigo, $cat_nome);

while ($stmt->fetch()) {
	if($usu_cat_codigo == $r_cat_codigo)
		{
			$categorias .= '<option value="' . $r_cat_codigo . '" selected="selected">' . $cat_nome . '</option>';
		}
		else
		{
		    $categorias .= '<option value="' . $r_cat_codigo . '">' . $cat_nome . '</option>';	
		}
}
	
	//gera escolaridade
$stmt->close();
$qry = "SELECT ef.descricao, ef.id FROM escolaridade_formacao as ef";
$stmt = $mysqli->prepare($qry);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($r_ef_descr, $r_ef_id);

$escolaridade = '';
while ($stmt->fetch()) {
	if($usu_escolaridade == $r_ef_descr)
		{
		$escolaridade .= '<option value="' . $r_ef_id. '" selected="selected">' . $r_ef_descr. '</option>';		
		}
		else
		{
			$escolaridade .= '<option value="' . $r_ef_id. '">' . $r_ef_descr. '</option>';
		}
    
}
	
//carrega cursos de formação do usuário
$stmt->close();
$qry = '
SELECT 
cf.curso,
cf.inicio,
cf.termino,
cf.instituicao,
cf.id

FROM cursos_formacao as cf, curriculos as cur, usuario as usu
WHERE
usu.usu_codigo = ? AND
cur.fk_usu_codigo = usu.usu_codigo AND
cf.fk_formacao_id = cur.fk_formacao_id
';	
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cf_curso,$cf_inicio,$cf_termino,$cf_instituicao,$cf_id);


//gera anos


$cursos = '';
$loop_cursos = 1;
$n_resultados = 0;//número de resultados 
$cursos_id = array();
while($stmt->fetch())
	{

		
		
		
		$n_resultados++;//adiciona um resultado.
		//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
					//cria um input hidden para identificar a ID do curso (vamos utilizar isso para atualizar os dados depois)
		$cursos_id[$loop_cursos] = $cf_id;
		$curso_input =  '<input type="hidden" value="'.$cursos_id[$loop_cursos].'" name="id_curso'.$loop_cursos.'"/>';
			$cursos .= '<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="'.$cf_curso.'" name="curso'.$loop_cursos.'">
		Início <select name="curso'.$loop_cursos.'_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="curso'.$loop_cursos.'_termino">
			'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="curso'.$loop_cursos.'_instituicao" value="'.$cf_instituicao.'" placeholder="Instituição" class="form_txt_medio"/>'.$curso_input.'
		</li>';
	$loop_cursos++;
	}
	
	if($n_resultados == 0)//se nao tem resultado..
		{
			//cria os 2 campos vazios
					//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
			$cursos .= '<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="" name="curso1">
		Início <select name="curso1_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="curso1_termino">
			'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="curso1_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
		
		$cursos .= '<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="" name="curso2">
		Início <select name="curso2_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="curso2_termino">
			'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="curso2_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
		}
	
	
	if($n_resultados == 1)//se tem só um curso..
		{
			//cria os 2 campos vazios
					//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $cf_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
			
		$cursos .= '<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="" name="curso2">
		Início <select name="curso2_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="curso2_termino">
			'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="curso2_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//Carrega informações sobre curso de ingles x office
if($usu_ingles == 1)//usuario faz ingles
	{
	$radio_ingles = '<input type="radio" value="1" name="ingles" checked="checked"/>Sim <input type="radio" value = "0" name="ingles" />Não
		<span class="campo_obrigatorio">';	
	}
	else
	{
	$radio_ingles = '<input type="radio" value="1" name="ingles" />Sim <input type="radio" value = "0" name="ingles" checked="checked" />Não
		<span class="campo_obrigatorio">';	
	}
	
	$ingles_nivel = '';
	
if(empty($usu_ingles_nivel))//se nao tiver nada cadastrado
{
		$ingles_nivel .= '<option value="">Selecione uma opção(opcional)</option>';	
		$ingles_nivel .= '<option value="Básico">Básico</option>';	
	$ingles_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$ingles_nivel .= '<option value="Avançado">Avançado</option>';
}
	
if($usu_ingles_nivel == 'Básico')
{
	$ingles_nivel .= '<option value="Básico" selected="selected">Básico</option>';	
	$ingles_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$ingles_nivel .= '<option value="Avançado">Avançado</option>';	
}
if($usu_ingles_nivel == 'Intermediário')
{
	$ingles_nivel .= '<option value="Básico">Básico</option>';	
	$ingles_nivel .= '<option value="Intermediário" selected="selected">Intermediário</option>';	
	$ingles_nivel .= '<option value="Avançado">Avançado</option>';	
}
if($usu_ingles_nivel == 'Avançado')
{
	$ingles_nivel .= '<option value="Básico">Básico</option>';	
	$ingles_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$ingles_nivel .= '<option value="Avançado" selected="selected">Avançado</option>';	
}
	
	
	$office_nivel = '';
	
	
	if($usu_office == 1)//usuario faz office
	{
	$radio_office = '<input type="radio" value="1" name="informatica" checked="checked"/>Sim <input type="radio" value = "0" name="informatica"/>Não';	
	}
	else
	{
	$radio_office = '<input type="radio" value="1" name="informatica"/>Sim <input type="radio" value = "0" name="informatica" checked="checked"/>Não';	
	}
	$office_nivel = '';
	
		if(empty($usu_office_nivel))//se nao tiver nada cadastrado
{
		$office_nivel .= '<option value="">Selecione uma opção(opcional)</option>';	
		$office_nivel .= '<option value="Básico">Básico</option>';	
	$office_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$office_nivel .= '<option value="Avançado">Avançado</option>';
}

	
	
if($usu_office_nivel == 'Básico')
{
	$office_nivel .= '<option value="Básico" selected="selected">Básico</option>';	
	$office_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$office_nivel .= '<option value="Avançado">Avançado</option>';	
}
if($usu_office_nivel == 'Intermediário')
{
	$office_nivel .= '<option value="Básico">Básico</option>';	
	$office_nivel .= '<option value="Intermediário" selected="selected">Intermediário</option>';	
	$office_nivel .= '<option value="Avançado">Avançado</option>';	
}
if($usu_office_nivel == 'Avançado')
{
	$office_nivel .= '<option value="Básico">Básico</option>';	
	$office_nivel .= '<option value="Intermediário">Intermediário</option>';	
	$office_nivel .= '<option value="Avançado" selected="selected">Avançado</option>';	
}
	
	

//carrega outras habilidades
$stmt->close();
$qry = '
SELECT 
oh.habilidade,
oh.inicio,
oh.termino,
oh.instituicao,
oh.id
FROM outras_habilidades as oh, curriculos as cur, usuario as usu
WHERE
usu.usu_codigo = ? AND
cur.fk_usu_codigo = usu.usu_codigo AND
oh.fk_habilidades_id = cur.fk_habilidades_id';	
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($oh_habilidade,$oh_inicio,$oh_termino,$oh_instituicao,$oh_id);

//gera anos

$outras_habilidades = '';
$loop_oh = 1;
$n_resultados = 0;
$oh_array = array();
while($stmt->fetch())
	{
		$n_resultados++;
		//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
			
			
				$oh_array[$loop_oh] = $oh_id;
		$oh_input =  '<input type="hidden" value="'.$oh_array[$loop_oh].'" name="id_oh'.$loop_oh.'"/>';
		
			$outras_habilidades .= '<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de libras" class="form_txt_big" value="'.$oh_habilidade.'" name="habilidade'.$loop_oh.'">
		Início <select name="habilidade'.$loop_oh.'_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="habilidade'.$loop_oh.'_termino">
			<option selected="selected" value="">Ano</option>'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="habilidade'.$loop_oh.'_instituicao" value="'.$oh_instituicao.'" placeholder="Instituição" class="form_txt_medio"/>
		</li>'.$oh_input.'';
	$loop_oh++;
	}	
	
if($n_resultados == 0)
{
		//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
			

			$outras_habilidades .= '<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de libras" class="form_txt_big" value="" name="habilidade1">
		Início <select name="habilidade1_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="habilidade1_termino">
			<option selected="selected" value="">Ano</option>'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="habilidade1_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
		
			$outras_habilidades .= '<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de libras" class="form_txt_big" value="" name="habilidade2">
		Início <select name="habilidade2_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="habilidade2_termino">
			<option selected="selected" value="">Ano</option>'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="habilidade2_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
}
	
	
if($n_resultados == 1)
{
		//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_inicio = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_inicio)
			{
				$ano_inicio.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_inicio.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
	
$ano_termino = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $oh_termino)
			{
				$ano_termino.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_termino.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}	
			

		
			$outras_habilidades .= '<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de libras" class="form_txt_big" value="" name="habilidade2">
		Início <select name="habilidade2_inicio">
			'.$ano_inicio.'
		</select>
		Término: <select name="habilidade2_termino">
			<option selected="selected" value="">Ano</option>'.$ano_termino.'
		</select>
			Instituição: <input type="text" name="habilidade2_instituicao" value="" placeholder="Instituição" class="form_txt_medio"/>
		</li>';
}
	

	
//Carrega histórico profissional

$stmt->close();
$qry = '
SELECT 
hp.empresa,
hp.ano,
hp.periodo_dia,
hp.periodo_duracao,
hp.cargo,
hp.descricao,
hp.id

FROM historicos_profissionais as hp, curriculos as cur, usuario as usu
WHERE
usu.usu_codigo = ? AND
cur.fk_usu_codigo = usu.usu_codigo AND
hp.fk_curriculos_id = cur.id';	
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hp_empresa,$hp_ano,$hp_periodo_dia,$hp_periodo_duracao,$hp_cargo,$hp_descricao,$hp_id);





$historico_profissional = '';
$loop_hp = 1;
$periodo_duracao = '';
$n_resultados = 0;
$hp_array = array();//cria uma nova array para armazenar a id do hp (uso dps para atualizar as variaveis)
while($stmt->fetch())
	{
			
	//gera período
	$periodo = '';
for($i=1;$i<=50;$i++)
	{
		if($hp_periodo_dia == $i)
			{
		$periodo .= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
			$periodo .= '<option value="'.$i.'" >' . $i. '</option>';	
			}
			
	}
		//ano em que trabalhou
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$ano_trabalhou = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $hp_ano)
			{
				$ano_trabalhou.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_trabalhou.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
		
		
		$n_resultados++;
		
switch($hp_periodo_duracao)
	{
		case 'anos':
		$periodo_duracao .= '
		<option value="anos" selected="selected">ano(s)</option>
		<option value="mes">meses</option>
		';
		break;
		case 'mes':
			$periodo_duracao .= '
		<option value="anos" >ano(s)</option>
		<option value="mes" selected="selected">meses</option>
		';
		break;
		
			
	}
	$hp_array[$loop_hp] = $hp_id;
	$hp_input =  '<input type="hidden" value="'.$hp_array[$loop_hp].'" name="id_hp'.$loop_hp.'"/>';
			$historico_profissional .= '	<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa'.$loop_hp.'_nome" value = "'.$hp_empresa.'" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa'.$loop_hp.'_ano">
		'.$ano_trabalhou.'
		</select><br />
		Período de: <select name="empresa'.$loop_hp.'_periodo_valor">
						'.$periodo.'
			</select> <select name="empresa'.$loop_hp.'_periodo_tempo">
		'.$periodo_duracao.'
			</select>
		Seu cargo: <input type="text" name="empresa'.$loop_hp.'_cargo" placeholder="Cargo ocupado" value="'.$hp_cargo.'" class="form_txt_big"/>
		<br />	
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa'.$loop_hp.'_responsabilidades">'.$hp_descricao.'</textarea>
'.$hp_input.'
	
		</li>';
	$loop_hp++;
	}	
		
		
		
	if($n_resultados == 0)
		{
			switch($hp_periodo_duracao)
	{
		case 'anos':
		$periodo_duracao .= '
		<option value="anos" selected="selected">ano(s)</option>
		<option value="mes">meses</option>
		';
		break;
		case 'mes':
			$periodo_duracao .= '
		<option value="anos" >ano(s)</option>
		<option value="mes" selected="selected">meses</option>
		';
		break;
			
		case '':
		$periodo_duracao .= '
		<option value="anos" >ano(s)</option>
		<option value="mes" >meses</option>
		';
		break;
		
			
	}
		
	//gera período
	$periodo = '';
for($i=1;$i<=50;$i++)
	{
		if($hp_periodo_dia == $i)
			{
		$periodo .= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
			$periodo .= '<option value="'.$i.'" >' . $i. '</option>';	
			}
			
	}
$ano_trabalhou = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $hp_ano)
			{
				$ano_trabalhou.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_trabalhou.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
			$historico_profissional .= '	<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa1_nome" value = "" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa1_ano">
		'.$ano_trabalhou.'
		</select><br />
		Período de: <select name="empresa1_periodo_valor">
						'.$periodo.'
			</select> <select name="empresa1_periodo_tempo">
		'.$periodo_duracao.'
			</select>
		Seu cargo: <input type="text" name="empresa1_cargo" placeholder="Cargo ocupado" value="" class="form_txt_big"/>
		<br />	
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa1_responsabilidades"></textarea>

	
		</li>';
		$historico_profissional .= '	<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa2_nome" value = "" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa2_ano">
		'.$ano_trabalhou.'
		</select><br />
		Período de: <select name="empresa2_periodo_valor">
						'.$periodo.'
			</select> <select name="empresa2_periodo_tempo">
		'.$periodo_duracao.'
			</select>
		Seu cargo: <input type="text" name="empresa2_cargo" placeholder="Cargo ocupado" value="" class="form_txt_big"/>
		<br />	
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa2_responsabilidades"></textarea>

	
		</li>';
		}
		
		
		if($n_resultados == 1)
		{
			switch($hp_periodo_duracao)
	{
		case 'anos':
		$periodo_duracao .= '
		<option value="anos" selected="selected">ano(s)</option>
		<option value="mes">meses</option>
		';
		break;
		case 'mes':
			$periodo_duracao .= '
		<option value="anos" >ano(s)</option>
		<option value="mes" selected="selected">meses</option>
		';
		break;
		
		case '':
		$periodo_duracao .= '
		<option value="anos" >ano(s)</option>
		<option value="mes" >meses</option>
		';
		break;
		
			
	}
		
	//gera período
	$periodo = '';
for($i=1;$i<=50;$i++)
	{
		if($hp_periodo_dia == $i)
			{
		$periodo .= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
			$periodo .= '<option value="'.$i.'" >' . $i. '</option>';	
			}
			
	}
	$ano_trabalhou = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		if($i == $hp_ano)
			{
				$ano_trabalhou.= '<option value="'.$i.'" selected="selected">' . $i. '</option>';	
			}
			else
			{
					$ano_trabalhou.= '<option value="'.$i.'">' . $i. '</option>';		
			}

	}
$historico_profissional .= '	<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa2_nome" value = "" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa2_ano">
		'.$ano_trabalhou.'
		</select><br />
		Período de: <select name="empresa2_periodo_valor">
						'.$periodo.'
			</select> <select name="empresa2_periodo_tempo">
		'.$periodo_duracao.'
			</select>
		Seu cargo: <input type="text" name="empresa2_cargo" placeholder="Cargo ocupado" value="" class="form_txt_big"/>
		<br />	
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa2_responsabilidades"></textarea>

	
		</li>';

		}
		
		
		
		
		
		
		
		
		
		

//=================== CONSTRUÇÃO DO FORMULÁRIO ======================


     
$display_main->conteudo('
<form action="editar_curriculo.php"  method="post">


<p>Edite suas informações abaixo e depois clique no botão salvar, ao final da página.</p>

<h3 class="vermelho_destaque">Informações Básicas</h3>

<ul style="list-style:none">
	<li>Nome Completo: <input id="nome" value="'.$usu_nome.'" class="form_txt_big" type="text" name="usu_nome"  placeholder= "Digite seu nome completo"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
	<li>Sexo: '.$radio_sexo.'<span class="campo_obrigatorio"   >* Campo obrigatório</span></li>	
		
		<li>Idade: <select  id="idade" name="usu_idade"   >'.$idade.'</select><span class="campo_obrigatorio">* Campo obrigatório</span></li>	
		
	<li>Estado: <select id="estado" name="estado" id="estado"   >'.$estados.'</select><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	<li>
	 Cidade: <select id="cidade" name="cidade" id="cidade"   >
    	'.$cidades.'
    </select><span class="campo_obrigatorio">  * Campo obrigatório</span></li>
	
	<li>Bairro: <input class="form_txt_big" id="bairro" type="text"  value="'.$usu_bairro.'"  name="usu_bairro" placeholder= "Digite seu bairro"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
	<li>Telefone (1°): <input class="form_txt_big" id="telefone1" type="tel"  value="'.$usu_telefone1.'"   name="usu_telefone1" placeholder= "Digite seu telefone"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
		<li>Telefone (2°): <input class="form_txt_big" type="tel" name="usu_telefone2"  value="'.$usu_telefone2.'" placeholder= "Digite seu telefone"/></li>
		
			<li>Link do perfil no facebook: <input  class="form_txt_giant" value = "'.$usu_link_facebook.'" type="text" name="usu_link_facebook" placeholder= "Exemplo: www.facebook.com/joanadasilva"/></li>
			
</ul>
			
			
<h3 class="vermelho_destaque">Objetivo Profissional</h3>		
<span class="campo_obrigatorio">* Campo obrigatório</span>	
<textarea id="objetivo"    placeholder="Deixe claro o seu objetivo profissional. Cuidado com exageros: antes de enviar seu perfil a um empregador, decida BEM o que você quer fazer e em que área quer atuar. Máximo de 300 caracteres." style="width:400; height:200;" maxlength="300" rows="4" cols="100" name="objetivo" >'.$usu_objetivo.'</textarea>

<h3 class="vermelho_destaque">Cargos</h3>		
		
	<ul style="list-style:none">
	
		<li><strong>Cargo de interesse principal: </strong><select id="area_profissional" name="fk_area_profissional"    style="width:300px;">
			<option value="">Selecione um cargo de interesse principal</option>'.$cargo_primario_opt.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<li><strong>Cargo de interesse secundário: </strong><select name="cargo_secundario">'.$cargo_secundario_opt.'</select></li>
	<li><strong>Cargo de interesse terciário: </strong><select name="cargo_terciario" >'.$cargo_terciario_opt.'</select></li>
	
<br />
		
		<li>Categoria profissional:<select id="categoria_profissional" name="fk_categoria_codigo"    style="width:300px;">
			<option value="">Selecione uma categoria profissional...</option>'.$categorias.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<li>Escolaridade:<select id="escolaridade" name="fk_escolaridade_formacao"    style="width:300px;">
			<option value="">Selecione sua escolaridade...</option>'.$escolaridade.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<h4 class="vermelho_destaque">Cursos Realizados</h4>
		<p>Os campos abaixo são opcionais, preencha digitando qual curso fez, quando começou e terminou e em qual instituição.</p>
		
		<ul style="list-style:none">
	'.$cursos.'
		
	</ul>
		
<h3 class="vermelho_destaque">Habilidades</h3>		
		
	<ul style="list-style:none">
	
		<li>Sabe falar Inglês?:'.$radio_ingles.'* Campo obrigatório</span>
		Nível: <select name="ingles_nivel">
			'.$ingles_nivel.'
		</select>
		
		</li>
		
		
		<li>Conhecimentos em Pacote Office? (informática):'.$radio_office.'
		<span class="campo_obrigatorio">* Campo obrigatório</span>
		Nível: <select name="office_nivel">
'.$office_nivel.'
		</select>
		
		</li>
		
		</ul>
		
		<h5>Outras habilidades</h5>
				
					<ul style="list-style:none">
	
		
		'.$outras_habilidades.'
		
	</ul>
	
	<h5>Opções compatíveis com seu currículo</h5>
				
					<ul style="list-style:none">
	
		<li>
'.$lista_cnh.'
		</li>
		<li>
			'.$lista_disponivel_viagem.'
		</li>
		
		<br />

		<li>
		  <span id="horario_disp_txt">Disponibilidade de horário </span>
		  
		  '.$lista_disp_horario.'	<span class="campo_obrigatorio">* Campo obrigatório</span>
		 
			
		</li>
		
			<li>
			Pretensão Salarial: <input id="pretensao_salarial"  value="'.$usu_pret_salarial.'" class="pretensao_salarial" data-a-sep="." data-a-dec="," data-a-sign="R$ " type="text" name="pretensao_salarial" class="form_txt_medio"/>
		</li>
		
		
		</ul>
	
	
<h3 class="vermelho_destaque">Histórico Profissional (opcional)</h3>		
		
		<p>Informe-nos sobre suas experiências profissionais anteriores!</p>
		
	<ul style="list-style:none; margin-left:20px">
	
	'.$historico_profissional.'
		

	</ul>

<h3 class="vermelho_destaque">Outras Informações(opcional)</h3>		
		
		<p>Escreva abaixo outras informações relevantes sobre seu currículo:</p>
		
	<ul style="list-style:none; margin-left:20px">
		<li>
			<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="outras_informacoes">'.$outras_informacoes.'</textarea>

		</li>
	</ul>

<center>

<input type="submit" value="Salvar" id="registrar" class="botao_cta"/>
</center>

</form>






');
		
		
}//end if get 


//POST

//Recebe dados e valida
if(isset($_POST['usu_nome']))//se recebeu dados por post é porque quer registrar cv
	{
		 require_once('funcoes/top_functions.php');
        require_once('funcoes/db_functions.php');
        require_once('funcoes/email_functions.php');
        require_once('funcoes/url_functions.php');
		require_once('funcoes/array_functions.php');
	

@$nome = mysqli_secure_query($_POST['usu_nome']);
@$sexo = mysqli_secure_query($_POST['usu_sexo']);
@$idade = mysqli_secure_query($_POST['usu_idade']);
@$estado = mysqli_secure_query($_POST['estado']);		
@$cidade = mysqli_secure_query($_POST['cidade']);		
@$bairro = mysqli_secure_query($_POST['usu_bairro']);	
@$telefone1 = mysqli_secure_query($_POST['usu_telefone1']);		
@$telefone2 = mysqli_secure_query($_POST['usu_telefone2']);		
@$link_facebook = mysqli_secure_query($_POST['usu_link_facebook']);			
@$objetivo = mysqli_secure_query($_POST['objetivo']);

@$area_profissional = mysqli_secure_query($_POST['fk_area_profissional']);
@$cargo_secundario = mysqli_secure_query($_POST['cargo_secundario']);
@$cargo_terciario = mysqli_secure_query($_POST['cargo_terciario']);


@$fk_categoria_codigo = mysqli_secure_query($_POST['fk_categoria_codigo']);
@$fk_escolaridade_formacao = mysqli_secure_query($_POST['fk_escolaridade_formacao']);

@$curso1 = mysqli_secure_query($_POST['curso1']);
@$curso1_inicio = mysqli_secure_query($_POST['curso1_inicio']);
@$curso1_termino = mysqli_secure_query($_POST['curso1_termino']);
@$curso1_instituicao = mysqli_secure_query($_POST['curso1_instituicao']);


@$curso2 = mysqli_secure_query($_POST['curso2']);
@$curso2_inicio = mysqli_secure_query($_POST['curso2_inicio']);
@$curso2_termino = mysqli_secure_query($_POST['curso2_termino']);
@$curso2_instituicao = mysqli_secure_query($_POST['curso2_instituicao']);		
	
@$ingles = mysqli_secure_query($_POST['ingles']);	
@$ingles_nivel = mysqli_secure_query($_POST['ingles_nivel']);


@$office = mysqli_secure_query($_POST['informatica']);	
@$office_nivel = mysqli_secure_query($_POST['office_nivel']);


@$habilidade1 = mysqli_secure_query($_POST['habilidade1']);
@$habilidade1_inicio = mysqli_secure_query($_POST['habilidade1_inicio']);
@$habilidade1_termino = mysqli_secure_query($_POST['habilidade1_termino']);
@$habilidade1_instituicao = mysqli_secure_query($_POST['habilidade1_instituicao']);


@$habilidade2 = mysqli_secure_query($_POST['habilidade2']);
@$habilidade2_inicio = mysqli_secure_query($_POST['habilidade2_inicio']);
@$habilidade2_termino = mysqli_secure_query($_POST['habilidade2_termino']);
@$habilidade2_instituicao = mysqli_secure_query($_POST['habilidade2_instituicao']);

@$cnh = $_POST['cnh'];
@$disponivel_viagem = mysqli_secure_query($_POST['disponivel_viagem']);
@$horario_disponivel = $_POST['horario_disp'];
@$pretensao_salarial = mysqli_secure_query($_POST['pretensao_salarial']);
	
@$empresa1_nome = mysqli_secure_query($_POST['empresa1_nome']);
@$empresa1_ano = mysqli_secure_query($_POST['empresa1_ano']);
@$empresa1_periodo_valor = mysqli_secure_query($_POST['empresa1_periodo_valor']);
@$empresa1_periodo_tempo = mysqli_secure_query($_POST['empresa1_periodo_tempo']);	
@$empresa1_cargo = mysqli_secure_query($_POST['empresa1_cargo']);
@$empresa1_responsabilidades = mysqli_secure_query($_POST['empresa1_responsabilidades']);


@$empresa2_nome = mysqli_secure_query($_POST['empresa2_nome']);
@$empresa2_ano = mysqli_secure_query($_POST['empresa2_ano']);
@$empresa2_periodo_valor = mysqli_secure_query($_POST['empresa2_periodo_valor']);
@$empresa2_periodo_tempo = mysqli_secure_query($_POST['empresa2_periodo_tempo']);	
@$empresa2_cargo = mysqli_secure_query($_POST['empresa2_cargo']);
@$empresa2_responsabilidades = mysqli_secure_query($_POST['empresa2_responsabilidades']);

@$outras_informacoes = mysqli_secure_query($_POST['outras_informacoes']);

//variáveis para edição específica de alguns campos
@$id_curso1 = mysqli_secure_query($_POST['id_curso1']);
@$id_curso2 = mysqli_secure_query($_POST['id_curso2']);

@$id_oh1 = mysqli_secure_query($_POST['id_oh1']);
@$id_oh2 = mysqli_secure_query($_POST['id_oh2']);

@$id_hp1 = mysqli_secure_query($_POST['id_hp1']);
@$id_hp2 = mysqli_secure_query($_POST['id_hp2']);

//==> dados obrigatórios
  if (checa_vazio(array($nome, $sexo, $idade, $estado, $cidade, $bairro, $telefone1, $objetivo, $area_profissional, $fk_categoria_codigo,$fk_escolaridade_formacao), array('Nome', 'Sexo', 'Idade', 'Estado', 'Cidade', 'Bairro', 'Telefone (1°)', 'Objetivo profissional', 'Área de formação', 'Categoria profissional', 'Escolaridade'))) {
        $display_main->show_system_message('Não foi possível editar o currículo pois os seguintes campos encontram-se vazios: ' . $resultados_vazios, 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
    }
	
	if(!isset($ingles))
		{
					$display_main->show_system_message('Você esqueceu de preencher se fala ingles ou não. ','error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
		
			if(!isset($office))
		{
			
			
			$display_main->show_system_message('Você esqueceu de preencher se tem conhecimentos no pacote office ou não. ','error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
	
	
	//valida arrays obrigatórias
	if(count($horario_disponivel) == 0)
		{
			 $display_main->show_system_message('Você esqueceu de preencher o horário disponível!', 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
	
		
		//VALIDAÇÃO DE FOTOS!

//--------------- TERMINA VALIDAÇÃO



//-------------------- ATUALIZA DADOS NO SISTEMA


$mysqli = mysqli_full_connection();
mysqli_set_charset($mysqli, "utf8");
$dados_atualizados = '';//var que registra o que foi modificado

//Atualiza algumas informações no perfil ===> CONFERIDO	
		
			
			$qry = "UPDATE usuario SET 
			usu_nome = ?,
			usu_sexo = ?, 
			usu_idade = ?, 
			usu_bairro = ?, 
			usu_telefone1 = ?,
			usu_telefone2 = ?,
			usu_link_facebook = ?,
			cid_codigo = ?
         WHERE usu_codigo = ?";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('ssissssii',$nome,$sexo,$idade,$bairro,$telefone1,$telefone2,$link_facebook,$cidade,$_SESSION['userid']);
	$stmt->execute();	
	$stmt->close();
	$dados_atualizados .= 'info_perfil/';
	

//ajusta algumas variáveis

$cnh_ajustada = '';
//ajusta cnh antes de inserir
for($i=0;$i<count($cnh);$i++)
	{
	$cnh_ajustada .= $cnh[$i];	
	}
	$horario_disponivel_ajustado = '';
//ajusta disp horario antes de inserir
for($i=0;$i<count($horario_disponivel);$i++)
	{
	$horario_disponivel_ajustado .= $horario_disponivel[$i].'/';	
	}

//ajusta pretensao salarial
if (empty($pretensao_salarial) || !isset($pretensao_salarial)) {
        $pretensao_salarial = "0.00"; //deixa como "A combinar" = 0	
    } else {//se tem salário, vamos acertar o número para inserir na base de dados (converte R$ 1500,00 em 1500.00, por ex)
        require_once('funcoes/number_functions.php');
        $pretensao_salarial = concerta_preco($pretensao_salarial); //concerta o salário inserido pelo usuário e transforma-o em double(float)
    }

//Atualiza informações no currículo e captura IDs de outras tabelas

//atualiza algumas variáveis na tabela CURRICULOS
$data_atual = time();
$get_data = getdate($data_atual);

$updated_date = $get_data['year'].'-'.$get_data['mon'].'-'.$get_data['mday'].' '.$get_data['hours'].':'.$get_data['minutes'].':'.$get_data['seconds'];


//Atualiza Currículos ==> CONFERIDO

			$qry = "UPDATE curriculos SET 
			updated = ?,
			objetivo_profissional = ?, 
			outras_informacoes = ?,
			fk_categoria_codigo = ?
         WHERE fk_usu_codigo = ?";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('sssii',$updated_date, $objetivo, $outras_informacoes,$fk_categoria_codigo, $_SESSION['userid']);
	$stmt->execute();	
		$dados_atualizados .= 'curriculos/';
	
	
//capta informações para atualizacao das habilidades, formacao e categoria ==> utilizado para editar outras tabelas
	$stmt->close();
			$qry = "SELECT 
			cur.fk_habilidades_id,
			cur.fk_formacao_id, 
			cur.fk_categoria_codigo,
			cur.id
			FROM curriculos as cur
			WHERE cur.fk_usu_codigo = ?";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$_SESSION['userid']);
	$stmt->execute();
	$stmt->store_result();	
	$stmt->bind_result($habilidade_id,$formacao_id,$categoria_id,$curriculo_id);
		while($stmt->fetch())
			{
			$habilidade_id = $habilidade_id;
			$formacao_id = $formacao_id;
			$categoria_id = $categoria_id;	
			$curriculo_id = $curriculo_id;
			}
		
		$stmt->close();
		
		//Atualiza cargo principal e outros cargos
		
		
			
/*ATUALIZA CARGO SECUNDARIO E TERCIARIO*/

//primeiro verifica se os dados ainda não foram registrados na tabela outros_cargos

	$qry = "SELECT id FROM outros_cargos WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$curriculo_id);
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
	$stmt->bind_param('iii',$curriculo_id,$cargo_secundario,$cargo_terciario);
	$stmt->execute();
			
		}
		
			if($tem_resultado == true)//se já possui dados na table outros_cargos, vamos atualizá-los!
		{
			$qry = "UPDATE outros_cargos SET cargo_secundario = ?, cargo_terciario = ? WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$cargo_secundario,$cargo_terciario,$curriculo_id);
	$stmt->execute();
			
		}
		

		
//registro na tabela habilidades ==> CONFERIDO
/*
id
cnh
disponivel_viagem
disponivel_horario
pretensao_salarial
ingles
ingles_nivel
office
office_nivel
*/

$qry = "UPDATE habilidades SET 
cnh = ?,
disponivel_viagem = ?,
disponivel_horario = ?,
pretensao_salarial = ?, 
ingles = ?, 
ingles_nivel = ?, 
office = ?,
office_nivel = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry) or die('could not prepare query');
	$stmt->bind_param('sisdisisi',$cnh_ajustada,$disponivel_viagem,$horario_disponivel_ajustado,$pretensao_salarial,$ingles,$ingles_nivel,$office,$office_nivel,$habilidade_id) or die('could not bind param');
	$stmt->execute() or die('could not execute');
	$stmt->close();
	$dados_atualizados .= 'habilidades/';
	
	//registro na tabela formação===> CONFERIDO
/*
	id
fk_area_formacao_id
fk_escolaridade_formacao_id
*/

$qry = "UPDATE formacao SET 
fk_area_formacao_id = ?,
fk_escolaridade_formacao_id = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$area_profissional,$fk_escolaridade_formacao,$formacao_id);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'formação/';

//Atualiza cursos ==========>> CONFERIDO
/*	
id
fk_formacao_id
curso
inicio
termino
instituicao*/


	
//CURSO 1
if(!empty($id_curso1))//verifica se tem curso 
{	
		
$qry = "UPDATE cursos_formacao SET 
curso = ?,
inicio = ?,
termino = ?,
instituicao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisi',$curso1,$curso1_inicio,$curso1_termino,$curso1_instituicao,$id_curso1);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'cursos_formacao/';
}
if(empty($id_curso1) && strlen($curso1) > 0)//se nao temos uma ID representante do curso 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{

$qry = "INSERT INTO cursos_formacao VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$formacao_id,$curso1,$curso1_inicio,$curso1_termino,$curso1_instituicao);
	$stmt->execute();
	$dados_atualizados .= 'cursos_formacao/';
	$stmt->close();
}
	
//CURSO2
if(!empty($id_curso2))//verifica se tem curso 
{	
		
$qry = "UPDATE cursos_formacao SET 
curso = ?,
inicio = ?,
termino = ?,
instituicao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisi',$curso2,$curso2_inicio,$curso2_termino,$curso2_instituicao,$id_curso2);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'cursos_formacao/';
}
if(empty($id_curso2) && strlen($curso2) > 0)//se nao temos uma ID representante do curso 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{
	
$qry = "INSERT INTO cursos_formacao VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$formacao_id,$curso2,$curso2_inicio,$curso2_termino,$curso2_instituicao);
	$stmt->execute();
	$dados_atualizados .= 'cursos_formacao/';
	$stmt->close();
}
		
//Atualiza outras habilidades

//OH 1 
if(!empty($id_oh1))//verifica se tem oh1 
{	
		
$qry = "UPDATE outras_habilidades SET 
habilidade = ?,
inicio = ?,
termino = ?,
instituicao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisi',$habilidade1,$habilidade1_inicio,$habilidade1_termino,$habilidade1_instituicao,$id_oh1);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'outras_habilidades/';
}
if(empty($id_oh1) && strlen($habilidade1) > 0)//se nao temos uma ID representante da oh 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{

			$qry = "INSERT INTO outras_habilidades VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$habilidade_id,$habilidade1,$habilidade1_inicio,$habilidade1_termino,$habilidade1_instituicao);
	$stmt->execute();	
	$dados_atualizados .= 'outras_habilidades/';
$stmt->close();
}		

//OH2
if(!empty($id_oh2))//verifica se tem oh1 
{	
		
$qry = "UPDATE outras_habilidades SET 
habilidade = ?,
inicio = ?,
termino = ?,
instituicao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisi',$habilidade2,$habilidade2_inicio,$habilidade2_termino,$habilidade2_instituicao,$id_oh2);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'outras_habilidades/';
}
if(empty($id_oh2) && strlen($habilidade2) > 0)//se nao temos uma ID representante da oh 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{

			$qry = "INSERT INTO outras_habilidades VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$habilidade_id,$habilidade2,$habilidade2_inicio,$habilidade2_termino,$habilidade2_instituicao);
	$stmt->execute();	
	$dados_atualizados .= 'outras_habilidades/';
$stmt->close();
}		
		

//Atualiza histórico profissional



//HP1
if(!empty($id_hp1))//verifica se tem hp1
{	
		
$qry = "UPDATE historicos_profissionais SET 
empresa = ?,
ano = ?,
periodo_dia = ?,
periodo_duracao = ?,
cargo = ?,
descricao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisssi',$empresa1_nome,$empresa1_ano,$empresa1_periodo_valor,$empresa1_periodo_tempo,$empresa1_cargo,$empresa1_responsabilidades,$id_hp1);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'historicos_profissionais/';
}
if(empty($id_hp1) && strlen($empresa1_nome) > 0)//se nao temos uma ID representante da oh 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{

		$qry = "INSERT INTO historicos_profissionais VALUES (null,?,?,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiisss',$curriculo_id,$empresa1_nome,$empresa1_ano,$empresa1_periodo_valor,$empresa1_periodo_tempo,$empresa1_cargo,$empresa1_responsabilidades);
	$stmt->execute();
	$stmt->close();
}		
	

//HP2
if(!empty($id_hp2))//verifica se tem hp1
{	
		
$qry = "UPDATE historicos_profissionais SET 
empresa = ?,
ano = ?,
periodo_dia = ?,
periodo_duracao = ?,
cargo = ?,
descricao = ?
WHERE id = ?
";

   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('siisssi',$empresa2_nome,$empresa2_ano,$empresa2_periodo_valor,$empresa2_periodo_tempo,$empresa2_cargo,$empresa2_responsabilidades,$id_hp2);
	$stmt->execute();
	$stmt->close();
	$dados_atualizados .= 'historicos_profissionais/';
}
if(empty($id_hp2) && strlen($empresa2_nome) > 0)//se nao temos uma ID representante da oh 1 e foi passado uma string por post é porque estamos tentando inserir uma nova informação no banco de dados
{

		$qry = "INSERT INTO historicos_profissionais VALUES (null,?,?,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiisss',$curriculo_id,$empresa2_nome,$empresa2_ano,$empresa2_periodo_valor,$empresa2_periodo_tempo,$empresa2_cargo,$empresa2_responsabilidades);
	$stmt->execute();
	$stmt->close();
}		
	




	
	
	//===========>> FINALIZA COM MENSAGEM DE SUCESSO OU FALHA


if(strlen($dados_atualizados) > 0)
{
//Currículo cadastrado com sucesso
		 $display_main->show_system_message('Currículo editado com sucesso! Você será redirecionado para nossas últimas vagas...', 'sucesso');
        $display_main->painel_direita();
        $display_main->fundo();
		
				
		echo '  <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout(\'document.location.href="main.php"\', 4000)
        });//end ready
    </script>';

        exit;
}
else
{
	//Erro no cadastro do CV
		 $display_main->show_system_message('Erro na edição do currículo. Por favor, tente novamente!', 'error');
		 //dump_network();
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
}

	
		
		
	}






//falta colocar as máscaras 

//VALIDAÇÃO EM JQUERY


//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();
?>


