<?php

function area_busca() {//função que realiza buscas no site
    if (isset($_GET['pesquisa'])) {


        if (isset($_GET['p_vaga'])) {//se passou por get, vamos pegar por get
            @ $p_vaga = mysqli_secure_query($_GET['p_vaga']);
        } else {//se passou por post...
            @ $p_vaga = mysqli_secure_query($_POST['p_vaga']); //	
        }

        if (isset($_GET['p_estado'])) {//se passou por get, vamos pegar por get
            @ $p_estado = mysqli_secure_query($_GET['p_estado']); //
        } else {
            @ $p_estado = mysqli_secure_query($_POST['p_estado']); //	
        }

        if (isset($_GET['p_cidade'])) {//se passou por get, vamos pegar por get
            @ $p_cidade = mysqli_secure_query($_GET['p_cidade']); //
        } else {
            @ $p_cidade = mysqli_secure_query($_POST['p_cidade']); //
        }

        if (isset($_GET['p_categoria'])) {//se passou por get, vamos pegar por get
            @ $p_categoria = mysqli_secure_query($_GET['p_categoria']); //
        } else {
            @ $p_categoria = mysqli_secure_query($_POST['p_categoria']); //
        }


//dump_network();
        //carrega classe de display... tem que carregar novamente pois esse script teoricamente está fora do main.php (só é carregado dps)
        require_once('classes/display_main.php');
        require_once('top_functions.php'); //usada para validação

        $display_main = new display_main; //associa uma variával à classe de carregamento do layout
//se tá passando pesquisa por get é porque fez pesquisa em área de busca
//vamos fazer uma validação rápida
        if (checa_vazio(array($p_estado, $p_cidade, $p_categoria), array('Estado', 'Cidade', 'Categoria'))) {//se encontrarmos algo vazio
            $display_main->show_system_message("Alguns dos campos selecionados estão vazios. Tente novamente!", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }


//coloca o nome do produto em maiúsculo
        $p_vaga = strtoupper($p_vaga);

//vamos conectar à BD
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");

//se o estado e cidade e a categoria não forem especificados e produto nao for especificado
//note que os SELECTs passados por post alteram somente o QUERY!


        $string_categoria = "";
        $string_vaga = "";
        $dt_hoje = date("Y-m-d");
//query padrão
        $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo =1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados";

        $query_add_final = " ORDER BY vagas.vag_destaque DESC, vagas.vag_dt_inicio DESC LIMIT 20"; //isso vai adicionar ao final da query, para que possa ordenar pela data						
        //sempre limitar os resultados em 20, para que o restante seja carregado dinamicamente
//as variáveis abaixo indicam se há necessidade ou não de bindar parametros
//vamos colocar os valores padrões para bindar
        $bind_estado = false;
        $bind_cidade = false;
        $bind_categoria = false;
        $bind_vaga = false;

        if ($p_categoria != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_categoria = " AND vagas.cat_codigo = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_categoria;
            $bind_categoria = true; //ativa variável para bindar parametro do estado 
        } else {
            $bind_categoria = false; //nao é para bindar parametro 
        }


        if (!empty($p_vaga) || ($p_vaga != "")) {//se tem valor no p_produto é porque passaram uma string de produto pra pesquisar
            $string_vaga = " AND vagas.vag_nome LIKE ?";
            $qry .= $string_vaga;
            $p_vaga = strtoupper($p_vaga);

            //tira caracteres especiais da string de busca
            require_once('string_functions.php');

            //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
            $palavra_chave = remover($p_vaga);

            //Vamos evitar procurar por palavras chaves vagas como "Auxiliar de", "Assistente de"
            $palavras_vagas = array('Auxiliar de', 'Auxiliar', 'Assistente de', 'Assistente', 'Encarregado de', 'Encarregado', '[ESTÁGIO]', 'Ajudante de', 'Analista de', 'Analista', 'Assistente de', 'Assistente', 'Auxiliar de', 'Auxiliar', 'Controlador de', 'Controlador', 'Coordenador de', 'Coordenador', 'Encarregado de', 'Gerente de', 'Inspetor de', 'Instalador de', 'Líder de', 'Operador de', 'Professor de', 'Professora de', 'Supervisor de', 'Tecnico de', 'Tecnico em');

            for ($i = 0; $i < count($palavras_vagas); $i++) {
                if (stristr($palavra_chave, $palavras_vagas[$i])) {//se encontrar a palavra vaga na palavra chave, vamos substituir
                    $palavra_chave = str_ireplace($palavras_vagas[$i], '', $palavra_chave);
                }
            }


//vamos limpar as strings de espaços em branco antes e depois
            $palavra_chave = trim($palavra_chave);

//agora vamos remover alguns caracteres, para encontrar alguma vaga parecida (e não apenas a palavra chave exata)
            $palavra_chave = substr($palavra_chave, 0, 5);

            $search = "%$palavra_chave%";

            $bind_vaga = true; //ativa variável para bindar parametro do produto tbm		
        } else {
            $bind_vaga = false;
        }

        if ($p_estado != "all") {

            $string_estado = " AND es.cod_estados = ?";
            $qry .= $string_estado;
            $bind_estado = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_estado = false;
        }

        if ($p_cidade != "all") {

            $string_cidade = " AND vagas.cid_codigo = ?";
            $qry .= $string_cidade;
            $bind_cidade = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cidade = false;
        }

//adiciona argumento no final da query, para organizar resultados por datga
        $qry = $qry . $query_add_final;
//echo $qry;
//newline(2); 
//envia variável $qry para o jquery --> usado para carregar dinamicamente os outros resultados da busca
//PASSANDO VARIÁVEL DO PHP PARA O JAVASCRIPT
//essa é a variável QUERY de consulta que será usada no carregamento dinamico das vagas ESPECÍFICAS DA PESQUISA
//tem que preparar categoria para enviar para o ajax
//ajusta categoria
        if (!empty($p_categoria)) {
            $query_preparada = str_ireplace('vagas.cat_codigo = ?', 'vagas.cat_codigo = ' . $p_categoria, $qry);
        }
//ajusta estado
        if (!empty($p_estado)) {
            $query_preparada = str_ireplace('es.cod_estados = ?', 'es.cod_estados = ' . $p_estado, $query_preparada);
        }
//ajusta cidade
        if (!empty($p_cidade)) {
            $query_preparada = str_ireplace('vagas.cid_codigo = ?', 'vagas.cid_codigo = ' . $p_cidade, $query_preparada);
        }
//ajusta palavra chave
        if (!empty($p_vaga)) {
            $query_preparada = str_ireplace('LIKE ?', 'LIKE ' . "'%$palavra_chave%'", $query_preparada);
        }

//echo $query_preparada;


        echo '
	<script type="text/javascript">
				$(document).ready(function(e) {
                 
				 query = ' . json_encode($query_preparada) . ';
				 
							
                });
			</script>
					';





        require_once('array_functions.php');
//dump_network();

        $stmt = $mysqli->prepare($qry) or die("BUSCA:could not prepare query");


//se temos que bindar alguma coisa..
        if ($bind_categoria == true || $bind_vaga == true || $bind_estado == true || $bind_cidade == true) {
//vamos usar essa classe para bindar os parametros dinamicamente
            require_once('classes/mysqli_class.php');
            $bindparam = new BindParam;


            if ($bind_categoria == true) {
                $bindparam->add('i', $p_categoria);
            }

            if ($bind_vaga == true) {
                $bindparam->add('s', $search);
            }

            if ($bind_estado == true) {
                $bindparam->add('i', $p_estado);
            }

            if ($bind_cidade == true) {
                $bindparam->add('i', $p_cidade);
            }

//essa função makeValues..etc, serve para passar os valores bindados por referencia (é uma necessidade para a função call user func array funcionar);
            call_user_func_array(array($stmt, 'bind_param'), makeValuesReferenced($bindparam->get()));
        }


// Bind all parameter values saved earlier
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);

        //se tiver resultado
        $tem_resultado = false;

        require_once('funcoes_estruturais.php');
        while ($stmt->fetch()) {//quando tiver resultado
            $tem_resultado = true;

            constroi_vaga($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
        }//end while
        if ($tem_resultado == false) {
            $display_main->show_system_message("Nenhuma vaga encontrada na pesquisa. Tente novamente, com outros parâmetros de busca!", "error");
        }
    }//end get pesquisa
}

function carrega_busca() {//carrega área de busca em $display_main->painel_esquerda
    //vamos nos conectar à base de dados para carregar os estados
    $mysqli = mysqli_full_connection();
    $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
    $stmt = $mysqli->prepare($qry);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_sigla, $r_cod_est);

    $estados = '';
    while ($stmt->fetch()) {
        $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
    }
    $stmt->close();
    $categorias = '';
    $qry = "SELECT cat_codigo, cat_nome FROM categoria";

    $stmt = $mysqli->prepare($qry);
    $stmt->execute();

    $stmt->bind_result($r_cat_codigo, $cat_nome);

    while ($stmt->fetch()) {
        $categorias .= '<option value="' . $r_cat_codigo . '">' . utf8_encode($cat_nome) . '</option>';
    }
    $stmt->close();


    echo '

<div id="area_busca">
		  <form action="main.php?pesquisa=true" method="post">
		  <select name="p_estado" id="estado2">
		  	<option value="all">Todos os estados...</option>
			  ' . $estados . '


		  </select>
		  <select name="p_cidade" id="cidade2" >
    	<option value="all">Todas as cidades...</option>
    </select>
	
	
	
	<select name="p_categoria" id="categoria2">
		<option value="all">Todas as categorias...</option>
		' . $categorias . '
	</select>


	<input type="search" name="p_vaga" id="p_vaga" placeholder="Nome da vaga..."/>
	
	<input type="submit" value="Encontrar"/>
	
	
		  </form>
</div>';
}

