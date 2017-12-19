<?php

class Feedback_model extends CI_Model {

    var $feed_codigo;
    var $fk_usu_codigo;
    var $fk_vag_codigo;
    var $feed_dt_cad;

    public function insert($fk_usu_codigo, $fk_vag_codigo) {
        if ($this->verificaDuplicados($fk_usu_codigo, $fk_vag_codigo)) {
            $this->feed_codigo = null;
            $this->fk_usu_codigo = $fk_usu_codigo;
            $this->fk_vag_codigo = $fk_vag_codigo;
            $this->feed_dt_cad = date("Y-m-d H:i:s");
            return $this->db->insert('feedback', $this);
        } else {
            return 0;
        }
    }

    public function verificaDuplicados($fk_usu_codigo, $fk_vag_codigo) {
        $this->db->where('fk_usu_codigo', $fk_usu_codigo);
        $this->db->where('fk_vag_codigo', $fk_vag_codigo);
        $duplicados = $this->db->get('feedback')->result();
        if (count($duplicados) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getFeedback($fk_usu_codigo, $fk_vag_codigo, $opcoes) {
        $this->db->where('fk_usu_codigo', $fk_usu_codigo);
        $this->db->where('fk_vag_codigo', $fk_vag_codigo);
        $this->db->where('feed_ativo', 0);
        $feedback = $this->db->get('feedback')->result();
        if (count($feedback) == 1) {
            return $this->update($feedback[0]->feed_codigo, $opcoes);
        } else {
            return 0;
        }
    }

    public function update($feed_codigo, $opcoes) {
        $this->db->where('feed_codigo', $feed_codigo);
        $dados = array(
            'feed_opcoes' => $opcoes,
            'feed_dt_feed' => date("Y-m-d H:i:s"),
            'feed_ativo' => 1
        );
        return $this->db->update('feedback', $dados);
    }

    public function getOpcoes() {
        $this->db->where('ativo', 1);
        return $this->db->get('feedback_opcoes')->result();
    }
    
    public function getOpcoesByArray($opcoes) {
        $this->db->where('ativo', 1);
        $this->db->where_in('codigo',$opcoes);
        return $this->db->get('feedback_opcoes')->result();
    }
    
    public function getFeedbackEmail($codigo) {
        $this->db->where('ativo', 1);
        $this->db->where_in('codigo',$codigo);
        return $this->db->get('feedback_opcoes')->result();
    }     

}
