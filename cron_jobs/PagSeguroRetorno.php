<?php

header('Content-Type: text/html; charset= ISO-8859-1');
include 'PagSeguroRetornoFuncoes.php';
define('TOKEN', '576310757392451BAD2C6934CACAF003');

require_once('../classes/connect_class.php');

$connect = new ConnectionFactory;
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


if (count($_POST) > 0) {

    $npi = new PagSeguroNpi();
    $result = $npi->notificationPost();

    $transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';

    if ($result == "VERIFICADO") {

        // Recebendo Dados
        //$VendedorEmail = $_POST['VendedorEmail'];
        $TransacaoID = $_POST['TransacaoID'];
        $Referencia = $_POST['Referencia'];
        if (intval($Referencia))
            $ativo = 0;
        else
            $ativo = 1;
        //$Extras = MoedaBR($_POST['Extras']);
        //$TipoFrete = $_POST['TipoFrete'];
        //$ValorFrete = MoedaBR($_POST['ValorFrete']);
        $DataTransacao = ConverterData($_POST['DataTransacao']);
        //$Anotacao = $_POST['Anotacao'];
        //$TipoPagamento = $_POST['TipoPagamento'];
        $StatusTransacao = $_POST['StatusTransacao'];

        //$CliNome = $_POST['CliNome'];
        $CliEmail = $_POST['CliEmail'];
        //$CliEndereco = $_POST['CliEndereco'];
        //$CliNumero = $_POST['CliNumero'];
        //$CliComplemento = $_POST['CliComplemento'];
        //$CliBairro = $_POST['CliBairro'];
        //$CliCidade = $_POST['CliCidade'];
        //$CliEstado = $_POST['CliEstado'];
        //$CliCEP = $_POST['CliCEP'];
        //$CliTelefone = $_POST['CliTelefone'];
        //$NumItens = $_POST['NumItens'];
        // Gravando Dados
//verifica transacao
        $mysqli = mysqli_full_connection();
        $mysqli->set_charset('utf8');
        $qry = "SELECT tran_codigo FROM membro_transacao WHERE tran_transacao_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('s', $TransacaoID);
        $stmt->execute();
        $stmt->bind_result($r_tran_codigo);
        $tem_resultado = false;
        while ($stmt->fetch()) {
            $tem_resultado = true;
        }
        if ($tem_resultado == true) {
            $stmt->close();
            $mysqli = mysqli_full_connection();
            $mysqli->set_charset('utf8');
            $qry = "UPDATE membro_transacao SET tran_situacao = ?, tran_dt_transacao=? WHERE tran_transacao_codigo = ?";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('sss', $StatusTransacao, $DataTransacao, $transacaoID);
            $stmt->execute();
        } else {
            $stmt->close();
            $mysqli = mysqli_full_connection();
            $mysqli->set_charset('utf8');
            $qry = "INSERT INTO membro_transacao (tran_codigo,tran_dt_transacao,tran_transacao_codigo,tran_referencia,tran_situacao,tran_cliEmail) VALUES (NULL,?,?,?,?,?)";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('issss', $DataTransacao, $transacaoID, $Referencia, $StatusTransacao, $CliEmail);
            $stmt->execute();
        }
    }
}
?>