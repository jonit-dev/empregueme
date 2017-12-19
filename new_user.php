<?php
session_start() or die("Erro de sessão: Não podemos efetuar login");
require_once('funcoes/login_functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

</head>
<body>
		




        <?php
//Script functions
        require_once('funcoes/top_functions.php');
        require_once('funcoes/db_functions.php');
        require_once('funcoes/email_functions.php');
        require_once('funcoes/url_functions.php');
		//

//default_var
$receber_vagas = 0;

//form vars
        @$nome = $_POST['name'];
        @$nickname = $_POST['nickname'];
        @$login = $_POST['login'];
        @$login2 = $_POST['login2'];
		
		@$login = $_POST['email'];
        @$login2 = $_POST['email2'];
		
        @$password = $_POST['password'];
        @$password2 = $_POST['password2'];
        @$tipo_conta = $_POST['tipo_conta'];
        @$cidade = $_POST['cidade'];
        @$estado = $_POST['estado'];
		
		// @$receber_vagas = $_POST['receber_vagas'];
		  @$receber_vagas = 0;
		 
		
		//require_once('funcoes/array_functions.php');
		//dump_network();
		//exit;
		
		
				echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34989993-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

$ultima_pagina = $_SERVER['HTTP_REFERER'];
$ultima_pagina = strtok($ultima_pagina,'?');//remove parametros GET
		
		
		$redireciona_url = $ultima_pagina;
		
		
if(empty($tipo_conta))//verifica se usuário preencheu o tipo de conta
{
	redireciona($redireciona_url.'?error=24');//esqueceu de especificar tipo de conta
	exit;
}


//ajusta tipo de conta para inserirmos na base de dados....
        switch ($tipo_conta) {
            case 'pf':
                $tipo_conta = 0;
                break;

            case 'e':
                $tipo_conta = 1;
                break;
        }
		
		

		/*if($tipo_conta == 0)
			{
			$redireciona_url = 'index.php';	
			}
		if($tipo_conta == 1)
			{
			$redireciona_url = 'index_empresa.php';	
			}*/
		
		
//=============== >> VALIDATION//

//Check if vars were filled

        echo '<p>Aguarde enquanto criamos sua conta...</p>';

//Verifique se as variáveis foram preenchidas
        if (validate(array($nome, $nickname, $login, $password, $password2)) == 1) 
		{
            redireciona($redireciona_url.'?error=1'); //1=formulario vazio
			exit;
        } 
		
		if (validate(array($nome, $nickname, $login, $password, $password2)) == 2) 
		{
            redireciona($redireciona_url.'?error=2'); //2=caracter invalido
			exit;
        }

//Verifique se o usuário preencheu um endereço de email válido
       /* if (check_email_address($login) == false) 
		{
            redireciona($redireciona_url.'error=3'); //3=email invalido
			exit;
        }*/
		if(!stristr($login,"@"))//se nao encontrar isso é pq o email é invalido
		{
			 redireciona($redireciona_url.'?error=3'); //3=email invalido
			exit;
		}
		
//verifica se o usuário digitou os mesmos passwords
        if ($password != $password2) {
            redireciona($redireciona_url.'?error=4'); //4= senhas nao sao as mesmas
			exit;
        }
//verifica se o usuário digitou o mesmo login
        if ($login != $login2) {
            redireciona($redireciona_url.'?error=5'); //5= emails nao sao os mesmos
			exit;
        }


//Verifica o tamanho do ogin
if ( mb_strlen($login,'utf-8') > 100) {
            redireciona($redireciona_url.'?error=6'); //6=nome usuario > 100 caracters
			exit;
        }

//verifica tamanho do apelido
        if ( mb_strlen($nickname,'utf-8') > 8) {
            redireciona($redireciona_url.'?error=7'); //7=apelido > 8 caracters
			exit;
        }

//verifica tamanho da senha
        if ((strlen($password) > 16)) {
            redireciona($redireciona_url.'?error=8'); //8=comprimento invalido de senha	
			exit;
        }
//check cidade
        if ($cidade == "") {
            redireciona($redireciona_url.'?error=23');
			exit;
        }
//-- FINAL DE VALIDAÇÃO


//============>> INICIA REGISTRO EM BASE DE DADOS


        $mysqli = mysqli_full_connection();

//Primeiro, verifica se usuário já existe
        $qry = "SELECT usu_login FROM usuario WHERE usu_login = ? and usu_ativo = 1";
        $mysqli->set_charset("utf8");
		$stmt = $mysqli->prepare($qry);
		
        $stmt->bind_param('s', $login);
        $stmt->execute();
        $stmt->bind_result($result_login);
        $tem_resultado = false;

        while ($stmt->fetch()) {//se encontrar algo no resultado//é porque usuário já existe.
//conserta variável
            $result_login = stripslashes($result_login);

            $tem_resultado = true;
            redireciona($redireciona_url.'?error=14');

            exit;
        }


//VERIFICA SE NICKNAME JÁ ESTÁ EM USO
//Primeiro, verifica se usuário já existe
        $qry = "SELECT usu_nickname FROM usuario WHERE usu_nickname=?";
        $stmt = $mysqli->prepare($qry);
		 $mysqli->set_charset("utf8");
        $stmt->bind_param('s', $nickname);
        $stmt->execute();
        $stmt->bind_result($result_nickname);


        $tem_resultado_nickname = false;

        while ($stmt->fetch()) {//se encontrar algo no resultado//é porque usuário já existe.
//concerta variável
            $result_nickname = stripslashes($result_nickname);

            $tem_resultado_nickname = true;
            redireciona($redireciona_url.'?error=15');


            exit;
        }

        if ($tem_resultado == false &&  $tem_resultado_nickname == false) {//se não encontrou usuário e o nickname está vago,  vamos prosseguir com o registro
            //insere usuário
			 $mysqli->set_charset("utf8");
            $qry = "INSERT INTO usuario (usu_nome,usu_dt_cad,usu_nickname,usu_login,usu_senha,tipo_conta,cid_codigo) VALUES (?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('sssssii', $nome, date("Y-m-d"), $nickname, $login, sha1($password), $tipo_conta, $cidade); //registra o password encriptado!!	
            $stmt->execute();

            if ($stmt->affected_rows > 0) {//verifica se realmente foi registrado
//Após registro ==> Envia email/password para usuário, via e-mail
//após alterarmos a BD, vamos enviar o email
                require_once('php_mailer/EmailConfig.php');

// Setando o endereço de recebimento
                $mail->AddAddress($login, $nome);
                $mail->Subject = 'Sua nova conta foi criada: Veja os detalhes!';
                $mail->Body = utf8_encode("Seja bem-vindo! Conforme solicitado, criamos sua nova conta. Por favor, <strong>registre-a em algum lugar seguro</strong>
</br></br>
<strong>Login: </strong>$login</br>
<strong>Senha: </strong>$password</br></br>
Obrigado!
");
                $mail->AltBody = utf8_encode('Seja bem-vindo! Conforme solicitado, criamos sua nova conta. Por favor, registre-a em algum lugar seguro
 
Login:$login
Senha: $password
Obrigado!');
                $mail->send(); //envia e-mail para o usuario com sua senha
                $mail->ClearAllRecipients();



//Se criou com sucesso, vamos fazer login do usuário e redirecioná-lo para criação de currículo


//====================== LOGANDO USUÁRIO================================/
//redirecionando para vagas após criar conta.




if(!isset($_GET['loadafter']))//se não está passando página nenhuma para redirecionar depois
	{	
		
		//Se não for redirecionamento pós criação de conta rápida..
		
		
		if($tipo_conta == 1)//se é uma empresa
		{
		//login_user($login,$password,false,true,false,$tipo_conta,$receber_vagas);
			if($receber_vagas == 1)//se user quer receber vagas
				{
					require_once('funcoes/aweber_functions.php');
					switch($estado)
							{
										case '8'://Empresas --> ES
												registraaweber_redirecina('empresas_es',''.$redireciona_url.'?conta_criada=true',$nome,$login);
												exit;
										break;
										
										case '26'://Empresa --> SP
												registraaweber_redirecina('empresas_sp',''.$redireciona_url.'?conta_criada=true',$nome,$login);
												exit;
										break;		
							}
				
					//se não é nenhum dos outros dois...
						login_user($login,$password,false,true,false,$tipo_conta,false);
					
					
				}
				if($receber_vagas == 0)
				{
				login_user($login,$password,false,true,false,$tipo_conta,false);					
				}
			
				
				
		}
		if($tipo_conta == 0)//se é pessoa física..
			{
			//login_user($login,$password,false,true,false,$tipo_conta,$receber_vagas);	
				if($receber_vagas == 1)//se user quer receber vagas
				{
					require_once('funcoes/aweber_functions.php');
					switch($estado)
									{
										case '8'://PEssoa física --> ES
										if(isset($_GET['vaga_id']))
											{
											registraaweber_redirecina('empregue-me',''.$redireciona_url.'?conta_criada=true&vaga_id='.$_GET['vaga_id'],$nome,$login);		
											exit;
											}
												
											registraaweber_redirecina('empregue-me',''.$redireciona_url.'?conta_criada=true',$nome,$login);
												exit;
										break;
										
										case '14'://PEssoa física --> MG
										if(isset($_GET['vaga_id']))
											{
											registraaweber_redirecina('awlist3750990',''.$redireciona_url.'?conta_criada=true&vaga_id='.$_GET['vaga_id'],$nome,$login);		
											exit;
											}
												
											registraaweber_redirecina('awlist3750990',''.$redireciona_url.'?conta_criada=true',$nome,$login);
												exit;
										break;
										
										case '26'://PEssoa física --> SP
											if(isset($_GET['vaga_id']))
											{
											registraaweber_redirecina('empregueme_sp',''.$redireciona_url.'?conta_criada=true&vaga_id='.$_GET['vaga_id'],$nome,$login);		
											exit;
											}
										
										
											registraaweber_redirecina('empregueme_sp',''.$redireciona_url.'?conta_criada=true',$nome,$login);
												exit;
										break;		
									}
									
					//se não é nenhum dos outros dois...
					if(isset($_GET['vaga_id']))//se tem vaga pra redirecionar dps, redireciona
					{
					login_user($login,$password,false,true,$_GET['vaga_id'],$tipo_conta,false);
					exit;
					}
						login_user($login,$password,false,true,false,$tipo_conta,false);
				
				}
				if($receber_vagas == 0)
				{
					if(isset($_GET['vaga_id']))//se tem vaga pra redirecionar dps, redireciona
					{
					login_user($login,$password,false,true,$_GET['vaga_id'],$tipo_conta,false);
					exit;
					}	
					
					
				login_user($login,$password,false,true,false,$tipo_conta,false);					
				}
			
			
			
			
			}
	}
	else//agora, se tem o loadafter pq quer carregar
	{
		
		$url_redireciona = $_GET['loadafter'];

	
		login_user($login,$password,false,true,$url_redireciona);
	}



            }
        }
        ?>
        
        
   
		</body>
</html>