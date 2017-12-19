<?php

session_start();

function carrega_e_constroi_cv($inicio, $fim) {
        $dt_hoje = date("Y-m-d");//data de hoje, para consulta
	
	//inicia conexão
    require_once('../classes/connect_class.php');
    $connect = new ConnectionFactory;
    $mysqli = $connect->getConnection();
	   mysqli_set_charset($mysqli, "utf8");
   //  $mysqli->set_charset("utf8");
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
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1 AND area_formacao.id != 259 ORDER BY curriculos.id LIMIT $inicio, $fim
   ";
    $stmt = $mysqli->prepare($qry);
    $stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao);

    $tem_resultado = false;
    while ($stmt->fetch()) {
        $tem_resultado = true;


        //Vamos fazer nova conexão para tentar capturar em qual empresa o usuário trabalhou

      $connect = new ConnectionFactory;
    $mysqli2 = $connect->getConnection();
	   mysqli_set_charset($mysqli2, "utf8");
       
	   
	  // echo $usu_codigo;
	   
       // $mysqli2->set_charset("utf8");

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

require_once('../funcoes/funcoes_estruturais.php');
$output = '';//cria variável que armazena html que vai ser retornado 

        //constrói currículo do usuário
        $html_vaga = constroi_cv($usu_codigo, $usu_nome, $usu_nickname, $usu_cnh, $usu_disp_viagem, $usu_disp_horario, $usu_pret_salarial, $usu_ingles, $usu_ingles_nivel, $usu_office, $usu_office_nivel, $usu_area_formacao, $usu_estado, $usu_cidade, $usu_curriculo_dt_criacao, $usu_empresa, $cnh, $disp_viagem, $usu_disp_horario, $ingles, $office, $usu_pret_salarial,true);

        $output .= $html_vaga;

        return $output;
    }//end if vaga ativa	
}

?>