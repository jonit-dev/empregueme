<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');

$inicio = mysqli_secure_query($_POST['inicio']);//secure var
$fim = mysqli_secure_query($_POST['fim']);//secure var


require_once('../funcoes/constroi_curriculos_dinamicamente.php');

if(isset($_POST['query']))//se recebemos o $_POST['query'] é porque a var veio de script de busca. vamos associá-la a uma var para usá-la adiante
{
	
$query = $_POST['query'];//secure var	
$output = carrega_e_constroi_cv($inicio,$fim,$query);

}
else//se nao foi passado a var query por post, vamos prosseguir com o carregamento padrão das vagas
{

$output = carrega_e_constroi_cv($inicio,$fim,'padrao');

}
			
echo $output;//envia o html das novas vagas carregadas, ao usuário	
	


?>