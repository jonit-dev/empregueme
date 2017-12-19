<?php

class Maladireta_model extends CI_Model {

    public function getEmpresasNaoEnviadas() {
        $this->db->where('enviou_email', 0);
        $this->db->where('email_contato', 'diogokdc@gmail.com');
        $this->db->limit('100');
        return $this->db->get('lista_email_empresas')->result();
    }

    public function updateStatus($id, $status) {
        $this->db->where('email_id', $id);
        $data = array('enviou_email' => $status);
        return $this->db->update('lista_email_empresas', $data);
    }

}
