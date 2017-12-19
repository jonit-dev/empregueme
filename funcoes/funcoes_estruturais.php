<?php

function url_exists($url) {
    // Version 4.x supported
    $handle = curl_init($url);
    if (false === $handle) {
        return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);
    return $connectable;
}

//essa função abaixo constroi o html do cv (no estilo post)
function constroi_cv($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial, $dinamicamente = false) {

    //vamos verificar a foto do usuário
    //primeiro checamos se existe a imagem
    $usu_foto = '';

    //como o usuário pode inserir foto em .jpg ou em .jpeg, vamos procurar o arquivo nas diferentes extensões. No que achar ele salva em uma var para usar depois
//"../upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg")



    $local_foto_real = "http://www.empregue-me.com/upload/gfx/perfil/usu_" . $usu_codigo . ".jpeg";

    $usu_foto = '<img src="' . $local_foto_real . '" class="vaga_logo_img" width="38" height="38"/>'; //se user tiver foto cadastrada, deixa como cadastrada...

    if (!url_exists($local_foto_real)) {//troca foto para foto de usuario anonimo, se nao tiver foto cadastrada
        $usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" width="38" height="38"/>';
    }



    //esconde nome de usuário se nao for plano recrutador ativo
    if ($_SESSION['plano_recrutador_ativo'] == 0) {
        $data = explode(' ', $usu_nome);

        $sobrenome = '';
        for ($i = 1; $i < count($data); $i++) {
            $sobrenome .= substr($data[$i], 0, 1) . '. ';
        }


        $usu_nome = $data[0] . ' ' . strtoupper($sobrenome);
    }
	
	//Vamos verificar se a empresa realmente está logada ou não... Se estiver só acessando como visitante cria o link pra redirecionar ela para criação de conta
$link_saiba_mais = '';

	if(isset($_SESSION['userid']))
		{
			$link_saiba_mais = '<a href="perfil.php?id=' . $usu_codigo . '" target="_blank"">
        <input type="button" class="candidatar" value="Saiba Mais"/>
         </a>               	
        ';
		
		$link_descricao = "perfil.php?id=".$usu_codigo;
		}
		else//se nao está logada, vamos mudar o link
		{
			
		$link_descricao = "cadastro_rapido_empresa.php";
			$link_saiba_mais = '<a href="cadastro_rapido_empresa.php" target="_self"">
        <input type="button" class="candidatar" value="Saiba Mais"/>
         </a>               	
        ';	
		}



    $html_cv = '<!--inicia CV-->
	<div class="vaga">
	
	<a href="'.$link_descricao.'" target="_blank">
				<strong>Cargo de interesse: </strong>' . $usu_area_formacao . '<br />
				<strong>Empresas anteriores: </strong>' . $usu_empresa . ' <br />
				<strong>Local:</strong> ' . $usu_estado . ', ' . $usu_cidade . '<br />
				<strong>Pretensão salarial: </strong>' . $usu_pret_salarial . '<br />		
				<strong>Detalhes: </strong> ' . $cnh . ' ' . $disp_viagem . ' Horários disponíveis: ' . $usu_disp_horario . '. ' . $ingles . ' ' . $office . '<br />
		</a>

		<div class="vaga_data" style="right:40px;">Data: ' . $usu_curriculo_dt_criacao . '</div>

		
		<div class="vaga_logo">
        	' . $usu_foto . '
        </div>
    	<div class="vaga_detalhe"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $usu_nome . ' </span></strong> procura:</div>
   
       <div class="vaga_settings"><img src="gfx/ui/settings2.png" /></div>
        
		<!--<div class="fb_pos">
		<div class="fb-like" data-href="perfil.php?id=' . $usu_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>--->
		
		'.$link_saiba_mais.'
		        <!--máximo de 620 characteres aqui na descrição-->
 
        
        
    </div>

<!--termina VAGA-->';

    if ($dinamicamente == true) {

        //Constrói a CV

        return $html_cv;
    } else {
        echo $html_cv;
    }
}

