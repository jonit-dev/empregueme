<?php
echo doctype('html5');
echo "<html>";
echo "<head>";
echo "<title>Currículo</title>";
$meta = array(
    array('name' => 'description', 'content' => 'Currículo cadastrado pelo site do empregue-me'),
    array('name' => 'keywords', 'content' => 'curriculo, empregos, oferta de vagas'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);
echo meta($meta);
?>
<style type='text/css'>
    a, a:link, a:visited
    {
        text-decoration:underline;
        color:#333;
    }
    p
    {
        font-family:Georgia, "Times New Roman", Times, serif;
        font-size:13px;	
        color:#333;	
    }

    #planos
    {
        font-size: larger;	
        font-weight:bold;
    }

    label{font-weight: bold}
</style>

<?php
echo "</head>";
echo "<body>";

// Formato 24 horas (de 1 a 24)
$hora = date('G');
if (($hora >= 0) AND ($hora < 12)) {
    $mensagem = "Bom dia,";
} else if (($hora >= 12) AND ($hora < 18)) {
    $mensagem = "Boa tarde,";
} else {
    $mensagem = "Boa noite,";
}
echo img('assets/images/logo.png');
?>
<h3 style="color: #990000">Quer procurar em nossa base de dados de MILHARES DE CANDIDATOS e postar sua vaga gratuitamente? ACESSE E CRIE SUA CONTA: <a href="http://www.empregue-me.com" target="_blank" style="text-decoration:none; color: #333">www.empregue-me.com</a></h3>
<?php
echo heading($mensagem . ' uma pessoa se candidatou a vaga anunciada de ' . $vaga->vag_nome . '. Leia abaixo o currículo do candidato e lembre-se de deixar o feedback para o mesmo.', 3);
foreach ($feedback_opcoes as $feedback_opcao) {
    echo anchor(base_url('envio/getFeedback/' . $usuario->usu_codigo . '/' . $vaga->vag_codigo . '/' . $feedback_opcao->codigo), $feedback_opcao->descricao, 'target="_blank"');
    echo br(1);
}
echo br(1);
?>
<fieldset>
    <h1>Currículo de <?php echo $usuario->usu_nome; ?></h1>
    <?php if ($usuario->usu_foto_curriculo) { ?>
        <div id="photo">
            <?php echo img('assets/images/usuarios/' . $usuario->usu_foto_curriculo); ?>
        </div>
    <?php } ?>
    <h2>Informações Básicas</h2>

    <label for="nome">Nome completo:</label>
    <?php
    echo $usuario->usu_nome;
    ?>
    <br />

    <label for="sexo">Sexo:</label>
    <?php
    echo $usuario->usu_sexo;
    echo br(1);
    ?>

    <label for="idade">Idade:</label>
    <?php
    echo $usuario->usu_idade;
    ?>
    <br />
    <label for="cidade">Cidade:</label>
    <?php
    echo $cidade->nome_cidade . ", " . $cidade->sigla;
    ?>
    <br />
    <label for="email">E-mail de contato:</label>
    <?php
    if ($usuario->usu_email = "") {
        echo $usuario->usu_email;
    } else {
        echo $usuario->usu_login;
    }
    ?>
    <br />
    <label for="bairro">Bairro:</label>
    <?php
    echo $usuario->usu_bairro;
    ?>
    <br />
    <label for="telefone">Telefone para contato:</label>
    <?php
    echo $usuario->usu_telefone1;
    ?>
    <br />
    <?php if ($usuario->usu_telefone2) { ?>
        <label for="telefone">Telefone para contato 2:</label>
        <?php echo $usuario->usu_telefone2; ?>
        <br />
    <?php } ?>
    <?php if ($usuario->usu_link_facebook) { ?>
        <label for="perfilfacebook">Link do perfil no facebook:</label>
        <?php
        echo $usuario->usu_link_facebook;
    }
    ?>
    <h2>Objetivo Profissional</h2>
    <?php
    $dados = array(
        'name' => 'objetivo',
        'rows' => '4',
        'cols' => '100',
        'style' => 'width:400; height:200;',
        'spellcheck' => 'true',
        'maxlenght' => '300',
        'value' => $curriculo->objetivo_profissional,
        'readonly' => 'readonly'
    );
    echo form_textarea($dados);
    ?>
    <h2>Formação</h2>  
    <label for="área formacao">Área Formação:</label>
    <?php
    echo $formacao->area_formacao;
    ?>
    <br />
    <label for="escolaridade formacao">Escolaridade Formação:</label>
    <?php
    echo $formacao->escolaridade_formacao;
    ?>    
    <?php if ($cursos_formacao) { ?>
        <br /><br />
        <?php foreach ($cursos_formacao as $curso_formacao) { ?>
            <label for = "curso1">Curso:</label>
            <?php
            echo $curso_formacao->curso;
            ?>
            <label for="curso1_inicio">Início:</label>
            <?php
            echo $curso_formacao->inicio;
            ?>
            <label for="curso1_termino">Término:</label>
            <?php
            echo $curso_formacao->termino;
            ?>
            <label for="curso1_instituicao">Instituição:</label>
            <?php
            echo $curso_formacao->instituicao;
            echo br(1);
        }
    }
    ?>
    <br />
    <h2>Habilidades</h2>

    <label for="ingles">Inglês:</label>
    <?php
    if ($habilidades->ingles == 1) {
        if ($habilidades->ingles_nivel) {
            $ingles = "Sim - Nível: " . $habilidades->ingles_nivel;
        } else {
            $ingles = "Sim";
        }
    } else {
        $ingles = "Não";
    }
    echo $ingles;
    ?>
    <br />
    <label for="informatica">Conhecimento Informática (Pacote Office):</label>
    <?php
    if ($habilidades->office == 1) {
        if ($habilidades->office_nivel) {
            $office = "Sim - Nível: " . $habilidades->office_nivel;
        } else {
            $office = "Sim";
        }
    } else {
        $office = "Não";
    }
    echo $office;
    if ($outras_habilidades) {
        ?>
        <br /><br />
        <?php foreach ($outras_habilidades as $outra_habilidade) { ?>
            <label for = "habilidade">Habilidade:</label>
            <?php
            echo $outra_habilidade->habilidade;
            ?>
            <label for="habilidade_inicio">Início:</label>
            <?php
            echo $outra_habilidade->inicio;
            ?>
            <label for="habilidade_termino">Término:</label>
            <?php
            echo $outra_habilidade->termino;
            ?>
            <label for="habilidade_instituicao">Instituição:</label>
            <?php
            echo $outra_habilidade->instituicao;
            echo br(1);
        }
    }
    ?>
    <br />
    <label for="cnh">CNH:</label>
    <?php
    echo $habilidades->cnh;
    ?>
    <br />
    <label for="disponivel_viagem">Disponível para Viagem:</label>
    <?php
    if ($habilidades->disponivel_viagem == 0) {
        echo "Não";
    } else {
        echo "Sim";
    }
    ?>    
    <br />
    <label for="disponivel_horario">Disponibilidade de horário:</label>
    <?php
    echo $habilidades->disponivel_horario;
    ?>
    <br />
    <label for="pretensao">Pretensão salarial:</label>
    <?php
    if ($habilidades->pretensao_salarial == "0.00") {
        echo "a combinar";
    } else {
        echo "R$ " . $habilidades->pretensao_salarial;
    }
    if ($historicos) {
        ?>
        <h2>Histórico Profissional</h2>
        <fieldset>
            <?php foreach ($historicos as $historico) { ?>
                <label for="empresa">Empresa em que trababalhou:</label>
        <?php echo $historico->empresa; ?>
                <br />
                <label for="empresa_ano">Ano em que trabalhou:</label>
        <?php echo $historico->ano; ?>
                <br />
                <label for="empresa_periodo">Por um perído de:</label>
        <?php echo $historico->periodo_dia . " " . $historico->periodo_duracao; ?>
                <br />
                <label for="empresa_cargo">Cargo:</label>
        <?php echo $historico->cargo; ?>
                <br />
                <label for = "empresa_responsabilidades">Descrição das responsabilidades:</label> <br />
                <?php
                $dados = array(
                    'name' => 'objetivo',
                    'rows' => '4',
                    'cols' => '100',
                    'style' => 'width:400; height:200;',
                    'spellcheck' => 'true',
                    'maxlenght' => '300',
                    'value' => $historico->descricao,
                    'readonly' => 'readonly'
                );
                echo form_textarea($dados);
                echo br(2);
            }
            ?>
        </fieldset>
        <?php
    }
    if ($curriculo->outras_informacoes) {
        ?>
        <h2>Outras Informações</h2>
        <?php
        $dados = array(
            'name' => 'objetivo',
            'rows' => '4',
            'cols' => '100',
            'style' => 'width:400; height:200;',
            'spellcheck' => 'true',
            'maxlenght' => '300',
            'value' => $curriculo->outras_informacoes,
            'readonly' => 'readonly'
        );
        echo form_textarea($dados);
    }
    ?>
</fieldset>
<p>Caso deseje desativar esta vaga, <a href="<?php echo base_url('envio/desativaVaga/' . $curriculo->id . '/' . $vaga->vag_codigo); ?>" target="_blank">clique aqui</a>.</p>
<?php
echo "</body>";
echo "</html>";


