<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maladireta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Maladireta_model', 'ml');
        $this->load->library('enviaemail');
    }

    public function ml_empresa() {
        $empresas = $this->ml->getEmpresasNaoEnviadas();
        if (isset($empresas)) {
            foreach ($empresas as $empresa) {
                $mensagem = $this->load->view('view_maladireta_empresa', '', TRUE);
                $assunto = "Encontre Profissionais Qualificados Gratuitamente";
                $enviado = $this->enviaemail->envia_email_maladireta($empresa->email_contato, $mensagem, $assunto);
                if ($enviado) {
                    /* atualiza bd que enviou com sucesso
                     * 1 - enviado
                     * 2 - erro
                     */
                    $this->ml->updateStatus($empresa->email_id, 1);
                } else {
                    echo $enviado;
                    $this->ml->updateStatus($empresa->email_id, 2);
                }
                sleep(8);
            }
        }
    }

    public function visualiza_online($tipo = null) {
        switch ($tipo) {
            case "empresa":
                $this->load->view('view_maladireta_empresa');
                break;
            case "usuario":
                $this->load->view('view_maladireta_usuario');
                break;
            default : $this->load->view('view_maladireta_usuario');
        }
    }

    public function teste_view() {
        $this->load->view('view_maladireta_empresa');
    }

}