function constroi_cv_vip($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial, $dinamicamente = false) {

    //vamos verificar a foto do usuário
    //primeiro checamos se existe a imagem
    $usu_foto = '';

    //como o usuário pode inserir foto em .jpg ou em .jpeg, vamos procurar o arquivo nas diferentes extensões. No que achar ele salva em uma var para usar depois
//"../upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg")



    $local_foto_real = "http://www.empregue-me.com/upload/gfx/perfil/usu_" . $usu_codigo . ".jpeg";

    $usu_foto = '<img src="' . $local_foto_real . '" class="vaga_logo_img" width="38" height="38"/>'; //se user tiver foto cadastrada, deixa como cadastrada...

    if (!url_exists($local_foto_real)) {//troca foto para foto de usuario anonimo, se nao tiver foto cadastrada
        $usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" width="38" height="38"/>';
    }



    //esconde nome de usuário se nao for plano recrutador ativo
    if ($_SESSION['plano_recrutador_ativo'] == 0) {
        $data = explode(' ', $usu_nome);

        $sobrenome = '';
        for ($i = 1; $i < count($data); $i++) {
            $sobrenome .= substr($data[$i], 0, 1) . '. ';
        }


        $usu_nome = $data[0] . ' ' . strtoupper($sobrenome);
    }

if(isset($_SESSION['userid']))
		{
			$link_saiba_mais = '<a href="perfil.php?id=' . $usu_codigo . '" target="_blank"">
        <input type="button" class="candidatar" value="Saiba Mais"/>
         </a>               	
        ';
		
		$link_descricao = "perfil.php?id=".$usu_codigo;
		}
		else//se nao está logada, vamos mudar o link
		{
			
		$link_descricao = "cadastro_rapido_empresa.php";
			$link_saiba_mais = '<a href="cadastro_rapido_empresa.php" target="_self"">
        <input type="button" class="candidatar" value="Saiba Mais"/>
         </a>               	
        ';	
		}



    $html_cv = '<!--inicia CV-->
	<div class="vaga_exclusiva">
	
	<a href="'.$link_descricao.'" target="_blank">
				<strong>Cargo de interesse: </strong>' . $usu_area_formacao . '<br />
				<strong>Empresas anteriores: </strong>' . $usu_empresa . ' <br />
				<strong>Local:</strong> ' . $usu_estado . ', ' . $usu_cidade . '<br />
				<strong>Pretensão salarial: </strong>' . $usu_pret_salarial . '<br />		
				<strong>Detalhes: </strong> ' . $cnh . ' ' . $disp_viagem . ' Horários disponíveis: ' . $usu_disp_horario . '. ' . $ingles . ' ' . $office . '<br />
		</a>

		<div class="vaga_data" style="right:40px;">Data: ' . $usu_curriculo_dt_criacao . '</div>

		
		<div class="vaga_logo_exclusiva">
        	' . $usu_foto . '
        </div>
    	<div class="vaga_detalhe_exclusiva"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $usu_nome . ' </span></strong> procura:</div>
   
       <div class="vaga_settings"><img src="gfx/ui/coroa.png" /></div>
        
		<!--<div class="fb_pos">
		<div class="fb-like" data-href="perfil.php?id=' . $usu_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>--->
		
		'.$link_saiba_mais.'              	
                <!--máximo de 620 characteres aqui na descrição-->
 
        
        
    </div>

<!--termina VAGA-->';

    if ($dinamicamente == true) {

        //Constrói a CV

        return $html_cv;
    } else {
        echo $html_cv;
    }
}

function constroi_post_cv_vip() {



//vamos iniciar abrindo uma nova conexão com o sql
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    //cria uma nova array para armazenar informações de usuário

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
   membro_vip.fk_stat_codigo = 1 AND
   curriculos.fk_usu_codigo = usuario.usu_codigo AND
   curriculos.fk_habilidades_id = habilidades.id AND
   curriculos.fk_formacao_id = formacao.id  AND
   formacao.fk_area_formacao_id = area_formacao.id AND
  usuario.cid_codigo = cidades.cod_cidades AND
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1 AND area_formacao.id != 259 ORDER BY curriculos.id DESC 
   ";
    $stmt = $mysqli->prepare($qry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao);

    $tem_resultado = false;
    while ($stmt->fetch()) {
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

        //constrói currículo do usuário
        constroi_cv_vip($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial);
    }
}

function constroi_post_cv() {
    constroi_post_cv_vip();
//vamos iniciar abrindo uma nova conexão com o sql
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    //cria uma nova array para armazenar informações de usuário

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
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1 AND area_formacao.id != 259 ORDER BY curriculos.id DESC LIMIT 20 ";
    $stmt = $mysqli->prepare($qry);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao);

    $tem_resultado = false;
    while ($stmt->fetch()) {
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

        //constrói currículo do usuário
        constroi_cv($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial);
    }
}

