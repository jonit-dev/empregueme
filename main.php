<?php


//---------------------- GERENCIAMENTO DE PROPAGANDAS DO ADWORDS---------
if(isset($_GET['adwords']))//se é anuncio do adwords, vamos inserir cookie para deixar o site inteiro PAGO
{
session_start();
$_SESSION['adwords'] = true;//deixa o site todo pago
}

//carrega arquivo com o layout

require_once('funcoes/db_functions.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/top_functions.php');
require_once('funcoes/array_functions.php');
require_once('funcoes/alert_functions.php');

require_once('classes/display_main.php');
$display_main = new display_main; //associa uma variával à classe de carregamento do layout





//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS -->  salva em uma variável para utilizarmos em selects ao longo do site.
$_SESSION['categorias'] = "";
$mysqli = mysqli_full_connection();

$qry = "SELECT cat_codigo, cat_nome FROM categoria";

$stmt = $mysqli->prepare($qry);
$stmt->execute();

$stmt->bind_result($r_cat_codigo, $cat_nome);

while ($stmt->fetch()) {
    $_SESSION['categorias'] .= '<option value="' . $r_cat_codigo . '">' . utf8_encode($cat_nome) . '</option>';
}
$stmt->close();


/* 	$time = microtime();
  $time = explode(' ', $time);
  $time = $time[1] + $time[0];
  $start = $time; */
  
  

  


//============= CÓDIGO DO CARREGAMENTO DINAMICO
$carregamento_dinamico = '';

if(isset($_SESSION['tipo_conta']))//se o user está logado
{
if($_SESSION['tipo_conta'] == 0)//pessoa física
	{
	$js_carregamento_dinamico = '<script type="text/javascript" src="js/ajax_scroll_loading.js"></script>';	
	}
if($_SESSION['tipo_conta'] == 1)//empresa
	{
	$js_carregamento_dinamico = '<script type="text/javascript" src="js/ajax_scroll_loading_empresas.js"></script>';	
	}	
}
else//se n está logado, use padrão do usuário
	{
			$js_carregamento_dinamico = '<script type="text/javascript" src="js/ajax_scroll_loading.js"></script>';	
	}


//--------------- END CARREGAMENTO DINAMICO

$mostra_escolha_vip = '';
if(isset($_SESSION['membro_vip_ativo']))
{
if(($_SESSION['membro_vip_ativo'] == 0 || $_SESSION['membro_vip_ativo'] == 2) && $_SESSION['tipo_conta'] == 0)//se nao for VIP, mostra propaganda para escolher ser
{
	$mostra_escolha_vip = '      <script type="text/javascript" src="js/propaganda_vip_escolha.js"></script>';
	
}
}


