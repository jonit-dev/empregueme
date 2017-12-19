<?php
header("Content-type:text/html; charset=utf-8");
require_once('../classes/connect_class.php');

class SimpleXMLExtended extends SimpleXMLElement // http://coffeerings.posterous.com/php-simplexml-and-cdata
{
  public function addCData($cdata_text)
  {
    $node= dom_import_simplexml($this); 
    $no = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
  } 
}



$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");

//PRIMEIRO VAMOS CRIAR A BASE DE NOSSO ARQUIVO DE FEED RSS

$xml = new SimpleXMLExtended('<?xml version="1.0" encoding="utf-8"?><trovit></trovit>');

require_once('../classes/date_management.php');
$gera_data = new date_management;

//$xml->addChild('publisher', 'Empregue-me');
//$xml->addChild('publisherurl', 'www.empregue-me.com');

//escreve data atual
$date_time = getdate(time());

$wday = $date_time['weekday'];
$mday = $date_time['mday'];
$month = $date_time['month'];
$year = $date_time['year'];
$hours = $date_time['hours'];
$minutes = $date_time['minutes'];
$seconds = $date_time['seconds'];

$data_formatada = $wday.", ".$mday." ".$month." ".$year." ".$hours.":".$minutes.":".$seconds." GMT";

//$xml->addChild('lastbuilddate',$data_formatada);




//AGORA VAMOS CARREGAR AS INFORMAÇÕES DA BD E GERAR O RSS

$qry = "SELECT 
v.vag_codigo,
cid.nome,
est.nome,
v.vag_nome,
v.vag_descricao,
v.vag_salario,
v.vag_empresa,
usu.usu_cep,
v.vag_tipo,
cat.cat_nome
FROM vagas as v, cidades as cid, estados as est, usuario as usu, categoria as cat
WHERE 
usu.usu_codigo = v.usu_codigo AND
v.cid_codigo = cid.cod_cidades AND
v.cat_codigo = cat.cat_codigo AND
cid.estados_cod_estados = est.cod_estados AND
v.vag_ativo = 1 AND 
v.vag_exclusivo = 0 AND
v.vag_dt_termino >= ?


";//somente vagas ativas e não VIP
$data_hoje = $gera_data->gera_data(time(),'eng',false);

$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$data_hoje);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($r_vag_codigo,$r_cid_nome,$r_est_nome,$r_vag_nome,$r_vag_descricao,$r_vag_salario,$r_vag_empresa,$r_vag_cep,$r_vag_tipo,$r_vag_cat_nome);
while($stmt->fetch())
	{
		//VAMOS PUXAR ALGUNS DADOS ANTES DA DB

		
		if(empty($r_vag_cep))
			{
			$r_vag_cep = '00000-000';	
			}
		
	$r_vag_descricao = str_replace("'","",$r_vag_descricao);	
	$r_vag_descricao = str_replace('"','',$r_vag_descricao);	
	
		
		
	$job = $xml->addChild('ad');	
	$job->addChild('id')->addCData($r_vag_codigo);
	$job->addChild('title')->addCData($r_vag_nome);
	$job->addChild('url')->addCData('http://empregue-me.com/novo/vaga.php?id='.$r_vag_codigo);
	$job->addChild('content')->addCData($r_vag_descricao);
	$job->addChild('city')->addCData($r_cid_nome);
	$job->addChild('city_area')->addCData('Sem informação');
	$job->addChild('region')->addCData($r_est_nome);
	$job->addChild('postcode')->addCData($r_vag_cep);
	$job->addChild('experience')->addCData('Sem Informação');
	$job->addChild('requirements')->addCData('Sem Informação');
	$job->addChild('studies')->addCData('Técnico-Operacional');
	$job->addChild('salary')->addCData($r_vag_salario);
	$job->addChild('working_hours')->addCData('Horário Comercial');
	$job->addChild('contract')->addCData($r_vag_tipo);
	$job->addChild('category')->addCData($r_vag_cat_nome);
	$job->addChild('company')->addCData($r_vag_empresa);
	$job->addChild('date')->addCData($data_formatada);
	
	}



$xml->asXML("rss.xml");


?>