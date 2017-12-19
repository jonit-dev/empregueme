<?php
		function constroi_cv_compactado($nome_candidato,$usu_codigo,$cur_id,$vag_codigo)
	{
		//tamanho maximo do nome
		$nome_tamanho_max = 20;//caracteres
		$nome_candidato = substr($nome_candidato,0,$nome_tamanho_max);
		
		
		

		
			echo '<div class="box_candidato">
				<input type="hidden" name="usu_id" value="'.$usu_codigo.'"/>
				<input type="hidden" name="usu_cv_id" value="'.$cur_id.'"/>
				<div class="box_candidato_nome">
				<span class="vermelho_destaque"><a href="perfil.php?id='.$usu_codigo.'" target="_blank">'.$nome_candidato.'</a></span>
				</div>
				
				<div class="box_candidato_feedback">
					<span class="box_candidato_txt" style="margin-left:15px;"><a href="painel_gerencia_cv.php?rejeita='.$usu_codigo.'&vaga='.$vag_codigo.'" >Feedback</a></span>
				</div>
				
					<div class="box_candidato_contato">
					<span class="box_candidato_txt" style="margin-left:15px;"><a href="painel_gerencia_cv.php?id='.$usu_codigo.'&banner=contato">Contato</a></span>
				</div>
				
				<div class="box_candidato_favoritar">
					<span class="box_candidato_txt" style="margin-left:15px;"><a href="painel_gerencia_cv.php?add_favoritos='.$usu_codigo.'">Adicionar aos Favoritos</a></span>
				</div>
				
					<div class="box_candidato_ver_cv">
					<span class="box_candidato_txt" style="margin-left:15px;"><a href="perfil.php?id='.$usu_codigo.'" target="_blank">Ver Currículo</a></span>
				</div>
				
				
			</div>';
	}


class class_painel_cv
{

	
	function constroi_vaga_compactada($vag_codigo,$vag_dt_inicio,$vag_nome,$qt_candidatos)
	{
	
	//limita tamanho do nome da vaga em 15 caracteres

	$nome_tamanho_max = 32;//caracteres
		$vag_nome = substr($vag_nome,0,$nome_tamanho_max);
		
	//ajusta palavra candidatos
	$palavra_candidatos = 'Candidatos';
	if($qt_candidatos <= 1)
		{
		$palavra_candidatos = 'Candidato';	
		}
		
		
	echo '
	<div class="box_item_wrap">
	
<div class="box_vaga">
<input type="hidden" name="id_vaga" value="'.$vag_codigo.'"/>
	<div class="box_arrow"></div>

	<div class="box_calendar"><span style="margin-left:20px;">Anunciada em '.$vag_dt_inicio.'</span></div>
	

	
	<div class="box_titulo"><a href="vaga.php?id='.$vag_codigo.'" target="_blank">'.$vag_nome.'</a></div>
	
		<div class="box_candidatos"><span class="vermelho_destaque" style="margin-left:20px;">'.$qt_candidatos.' '.$palavra_candidatos.'</span></div>
		
		<div class="box_mostra_cv"><span class="vermelho_destaque" style="margin-left:25px;"><a href="javascript:void(0)" class="mostra_cv">Mostrar Currículos</a></span></div>
		</div>
		
		<div class="box_content">
		';
		
		//conecta à base de dados e puxa nomes de candidatos que enviaram CV para essa vaga em particular
		require_once('funcoes/db_functions.php');
		 $mysqli = mysqli_full_connection();
    	mysqli_set_charset($mysqli, "utf8");
		
		$qry = "SELECT
		usu.usu_nome,
		usu.usu_codigo,
		cur.id
		FROM usuario as usu, curriculos as cur, curriculos_vagas as curv
		WHERE
		
		curv.vag_codigo = ? AND
		curv.curr_codigo  = cur.id AND
		cur.fk_usu_codigo = usu.usu_codigo
		";
		$stmt = $mysqli->prepare($qry);
		$stmt->bind_param('i',$vag_codigo);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($usu_nome,$usu_codigo,$cur_id);
		
		while($stmt->fetch())
			{
				constroi_cv_compactado($usu_nome,$usu_codigo,$cur_id,$vag_codigo);
					
			}
		
		
		
		
		
		echo '
					
	
			
		
		</div>

</div>


';	
		
		
	}
	

	
}




?>