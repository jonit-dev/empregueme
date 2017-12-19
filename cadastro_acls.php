<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro ACLS</title>


<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<!--Máscara telefone-->
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<!--gerencia js-->
<script type="text/javascript" src="js/cadastro_acls.js"></script>
</head>

<body>
<h1>Pré-inscrição no ACLS</h1>

<p> <b>Preencha seus dados abaixo e um de nossos colaboradores irá entrar em contato o mais breve possível.</b></p>

<?php
require_once('funcoes/db_functions.php');
require_once('funcoes/email_functions.php');
if(isset($_POST['input_nome']))//Se usuário está tentando cadastrar
	{
		//vamos tratar e validar os dados
		$user_nome = mysqli_secure_query($_POST['input_nome']);
		$user_email = mysqli_secure_query($_POST['input_email']);
		$user_telefone = mysqli_secure_query($_POST['input_telefone']);
		
		$tem_erro = false;
		//Validação de campos do formulário
		if(empty($user_nome) || strlen($user_nome) < 4)
			{
				echo "<p style='color:red;'>Por favor, insira seu nome completo.</p>";
				$tem_erro = true;
			}
		
		if(!check_email_address($user_email))
			{
					echo "<p style='color:red;'>E-mail inválido. Verifique se há algum erro de digitação ou tente inserir outro e-mail.</p>";
			$tem_erro = true;
			}
		
		if(empty($user_telefone))
			{
					echo "<p style='color:red;'>Por favor, insira seu telefone.</p>";
		$tem_erro = true;
			}
			
			
			
			if($tem_erro == false)//prossiga se não houver erros na validação
			{
		//após tudo validado, vamos iniciar a inserção na base de dados	
		$mysqli = mysqli_full_connection();
		$mysqli->set_charset("utf8");
		$qry = "INSERT INTO leads_acls VALUES (null,?,?,?)";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('sss',$user_nome,$user_email,$user_telefone);
		$stmt->execute();
		
		if($stmt->affected_rows > 0)
			{
								echo "<p style='color:green;'>Cadastro inserido com sucesso!</p>";
							
						
			}
			else
				{
									echo "<p style='color:red;'>Erro ao registrar em base de dados. Tente novamente ou envie sua solicitação para joaopaulofurtado@live.com</p>";
								
									
				}
		
			}//end if !$tem_erro
		
	}



?>

<form action="cadastro_acls.php" method="post">
<ul style="list-style:none;">
	<li style="margin-top:10px;">
      <label for="input_nome">Nome: 
          <input type="text" name="input_nome" placeholder="Insira seu nome completo" />
      </label>
    </li>
	<li style="margin-top:10px;">
      <label for="input_email">E-mail: 
          <input type="email" name="input_email" placeholder="Insira um e-mail válido" />
      </label>
    </li>
    
    <li style="margin-top:10px;">
      <label for="input_telefone">Telefone Celular: 
          <input type="tel" name="input_telefone" placeholder="Insira seu telefone" />
      </label>
    </li>





</ul>



<input type='submit' style="margin-left:20%;" value="Cadastrar" />

</form>


</body>
</html>