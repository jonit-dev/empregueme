<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../funcoes/db_functions.php');

//pega variaveis passadas por post
//$email = mysqli_secure_query($_POST['email']);
//$senha = mysqli_secure_query($_POST['senha']);
$nome_prato = mysqli_secure_query($_POST['nome_prato']);
$preco_prato = mysqli_secure_query($_POST['preco_prato']);
$nome_restaurante = mysqli_secure_query($_POST['nome_restaurante']);
$user_latitude = mysqli_secure_query($_POST['user_latitude']);
$user_longitude = mysqli_secure_query($_POST['user_longitude']);
$avaliacao_restaurante = mysqli_secure_query($_POST['avaliacao_prato']);
$categoria_prato = mysqli_secure_query($_POST['categoria_prato']);

//realiza validação de dados

//joga tudo para uma array e começa a verificar se dados estão totalmente preenchidos ou são maior que 3 caracteres
$dados = array($nome_prato,$preco_prato,$nome_restaurante,$avaliacao_restaurante);
$nomes_dados = array("Nome do Prato","Preço do Prato","Nome do Restaurante","Avaliação do Restaurante");
$tem_campo_vazio = false;
		$campos_vazios = "";
for($i=0;$i<count($dados);$i++)
	{
		
		if(empty($dados[$i]))//caso esteja vazio 
			{
				$tem_campo_vazio = true;
				$campos_vazios .= $nomes_dados[$i].", ";
			}
			
	}
	if($tem_campo_vazio == true)
		{
			$campos_vazios = rtrim($campos_vazios,", ");
			echo "Não foi possível cadastrar a foto do seu prato. Os seguintes campos estão vazios: ".$campos_vazios."";		
			exit;
		}
		
if (empty($user_latitude) || empty($user_longitude))
	{
		echo "Não foi possível cadastrar a foto do seu prato pois os dados de localização estão nulos. Verifique se se GPS encontra-se ligado.";		
			exit;
		
	}


//Validação da foto!
//aqui

//SE ESTA TUDO CERTO, VAMOS INSERIR O PRATO
//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");


$qry = "INSERT INTO pratos VALUES(null, ?, ?, ?, ?, ?, ?, ?, 0)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('sdsddii',$nome_prato,$preco_prato,$nome_restaurante,$user_latitude,$user_longitude,$avaliacao_restaurante, $categoria_prato);
$stmt->execute();
$id_prato = $mysqli->insert_id;//armazena ID do prato em uma variável

if($stmt->affected_rows >= 1)
	{
		//se inseriu na base de dados corretamente...
		//vamos prosseguir com o registro dos arquivos	
		$new_image_name = "prato_".$id_prato.".jpeg";//especifica nome de arquivo de acordo com a id do registro na tablea
		move_uploaded_file($_FILES["file"]["tmp_name"], "../gfx/pratos/".$new_image_name);//salva arquivo em folder em particular

				
						$mensagem = "Foto enviada com sucesso";
						echo $mensagem;	
	}
else//se nao inseriu o prato, vamos retornar mensagem de erro ao cliente	
	{
		echo "Não foi possível registrar a foto do prato em nosso sistema. Por favor, tente novamente";
	}


				


?>