function constroi_vaga_para_edicao($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome) {//essa função é responsável por construir a estrutura em html da vaga
    if ($r_vag_ativo) {//só mostra vaga se setiver ativa
        if (!file_exists("../upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg")) {
            $logo_path = "gfx/empregueme.jpeg";
        } else {
            $logo_path = "../upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg";
        }

        //se nao tiver nome da empresa, coloque como nome do empregue-me
        if ($r_vag_empresa == "") {
            $r_vag_empresa = "empregue-me";
        }

        //sql com quantidade de cadidatos por vagas
        $mysqli = mysqli_full_connection();
        $qry = "SELECT count(*) as cont FROM vagas vag,curriculos_vagas currVag 
            WHERE currVag.vag_codigo = vag.vag_codigo
            AND vag.vag_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $r_vag_codigo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_vag_candidatos);
        while ($stmt->fetch()) {
            //pluraliza ou nao a palavra candidatos
            if ($r_vag_estado_nome != "SP") {
                if ($r_vag_candidatos == 1) {
                    $palavra_cand = $r_vag_candidatos . " candidato";
                } else {
                    $palavra_cand = $r_vag_candidatos . " candidatos";
                }
            } else {
                $palavra_cand = "";
            }
        }
        $stmt->close();


        /*      //verifica regime de contratação
          switch ($r_vag_tipo) {
          case 'tem':
          $r_vag_tipo = "Temporário";
          break;

          case 'clt':
          $r_vag_tipo = "CLT";
          break;

          case 'fre':
          $r_vag_tipo = "Freelancer";
          break;
          }
         */
        //verifica se precisa mostrar telefone
        if ($r_vag_telefone == "") {
            $mostra_telefone = "";
        } else {
            $mostra_telefone = '<strong>Telefone:</strong> ' . $r_vag_telefone . '<br />';
        }

        //ajusta data
        $data = explode('-', $r_vag_dt_inicio);
        $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];


        //ajusta salário
        if ($r_vag_salario == "0.00") {
            $r_vag_salario = "Não informado";
        } else {
            $r_vag_salario = "R$ " . $r_vag_salario; //ajusta com simbolo de R$	
        }

        //--->> constroi vaga
        echo '<!--inicia VAGA-->
	<div class="vaga">

<a href="vaga.php?id=' . $r_vag_codigo . '" target="new">
				<strong>Cargo: </strong> ' . $r_vag_nome . '<br />
				<strong>Empresa: </strong> ' . $r_vag_empresa . '<br />
				<strong>Local: </strong> ' . $r_vag_cidade_nome . ', ' . $r_vag_estado_nome . '<br />
				<strong>Salário: </strong>' . $r_vag_salario . '<br />		
				<strong>Regime de contratação: </strong> ' . $r_vag_tipo . '<br />
				' . $mostra_telefone . '
				<strong>Descrição: </strong> ' . $r_vag_descricao . '<br />
		</a>

		<div class="vaga_data">Data: ' . $data_ajustada . '</div>

		
		<div class="vaga_logo">
        	<img src="' . $logo_path . '" class="vaga_logo_img" width="38" height="38"/>
        </div>
    	<div class="vaga_detalhe"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $r_vag_empresa . '</span></strong> oferece:</div>
   
        
        <div class="vaga_candidatos"><span class="vermelho_destaque"><strong>' . $r_vag_candidatos . ' ' . $palavra_cand . '</strong></span></div>
        
        <div class="vaga_settings"><img src="gfx/ui/settings2.png" /></div>
        
		<input type="hidden" name="vaga_codigo" value="' . $r_vag_codigo . '"/>
		<input type="hidden" name="vaga_usuario" value="' . $r_vag_usu_codigo . '"/>
		<input type="hidden" name="vaga_email" value="' . $r_vag_email . '"/>
		
		<!--<div class="fb_pos">
		<div class="fb-like" data-href="https://www.empreguemeagora.com.br/vaga.php?id=' . $r_vag_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
		-->
		
		<!--MOSTRA OPÇÕES DE EDIÇÃO-->
		
      	<div class="vaga_editar">
		
			
			<!----
				<img src="gfx/ui/editar_vaga.png" class="vaga_editar_img" alt="editar vaga"/><div class="vaga_editar_item"><a href="#"> Editar</a></div>
			---->
			
				<img src="gfx/ui/deletar_vaga.png" class="vaga_editar_img" alt="deletar vaga" style="margin-left:15px;"/>
				<div class="vaga_editar_item"><a href="#" class="deletar_vaga"> Deletar</a></div>
		
		
				<img src="gfx/ui/compartilhar_vaga.png" class="vaga_editar_img" alt="divulgar link vaga"  style="margin-left:15px;"/>
				<div class="vaga_editar_item"><a href="#" class="divulga_link"> Divulgar link</a></div>
		</div>
        
    
                
                	
                <!--máximo de 620 characteres aqui na descrição-->
 
        
        
    </div>

<!--termina VAGA-->';
        // <div class="vaga_conteudo">	
    }
}

//end if vaga ativa		

