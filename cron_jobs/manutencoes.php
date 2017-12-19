<?php
//SCRIPT DE ALGUMAS MANUTENÇÕES PARA EVITAR INTERVENÇÕES HUMANAS
//esse script é um CRON JOB DIARIO

//conecta 
require_once('connect_class.php');
require_once('date_management.php');
require_once('db_functions.php');

$gera_data = new date_management;

$hoje = $gera_data->gera_data(time(),'eng',false,'-');


$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
//Vamos colocar as vagas mais requisitadas como pagas
$qry = "UPDATE vagas SET vag_exclusivo = 1 WHERE 
vag_nome  LIKE '%recepcionista%'
 OR vag_nome LIKE '%secretaria%'
  OR  vag_nome LIKE '%administra%'
   OR vag_nome LIKE '%atend%'
    OR vag_nome LIKE '%técnico%'
	   OR vag_nome LIKE '%tecnico%'
 OR vag_nome LIKE '%vendedor%'
 OR vag_nome LIKE '%ESTÁGIO%'
  OR vag_nome LIKE '%ESTAGIO%'
 OR vag_nome LIKE '%gerente%'
 OR vag_nome LIKE '%financeir%'
 OR vag_nome LIKE '%supervisor%'
 OR vag_nome LIKE '%pedago%'
 OR vag_nome LIKE '%coordenador%'
 OR vag_nome LIKE '%gestor%'
 OR vag_nome LIKE '%analista%'
  OR vag_nome LIKE '%advoga%'
   OR vag_nome LIKE '%agente%'
 OR vag_nome LIKE '%almoxar%'
 OR vag_nome LIKE '%comerc%'
 OR vag_nome LIKE '%pessoal%'
  OR vag_nome LIKE '%logística%'
   OR vag_nome LIKE '%logistica%'
   OR vag_nome LIKE '%qualidade%'
   OR vag_nome LIKE '%humanos%'
   OR vag_nome LIKE '%RH%'
   OR vag_nome LIKE '%sistema%'
   OR vag_nome LIKE '%fiscal%'
   OR vag_nome LIKE '%arquitet%'
   OR vag_nome LIKE '%arquiv%'
   OR vag_nome LIKE '%assessor%'
   OR vag_nome LIKE '%arte%'
   OR vag_nome LIKE '%contábil%'
   OR vag_nome LIKE '%contab%'
   OR vag_nome LIKE '%faturam%'
   OR vag_nome LIKE '%logistica%'
   OR vag_nome LIKE '%marketing%'
   OR vag_nome LIKE '%operacion%'
   OR vag_nome LIKE '%escritório%'
   OR vag_nome LIKE '%escritorio%'
   OR vag_nome LIKE '%produção%'
   OR vag_nome LIKE '%producao%'
   OR vag_nome LIKE '%eletricista%'
   OR vag_nome LIKE '%engenheiro%'
   OR vag_nome LIKE '%estoquista%'
   OR vag_nome LIKE '%estudante%'
   OR vag_nome LIKE '%mecânico%'
   OR vag_nome LIKE '%motorista%'
   OR vag_nome LIKE '%caixa%'
   OR vag_nome LIKE '%professor%'
   OR vag_nome LIKE '%logistica%'
   
 OR vag_salario >= 1000
  
  
 AND vag_ativo = 1 AND vag_dt_termino >= ? AND vag_destaque != 1";//evita deixar vagas destaque como exclusivas
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('s',$hoje);
$stmt->execute();

$stmt->close();

//Agora vamos reativar algumas vagas antigas para sempre manter a BD com vagas

$periodo = 4*(2629800);//equivale há 2 meses 

$vag_dt_inicio = $gera_data->gera_data((time() - $periodo),'eng',false,'-');//vagas que iniciaram há 2 meses
$vag_dt_termino = $gera_data->gera_data((time() + $periodo),'eng',false,'-');//coloque para mais 2 meses de prazo 
//Vamos Reativar vagas antigas!
$qry = "UPDATE vagas SET vag_dt_termino = ? WHERE vag_dt_inicio > ?;";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('ss',$vag_dt_termino,$vag_dt_inicio);
$stmt->execute();


echo "Manutenção realizadao com sucesso";



?>