//========================== PARA EMPRESAS

function area_busca_empresa_vip() {
    if (isset($_GET['pesquisa'])) {
        //carrega classe de display... tem que carregar novamente pois esse script teoricamente está fora do main.php (só é carregado dps)
        require_once('classes/display_main.php');
        require_once('top_functions.php'); //usada para validação

        $display_main = new display_main; //associa uma variával à classe de carregamento do layout
//se tá passando pesquisa por get é porque fez pesquisa em área de busca
        @ $p_estado = mysqli_secure_query($_POST['p_estado']); //
        @ $p_cidade = mysqli_secure_query($_POST['p_cidade']); //
        @ $p_categoria = mysqli_secure_query($_POST['p_categoria']); //
        @ $p_vaga = mysqli_secure_query($_POST['p_vaga']);
        @ $p_cnh = mysqli_secure_query($_POST['p_cnh']);
        @ $p_bairro = mysqli_secure_query($_POST['p_bairro']);
        @ $p_idade = mysqli_secure_query($_POST['p_idade']);
        @ $p_escolaridade = mysqli_secure_query($_POST['p_escolaridade']);
        @ $p_sexo = mysqli_secure_query($_POST['p_sexo']);
        @ $p_pretensao = mysqli_secure_query($_POST['p_pretensao']);


        //dump_network();
        //Ajusta o valor da CNH
        $p_cnh = str_ireplace("CNH ", '', $p_cnh);


        //
//vamos fazer uma validação rápida
        if (checa_vazio(array($p_estado, $p_cidade), array('Estado', 'Cidade'))) {//se encontrarmos algo vazio
            $display_main->show_system_message("Alguns dos campos selecionados estão vazios. Tente novamente!", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }


//coloca o nome da vaga e do bairro em maiúsculo --> para nao dar confusão na hora de buscar na base de dados
        $p_vaga = strtoupper($p_vaga);
        $p_bairro = strtoupper($p_bairro);

//vamos conectar à BD
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");

//se o estado e cidade e a categoria não forem especificados e produto nao for especificado
//note que os SELECTs passados por post alteram somente o QUERY!

        $string_pretensao = '';
        $string_sexo = '';
        $string_escolaridade = '';
        $string_idade = '';
        $string_bairro = '';
        $string_categoria = '';
        $string_vaga = '';
        $dt_hoje = date("Y-m-d");
//query padrão
        $qry = "SELECT 
 	curriculos.fk_usu_codigo,
	usuario.usu_nome,
	usuario.usu_nickname,
	habilidades.cnh, 
	habilidades.disponivel_viagem,
	habilidades.disponivel_horario,
	habilidades.pretensao_salarial,
	habilidades.ingles,
	habilidades.ingles_nivel,
	habilidades.office,
	habilidades.office_nivel,
    area_formacao.descricao,
	estados.sigla,
	cidades.nome,
	curriculos.created
	 
   FROM usuario, curriculos, habilidades,area_formacao, estados, cidades,formacao, membro_vip
   
   WHERE
   usuario.usu_codigo = membro_vip.fk_usu_codigo AND
   curriculos.fk_usu_codigo = usuario.usu_codigo AND
   curriculos.fk_habilidades_id = habilidades.id AND
   curriculos.fk_formacao_id = formacao.id  AND
   formacao.fk_area_formacao_id = area_formacao.id AND
  usuario.cid_codigo = cidades.cod_cidades AND
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1  ";

        $query_add_final = " AND area_formacao.descricao NOT LIKE '%Nenhuma%' ORDER BY curriculos.created DESC"; //isso vai adicionar ao final da query, para que possa ordenar pela data	. Evita também mostrar candidatos que nao tenham cargo selecionado!
//as variáveis abaixo indicam se há necessidade ou não de bindar parametros
//vamos colocar os valores iniciais (false)
        $bind_estado = false;
        $bind_cidade = false;
        $bind_categoria = false;
        $bind_vaga = false;
        $bind_cnh = false;
        $bind_bairro = false;
        $bind_idade = false;
        $bind_escolaridade = false;
        $bind_sexo = false;
        $bind_pretensao = false;

        //---- BUSCA POR PRETENSAO SALARIAL ----/

        if ($p_pretensao != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_pretensao = " AND habilidades.pretensao_salarial <= ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_pretensao;
            $bind_pretensao = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_pretensao = false; //nao é para bindar parametro 
        }





        //---- BUSCA POR SEXO ----/

        if ($p_sexo != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_sexo = " AND usuario.usu_sexo LIKE ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_sexo;
            $bind_sexo = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_sexo = false; //nao é para bindar parametro 
        }


        //---- BUSCA POR ESCOLARIDADE ----/

        if ($p_escolaridade != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_escolaridade = " AND formacao.fk_escolaridade_formacao_id = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_escolaridade;
            $bind_escolaridade = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_escolaridade = false; //nao é para bindar parametro 
        }

        //--------------- BUSCA POR IDADE--------------//

        if ($p_idade != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $data = explode('-', $p_idade);
            $idade_inicio = $data[0];
            $idade_termino = $data[1];


            $string_idade = " AND usuario.usu_idade >= ? AND usuario.usu_idade <= ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_idade;
            $bind_idade = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_idade = false; //nao é para bindar parametro 
        }
        //------------- BUSCA POR CATEGORIA------------//

        if ($p_categoria != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_categoria = " AND curriculos.fk_categoria_codigo = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_categoria;
            $bind_categoria = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_categoria = false; //nao é para bindar parametro 
        }


//-------------------- BUSCA POR VAGA ----------------//

        if (!empty($p_vaga) || ($p_vaga != "")) {//se tem valor no p_vaga é porque passaram uma string de vaga pra pesquisar
            $string_vaga = " AND area_formacao.descricao LIKE ?";
            $qry .= $string_vaga;
            $p_vaga = strtoupper($p_vaga);

            //tira caracteres especiais da string de busca
            require_once('string_functions.php');

            //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
            $palavra_chave = remover($p_vaga);
            // echo $palavra_chave;
            //Vamos evitar procurar por palavras chaves vagas como "Auxiliar de", "Assistente de"
            $palavras_vagas = array('Auxiliar de', 'Auxiliar', 'Assistente de', 'Assistente', 'Encarregado de', 'Encarregado', '[ESTÁGIO]', 'Ajudante de', 'Analista de', 'Analista', 'Assistente de', 'Assistente', 'Auxiliar de', 'Auxiliar', 'Controlador de', 'Controlador', 'Coordenador de', 'Coordenador', 'Encarregado de', 'Gerente de', 'Inspetor de', 'Instalador de', 'Líder de', 'Operador de', 'Professor de', 'Professora de', 'Supervisor de', 'Tecnico de', 'Tecnico em');



            for ($i = 0; $i < count($palavras_vagas); $i++) {
                if (stristr($palavra_chave, $palavras_vagas[$i])) {//se encontrar a palavra vaga na palavra chave, vamos substituir
                    $palavra_chave = str_ireplace($palavras_vagas[$i], '', $palavra_chave);
                }
            }


//vamos limpar as strings de espaços em branco antes e depois
            $palavra_chave = trim($palavra_chave);

//agora vamos remover alguns caracteres, para encontrar alguma vaga parecida (e não apenas a palavra chave exata)
            $palavra_chave = substr($palavra_chave, 0, 4);


            $search = "%$palavra_chave%";

            $bind_vaga = true; //ativa variável para bindar parametro da vaga tbm		
        } else {
            $bind_vaga = false;
        }

        //------------------ BUSCA POR BAIRRO-------------------------


        if (!empty($p_bairro) || ($p_bairro != "")) {//se tem valor no p_vaga é porque passaram uma string de vaga pra pesquisar
            $string_bairro = " AND usuario.usu_bairro LIKE ?";
            $qry .= $string_bairro;
            $p_bairro = strtoupper($p_bairro);

            //tira caracteres especiais da string de busca
            require_once('string_functions.php');

            //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
            $palavra_chave_bairro = remover($p_bairro);
            // echo $palavra_chave;
//vamos limpar as strings de espaços em branco antes e depois
            $palavra_chave_bairro = trim($palavra_chave_bairro);

            $search_bairro = "%$palavra_chave_bairro%";

            $bind_bairro = true; //ativa variável para bindar parametro da vaga tbm		
        } else {
            $bind_bairro = false;
        }


        //----------- BUSCA POR ESTADO----------------//

        if ($p_estado != "all") {

            $string_estado = " AND estados.cod_estados = ?";
            $qry .= $string_estado;
            $bind_estado = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_estado = false;
        }


        //----------- BUSCA POR CIDADE----------------//

        if ($p_cidade != "all") {

            $string_cidade = " AND usuario.cid_codigo = ?";
            $qry .= $string_cidade;
            $bind_cidade = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cidade = false;
        }


        if ($p_cnh != "all") {

            $string_cnh = " AND habilidades.cnh = ?";
            $qry .= $string_cnh;
            $bind_cnh = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cnh = false;
        }



//adiciona argumento no final da query, para organizar resultados por data
        $qry = $qry . $query_add_final;



        //require_once('array_functions.php');


        $stmt = $mysqli->prepare($qry) or die("BUSCA:could not prepare query:<br/><br/> $qry");


//se temos que bindar alguma coisa..
        if ($bind_vaga == true || $bind_estado == true || $bind_cidade == true || $bind_cnh == true || $bind_bairro == true || $bind_categoria == true || $bind_idade == true || $bind_escolaridade == true || $bind_sexo == true || $bind_pretensao == true) {
//vamos usar essa classe para bindar os parametros dinamicamente
            require_once('classes/mysqli_class.php');
            $bindparam = new BindParam;


//bindagem de parametros --> tem que seguir ordem de construção das querys acima!!

            if ($bind_pretensao == true) {
                $bindparam->add('i', $p_pretensao);
            }


            if ($bind_sexo == true) {
                $bindparam->add('s', $p_sexo);
            }


            if ($bind_escolaridade == true) {
                $bindparam->add('i', $p_escolaridade);
            }
            if ($bind_idade == true) {
                $bindparam->add('i', $idade_inicio);
                $bindparam->add('i', $idade_termino);
            }


            if ($bind_categoria == true) {
                $bindparam->add('i', $p_categoria);
            }

            if ($bind_vaga == true) {
                $bindparam->add('s', $search);
            }

            if ($bind_bairro == true) {
                $bindparam->add('s', $search_bairro);
            }

            if ($bind_estado == true) {
                $bindparam->add('i', $p_estado);
            }

            if ($bind_cidade == true) {
                $bindparam->add('i', $p_cidade);
            }

            if ($bind_cnh == true) {
                $bindparam->add('s', $p_cnh);
            }

//essa função makeValues..etc, serve para passar os valores bindados por referencia (é uma necessidade para a função call user func array funcionar);
            call_user_func_array(array($stmt, 'bind_param'), makeValuesReferenced($bindparam->get()));
        }

//echo $search;
// Bind all parameter values saved earlier
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao);

        //se tiver resultado
       $tem_resultado_vip = false;

        require_once('funcoes_estruturais.php');
        while ($stmt->fetch()) {//quando tiver resultado, vamos construir os 
        
		
       $tem_resultado_vip = true;






            //Vamos fazer nova conexão para tentar capturar em qual empresa o usuário trabalhou

            $mysqli2 = mysqli_full_connection();
            mysqli_set_charset($mysqli2, "utf8");

            $qry2 = "SELECT
	 hp.empresa
	 
	  FROM historicos_profissionais as hp, curriculos as cur, usuario as usu 
	  
	  WHERE  
      hp.fk_curriculos_id = cur.id AND
      cur.fk_usu_codigo = usu.usu_codigo AND
      usu.usu_codigo = ?";

            $stmt2 = $mysqli2->prepare($qry2);
            $stmt2->bind_param('i', $usu_codigo);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($r_usu_empresa);

            $usu_empresa = '';
            $tem_resultado_empresa = false;
            while ($stmt2->fetch()) {
                $tem_resultado_empresa = true;
                $usu_empresa .= ' ' . $r_usu_empresa . ',';
            }
            if ($tem_resultado_empresa == false) {
                $usu_empresa = 'Nenhuma'; //valor padrão ( se nao encontrar nada na base de dados é isso que vai mostrar )
            }


            $usu_empresa = rtrim($usu_empresa, ","); //retira ultima virgula
            //primeiro ajeita cnh
            $usu_cnh = str_replace('/', ',', $usu_cnh);

            //verifica se tem CNH ou não
            if (!empty($usu_cnh)) {
                $cnh = "CNH $usu_cnh,";
            } else {
                $cnh = '';
            }

            //verifica se é disponível para viagem
            if ($usu_disp_viagem == 0) {
                $disp_viagem = "Indisponível para viagem,";
            } else {
                $disp_viagem = "Disponível para viagem,";
            }

            //Acerta disponibilidade de horário
            $usu_disp_horario = str_replace('/', ',', $usu_disp_horario); //troca por virgula
            $usu_disp_horario = substr($usu_disp_horario, 0, -1);

            //Verifica ingles
            if ($usu_ingles == 1) {
                $ingles = "Inglês $usu_ingles_nivel,";
            } else {
                $ingles = '';
            }

            //Verifica office
            if ($usu_office == 1) {
                $office = "Office $usu_office_nivel.";
            } else {
                $office = '';
            }

            //Ajusta pretensão salarial
            if ($usu_pret_salarial == 0) {
                $usu_pret_salarial = "À combinar";
            } else {
                $usu_pret_salarial = 'R$ ' . $usu_pret_salarial;
            }

            //ajusta data de criação do currículo
            $data = explode(' ', $usu_curriculo_dt_criacao);
            $usu_curriculo_dt_criacao = $data[0];

            $data = explode('-', $usu_curriculo_dt_criacao);
            $dia = $data[2];
            $mes = $data[1];
            $ano = $data[0];
            $usu_curriculo_dt_criacao = $dia . "/" . $mes . "/" . $ano;






            constroi_cv_vip($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial);
        }//end while
		
		return $tem_resultado_vip;//retorna para usarmos depois e verificar se houve resultados na busca
		
    }//end get pesquisa	
}

