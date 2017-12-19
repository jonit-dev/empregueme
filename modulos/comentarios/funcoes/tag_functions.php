<?php

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

$result = array();

//agora vamos comparar
for($i=0;$i<count($tag_array);$i++)
	{
	similar_text($tag_array[$i],$title,$percent);
	array_push($result,$percent);

	}

$tag_mais_parecida =  max($result);

for($i=0;$i<count($result);$i++)
	{
		if($tag_mais_parecida == $result[$i])//procura qual a KEY do resultado mais similar
			{
			return $tag_array[$i];
			
			
			}
	}

}

?>

</body>
</html>