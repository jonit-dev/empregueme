<?php
//CHECK VALIDATION
function checkurl($url)
{
  return filter_var($url, FILTER_VALIDATE_URL);//if it's valid it return TRUE else FALSE
}


 // verifica se um esta esta de escrito de forma correta
function validarCep($cep) {
    // retira espacos em branco
    $cep = trim($cep);
    // expressao regular para avaliar o cep
    $avaliaCep = ereg("^[0-9]{5}[0-9]{3}$", $cep);
    
    // verifica o resultado
    if(!$avaliaCep) {            
        return false;
    }
    else
    {
		return true;
    }
}

?>