$display_main->head('@import url(\'css/mini_popup.css\');', '<script type="text/javascript" src="js/desarma_botao.js"></script>   <!--SCROLL LOADING-->
'.$js_carregamento_dinamico.'
  
   <script type="text/javascript" src="js/funcoes_js/mostra_mini_popup.js"></script>
   
   <!--- ENVIO DE CURRICULOS-->
      <script type="text/javascript" src="js/envio_curriculo.js"></script>
	  
	  <!--- ESCOLHA VIP ----->
	  '.$mostra_escolha_vip.'
  ');





//-------------- BOX INFORMAÇÃO--------------//
/*
echo '<div id="info_box">
	<a href="https://pt.surveymonkey.com/s/ZV8Q9YD" target="_blank">Melhorias para o Empregue-me</a>
</div>
';*/


//--------------------- SISTEMA DE MINI POPUP---------------// 
require_once('funcoes/mini_popup_functions.php');
mini_popup();
//-------------------- SISTEMA DE MINI POPUP----------------//


//------------ ATUALIZACAO DE CARGO (Se estiver como Nenhum)-------------//

require_once('funcoes/atualiza_cargo_functions.php');
atualiza_cargo();

/*
 * Apos o cadastro do curriculo preciso chamar o refresh session
 */

if(isset($_SESSION['login']))//se tem uma seção em andamento
{
session_refresh();
}
$display_main->topo();


?>


<?php
//carrega painel de opções à esquerda
$display_main->painel_esquerda(true);

require_once('funcoes/funcoes_estruturais.php');


//-------------BOX FEEDBACK-------------
//somente vamos mostrar a box de feedback se o usuario estiver logado

if (!empty($_SESSION['userid'])) {//se está logado
    require_once('funcoes/box_feedback_functions.php');
    box_feedback_init();
}

//--end box feedback
//-+------------------------        ÁREA DE BUSCA -----------------------------------------//
//vamos verificar o tipo de conta do usuário e carregar as áreas de busca de acordo 
//carrega funcoes de busca
require_once('funcoes/funcoes_busca.php');


if (!isset($_SESSION['tipo_conta'])) { //se nao estiver logado...
    area_busca();
}
if (isset($_SESSION['tipo_conta'])) {
    if ($_SESSION['tipo_conta'] == 0) { //se for pessoa física
        //O manejo da estrutura da busca é feito em funcoes_estruturais.php
        area_busca();
    }
    if ($_SESSION['tipo_conta'] == 1) {//se for empresa
        //O manejo da estrutura da busca é feito em funcoes_estruturais.php
        area_busca_empresa();
    }
}

if (!isset($_GET['pesquisa'])) {//se nao passou nada pra pesquisar, carregue tudo
//////// ============= >>> CARREGAMENTO DE VAGAS
    //está em funções_estruturais.php		
//primeiro verifica qual o tipo de conta...
// Se for PESSOA FÍSICA --> VAMOS MOSTRAR AS VAGAS
//Se for empresa --> mostra os candidatos!
    if (empty($_SESSION['tipo_conta'])) {//se nao está logado
        carrega_vagas('all', false, 30, false); //só carrega vagas
    }


    if (!empty($_SESSION['tipo_conta'])) {//se estiver logado...
        switch ($_SESSION['tipo_conta']) {//mostra vagas ou post CV, conforme tipo de conta
            case 0://pessoa física
                carrega_vagas('all', false, 30, false);
                break;

            case 1://empresa
                constroi_post_cv();
                break;
        }
    }
}
?>

<!-- INICIA CARREGAMENTO DE SCRIPTS!-->


<!--SCRIPT DE CARREGAMENTO DOS SELECTS DOS BANNERS-->
<script type="text/javascript" src="js/select_load.js">
</script>

<!--SCRIPT DE CARREGAMENTO ==>>> AUTOCOMPLETE-->
<script type="application/javascript" src="js/autocomplete_action.js"></script>

<!--carrega plugin jquery para manejo do input preço-->
<script type="text/javascript" src="plugins_jquery/numero/autoNumeric.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('.preco').autoNumeric('init');
    });//end ready
</script>

<!--CÓDIGO PRA SOMENTE PERMITIR SOMENTE NUMEROS NO INPUT-->
<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<?php
//função para lidar com mensagens de sucesso ou error
//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
    switch ($_GET['tipo']) {//verifica o tipo da mensagem
        case 'sucesso'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'sucesso');
            break;
        case 'error'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'error');
            break;
    }
}


//MENSAGENS DE ALERTA
if (isset($_GET['mostra_alerta'])) {
    switch ($_GET['mostra_alerta']) {
        case 'semcv':

            if (isset($_GET['ref'])) {
                alerta_e_redireciona('Você ainda não cadastrou seu currículo! Clique em OK para criá-lo', 'curriculo.php?redireciona=' . $_GET['ref']);
            } else {
                alerta_e_redireciona('Você ainda não cadastrou seu currículo! Clique em OK para criá-lo', 'curriculo.php');
            }


            break;
    }
}

if (isset($_GET['flag']) && $_GET['flag'] == "free") {
	if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

	session_refresh();
    ?>
    <script type='text/javascript'>
        var a = confirm('Seu currículo já está na fila para envio e será enviado dentro de 48 horas! Clique em OK caso queira enviá-lo imediatamente, se tornando Membro VIP!');
        if (a) {
            top.location.href = "membro_vip.php";
        }
    </script>
    <?php
}
if (isset($_GET['flag']) && $_GET['flag'] == "vip") {
	if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

	session_refresh();
    ?>
    <script type='text/javascript'>
        alert('Seu currículo foi enviado com sucesso! Boa Sorte');  
    </script>
    <?php
}
//MANIPULAÇÃO DE BANNERS ==> deve vir após o conteúdo sempre! Se colocar antes do head nao funciona pois não terá carregado o jQuery
//CÓDIGO DOS BANNERS

