<?php
//teste login

require_once('funcoes/top_functions.php');
       require_once('funcoes/db_functions.php');
        require_once('funcoes/email_functions.php');
        require_once('funcoes/url_functions.php');


require_once('funcoes/login_functions.php');


//cria conta fake
$login = 'joaopaulofurtado@hotmail.com';
$password = '32258190';

//conta fake criada acima


login_user($login,$password,false,true,'vaga.php?id=7');	

?>