function area_busca_empresa() {
	
 $tem_resultado_vip = area_busca_empresa_vip();
    if (isset($_GET['pesquisa'])) {
        //carrega classe de display... tem que carregar novamente pois esse script teoricamente está fora do main.php (só é carregado dps)
        require_once('classes/display_main.php');
        require_once('top_functions.php'); //usada para validação

        $display_main = new display_main; //associa uma variával à classe de carregamento do layout
//se tá passando pesquisa por get é porque fez pesquisa em área de busca
        @ $p_estado = mysqli_secure_query($_POST['p_estado']); //
        @ $p_cidade = mysqli_secure_query($_POST['p_cidade']); //
        @ $p_categoria = mysqli_secure_query($_POST['p_categoria']); //
        @ $p_vaga = mysqli_secure_query($_POST['p_vaga']);
        @ $p_cnh = mysqli_secure_query($_POST['p_cnh']);
        @ $p_bairro = mysqli_secure_query($_POST['p_bairro']);
        @ $p_idade = mysqli_secure_query($_POST['p_idade']);
        @ $p_escolaridade = mysqli_secure_query($_POST['p_escolaridade']);
        @ $p_sexo = mysqli_secure_query($_POST['p_sexo']);
        @ $p_pretensao = mysqli_secure_query($_POST['p_pretensao']);


       
        //Ajusta o valor da CNH
        $p_cnh = str_ireplace("CNH ", '', $p_cnh);


        //
//vamos fazer uma validação rápida
        if (checa_vazio(array($p_estado, $p_cidade), array('Estado', 'Cidade'))) {//se encontrarmos algo vazio
            $display_main->show_system_message("Alguns dos campos selecionados estão vazios. Tente novamente!", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }


//coloca o nome da vaga e do bairro em maiúsculo --> para nao dar confusão na hora de buscar na base de dados
        $p_vaga = strtoupper($p_vaga);
        $p_bairro = strtoupper($p_bairro);

//vamos conectar à BD
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");

//se o estado e cidade e a categoria não forem especificados e produto nao for especificado
//note que os SELECTs passados por post alteram somente o QUERY!

        $string_pretensao = '';
        $string_sexo = '';
        $string_escolaridade = '';
        $string_idade = '';
        $string_bairro = '';
        $string_categoria = '';
        $string_vaga = '';
        $dt_hoje = date("Y-m-d");
//query padrão
        $qry = "SELECT 
 	curriculos.fk_usu_codigo,
	usuario.usu_nome,
	usuario.usu_nickname,
	habilidades.cnh, 
	habilidades.disponivel_viagem,
	habilidades.disponivel_horario,
	habilidades.pretensao_salarial,
	habilidades.ingles,
	habilidades.ingles_nivel,
	habilidades.office,
	habilidades.office_nivel,
    area_formacao.descricao,
	estados.sigla,
	cidades.nome,
	curriculos.created
	 
   FROM usuario, curriculos, habilidades,area_formacao, estados, cidades,formacao
   
   WHERE 
   curriculos.fk_usu_codigo = usuario.usu_codigo AND
   curriculos.fk_habilidades_id = habilidades.id AND
   curriculos.fk_formacao_id = formacao.id  AND
   formacao.fk_area_formacao_id = area_formacao.id AND
  usuario.cid_codigo = cidades.cod_cidades AND
  usuario.usu_codigo not in (SELECT fk_usu_codigo FROM membro_vip) AND
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1 ";

        $query_add_final = " AND area_formacao.descricao NOT LIKE '%Nenhuma%' ORDER BY curriculos.created DESC"; //isso vai adicionar ao final da query, para que possa ordenar pela data	. Evita também mostrar candidatos que nao tenham cargo selecionado!
//as variáveis abaixo indicam se há necessidade ou não de bindar parametros
//vamos colocar os valores iniciais (false)
        $bind_estado = false;
        $bind_cidade = false;
        $bind_categoria = false;
        $bind_vaga = false;
        $bind_cnh = false;
        $bind_bairro = false;
        $bind_idade = false;
        $bind_escolaridade = false;
        $bind_sexo = false;
        $bind_pretensao = false;

        //---- BUSCA POR PRETENSAO SALARIAL ----/

        if ($p_pretensao != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_pretensao = " AND habilidades.pretensao_salarial <= ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_pretensao;
            $bind_pretensao = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_pretensao = false; //nao é para bindar parametro 
        }





        //---- BUSCA POR SEXO ----/

        if ($p_sexo != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_sexo = " AND usuario.usu_sexo LIKE ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_sexo;
            $bind_sexo = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_sexo = false; //nao é para bindar parametro 
        }


        //---- BUSCA POR ESCOLARIDADE ----/

        if ($p_escolaridade != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_escolaridade = " AND formacao.fk_escolaridade_formacao_id = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_escolaridade;
            $bind_escolaridade = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_escolaridade = false; //nao é para bindar parametro 
        }

        //--------------- BUSCA POR IDADE--------------//

        if ($p_idade != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $data = explode('-', $p_idade);
            $idade_inicio = $data[0];
            $idade_termino = $data[1];


            $string_idade = " AND usuario.usu_idade >= ? AND usuario.usu_idade <= ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_idade;
            $bind_idade = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_idade = false; //nao é para bindar parametro 
        }
        //------------- BUSCA POR CATEGORIA------------//

        if ($p_categoria != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_categoria = " AND curriculos.fk_categoria_codigo = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_categoria;
            $bind_categoria = true; //ativa variável para bindar parametro de categoria
        } else {
            $bind_categoria = false; //nao é para bindar parametro 
        }


//-------------------- BUSCA POR VAGA ----------------//

        if (!empty($p_vaga) || ($p_vaga != "")) {//se tem valor no p_vaga é porque passaram uma string de vaga pra pesquisar
            $string_vaga = " AND area_formacao.descricao LIKE ?";
            $qry .= $string_vaga;
            $p_vaga = strtoupper($p_vaga);

            //tira caracteres especiais da string de busca
            require_once('string_functions.php');

            //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
            $palavra_chave = remover($p_vaga);
            // echo $palavra_chave;
            //Vamos evitar procurar por palavras chaves vagas como "Auxiliar de", "Assistente de"
            $palavras_vagas = array('Auxiliar de', 'Auxiliar', 'Assistente de', 'Assistente', 'Encarregado de', 'Encarregado', '[ESTÁGIO]', 'Ajudante de', 'Analista de', 'Analista', 'Assistente de', 'Assistente', 'Auxiliar de', 'Auxiliar', 'Controlador de', 'Controlador', 'Coordenador de', 'Coordenador', 'Encarregado de', 'Gerente de', 'Inspetor de', 'Instalador de', 'Líder de', 'Operador de', 'Professor de', 'Professora de', 'Supervisor de', 'Tecnico de', 'Tecnico em');



            for ($i = 0; $i < count($palavras_vagas); $i++) {
                if (stristr($palavra_chave, $palavras_vagas[$i])) {//se encontrar a palavra vaga na palavra chave, vamos substituir
                    $palavra_chave = str_ireplace($palavras_vagas[$i], '', $palavra_chave);
                }
            }


//vamos limpar as strings de espaços em branco antes e depois
            $palavra_chave = trim($palavra_chave);

//agora vamos remover alguns caracteres, para encontrar alguma vaga parecida (e não apenas a palavra chave exata)
            $palavra_chave = substr($palavra_chave, 0, 4);


            $search = "%$palavra_chave%";

            $bind_vaga = true; //ativa variável para bindar parametro da vaga tbm		
        } else {
            $bind_vaga = false;
        }

        //------------------ BUSCA POR BAIRRO-------------------------


        if (!empty($p_bairro) || ($p_bairro != "")) {//se tem valor no p_vaga é porque passaram uma string de vaga pra pesquisar
            $string_bairro = " AND usuario.usu_bairro LIKE ?";
            $qry .= $string_bairro;
            $p_bairro = strtoupper($p_bairro);

            //tira caracteres especiais da string de busca
            require_once('string_functions.php');

            //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
            $palavra_chave_bairro = remover($p_bairro);
            // echo $palavra_chave;
//vamos limpar as strings de espaços em branco antes e depois
            $palavra_chave_bairro = trim($palavra_chave_bairro);

            $search_bairro = "%$palavra_chave_bairro%";

            $bind_bairro = true; //ativa variável para bindar parametro da vaga tbm		
        } else {
            $bind_bairro = false;
        }


        //----------- BUSCA POR ESTADO----------------//

        if ($p_estado != "all") {

            $string_estado = " AND estados.cod_estados = ?";
            $qry .= $string_estado;
            $bind_estado = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_estado = false;
        }


        //----------- BUSCA POR CIDADE----------------//

        if ($p_cidade != "all") {

            $string_cidade = " AND usuario.cid_codigo = ?";
            $qry .= $string_cidade;
            $bind_cidade = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cidade = false;
        }


        if ($p_cnh != "all") {

            $string_cnh = " AND habilidades.cnh = ?";
            $qry .= $string_cnh;
            $bind_cnh = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cnh = false;
        }



//adiciona argumento no final da query, para organizar resultados por data
        $qry = $qry . $query_add_final;



        //require_once('array_functions.php');


        $stmt = $mysqli->prepare($qry) or die("BUSCA:could not prepare query:<br/><br/> $qry");


//se temos que bindar alguma coisa..
        if ($bind_vaga == true || $bind_estado == true || $bind_cidade == true || $bind_cnh == true || $bind_bairro == true || $bind_categoria == true || $bind_idade == true || $bind_escolaridade == true || $bind_sexo == true || $bind_pretensao == true) {
//vamos usar essa classe para bindar os parametros dinamicamente
            require_once('classes/mysqli_class.php');
            $bindparam = new BindParam;


//bindagem de parametros --> tem que seguir ordem de construção das querys acima!!

            if ($bind_pretensao == true) {
                $bindparam->add('i', $p_pretensao);
            }


            if ($bind_sexo == true) {
                $bindparam->add('s', $p_sexo);
            }


            if ($bind_escolaridade == true) {
                $bindparam->add('i', $p_escolaridade);
            }
            if ($bind_idade == true) {
                $bindparam->add('i', $idade_inicio);
                $bindparam->add('i', $idade_termino);
            }


            if ($bind_categoria == true) {
                $bindparam->add('i', $p_categoria);
            }

            if ($bind_vaga == true) {
                $bindparam->add('s', $search);
            }

            if ($bind_bairro == true) {
                $bindparam->add('s', $search_bairro);
            }

            if ($bind_estado == true) {
                $bindparam->add('i', $p_estado);
            }

            if ($bind_cidade == true) {
                $bindparam->add('i', $p_cidade);
            }

            if ($bind_cnh == true) {
                $bindparam->add('s', $p_cnh);
            }

//essa função makeValues..etc, serve para passar os valores bindados por referencia (é uma necessidade para a função call user func array funcionar);
            call_user_func_array(array($stmt, 'bind_param'), makeValuesReferenced($bindparam->get()));
        }

//echo $search;
// Bind all parameter values saved earlier
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao);

        //se tiver resultado
        $tem_resultado = false;

        require_once('funcoes_estruturais.php');
        while ($stmt->fetch()) {//quando tiver resultado, vamos construir os currículos
            $tem_resultado = true;






            //Vamos fazer nova conexão para tentar capturar em qual empresa o usuário trabalhou

            $mysqli2 = mysqli_full_connection();
            mysqli_set_charset($mysqli2, "utf8");

            $qry2 = "SELECT
	 hp.empresa
	 
	  FROM historicos_profissionais as hp, curriculos as cur, usuario as usu 
	  
	  WHERE  
      hp.fk_curriculos_id = cur.id AND
      cur.fk_usu_codigo = usu.usu_codigo AND
      usu.usu_codigo = ?";

            $stmt2 = $mysqli2->prepare($qry2);
            $stmt2->bind_param('i', $usu_codigo);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($r_usu_empresa);

            $usu_empresa = '';
            $tem_resultado_empresa = false;
            while ($stmt2->fetch()) {
                $tem_resultado_empresa = true;
                $usu_empresa .= ' ' . $r_usu_empresa . ',';
            }
            if ($tem_resultado_empresa == false) {
                $usu_empresa = 'Nenhuma'; //valor padrão ( se nao encontrar nada na base de dados é isso que vai mostrar )
            }


            $usu_empresa = rtrim($usu_empresa, ","); //retira ultima virgula
            //primeiro ajeita cnh
            $usu_cnh = str_replace('/', ',', $usu_cnh);

            //verifica se tem CNH ou não
            if (!empty($usu_cnh)) {
                $cnh = "CNH $usu_cnh,";
            } else {
                $cnh = '';
            }

            //verifica se é disponível para viagem
            if ($usu_disp_viagem == 0) {
                $disp_viagem = "Indisponível para viagem,";
            } else {
                $disp_viagem = "Disponível para viagem,";
            }

            //Acerta disponibilidade de horário
            $usu_disp_horario = str_replace('/', ',', $usu_disp_horario); //troca por virgula
            $usu_disp_horario = substr($usu_disp_horario, 0, -1);

            //Verifica ingles
            if ($usu_ingles == 1) {
                $ingles = "Inglês $usu_ingles_nivel,";
            } else {
                $ingles = '';
            }

            //Verifica office
            if ($usu_office == 1) {
                $office = "Office $usu_office_nivel.";
            } else {
                $office = '';
            }

            //Ajusta pretensão salarial
            if ($usu_pret_salarial == 0) {
                $usu_pret_salarial = "À combinar";
            } else {
                $usu_pret_salarial = 'R$ ' . $usu_pret_salarial;
            }

            //ajusta data de criação do currículo
            $data = explode(' ', $usu_curriculo_dt_criacao);
            $usu_curriculo_dt_criacao = $data[0];

            $data = explode('-', $usu_curriculo_dt_criacao);
            $dia = $data[2];
            $mes = $data[1];
            $ano = $data[0];
            $usu_curriculo_dt_criacao = $dia . "/" . $mes . "/" . $ano;






            constroi_cv($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial);
        }//end while
        if ($tem_resultado == false && $tem_resultado_vip == false)//se nao tem nem resultado VIP nem de membro Free... (coisa tá feia hein!) 
		 {
            $display_main->show_system_message("Nenhum candidato encontrado na pesquisa. Tente novamente, com outros parâmetros de busca!", "error");
        }
    }//end get pesquisa	
}

