<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cep extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $cep = $this->input->post('usu_cep');

        $reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);

        $dados['sucesso'] = (string) $reg->resultado;
        $dados['rua'] = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
        $dados['bairro'] = (string) $reg->bairro;
        $dados['cidade'] = (string) $reg->cidade;
        $dados['estado'] = (string) $reg->uf;

        echo json_encode($dados);
    }

}
