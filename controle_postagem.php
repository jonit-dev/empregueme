<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('classes/date_management.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/funcoes_estruturais.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout

$gerencia_data = new date_management;
//update session vars
//session_start();


$display_main->head();

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

//carrega lista de usuários
$mysqli = mysqli_full_connection();
$qry = "SELECT usu_login,usu_codigo FROM usuario WHERE usu_permissao = 1";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($usu_login,$usu_codigo);

$opt_login = '';
while($stmt->fetch())
	{
	$opt_login .= '<option name="usuario" value="'.$usu_login.'">'.$usu_login.'</option>';
	
		
	}


$display_main->conteudo('


<h1>Controle de Postagem</h1>

<p>Selecione o usuário abaixo e o período de seu interesse para ver a quantidade de vagas postadas:</p>


<form action="controle_postagem.php" method="post">
<ul>
	<li>Usuário: 
		<select name="usuario">
    		'.$opt_login.'
   		 </select>
    </li>
	
	
	<li>
		Data Inicial: <input type="date" name="data_inicio" />  -  Data de término: <input type="date" name="data_termino" />
	</li>
	
	<li>Quantas vagas por dia você deveria postar? <input type="number" name="meta" /></li>
	
</ul>

<input type="submit" value="Consultar" />

</form>');

if(isset($_POST['usuario']))
{
//valida dados
@$usuario = mysqli_secure_query($_POST['usuario']);
@$data_inicio = mysqli_secure_query($_POST['data_inicio']);
@$data_termino = mysqli_secure_query($_POST['data_termino']);
@$meta = mysqli_secure_query($_POST['meta']);



//inicia validação de dados
    if (checa_vazio(array($usuario,$data_inicio,$data_termino), array('Usuário','Data inicial','Data término'))) {
		$display_main->noty('Não foi possível enviar a mensagem pois os seguintes campos encontram-se vazios:'.$resultados_vazios,'error','topCenter',6000);
        exit;
    }
	
	
	
//faz requisicao à BD

$mysqli = mysqli_full_connection();


$qry = "SELECT count(v.vag_codigo)
 FROM vagas as v, usuario as usu
  WHERE 	
  usu.usu_codigo = v.usu_codigo AND
  usu.usu_login = ? AND
  v.vag_dt_inicio >= ? AND
  v.vag_dt_inicio <= ?
  
  
  ";
  $stmt = $mysqli->prepare($qry);
  $stmt->bind_param('sss',$usuario,$data_inicio,$data_termino);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($r_n_vagas);
  while($stmt->fetch())
  	{

$n_vagas = $r_n_vagas;		
	}
	
	$data_inicio = $gerencia_data->converte_data($data_inicio,'eng','pt-br');
	$data_termino = $gerencia_data->converte_data($data_termino,'eng','pt-br');
	
$ts1 = strtotime($data_inicio);
$ts2 = strtotime($data_termino);

$seconds_diff = $ts2 - $ts1;

$dias_diff = floor($seconds_diff/3600/24);

$dias_diff = $dias_diff + 1;//add 1 para ajustar

$meta_postagem = $dias_diff*$meta;

//soma 1 à meta
$meta_postagem = $meta_postagem + 1;

$meta_diff = $meta_postagem - $n_vagas;

$conclusao = '';

	$faltam = $meta_postagem - $n_vagas;
	
	if($faltam > 0)
		{
			$conclusao = '<span style="color:red;">Faltam '.$faltam.' vagas para você postar</span>';	
		}
			if($faltam == 0)
		{
$conclusao = '<span style="color:green;">Parabéns! Você atingiu sua meta do período.</span>';		
		}
	
		if($faltam < 0)
		{	

$conclusao = '<span style="color:green;">Parabéns! Você atingiu sua meta e ainda postou '.abs($faltam).' vagas extras</span>';	
		
		}

	

	
	
	echo '
	<h3>Resultado:</h3>
	
	<p>Usuário: <b style="color:blue;">'.$usuario.'</b><br />
	 <b>Total de Vagas Postadas:  </b><span style="color:green;">'.$r_n_vagas.' vagas</span> no período de '.$data_inicio.' até '.$data_termino.'<br />
	<b>Quantas Vagas deveria ter postado:  </b> <span style="color:red;"> '.$meta_postagem.' vagas</span><br />
	<b>Conclusão: </b>'.$conclusao.'
	</p>
	
	';
  







	
}








$display_main->painel_direita();
$display_main->fundo();