function constroi_vaga($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome) {//essa função é responsável por construir a estrutura em html da vaga
    if ($r_vag_ativo) {//só mostra vaga se setiver ativa
        $local_logomarca = "http://www.empregue-me.com/upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg";

        $logo_path = "../upload/gfx/vagas/vag_" . $r_vag_codigo . ".jpeg";


        if (!url_exists($local_logomarca)) {
            $logo_path = "gfx/empregueme.jpeg";
        }

        //se nao tiver nome da empresa, coloque como nome do empregue-me
        if ($r_vag_empresa == "") {
            $r_vag_empresa = "empregue-me";
        }

        //sql com quantidade de cadidatos por vagas
        $mysqli = mysqli_full_connection();
        $qry = "SELECT count(*) as cont FROM vagas vag,curriculos_vagas currVag 
            WHERE currVag.vag_codigo = vag.vag_codigo
            AND vag.vag_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $r_vag_codigo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_vag_candidatos);
        while ($stmt->fetch()) {
            //pluraliza ou nao a palavra candidatos
            if ($r_vag_estado_nome != "SP") {
                if ($r_vag_candidatos == 1) {
                    $palavra_cand = $r_vag_candidatos . " candidato";
                } else {
                    $palavra_cand = $r_vag_candidatos . " candidatos";
                }
            } else {
                $palavra_cand = "";
            }
        }
        $stmt->close();


        /*      //verifica regime de contratação
          switch ($r_vag_tipo) {
          case 'tem':
          $r_vag_tipo = "Temporário";
          break;

          case 'clt':
          $r_vag_tipo = "CLT";
          break;

          case 'fre':
          $r_vag_tipo = "Freelancer";
          break;
          }
         */

        //verifica se o usuário é membro VIP para mostrar email
        $mostra_email = '';

        if (isset($_SESSION['membro_vip_ativo'])) {
            if ($_SESSION['membro_vip_ativo'] == 1) {
                $mostra_email = '<strong>E-mail:</strong> ' . $r_vag_email . '<br />';
            } else {
                $mostra_email = '<strong>E-mail:</strong><a href="membro_vip.php"> <span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';
            }
        } else {
            $mostra_email = '<strong>E-mail:</strong><a href="membro_vip.php"> <span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';
        }

        //verifica se precisa mostrar telefone
        if ($r_vag_telefone == "") {
            $mostra_telefone = "";
        } else {
            if (isset($_SESSION['membro_vip_ativo'])) {
                //verifica se o usuário é membro VIP
                if ($_SESSION['membro_vip_ativo'] == 1) {
                    $mostra_telefone = '<strong>Telefone:</strong> ' . $r_vag_telefone . '<br />';
                } else {
                    $mostra_telefone = '<strong>Telefone:</strong> 
				<a href="membro_vip.php"><span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';
                }
            } else {
                $mostra_telefone = '<strong>Telefone:</strong> 
				<a href="membro_vip.php"><span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';
            }
        }



        //ajusta data
        $data = explode('-', $r_vag_dt_inicio);
        $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];


        //ajusta salário
        if ($r_vag_salario == "0.00") {
            $r_vag_salario = "À combinar";
        } else {
            $r_vag_salario = "R$ " . $r_vag_salario; //ajusta com simbolo de R$	
        }
        if (empty($_SESSION['login']) || !isset($_SESSION['login'])) {
            if (isset($_SESSION['adwords'])) {
                $r_curriculo = '<a class="candidatar" href="main.php?freetrial=true">Candidatar</a>';
            } else {
                $r_curriculo = '<a class="candidatar" href="index.php?aviso=1">Candidatar</a>';
            }
        } else {
            //vamos verificar se é vaga VIP
            //verifica curriculo e mostra se ele é habilitado ou não para enviar para vaga
            if ($_SESSION['curriculo'] == 0) { // curriculo = 0 o candidato nao criou o curriculo
                if ($_SESSION['tipo_conta'] == 0) {
                    $r_curriculo = '<a class="candidatar" href="main.php?mostra_alerta=semcv">Candidatar</a>';
                } else {
                    $r_curriculo = "";
                }
            } else {
                //verifica se o candidato ja enviou currículo
                $qry = "SELECT count(*) as qtd FROM curriculos_vagas where curr_codigo = ? and vag_codigo = ?";
                $stmt = $mysqli->prepare($qry);
                $curriculo = $_SESSION['curriculo'];
                $stmt->bind_param('ii', $curriculo, $r_vag_codigo);
                $stmt->execute();
                $stmt->bind_result($r_qtd);
                while ($stmt->fetch()) {
                    
                }
                if ($r_qtd == 1) { //se o resultado for 1 o candidato nao pode se candidatar, caso contrario ele está apto.
                    $r_curriculo = '<h4 style="color:#6ac824;">Voce já se candidatou a essa vaga</h4>';
                } else {
                    if ($r_vag_exclusivo == 1 && $_SESSION['membro_vip_ativo'] != 1) {//Se a vaga é exclusiva e o cara não é VIP
                        $r_curriculo = '<a class="candidatar" href="membro_vip.php" target="_blank">Seja VIP</a>'; //mostra pra ser VIP
                    } else {// se não for exclusiva, pode candidatar
                        //$link = "http://localhost/empre941/novo/curriculo/envio/envia_curriculo/" . $_SESSION['userid'] . "/" . $r_vag_codigo; //offline
                        //  $link = "http://www.empregue-me.com/novo/curriculo/envio/envia_curriculo/" . $_SESSION['userid'] . "/" . $r_vag_codigo; //online
                        //ajusta uma ID junto com o link só para identificar qual mensagem pós envio deveremos mostrar ao usuário
                        //   $r_curriculo = '<a class="candidatar"  href="' . $link . '">Candidatar</a>';
                        //candidatar via ajax
                        $r_curriculo = '
							<input type="hidden" name="userid" value="' . $_SESSION['userid'] . '"/>
							<input type="hidden" name="vaga_codigo" value="' . $r_vag_codigo . '"/>
							<a class="candidatar"  href="javascript:void(0)" >Candidatar</a>
							
							';
                    }
                }
            }
        }

