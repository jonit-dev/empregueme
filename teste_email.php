<?php
require_once('funcoes/verificar_email_valido.php');

$email =  verifyEmail('joaopaulofurtado@live.com','joaopaulofurtado@live.com');

echo $email;
?>