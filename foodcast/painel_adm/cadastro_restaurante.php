<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FoodCast :: Cadastro de Restaurantes</title>

<style type="text/css">
	.obrigatorio
		{
			color:red;
			font-weight:bold;
			font-size:.7em;
		}	
		
		.error
		{
			color:#900;
			font-weight:bold;
			font-size:1em;
		}	
		
		.sucesso
		{
			color:#0C3;
			font-weight:bold;
			font-size:1em;
		}	
		h2,h3
			{
				color:#900;	
			}
		
</style>
<link rel="stylesheet" href="../jquery_plugins/time_picker/jquery.timepicker.css" />

<!--INICIA PLUGIN JQUERY-->
<script type="text/javascript" src="../jquery_plugins/jquery-1.11.1.min.js"></script>

<!--GERENCIA MASK MONEY-->
<script type="text/javascript" src="../jquery_plugins/jquery.maskMoney.js"></script>


<!--GERENCIA PLUGIN MÁSCARAS DO INPUT-->
<script type="text/javascript" src="../jquery_plugins/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="../jquery_plugins/gerencia_mascaras.js"></script>


<!--GERENCIA PLUGIN TIME PICKER-->
<script type='text/javascript' src="../jquery_plugins/time_picker/jquery.timepicker.js"></script>
<script type="text/javascript" src="../jquery_plugins/gerencia_horario.js"></script>

</head>

<body>
<?php
require_once('../funcoes/db_functions.php');




//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");


//---------------------- CARREGAMENTO DE DADOS DO FORMULÁRIO ------------------------------//

//carrega categorias culinárias
$qry = "SELECT tc.culinaria_id, tc.culinaria_nome FROM tipo_culinaria as tc";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($c_id,$c_nome);
$html_tc = "";
while($stmt->fetch())
	{
		$html_tc .= '<option value="'.$c_id.'">'.$c_nome.'</option>';
		
	}
	
	$stmt->close();
	//carrega cartoes aceitos
$qry = "SELECT tc.car_id, tc.car_nome FROM tipos_cartoes as tc";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($car_id,$car_nome);
$html_cartoes_aceitos = "";
while($stmt->fetch())
	{
		$html_cartoes_aceitos .= '<option value="'.$car_id.'">'.$car_nome.'</option>';
		
	}
	
	//carrega tipos de refeições
	$stmt->close();
	//carrega cartoes aceitos
$qry = "SELECT tr.tr_id, tr.tr_nome FROM tipos_refeicoes as tr";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($tr_id,$tr_nome);
$html_tipos_refeicoes = "";
while($stmt->fetch())
	{
		$html_tipos_refeicoes .= '<option value="'.$tr_id.'">'.$tr_nome.'</option>';
		
	}
	

?>




<h1>Painel Administrativo - FoodCast</h1>

<?php


//-------------------------- CADASTRO DE NOVO RESTAURANTE ------------------------------//

//pega variaveis passadas por post

