 <?php

function login_user($login, $password, $redirect = false, $login_pos_creation = false, $redirect_pos_criar_cv = false, $tipo_conta = 0, $receber_vagas = 1) {
//passsa variáveis para sessão (sessão é criada em session_functions.php)


    require_once('class_display.php');
//Script functions
   
    require_once('funcoes/top_functions.php');
    require_once('funcoes/db_functions.php');
    require_once('funcoes/email_functions.php');

    $display_site = new display();
    $display_site->top();

//form vars

    echo "<p>Aguarde enquanto o login é realizado...</p>";
//VALIDATION//
//Check if vars were filled

$ultima_pagina = $_SERVER['HTTP_REFERER'];
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET

    if (empty($login) || empty($password)) {
        redireciona($ultima_pagina.'?error=1'); //campos vazios
    }


//check if user filled a valid email
    if (check_email_address($login) == false) {
        redireciona($ultima_pagina.'?error=21'); //email inválido
    }

//end validation
//DB connection
//connect to db
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");

//prepara query

    $usu_senha = sha1($password);


//Primeiro, verifica se combinação usuário/password existe
    $qry = "SELECT usu_codigo,usu_login,usu_senha FROM usuario WHERE usu_login = ? and usu_senha = ? and usu_ativo = 1";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('ss', $login, $usu_senha);
    $stmt->execute();
    $stmt->bind_result($r_usu_codigo, $r_usu_email, $r_usu_senha);

    $tem_resultado = false;
    while ($stmt->fetch()) {//se encontrar algo no resultado é porque fez o login
//primeiro, vamos desconectar qualquer usuário que esteja conectado, caso ele faça login novamente
        foreach ($_SESSION as $key => $value) {//remove todas as variáveis de sessão
            unset($_SESSION[$key]);
        }

//prossegue	

        $tem_resultado = true;

//conserta variáveis
        $r_userid = stripslashes($r_usu_codigo);
        $r_login = stripslashes($r_usu_email);
        $r_password = stripslashes($r_usu_senha);

//Agora carrega o restante dos dados
        $stmt->close(); //fecha conexão anteriro

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
       $mysqli->set_charset("utf8");
		$stmt = $mysqli->prepare($qry);
		
        $stmt->bind_param('i', $r_userid);
        $stmt->execute();
        $stmt->bind_result($usu_codigo, $usu_id, $cid_codigo, $usu_nome, $usu_dt_cad, $usu_nickname, $usu_login, $usu_sexo, $usu_idade, $usu_bairro, $usu_telefone1, $usu_telefone2, $usu_link_facebook, $usu_foto_perfil, $importou_email, $tipo_conta, $usu_cep);




        while ($stmt->fetch()) {

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
//$_SESSION['ultimo_ip'] = $r_ultimo_ip;
        }
//verifica se o usuário tem curriculo cadastrado
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
	

//===> IMportante: se alterar aqui acima, atualize function session refresh
//Antes de carregar o usuário para página principal, vamos verificar se ele importou os contatos.
        if ($importou_email == 1)//se já importou email, só redireciona
		
		 {
            if (isset($_GET['loadafter']))//se passou esse parametro por get, vamos redirecionar o usuário para determinada página
			
			 {
                @ $load_after = mysqli_secure_query($_GET['loadafter']);

               
                redireciona($load_after);
            }
			 else
			  {//se nao passou nada por get, vá para página main.php direto
				
				//vamos verificar o tipo de conta para inserir uma var por get na url, só para identificarmos logins de empresas no analytics
				if($_SESSION['tipo_conta'] == 0)
					{
								//se for usuario free e já importou email
		if($_SESSION['membro_vip_ativo'] != 1)
			{
									
					redireciona('main.php?tipo=usuario');// se nao encontrar nenhum email compatível com a importação... vai para página inicial mesmo
				
				
			}
		
		//se for usuario pago
		if($_SESSION['membro_vip_ativo'] == 1)
			{
				redireciona('main.php?tipo=usuario');	//vai direto para pagina inicial!
			}
	
					}
				if($_SESSION['tipo_conta'] == 1)
					{
						 redireciona("main.php?tipo=empresa");
					}	
					
				
               
            }
        } elseif ($importou_email == 0) 
		{//se nao importou email, vamos importar
		
		
			 //verifica de qual estado é o usuario, baseando se na cidade dele
								$mysqli2 =  mysqli_full_connection();
								$qry2 = "SELECT cid.estados_cod_estados FROM cidades as cid WHERE
								
								cid.cod_cidades = ?";
								$stmt2 = $mysqli2->prepare($qry2);
								$stmt2->bind_param('i',$_SESSION['cidade_id']);
								$stmt2->execute();
								$stmt2->store_result();
								$stmt2->bind_result($usu_estado);
								while($stmt2->fetch())
									{
									$usu_estado = $usu_estado;	
									}
		
		
				//primeiro, vamos verificar se é um login logo após a criação do CV...
					//se for pessoa física
					if($tipo_conta == 0)
					{
					
						if ($login_pos_creation == true)
						 {//se é login automático logo após criarmos a conta do user
						 
						 
							if ($redirect_pos_criar_cv != false)
							
							 {//se tem que redirecionar para vaga específica após criar CV
									
									//desativado
																
								

							redireciona('curriculo.php?redireciona=' . $redirect_pos_criar_cv); //redireciona para cadastro de CV
							} 
							else
							 {//se nao, vai só para criação do CV
							 
							 			if($receber_vagas == 0)//se nao quer receber vagas, vai logo pro currículo
											{
												redireciona('curriculo.php');
												exit;
											}
										
										
											//se quer receber vagas, registra nas listas			
						
																									
							 
							 
								redireciona('curriculo.php'); //redireciona para cadastro de CV
							}
						}
			
						if ($redirect != false) {//se tem que redirecionar...
							redireciona($redirect);
						}
					}//end tipo conta
					
					//se for empresa
					if($tipo_conta == 1)
					{
					
						if ($login_pos_creation == true)
						 {//se é login automático logo após criarmos a conta do user
						 
						 	//desativado por enquanto... 
						 
				
						}
			
						if ($redirect != false) 
						{//se tem que redirecionar...
						redireciona($redirect);
						
								
						}
						
				
					}//end tipo conta
					
		
		
		
		

//Só importa contatos de usuários! De empresa é melhor fazer propaganda do plano recrutador!!


            //se nao, vamos prosseguir normalmente
if($_SESSION['tipo_conta'] == 0)//se é pessoa física fazendo login
{
	
	//primeiro verifica se já criou o currículo
	if($_SESSION['curriculo'] == 0)//se nao...
		{
			if(isset($redirect_pos_criar_cv))
			{
			redireciona('curriculo.php'.$redirect_pos_criar_cv);	
			}
			else
			{
			redireciona('curriculo.php');
			}
		}
		
		//se for usuario free
		if($_SESSION['membro_vip_ativo'] != 1)
			{
				//redireciona('vip_ad.php');
                redireciona('main.php');
				
			//verifica qual provedor de e-mail e redireciona para o script de importação correspondente
				/*if(stristr($_SESSION['login'],'live') || stristr($_SESSION['login'],'hotmail') || stristr($_SESSION['login'],'outlook'))
					{
						redireciona('importa_email_outlook.php');
						exit;
					}
					
							if(stristr($_SESSION['login'],'gmail'))
					{
						redireciona('importa_email_gmail.php');
						exit;
					}
					
					
					redireciona('main.php?tipo=usuario');// se nao encontrar nenhum email compatível com a importação... vai para página inicial mesmo
				*/
			}
		
		//se for usuario pago
		if($_SESSION['membro_vip_ativo'] == 1)
			{
				redireciona('main.php?tipo=usuario');	//vai direto para pagina inicial!
			}
	
	

}

if($_SESSION['tipo_conta'] == 1)//se for empresa
					{
						//se nao for plano recrutador, vai pra pagina de selecionar plano
						if($_SESSION['plano_recrutador_ativo'] != 1)
							{
										 redireciona("empresa_seleciona_plano.php");
							}
						if($_SESSION['plano_recrutador_ativo'] == 1)//se tem plano recrutador ativo..
							{
								 redireciona("main.php?tipo=empresa");
							}
						
				
					}

          
        }
    }

    if ($tem_resultado == false) {//se não encontrou usuário, é porque o username/password está errado
        redireciona($ultima_pagina.'?error=22'); //email inválido
    }
}

//end function login
?>