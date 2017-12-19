<?php
if (validation_errors()) {
    echo "<div class='validacoes'>" . validation_errors() . "</div>";
}
if ($mensagem) {
    echo "<div class='validacoes'>Ocorreu um erro, tente novamente</div>";
}
echo form_open_multipart('curriculo/setAdd');
echo form_hidden('user', $usuario);
?>
<p>Preencha abaixo seu currículo!<strong><span class="special"> Os campos marcados com * são obrigatórios e os que não possuem tal marcação podem ser deixados em branco.</span></strong> Aconselhamos que você <strong>preencha seu currículo da forma mais completa possível </strong>para que as empresas consigam encontrar suas informações com facilidade!</p>

<p><span class="planos">Informações básicas</span></p>

<label for="nome">Nome completo:</label>
<?php
$dados = array(
    'name' => 'usu_nome',
    'width' => '400px',
    'placeholder' => 'Digite aqui seu nome',
    'value' => set_value('usu_nome')
);
echo form_input($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />

<label for="sexo">Sexo:</label>
<span class="radio">
    <input type="radio" name="usu_sexo" value="Masculino" />Masculino
    <input type="radio" name="usu_sexo" value="Feminino" />Feminino
</span>
<?php
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
echo br(1);
?>

<label for="idade">Idade:</label>
<?php
$idade = array(
    '' => 'Selecione uma opção'
);
for ($i = 14; $i <= 150; $i++) {
    $idade[$i] = $i;
}
echo form_dropdown('usu_idade', $idade);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="estado">Estado:</label>
<?php
$options_est = array('' => 'Escolha o estado');
foreach ($estados as $estado) {
    $options_est[$estado->cod_estados] = $estado->nome;
}
echo form_dropdown('estado', $options_est);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<label for="cidade">Cidade:</label>
<?php
echo form_dropdown('cidade', array('' => 'Escolha a cidade'), '', 'id="cidade"');
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="email">E-mail de contato:</label>
<?php
$dados = array('name' => 'email', 'value' => set_value('email'));
echo form_input($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="bairro">Bairro:</label>
<?php
$dados = array('name' => 'usu_bairro', 'id' => 'usu_bairro', 'value' => set_value('usu_bairro'));
echo form_input($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="telefone">Telefone para contato:</label>
<?php
$dados = array('name' => 'usu_telefone1', 'value' => set_value('usu_telefone1'), 'type' => 'tel');
echo form_input($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="telefone">Telefone para contato 2:</label>
<?php
$dados = array('name' => 'usu_telefone2', 'value' => set_value('usu_telefone2'), 'type' => 'tel');
echo form_input($dados);
?>
<br />    
<label for="perfilfacebook">Link do perfil no facebook:</label>
<?php
$dados = array(
    'name' => 'usu_link_facebook',
    'style' => 'width:300px;',
    'placeholder' => 'Exemplo: www.facebook.com/joanadasilva',
    'value' => set_value('usu_link_facebook')
);
echo form_input($dados);
?>
<div id="photo">
    <?php echo img('./assets/images/Moonify_UI_03.png'); ?>
    <br />

    <span class="radio">Enviar foto:<?php echo form_upload('userfile'); ?>
</div>

<p><span class="planos">Objetivo Profissional</span></p>
<p>Descreva qual é seu objetivo profissional:</p>
<?php
$dados = array(
    'name' => 'objetivo',
    'id' => 'objetivo',
    'rows' => '4',
    'cols' => '100',
    'maxlength' => '300',
    'style' => 'width:400; height:200;',
    'placeholder' => 'Deixe claro o seu objetivo profissional. Cuidado com exageros: antes de enviar seu perfil a um empregador, decida BEM o que você quer fazer e em que área quer atuar. Máximo de 300 caracteres.'
);
echo form_textarea($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<p><span class="planos">Formação</span></p>
<label for="area">Informe sua área profissional:</label>
<?php
$dados_area[''] = 'Selecione sua área profissional';
foreach ($areas as $area) {
    $dados_area[$area->id] = $area->descricao;
}
echo form_dropdown('fk_area_formacao', $dados_area);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="area">Informe uma categoria de interesse:</label>
<?php
$dados_categoria[''] = 'Selecione uma categoria';
foreach ($categorias as $categoria) {
    $dados_categoria[$categoria->cat_codigo] = $categoria->cat_nome;
}
echo form_dropdown('fk_categoria_codigo', $dados_categoria);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<label for="nivel_escolaridade">Informe seu nível de escolaridade:</label>
<?php
$dados_escolaridade[''] = 'Seleciona seu nível de escolaridade';
foreach ($escolaridades as $escolaridade) {
    $dados_escolaridade[$escolaridade->id] = $escolaridade->descricao;
}
echo form_dropdown('fk_escolaridade_formacao', $dados_escolaridade);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<br />
<br />
<p>Os campos abaixo são opcionais, preencha  digitando  qual curso fez, quando começou e terminou e em qual instituição.</p>
<label for="curso1">Curso:</label>
<?php
$dados = array(
    'name' => 'curso1',
    'style' => 'width:250px;',
    'placeholder' => 'Ex. Técnico de Informática',
    'value' => set_value('curso1')
);
echo form_input($dados);
?>
<label for="curso1_inicio">Início:</label>
<?php
$ano[''] = 'Ano';
for ($i = 1950; $i <= date('Y'); $i++) {
    $ano[$i] = $i;
}
echo form_dropdown('curso1_inicio', $ano, set_value('curso1_inicio'));
?>

<label for="curso1_termino">Término:</label>
<?php
echo form_dropdown('curso1_termino', $ano, set_value('curso1_termino'));
?>

<label for="curso1_instituicao">Instituição:</label>
<?php
$dados = array(
    'name' => 'curso1_instituicao',
    'value' => set_value('curso1_instituicao')
);
echo form_input($dados);
echo br(1);
?>
<label for="curso2">Curso:</label>
<?php
$dados = array(
    'name' => 'curso2',
    'style' => 'width:250px;',
    'placeholder' => 'Ex. Pós Graduação',
    'value' => set_value('curso2')
);
echo form_input($dados);
?>
<label for="curso2_inicio">Início:</label>
<?php
echo form_dropdown('curso2_inicio', $ano, set_value('curso2_inicio'));
?>

<label for="curso2_termino">Término:</label>
<?php
echo form_dropdown('curso2_termino', $ano, set_value('curso2_termino'));
?>

<label for="curso2_instituicao">Instituição:</label>
<?php
$dados = array(
    'name' => 'curso2_instituicao',
    'value' => set_value('curso2_instituicao')
);
echo form_input($dados);
?>        
<br />
<p><span class="planos">Habilidades</span></p>

<label for="ingles">Sabe falar inglês?</label>
<span class="radio">
    <input type="radio" name="ingles" value="1" />Sim
    <input type="radio" name="ingles" value="0" />Não
    <?php echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>"; ?>
    <label for="ingles_nivel">Nível:</label>        
    <?php
    $nivel_ingles = array(
        '' => 'Selecione uma opção (opcional)',
        'Básico' => 'Básico',
        'Intermediário' => 'Intermediário',
        'Avançado' => 'Avançado',
    );
    echo form_dropdown('ingles_nivel', $nivel_ingles, set_value('ingles_nivel'));
    ?>
</span>
<br />
<label for="informatica">Tem conhecimento em informática (Pacote Office)?</label>
<span class="radio">
    <input type="radio" name="informatica" value="1" />Sim
    <input type="radio" name="informatica" value="0" />Não
    <?php echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>"; ?>
    <label for="informatica_nivel">Nível:</label>
    <?php
    $informatica_nivel = array(
        '' => 'Selecione uma opção (opcional)',
        'Básico' => 'Básico',
        'Intermediário' => 'Intermediário',
        'Avançado' => 'Avançado',
    );
    echo form_dropdown('informatica_nivel', $informatica_nivel, set_value('informatica_nivel'));
    ?> 
</span>
<p><strong>Outras habilidades (Opcional):</strong></p>
<label for="habilidade1">Habilidade:</label>
<?php
$dados = array(
    'name' => 'habilidade1',
    'style' => 'width:200px;',
    'placeholder' => 'Ex. Curso de Libras',
    'value' => set_value('habilidade1')
);
echo form_input($dados);
?>

<label for="habilidade1_inicio">Início:</label>
<?php
echo form_dropdown('habilidade1_inicio', $ano, set_value('habilidade1_inicio'));
?>

<label for="habilidade1_termino">Término:</label>
<?php
echo form_dropdown('habilidade1_termino', $ano, set_value('habilidade1_termino'));
?>
<label for="habilidade1_instituicao">Instituição:</label>
<?php
echo form_input('habilidade1_instituicao');
?>
<br />
<label for="habilidade2">Habilidade:</label>
<?php
$dados = array(
    'name' => 'habilidade2',
    'style' => 'width:200px;',
    'placeholder' => 'Ex. Curso Avançado de Excel',
    'value' => set_value('habilidade2')
);
echo form_input($dados);
?>

<label for="habilidade2_inicio">Início:</label>
<?php
echo form_dropdown('habilidade2_inicio', $ano, set_value('habilidade2_inicio'));
?>

<label for="habilidade2_termino">Término:</label>
<?php
echo form_dropdown('habilidade2_termino', $ano, set_value('habilidade2_termino'));
?>
<label for="habilidade2_instituicao">Instituição:</label>
<?php
echo form_input('habilidade2_instituicao');
?>
<br />

<p><strong>Marque as opções compatíveis com seu currículo:</strong></p>

<input type="checkbox" name="cnh[]" value="A" />CNH A 
<input type="checkbox" name="cnh[]" value="B" />CNH B
<input type="checkbox" name="cnh[]" value="C" />CNH C
<input type="checkbox" name="cnh[]" value="D" />CNH D
<br />
<input type="checkbox" name="disponivel_viagem" value="1"  />Disponível para viagem <br />
<br />
<label for="horario_disp">Disponibilidade de horário:</label>
<input type="checkbox" name="horario_disp[]" value="Manhã"/>Manhã
<input type="checkbox" name="horario_disp[]" value="Tarde"/>Tarde
<input type="checkbox" name="horario_disp[]" value="Noite"/>Noite
<?php echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>"; ?>
</br>

<label for="pretensao">Pretensão salarial:</label>
<?php
$dados = array(
    'name' => 'pretensao_salarial',
    'id' => 'pretensao_salarial',
    'placeholder' => 'Caso não tenha pretensão salarial digite 0.',
    'style' => 'width:290px'
);
echo form_input($dados);
echo "<span id='campo_obrigatorio'>* Campo obrigatório</span>";
?>
<p><span class="planos">Histórico profissional</span></p>
<p>Aqui você deve informar sobre sua experiência profissional passada.</p>

<fieldset>
    <label for="empresa1_nome">Empresa em que trababalhou:</label>
    <?php
    $dados = array(
        'name' => 'empresa1_nome',
        'placeholder' => 'Digite o nome da empresa',
        'style' => 'width:200px'
    );
    echo form_input($dados);
    ?>
    <br />
    <label for="empresa1_ano">Ano em que trabalhou:</label>
    <?php
    echo form_dropdown('empresa1_ano', $ano, set_value('empresa1_ano'))
    ?>
    <br />
    <label for="empresa1_periodo">Por um perído de:</label>
    <?php
    $periodo[''] = 'Período';
    for ($i = 1; $i <= 50; $i++) {
        $periodo[$i] = $i;
    }
    echo form_dropdown('empresa1_periodo_valor', $periodo, set_value('empresa1_periodo_valor'));

    $periodo_tempo = array(
        'meses' => 'meses',
        'anos' => 'anos'
    );
    echo form_dropdown('empresa1_periodo_tempo', $periodo_tempo, set_value('empresa1_periodo_tempo'));
    ?>
    <br />
    <label for="empresa1_cargo">Seu cargo:</label>
    <?php
    $dados = array(
        'name' => 'empresa1_cargo',
        'placeholder' => 'Que função você ocupava?',
        'style' => 'width:200px'
    );
    echo form_input($dados);
    ?>
    <br />
    <label for = "empresa1_responsabilidades">Faça uma breve descrição das suas responsabilidades:</label><br />
    <?php
    $dados = array(
        'name' => 'empresa1_responsabilidades',
        'id' => 'empresa1_responsabilidades',
        'placeholder' => 'Que atividades você executava? Máximo de 300 caracteres.',
        'rows' => '4',
        'cols' => '100',
        'maxlength' => '300',
        'style' => 'width:400; height:200;'
    );
    echo form_textarea($dados);
    echo br(2);
    ?>
    <label for="empresa2_nome">Empresa em que trababalhou:</label>
    <?php
    $dados = array(
        'name' => 'empresa2_nome',
        'placeholder' => 'Digite o nome da empresa',
        'style' => 'width:200px'
    );
    echo form_input($dados);
    ?>
    <br />
    <label for="empresa2_ano">Ano em que trabalhou:</label>
    <?php
    echo form_dropdown('empresa2_ano', $ano, set_value('empresa2_ano'))
    ?>
    <br />
    <label for="empresa2_periodo">Por um perído de:</label>
    <?php
    $periodo[''] = 'Período';
    for ($i = 1; $i <= 50; $i++) {
        $periodo[$i] = $i;
    }
    echo form_dropdown('empresa2_periodo_valor', $periodo, set_value('empresa2_periodo_valor'));

    $periodo_tempo = array(
        'meses' => 'meses',
        'anos' => 'anos'
    );
    echo form_dropdown('empresa2_periodo_tempo', $periodo_tempo, set_value('empresa2_periodo_tempo'));
    ?>
    <br />
    <label for="empresa2_cargo">Seu cargo:</label>
    <?php
    $dados = array(
        'name' => 'empresa2_cargo',
        'placeholder' => 'Que função você ocupava?',
        'style' => 'width:200px'
    );
    echo form_input($dados);
    ?>
    <br />
    <label for = "empresa2_responsabilidades">Faça uma breve descrição das suas responsabilidades:</label><br />
    <?php
    $dados = array(
        'name' => 'empresa2_responsabilidades',
        'id' => 'empresa2_responsabilidades',
        'placeholder' => 'Que atividades você executava? Máximo de 300 caracteres.',
        'rows' => '4',
        'cols' => '100',
        'maxlength' => '300',
        'style' => 'width:400; height:200;'
    );
    echo form_textarea($dados);
    echo br(2);
    ?>
</fieldset>
<p><span class = "planos">Outras informações</span></p>
<p>Escreva aqui alguma outra informação que você considera pertinente sobre seu currículo:</p>
<?php
$dados = array(
    'name' => 'outras_informacoes',
    'id' => 'outras_informacoes',
    'placeholder' => 'Máximo de 300 caracteres.',
    'rows' => '4',
    'cols' => '100',
    'maxlength' => '300',
    'style' => 'width:400; height:200;'
);
echo form_textarea($dados);
?>
<br />
<br />
<input type = "submit" value = "Registrar" style = "margin-left:30%;"/>
<?php echo form_close(); ?>