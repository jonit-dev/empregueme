<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado
if (session_id() == '') {
    session_start();
}

check_loggedin();//pra cadastrar CV usuário tem que tá logado


if (isset($_SESSION['nome'])) {

    $data = explode(' ', $_SESSION['nome']);
    $primeiro_nome = $data[0];
} else {//se nao tá logado, deixa em branco msm
    $primeiro_nome = '';
}


//o HEAD dessa página é diferente... cuidado

$display_main->head('
@import url(\'css/botoes.css\');
@import url(\'css/form_style.css\');
', '



<!--CARREGAMENTO DE CLICA MOSTRA BENEFICIOS MEMBRO VIP-->
<script type="text/javascript" src="js/membro_vip.js"></script>


<!--CÓDIGO PRA SOMENTE PERMITIR NUMEROS NO INPUT-->
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


<!--SCRIPT PARA GERENCIAR FORM DE PAGAMENTO-->
<script type="text/javascript" src="js/form_pagamento.js"></script>

<!--SCRIPT PARA GERENCIAR CADASTRO DE CV-->
<script type="text/javascript" src="js/cadastro_cv.js"></script>

');
?>
<!--SCRIPT DE CARREGAMENTO DOS SELECTS DOS BANNERS-->
<script type="text/javascript" src="js/select_load.js">
</script>

<script src="js/jquery.price_format.min.js" type="text/javascript"></script>


<!--carrega plugin jquery para manejo do input preço-->
<script type="text/javascript" src="plugins_jquery/numero/autoNumeric.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('.pretensao_salarial').autoNumeric('init');
    });//end ready
</script>

<!--CÓDIGO PRA SOMENTE PERMITIR SOMENTE NUMEROS NO INPUT-->
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

<?php



$display_main->topo(true);

//no caso do painel a esquerda, vamos verificar. Se estiver logado, mostra versão original. Se não, vai mostrar o painel do visitante.
//veja scripts internos
$display_main->painel_esquerda();




echo '<h1>Cadastre seu Currículo</h1>';

//Primeiro vamos verificar se o usuário já cadastrou o currículo, para evitar CV duplicado.
$mysqli = mysqli_full_connection();
$mysqli->set_charset('utf8');
$qry = "SELECT id FROM curriculos where fk_usu_codigo = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$_SESSION['userid']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cid);

$tem_resultado = false;

while($stmt->fetch())
	{
			$tem_resultado = true;
	}	

if($tem_resultado == true)//se usuário já cadastrou o CV
	{
				$display_main->show_system_message('Você já cadastrou o seu currículo! Clique em Visualizar meu Currículo no painel ao lado para vê-lo','error');
		echo '  <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout(\'document.location.href="main.php"\', 2000)
        });//end ready
    </script>';
		
		$mysqli->close();
		exit;
	}

$stmt->close();


//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
$categorias = '';
$mysqli->set_charset('utf8');
$qry = "SELECT cat_codigo, cat_nome FROM categoria";

$stmt = $mysqli->prepare($qry);
$stmt->execute();

$stmt->store_result();
$stmt->bind_result($r_cat_codigo, $cat_nome);

while ($stmt->fetch()) {
    $categorias .= '<option value="' . $r_cat_codigo . '">' . $cat_nome . '</option>';
}

$stmt->close();
$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
$stmt = $mysqli->prepare($qry);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($r_sigla, $r_cod_est);

$estados = '';
while ($stmt->fetch()) {
    $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
}

//carrega cargos da base de dados e salva em opcoes

  $mysqli = mysqli_full_connection();
	$mysqli->set_charset("utf8");
    $qry = "SELECT af.id, af.descricao FROM area_formacao as af ORDER BY descricao ASC";
	$stmt = $mysqli->prepare($qry);
	$stmt->execute();
	$stmt->bind_result($af_id,$af_descricao);
	
	$cargos = '';
	$outros_cargos = '';
	while($stmt->fetch())
		{
			
		if($af_id == 349)
			{
				$cargos .= '<option value="'.$af_id.'" selected="selected">'.$af_descricao.'</option>';		
			}
			else
				{
					$cargos .= '<option value="'.$af_id.'" >'.$af_descricao.'</option>';	
				}
			
			if($af_id == 259)//deixa o "Nenhum como default"
			{
				$outros_cargos .= '<option value="'.$af_id.'" selected="selected">'.ucwords($af_descricao).'</option>';			
			}
				else
				{
					$outros_cargos .= '<option value="'.$af_id.'">'.ucwords($af_descricao).'</option>';	
				}
		
		}




