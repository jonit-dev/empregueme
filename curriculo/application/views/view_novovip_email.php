<?php
echo doctype('html5');
echo "<html>";
echo "<head>";
echo "<title>Bem-vindo membro VIP</title>";
$meta = array(
    array('name' => 'description', 'content' => 'Bem vindo ao plano membro VIP do empregue-me'),
    array('name' => 'keywords', 'content' => 'vip, empregue-me,empregos'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);
echo meta($meta);
echo link_tag(array('href' => 'assets/css/cadastro.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'assets/css/vip.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "</head>";
echo "<body>";
echo img('assets/images/logo.png');
echo $sucesso;
echo "</body>";
echo "</html>";
?>


