<?php

//SESSION SCRIPTS
//update session vars
if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

function check_session()//verifica se sessão está ou não ativa
{
if(session_id() == '') {
 return false;
}			
else
{
return true;	
}
	
}


//verifica se usuario esta logado
//check_loggedin();

function session_clean() {
    //clean all session vars and destroy session
    foreach ($_SESSION as $key => $value) {//remove todas as variáveis de sessão
        unset($_SESSION[$key]);
    }
    session_destroy(); //finaliza nossa sessão	
}


function custom_check_vip()
{
if (!isset($_SESSION['membro_vip_ativo']) || empty($_SESSION['membro_vip_ativo']) || $_SESSION['membro_vip_ativo'] == 0 || $_SESSION['membro_vip_ativo'] == 2  ) {//se usuário nem tem variável de sessão é pq nao é VIP
 
 return false;
}
else
{
return true;	
}
	
}



function check_vip() {//verifica se o usuário que está logado é realmente VIP (ou seja, tal função deve ser apenas chamada após o session_start
    require_once('funcoes/url_functions.php');

    check_loggedin();
    if (!isset($_SESSION['membro_vip_ativo']) || empty($_SESSION['membro_vip_ativo']) || $_SESSION['membro_vip_ativo'] == 0) {//se usuário nem tem variável de sessão é pq nao é VIP
        //mostra mensagem de alerta
		
        echo '<script type="text/javascript">
			  
function redireciona_agora()
        {
        window.location.replace("membro_vip.php");
        exit;
        }



alert("Essa área é EXCLUSIVA para Membros VIPs Empregue-me! Crie sua conta e desfrute já de todos os benefícios.");
setTimeout("redireciona_agora()", 1);
exit;
</script>';




        exit;
    }
}

function check_plano_recrutador() {//verifica se o usuário que está logado é realmente plano_recrutador (ou seja, tal função deve ser apenas chamada após o session_start
    require_once('funcoes/url_functions.php');

    check_loggedin();
    if (!isset($_SESSION['plano_recrutador_ativo']) || empty($_SESSION['plano_recrutador_ativo']) || $_SESSION['plano_recrutador_ativo'] == 0) {//se usuário nem tem variável de sessão é pq nao é plano recrutador
        //mostra mensagem de alerta
        echo '<script type="text/javascript">
			  
function redireciona_agora()
        {
        window.location.replace("plano_recrutador.php");
        exit;
        }



alert("Essa área é EXCLUSIVA para empresas que possuem o Plano Recrutador Empregue-me! Crie sua conta e desfrute já de todos os benefícios.");
setTimeout("redireciona_agora()", 1);
exit;
</script>';




        exit;
    }
}


function check_loggedin() {//check if a user is really logged in (avoid page acess without login
    require_once('funcoes/url_functions.php');
    //check if user has directly for this page, without login!
    if (empty($_SESSION['login']) || !isset($_SESSION['login'])) {
        //mostra mensagem de alerta
        echo '<script type="text/javascript">
			  
							function redireciona_agora()
								{
								window.location.replace("index.php");
								exit;
								}
							
							
							
						alert("CRIE SUA CONTA ou faça LOGIN para acessar essa seção do site!");
						setTimeout("redireciona_agora()", 1);
						exit;
				</script>';




        exit;
    }
}

