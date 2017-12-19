<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FoodCast :: Cadastro de Pratos</title>

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

<script type="text/javascript">
$(document).ready(function(e) {
   
   	//preço
	 	$(".dinheiro").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
    
});
</script>

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
	
	
	//carrega restaurantes disponíveis
$qry = "SELECT r.rst_id, r.rst_nome FROM restaurantes as r";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($rst_id,$rst_nome);
$html_r = "";
while($stmt->fetch())
	{
		$html_r .= '<option value="'.$rst_id.'">'.$rst_nome.'</option>';
		
	}
	
	$stmt->close();
	
	
	
	

?>




<h1>Painel Administrativo - FoodCast</h1>

<?php


//-------------------------- CADASTRO DE NOVO RESTAURANTE ------------------------------//

//pega variaveis passadas por post

if(!empty($_POST))
	{
$pr_nome = mysqli_secure_query($_POST['pr_nome']);		
$pr_restaurante = mysqli_secure_query($_POST['pr_restaurante']);
$pr_categoria = mysqli_secure_query($_POST['pr_categoria']);	
$pr_descricao = mysqli_secure_query($_POST['pr_descricao']);
$pr_preco = mysqli_secure_query($_POST['pr_preco']);

//ajusta_preco
$pr_preco = str_ireplace("R$ ","",$pr_preco);

$campos_vazios = '';//armazena resultados vazios
foreach($_POST as $key => $value)
	{
	
	switch($key)
		{
			case 'pr_nome':
			if(empty($value))
				{
				$campos_vazios .= "Nome,";
				}
			break;
			case 'pr_categoria':
						if(empty($value))
				{
				$campos_vazios .= "Categoria,";
				}
			break;
			case 'pr_restaurante':
						if(empty($value))
				{
				$campos_vazios .= "Restaurante,";
				}
			break;
		
		
			
		}
	}
	
	//ajusta string campos_vazios
	$campos_vazios = rtrim($campos_vazios,',');
	
//vamos verificar se há algum campo vazio
if(strlen($campos_vazios) > 0)
	{
		echo '<p><span class="error">Erro no cadastro do prato: Os seguintes campos obrigatórios estão vazios: '.$campos_vazios."</span></p>";
	}
	
		else//prossegue com cadastro do prato
		{
			//primeiro, o mais importante!
			
			//tenta cadastrar a foto
			
			$insere_registros = true;
			
	//primeiro verifica se a logomarca foi enviada
	if($_FILES["pr_foto"]['size'] > 0)
	{
	//	echo "Salvando logomarca...";
		$file_temp_path = $_FILES["pr_foto"]["tmp_name"];
		
		  require_once('../classes/SimpleImage.php');
        $image = new SimpleImage();
        $image->load($file_temp_path);
//essa variável armazena aonde iremos salvar o arquivo de foto
				$image->resize(417, 417,'y');
				
				
	
		}
		else//se o tamanho do arquivo for = 0 ... é pq nao enviou a foto!
			{
	echo '<p><span class="error">Envie a foto do prato para cadastrá-lo! Tente novamente.</span></p>';
$insere_registros = false; //impede o sistema de inserir o registro do prato			
			}
			
			
	if($insere_registros == true)
	{		
			//se tudo estiver ok com a foto, prossegue com o registro na base de dados...
			
		$qry = "INSERT INTO pratos VALUES (null, ?, ?, ?, 0, 0, 0, ?, ?)";	
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('sdiis',$pr_nome,$pr_preco,$pr_restaurante,$pr_categoria,$pr_descricao);
		$stmt->execute();
		$prato_id = $mysqli->insert_id;
		if($stmt->affected_rows >= 1)
			{
//se tudo foi registrado com sucesso, mostra mensagem de sucesso!
echo '<p><span class="sucesso">Prato cadastrado com sucesso!</span></p>';	


//finaliza registro da foto do prato
				$file_path = "../gfx/pratos/";
				$uploaded_file = $file_path . "prato_" . $prato_id. ".png";
	
                $image->save($uploaded_file,IMAGETYPE_PNG,25); //salva no lugar da foto original (substitui)

			}
			else
			{
echo '<p><span class="error">Algum erro ocorreu no cadastro do novo prato. Favor verificar</span></p>';	
				
			}
			
	}//end insere registros
		
			
			
			
			
			
			
			
			
	

	}//end form post
	
	}//end else
	
?>




<h2>Cadastre um Novo Prato</h2>

<?php

//------------------------- FORMULARIO CADASTRO DE RESTAURANTE-----------------------------------//

echo '
<form action="cadastro_prato.php" method="post" enctype="multipart/form-data">

	<ul style="list-style:none;">
    	<li>
        	<label for="pr_nome"><strong>Nome do Prato </strong></label>
        	<input type="text" name="pr_nome" value="" /><span class="obrigatorio">* Obrigatório</span>
        </li>
		
		<li>
        	<label for="pr_restaurante"><strong>Restaurante:</strong></label>
				<select name="pr_restaurante">'.$html_r.'</select>
	        </li>
		
		<li>
		<label for="pr_foto"><strong>Foto do prato:</strong></label>
        	<input type="file" name="pr_foto"/>
			
		</li>
		
		<li>
        	<label for="pr_categoria"><strong>Categoria</strong></label>
        	<select name="pr_categoria">
				'.$html_tc.'
			</select><span class="obrigatorio">* Obrigatório</span>
        </li>
		
		<li>
        	<label for="pr_descricao"><strong>Descrição</strong></label><br />
        	<textarea name="pr_descricao" rows="4" cols="50"></textarea>
        </li>
		
			<li>
        	<label for="pr_preco"><strong>Preço</strong></label>
        	<input type="text" class="dinheiro" name="pr_preco" value="0.00"/><span class="obrigatorio">Deixe 0 caso não saiba!</span>
       		</li>
					
			<input type="submit" value="Cadastrar Prato"/>
			

</form>
';



?>



</body>
</html>