function carrega_busca_empresa() {//carrega html da área de busca de candidatos --> versão para a empresa ;)
    //vamos nos conectar à base de dados para carregar os estados
    $mysqli = mysqli_full_connection();
    $mysqli->set_charset('utf8');
    $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
    $stmt = $mysqli->prepare($qry);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_sigla, $r_cod_est);

    $estados = '';
    while ($stmt->fetch()) {
        $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
    }

    $stmt->close();
    $qry = "SELECT ef.descricao, ef.id FROM escolaridade_formacao as ef";
    $stmt = $mysqli->prepare($qry);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_ef_descr, $r_ef_id);

    $escolaridade = '';
    while ($stmt->fetch()) {
        $escolaridade .= '<option value="' . $r_ef_id . '">' . $r_ef_descr . '</option>';
    }

    $stmt->close();
    $categorias = '';
    $qry = "SELECT cat_codigo, cat_nome FROM categoria";

    $stmt = $mysqli->prepare($qry);
    $stmt->execute();

    $stmt->bind_result($r_cat_codigo, $cat_nome);

    while ($stmt->fetch()) {
        $categorias .= '<option value="' . $r_cat_codigo . '">' . $cat_nome . '</option>';
    }
    $stmt->close();

    echo '

<div id="area_busca_empresa">
		  <form action="main.php?pesquisa=true" method="post">
		  
		  

