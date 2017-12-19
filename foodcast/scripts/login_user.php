<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');

//pega variaveis passadas por post
$email = mysqli_secure_query($_POST['email']);
$senha = mysqli_secure_query($_POST['senha']);


//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");

$qry = "SELECT usu_login FROM usuario WHERE usu_login = ?";//primeiro verifica se o usuário existe.
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$email);
$stmt->execute();
$stmt->bind_result($r_usu_login);

$user_existe = false;
while($stmt->fetch())
	{
		$user_existe = true;	
	}
	
if($user_existe == true)//se tem o usuário
	{
		
		//faz outra requisição e verifica se o usuário x senha correspondem
		
		$qry = "SELECT usu_login, user_id, cid_codigo, usu_nome, usu_nickname, usu_dt_cad, usu_telefone,usu_celular,
		usu_cep, usu_tipo_conta FROM usuario WHERE usu_login = ? AND usu_senha = ?";//primeiro verifica se o usuário existe.
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('ss',$email,sha1($senha));
		$stmt->execute();
		$stmt->bind_result($r_usu_login,$r_user_id,$r_cid_codigo,$r_usu_nome,$r_usu_nickname,$r_usu_dt_cad,$r_usu_telefone,$r_usu_celular,$r_usu_cep,$r_usu_tipo_conta);
		$tem_resultado = false;
			while($stmt->fetch())
				{
					$tem_resultado = true;
					if($tem_resultado == true)
					{
						//login com sucesso! Carregue os dados do servidor!
							//enviar array com dados de login do usuário
							
										
							$dados_usuario = array(
							'USER_LOGIN'=>$r_usu_login,
							'USER_ID'=>$r_user_id,
							'USER_CIDADE'=>$r_cid_codigo,
							'USER_NOME'=>$r_usu_nome,
								'USER_NICKNAME'=>$r_usu_nickname,
								'USER_DT_CAD'=>$r_usu_dt_cad,
								'USER_TELEFONE'=>$r_usu_telefone,
								'USER_CELULAR'=>$r_usu_celular,
								'USER_CEP'=>$r_usu_cep,
								'USER_TIPO_CONTA'=>$r_usu_tipo_conta
							);
							
							echo json_encode($dados_usuario);
					}
					
					
				}
				
					if(!$tem_resultado)
					{
						$mensagem = array(
							'ERROR_MSG'=>'Combinação e-mail x senha incorreta. Por favor, tente novamente!'
						);
						echo json_encode($mensagem);	
					}
		

	}
if($user_existe == false)
	{
					$mensagem = array(
							'ERROR_MSG'=>'O e-mail inserido não está registrado em nossa base de dados. Por favor, verifique se digitou algo errado ou crie uma nova conta.'
						);
						echo json_encode($mensagem);
		

	}





?>