//gera escolaridade
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

//gera idade
$idade = '';
for($i=14;$i<=120;$i++)
	{
		$idade .= '<option value="'.$i.'">' . $i. '</option>';	
	}
//gera anos

//-- ano atual
$data = time();
$get_date = getdate($data);

$ano_atual = $get_date['year'];

$anos = '';
for($i=1950;$i<=$ano_atual;$i++)
	{
		$anos .= '<option value="'.$i.'">' . $i. '</option>';	
	}
	
	//gera período
	$periodo = '';
for($i=1;$i<=50;$i++)
	{
		$periodo .= '<option value="'.$i.'">' . $i. '</option>';	
	}


if(isset($_GET['redireciona']))
	{
	$input_redireciona = '<input type="hidden" name="redireciona" value="'.$_GET['redireciona'].'"/>';	
	}
	else
	{
	$input_redireciona = '';	
	}


     
$display_main->conteudo('
<form action="curriculo.php"  enctype="multipart/form-data" method="post">


<p>Preencha abaixo seu currículo! Os campos marcados com <span class="vermelho_destaque"> * são obrigatórios</span> e os que não possuem tal marcação podem ser deixados em branco. Aconselhamos que você <strong>preencha seu currículo da forma mais completa possível para que as empresas consigam encontrar suas informações</strong> com facilidade!</p>

<h3 class="vermelho_destaque">Informações Básicas</h3>

<ul style="list-style:none">
	<li>Nome Completo: <input id="nome" class="form_txt_big" type="text" name="usu_nome"  placeholder= "Digite seu nome completo"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
	<li>Sexo: <input type="radio"  id="sexo"  name="usu_sexo" value="Masculino" checked="checked"/>Masculino <input type="radio" name="usu_sexo" value="Feminino"/>Feminino<span class="campo_obrigatorio"   >* Campo obrigatório</span></li>	
		
		<li>Idade: <select  id="idade" name="usu_idade"   ><option value="">Selecione uma opção...</option>'.$idade.'</select><span class="campo_obrigatorio">* Campo obrigatório</span></li>	
		
	<li>Estado: <select id="estado" name="estado" id="estado"   ><option value="">Escolha o estado...</option>'.$estados.'</select><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	<li>
	 Cidade: <select id="cidade" name="cidade" id="cidade"   >
    	<option value="">Selecione seu estado primeiro...</option>
    </select><span class="campo_obrigatorio">  * Campo obrigatório</span></li>
	
	<li>Bairro: <input class="form_txt_big" id="bairro" type="text"    name="usu_bairro" placeholder= "Digite seu bairro"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
	<li>Telefone (1°): <input class="form_txt_big" id="telefone1" type="tel"     name="usu_telefone1" placeholder= "Digite seu telefone"/><span class="campo_obrigatorio">* Campo obrigatório</span></li>
	
		<li>Telefone (2°): <input class="form_txt_big" type="tel" name="usu_telefone2" placeholder= "Digite seu telefone"/></li>
		
			<li>Link do perfil no facebook: <input  class="form_txt_giant" type="text" name="usu_link_facebook" placeholder= "Exemplo: www.facebook.com/joanadasilva"/></li>
			
			<li>Foto de usuário (opcional):
						 <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						 <input type="file" name="usu_foto"/><span class="campo_obrigatorio" style="color:silver;">* Tamanho máximo: 1Mb - Formato:.jpeg, .bmp, .png</span></li>
</ul>
			
			
<h3 class="vermelho_destaque">Objetivo Profissional</h3>		
<span class="campo_obrigatorio">* Campo obrigatório</span>	
<textarea id="objetivo"    placeholder="Deixe claro o seu objetivo profissional. Cuidado com exageros: antes de enviar seu perfil a um empregador, decida BEM o que você quer fazer e em que área quer atuar. Máximo de 300 caracteres." style="width:400; height:200;" maxlength="300" rows="4" cols="100" name="objetivo"></textarea>

<h3 class="vermelho_destaque">Cargos &amp; Categoria Profissional</h3>		
		
	<ul style="list-style:none">
	
		<li><strong>Cargo de interesse principal: </strong><select id="area_profissional" name="fk_area_profissional"    style="width:300px;">
			<option value="">Selecione um cargo de interesse principal</option>'.$cargos.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<li><strong>Cargo de interesse secundário: </strong><select name="cargo_secundario">'.$outros_cargos.'</select></li>
	<li><strong>Cargo de interesse terciário: </strong><select name="cargo_terciario" >'.$outros_cargos.'</select></li>
	
<br />

		<li>Categoria profissional:<select id="categoria_profissional" name="fk_categoria_codigo"    style="width:300px;">
			<option value="">Selecione uma categoria profissional...</option>'.$categorias.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<li>Escolaridade:<select id="escolaridade" name="fk_escolaridade_formacao"    style="width:300px;">
			<option value="">Selecione sua escolaridade...</option>'.$escolaridade.'
		</select> 
		<span class="campo_obrigatorio">* Campo obrigatório</span></li>
		
		<h4 class="vermelho_destaque">Cursos Realizados</h4>
		<p>Os campos abaixo são opcionais, preencha digitando qual curso fez, quando começou e terminou e em qual instituição.</p>
		
		<ul style="list-style:none">
	
		<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="" name="curso1">
		Início <select name="curso1_inicio">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
		Término: <select name="curso1_termino">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
			Instituição: <input type="text" name="curso1_instituicao" placeholder="Instituição" class="form_txt_medio"/>
		
		
		</li>
		
		<li>
		Curso: <input type="text" placeholder="Ex. Técnico de Informática" class="form_txt_big" value="" name="curso2">
		Início <select name="curso2_inicio">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
		Término: <select name="curso2_termino">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
			Instituição: <input type="text" name="curso2_instituicao" placeholder="Instituição" class="form_txt_medio"/>
		
		
		</li>
		
	</ul>
		
<h3 class="vermelho_destaque">Habilidades</h3>		
		
	<ul style="list-style:none">
	
		<li>Sabe falar Inglês?:<input type="radio" value="1" name="ingles"/>Sim <input type="radio" value = "0" name="ingles" checked="checked"/>Não
		<span class="campo_obrigatorio">* Campo obrigatório</span>
		Nível: <select name="ingles_nivel">
			<option value="">Selecione uma opção(opcional)</option>
			<option value="Básico">Básico</option>
			<option value="Intermediário">Intermediário</option>
			<option value="Avançado">Avançado</option>
		</select>
		
		</li>
		
		
		<li>Conhecimentos em Pacote Office? (informática):<input type="radio" value="1" name="informatica"/>Sim <input type="radio" value = "0" name="informatica" checked="checked"/>Não
		<span class="campo_obrigatorio">* Campo obrigatório</span>
		Nível: <select name="office_nivel">
			<option value="">Selecione uma opção(opcional)</option>
			<option value="Básico">Básico</option>
			<option value="Intermediário">Intermediário</option>
			<option value="Avançado">Avançado</option>
		</select>
		
		</li>
		
		</ul>
		
		<h5>Outras habilidades</h5>
				
					<ul style="list-style:none">
	
		<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de libras" class="form_txt_big" value="" name="habilidade1">
		Início <select name="habilidade1_inicio">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
		Término: <select name="habilidade1_termino">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
			Instituição: <input type="text" name="habilidade1_instituicao" placeholder="Instituição" class="form_txt_medio"/>
		
		
		</li>
		
		<li>
		Habilidade: <input type="text" placeholder="Ex. Curso de Linux" class="form_txt_big" value="" name="habilidade2">
		Início <select name="habilidade2_inicio">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
		Término: <select name="habilidade2_termino">
			<option selected="selected" value="">Ano</option>'.$anos.'
		</select>
			Instituição: <input type="text" name="habilidade2_instituicao" placeholder="Instituição" class="form_txt_medio"/>
		
		
		</li>
		
	</ul>
	
	<h5>Opções compatíveis com seu currículo</h5>
				
					<ul style="list-style:none">
	
		<li>
			<input type="checkbox" value="A" name="cnh[]"/>CNH A &nbsp;&nbsp;
			<input type="checkbox" value="B" name="cnh[]"/>CNH B&nbsp;&nbsp;
			<input type="checkbox" value="C" name="cnh[]"/>CNH C&nbsp;&nbsp;
			<input type="checkbox" value="D" name="cnh[]"/>CNH D&nbsp;&nbsp;
		</li>
		<li>
			<input type="checkbox" value="1" name="disponivel_viagem"/>Disponível para Viagem
		</li>
		
		<br />

		<li>
		  <span id="horario_disp_txt">Disponibilidade de horário </span><input type="checkbox" id="horario_focus" value="Manhã" name="horario_disp[]"/>Manhã
			<input type="checkbox" value="Tarde" name="horario_disp[]"/>Tarde
			<input type="checkbox" value="Noite" name="horario_disp[]"/>Noite <span class="campo_obrigatorio">* Campo obrigatório</span>
			
		</li>
		
			<li>
		Pretensão Salarial: <input id="pretensao_salarial" class="pretensao_salarial" data-a-sep="." data-a-dec="," data-a-sign="R$ " type="text" name="pretensao_salarial" class="form_txt_medio"/>
		</li>
		
		
		</ul>
	
	
<h3 class="vermelho_destaque">Histórico Profissional (opcional)</h3>		
		
		<p>Informe-nos sobre suas experiências profissionais anteriores!</p>
		
	<ul style="list-style:none; margin-left:20px">
	
	<!--EMPRESA 1 -->
		<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa1_nome" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa1_ano">
			<option value="">Ano</option>'.$anos.'
		</select><br />
		Período de: <select name="empresa1_periodo_valor">
			<option value="" selected="selected">Período</option>
			'.$periodo.'
			</select> <select name="empresa1_periodo_tempo">
			<option value="mes" selected="selected">meses</option>
			<option value="ano" >ano(s)</option>
			</select>
		Seu cargo: <input type="text" name="empresa1_cargo" placeholder="Cargo ocupado" class="form_txt_big"/>
		<br />	
		
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa1_responsabilidades"></textarea>

	
		</li>
		
		
		
	<!--EMPRESA 2 -->
		<li>
		
		<strong>Empresa em que trabalhou: </strong><input type="text" name="empresa2_nome" placeholder="Nome da empresa" class="form_txt_big"/>
		<br />
		Ano em que trabalhou: <select name="empresa2_ano">
			<option value="">Ano</option>'.$anos.'
		</select><br />
		Período de: <select name="empresa2_periodo_valor">
			<option value="" selected="selected">Período</option>
			'.$periodo.'
			</select> <select name="empresa2_periodo_tempo">
			<option value="mes" selected="selected">meses</option>
			<option value="ano" >ano(s)</option>
			</select>
		Seu cargo: <input type="text" name="empresa2_cargo" placeholder="Cargo ocupado" class="form_txt_big"/>
		<br />	
		
		Faça uma <strong>breve</strong> descrição de suas atividade: 
	<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="empresa2_responsabilidades"></textarea>

	
		</li>
		

	</ul>

<h3 class="vermelho_destaque">Outras Informações(opcional)</h3>		
		
		<p>Escreva abaixo outras informações relevantes sobre seu currículo:</p>
		
	<ul style="list-style:none; margin-left:20px">
		<li>
			<textarea   placeholder="Máximo de 400 caracteres." maxlength="400" rows="4" cols="100" name="outras_informacoes"></textarea>

		</li>
	</ul>

<center>

'.$input_redireciona.'

<input type="submit" value="Registrar Currículo" id="registrar" class="botao_cta"/>
</center>

</form>






');

//POST

//Recebe dados e valida
if(isset($_POST['usu_nome']))//se recebeu dados por post é porque quer registrar cv
	{
		 require_once('funcoes/top_functions.php');
        require_once('funcoes/db_functions.php');
        require_once('funcoes/email_functions.php');
        require_once('funcoes/url_functions.php');
		require_once('funcoes/array_functions.php');
	

		
		
@$nome = mysqli_secure_query($_POST['usu_nome']);
@$sexo = mysqli_secure_query($_POST['usu_sexo']);
@$idade = mysqli_secure_query($_POST['usu_idade']);
@$estado = mysqli_secure_query($_POST['estado']);		
@$cidade = mysqli_secure_query($_POST['cidade']);		
@$bairro = mysqli_secure_query($_POST['usu_bairro']);	
@$telefone1 = mysqli_secure_query($_POST['usu_telefone1']);		
@$telefone2 = mysqli_secure_query($_POST['usu_telefone2']);		
@$link_facebook = mysqli_secure_query($_POST['usu_link_facebook']);			
@$objetivo = mysqli_secure_query($_POST['objetivo']);

@$area_profissional = mysqli_secure_query($_POST['fk_area_profissional']);
@$cargo_secundario = mysqli_secure_query($_POST['cargo_secundario']);
@$cargo_terciario = mysqli_secure_query($_POST['cargo_terciario']);


@$fk_categoria_codigo = mysqli_secure_query($_POST['fk_categoria_codigo']);
@$fk_escolaridade_formacao = mysqli_secure_query($_POST['fk_escolaridade_formacao']);

@$curso1 = mysqli_secure_query($_POST['curso1']);
@$curso1_inicio = mysqli_secure_query($_POST['curso1_inicio']);
@$curso1_termino = mysqli_secure_query($_POST['curso1_termino']);
@$curso1_instituicao = mysqli_secure_query($_POST['curso1_instituicao']);


@$curso2 = mysqli_secure_query($_POST['curso2']);
@$curso2_inicio = mysqli_secure_query($_POST['curso2_inicio']);
@$curso2_termino = mysqli_secure_query($_POST['curso2_termino']);
@$curso2_instituicao = mysqli_secure_query($_POST['curso2_instituicao']);		
	
@$ingles = mysqli_secure_query($_POST['ingles']);	
@$ingles_nivel = mysqli_secure_query($_POST['ingles_nivel']);


@$office = mysqli_secure_query($_POST['informatica']);	
@$office_nivel = mysqli_secure_query($_POST['office_nivel']);


@$habilidade1 = mysqli_secure_query($_POST['habilidade1']);
@$habilidade1_inicio = mysqli_secure_query($_POST['habilidade1_inicio']);
@$habilidade1_termino = mysqli_secure_query($_POST['habilidade1_termino']);
@$habilidade1_instituicao = mysqli_secure_query($_POST['habilidade1_instituicao']);


@$habilidade2 = mysqli_secure_query($_POST['habilidade2']);
@$habilidade2_inicio = mysqli_secure_query($_POST['habilidade2_inicio']);
@$habilidade2_termino = mysqli_secure_query($_POST['habilidade2_termino']);
@$habilidade2_instituicao = mysqli_secure_query($_POST['habilidade2_instituicao']);

@$cnh = $_POST['cnh'];
@$disponivel_viagem = mysqli_secure_query($_POST['disponivel_viagem']);
@$horario_disponivel = $_POST['horario_disp'];
@$pretensao_salarial = mysqli_secure_query($_POST['pretensao_salarial']);
	
@$empresa1_nome = mysqli_secure_query($_POST['empresa1_nome']);
@$empresa1_ano = mysqli_secure_query($_POST['empresa1_ano']);
@$empresa1_periodo_valor = mysqli_secure_query($_POST['empresa1_periodo_valor']);
@$empresa1_periodo_tempo = mysqli_secure_query($_POST['empresa1_periodo_tempo']);	
@$empresa1_cargo = mysqli_secure_query($_POST['empresa1_cargo']);
@$empresa1_responsabilidades = mysqli_secure_query($_POST['empresa1_responsabilidades']);


@$empresa2_nome = mysqli_secure_query($_POST['empresa2_nome']);
@$empresa2_ano = mysqli_secure_query($_POST['empresa2_ano']);
@$empresa2_periodo_valor = mysqli_secure_query($_POST['empresa2_periodo_valor']);
@$empresa2_periodo_tempo = mysqli_secure_query($_POST['empresa2_periodo_tempo']);	
@$empresa2_cargo = mysqli_secure_query($_POST['empresa2_cargo']);
@$empresa2_responsabilidades = mysqli_secure_query($_POST['empresa2_responsabilidades']);

@$outras_informacoes = mysqli_secure_query($_POST['outras_informacoes']);

@$input_redireciona = mysqli_secure_query($_POST['redireciona']);

@$foto = mysqli_secure_query($_POST['usu_foto']);
//INICIA VALIDAÇÃO

//==> dados obrigatórios
  if (checa_vazio(array($nome, $sexo, $idade, $estado, $cidade, $bairro, $telefone1, $objetivo, $area_profissional, $fk_categoria_codigo,$fk_escolaridade_formacao), array('Nome', 'Sexo', 'Idade', 'Estado', 'Cidade', 'Bairro', 'Telefone (1°)', 'Objetivo profissional', 'Cargo Principal', 'Categoria profissional', 'Escolaridade'))) {
        $display_main->show_system_message('Não foi possível editar o currículo pois os seguintes campos encontram-se vazios: ' . $resultados_vazios, 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
    }
	
	if(!isset($ingles))
		{
					$display_main->show_system_message('Você esqueceu de preencher se fala ingles ou não. ','error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
		
			if(!isset($office))
		{
			
			
			$display_main->show_system_message('Você esqueceu de preencher se tem conhecimentos no pacote office ou não. ','error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
	
	
	//valida arrays obrigatórias
	if(count($horario_disponivel) == 0)
		{
			 $display_main->show_system_message('Você esqueceu de preencher o horário disponível!', 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
			
		}
	
		
		//VALIDAÇÃO DE FOTOS!

//--------------- TERMINA VALIDAÇÃO

//AJUSTA LINK FACEBOOK
if(!empty($link_facebook))//se tem link do facebook.
{
if(stristr($link_facebook,'http') === false)
	{
		$link_facebook = 'http://'.$link_facebook;//adiciona http se nao tiver... tem que ter senao buga	
	}
}

//-------------------- INICIA REGISTRO DOS DADOS NO SISTEMA!


$mysqli = mysqli_full_connection();
mysqli_set_charset($mysqli, "utf8");


//Atualiza algumas informações no perfil	
		
			$stmt->close();
			$qry = "UPDATE usuario SET 
			usu_nome = ?,
			usu_sexo = ?, 
			usu_idade = ?, 
			usu_bairro = ?, 
			usu_telefone1 = ?,
			usu_telefone2 = ?,
			usu_link_facebook = ?
         WHERE usu_codigo = ?";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('ssissssi',$nome,$sexo,$idade,$bairro,$telefone1,$telefone2,$link_facebook,$_SESSION['userid']);
	$stmt->execute();	
	$stmt->close();
	
//registro na tabela habilidades
/*
id
cnh
disponivel_viagem
disponivel_horario
pretensao_salarial
ingles
ingles_nivel
office
office_nivel
*/



$cnh_ajustada = '';
//ajusta cnh antes de inserir
for($i=0;$i<count($cnh);$i++)
	{
	$cnh_ajustada .= $cnh[$i];	
	}
	$horario_disponivel_ajustado = '';
//ajusta disp horario antes de inserir
for($i=0;$i<count($horario_disponivel);$i++)
	{
	$horario_disponivel_ajustado .= $horario_disponivel[$i].'/';	
	}

//ajusta pretensao salarial
if (empty($pretensao_salarial) || !isset($pretensao_salarial)) {
        $pretensao_salarial = "0.00"; //deixa como "A combinar" = 0	
    } else {//se tem salário, vamos acertar o número para inserir na base de dados (converte R$ 1500,00 em 1500.00, por ex)
        require_once('funcoes/number_functions.php');
        $pretensao_salarial = concerta_preco($pretensao_salarial); //concerta o salário inserido pelo usuário e transforma-o em double(float)
    }


$qry = "INSERT INTO habilidades VALUES (null,?,?,?,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('sisdisis',$cnh_ajustada,$disponivel_viagem,$horario_disponivel_ajustado,$pretensao_salarial,$ingles,$ingles_nivel,$office,$office_nivel);
	$stmt->execute();
	$habilidades_id = $stmt->insert_id;
		$stmt->close();
/*REGISTRO NA TABELA FORMAÇÃO
id
fk_area_formacao_id
fk_escolaridade_formacao_id*/	

	$qry = "INSERT INTO formacao VALUES (null,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('ii',$area_profissional,$fk_escolaridade_formacao);
	$stmt->execute();
	$formacao_id = $stmt->insert_id;





/*REGISTRO NA TABELA FORMAÇÃO
id
fk_area_formacao_id ==> ATUALMENTE É O CARGO PRINCIPAL
fk_escolaridade_formacao_id*/
	
	

//armazena data de criação do CV
$data_atual = time();
$get_data = getdate($data_atual);

$created = $get_data['year'].'-'.$get_data['mon'].'-'.$get_data['mday'].' '.$get_data['hours'].':'.$get_data['minutes'].':'.$get_data['seconds'];

		$stmt->close();
		
/*	REGISTRO TABELA CURRICULOS
id
fk_usu_codigo
fk_habilidades_id
fk_formacao_id
fk_categoria_codigo
created
updated
deleted
objetivo_profissional
outras_informacoes
ativ*/		
	

	$qry = "INSERT INTO curriculos VALUES (null,?,?,?,?,?,null,null,?,?,1)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iiiisss',$_SESSION['userid'],$habilidades_id,$formacao_id,$fk_categoria_codigo,$created,$objetivo,$outras_informacoes);
	$stmt->execute();
	$curriculo_id = $stmt->insert_id;
	
			
			
			
/*ATUALIZA CARGO SECUNDARIO E TERCIARIO*/

//primeiro verifica se os dados ainda não foram registrados na tabela outros_cargos
	$stmt->close();
	$qry = "SELECT id FROM outros_cargos WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$curriculo_id);
	$stmt->execute();
	$stmt->bind_result($id);
	
	$tem_resultado = false;
	while($stmt->fetch())
		{
			$tem_resultado = true;
		}
	
	
	if($tem_resultado == false)//se nao tem os outros cargos registrados, vamos registrar um novo
		{
			$qry = "INSERT INTO outros_cargos VALUES (null,?,?,?)";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$curriculo_id,$cargo_secundario,$cargo_terciario);
	$stmt->execute();
			
		}
		
			if($tem_resultado == true)//se já possui dados na table outros_cargos, vamos atualizá-los!
		{
			$qry = "UPDATE outros_cargos SET cargo_secundario = ?, cargo_terciario = ? WHERE fk_curriculos_id = ?";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('iii',$cargo_secundario,$cargo_terciario,$curriculo_id);
	$stmt->execute();
			
		}

		

				
			
				
/*	REGISTRO TABELA CURSOS FORMAÇÃO
	
id
fk_formacao_id
curso
inicio
termino
instituicao*/		
	
	//primeiro, verifica se há necessidade de realmente registrar os cursos
	if(strlen($curso1) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO cursos_formacao VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$formacao_id,$curso1,$curso1_inicio,$curso1_termino,$curso1_instituicao);
	$stmt->execute();	
		}
		if(strlen($curso2) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO cursos_formacao VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$formacao_id,$curso2,$curso2_inicio,$curso2_termino,$curso2_instituicao);
	$stmt->execute();	

		}
	
	/*	HISTÓRICO PROFISSIONAL
id
fk_curriculos_id
empresa
ano
periodo_dia --> valor
periodo_duracao --> tempo
cargo
descricao*/
	
		if(strlen($empresa1_nome) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO historicos_profissionais VALUES (null,?,?,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiisss',$curriculo_id,$empresa1_nome,$empresa1_ano,$empresa1_periodo_valor,$empresa1_periodo_tempo,$empresa1_cargo,$empresa1_responsabilidades);
	$stmt->execute();	
		}
		
		
		if(strlen($empresa2_nome) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO historicos_profissionais VALUES (null,?,?,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiisss',$curriculo_id,$empresa2_nome,$empresa2_ano,$empresa2_periodo_valor,$empresa2_periodo_tempo,$empresa2_cargo,$empresa2_responsabilidades);
	$stmt->execute();	
		}
	
	

/*	OUTRAS HABILIDADES	
id
fk_habilidades_id
habilidade
inicio
termino
instituica*/
	
		if(strlen($habilidade1) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO outras_habilidades VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$habilidades_id,$habilidade1,$habilidade1_inicio,$habilidade1_termino,$habilidade1_instituicao);
	$stmt->execute();	
		}
		
				if(strlen($habilidade2) > 0)
		{
			$stmt->close();
			$qry = "INSERT INTO outras_habilidades VALUES (null,?,?,?,?,?)";
   $stmt = $mysqli->prepare($qry);
	$stmt->bind_param('isiis',$habilidades_id,$habilidade2,$habilidade2_inicio,$habilidade2_termino,$habilidade2_instituicao);
	$stmt->execute();	
		}
		
	
		
	
	$tem_foto = false;
    if (($_FILES['usu_foto']['size']) > 0) 
	{//se o tamanho da foto é maior que zero, é pq tem foto!
        $tem_foto = true;
    }


    if ($tem_foto == true) 
	
	{//se o usuário tentou enviar sua foto... vamos prosseguir com validação
        $file_temp_path = $_FILES['usu_foto']['tmp_name'];
        $file_name = $_FILES['usu_foto']['name'];
        $file_size = $_FILES['usu_foto']['size'];
        $file_type = $_FILES['usu_foto']['type'];
        $file_error = $_FILES['usu_foto']['error'];


//Validação upload foto
        if ($file_error > 0) {//se existe algum erro
            switch ($file_error) {
                case 1:
                    $display_main->show_system_message("O tamanho da foto excede o limite máximo de upload do servidor.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 2:
                    $display_main->show_system_message("O tamanho da foto enviada excede 1MB. Por favor, tente novamente com uma foto menor.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 3:
                    $display_main->show_system_message("A foto foi enviada parcialmente. Por favor, tente novamente.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 4:
                    $display_main->show_system_message("Você esqueceu de enviar a foto de usuário. Por favor, tente novamente.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;
            }//end switch
            exit; //para execução do script
        }//end if	
		
		//verifica tipos permitidos
        $allowed_types = array("image/jpeg", "image/png", "image/bmp");

        $arquivo_permitido = false;
        for ($i = 0; $i < count($allowed_types); $i++) {//faz um loop pela array de arquivo permitidos, verificando se o arquivo enviado pelo usuário é permitido
            if ($file_type == $allowed_types[$i]) {//se for, altere a variável
                $arquivo_permitido = true;
            }
        }


        if ($arquivo_permitido === false) {//se o tipo de arquivo não é permitido
            $display_main->show_system_message("ERROR:O arquivo enviado não é do tipo .jpeg, .png ou .bmp", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }
		
		
//continua validação da foto...
//Verifica tamanho da foto enviada
        require_once('classes/SimpleImage.php');
        $image = new SimpleImage();
        $image->load($file_temp_path);
//essa variável armazena aonde iremos salvar o arquivo de foto
//pega tamanho da foto e verifica se o tamanho está adequado!
        $image_height = $image->getHeight();
        $image_width = $image->getWidth();

//o tamanho mínimo é 75x75.. menos que isso não tem como aceitar!
        if ($image_height < 75 && $image_width < 75) {
            $display_main->show_system_message('Error: A foto enviada é muito pequena. Favor enviar uma foto maior que 75 x 75 pixels.', 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }

  


//
//essa variável armazena aonde iremos salvar o arquivo de foto
            $file_path = "../upload/gfx/perfil/";

            $data = explode('/', $file_type);
            $file_extension = $data[1]; //pegamos a extensão do arquivo
            $file_extension = "jpeg";
//Agora vamos manejar o arquivo enviado
            if (is_uploaded_file($file_temp_path)) {//se arquivo temporário já chegou é porque o upload já foi concluido
                $uploaded_file = $file_path . "usu_" . $_SESSION['userid'] . "." . $file_extension;


                if (!move_uploaded_file($file_temp_path, $uploaded_file)) {//se nao conseguir mover
                    $display_main->show_system_message("Error: Vaga inserida porem não foi possível mover o arquivo ao diretório de destino", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                }

                unset($image); //destroi var para usar novamente
//--photo resize (vamos alterar o tamanho do arquivo
                //   $uploaded_file_thumb = $file_path . "thumb_" . $vaga_id . "." . $file_extension;
                $image = new SimpleImage();
                $image->load($uploaded_file);
                $image->resize(100, 100);
                $image->save($uploaded_file); //salva no lugar da foto original (substitui)
				
				
				//salva versão para comentárois
				 $uploaded_file_comentario = $file_path . "comentario_" . $_SESSION['userid'] . "." . $file_extension;
				 $image->load($uploaded_file);
                $image->resize(32, 32);
                $image->save($uploaded_file_comentario); //salva no lugar da foto original (substitui)
				
            } else {//se o arquivo temporário não existe... é possível que seja um ataque em arquivo de upload
                $display_main->show_system_message("Error: Possível ataque de upload. Abortando! - Nome do arquivo: " . $file_name, 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;
            }
      	
	}
	
	
	
	//dump_network();
	
	
	
	
	
	
if($stmt->affected_rows > 0)
{
	
if(empty($input_redireciona))//se não é para redirecionar para lugar algum... vai para ultimas vagas
{
//Currículo cadastrado com sucesso
		 $display_main->show_system_message('Currículo cadastrado com sucesso! Você será redirecionado para nossas últimas vagas...', 'sucesso');
        $display_main->painel_direita();
        $display_main->fundo();
		
		echo '  <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout(\'document.location.href="main.php"\', 4000)
        });//end ready
    </script>';

        exit;	
}
	else
		{
				 $display_main->show_system_message('Currículo cadastrado com sucesso! Você será redirecionado vaga que estava verificando...', 'sucesso');
        $display_main->painel_direita();
        $display_main->fundo();
		
		echo '  <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout(\'document.location.href="vaga.php?id='.$input_redireciona.'"\', 4000)
        });//end ready
    </script>';

        exit;	
		}

}
else
{
	//Erro no cadastro do CV
		 $display_main->show_system_message('Erro no cadastro do currículo. Por favor, tente novamente!', 'error');
		 //dump_network();
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
}

	
		
		
	}


//falta colocar as máscaras 

//VALIDAÇÃO EM JQUERY


//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
$display_main->painel_direita();
$display_main->fundo();
?>