<input type="search" name="p_vaga" id="p_vaga" placeholder="Cargo do candidato"/>
		  
		  
		  
		  <select name="p_estado" id="estado2">
		  	<option value="all">Todos os estados...</option>
			 ' . $estados . '

		  </select>
		  <select name="p_cidade" id="cidade2" >
    	<option value="all">Todas as cidades...</option>
    </select>
	
	 <input type="search" name="p_bairro" id="bairro" placeholder="Digite o bairro..."/>
	
	
	
	
	
	<select name="p_categoria" id="categoria2">
		<option value="all">Todas as categorias...</option>
		' . $categorias . '
	</select>
	<br />

  
	<select name="p_cnh" id="p_cnh" value="all">
			<option value="all">Qualquer CNH...</option>
			<option value="A">CNH A</option>
			<option value="B">CNH B</option>
			<option value="C">CNH C</option>
			<option value="D">CNH D</option>
			<option value="E">CNH E</option>
	
	</select>

	

	<select name="p_idade" id="p_idade" value="all">
			<option value="all">Qualquer Idade...</option>
			<option value="14-20">de 14 a 20 anos</option>
			<option value="21-30">de 21 a 30 anos</option>
			<option value="31-40">de 31 a 40 anos</option>
			<option value="41-50">de 41 a 50 anos</option>
			<option value="51-65">de 51 a 65 anos</option>
			<option value="65-100">acima de 65 anos</option>
	</select>
	
		<select name="p_sexo" id="p_sexo" value="all">
			<option value="all">Qualquer Sexo...</option>
			<option value="Masculino">Masculino</option>
			<option value="Feminino">Feminino</option>
			
				</select>
	
	<select name="p_escolaridade" id="p_escolaridade" value="all"><br />