function session_refresh() {//atualiza todas as variáveis de função
//primeiro contecta-se à DB
//faz conexão com base de dados
    $mysqli = mysqli_full_connection();
	$mysqli->set_charset("utf8");
    $qry = "SELECT 
  `usu_codigo`,
  `usu_id`,
  cid_codigo,   
  `usu_nome`,
  `usu_dt_cad`, 
  `usu_nickname`,
  `usu_login`,
  `usu_sexo`,
  `usu_idade`,
  `usu_bairro`,
  `usu_telefone1`,
  `usu_telefone2`,
  `usu_link_facebook`,
  `usu_foto_perfil`,
  `importou_email`,
  `tipo_conta`,
  usu_cep
  FROM usuario WHERE usu_codigo=?";
    $stmt = $mysqli->prepare($qry);
    $usucodigo = $_SESSION['userid'];
    $stmt->bind_param('i', $usucodigo);
    $stmt->execute();
    $stmt->bind_result($usu_codigo, $usu_id, $cid_codigo, $usu_nome, $usu_dt_cad, $usu_nickname, $usu_login, $usu_sexo, $usu_idade, $usu_bairro, $usu_telefone1, $usu_telefone2, $usu_link_facebook, $usu_foto_perfil, $importou_email, $tipo_conta, $usu_cep);
    $tem_resultado = false;
    while ($stmt->fetch()) {//se houver resultado
        $tem_resultado = true;

        //começa a atualizar variáveis de sessão$_SESSION['nome'] = $r_nome;
//$_SESSION['login'] = $r_login; ------------> não pode atualizar o login até porque ele nao muda nunca. Se atualizar corre o risco de deslogar do nada!

        $_SESSION['userid'] = $usu_codigo;
        $_SESSION['userid_facebook'] = $usu_id;
        $_SESSION['cidade_id'] = $cid_codigo;
        $_SESSION['nome'] = $usu_nome;
        $_SESSION['usu_dt_cad'] = $usu_dt_cad;
        $_SESSION['nickname'] = $usu_nickname;
        $_SESSION['login'] = $usu_login;
        $_SESSION['usu_sexo'] = $usu_sexo;
        $_SESSION['usu_idade'] = $usu_idade;
        $_SESSION['usu_bairro'] = $usu_bairro;
        $_SESSION['telefone'] = $usu_telefone1;
        $_SESSION['usu_telefone2'] = $usu_telefone2;
        $_SESSION['usu_link_facebook'] = $usu_link_facebook;
        $_SESSION['usu_foto_perfil'] = $usu_foto_perfil;
        $_SESSION['importou_email'] = $importou_email;
        $_SESSION['tipo_conta'] = $tipo_conta;
        $_SESSION['usu_cep'] = $usu_cep;
    }
	          $stmt->close();
        $qry = "SELECT id FROM curriculos WHERE fk_usu_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $r_userid);
        $stmt->execute();
        $stmt->bind_result($id);
		$tem_resultado = false;
        while ($stmt->fetch()) {
			$tem_resultado = true;
            
                $_SESSION['curriculo'] = $id; //curriculo cadastrado
            
        }
		if($tem_resultado == false)
			{
			    $_SESSION['curriculo'] = 0; // curriculo não cadastrado	
			}
	
    //verifica se o usuário tem curriculo cadastrado
    $stmt->close();
    $qry = "SELECT id FROM curriculos WHERE fk_usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->bind_result($id);
    while ($stmt->fetch()) {
        if ($id) {
            $_SESSION['curriculo'] = $id; //curriculo cadastrado
        } else {
            $_SESSION['curriculo'] = 0; // curriculo não cadastrado
        }
    }
    //armazena id do estado
    $stmt->close();
    $qry = "SELECT estados_cod_estados FROM cidades as cid,usuario as usu WHERE usu.cid_codigo = cid.cod_cidades AND usu.usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->bind_result($r_estado_id);
    while ($stmt->fetch()) {
        $_SESSION['estado_id'] = $r_estado_id;
    }
	

	

    //armazena status da conta VIP
    $stmt->close();
    $qry = "SELECT fk_stat_codigo FROM membro_vip WHERE fk_usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->bind_result($r_membro_vip_ativo);
    $tem_resultado = false;
    while ($stmt->fetch()) {
        $tem_resultado = true;

        //vamos armazenar o resultado na var de sessão, para usarmos mais tarde
        if ($tem_resultado == true) {
            $_SESSION['membro_vip_ativo'] = $r_membro_vip_ativo; //0 = inativo, 1= ativo, 2 = pendente
        }
    }

    if ($tem_resultado == false) {//se nao tem resultado é pq nao é vip
        $_SESSION['membro_vip_ativo'] = 0;
    }
	

	 //armazena status da conta VIP
    $stmt->close();
    $qry = "SELECT fk_stat_codigo FROM plano_recrutador WHERE fk_usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->bind_result($r_plano_recrutador_ativo);
    $tem_resultado = false;
    while ($stmt->fetch()) {
        $tem_resultado = true;

        //vamos armazenar o resultado na var de sessão, para usarmos mais tarde
        if ($tem_resultado == true) {
            $_SESSION['plano_recrutador_ativo'] = $r_plano_recrutador_ativo; //0 = inativo, 1= ativo, 2 = pendente
        }
    }

    if ($tem_resultado == false) {//se nao tem resultado é pq nao é vip
        $_SESSION['plano_recrutador_ativo'] = 0;
    }
	
	
	
	
	
	
}

//end session refresh
?>