<?php

class Curriculo_model extends CI_Model {

    var $id;
    var $fk_usu_codigo;
    var $fk_habilidades_id;
    var $fk_formacao_id;
    var $fk_categoria_codigo;
    var $created;
    var $updated;
    var $deleted;
    var $objetivo_profissional;
    var $outras_informacoes;
    var $ativo;

    public function insert($fk_usu_codigo, $fk_habilidades_id, $fk_formacao_id, $fk_categoria_codigo, $objetivo_profissional, $outras_informacoes) {
        if ($this->verificaDuplicados($fk_usu_codigo, $fk_habilidades_id, $fk_formacao_id)) {
            $this->id = null;
            $this->fk_usu_codigo = $fk_usu_codigo;
            $this->fk_habilidades_id = $fk_habilidades_id;
            $this->fk_formacao_id = $fk_formacao_id;
            $this->fk_categoria_codigo = $fk_categoria_codigo;
            $this->created = date('Y-m-d H:i:s');
            $this->updated = null;
            $this->deleted = null;
            $this->objetivo_profissional = $objetivo_profissional;
            $this->outras_informacoes = $outras_informacoes;
            $this->ativo = 1;
            if ($this->db->insert('curriculos', $this)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getCurriculoByUsuCodigo($usu_codigo, $curr_codigo = null) {
        $this->db->where('fk_usu_codigo', $usu_codigo);
        if ($curr_codigo != null) {
            $this->db->where('id', $curr_codigo);
        }
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $curriculos = $this->db->get('curriculos')->result();
        if (count($curriculos) > 0) {
            foreach ($curriculos as $curriculo) {
                $this->id = $curriculo->id;
                $this->fk_usu_codigo = $curriculo->fk_usu_codigo;
                $this->fk_habilidades_id = $curriculo->fk_habilidades_id;
                $this->fk_formacao_id = $curriculo->fk_formacao_id;
                $this->created = $curriculo->created;
                $this->updated = $curriculo->updated;
                $this->deleted = $curriculo->deleted;
                $this->objetivo_profissional = $curriculo->objetivo_profissional;
                $this->outras_informacoes = $curriculo->outras_informacoes;
                $this->ativo = $curriculo->ativo;
            }
            $dados = $this;
        } else {
            $dados = null;
        }
        return $dados;
    }

    public function getUsuByCurriculo($curr_codigo) {
        $this->db->where('id', $curr_codigo);
        $this->db->where('ativo', 1);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $usuarios = $this->db->get('curriculos')->result();
        if (count($usuarios) > 0) {
            foreach ($usuarios as $usuario) {
                $dados = $usuario->fk_usu_codigo;
            }
        } else {
            $dados = null;
        }
        return $dados;
    }

    public function verificaDuplicados($fk_usu_codigo, $fk_habilidades, $fk_formacao) {
        $this->db->where('fk_usu_codigo', $fk_usu_codigo);
        $this->db->where('fk_habilidades_id', $fk_habilidades);
        $this->db->where('fk_formacao_id', $fk_formacao);
        $curriculos = $this->db->get('curriculos')->result();
        if (count($curriculos) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function verifica_curriculo($usu_codigo) {
        $this->db->where('fk_usu_codigo', $usu_codigo);
        $curriculos = $this->db->get('curriculos')->result();
        if (count($curriculos) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function verifica_curriculoVaga($curr_codigo, $vag_codigo) {
        $this->db->where('curr_codigo', $curr_codigo);
        $this->db->where('vag_codigo', $vag_codigo);
        $curriculos = $this->db->get('curriculos_vagas')->result();
        if (count($curriculos) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function grava_curriculo_vaga($curr_codigo, $vag_codigo, $ativo = 1, $envio_automatico = 0, $dt_envio_automatico = null) {
        if ($this->verifica_curriculoVaga($curr_codigo, $vag_codigo)) {
            $dados = array(
                'curr_codigo' => $curr_codigo,
                'vag_codigo' => $vag_codigo,
                'envio_automatico' => $envio_automatico,
                'dt_envio_automatico' => $dt_envio_automatico,
                'envio_manual' => $ativo
            );
            return $this->db->insert('curriculos_vagas', $dados);
        } else {
            return 0;
        }
    }

    public function edita_curriculo_vaga($curr_codigo, $vag_codigo, $ativo = 1) {
        $this->db->where('curr_codigo', $curr_codigo);
        $this->db->where('vag_codigo', $vag_codigo);
        $dados = array('envio_manual' => $ativo, 'envio_dt' => date("Y-m-d H:i:s"));
        return $this->db->update('curriculos_vagas', $dados);
    }

    public function getCurriculosNaoEnviados() {
        $this->db->select('curr_codigo,vag_codigo');
        $this->db->where('curriculos_vagas.envio_manual', 0);
        $this->db->join('curriculos', 'curriculos.id = curriculos_vagas.curr_codigo', 'inner');
        $this->db->where('curriculos.ativo', 1);
        $this->db->limit('20');
        return $this->db->get('curriculos_vagas')->result();
    }

    public function getCurriculosNaoEnviadosVip() {
        $this->db->select('curr_codigo,vag_codigo');
        $this->db->where('curriculos_vagas.envio_manual', 0);
        $this->db->join('curriculos', 'curriculos.id = curriculos_vagas.curr_codigo', 'inner');
        $this->db->join('membro_vip', 'curriculos.fk_usu_codigo = membro_vip.fk_usu_codigo', 'inner');
        $this->db->where('curriculos.ativo', 1);
        $this->db->where('membro_vip.fk_stat_codigo', 1);
        $this->db->limit('20');
        return $this->db->get('curriculos_vagas')->result();
    }

    public function getCurriculosNaoEnviadosEmpresa() {
        $this->db->select('curriculos_vagas.curr_codigo,curriculos_vagas.vag_codigo');
        $this->db->where('curriculos_vagas.envio_manual', 0);
        $this->db->join('curriculos', 'curriculos.id = curriculos_vagas.curr_codigo', 'inner');
        $this->db->join('vagas', 'vagas.vag_codigo = curriculos_vagas.vag_codigo', 'inner');
        $this->db->join('usuario', 'usuario.usu_codigo = vagas.usu_codigo', 'inner');
        $this->db->where('curriculos.ativo', 1);
        $this->db->where('usuario.usu_permissao', 0);
        $this->db->limit('20');
        return $this->db->get('curriculos_vagas')->result();
    }

}
