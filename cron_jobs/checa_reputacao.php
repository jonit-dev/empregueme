<?php
//esse script deverá ser rodado a cada 14 dias, verificando a data de registro da reputação de cada usuário. Se tiver mais de 14 dias de registro e o usuário não realizou a qualificação da outra parte, tal qualificação é dada como neutra.

//deve rodar diariamente






//conecta diretamente
require_once('../classes/connect_class.php');
require_once('../funcoes/db_functions.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "SELECT 
transacoes.data,
transacoes.transacao_id,
transacoes.status_comprador,
transacoes.status_vendedor,
transacoes.comprador,
transacoes.vendedor

 FROM transacoes WHERE status_comprador = 0 OR status_vendedor = 0";

$stmt = $mysqli->prepare($qry) or die("Could not prepare query");
$stmt->execute();
$stmt->bind_result($r_data,$r_transacao_id,$r_status_comprador,$r_status_vendedor,$r_comprador_id,$r_vendedor_id);

$tem_resultado = false;

$diferenca_maxima = 14;//essa variável armazena quantos dias no máximo o usuário pode ficar sem dar a qualificação. Após esse dia, a transação é qualificada como neutra! Padrão são 14 dias de prazo máximo para qualificar.

$lista_alteracoes = array();
//armazena data de hoje
$agora = time();
$data_agora = getdate($agora);
$dia_ano_agora = $data_agora['yday'];


	while($stmt->fetch())	
		{
			
			$tem_resultado = true;
			
			$data = getdate($r_data);
			$dia_ano_transacao = $data['yday'];//calcula qual n° do dia do ano ocorreu a transação
			$diferenca_dias = $dia_ano_agora - $dia_ano_transacao;//calcula a diferença em dias entre a data de hoje e quanto ocorreu a transação
			
			
			echo "TRANSACAO: $r_transacao_id </br>
				DIA_ANO_AGORA: $dia_ano_agora </br>
				DIA_ANO_TRANSACAO: $dia_ano_transacao </br>
				DIF DIAS: $diferenca_dias dias </br>
				DIF MAX: $diferenca_maxima dias</br>
				######";
			
			
			if ($diferenca_dias >= $diferenca_maxima)//se já passou do prazo para qualificação e n qualificou ainda
				{
				
				//se o comprador quem esqueceu de qualificar
					if($r_status_comprador == 0 || $r_status_vendedor == 0)
						{
							//adicionar a lista para alterarmos depois
							array_push($lista_alteracoes,$r_transacao_id."|".$r_comprador_id."|".$r_vendedor_id."|".$r_status_comprador."|".$r_status_vendedor);
							
						}
								
			
			//vamos alterar algumas coisas
			
				
				}
			
		}//end while fetch
require_once('../funcoes/array_functions.php');
dump_array($lista_alteracoes);




//agora que criamos a lista, vamos iniciar as alterações
clean_stmt();//fecha stmt para realizarmos novos qrys

for($i=0;$i<count($lista_alteracoes);$i++)
{
$lista = explode("|",$lista_alteracoes[$i]);



//============ QUALIFICAÇÃO AUTOMÁTICA DO COMPRADOR============

//primeiro verifica se é o comprador que nao emitiu a qualificação
if($lista[3] == 0)//status comprador = 0
	{
	//REGISTRA REPUTAÇÃO AUTOMÁTICA
	  $justificativa = "Qualificação automática do vendedor realizada pois prazo para qualificar ultrapassou 14 dias.";
	  $data = time();//data de hoje
	  $comprador_id = $lista[1];
	  $vendedor_id = $lista[2];
	 
	 
	  $qry = "INSERT INTO reputacao_registro VALUES(NULL, ?, ?, ?, 0, 10, 10, 10, 10, ?, 1)";//1 no final porque ele tá qualificando uma venda (se o stauts do comprador é 0, é porque ele deve qualificar uma venda que nao qualificou - e vice versa!-)
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param('iiis',$comprador_id,$vendedor_id,$data,$justificativa);
	  $stmt->execute();
	
	
	  clean_stmt();
	
		//atualiza status do comprador
	  $qry = "UPDATE transacoes SET status_comprador = 1 WHERE transacao_id = ?";
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param("i",$lista[0]);//binda transacao id
	  $stmt->execute();
	  
	  //agora atualiza reputacao_usuario vendedor
	    clean_stmt();
	  $qry = "UPDATE reputacao_usuario SET qneutras = qneutras + 1, item_mesmo = item_mesmo + 10, rapidez_resposta = rapidez_resposta + 10, tempo_entrega = tempo_entrega + 10, qualidade_produto = qualidade_produto + 10, transacoes_vendas = transacoes_vendas + 1 WHERE userid = ?";
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param("i",$vendedor_id);//binda transacao id
	  $stmt->execute();
	  
	  
echo "TRANSAÇÃO: ".$lista[0]." / COMPRADOR: ".$lista[1]."==> Qualificação automática realizada com sucesso";
	}//end qualificação automática do comprador
	
	
	
//============ QUALIFICAÇÃO AUTOMÁTICA DO VENDEDOR============

//primeiro verifica se é o comprador que nao emitiu a qualificação
if($lista[4] == 0)//status vendedor = 0
	{
	//REGISTRA REPUTAÇÃO AUTOMÁTICA
	  $justificativa = "Qualificação automática do comprador realizada pois prazo para qualificar ultrapassou 14 dias.";
	  $data = time();//data de hoje
	  $comprador_id = $lista[1];
	  $vendedor_id = $lista[2];
	 
	 
	  $qry = "INSERT INTO reputacao_registro VALUES(NULL, ?, ?, ?, 0, 10, 10, 10, 10, ?, 0)";//0 no final porque ele tá qualificando uma compra
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param('iiis',$vendedor_id,$comprador_id,$data,$justificativa);
	  $stmt->execute();
	
	
	  clean_stmt();
	
		//atualiza status do vendedor
	  $qry = "UPDATE transacoes SET status_vendedor = 1 WHERE transacao_id = ?";
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param("i",$lista[0]);//binda transacao id
	  $stmt->execute();
	  
	  //agora atualiza reputacao_usuario comprador
	    clean_stmt();
	  $qry = "UPDATE reputacao_usuario SET qneutras = qneutras + 1, item_mesmo = item_mesmo + 10, rapidez_resposta = rapidez_resposta + 10, tempo_entrega = tempo_entrega + 10, qualidade_produto = qualidade_produto + 10, transacoes_compras = transacoes_compras + 1 WHERE userid = ?";
	  $stmt = $mysqli->prepare($qry);
	  $stmt->bind_param("i",$comprador_id);//binda transacao id
	  $stmt->execute();
	  
	  
	}//end qualificação automática do comprador

echo "TRANSAÇÃO: ".$lista[0]." / VENDEDOR: ".$lista[2]."==> Qualificação automática realizada com sucesso";
	


}



?>