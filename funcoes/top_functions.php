<?php




function newline($var=1)//função só pra criar novas linhas =D para economizar teclado. $var = numero de linhas para criar
{
	for($i=0;$i<$var;$i++)
		{
		echo "</br>";	
		}
}

function validate($array_with_vars)
//basic validation. check is its filled with something!
{
for($i=0;$i<count($array_with_vars);$i++)
	{
	  if(!isset($array_with_vars[$i]) || empty($array_with_vars[$i]))
	  	{
			return 1;//retorna 1 se está vazio
		}
		$strings_proibidas = array("=","//"); 
		
	for($a=0;$a<count($strings_proibidas);$a++)
		{//faz um loop pelas strings proibidas
			
				//verifica se a var tem tal string proibida
				if(stristr($array_with_vars[$i],$strings_proibidas[$a]))
				{
					return 2; //retorna 2 se tem caractere proibido	
				}	
		}
		
		
	}
}

function checa_vazio($array_with_vars,$array_with_array_names)
//basic validation. check is its filled with something!
{
	global $resultados_vazios;
		$resultados_vazios = "";
for($i=0;$i<count($array_with_vars);$i++)
	{
		
	  if(!isset($array_with_vars[$i]) || empty($array_with_vars[$i]))
	  	{
			$resultados_vazios .= $array_with_array_names[$i].', ';
			//echo $array_with_array_names[$i].', está vazia!</br>';
		}
	
		
	}
	
//remove última vírgula do resultado
$resultados_vazios = rtrim($resultados_vazios, ", ");


	
//se depois de tudo, não encontrar nada vazio, retorna false
if (strlen($resultados_vazios) == 0)
	{
		return false;
	}
else//se não estiver vazio, retorna a array
	{
		return true;	
	}
}



?>
