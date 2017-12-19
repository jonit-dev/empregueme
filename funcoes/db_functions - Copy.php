<?php

function mysqli_secure_query($var_to_validate)
//this functions secure the vars that will be send to database
{
	// Lista de palavras para procurar
	$check[1] = chr(34); // símbolo "
	$check[2] = chr(39); // símbolo '
	$check[3] = chr(92); // símbolo /
	$check[4] = chr(96); // símbolo `
	$check[5] = "drop table";
	$check[6] = "update";
	$check[7] = "alter table";
	$check[8] = "drop database";	
	$check[9] = "drop";
	$check[10] = "select";
	$check[11] = "delete";
	$check[12] = "insert";
	$check[13] = "alter";
	$check[14] = "destroy";
	$check[15] = "table";
	$check[16] = "database";
	$check[17] = "union";
	$check[18] = "TABLE_NAME";
	$check[19] = "1=1";
	$check[20] = 'or 1';
	$check[21] = 'exec';
	$check[22] = 'INFORMATION_SCHEMA';
	$check[23] = 'like';
	$check[24] = 'COLUMNS';
	$check[25] = 'into';
	$check[26] = 'VALUES';
	
	// Cria se as variáveis $y e $x para controle no WHILE que fará a busca e substituição
	$y = 1;
	$x = sizeof($check);
	// Faz-se o WHILE, procurando alguma das palavras especificadas acima, caso encontre alguma delas, este script substituirá por um espaço em branco " ".
	while($y <= $x){
		   $target = strpos($var_to_validate,$check[$y]);
			if($target !== false){
				$var_to_validate = str_replace($check[$y], "", $var_to_validate);
			}
		$y++;
	}


//faz alterações para evitar erro em BD
$new_var = strip_tags(addslashes(trim($var_to_validate)));
return $new_var;
}

 function stripslashes_array(&$arr) {
        foreach ($arr as $k => &$v) {
            $nk = stripslashes($k);
            if ($nk != $k) {
                $arr[$nk] = &$v;
                unset($arr[$k]);
            }
            if (is_array($v)) {
                stripslashes_array($v);
            } else {
                $arr[$nk] = stripslashes($v);
            }
        }
    }

function clean_stmt()
{
		  
	  //Fecha alguma consulta que eu possa ter esquecido aberta
	  if (isset($stmt))
	  {
		  $stmt->close();//fecha stmt
	  unset($stmt);	//deleta variável
	  }
		
}



function mysqli_full_connection($host,$username,$password,$db,$error_msg)
//THIS FUNCTION CONNECTS TO A DATABASE AND MANAGE SOME COMMONS ERRORS
{
	

@ $mysqli_handle = new mysqli($host,$username,$password,$db);//try to connect
			
			
			
	if ($mysqli_handle->connect_error)//if failed to connect to DB
	{

//first, show the error
echo '<strong>'.$error_msg.'</strong></br>';
echo 'ERROR CODE:'.$mysqli_handle->connect_errno.'</br>';//display error code
echo 'ERROR: '.$mysqli_handle->connect_error;//display msg	

//after, try to help user

		switch($mysqli_handle->connect_errno)
		{
			
		case 1044://acess denied for particular user
			echo "<p><em>POSSIBLE SOLUTION: Check if your user has permissions to acess $db</em></p>";
		break;	
			
		case 1045://acess denied
			echo "<p><em>POSSIBLE SOLUTION: Check if your username\password combination is 			right.	</em></p>";
		break;	
		case 1049://unknow database 
			echo "<p><em>POSSIBLE SOLUTION: Check if your database name is right.	</em></p>";
		break;	
	
	
	
		}
			
	}
	else//if we are connected
	{
		return $mysqli_handle;//return mysqli for handling
	}	
}




function prepare_for_db($array_with_vars)
{
for($i=0; $i<count($array_with_vars);$i++)
	{
		if (preg_match('/[0-9]+/',$array_with_vars[$i])) //se na string tem algum padrão numérico
			{
				
		$alphabet = range('a','z');
		for($s=0;$s<count($alphabet);$s++)
		{
			if (stristr($array_with_vars[$i],$alphabet[$s]))//se na nossa variável numerica tem algum tipo de letra
				{
					//echo 'Esse número tem letras no meio. Nao vou fazer nada';
				}
				else//agora, se é só número..acerte o valor!
				{
				doubleval($array_with_vars[$i]);	
				}
		}
				
			}
		
			//filtragem de strings...
			$array_with_vars[$i] = addslashes($array_with_vars[$i]);//adiciona / antes de enviar à DB (para segurança)	
			$array_with_vars[$i] = strip_tags($array_with_vars[$i]);//remove tags PHP ou HTML => podem ser maliciosas
			$array_with_vars[$i] = trim($array_with_vars[$i]);//remove espaços em branco
	}	
}



function avoid_sql_injection($array_inputs)//$array_with_vars = caracteres proibidos!, $string = string na qual eles não podem estar presentes!
{
	$array_with_vars=array("=","'","/",'"',">","<");//aqui ficam as arrays proibidas!
	
	for($i=0;$i<count($array_inputs);$i++)//loop através das arrays
		{
			//agora checa em cada uma dessas arrays se tem palavras proibidas usadas em SQL injection
			for($a=0;$a<count($array_with_vars);$a++)
				{
					if (stristr($array_inputs[$i],$array_with_vars[$a]))//se existe alguma palavra proibida em alguma das arrays analisadas
						{
							echo "A forbidden word was found in your search input field. Try again with a different value.";
							exit;				
						}
					
				}
			
		}
	
	
	/*
for($i=0;$i < count($array_with_vars);$i++)
{
		if (stristr($array_inputs[$i],$array_with_vars[$i]))
		{
		echo "You inserted a forbidden character on the form.";
		exit;	
		}
}*/
}

function get_user_id($login)
{
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database.');	
	
$qry = "SELECT userid FROM auth WHERE email=?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$login);	
$stmt->execute();
$stmt->bind_result($r_userid);

while($stmt->fetch())//enquanto houver resultado
{
	return $r_userid;
}

}



?>