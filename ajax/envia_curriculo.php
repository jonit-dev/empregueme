<?php
require_once('../funcoes/db_functions.php');
require_once('../funcoes/session_functions.php');
if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
header ('Content-type: text/html; charset=utf-8');


$userid = mysqli_secure_query($_POST['userid']);//captura variável passada pelo ajax
$vaga_codigo = mysqli_secure_query($_POST['vaga_codigo']);//captura variável passada pelo ajax


//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

//consulta código do currículo do usuário, que será necessário para o registro na BD

$qry = "SELECT id FROM curriculos WHERE fk_usu_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$userid);
$stmt->execute();
$stmt->bind_result($curriculo_id);
while($stmt->fetch())
	{
		$curriculo_id = $curriculo_id;	
	}
$stmt->close();	

//verifica a ID de quem cadastrou a vaga
$qry = "SELECT usu_codigo FROM vagas WHERE vag_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$vaga_codigo);
$stmt->execute();
$stmt->bind_result($id_quem_cadastrou_vaga);
while($stmt->fetch())
	{
		$id_quem_cadastrou_vaga = $id_quem_cadastrou_vaga;	
	}
$stmt->close();	

//------------ ENVIO DE CURRICULO

//primeiro, verifica se é membro VIP 

if($_SESSION['membro_vip_ativo'] == 1)//se é membro vip ativo
	{
		//envia CV na hora

//código do diogo aqui
		
		//registra na base de dados
		
		$mysqli = $connect->getConnection();
	registra_envio_cv_bd($mysqli,$curriculo_id,$vaga_codigo,'Vaga VIP',0);//apenas registra que foi enviado!
	
		exit;
		
	}
	
//verifica se quem inseriu a vaga foi empresa real --> se for empresa real, envia CV na hora (não foi pelo painel administrativo)
if($id_quem_cadastrou_vaga != 1140)////VAGA DE EMPRESA REAL ( Se fosse 1140, seria a cadastrada pela sarah)
	{
		//envia CV na hora
		
		
		//registra na base de dados		

	$mysqli = $connect->getConnection();
	registra_envio_cv_bd($mysqli,$curriculo_id,$vaga_codigo,'vaga_empresa',0);//registra o currículo do candidato horas.
		exit;
		
	}	
	else
	{//se é vaga cadastrada pela Sarah (Pelo Painel Administrativo)
	
		
//agora vamos lidar com os casos padrões...

/*
curr_codigo
vag_codigo
envio_automatico
dt_envio_automatico
envio_manual
*/
$mysqli = $connect->getConnection();
	registra_envio_cv_bd($mysqli,$curriculo_id,$vaga_codigo,'vaga_normal',0);//registra o envio do CV na fila... usuário deve aguardar até 48 horas. 

	}


//---------FUNCOES UTEIS NO SCRIPT----

function registra_envio_cv_bd($mysqli,$curriculo_id,$vaga_codigo,$tipo_vaga = "vaga_normal",$enviada = 0)
{
	
	//enviada = 0 => Significa que a vaga está indo para fila de envio e será enviada depois.
	//enviada = 1 => significa que vaga já foi enviada, só estamos registrando para constar na BD.
	
//registra na base de dados o envio do currículo!



$data_atual = time();
$get_data = getdate($data_atual);
$created = $get_data['year'].'-'.$get_data['mon'].'-'.$get_data['mday'].' '.$get_data['hours'].':'.$get_data['minutes'].':'.$get_data['seconds'];

$qry = "INSERT INTO curriculos_vagas VALUES (?, ?, 0, null, ?, ?)";
	
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('iiis',$curriculo_id,$vaga_codigo,$enviada, $created);
$stmt->execute();

if($stmt->affected_rows > 0)
	{
		echo $tipo_vaga.": Registrada";
	}
	else
	{
	echo $tipo_vaga.": Erro no registro";
	}

		$stmt->close();
		$mysqli->close();
		
//pronto	
}



?>