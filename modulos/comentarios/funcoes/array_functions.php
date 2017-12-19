<?php

/*ARRAY HANDLING FUNCTIONS*/

function array_delete_element($element,$array)
{
	foreach (array_keys($array, $element) as $key) {
    unset($array[$key]);
	return $array;//retorna array modificada	
}
	
}

/*-----*/



/*---------- DEBUG FUNCTIONS ------------*/
function dump_array($array)
{//echoes array content
	foreach($array as $key => $value)
		{
		echo $key." => ".$value;
		echo "</br>";	
		}
}

function dump_network()
{
echo '$_GET</br>';
if (isset($_GET))
{
dump_array($_GET);
echo '#####</br>';
}

if (isset($_POST))
{
echo '$_POST</br>';
dump_array($_POST);
echo '#####</br>';
}

if (isset($_SESSION))
{
echo '$_SESSION</br>';
dump_array($_SESSION);
echo '#####</br>';
}

if (isset($_COOKIE))
{
echo '$_COOKIE</br>';
dump_array($_COOKIE);
echo '#####</br>';
}
	}//end function
/*------------ end debug functions -----------------*/


?>