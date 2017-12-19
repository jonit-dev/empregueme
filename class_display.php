<?php

class display {

    function top() {
        require_once('funcoes/url_functions.php');
        echo '	
	 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Empregue-me: A maior Rede Social Profissional do Brasil</title>
<meta name="description" content="Acesse o Empregue-me gratuitamente e fique por dentro de milhares oportunidades anunciadas em seu estado!" />
<meta name="keywords" content="empregos, oportunidades, vagas, anunciar vagas es, anunciar vagas sp, trabalho no es, trabalho em es, trabalhar em vitória, empregos em vitória, empregos es" />
<meta name="author" content="Empregue-me"
<meta name="robots" content="index, follow" />

<style type="text/css">
@import url(\'css/reset.css\');
@import url(\'fonts/lato.css\');
</style>


<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>


';
    }

    function fundo() {
        echo '</body></html>';
    }
}

?>