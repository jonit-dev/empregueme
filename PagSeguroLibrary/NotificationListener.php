<?php
//header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
/*
 * ***********************************************************************
  Copyright [2011] [PagSeguro Internet Ltda.]

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 * ***********************************************************************
 */

require_once "PagSeguroLibrary.php";

class NotificationListener {

    public static function main() {

        $code = (isset($_POST['notificationCode']) && trim($_POST['notificationCode']) !== "" ?
                        trim($_POST['notificationCode']) : null);
        $type = (isset($_POST['notificationType']) && trim($_POST['notificationType']) !== "" ?
                        trim($_POST['notificationType']) : null);

        if ($code && $type) {

            $notificationType = new PagSeguroNotificationType($type);
            $strType = $notificationType->getTypeFromValue();

            switch ($strType) {

                case 'TRANSACTION':
                    self::transactionNotification($code);
                    break;

                default:
                    LogPagSeguro::error("Unknown notification type [" . $notificationType->getValue() . "]");
            }
            //self::printLog($strType);
        } else {
            LogPagSeguro::error("Invalid notification parameters.");
            //self::printLog();
        }
    }

    private static function transactionNotification($notificationCode) {

        /*
         * #### Credentials #####
         * Substitute the parameters below with your credentials (e-mail and token)
         * You can also get your credentials from a config file. See an example:
         * $credentials = PagSeguroConfig::getAccountCredentials();
         */
        $credentials = PagSeguroConfig::getAccountCredentials();
        try {
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
            /*
             * Chama as funcoes com os dados da transacao
             */
            // confgura tipo de pagamento
            $paymentMethod = $transaction->getPaymentMethod();
            $type_payment = $paymentMethod->getType();
            //self::printLog($transaction->getCode(), $transaction->getDate(), $transaction->getLastEventDate(), $transaction->getGrossAmount(), $transaction->getNetAmount(), $type_payment->getValue(), $transaction->getReference(), $transaction->getStatus()->getValue(), $transaction->getSender()->getName(), $transaction->getSender()->getEmail(), $transaction->getSender()->getPhone()->getAreaCode(), $transaction->getSender()->getPhone()->getNumber());
            self::grava_bd($transaction->getCode(), $transaction->getDate(), $transaction->getLastEventDate(), $transaction->getGrossAmount(), $transaction->getNetAmount(), $type_payment->getValue(), $transaction->getReference(), $transaction->getStatus()->getValue(), $transaction->getSender()->getName(), $transaction->getSender()->getEmail(), $transaction->getSender()->getPhone()->getAreaCode(), $transaction->getSender()->getPhone()->getNumber());
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    private static function printLog($trans_codigo, $trans_data, $trans_data_evento, $trans_bruto, $trans_liquido, $trans_metodoPagamento, $trans_referencia, $trans_status, $usu_nome, $usu_email, $usu_ddd, $usu_telefone) {
        echo "<h4>Codigo: $trans_codigo</h4>";
        echo "<h4>Data: $trans_data</h4>";
        echo "<h4>Data: $trans_data_evento</h4>";
        echo "<h4>Bruto: $trans_bruto</h4>";
        echo "<h4>Liquido: $trans_liquido</h4>";
        echo "<h4>Metodo: $trans_metodoPagamento</h4>";
        echo "<h4>Referencia: $trans_referencia</h4>";
        echo "<h4>Status: $trans_status</h4>";
        echo "<h4>Usuario Nome: $usu_nome</h4>";
        echo "<h4>Usuario E-mail: $usu_email</h4>";
        echo "<h4>Usuario Telefone: ($usu_ddd) $usu_telefone</h4>";
    }

    private static function grava_bd($trans_codigo, $trans_data, $trans_data_evento, $trans_bruto, $trans_liquido, $trans_metodoPagamento, $trans_referencia, $trans_status, $usu_nome, $usu_email, $usu_ddd, $usu_telefone) {
        $telefone = "($usu_ddd) $usu_telefone";

        // Conecta ao banco de dados
        //$mysqli = new mysqli('localhost', 'root', '', 'empre941_empregueme'); //local
        $mysqli = new mysqli('localhost', 'empre941_user', 'Empre#12', 'empre941_rede'); //online
        // Verifica se ocorreu algum erro
        if (mysqli_connect_errno()) {
            LogPagSeguro::error('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
            exit();
        }
        mysqli_set_charset($mysqli, "utf8");
        $qry = "INSERT INTO membro_transacao VALUE (NULL,?,?,?,?,?,?,?,?,?,?,?,0)";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('sssssisisss', $trans_codigo, $trans_data, $trans_data_evento, $trans_bruto, $trans_liquido, $trans_metodoPagamento, $trans_referencia, $trans_status, $usu_nome, $usu_email, $telefone);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        /*
          if ($stmt->errno) {
          LogPagSeguro::error("Problema inserir: transacao = " . $trans_codigo . ", status = " . $trans_status);
          }
         * 
         */
    }

}

NotificationListener::main();