if(!empty($_POST))
	{
$rst_nome = mysqli_secure_query($_POST['rst_nome']);
$rst_categoria = mysqli_secure_query($_POST['rst_categoria']);
$rst_descricao = mysqli_secure_query($_POST['rst_descricao']);
$rst_preco_min = mysqli_secure_query($_POST['rst_preco_min']);
$rst_preco_max = mysqli_secure_query($_POST['rst_preco_max']);
$rst_cidade_id = mysqli_secure_query($_POST['rst_cidade_id']);
$rst_latitude = mysqli_secure_query($_POST['rst_latitude']);
$rst_longitude = mysqli_secure_query($_POST['rst_longitude']);
$rst_cep = mysqli_secure_query($_POST['rst_cep']);
$rst_endereco = mysqli_secure_query($_POST['rst_endereco']);
$rst_telefone = mysqli_secure_query($_POST['rst_telefone']);
$rst_site = mysqli_secure_query($_POST['rst_site']);
$rst_facebook = mysqli_secure_query($_POST['rst_facebook']);
$rst_aceita_reserva = mysqli_secure_query($_POST['rst_aceita_reserva']);
$rst_aceita_cartao = mysqli_secure_query($_POST['rst_aceita_cartao']);

$rst_tem_wifi = mysqli_secure_query($_POST['rst_tem_wifi']);
$rst_tem_mesa_ar_livre = mysqli_secure_query($_POST['rst_tem_mesa_ar_livre']);
$rst_tem_delivery = mysqli_secure_query($_POST['rst_tem_delivery']);
$rst_telefone_delivery = mysqli_secure_query($_POST['rst_telefone_delivery']);
$rst_tem_musica_ao_vivo = mysqli_secure_query($_POST['rst_tem_musica_ao_vivo']);
$rst_tem_acesso_deficientes = mysqli_secure_query($_POST['rst_tem_acesso_deficientes']);
$rst_tem_area_fumantes = mysqli_secure_query($_POST['rst_tem_area_fumantes']);
$rst_tem_area_criancas = mysqli_secure_query($_POST['rst_tem_area_criancas']);
$rst_tem_estacionamento = mysqli_secure_query($_POST['rst_tem_estacionamento']);
$rst_tem_manobrista = mysqli_secure_query($_POST['rst_tem_manobrista']);
$rst_permite_levar_vinhos = mysqli_secure_query($_POST['rst_permite_levar_vinhos']);
$rst_tem_ar_condicionado = mysqli_secure_query($_POST['rst_tem_ar_condicionado']);

//variáveis de horario de funcionamento
$rst_seg_periodo_geral = mysqli_secure_query($_POST['seg_periodo_geral']);
$rst_ter_periodo_geral =  mysqli_secure_query($_POST['ter_periodo_geral']);
$rst_qua_periodo_geral =  mysqli_secure_query($_POST['qua_periodo_geral']);
$rst_qui_periodo_geral =  mysqli_secure_query($_POST['qui_periodo_geral']);
$rst_sex_periodo_geral =  mysqli_secure_query($_POST['sex_periodo_geral']);
$rst_sab_periodo_geral =  mysqli_secure_query($_POST['sab_periodo_geral']);
$rst_dom_periodo_geral =  mysqli_secure_query($_POST['seg_periodo_geral']);


if(isset($_POST['rst_cartoes_aceitos']))//vamos associar à array cartoes aceitos somente se o usuário selecionou algum valor
	{
	$rst_cartoes_aceitos = $_POST['rst_cartoes_aceitos']; //nao usamos o script mysqli_secure_query pois é array... vai bugar se colocarmos.
	}
	
if(isset($_POST['tipos_refeicoes']))//vamos associar à array cartoes aceitos somente se o usuário selecionou algum valor
	{
	$tipos_refeicoes = $_POST['tipos_refeicoes']; //nao usamos o script mysqli_secure_query pois é array... vai bugar se colocarmos.
	}	
	
	
//ajusta algumas variáveis
//ajusta preço
$rst_preco_min = str_ireplace("R$ ","",$rst_preco_min);
$rst_preco_max = str_ireplace("R$ ","",$rst_preco_max);

$rst_cep = str_ireplace("-","",$rst_cep);

	
	
	
//vamos iniciar validação de campos obrigatórios

$campos_vazios = '';//armazena resultados vazios
foreach($_POST as $key => $value)
	{
	
	switch($key)
		{
			case 'rst_nome':
			if(empty($value))
				{
				$campos_vazios .= "Nome,";
				}
			break;
			case 'rst_categoria':
						if(empty($value))
				{
				$campos_vazios .= "Categoria,";
				}
			break;
			case 'rst_cidade_id':
					if(empty($value))
				{
				$campos_vazios .= "Cidade,";
				}
			break;
			case 'rst_latitude':
					if(empty($value))
				{
				$campos_vazios .= "Latitude,";
				}
			break;
			case 'rst_longitude':
						if(empty($value))
				{
				$campos_vazios .= "Longitude,";
				}
			break;
			case 'rst_cep':
						if(empty($value))
				{
				$campos_vazios .= "CEP,";
				}
			break;
			
			case 'rst_telefone':
						if(empty($value))
				{
				$campos_vazios .= "Telefone,";
				}
			break;
			
		}
	}
	
	//ajusta string campos_vazios
	$campos_vazios = rtrim($campos_vazios,',');
	
//vamos verificar se há algum campo vazio
if(strlen($campos_vazios) > 0)
	{
		echo '<span class="error">Erro no cadastro do restaurante: Os seguintes campos obrigatórios estão vazios: '.$campos_vazios."</span>";
	}
		else//se nao tem campo obrigatório vazio, vamos registrar os dados
			{

				$stmt->close();
				$qry = "INSERT INTO restaurantes VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('sisddiddsssssiiiiisiiiiiiii',$rst_nome,$rst_categoria,$rst_descricao,$rst_preco_min,$rst_preco_max,$rst_cidade_id,
				$rst_latitude,$rst_longitude,$rst_cep,$rst_endereco,$rst_telefone,$rst_site,$rst_facebook,$rst_aceita_reserva,$rst_aceita_cartao,$rst_tem_wifi,
				$rst_tem_mesa_ar_livre,$rst_tem_delivery,$rst_telefone_delivery,$rst_tem_musica_ao_vivo,$rst_tem_acesso_deficientes,$rst_tem_area_fumantes,$rst_tem_area_criancas,
				$rst_tem_estacionamento,$rst_tem_manobrista,$rst_permite_levar_vinhos,$rst_tem_ar_condicionado);
				$stmt->execute();
				
				$rst_id = $mysqli->insert_id;//vamos salvar qual a ID do restaurante cadastrado para usarmos posteriormente, quando formos registrar os cartões aceitos (veja abaixo) 

				
				if($stmt->affected_rows >= 1)//se tudo foi inserido com sucesso....
					{
						echo '<p class="sucesso">O restaurante <span style="text-decoration:underline;">'.$rst_nome.'</span> foi adicionado com sucesso</p>';
		
					}
					else
						{
						echo '<p class="error">O restaurante não foi cadastrado na base de dados. Verifique os dados inseridos no formulário</p>';
						}
						
	//registra cartões aceitos
	
	if(isset($rst_cartoes_aceitos))
			{
			if(count($rst_cartoes_aceitos) > 0)//se tem cartao aceito, vamos registrá-los também
				{
					for($i=0;$i<count($rst_cartoes_aceitos);$i++)//roda um loop para cadastrar todos cartões aceitos
						{
					$stmt->close();
					$qry = "INSERT INTO restaurantes_cartoes VALUES (null,?,?)";
						$stmt = $mysqli->prepare($qry);
						$stmt->bind_param('ii',$rst_id,$rst_cartoes_aceitos[$i]);
						$stmt->execute();
						
						}
				}
	}//isset cartoes aceitos
	//registra horários de funcionamento
	
	
	/*rst_horario_id	
rst_id	
rst_dia_semana	
rst_horario_de	
rst_horario_ate	
rst_dia_inteiro	
rst_nao_funciona*/


	switch($rst_seg_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "segunda";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "segunda";
			$rst_horario_de = mysqli_secure_query($_POST['segunda_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['segunda_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "segunda";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
	
	
			
			}
			
					switch($rst_ter_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "terca";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "terca";
			$rst_horario_de = mysqli_secure_query($_POST['terca_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['terca_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "terca";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
		
		
				switch($rst_qua_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "quarta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "quarta";
			$rst_horario_de = mysqli_secure_query($_POST['quarta_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['quarta_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "quarta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
	
	
			switch($rst_qui_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "quinta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "quinta";
			$rst_horario_de = mysqli_secure_query($_POST['quinta_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['quinta_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "quinta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
	
	
			switch($rst_sex_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "sexta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "sexta";
			$rst_horario_de = mysqli_secure_query($_POST['sexta_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['sexta_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "sexta";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
		
				switch($rst_sab_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "sabado";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "sabado";
			$rst_horario_de = mysqli_secure_query($_POST['sabado_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['sabado_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "sabado";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
		
		
				switch($rst_dom_periodo_geral)
		{
			case 'dia_inteiro':
			//especifica variáveis
			$rst_dia_semana = "domingo";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 1;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			
			break;	
			
			case 'horario_especifico':
			//especifica variáveis
			$rst_dia_semana = "domingo";
			$rst_horario_de = mysqli_secure_query($_POST['domingo_de']);
			$rst_horario_ate = mysqli_secure_query($_POST['domingo_ate']);
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 0;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
			
			case 'nao_funciona':
			//especifica variáveis
			$rst_dia_semana = "domingo";
			$rst_horario_de = 0;
			$rst_horario_ate = 0;
			$rst_dia_inteiro = 0;
			$rst_nao_funciona = 1;
			
			//cadastra na bd			
			$stmt->close();
			$qry = "INSERT INTO restaurantes_horarios VALUES (null,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('isssii',$rst_id,$rst_dia_semana,$rst_horario_de,$rst_horario_ate,$rst_dia_inteiro,$rst_nao_funciona);
				$stmt->execute();
			break;	
		}
	
	
	//vamos registrar os tipos de refeições
	
	if(!empty($tipos_refeicoes))//se tem algum tipo de refeição para cadastrar
		{
			for($i=0;$i<count($tipos_refeicoes);$i++)
				{
						$stmt->close();
			$qry = "INSERT INTO restaurantes_refeicoes VALUES (null,?,?)";
				$stmt = $mysqli->prepare($qry);
				$stmt->bind_param('ii',$rst_id,$tipos_refeicoes[$i]);
				$stmt->execute();
				}
				
		}
	
	//vamos cadastrar a logomarca
	
	//primeiro verifica se a logomarca foi enviada
	if($_FILES["rst_logo"]['size'] > 0)
	{
	//	echo "Salvando logomarca...";
		$file_temp_path = $_FILES["rst_logo"]["tmp_name"];
		
		  require_once('../classes/SimpleImage.php');
        $image = new SimpleImage();
        $image->load($file_temp_path);
//essa variável armazena aonde iremos salvar o arquivo de foto
				$image->resize(100, 100);
				
				        $file_path = "../gfx/restaurantes/";
					    $uploaded_file = $file_path . "logo_" . $rst_id. ".jpeg";
	
                $image->save($uploaded_file); //salva no lugar da foto original (substitui)
		
		/*
			//se inseriu na base de dados corretamente...
		//vamos prosseguir com o registro dos arquivos	
		$new_image_name = "logo_".$id_prato.".jpeg";//especifica nome de arquivo de acordo com a id do registro na tablea
		move_uploaded_file($_FILES["file"]["tmp_name"], "../gfx/restaurantes/".$new_image_name);//salva arquivo em folder em particular*/

	}
	
	

	}//end form post
	
	
	
?>




<h2>Cadastre um Novo Restaurante</h2>

<?php

//------------------------- FORMULARIO CADASTRO DE RESTAURANTE-----------------------------------//

echo '
<form action="cadastro_restaurante.php" method="post" enctype="multipart/form-data">

	<ul style="list-style:none;">
    	<li>
        	<label for="rst_nome"><strong>Nome do Restaurante </strong></label>
        	<input type="text" name="rst_nome" value="" /><span class="obrigatorio">* Obrigatório</span>
        </li>
		
		<li>
		<label for="rst_logo"><strong>Logomarca:</strong></label>
        	<input type="file" name="rst_logo"/>
			
		</li>
		
		<li>
        	<label for="rst_categoria"><strong>Categoria</strong></label>
        	<select name="rst_categoria">
				'.$html_tc.'
			</select><span class="obrigatorio">* Obrigatório</span>
        </li>
		
		<li>
        	<label for="rst_descricao"><strong>Descrição</strong></label><br />
        	<textarea name="rst_descricao" rows="4" cols="50"></textarea>
        </li>
		
			<li>
        	<label for="rst_preco_min"><strong>Preço Mínimo</strong></label>
        	<input type="text" class="dinheiro" name="rst_preco_min" value=""/>
       		</li>
			
				<li>
        	<label for="rst_preco_max"><strong>Preço Máximo</strong></label>
        	<input type="text" class="dinheiro" name="rst_preco_max" value=""/>
       		</li>
			
				<li>
        	<label for="rst_cidade_id"><strong>Cidade (Estado)</strong></label><span class="obrigatorio">* Obrigatório</span><br />

    			<input type="radio" name="rst_cidade_id" checked="checked" value="2048"/> Vitória (ES)
				<input type="radio" name="rst_cidade_id" value="2044"/> Vila Velha (ES)
       		</li>
			
			<li>
        	<label for="rst_latitude"><strong>Latitude</strong></label>
        	<input type="text" name="rst_latitude" value=""/><span class="obrigatorio">* Obrigatório</span>
       		</li>
			
			<li>
        	<label for="rst_longitude"><strong>Longitude</strong></label>
        	<input type="text" name="rst_longitude" value=""/><span class="obrigatorio">* Obrigatório</span>
       		</li>
			
			<li>
        	<label for="rst_cep"><strong>CEP</strong></label>
        	<input type="text" name="rst_cep" value=""/><span class="obrigatorio">* Obrigatório</span>
       		</li>
			
			<li>
        	<label for="rst_endereco"><strong>Endereço</strong></label>
        	<input type="text" name="rst_endereco" value=""/>
       		</li>
			
			
			<li>
        	<label for="rst_telefone"><strong>Telefone:</strong></label>
        	<input type="text" name="rst_telefone" value=""/><span class="obrigatorio">* Obrigatório</span>
       		</li>
			
			
			<li>
        	<label for="rst_site"><strong>Website:</strong></label>
        	<input type="text" name="rst_site" value=""/>
       		</li>
			
			
			<li>
        	<label for="rst_facebook"><strong>Facebook:</strong></label>
        	<input type="text" name="rst_facebook" value=""/>
       		</li>
			
			
<h3>Características do Local</h3>
		
			
			<li>
        	<label for="rst_aceita_reserva"><strong>Aceita reserva?</strong></label>
        		<select name="rst_aceita_reserva">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			
			<li>
        	<label for="rst_aceita_cartao"><strong>Aceita Cartão?</strong></label>
        		<select name="rst_aceita_cartao">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_cartoes_aceitos"><strong>Caso aceite cartão, quais? (Segure CTRL para selecionar)</strong></label><br />

        		<select name="rst_cartoes_aceitos[]" multiple="multiple">
					<option value="0">Não Aceita cartão</option>
						'.$html_cartoes_aceitos.'
				</select>
       		</li>
			
			<li>
        	<label for="rst_tem_wifi"><strong>Tem WiFi?</strong></label>
        		<select name="rst_tem_wifi">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_tem_mesa_ar_livre"><strong>Tem mesa ao ar livre?</strong></label>
        		<select name="rst_tem_mesa_ar_livre">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			
				<li>
        	<label for="rst_tem_delivery"><strong>Tem Delivery?</strong></label>
        		<select name="rst_tem_delivery">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_telefone_delivery"><strong>Caso tenha delivery, qual é o telefone para realizar pedidos?</strong></label><br />

        		<input type="text" name="rst_telefone_delivery"/>
       		</li>
			
			<li>
        	<label for="rst_tem_musica_ao_vivo"><strong>Tem música ao vivo?</strong></label>
        		<select name="rst_tem_musica_ao_vivo">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_tem_acesso_deficientes"><strong>Tem acesso para deficientes?</strong></label>
        		<select name="rst_tem_acesso_deficientes">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
				<li>
        	<label for="rst_tem_area_fumantes"><strong>Tem área para fumantes?</strong></label>
        		<select name="rst_tem_area_fumantes">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
				<li>
        	<label for="rst_tem_area_criancas"><strong>Tem área para crianças?</strong></label>
        		<select name="rst_tem_area_criancas">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
					<li>
        	<label for="rst_tem_estacionamento"><strong>Tem estacionamento?</strong></label>
        		<select name="rst_tem_estacionamento">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
					<li>
        	<label for="rst_tem_manobrista"><strong>Tem manobrista?</strong></label>
        		<select name="rst_tem_manobrista">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_permite_levar_vinhos"><strong>Permite levar vinhos?</strong></label>
        		<select name="rst_permite_levar_vinhos">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<li>
        	<label for="rst_tem_ar_condicionado"><strong>Tem ar condicionado?</strong></label>
        		<select name="rst_tem_ar_condicionado">
					<option value="0" selected="selected">Não</option>
						<option value="1">Sim</option>
				</select>
       		</li>
			
			<br />
			
			<h3>Horários de Funcionamento</h3>
			
			<fieldset>
				<ul>
				  <li>
				  	Segunda-Feira:
					<select name="seg_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
										<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="segunda_de" disabled/> até  <input type="text" class="time" name="segunda_ate" disabled/>
				  </li>
				  
				   <li>
				  	Terça-Feira:
					<select name="ter_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="terca_de" disabled/> até  <input type="text" class="time" name="terca_ate" disabled/>
				  </li>
				  
				   <li>
				  	Quarta-Feira:
					<select name="qua_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="quarta_de" disabled/> até  <input type="text" class="time" name="quarta_ate" disabled/>
				  </li>
				  
				   <li>
				  	Quinta-Feira:
					<select name="qui_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="quinta_de" disabled/> até  <input type="text" class="time" name="quinta_ate" disabled/>
				  </li>
				  
				   <li>
				  	Sexta-Feira:
					<select name="sex_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="sexta_de" disabled/> até  <input type="text" class="time" name="sexta_ate" disabled/>
				  </li>
				  
				   <li>
				  	Sábado:
					<select name="sab_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="sabado_de" disabled/> até  <input type="text" class="time" name="sabado_ate" disabled/>
				  </li>
				  
				   <li>
				  	Domingo:
					<select name="dom_periodo_geral" class="periodo_geral">
						<option value="dia_inteiro">O dia inteiro</option>
						<option value="horario_especifico">Horários específicos</option>
						<option value="nao_funciona">Não Funciona</option>
					</select> -&nbsp;&nbsp;&nbsp;&nbsp;De <input type="text" class="time" name="domingo_de" disabled/> até  <input type="text" class="time" name="domingo_ate" disabled/>
				  </li>
				  
				  
				  
				  
				  
				
				
				</ul>
			</fieldset>
			
			<h3>Refeições Disponíveis</h3>
			<fieldset>
			<p>Segure CTRL e clique para selecionar</p>
			
			<select name="tipos_refeicoes[]" multiple="multiple">
			'.$html_tipos_refeicoes.'
			</select>
			
			</fieldset>
			
			<input type="submit" value="Cadastrar Restaurante"/>
			
			
			
			
			
			
			
			
			
			
    </ul>

</form>
';



?>



</body>
</html>