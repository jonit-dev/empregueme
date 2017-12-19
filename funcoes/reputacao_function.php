<?php
function mostra_estrelas($r_qpositivas,$r_qnegativas)
{
	
//use essa função para calcular o percentual de qualificações positivas. Retorna o código das estrelas
	if($r_qpositivas != 0 || $r_qnegativas != 0)
{ 

$percentual_qualificacao = (5*$r_qpositivas)/($r_qpositivas+$r_qnegativas);


if($percentual_qualificacao == 0)
{
$mostra_estrelas = "
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	
}
elseif($percentual_qualificacao > 0 && $percentual_qualificacao < 1)
{
	$mostra_estrelas = "
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	
	
}
elseif($percentual_qualificacao >= 1 && $percentual_qualificacao < 2)
{
	$mostra_estrelas = "
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	
	
}
elseif($percentual_qualificacao >= 2 && $percentual_qualificacao < 3)
{
		$mostra_estrelas = "
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	
}
elseif($percentual_qualificacao >= 3 && $percentual_qualificacao < 4)
{
		$mostra_estrelas = "
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	
}

elseif($percentual_qualificacao == 5)
{
			$mostra_estrelas = "
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img'/>

";

}	 
}//end if qpositivas != 0
else
{
	$mostra_estrelas = "
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img'/>
";	

	
}
return $mostra_estrelas;

}//end function mostra estrelas

function calcula_detalhe_reputacao($var_detalhe_reputacao,$r_transacoes_vendas)
{
//use essa função para calcular o detalhe da reputação (Ex. item mesmo que o entregue, etc). Retorna o código das estrelas	
if($var_detalhe_reputacao != 0 || $r_transacoes_vendas != 0)
{ 

$percentual_qualificacao = ($var_detalhe_reputacao*5)/(10*$r_transacoes_vendas);


if($percentual_qualificacao == 0)
{
$mostra_estrelas = "
	<div class='reputacao_wrap'>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
	</div>
";	
}
elseif($percentual_qualificacao > 0 && $percentual_qualificacao < 1)
{
	$mostra_estrelas = "
	<div class='reputacao_wrap'>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
	</div>
";	
	
}
elseif($percentual_qualificacao >= 1 && $percentual_qualificacao < 2)
{
	$mostra_estrelas = "
	<div class='reputacao_wrap'>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
	</div>
";	
	
}
elseif($percentual_qualificacao >= 2 && $percentual_qualificacao < 3)
{
		$mostra_estrelas = "
		<div class='reputacao_wrap'>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
		</div>
";	
}
elseif($percentual_qualificacao >= 3 && $percentual_qualificacao <= 4)
{
		$mostra_estrelas = "
		<div class='reputacao_wrap'>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
		</div>
";	
}

elseif($percentual_qualificacao > 4 && $percentual_qualificacao <= 5 )
{
			$mostra_estrelas = "
			<div class='reputacao_wrap'>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/com_rep.png' alt='Com reputação' class='reputacao_img' style='margin-top:7px;'/>
			</div>
";

}	 
}//end if != 0
else
{
	$mostra_estrelas = "
		<div class='reputacao_wrap'>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
<img src='gfx/ui/sem_rep.png' alt='Sem reputação' class='reputacao_img' style='margin-top:7px;'/>
		</div>
";	

	
}
return $mostra_estrelas;

}


?>