<option value="all">Qualquer Escolaridade...</option>
			' . $escolaridade . '
	</select>
	
	
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
	
	
	

<br />

<center>
	<input type="submit" value="Buscar Candidato"/>
	</center>
	
		  </form>
</div>';
}

function carrega_busca_freelancer() {//carrega área de busca em $display_main->painel_esquerda
    //vamos nos conectar à base de dados para carregar os estados
    $mysqli = mysqli_full_connection();
    $mysqli->set_charset('utf8');
    $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
    $stmt = $mysqli->prepare($qry);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_sigla, $r_cod_est);

    $estados = '';
    while ($stmt->fetch()) {
        $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
    }
    $stmt->close();

    /*
     * categoria
     */
    $qry = "SELECT id,descricao FROM freelancer_categoria  ORDER BY descricao";

    $stmt = $mysqli->prepare($qry);
    $stmt->execute();

    $stmt->store_result();
    $stmt->bind_result($r_categoria_id, $r_categoria_descricao);

    while ($stmt->fetch()) {
        $categoria .= '<option value="' . $r_categoria_id . '">' . $r_categoria_descricao . '</option>';
    }
    $stmt->close();
    echo '

<div id="area_busca_empresa">
		  <form action="busca_freelancer.php?pesquisa=true" method="post">
		  <select name="p_estado" id="estado2">
		  	<option value="all">Todos os estados...</option>
			  ' . $estados . '
		  </select>
		  <select name="p_cidade" id="cidade2" >
    	<option value="all">Todas as cidades...</option>
    </select>
	
        <select name="p_categoria" id="categoria"><option value="all">Todas as categorias...</option>' . $categoria . '</select>
         <select name="p_servico" id="cargo"><option value="all">Todos os serviços...</option></select>
	
	<input type="submit" value="Encontrar"/>
	
	
		  </form>
