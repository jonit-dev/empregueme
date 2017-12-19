<?php

class Vaga_model extends CI_Model {

    var $vag_codigo;
    var $vag_nome;
    var $vag_email;

    public function getVagaByCodigo($vag_codigo) {
        $this->db->select('vag_codigo,vag_nome,vag_email');
        $this->db->where('vag_codigo', $vag_codigo);
        $vagas = $this->db->get('vagas')->result();
        if (count($vagas) == 1) {
            foreach ($vagas as $vaga) {
                $this->vag_codigo = $vaga->vag_codigo;
                $this->vag_nome = $vaga->vag_nome;
                $this->vag_email = $vaga->vag_email;
            }
            $dados = $this;
        } else {
            $dados = null;
        }
        return $dados;
    }

    public function confirmaVaga($curr_codigo, $vag_codigo) {
        $this->db->where('curr_codigo', $curr_codigo);
        $this->db->where('vag_codigo', $vag_codigo);
        $vagas = $this->db->get('curriculos_vagas')->result();
        if (count($vagas) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function removeVaga($vag_codigo) {
        $this->db->where('vag_codigo', $vag_codigo);
        $data = array('vag_ativo' => 0);
        $atualiza = $this->db->update('vagas', $data);
        if ($atualiza) {
            $this->removeEnvios($vag_codigo);
        }
    }

    public function removeEnvios($vag_codigo) {
        $this->db->where('vag_codigo', $vag_codigo);
        $this->db->where('envio_manual', 0);
        return $this->db->delete('curriculos_vagas');
    }

}
