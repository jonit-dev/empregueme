<?php

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', 'CC04618889A24E13A299694B9B010C43');

//define('TOKEN', 'D6C7B6A89400426DAE95530BF68B7C95'); //token sandbox

class PagSeguroNpi {

    private $timeout = 20; // Timeout em segundos

    public function notificationPost() {
        $postdata = 'Comando=validar&Token=' . TOKEN;
        foreach ($_POST as $key => $value) {
            $valued = $this->clearStr($value);
            $postdata .= "&$key=$valued";
        }
        return $this->verify($postdata);
    }

    private function clearStr($str) {
        if (!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
        return $str;
    }

    private function verify($data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
        //curl_setopt($curl, CURLOPT_URL, "https://sandbox.pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml"); //sandbox
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = trim(curl_exec($curl));
        curl_close($curl);
        return $result;
    }

    public function converteData($data) {
        $data = explode(' ', $data);
        $hora = $data[1];
        $data = $data[0];
        $data = explode('/', $data);
        $data = $data[2] . '-' . $data[1] . '-' . $data[0] . ' ';
        return $data . $hora;
    }

}
