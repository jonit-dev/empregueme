<?php
//A finalidade desse email é filtrar os emails de empresas que foram coletados pela importação de email do usuário
set_time_limit(10000);//isso é pra nao dar erro de execução de script (tempo máximo) --> se for baixo (ex. 20) e tiver muitos emails, dá pau no script
require_once('../classes/connect_class.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();



/*
	[lista_email]
email_id
id_quem_enviou
nome_contato
email_contato
clicou_link
enviou_email
*/

//Acessa base de dados e filtra emails da lista 
//pega todos os emails da lista atual ===> EXCLUI EMAILS GRATUITOS + EMAIL DE EMPRESAS DE RH(geralmente nao sao de empresas)
$qry = "SELECT email_contato FROM lista_email WHERE email_contato NOT LIKE '%yahoo%' AND email_contato NOT LIKE '%gmail%' AND email_contato NOT LIKE '%hotmail%' AND email_contato NOT LIKE '%outlook%' AND email_contato  NOT LIKE '%terra%' AND email_contato  NOT LIKE '%reply%' AND email_contato  NOT LIKE '%ig%' AND email_contato  NOT LIKE '%uol%' AND email_contato  NOT LIKE '%facebook%' AND email_contato  NOT LIKE '%bol%' AND email_contato  NOT LIKE '%live%' AND email_contato  NOT LIKE '%ymail%' AND email_contato  NOT LIKE '%pop%' AND email_contato  NOT LIKE '%msn%' AND email_contato  NOT LIKE '%recrutamento%' AND email_contato  NOT LIKE '%rh%' AND email_contato  NOT LIKE '%dp%' AND email_contato  NOT LIKE '%vagas%' AND email_contato  NOT LIKE '%naorespo%'";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($emails_nao_rh);
$lista_email_atual = array();
$i = 0;
while($stmt->fetch())
	{
		$lista_email_atual[$i] = $emails_nao_rh;//adiciona emails da base de dados em uma array, para uso posterior.
		$i++;
			
	}

//echo "Exclusao email gratuitos e rh===>".count($lista_email_atual)."</br>";	
	
$stmt->close();

//pega todos os emails da lista atual  ===> SOMENTE EMPRESAS DE RH
$qry = "SELECT email_contato FROM lista_email WHERE email_contato LIKE '%rh%' OR email_contato LIKE '%dp%' OR email_contato LIKE '%recrutamento%' OR email_contato LIKE '%humanos%' OR email_contato LIKE '%vagas%' OR  email_contato LIKE '%empregos%' OR email_contato LIKE '%contrata%' OR email_contato LIKE '%curriculo%' OR email_contato LIKE '%comercial%' OR  email_contato LIKE '%recruta%' OR  email_contato LIKE '%selecao%' OR email_contato LIKE '%contato%'";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($emails_rh);
while($stmt->fetch())
	{

		
		$lista_email_atual[$i] = $emails_rh;//adiciona emails da base de dados em uma array, para uso posterior.
		$i++;
			
	}
		
$stmt->close();


//echo "Adicao empresas rh===>".count($lista_email_atual)."</br>";

//pega todos os emails da lista atual ===> EMAILS DA TABELA VAGAS
$qry = "SELECT vag_email FROM vagas";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($emails_vagas);
while($stmt->fetch())
	{
		$lista_email_atual[$i] = $emails_vagas;//adiciona emails da base de dados em uma array, para uso posterior.
		$i++;
			
	}
	
$stmt->close();


//echo "Adicao email vagas===>".count($lista_email_atual)."</br>";


//agora vamos fazer outra requisição, mas dessa vez na tabela lista_email_empresas, para checar se os emails da array já foram inseridos na lista de empresas. Se já foram, não insere novamente para evitar emails duplicados. Se não foram, registre um novo email

$lista_registro = array(); //essa lista armazena quais emails realmente devem ser registrados na tabela lista_email_empresas
$j = 0;
for($i=0;$i<count($lista_email_atual);$i++)
{
$resultado = $qry = "SELECT email_contato FROM lista_email_empresas WHERE email_contato = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$lista_email_atual[$i]);
$stmt->execute();
$stmt->bind_result($email_empresa);
$tem_resultado = false;
while($stmt->fetch())
	{	
	$tem_resultado = true;
	}
	if($tem_resultado == false)
		{
			$lista_registro[$j] = $lista_email_atual[$i];
			$j++;	
		}

}
	
$stmt->close();


//echo "LISTA REGISTRO VIRGEM ===>".count($lista_registro)."</br>";
//antes de inserir, vamos remover os valores duplicados da array
//converte tudo para lowercase antes para comparação depois

function array_iunique($array) {
    return array_intersect_key($array,array_unique(
                 array_map('strtolower',$array)));
}

$lista_registro_sem_duplicados = array_iunique($lista_registro);//remove valores duplicados


//echo "LISTA REGISTRO FILTRADA ===>".count($lista_registro_sem_duplicados)."</br>";
//pronto =)
//agora vamos registrar os resultados na lista_email_empresas

$emails_add = 0;//armazena quantos emails foram realmente inseridos na BD



for($i=0;$i<count($lista_registro_sem_duplicados);$i++)
{
	
	//verifica se dado não está vazio, antes de inserir

if(isset($lista_registro_sem_duplicados[$i]))
{
	if(!empty($lista_registro_sem_duplicados[$i]) || strlen($lista_registro_sem_duplicados[$i]) != 0)//evita inserir valores nulos
	{
	
$qry = "INSERT INTO lista_email_empresas VALUES (null,0,0,?,0,0)";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$lista_registro_sem_duplicados[$i]);
$stmt->execute();
$emails_add += $stmt->affected_rows;
$stmt->close();
	}
}
}




$mysqli->close();
//print_r($lista_filtrada);
echo '<h1>Filtro de emails empresariais realizado com sucesso</h1>

'.$emails_add.' emails adicionados ( apos excluir valores nulos e duplicados! ).
';

?>