if (isset($_GET["banner"])) {//se tá passando parametro por get do banner é porque quer mostrar o banner
    switch ($_GET["banner"]) {//avalia conteúdo da variável
        
		case 'curriculo':
            //$link = "http://www.empregue-me.com/novo/curriculo/curriculo/show/" . $_SESSION['userid']; //ONLINE
            //$link = "http://localhost/empre941/novo/curriculo/curriculo/show/" . $_SESSION['userid']; //OFFLINE
            if ($_SESSION['curriculo'] == 0) {//se usuário ainda não cadastrou o currículo...
                header ("Location curriculo.php");
            } else {
                alerta_e_redireciona('Você ainda não cadastrou seu currículo! Clique em OK para criá-lo', 'curriculo.php');
            }
            break;
        case 'envioautomatico':
            $link = "http://www.empregue-me.com/novo/curriculo/envioautomatico/add/" . $_SESSION['userid']; //ONLINE
            //$link = "http://localhost/empre941/novo/curriculo/envioautomatico/add/" . $_SESSION['userid']; //OFFLINE
            $display_main->show_banner("Envio automático de currículos", "<object border='0' style='overflow:hidden; width: 450px; height: 400px; border-style:none; ' data='" . $link . $_SESSION['userid'] . "'></object>", "small");
            break;


        case 'ativacao_andamento':
            $display_main->show_banner('Ativação de conta em andamento', '<p>A ativação de sua conta ainda está em andamento. Por favor, aguarde 3 dias <strong>úteis</strong> para que o processo seja completado com sucesso. Caso ocorra algum atraso superior a 5 dias, entre em contato com sac@empreguemeagora.com.br</p>', 'small');
            break;
    }//end switch
}
//End manipulação de banners
?>
<script type="text/javascript" src="js/estado_cidade_load.js"></script>

<?php

//resultado velocidade carregamento
/* $time = microtime();
  $time = explode(' ', $time);
  $time = $time[1] + $time[0];
  $finish = $time;
  $total_time = round(($finish - $start), 4);
  echo 'Page generated in '.$total_time.' seconds.'; */


//---------------AVISO DE VISITAS NO CURRÍCULO----

if(isset($_SESSION['userid']))//se usuario está logado...
{

	$qry = "SELECT visita_id FROM visitas_perfil WHERE
	visitado_id = ? AND visualizada = 0";

$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$_SESSION['userid']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($visita_id);
$numero_visitas_nao_vistas = 0;
$tem_resultado = false;
while ($stmt->fetch()) {
	$tem_resultado = true;
	$numero_visitas_nao_vistas++;//para cada resultado, adicione uma visita.... saberemos no total quantas visualizações do curriculo nao vistas ainda pelo usuário estão disponíveis
}
$stmt->close();

if($tem_resultado == true)
{

$display_main->noty('Existem '.$numero_visitas_nao_vistas.' empresas interessadas em seu currículo. Acesse a seção Quem viu meu CV no painel à esquerda para saber mais.','success','topCenter',6000);
}

}
	
//--- END AVISO VISITAS CURRICULO


//------------- CARREGAMENDO ASSINATURA ADWORDS----------------//


if(isset($_GET['freetrial']))
{
$display_main->show_banner('Para se Candidatar Seja Assinante VIP','
	
	<img class="foto_banner" src="gfx/plano_recrutador/images/banner_assinante_03.jpg"/> 
	
	<div class="txt_assinatura">
		<div class="titulo_assinatura">
			7 Dias Grátis
		</div>
		
		<div class="descr_assinatura">
		<p>Candidate-se sem limitações por 7 dias em todas as vagas do site! Se interessou? Clique no botão abaixo e saiba mais!</p>

		</div>
		
		<div class="btm_cta_assinatura">
		<center>
	
			<a href="adwords_membro_vip.php" target="_self"  class="botao_cta">Saiba Mais</a>
		
		
		
		
		</center>
		
		
		<div class="info_assinatura">
		<b>Dúvidas:</b> Envie um e-mail para sac@empreguemeagora.com.br
		</div>
		
		</div>
		
	</div>
	
	','small');	
	
}


echo '</div>';//fecha DIV conteudo, para nao bugar a propaganda...





$display_main->painel_propaganda();
$display_main->fundo();






?>