//Verifica se é vaga exclusiva... se for, vamos mudar o layout
        if ($r_vag_exclusivo == 1) {//VAGA EXCLUSIVA
            $layout_vaga = '<div class="vaga_exclusiva">';
            $vaga_logo = 'vaga_logo_exclusiva';
            $vaga_detalhe = 'vaga_detalhe_exclusiva';
            $vaga_settings = 'coroa.png';
        }
        if ($r_vag_exclusivo == 0) {//VAGA COMUM
            $layout_vaga = '<div class="vaga">'; //se nao for, mostra layout padrão
            $vaga_logo = 'vaga_logo';
            $vaga_detalhe = 'vaga_detalhe';
            $vaga_settings = 'settings2.png';
        }


        if ($r_vag_destaque == 1) {//VAGA DESTAQUE
            $layout_vaga = '<div class="vaga_destaque">';
            $vaga_logo = 'vaga_logo_destaque';
            $vaga_detalhe = 'vaga_detalhe_destaque';
            $vaga_settings = 'vaga_destaque.png';
        }

        $envia_mensagem = ''; //nao pode mostrar para quem n esta logado	
        if (isset($_SESSION['login'])) {
            $envia_mensagem = '<a href="envia_mensagem_empresa.php?id=' . $r_vag_codigo . '" class="btm_enviar_msg">Enviar Mensagem</a>';
        }


        //--->> constroi vaga
        echo '<!--inicia VAGA-->
	' . $layout_vaga . '<a name="vaga' . $r_vag_codigo . '"></a>

<a href="vaga.php?id=' . $r_vag_codigo . '" target="new">

				<strong>Empresa: </strong> ' . $r_vag_empresa . '<br />
				<strong>Local: </strong> ' . $r_vag_cidade_nome . ', ' . $r_vag_estado_nome . '<br />
				<strong>Salário: </strong>' . $r_vag_salario . '<br />		
				<strong>Regime de contratação: </strong> ' . $r_vag_tipo . '<br />
				' . $mostra_telefone . '
				' . $mostra_email . '
				<strong>Descrição: </strong> ' . $r_vag_descricao . '<br />
		</a>

		<div class="vaga_data">Data: ' . $data_ajustada . '</div>

		
		<div class="' . $vaga_logo . '">
        	<img src="' . $logo_path . '" class="vaga_logo_img" width="38" height="38"/>
        </div>
    	<div class="' . $vaga_detalhe . '"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $r_vag_nome . '</span></strong></div>
   
        
        <div class="vaga_candidatos"><span class="vermelho_destaque"><strong>' . $palavra_cand . '</strong></span></div>
        
        <div class="vaga_settings"><img src="gfx/ui/' . $vaga_settings . '" /></div>
        
	
		
		<!----
		<div class="fb_pos">
		<div class="fb-like" data-href="https://www.empreguemeagora.com.br/vaga.php?id=' . $r_vag_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
		-->
		
        ' . $r_curriculo . '
		
' . $envia_mensagem . '
        
    
                
                	
                <!--máximo de 620 characteres aqui na descrição-->
 
        
        
    </div>

<!--termina VAGA-->';
        // <div class="vaga_conteudo">	
    }
}

//end if vaga ativa

