<?php

function convert_to_utf8($string)
{
	
//verifica se é UTF8
if (isUTF8($string)) { 
    return $string; //retorna como está mesmo
}
else//se nao for, converta!!
{
	$string = iconv("ISO-8859-1", "UTF-8//TRANSLIT", $string);
	return $string;
}
}


function isUTF8($string) {
    return (utf8_encode(utf8_decode($string)) == $string);
}



function remover($str){
  $remover = array("à" => "a","á" => "a","ã" => "a","â" => "a","é" => "e","ê" => "e","ì" => "i","í" => "i","ó" => "o","õ" => "o","ô" => "o","ú" => "u","ü" => "u","ç" => "c","À" => "A","Á" => "A","Ã" => "A","Â" => "A","É" => "E","Ê" => "E","Í" => "I","Ó" => "O","Õ" => "O","Ô" => "O","Ù" => "U","Ú" => "U","Ü" => "U"," " => " ");
  return strtoupper(strtr($str, $remover));
 }



?>