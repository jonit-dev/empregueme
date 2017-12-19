<?php
if (validation_errors()) {
    echo "<div class='validacoes'>" . validation_errors() . "</div>";
    echo br(2);
}

echo form_open_multipart('envioautomatico/setAdd');
echo form_hidden('user', $usuario);
//echo heading('Cadastro para envio automático de currículos',2);
?>
<label for="primeira opcao">Primeira Opção:</label>
<?php
$options_vag1 = array(' ' => 'Escolha uma vaga');
foreach ($tags as $tag) {
    $options_vag1[$tag->vag_tag] = $tag->vag_tag;
}
echo form_dropdown('vaga1', $options_vag1);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
echo br(2);
?>
<label for="segunda opcao">Segunda Opção:</label>
<?php
$options_vag2 = array(' ' => 'Escolha uma vaga');
foreach ($tags as $tag) {
    $options_vag2[$tag->vag_tag] = $tag->vag_tag;
}
echo form_dropdown('vaga2', $options_vag2);
echo br(2);
?>
<label for="terceira opcao">Terceira Opção:</label>
<?php
$options_vag2 = array(' ' => 'Escolha uma vaga');
foreach ($tags as $tag) {
    $options_vag2[$tag->vag_tag] = $tag->vag_tag;
}
echo form_dropdown('vaga3', $options_vag2);
echo br(2);
?>
<input type = "submit" value = "Cadastrar" style = "margin-left:30%;"/>
<?php echo form_close(); ?>