function carrega_vagas($target = "all", $edit = false, $qt_para_carregar = 5, $carrega_exclusiva = false) {
    //var target serve para saber se temos que carregar todas as vagas ou só de algum usuário específico
    //var edit serve para saber se é para carregar uma vaga comum ou aquela com os settings de edição
    require_once('classes/display_main.php');
    require_once('funcoes/top_functions.php'); //usada para validação
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");

    $display_main = new display_main; //associa uma variával à classe de carregamento do layout
    //primeiro se conecta à base de dados para captar os dados
    //se o limite passado pelo usuário é ALL, vamos deixar sem limitações
    if ($qt_para_carregar == 'all') {
        $LIMIT = '';
    } else {//se nao for todas as vagas, carrega o padrão.
        $LIMIT = 'LIMIT ' . $qt_para_carregar;
    }

//ve qual cargo é o principal desejado pelo usuario, se ELE TEM CV CADASTRADO
    if (isset($_SESSION['curriculo']) && $_SESSION['curriculo'] != 0) {
        $qry = "SELECT af.descricao 
FROM area_formacao as af, 
usuario as usu, 
curriculos as cv,
formacao as frm
WHERE
usu.usu_codigo = ? AND
usu.usu_codigo = cv.fk_usu_codigo AND
cv.fk_formacao_id = frm.id AND
frm.fk_area_formacao_id = af.id LIMIT 1";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $_SESSION['userid']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_cargo_user);
        while ($stmt->fetch()) {
            $cargo_user = $r_cargo_user;
        }

        $cargo_user = strtoupper($cargo_user);

        //tira caracteres especiais da string de busca
        require_once('funcoes/string_functions.php');

        //tira todos os acentos da palavra de busca e depois deixa tudo em maiúsculo, para enviar à consulta 
        $palavra_chave = remover($cargo_user);

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
    }
    if (isset($stmt)) {
        $stmt->close();
    }


    if ($target != "all") {//CARREGA VAGAS DE UM USUÁRIO ANUNCIANTE EM PARTICULAR (útil para empresas)
        $dt_hoje = date("Y-m-d");
        $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo =1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados AND vagas.usu_codigo = ? ORDER BY vagas.vag_dt_inicio " . $LIMIT;
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $target);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
        $tem_resultado = false;
        while ($stmt->fetch()) {


            $tem_resultado = true;
            if ($edit == false) {//se não é vaga para edição, vamos mostrar somente a vaga do usuário específico
                constroi_vaga($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
            }
            if ($edit == true) {//agora, se for para edição, vamos criar uma vaga com botões de edição personalizados
                constroi_vaga_para_edicao($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
            }
        }

        if ($tem_resultado == false) {//se empresa ainda não anunciou nenhuma vaga, vamos orientá-la a anunciar!
            echo '<p>Você ainda não anunciou nenhuma vaga! <strong><a class="vermelho_destaque" href="main.php?banner=anunciar">Clique aqui</a></strong> para criar seu anúncio</p>';
        }
    }




    if ($target == "all") {//CARREGA VAGAS DE TODOS OS USUÁRIOS
        //se a Quantidade para CARREGAR passada pelo usuário é ALL, vamos deixar sem limitações
        //Vamos verificar se a vaga para carregar é exclusiva. Se for, ajusta o carregamento!
        if ($carrega_exclusiva == true) {
            $qry_exclusiva = ' AND vagas.vag_exclusivo = 1'; //add isso ao qry de consulta á BD	
        } else {
            $qry_exclusiva = ''; //nao mostra nada exclusivo	
        }


        $auto_consulta = false; //ESSA VARIAVEL FAZ MOSTRAR LOGO DE INICIO AS VAGAS DE INTERESSE PRINCIPAL DO CANDIDATO


        if (isset($_SESSION['cidade_id']) && $_SESSION['cidade_id'] != "") {// mostra apenas as vagas do estadodo usuário
            $add_query = ''; //var que armazena parametros extas de consulta à BD, caso seja necessário

            if (isset($cargo_user) && $auto_consulta == true) {
                $add_query = 'AND vagas.vag_nome LIKE ?';
            }




            $qry = "SELECT estados_cod_estados FROM usuario, cidades WHERE cid_codigo = cod_cidades AND usu_codigo = ?";
            $stmt = $mysqli->prepare($qry);
            $usu_codigo = $_SESSION['userid'];
            $stmt->bind_param('i', $usu_codigo);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($estados_cod_estados);
            while ($stmt->fetch()) {
                $cid = " AND es.cod_estados = " . $estados_cod_estados;
            }
            $stmt->close();
        } else {
            $cid = "";
        }
        //mysqli_set_charset($mysqli, "utf8");
        $dt_hoje = date("Y-m-d");
        if (isset($_SESSION['userid'])) {//se user está logado
            $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo =1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados " . $qry_exclusiva . " " . $cid . " " . $add_query . " ORDER BY vagas.vag_destaque DESC,vagas.vag_dt_inicio DESC " . $LIMIT . "";
        } else {//se nao estiver logado, mostre todas as vagas.. n tem sentido mostrar vagas de acordo com cv!!
            $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo =1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados " . $qry_exclusiva . " " . $cid . " ORDER BY vagas.vag_destaque DESC,vagas.vag_dt_inicio DESC " . $LIMIT . "";
        }
        $stmt = $mysqli->prepare($qry);
        if (isset($cargo_user) && isset($_SESSION['curriculo']) && ($auto_consulta == true)) {
            if ($_SESSION['curriculo'] != 0) {
                $stmt->bind_param('s', $search);
            }
        }

        $stmt->execute();

        $stmt->store_result();
        $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
        $tem_vaga = false;
        while ($stmt->fetch()) {
            $tem_vaga = true;
            if ($tem_vaga == true) {//se tem vaga correspondente ao CV do usuário...
                constroi_vaga($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
            }
        }

        if ($tem_vaga == false) {//se não tiver, mostre todas!
            if (isset($stmt)) {
                $stmt->close();
            }
            $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo =1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados " . $qry_exclusiva . " " . $cid . "  ORDER BY vagas.vag_destaque DESC,vagas.vag_dt_inicio DESC " . $LIMIT . "";
            $stmt = $mysqli->prepare($qry);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
            $tem_vaga = false;
            while ($stmt->fetch()) {

                constroi_vaga($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
            }
        }
    }
}

/* FUNÇÕES PARA O PRESTADOR DE SERVIÇOS */

function constroi_freelancer($user = false) {
    if ($user == true) {
        $usu_codigo = $_SESSION['userid'];
//vamos iniciar abrindo uma nova conexão com o sql
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");
        //diferencia vip e nao vips
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
                . "FROM freelancer free, usuario usu, cidades cid, estados est WHERE free.usu_codigo = usu.usu_codigo AND usu.cid_codigo = cid.cod_cidades AND cid.estados_cod_estados = est.cod_estados AND free.usu_codigo = ? AND free.free_ativo = 1 ORDER BY free.free_codigo DESC";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $usu_codigo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
        while ($stmt->fetch()) {
            if ($user == true) {
                imprimi_freelancer_edicao($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
            } else {
                imprimi_freelancer($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
            }
        }
        $stmt->close();
    } else {

//vamos iniciar abrindo uma nova conexão com o sql
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");
        //diferencia vip e nao vips
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
                . "FROM freelancer free, usuario usu, cidades cid, estados est WHERE free.usu_codigo = usu.usu_codigo AND usu.cid_codigo = cid.cod_cidades AND cid.estados_cod_estados = est.cod_estados AND free.free_ativo = 1 ORDER BY free.free_vip desc";
        $stmt = $mysqli->prepare($qry);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
        while ($stmt->fetch()) {
            imprimi_freelancer($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip);
        }
        $stmt->close();
    }
}

function imprimi_freelancer($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip) {
    if ($free_vip == 1) {//VAGA EXCLUSIVA
        $layout_vaga = '<div class="vaga_exclusiva">';
        $vaga_logo = 'vaga_logo_exclusiva';
        $vaga_detalhe = 'vaga_detalhe_exclusiva';
        $vaga_settings = 'coroa.png';
    } else {//VAGA COMUM
        $layout_vaga = '<div class="vaga">'; //se nao for, mostra layout padrão
        $vaga_logo = 'vaga_logo';
        $vaga_detalhe = 'vaga_detalhe';
        $vaga_settings = 'settings2.png';
    }

    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "SELECT cargo.descricao,cat.descricao FROM freelancer_cargo cargo, freelancer_categoria cat WHERE cat.id = cargo.fk_freecategoria_id AND cargo.id = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $fk_freecargo_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_cargo, $r_categoria);
    while ($stmt->fetch()) {
        
    }
    $stmt->close();
    /*
     * dados do servico
     */
    //nome do candidato
    $nome = explode(" ", $usu_nome);
    //ajusta data
    $data_hora = explode(" ", $free_dt_cadastro);
    $data = explode('-', $data_hora[0]);
    $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];
    //foto do prestador
    $local_foto_real = "../upload/gfx/perfil/usu_" . $usu_codigo . ".jpeg";
    $usu_foto = '<img src="' . $local_foto_real . '" class="vaga_logo_img" width="38" height="38"/>'; //se user tiver foto cadastrada, deixa como cadastrada...
    //preco servico
    if ($free_preco == 0.00) {
        $free_preco = "Á combinar";
    } else {
        $free_preco = "R$ " . $free_preco . ' ' . $free_pos_preco;
    }
    //turno
    if ($free_turno == "Geral") {
        $free_turno = "Matutino, Vespertino e Noturno";
    }


    if (!file_exists($local_foto_real)) {//troca foto para foto de usuario anonimo, se nao tiver foto cadastrada
        $usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" width="38" height="38"/>';
    }

    echo '<!--inicia VAGA-->
	' . $layout_vaga . '
<a href="servico.php?id=' . $free_codigo . '" target="_blank">
				<strong>Serviço: </strong> ' . $r_categoria . ' - ' . $r_cargo . '<br />
				<strong>Local: </strong> ' . $cidade . ', ' . $estado . '<br />
				<strong>Preço do serviço: </strong>' . $free_preco . '<br />
                                <strong>Turno: </strong> ' . $free_turno . '<br />
				<strong>O prestador é: </strong> ' . $free_tipo_trabalhador . '<br />
				<strong>Descrição: </strong> ' . $free_descricao . '<br />
		</a>

		<div class="vaga_data">Data: ' . $data_ajustada . '</div>

		
		<div class="' . $vaga_logo . '">
        	' . $usu_foto . '
        </div>
    	<div class="' . $vaga_detalhe . '"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $nome[0] . ' ' . $nome[1] . '</span></strong> oferece:</div>
                 
        <div class="vaga_settings"><img src="gfx/ui/' . $vaga_settings . '" /></div>   
	
		<a class="candidatar" href="servico.php?id=' . $free_codigo . '" target="_blank">Ver Contato</a>
                
		<!----
		<div class="fb_pos">
		<div class="fb-like" data-href="https://www.empregue-me.com/novo/servico.php?id=' . $free_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
		-->                                    	
                <!--máximo de 620 characteres aqui na descrição-->                 
    </div>

<!--termina VAGA-->';
    // <div class="vaga_conteudo">	
}

function imprimi_freelancer_edicao($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $cidade, $estado, $free_vip) {
    if ($free_vip == 1) {//VAGA EXCLUSIVA
        $layout_vaga = '<div class="vaga_exclusiva">';
        $vaga_logo = 'vaga_logo_exclusiva';
        $vaga_detalhe = 'vaga_detalhe_exclusiva';
        $vaga_settings = 'coroa.png';
    } else {//VAGA COMUM
        $layout_vaga = '<div class="vaga">'; //se nao for, mostra layout padrão
        $vaga_logo = 'vaga_logo';
        $vaga_detalhe = 'vaga_detalhe';
        $vaga_settings = 'settings2.png';
    }

    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "SELECT cargo.descricao,cat.descricao FROM freelancer_cargo cargo, freelancer_categoria cat WHERE cat.id = cargo.fk_freecategoria_id AND cargo.id = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $fk_freecargo_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_cargo, $r_categoria);
    while ($stmt->fetch()) {
        
    }
    $stmt->close();
    /*
     * dados do servico
     */
    //nome do candidato
    $nome = explode(" ", $usu_nome);
    //ajusta data
    $data_hora = explode(" ", $free_dt_cadastro);
    $data = explode('-', $data_hora[0]);
    $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];
    //foto do prestador
    $local_foto_real = "../upload/gfx/perfil/usu_" . $usu_codigo . ".jpeg";
    $usu_foto = '<img src="' . $local_foto_real . '" class="vaga_logo_img" width="38" height="38"/>'; //se user tiver foto cadastrada, deixa como cadastrada...
    //preco servico
    if ($free_preco == 0.00) {
        $free_preco = "Á combinar";
    } else {
        $free_preco = "R$ " . $free_preco . ' ' . $free_pos_preco;
    }
    //turno
    if ($free_turno == "Geral") {
        $free_turno = "Matutino, Vespertino e Noturno";
    }


    if (!file_exists($local_foto_real)) {//troca foto para foto de usuario anonimo, se nao tiver foto cadastrada
        $usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" width="38" height="38"/>';
    }

    echo '<!--inicia VAGA-->
	' . $layout_vaga . '
<a href="servico.php?id=' . $free_codigo . '" target="_blank">
				<strong>Serviço: </strong> ' . $r_categoria . ' - ' . $r_cargo . '<br />
				<strong>Local: </strong> ' . $cidade . ', ' . $estado . '<br />
				<strong>Preço do serviço: </strong>' . $free_preco . '<br />
                                <strong>Turno: </strong> ' . $free_turno . '<br />
				<strong>O prestador é: </strong> ' . $free_tipo_trabalhador . '<br />
				<strong>Descrição: </strong> ' . $free_descricao . '<br />
		</a>

		<div class="vaga_data">Data: ' . $data_ajustada . '</div>

		
		<div class="' . $vaga_logo . '">
        	' . $usu_foto . '
        </div>
    	<div class="' . $vaga_detalhe . '"></div>
    	<div class="vaga_titulo"><strong><span class="vermelho_destaque">' . $nome[0] . ' ' . $nome[1] . '</span></strong> oferece:</div>
                 
        <div class="vaga_settings"><img src="gfx/ui/' . $vaga_settings . '" /></div>   
	
		<a class="candidatar" href="servico.php?id=' . $free_codigo . '" target="_blank">Ver Contato</a>
                    <input type="hidden" name="servico_codigo" value=' . $free_codigo . ' />
                        <input type="hidden" name="free_vip" value=' . $free_vip . ' />
                
      	<div class="vaga_editar">			
				<img src="gfx/ui/deletar_vaga.png" class="vaga_editar_img" alt="deletar vaga" style="margin-left:15px;"/>
				<div class="vaga_editar_item"><a href="#" class="deletar_servico"> Deletar</a></div>
		</div>                
    </div>

<!--termina VAGA-->';
    // <div class="vaga_conteudo">	
}

?>