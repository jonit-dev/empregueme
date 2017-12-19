<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado
if (session_id() == '') {
    session_start();
}

check_loggedin(); //pra cadastrar CV usuário tem que tá logado

$display_main->head('
@import url(\'css/membro_vip.css\');
@import url(\'css/botoes.css\');
@import url(\'css/form_pagto.css\');


', '
<!--SCRIPT PARA GERENCIAR FORM DE PAGAMENTO-->
<script type="text/javascript" src="js/form_pagamento_novo.js"></script>
<script>
function aviso(){
alert("O Membro VIP foi desativado do empregue-me");
}</script>
');

$display_main->topo();
$display_main->painel_esquerda();
$usu_codigo = $_SESSION['userid'];


if (isset($_GET['status']) && $_GET['status'] == 1) {
    $mysqli = mysqli_full_connection();
    $qry = "SELECT vip_interesse_vagas,fk_tpCont_codigo FROM membro_vip WHERE fk_usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_vip_vagas, $r_fk_tpCont_codigo);
    $tem_resultado = false;
    while ($stmt->fetch()) {
        $tem_resultado = true;
        if ($r_vip_vagas != "") {
            $ex = explode('/', $r_vip_vagas);
            foreach ($ex as $novo) {
                $cat_final[$novo] = $novo;
            }
            //var_dump($cat_final);
        }
    }
    $stmt->close();
    if ($tem_resultado == true) {
        $qry = "SELECT cat_codigo, cat_nome FROM categoria";
        $stmt = $mysqli->prepare($qry);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_cat_codigo, $cat_nome);
        $i = 0;
        $_SESSION['categorias'] = "";
        while ($stmt->fetch()) {
            if ($cat_final[$r_cat_codigo][0] == $r_cat_codigo) {
                $_SESSION['categorias'] .= '<input type="checkbox" checked="checked" id="cat_vip" name="categoria[]" value="' . $r_cat_codigo . '" />' . utf8_encode($cat_nome) . '<br />';
            } else {
                $_SESSION['categorias'] .= '<input type="checkbox" id="cat_vip" name="categoria[]" value="' . $r_cat_codigo . '" />' . utf8_encode($cat_nome) . '<br />';
            }
            $i++;
        }
        $stmt->close();
        $qry = "SELECT tpCont_codigo,tpCont_descricao,tpCont_valor FROM membro_conta WHERE tpCont_ativo = 1";
        $stmt = $mysqli->prepare($qry);

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($r_tpCont_codigo, $r_descricao, $r_valor);

        while ($stmt->fetch()) {
            switch ($r_descricao) {

                case "PLANO VIP MENSAL":
                    $ex_mensal = explode('.', $r_valor);
                    if ($r_tpCont_codigo == $r_fk_tpCont_codigo) {
                        $check_mensal = 'checked="checked"';
                    } else {
                        $check_mensal = '';
                    }
                    break;

                case "PLANO VIP TRIMESTRAL":
                    $ex_trimestral = explode('.', $r_valor);
                    if ($r_tpCont_codigo == $r_fk_tpCont_codigo) {
                        $check_trimestral = 'checked="checked"';
                    } else {
                        $check_trimestral = '';
                    }
                    break;

                case "PLANO VIP SEMESTRAL":
                    $ex_semestral = explode('.', $r_valor);
                    if ($r_tpCont_codigo == $r_fk_tpCont_codigo) {
                        $check_semestral = 'checked="checked"';
                    } else {
                        $check_semestral = '';
                    }
                    break;

                case "PLANO VIP ANUAL":
                    $ex_anual = explode('.', $r_valor);
                    if ($r_tpCont_codigo == $r_fk_tpCont_codigo) {
                        $check_anual = 'checked="checked"';
                    } else {
                        $check_anual = '';
                    }
                    break;
            }
        }
//====================>> CONTEUDO DA PAGINA

        $display_main->conteudo('
		
<!--FORMULARIO DE PAGAMENTO-->
<form action="processa_pagamento.php" id="form_processa_pagamento" method="post">
<div id="checkout">

<div class="content">

<div id="content1">

<h4>Selecione seu Plano</h4>
	<div id="box_planos">
  <div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP MENSAL" id="plano_mensal" ' . $check_mensal . ' /><span class="planos_txt">Mensal</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$29,90</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_mensal[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_mensal[1] . '</div>
                </div>                    
       </div>

<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP TRIMESTRAL" id="plano_trimestral" ' . $check_trimestral . ' /><span class="planos_txt">Trimestral</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$44,70</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_trimestral[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_trimestral[1] . '</div>
                </div>
                
       
       </div> 
       
<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP SEMESTRAL" id="plano_semestral" ' . $check_semestral . '/><span class="planos_txt">Semestral</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$59,80</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_semestral[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_semestral[1] . '</div>
                </div>
                
       
       </div> 
       
<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP ANUAL" id="plano_anual" ' . $check_anual . '/><span class="planos_txt">Anual</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$115,25</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_anual[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_anual[1] . '</div>
                </div>
                
       
       </div> 
        
        
        
        </div>
        <br />
<br />

<h4>Categorias profissionais de seu interesse:</h4>

<div id="categorias">
	' . $_SESSION['categorias'] . '
</div>

<br />
<center>
<input type="button" class="btm_checkout" onclick="aviso();" value="Prosseguir">
</center>
</div>
</div>
</div>
</form>
<!--END FORMULARIO DE PAGAMENTO-->');
//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
        $display_main->painel_direita();
        $display_main->fundo();
    }
} else {

    /*
     * Verifica existencia de VIP no sistema
     */
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "SELECT fk_stat_codigo,vip_dt_vencimento FROM membro_vip WHERE fk_usu_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($r_fk_stat_codigo, $r_vip_dt_vencimento);
    $tem_resultado = false;
    while ($stmt->fetch()) {
        $tem_resultado = true;
        $r_vip_dt_vencimento = explode('-', $r_vip_dt_vencimento);
        $data = $r_vip_dt_vencimento[2] . '/' . $r_vip_dt_vencimento[1] . '/' . $r_vip_dt_vencimento[0];
        switch ($r_fk_stat_codigo) {
            case 1:
                $mensagem = "<p>Sua conta se encontra <strong>ATIVADA</strong> com vencimento em <strong>$data</strong>.</p>";
                break;
            case 2:
                $mensagem = "<p>Sua conta se encontra <strong>PENDENTE</strong>.</p> "
                    . "<p><a href='membro_vip_pag.php?status=1'><strong>Clique aqui</strong></a> para renovar sua conta VIP e continuar usufruindo de todos os benefícios do site.</p>"
                    . "<p><strong>Caso você já tenha efetuado o pagamento, não se preocupe iremos ativar em no máximo 3 dias.</strong></p>"
                    . "<br />"
                    . "<p>Dúvidas: sac@empreguemeagora.com.br</p>";
                break;
            default :
                "<p>Sua conta se encontra <strong>DESATIVADA</strong>, entre em contato no sac@empreguemeagora.com.br para tirar todas as suas dúvidas.</p>";
        }
    }
    $stmt->close();
    if ($tem_resultado == true) {
        $display_main->conteudo(''
            . '<h1>Situação da conta: Membro VIP</h1>'
            . $mensagem
        );
        $display_main->painel_direita();
        $display_main->fundo();
    } else {
//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
        $_SESSION['categorias'] = "";
        $mysqli = mysqli_full_connection();

        $qry = "SELECT cat_codigo, cat_nome FROM categoria";

        $stmt = $mysqli->prepare($qry);
        $stmt->execute();

        $stmt->bind_result($r_cat_codigo, $cat_nome);

        while ($stmt->fetch()) {
            $_SESSION['categorias'] .= '<input type="checkbox" id="cat_vip" name="categoria[]" value="' . $r_cat_codigo . '" />' . utf8_encode($cat_nome) . '<br />';
        }
        $stmt->close();
        $qry = "SELECT tpCont_descricao,tpCont_valor FROM membro_conta WHERE tpCont_ativo = 1";
        $stmt = $mysqli->prepare($qry);

        $stmt->execute();
        $stmt->bind_result($r_descricao, $r_valor);

        while ($stmt->fetch()) {
            switch ($r_descricao) {

                case "PLANO VIP MENSAL":
                    $ex_mensal = explode('.', $r_valor);
                    break;

                case "PLANO VIP TRIMESTRAL":
                    $ex_trimestral = explode('.', $r_valor);
                    break;

                case "PLANO VIP SEMESTRAL":
                    $ex_semestral = explode('.', $r_valor);
                    break;

                case "PLANO VIP ANUAL":
                    $ex_anual = explode('.', $r_valor);
                    break;
            }
        }
//====================>> CONTEUDO DA PAGINA
        if (isset($_GET['conta'])) {
            switch ($_GET['conta']) {
                case "mensal":
                    $mensal = 'checked="checked"';
                    break;
                case "semestral":
                    $semestral = 'checked="checked"';
                    break;
                case "trimestral":
                    $trimestral = 'checked="checked"';
                    break;
            }
        }
        $display_main->conteudo('
		
<!--FORMULARIO DE PAGAMENTO-->
<form action="processa_pagamento.php" id="form_processa_pagamento" method="post">
<div id="checkout">

<div class="content">

<div id="content1">

<h4>Selecione seu Plano</h4>
	<div id="box_planos">
    <div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP MENSAL" id="plano_mensal" ' . $mensal . ' /><span class="planos_txt">Mensal</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$39,90</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_mensal[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_mensal[1] . '</div>
                </div>                    
       </div> 

<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP TRIMESTRAL" id="plano_trimestral" ' . $trimestral . ' /><span class="planos_txt">Trimestral</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$44,70</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_trimestral[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_trimestral[1] . '</div>
                </div>
                
       
       </div> 
       
<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP SEMESTRAL" id="plano_semestral" ' . $semestral . ' /><span class="planos_txt">Semestral</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$59,80</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_semestral[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_semestral[1] . '</div>
                </div>
                
       
       </div> 
       
<div class="planos">
    	<input type="radio" name="plano"  value="PLANO VIP ANUAL" id="plano_anual"/><span class="planos_txt">Anual</span>
                
                <div class="valor_promo">de <span style="text-decoration:line-through;">R$115,25</span> por</div>
                
                <div class="valor">
                <div class="plano_rs">R$</div>
                <div class="plano_valor_maior">' . $ex_anual[0] . '</div>
                <div class="plano_valor_menor">,' . $ex_anual[1] . '</div>
                </div>
                
       
       </div> 
        
        
        
        </div>
        <br />
<br />

<h4>Categorias profissionais de seu interesse:</h4>

<div id="categorias">
	' . $_SESSION['categorias'] . '
</div>

<br />
<center>
<input type="button" class="btm_checkout" onclick="aviso();" value="Prosseguir">
</center>
</div>
</div>
</div>
</form>
<!--END FORMULARIO DE PAGAMENTO-->');
//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
        $display_main->painel_direita();
        $display_main->fundo();
    }
}
?>


