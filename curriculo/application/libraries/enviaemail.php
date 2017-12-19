<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enviaemail {

    public function __construct() {
        $CI = & get_instance();
        log_message('Debug', 'PHPmailer class is loaded.');
    }

    public function envia_email($toEmail, $toName, $mensagem, $assunto, $anexo = null) {
        include_once APPPATH . '/third_party/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'mail.empreguemeagora.com.br';
        $mail->SMTPAuth = true;
        $mail->Port = 26;
        $mail->Username = 'empregueme@empreguemeagora.com.br';
        $mail->Password = '4htiaIr6o61M';
        //$mail->AddReplyTo($toEmail,$toName);
        $mail->From = "empregueme@empreguemeagora.com.br";
        $mail->FromName = "empregue-me";
        $mail->AddAddress($toEmail, $toName);
        if ($anexo != null) {
            $mail->AddAttachment(base_url('assets/files/' . $anexo));
        }
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $enviado = $mail->Send();
        $mail->ClearAllRecipients();
        if ($enviado) {
            return 1;
        } else {
            return 0;
            //echo $mail->ErrorInfo;
        }
    }

    public function envia_email_vaga($toEmail, $mensagem, $assunto) {
        include_once APPPATH . '/third_party/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'mail.empreguemeagora.com.br';
        $mail->SMTPAuth = true;
        $mail->Port = 26;
        $mail->Username = 'empregueme@empreguemeagora.com.br';
        $mail->Password = '4htiaIr6o61M';
        $mail->From = "empregueme@empreguemeagora.com.br";
        $mail->FromName = "empregue-me";
        $mail->AddAddress($toEmail);
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $enviado = $mail->Send();
        $mail->ClearAllRecipients();
        if ($enviado) {
            return 1;
        } else {
            return 0;
            //echo $mail->ErrorInfo;
        }
    }
    
        public function envia_email_maladireta($toEmail,$mensagem, $assunto, $anexo = null) {
        include_once APPPATH . '/third_party/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'mail.empregueme.com.br';
        $mail->SMTPAuth = true;
        $mail->Port = 26;
        $mail->Username = 'no-reply@empregueme.com.br';
        $mail->Password = 'Empre#12';
        $mail->AddAddress($toEmail);
        if ($anexo != null) {
            $mail->AddAttachment(base_url('assets/files/' . $anexo));
        }
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $enviado = $mail->Send();
        $mail->ClearAllRecipients();
        if ($enviado) {
            return 1;
        } else {
            //return 0;
            echo $mail->ErrorInfo;
        }
    }

}
