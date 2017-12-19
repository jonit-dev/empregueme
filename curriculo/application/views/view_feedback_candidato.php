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
// Formato 24 horas (de 1 a 24)
$hora = date('G');
if (($hora >= 0) AND ($hora < 12)) {
    $mensagem = "Bom dia ";
} else if (($hora >= 12) AND ($hora < 18)) {
    $mensagem = "Boa tarde ";
} else {
    $mensagem = "Boa noite ";
}
echo img('assets/images/logo.png');
echo "<p>" . $mensagem . $usuario->usu_nome . ", você enviou um currículo para a vaga de " . $vaga->vag_nome . ". Estamos enviando esse e-mail para lhe informar que seu currículo foi visualizado pela empresa. O feedback dela foi o seguinte:</p>";
if ($feedbacks) {
    foreach ($feedbacks as $feedback) {
        echo "<p><strong>" . $feedback->descricao . "</strong></p>";
    }
}
echo "<p><strong>" . $usuario->usu_nome . " quer ter até 17x mais chances de conseguir um emprego? <a href='http://empregue-me.com/novo/membro_vip.php' target='_blank'>Clique aqui e confira essa oportunidade</a></strong></p>";
echo "<p>Atenciosamente,</p>";
echo "<p>Equipe empregue-me.</p>";
echo "</body>";
echo "</html>";
?>


