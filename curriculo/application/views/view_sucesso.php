<?php
echo doctype('html5');
echo "<html>";
echo "<head>";
echo "<title>Currículo cadastrado com sucesso</title>";
$meta = array(
    array('name' => 'description', 'content' => 'Currículo cadastrado pelo site do empregue-me'),
    array('name' => 'keywords', 'content' => 'curriculo, empregos, oferta de vagas'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);
echo meta($meta);
echo link_tag(array('href' => 'assets/css/cadastro.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'assets/css/vip.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo "</head>";
echo "<body>";
echo "<center>";
//echo img('assets/images/logo.png');
echo $sucesso;
echo "</center>";
echo "</body>";
echo "</html>";
?>


