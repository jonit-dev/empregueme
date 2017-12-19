<?php

function products_load()
{
	//vamos iniciar carregamento da listagem de produtos
$mysqli = mysqli_full_connection('localhost','normal_user','32258190','projeto_rsc','Could not connect to database');
			
			
			//vamos iniciar capturando cidade, estado do vendedor
					
			
			
			
			
			$qry = "SELECT produtos.produto_id,
			produtos.userid,
			produtos.produto_tag,
			produtos.produto_titulo,
			produtos.produto_data,
			produtos.produto_preco,
			produtos.produto_total_compras,
			produtos.produto_foto,
			tb_cidades.uf,
			tb_cidades.nome,
			perfil_usuario.nickname
			 FROM produtos, tb_cidades, perfil_usuario WHERE produtos.userid = perfil_usuario.userid AND perfil_usuario.estado_id = tb_cidades.estado AND perfil_usuario.cidade_id = tb_cidades.id";
			$stmt = $mysqli->prepare($qry);
			$stmt->execute();
			$stmt->bind_result($r_produto_id,$r_userid,$r_produto_tag,$r_produto_titulo,$r_produto_data,$r_produto_preco,$r_produto_total_compras,$r_produto_foto,$estado_nome,$cidade_nome,$r_nickname);
			
			//se tiver resultado
			$tem_resultado = false;
			while($stmt->fetch())//quando tiver resultado
			{
				$tem_resultado = true;
				
				//ajusta algumas informações
				$r_produto_tag = ucfirst($r_produto_tag);
				$data = getdate($r_produto_data);
				$dia = $data["mday"];
				$mes = $data["mon"];
				$ano = $data["year"];
				
				settype($r_produto_preco,'string');
				$preco = explode(".",$r_produto_preco);
				$reais = $preco[0];
					if (isset($preco[1]))
						{
				$centavos = $preco[1];
				
				//concertar centavos
				if(strlen($centavos) == 1)
					{
					//se só tem um dígito é porque cortou o 0
					$centavos = $centavos."0";//adiciona 0 no final	
					}	
						}
						else
						{
						$centavos = "00";
						}
					
					$r_produto_tag = strtolower($r_produto_tag);
				$r_produto_tag = ucwords($r_produto_tag);
						
				$local_foto = '../upload/gfx/produtos/'.$r_userid.'/'.$r_produto_id.'/'.$r_produto_foto;
		
				echo '
				
				
	<a href="anuncio.php?id='.$r_produto_id.'">	
				<div class="anuncio">	
<div class="box_tipo"></div>
<div class="produtos_vendidos"><center>'.$r_produto_total_compras.'</center></div>

<img src="'.$local_foto.'" />
<div class="price_tag">
</div>

<span class="reais_grande">'.$reais.'</span><span class="centavos_grande">,'.$centavos.'</span>
<div class="anuncio_descricao"><div class="description_txt">'.$r_produto_titulo.'</div></div>


<div class="produto_nome">
'.$r_produto_tag.'
</div>

<div class="produto_local">
'.$cidade_nome.', '.$estado_nome.'
</div>

<div class="produto_data">
'.$dia.'/'.$mes.'/'.$ano.'
</div>

<img src="gfx/ui/map_point.png" class="produto_map_point"/>

<div class="info">

<div class="info_txt">

<div class="dados_vendedor">
<span class="nome_vendedor">'.$r_nickname.'</span><span class="reputacao_vendedor"> (1400)</span>
</div>
</div><!--end dados vendedor-->


<div class="reputacao_div">
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
<img src="gfx/ui/com_rep.png" class="reputacao_img"/>
</div>

</div><!--end info txt-->
</a>
</div><!--end anuncios box-->';

				
				
				
				
			}		
		
		$stmt->close();
		$mysqli->close();
		//fecha conexão com base de dados e mostra o banner
	
	
}


?>