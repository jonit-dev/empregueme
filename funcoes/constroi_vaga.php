<?php

session_start();

function url_exists($url) {
    // Version 4.x supported
    $handle   = curl_init($url);
    if (false === $handle)
    {
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



function carrega_e_constroi_vaga($inicio, $fim, $query = 'padrao') {
        $dt_hoje = date("Y-m-d");//data de hoje, para consulta
	if($query == 'padrao')//se nao passou query específica para carregar (geralmente quando passa é porque vem da busca), vamos carregar a query padrão para consulta
		{
			    $qry = "SELECT vagas.vag_codigo, vagas.usu_codigo, vagas.cid_codigo, vagas.cat_codigo, vagas.vag_nome, vagas.vag_email, vagas.vag_descricao, vagas.vag_salario, vagas.vag_dt_inicio, vagas.vag_dt_termino, vagas.vag_ativo, vagas.vag_empresa, vagas.vag_qtd, vagas.vag_destaque, vagas.vag_exclusivo, vagas.vag_link, vagas.vag_telefone, vagas.vag_tipo, cid.nome, es.sigla
FROM vagas vagas, cidades cid, estados es
WHERE vagas.vag_ativo = 1
AND vagas.vag_dt_termino >=  '$dt_hoje'
AND vagas.cid_codigo = cid.cod_cidades
AND cid.estados_cod_estados = es.cod_estados ORDER BY vagas.vag_dt_inicio DESC LIMIT $inicio,$fim";
		}
	if($query != 'padrao')
	{
		$query = str_ireplace(' LIMIT 20',' LIMIT '.$inicio.','.$fim,$query);
		$qry = $query;
		//echo $qry;
	}
	
	
	//inicia conexão
    require_once('../classes/connect_class.php');
    $connect = new ConnectionFactory;
    $mysqli = $connect->getConnection();
    mysqli_set_charset($mysqli, "utf8");


    $stmt = $mysqli->prepare($qry);
    $stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($r_vag_codigo, $r_vag_usu_codigo, $r_vag_cid_codigo, $r_vag_cat_codigo, $r_vag_nome, $r_vag_email, $r_vag_descricao, $r_vag_salario, $r_vag_dt_inicio, $r_vag_dt_termino, $r_vag_ativo, $r_vag_empresa, $r_vag_qtd, $r_vag_destaque, $r_vag_exclusivo, $r_vag_link, $r_vag_telefone, $r_vag_tipo, $r_vag_cidade_nome, $r_vag_estado_nome);
    $output = '';
    while ($stmt->fetch()) {
        //ajusta data
        //ajusta data
        $data = explode('-', $r_vag_dt_inicio);
        $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];


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
        $connect = new ConnectionFactory;
        $mysqli2 = $connect->getConnection();
        $qry = "SELECT count(*) as cont FROM vagas vag,curriculos_vagas currVag 
            WHERE currVag.vag_codigo = vag.vag_codigo
            AND vag.vag_codigo = ?";
        $stmt2 = $mysqli2->prepare($qry);
        $stmt2->bind_param('i', $r_vag_codigo);
        $stmt2->execute();
		$stmt2->store_result();
        $stmt2->bind_result($r_vag_candidatos);
        while ($stmt2->fetch()) {
            //pluraliza ou nao a palavra candidatos
            if ($r_vag_candidatos == 1) {
                $palavra_cand = "candidato";
            } else {
                $palavra_cand = "candidatos";
            }
        }
        $stmt2->close();
        $mysqli2->close();

	 		//verifica se o usuário é membro VIP para mostrar email
		$mostra_email = '';
					if(isset($_SESSION['membro_vip_ativo']))
		{
			if($_SESSION['membro_vip_ativo'] == 1)
				{
					$mostra_email = '<strong>E-mail:</strong> ' . $r_vag_email. '<br />';
				}
			else
			{
					$mostra_email = '<strong>E-mail:</strong><a href="membro_vip.php"> <span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';	
			}
		}
		else
		{
							$mostra_email = '<strong>E-mail:</strong><a href="membro_vip.php"> <span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';	
	
		}
		 
        //verifica se precisa mostrar telefone
        if ($r_vag_telefone == "") {
            $mostra_telefone = "";
        } else {
					if(isset($_SESSION['membro_vip_ativo']))
		{
            //verifica se o usuário é membro VIP
			if($_SESSION['membro_vip_ativo'] == 1)
				{
					$mostra_telefone = '<strong>Telefone:</strong> ' . $r_vag_telefone . '<br />';
				}
			else
			{
				$mostra_telefone = '<strong>Telefone:</strong> 
				<a href="membro_vip.php"><span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';	
			}
		}
		else
		{
			$mostra_telefone = '<strong>Telefone:</strong> 
				<a href="membro_vip.php"><span class="vermelho_destaque">Conteúdo exclusivo para VIPs - Clique Aqui e Crie Sua Conta</span></a><br />';	
		}
        }
		


//primeiro verifica se é candidato proveniente do adwords! Se for, todas as vagas ficam como pagas!

        if (empty($_SESSION['login']) || !isset($_SESSION['login'])) {
			
			if(isset($_SESSION['adwords']))
			{
						 $r_curriculo = '<a class="candidatar" href="main.php?freetrial=true">Candidatar</a>';	
			}
				else
			{
			$r_curriculo = '<a class="candidatar" href="index.php?aviso=1">Candidatar</a>';
			}
			
			
            
        } else {
            //vamos verificar se é vaga VIP
            //verifica curriculo e mostra se ele é habilitado ou não para enviar para vaga
            if ($_SESSION['curriculo'] == 0) { // curriculo = 0 o candidato nao criou o curriculo
                if ($_SESSION['tipo_conta'] == 0) {
                    $r_curriculo = '<a class="candidatar" href="main.php?mostra_alerta=semcv">Candidatar</a>';//se user não cadastrou cv...
                } else {
                    $r_curriculo = "";
                }
            } else {
                //verifica se o candidato ja enviou currículo
                $connect = new ConnectionFactory;
                $mysqli3 = $connect->getConnection();
                $qry = "SELECT count(*) as qtd FROM curriculos_vagas where curr_codigo = ? and vag_codigo = ?";
                $stmt3 = $mysqli3->prepare($qry);
                $curriculo = $_SESSION['curriculo'];
                $stmt3->bind_param('ii', $curriculo, $r_vag_codigo);
                $stmt3->execute();
				$stmt3->store_result();
                $stmt3->bind_result($r_qtd);
                while ($stmt3->fetch()) {
                    
                }
                if ($r_qtd == 1) { //se o resultado for 1 o candidato nao pode se candidatar, caso contrario ele está apto.
                    $r_curriculo = '<h4 style="color:#6ac824;">Voce já se candidatou a essa vaga</h4>';
                } else {
                    if ($r_vag_exclusivo == 1 && $_SESSION['membro_vip_ativo'] != 1) {//Se a vaga é exclusiva e o cara não é VIP
                        $r_curriculo = '<a class="candidatar" href="membro_vip.php" target="_blank">Seja VIP</a>'; //mostra pra ser VIP
                    } else {// se não for exclusiva, pode candidatar
                        //$link = "http://localhost/empre941/novo/curriculo/envio/envia_curriculo/" . $_SESSION['userid'] . "/" . $r_vag_codigo; //offline
                       // $link = "http://www.empreguemeagora.com.br/novo/curriculo/envio/envia_curriculo/" . $_SESSION['userid'] . "/" . $r_vag_codigo; //online
					   
					   
						//candidatar via ajax
						$r_curriculo = '
							<input type="hidden" name="userid" value="'.$_SESSION['userid'].'"/>
							<input type="hidden" name="vaga_codigo" value="'.$r_vag_codigo.'"/>
							<a class="candidatar" href="javascript:void(0)">Candidatar</a>
							
							';	
					
                    					
                      //  $r_curriculo = '<a class="candidatar" href="' . $link . '">Candidatar</a>';
						
					
						
                    
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



if($r_vag_destaque == 1)//VAGA DESTAQUE
	{
	$layout_vaga = '<div class="vaga_destaque">';	
	$vaga_logo = 'vaga_logo_destaque';
	$vaga_detalhe = 'vaga_detalhe_destaque';
	$vaga_settings = 'vaga_destaque.png';
	}
	
	//ajusta salário
	if($r_vag_salario == 0)
		{
			$r_vag_salario = "À combinar";	
		}
		else
			{
				$r_vag_salario = 'R$ '.$r_vag_salario;
			}
			
		      $envia_mensagem = ''; //nao pode mostrar para quem n esta logado	
        if (isset($_SESSION['login'])) {
            $envia_mensagem = '<a href="envia_mensagem_empresa.php?id=' . $r_vag_codigo . '" class="btm_enviar_msg">Enviar Mensagem</a>';
        }	
	

        //--->> constroi vaga
        $html_vaga = '<!--inicia VAGA-->
	' . $layout_vaga . '<a name="vaga' . $r_vag_codigo . '"></a>

<a href="vaga.php?id=' . $r_vag_codigo . '" target="_blank">
				<strong>Empresa: </strong> ' . $r_vag_empresa . '<br />
				<strong>Local: </strong> ' . $r_vag_estado_nome . ', ' . $r_vag_cidade_nome . '<br />
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
   
        
        <div class="vaga_candidatos"><span class="vermelho_destaque"><strong>' . $r_vag_candidatos . ' ' . $palavra_cand . '</strong></span></div>
        
        <div class="vaga_settings"><img src="gfx/ui/' . $vaga_settings . '" /></div>
        
	
		
		<!----
		<div class="fb_pos">
		<div class="fb-like" data-href="https://www.empreguemeagora.com.br/vaga.php?id=' . $r_vag_codigo . '" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
		-->
		
        ' . $r_curriculo . '
        
    '.$envia_mensagem.'
                
                	
                <!--máximo de 620 characteres aqui na descrição-->
 
        
        
    </div>

<!--termina VAGA-->';

        $output .= $html_vaga;

        return $output;
    }//end if vaga ativa	
}

?>