</div>';
}

function area_busca_freelancer() {//função que realiza buscas no site
    if (isset($_GET['pesquisa'])) {



        //carrega classe de display... tem que carregar novamente pois esse script teoricamente está fora do main.php (só é carregado dps)
        require_once('classes/display_main.php');
        require_once('top_functions.php'); //usada para validação

        $display_main = new display_main; //associa uma variával à classe de carregamento do layout
//se tá passando pesquisa por get é porque fez pesquisa em área de busca
        @ $p_estado = mysqli_secure_query($_POST['p_estado']); //
        @ $p_cidade = mysqli_secure_query($_POST['p_cidade']); //
        @ $p_categoria = mysqli_secure_query($_POST['p_categoria']); //
        @ $p_servico = mysqli_secure_query($_POST['p_servico']); //
//vamos fazer uma validação rápida
        if (checa_vazio(array($p_estado, $p_cidade, $p_categoria), array('Estado', 'Cidade', 'Categoria'))) {//se encontrarmos algo vazio
            $display_main->show_system_message("Alguns dos campos selecionados estão vazios. Tente novamente!", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }

//vamos conectar à BD
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");

//se o estado e cidade e a categoria não forem especificados e produto nao for especificado
//note que os SELECTs passados por post alteram somente o QUERY!


        $string_categoria = "";
        $string_servico = "";
//query padrão
        $qry = "SELECT free.free_codigo,"
                . "free.fk_freecargo_id,"
                . "free.usu_codigo,"
                . "free.free_descricao,"
                . "free.free_turno,"
                . "free.free_preco,"
                . "free.free_pos_preco,"
                . "free.free_tipo_trabalhador,"
                . "free.free_tel1,"
                . "free.free_tel2,"
                . "free.free_email,"
                . "free.free_dt_cadastro,"
                . "free.free_ativo,"
                . "usu.cid_codigo,"
                . "usu.usu_nome,"
                . "usu.usu_foto_perfil,"
                . "usu.usu_foto_curriculo,"
                . "cid.nome,"
                . "est.nome,"
                . "free.free_vip "
                . "FROM freelancer free, usuario usu, cidades cid, estados est, freelancer_cargo cargo,freelancer_categoria categoria WHERE free.usu_codigo = usu.usu_codigo AND usu.cid_codigo = cid.cod_cidades AND cid.estados_cod_estados = est.cod_estados AND free.fk_freecargo_id = cargo.id AND cargo.fk_freecategoria_id = categoria.id AND free.free_ativo = 1 ";

        $query_add_final = " ORDER BY free.free_vip desc LIMIT 20 "; //isso vai adicionar ao final da query, para que possa ordenar pela data						
        //sempre limitar os resultados em 20, para que o restante seja carregado dinamicamente
//as variáveis abaixo indicam se há necessidade ou não de bindar parametros
//vamos colocar os valores padrões para bindar
        $bind_estado = false;
        $bind_cidade = false;
        $bind_categoria = false;
        $bind_servico = false;

        if ($p_categoria != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_categoria = " AND categoria.id = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_categoria;
            $bind_categoria = true; //ativa variável para bindar parametro do estado 
        } else {
            $bind_categoria = false; //nao é para bindar parametro 
        }

        if ($p_servico != "all") {//se nao for igual a todas é porque usuário quer categoria específica
            $string_servico = " AND cargo.id = ?"; //adiciona string da categoria à QUERY que será enviada ao MYSQL
            $qry .= $string_servico;
            $bind_servico = true; //ativa variável para bindar parametro do estado 
        } else {
            $bind_servico = false; //nao é para bindar parametro 
        }

        if ($p_estado != "all") {

            $string_estado = " AND est.cod_estados = ?";
            $qry .= $string_estado;
            $bind_estado = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_estado = false;
        }

        if ($p_cidade != "all") {

            $string_cidade = " AND cid.cid_codigo = ?";
            $qry .= $string_cidade;
            $bind_cidade = true; //ativa variável para bindar parametro do estado
        } else {
            $bind_cidade = false;
        }

//adiciona argumento no final da query, para organizar resultados por datga
        $qry = $qry . $query_add_final;
//echo $qry;
//newline(2); 
//envia variável $qry para o jquery --> usado para carregar dinamicamente os outros resultados da busca
//PASSANDO VARIÁVEL DO PHP PARA O JAVASCRIPT
//essa é a variável QUERY de consulta que será usada no carregamento dinamico das vagas ESPECÍFICAS DA PESQUISA
//tem que preparar categoria para enviar para o ajax
//ajusta categoria
        if (!empty($p_categoria)) {
            $query_preparada = str_ireplace('categoria.id  = ?', 'categoria.id  = ' . $p_categoria, $qry);
        }
//ajusta estado
        if (!empty($p_estado)) {
            $query_preparada = str_ireplace('est.cod_estados = ?', 'est.cod_estados = ' . $p_estado, $query_preparada);
        }
//ajusta cidade
        if (!empty($p_cidade)) {
            $query_preparada = str_ireplace('cid.cid_codigo = ?', 'cid.cid_codigo = ' . $p_cidade, $query_preparada);
        }
//ajusta palavra chave
        if (!empty($p_servico)) {
            $query_preparada = str_ireplace('cargo.id  = ?', 'cargo.id  = ' . $p_servico, $query_preparada);
        }

//echo $query_preparada;


        echo '
	<script type="text/javascript">
				$(document).ready(function(e) {
                 
				 query = ' . json_encode($query_preparada) . ';
				 
							
                });
			</script>
					';





        require_once('array_functions.php');
//dump_network();

        $stmt = $mysqli->prepare($qry) or die("BUSCA:could not prepare query");


//se temos que bindar alguma coisa..
        if ($bind_categoria == true || $bind_servico == true || $bind_estado == true || $bind_cidade == true) {
//vamos usar essa classe para bindar os parametros dinamicamente
            require_once('classes/mysqli_class.php');
            $bindparam = new BindParam;


            if ($bind_categoria == true) {
                $bindparam->add('i', $p_categoria);
            }

            if ($bind_servico == true) {
                $bindparam->add('s', $p_servico);
            }

            if ($bind_estado == true) {
                $bindparam->add('i', $p_estado);
            }

            if ($bind_cidade == true) {
                $bindparam->add('i', $p_cidade);
            }

//essa função makeValues..etc, serve para passar os valores bindados por referencia (é uma necessidade para a função call user func array funcionar);
            call_user_func_array(array($stmt, 'bind_param'), makeValuesReferenced($bindparam->get()));
        }


// Bind all parameter values saved earlier
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
        //se tiver resultado
        $tem_resultado = false;

        require_once('funcoes_estruturais.php');
        while ($stmt->fetch()) {//quando tiver resultado
            $tem_resultado = true;
            imprimi_freelancer($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
        }//end while
        if ($tem_resultado == false) {
            $display_main->show_system_message("Nenhum serviço encontrado na pesquisa. Tente novamente, com outros parâmetros de busca!", "error");
        }
    }//end get pesquisa
}

?>