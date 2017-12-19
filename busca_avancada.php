<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/top_functions.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}
?>

<?php


$display_main->head('','<!--CÓDIGO PRA SOMENTE PERMITIR SOMENTE NUMEROS NO INPUT-->
<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

<!--carrega plugin jquery para manejo do input preço-->
<script type="text/javascript" src="plugins_jquery/numero/autoNumeric.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $(\'.preco\').autoNumeric(\'init\');
    });//end ready
</script>');

$display_main->topo();
$display_main->painel_esquerda();

//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
    switch ($_GET['tipo']) {//verifica o tipo da mensagem
        case 'sucesso'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'sucesso');
            break;
        case 'error'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'error');
            break;
    }
}

            $qtd_vaga = "";
//gera opções para a vaga
            for ($i = 1; $i < 101; $i++) {
                $qtd_vaga .= '<option name="vaga_quantidade" value="' . $i . '">' . $i . '</option>';
            }

            //vamos carregar os estados de nossa base de dados
            $mysqli = mysqli_full_connection();
            $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
            $stmt = $mysqli->prepare($qry);

            $stmt->execute();
            $stmt->bind_result($r_sigla, $r_cod_est);

            $estados = '';
            while ($stmt->fetch()) {
                $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
            }

			$stmt->close();
			
			//carrega categorias
			//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
	$categorias = '';

	$qry = "SELECT cat_codigo, cat_nome FROM categoria";

	$stmt = $mysqli->prepare($qry);
	$stmt->execute();

$stmt->bind_result($r_cat_codigo,$cat_nome);

while($stmt->fetch())
	{
		$categorias .= '<option name="categoria" value="'.$r_cat_codigo.'" />'.utf8_encode($cat_nome).'</option>';
	}

$stmt->close();
$qry = "SELECT ef.descricao, ef.id FROM escolaridade_formacao as ef";
$stmt = $mysqli->prepare($qry);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($r_ef_descr, $r_ef_id);

$escolaridade = '';
while ($stmt->fetch()) {
    $escolaridade .= '<option value="' . $r_ef_id. '">' . $r_ef_descr. '</option>';
}
			
echo '

<h1>Busca Avançada de Currículos</h1>

<form action="main.php?pesquisa=true" method="post">

<p>Selecione os filtros desejados para que nosso sistema possa encontrar exatamente quem você procura.</p>




<ul>
<h3 class="vermelho_destaque">Dados Pessoais</h3>

<div style="margin-left:30px;">
	
<h4>Selecione um cargo</h4>
<li>
Cargo: <input type="search" name="p_vaga" id="p_vaga" placeholder="Cargo do candidato"/>
</li>	 

<h4>Estado, Cidade, Bairro</h4>		  
		
		<li>Estado: 
		  <select name="p_estado" id="estado2">
		  	<option value="all">Todos os estados...</option>
			 '.$estados.'

		  </select>
		</li>
		<li>
		Cidade:
		  <select name="p_cidade" id="cidade2" >
    	<option value="all">Todas as cidades...</option>
    </select>
		</li>

	
	<li>
	Bairro:
	 <input type="search" name="p_bairro" id="bairro" placeholder="Digite o bairro..."/><span class="campo_obrigatorio">* Campo opcional</span>
	</li>
	
	
	
	
	<h4>CNH - Carteira Nacional de Habilitação</h4>

<li>CNH:
  
	<select name="p_cnh" id="p_cnh" value="all">
			<option value="all">Qualquer CNH...</option>
			<option value="A">CNH A</option>
			<option value="B">CNH B</option>
			<option value="C">CNH C</option>
			<option value="D">CNH D</option>
			<option value="E">CNH E</option>
	
	</select>
</li>
	
<h4>Idade</h4>
<li>
	Idade:<select name="p_idade" id="p_idade" value="all">
			<option value="all">Qualquer Idade...</option>
			<option value="14-20">de 14 a 20 anos</option>
			<option value="21-30">de 21 a 30 anos</option>
			<option value="31-40">de 31 a 40 anos</option>
			<option value="41-50">de 41 a 50 anos</option>
			<option value="51-65">de 51 a 65 anos</option>
			<option value="65-100">acima de 65 anos</option>
	</select>
</li>


<h4>Sexo</h4>	
		<li>Sexo:
		<select name="p_sexo" id="p_sexo" value="all">
			<option value="all">Qualquer Sexo...</option>
			<option value="Masculino">Masculino</option>
			<option value="Feminino">Feminino</option>
			
				</select>
		</li>
		
		
	<h4>Escolaridade</h4>
	<li>Escolaridade	
	<select name="p_escolaridade" id="p_escolaridade" value="all"><br />
<option value="all">Qualquer Escolaridade...</option>
			'.$escolaridade.'
	</select>
	</li>
	
	<!----
	<select name="p_experiencia" id="p_experiencia" value="all"><br />
<option value="all">Qualquer nível de experiência...</option>
<option value="0-1">Até 1 ano de experiência</option>
<option value="1-2">Entre 1 e 2 anos de experiência</option>
<option value="2-3">Entre 2 e 3 anos de experiência</option>
<option value="4-5">Entre 4 e 5 anos de experiência</option>
<option value="5-10">Entre 5 e 10 anos de experiência</option>
<option value="10-15">Entre 10 e 15 anos de experiência</option>
<option value="15-20">Entre 15 e 20 anos de experiência</option>
<option value="20-30">Entre 20 e 30 anos de experiência</option>
<option value="30-100">Mais do que 30 anos de experiência</option>

	</select>
-->
</div>

<h3 class="vermelho_destaque">Dados Profissionais</h3>

<div style="margin-left:30px;">
<h4>Categoria Profissional</h4>
	
	<li>Categoria:
	<select name="p_categoria" id="categoria2">
		<option value="all">Todas as categorias...</option>
		' .  $categorias . '
	</select>
	</li>
 
<h4>Pretensão Salarial</h4>

<li>Pretensão Salarial:
<select name="p_pretensao" id="p_pretensao" value="all"><br />
<option value="all">Qualquer pretensão salarial...</option>
<option value="800">Até R$ 800,00</option>
<option value="1000">Até R$ 1000,00</option>
<option value="1200">Até R$ 1200,00</option>
<option value="1400">Até R$ 1400,00</option>
<option value="1600">Até R$ 1600,00</option>
<option value="1800">Até R$ 1800,00</option>
<option value="2000">Até R$ 2000,00</option>
<option value="2500">Até R$ 2500,00</option>
<option value="2700">Até R$ 2700,00</option>
<option value="3000">Até R$ 3000,00</option>
<option value="3500">Até R$ 3500,00</option>
<option value="4000">Até R$ 4000,00</option>
<option value="5000">Até R$ 5000,00</option>
<option value="7000">Até R$ 7000,00</option>
<option value="10000">Até R$ 10000,00</option>
<option value="15000">Até R$ 15000,00</option>
<option value="20000">Até R$ 20000,00</option>


	</select>
	</li>
	
	
	

<br />

<center>
	<input type="submit" value="Buscar Candidato" class="botao_cta"/>
	</center>
	</ul>
	
	</div>
		  </form>';






$display_main->painel_direita();
$display_main->fundo();
?>


