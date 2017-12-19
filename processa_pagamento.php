<?php

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
//ini_set('default_charset', 'UTF-8');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
$display_main->head();
//carrega arquivo com o layout
//atualiza variáveis de sessão se usuário estiver logado
if (session_id() == '') {
    session_start();
}

check_loggedin();//pra cadastrar CV usuário tem que tá logado
/*
 * pega as variaveis do formulario do membro_vip.php
 */
//var_dump($_POST);
if (isset($_POST['plano'])) {
    @$plano_vip = mysqli_secure_query($_POST['plano']);
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "SELECT tpCont_codigo,tpCont_descricao,tpCont_valor FROM membro_conta WHERE tpCont_descricao = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('s', $plano_vip);
    $stmt->execute();
    $stmt->bind_result($r_codigo, $r_descricao, $r_valor);
    $tem_resultado = false;
    while ($stmt->fetch()) {
        $plano_codigo = $r_codigo;
        $plano_descricao = $r_descricao;
        $plano_valor = $r_valor;
        $tem_resultado = true;
    }
    $stmt->close();
    if ($tem_resultado) { //retornou o plano com o valor cadastrado no BD
        $cat = $_POST['categoria'];
        $categoria = "";
        foreach ($cat as $key => $value) {
            $categoria .= $value . "/";
        }
        $usu_codigo = $_SESSION['userid'];
        $nome = $_SESSION['nome'];
        $email = $_SESSION['login'];
        $referencia = "VIP/" . $usu_codigo;
        /*
         * Grava VIP
         */
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");
        $qry = "SELECT vip_codigo FROM membro_vip WHERE fk_usu_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('i', $usu_codigo);
        $stmt->execute();
        $stmt->bind_result($r_vip_codigo);
        $tem_resultado = false;
        while ($stmt->fetch()) {
            $stmt->close();
            $tem_resultado = true;
            //existe vip entao vamos atualizar
            $mysqli = mysqli_full_connection();
            $qry = "UPDATE membro_vip set fk_tpCont_codigo = ? ,vip_interesse_vagas = ? WHERE vip_codigo = ?";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('isi', $plano_codigo, $categoria, $r_vip_codigo);
            $stmt->execute();
        }
        $stmt->close();
        if ($tem_resultado == false) { //significa que nao existe VIP cadastrado
            $fk_status_codigo = 2;
            $vip_dt_inicio = date('Y-m-d');
            $mysqli = mysqli_full_connection();
            $qry = "INSERT INTO membro_vip (vip_codigo,fk_usu_codigo,fk_tpCont_codigo,fk_stat_codigo,vip_dt_inicio,vip_interesse_vagas) VALUES (NULL,?,?,?,?,?)";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('iiiss', $usu_codigo, $r_codigo, $fk_status_codigo, $vip_dt_inicio, $categoria);
            $stmt->execute();
            $tem_resultado = false;
            while ($stmt->fetch()) {
                $tem_resultado = true;
            }

            if ($tem_resultado == true) {
                //envia e-mail avisando do pagamento
                require_once('php_mailer/EmailConfig.php');

// Setando o endereço de recebimento
                $mail->AddAddress($email, $nome);
                $mail->Subject = 'Status do Membro VIP';
                $mail->Body = utf8_encode(""
                        . "<p>Seja bem-vindo! Você foi cadastrado como membro VIP, assim que o pagamento for confirmado pelo sistema ativaremos sua conta e você poderá acessar a <strong>todos os benefícios</strong> do site.</p>"
                        . "<p>Este é um e-mail automático, favor não responder. A equipe empregue-me agradece pela confiança.</p>");
                $mail->send(); //envia e-mail para o novo membro vip
                $mail->ClearAllRecipients();
            }
            session_refresh();
        }
        /*
         * Começa pagamento via pagseguro
         */
        require_once 'PagSeguroLibrary/createPaymentRequestLightbox.php';
        $pagseguro = new CreatePaymentRequestLightbox();
        $pagseguro->main($plano_codigo, $plano_descricao, $plano_valor, $referencia, $nome, $email);

        $display_main->topo();
        $display_main->painel_esquerda();
        $display_main->conteudo(''
                . '<h1>Você está um passo de ser membro VIP</h1>'
                . '<h3>Aguarde que estamos carregando o processo de pagamento...</h3>'
                . '<p>Após concluir a etapa do pagamento via pagseguro, sua conta será ativada em no máximo 3 dias úteis.</p>');
        $display_main->painel_direita();
        $display_main->fundo();
    } //fim --- retorna plano cadastrado no BD
} // fim --- if (isset($_POST['plano'])) {
?>


