<?php

class Historicos_model extends CI_Model {

    var $id;
    var $fk_curriculos_id;
    var $empresa;
    var $ano;
    var $periodo_dia;
    var $periodo_duracao;
    var $cargo;
    var $descricao;

    public function insert($fk_curriculos_id, $empresa, $ano, $periodo_dia, $periodo_duracao, $cargo, $descricao) {
        if ($this->verificaDuplicados($fk_curriculos_id, $empresa)) {
            $this->id = null;
            $this->fk_curriculos_id = $fk_curriculos_id;
            $this->empresa = $empresa;
            $this->ano = $ano;
            $this->periodo_dia = $periodo_dia;
            $this->periodo_duracao = $periodo_duracao;
            $this->cargo = $cargo;
            $this->descricao = $descricao;
            if ($this->db->insert('historicos_profissionais', $this)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function verificaDuplicados($fk_curriculos_id, $empresa) {
        $this->db->where('fk_curriculos_id', $fk_curriculos_id);
        $this->db->where('empresa', $empresa);
        $historicos = $this->db->get('historicos_profissionais')->result();
        if (count($historicos) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getById($fk_curriculos_id) {
        $this->db->where('fk_curriculos_id', $fk_curriculos_id);
        $historicos = $this->db->get('historicos_profissionais')->result();
        if (count($historicos) > 0) {
            return $historicos;
        } else {
            return 0;
        }
    }

}
