<?php

class Vip_model extends CI_Model {

    public function getPagantes() {
        $data = array(3,4);
        $this->db->where_in('tran_status',$data);
        $this->db->where('tran_ativo', 0);
        $this->db->limit(1);
        return $this->db->get('membro_transacao')->result();
    }

    public function getVip($usu_codigo) {
        $this->db->where('fk_usu_codigo', $usu_codigo);
        return $this->db->get('membro_vip')->result();
    }

    public function getTipoConta($tipo_conta) {
        $this->db->where('tpCont_codigo', $tipo_conta);
        $this->db->where('tpCont_ativo', 1);
        return $this->db->get('membro_conta')->result();
    }

    public function ativaVip($usu_codigo, $dt_vencimento) {
        $this->db->where('fk_usu_codigo', $usu_codigo);
        $data = array(
            'fk_stat_codigo' => 1,
            'vip_dt_pagamento' => date('Y-m-d'),
            'vip_dt_vencimento' => $dt_vencimento,
            'vip_envio_emailVenc' => 0
        );
        return $this->db->update('membro_vip', $data);
    }

    public function desativaTransacao($id) {
        $this->db->where('tran_codigo', $id);
        $data = array('tran_ativo' => 1);
        return $this->db->update('membro_transacao', $data);
    }

    /*
     * CORREÇÃO DO BUG DOS VIPS ANTIGOS
     */

    public function getVipOld() {
        $this->db->where('membro_vip.flag', 1);
        $this->db->join('usuario', 'usuario.usu_codigo = membro_vip.fk_usu_codigo', 'inner');
        return $this->db->get('membro_vip')->result();
    }

    public function desativaFlag($vip_codigo) {
        $this->db->where('vip_codigo', $vip_codigo);
        $data = array('flag' => 0);
        return $this->db->update('membro_vip', $data);
    }

    /*
     * VIP VENCIDOS
     */

    public function getVipsVencidos() {
        $this->db->where('vip_dt_vencimento < ', date('Y-m-d'));
        //$this->db->or_where('year(vip_dt_vencimento) <', date('Y'));
        //$this->db->where('vip_envio_emailVenc', 0);
        $this->db->where('fk_stat_codigo', 1);
        $this->db->limit(5);
        return $this->db->get('membro_vip')->result();
    }

    public function alteraStatus($fk_usu_codigo, $vip_envio_emailVenc = 1, $fk_stat_codigo = 2) {
        $this->db->where('fk_usu_codigo', $fk_usu_codigo);
        $data = array('fk_stat_codigo' => $fk_stat_codigo, 'vip_envio_emailVenc' => $vip_envio_emailVenc);
        return $this->db->update('membro_vip', $data);
    }

}
