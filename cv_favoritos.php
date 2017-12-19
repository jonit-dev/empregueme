<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');
require_once('classes/gerenciador_painel_class.php');
require_once('funcoes/db_functions.php');

if (session_id() == '') {
    session_start();
}


check_plano_recrutador();


$painel_cv = new class_painel_cv;//cria classe de gerenciamento de painel 


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado




$display_main->head('','');

$display_main->topo(false);


$display_main->painel_esquerda();

echo '<h1>Meus Candidatos Favoritos</h1>

<p>Nesta página se encontra todos os seus currículos salvos como favoritos, para que você possa analisar com mais calma depois.</p>

<h5>Últimos Candidatos Favoritos</h5>
';

	require_once('funcoes/funcoes_estruturais.php');

    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
	
	
	
	$qry = "
	SELECT 
	fv.fav_cv_favoritado,
	fv.fav_quem_favoritou,
	fv.fav_dt_registro FROM cv_favoritos as fv 
	WHERE
	fv.fav_quem_favoritou = ?
	";
	$stmt = $mysqli->prepare($qry);
	$stmt->bind_param('i',$_SESSION['userid']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($fav_cv_favoritado,$fav_quem_favoritou,$fav_dt_registro);
	$tem_resultado = false;
	while($stmt->fetch())
		{
		
		$tem_resultado = true;
	$fav_cv_favoritado = $fav_cv_favoritado;
	
	    $mysqli2 = mysqli_full_connection();
    mysqli_set_charset($mysqli2, "utf8");
	//puxa informações de usuário favoritado
	 $qry2 = "SELECT 
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
   curriculos.fk_usu_codigo = ? AND
   curriculos.fk_habilidades_id = habilidades.id AND
   curriculos.fk_formacao_id = formacao.id  AND
   formacao.fk_area_formacao_id = area_formacao.id AND
  usuario.cid_codigo = cidades.cod_cidades AND
cidades.estados_cod_estados = estados.cod_estados AND curriculos.ativo = 1 AND area_formacao.id != 259 ORDER BY curriculos.id DESC";
$stmt2 = $mysqli2->prepare($qry2);
$stmt2->bind_param('i',$fav_cv_favoritado);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($usu_codigo,$usu_nome,$usu_nickname,$usu_cnh,$usu_disp_viagem,$usu_disp_horario,$usu_pret_salarial,$usu_ingles,$usu_ingles_nivel,$usu_office,$usu_office_nivel,$usu_area_formacao,$usu_estado,$usu_cidade,$usu_curriculo_dt_criacao);

while($stmt2->fetch())
	{
		 //Vamos fazer nova conexão para tentar capturar em qual empresa o usuário trabalhou

        $mysqli3 = mysqli_full_connection();
        mysqli_set_charset($mysqli3, "utf8");

        $qry3 = "SELECT
	 hp.empresa
	 
	  FROM historicos_profissionais as hp, curriculos as cur, usuario as usu 
	  
	  WHERE  
      hp.fk_curriculos_id = cur.id AND
      cur.fk_usu_codigo = usu.usu_codigo AND
      usu.usu_codigo = ?";

        $stmt3 = $mysqli3->prepare($qry3);
        $stmt3->bind_param('i', $usu_codigo);
        $stmt3->execute();
		$stmt3->store_result();
        $stmt3->bind_result($r_usu_empresa);

        $usu_empresa = '';
        $tem_resultado_empresa = false;
        while ($stmt3->fetch()) {
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
	}	
	
	
	//constroi post cv

		
	}
	
	if($tem_resultado == false)
		{
			echo '<p>Você ainda não adicionou nenhum candidato aos favoritos. Acesse seu <a href="painel_gerencia_cv.php" target="_self"><b class="vermelho_destaque">Painel de Gerencimento de currículos</b></a> para adicionar alguns usuários</p>';	
		}
		
			
		
		if(isset($mysqli))
			{
				$mysqli->close();		
			}
			
				if(isset($mysqli2))
			{
				$mysqli2->close();		
			}
			
				if(isset($mysqli3))
			{
				$mysqli3->close();		
			}
		

$display_main->painel_direita();
$display_main->fundo();
?>


