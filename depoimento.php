<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/top_functions.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
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

?>
<h1>Envie seu Depoimento</h1>

<p>Já conseguiu um emprego ou uma entrevista pelo Empregue-me? Dê seu depoimento e motive os outros usuários a continuarem a utilizando o site para
conseguir resultados!</p>

<form action="depoimento.php" method="post">

<ul>
	<li>Tipo de depoimento:
    	<select name="tipo_depoimento">
        	<option name="tipo_depoimento" value="0">Consegui uma entrevista</option>
            <option name="tipo_depoimento" value="1">Consegui um emprego</option>
            
        </select>
    </li>
	<li>Título: <input type="text" name="msg_titulo" placeholder="O título de seu depoimento" style="width:200px;"/> </li>
    <li>Mensagem:<br />
	<textarea name="msg_descricao" placeholder="Escreva sua mensagem" maxlength="400" style="width:400px;height:200px;"></textarea>
    
    </li>
    
    <br />
    <input type="submit" style="margin-left:90px;" class="botao_cta" value="Enviar"/>

</ul>


</form>



<?php       

//------------------ GERENCIA CADASTRO DE DEPOIMENTOS ----------------------

if(isset($_POST['msg_titulo']))
{
	//prepara variaveis
	@$assunto = mysqli_secure_query($_POST['msg_titulo']);
	@$mensagem = mysqli_secure_query($_POST['msg_descricao']);
	@$tipo_depoimento = mysqli_secure_query($_POST['tipo_depoimento']);
	
//inicia validação de dados
    if (checa_vazio(array($assunto,$mensagem), array('Assunto','Mensagem'))) {
		$display_main->noty('Não foi possível enviar a mensagem pois os seguintes campos encontram-se vazios:'.$resultados_vazios,'error','topCenter',6000);
        exit;
    }




//registra na base de dados
$mysqli = mysqli_full_connection();
$mysqli->set_charset('utf8');
$qry = "INSERT INTO depoimentos VALUES(null,?,?,?,?)";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('issi',$_SESSION['userid'],$assunto,$mensagem,$tipo_depoimento);
	$stmt->execute();
	
	if($stmt->affected_rows >= 1)
		{
			$display_main->noty('Muito Obrigado! Seu depoimento foi registrado com sucesso e será publicado em breve em nosso website.','success','topCenter',6000);
		
		}
		else
		{
			$display_main->noty('Seu depoimento não pôde ser registrado em nosso sistema no momento. Favor enviá-lo para sac@empreguemeagora.com.br','error','topCenter',6000);
		}
	
	
}


$display_main->painel_direita();
$display_main->fundo();
?>


