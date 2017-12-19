<?php
function concerta_preco($preco_virgem)
	{
	$preco_virgem = str_ireplace("R$ ","",$preco_virgem);
$preco_virgem = str_ireplace(".","",$preco_virgem);
$data = explode(",",$preco_virgem);
settype($data[0],"float");
settype($data[1],"float");
$data[1] = ($data[1]/100);

$preco = $data[0]+$data[1];	
return $preco;
	}
?>