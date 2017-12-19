<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
/*---------- DEBUG FUNCTIONS ------------*/
function dump_array($array)
{//echoes array content
	foreach($array as $key => $value)
		{
		echo $key." => ".$value;
		echo "</br>";	
		}
}
function tag_search($tag_array,$title)
{
/*
//Função: procura a TAG mais parecida, dentro de uma array de tags
EXEMPLO DE USO

$tag_array = array ("Hiphone 5s","iphone 5s","iphone 2","Nokia L3 4","LG optimus","LUMIA");
$title = "apple iphone 5s barato";

echo tag_search($tag_array,$title);

*/	
	
	
//primeiro coloca os argumentos em capslock
for($i=0;$i<count($tag_array);$i++)
	{
		$tag_array[$i] = strtoupper($tag_array[$i]);
	}

$title = strtoupper($title);//coloca titulo em maiusculo

$result = array();//vamos criar uma array para os resultados



//a primeira ação é verificar se já existe a tag. se sim, associa logo de cara e encerra o script. se não, 



//agora vamos comparar
for($i=0;$i<count($tag_array);$i++)
	{
	similar_text($tag_array[$i],$title,$percent);
	array_push($result,$percent);

	}

$tag_mais_parecida =  max($result);
//primeiro, vamos verificar se o resultado não tem nada a ver com nada
if($tag_mais_parecida < 50)
{
	
echo "O produto que você deseja anunciar é o:";

}

for($i=0;$i<count($result);$i++)
	{
		if($tag_mais_parecida == $result[$i])//procura qual a KEY do resultado mais similar
			{
					return $tag_array[$i];
			
			
			}
	}

}
$string = "mini galaxy frete grátis";
$tags = array("IPHONE 5S","GALAXY S3","LG OPTIMUS","IPHONE 2","IPHONE 3");





?>
</body>
</html>