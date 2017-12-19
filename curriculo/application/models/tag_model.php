<?php

class Tag_model extends CI_Model {

    public function getTags() {
        $this->db->select('vag_tag');
        $this->db->distinct();
        $this->db->where("vag_tag !=", '');
        $this->db->order_by('vag_tag');
        return $this->db->get('vagas')->result();
    }

    public function insertTags($usu_codigo, $tags) {
        if ($usu_codigo) {
            $this->db->where('usu_codigo', $usu_codigo);
            $data = array('usu_tags' => $tags);
            return $this->db->update('usuario', $data);
        } else {
            return 0;
        }
    }

    public function updateEnvioTags($usu_codigo, $count, $status) {
        $this->db->where('usu_codigo', $usu_codigo);
        $data = array('usu_tags_envio_' . $count => $status);
        return $this->db->update('usuario', $data);
    }

    public function getEnvio($count) {
        $this->db->where('usu_tags_envio_' . $count, 0);
        $this->db->where('usu_tags !=', '');
        $this->db->limit(1);
        return $this->db->get('usuario')->result();
    }

    /*
     * busca todas as vagas ativas com a mesma tag e retorna array de codigo das vagas
     */

    public function getVagasTag($tag) {
        $this->db->select('vag_codigo');
        $this->db->where('vag_tag', $tag);
        $this->db->where('vag_ativo', 1);
        $vagas = $this->db->get('vagas')->result();
        $vagas_codigo = array();
        $i = 0;
        if ($vagas) {
            foreach ($vagas as $vaga) {
                $vagas_codigo[$i] = $vaga->vag_codigo;
                $i++;
            }
            return $vagas_codigo;
        } else {
            return NULL;
        }
    }

    /*
     * busca todas as vagas cadastradas com o curriculo e retorna um array de codigo das vagas
     */

    public function getVagasNaoDisponiveis($curr_codigo) {
        $this->db->where('curr_codigo', $curr_codigo);
        $vagas = $this->db->get('curriculos_vagas')->result();
        $vagas_codigo = array();
        $i = 0;
        if ($vagas) {
            foreach ($vagas as $vaga) {
                $vagas_codigo[$i] = $vaga->vag_codigo;
                $i++;
            }
            return $vagas_codigo;
        } else {
            return NULL;
        }
    }

    /*
     * busca todas as vagas disponiveis para cadastro
     */

    public function getVagasDisponiveis($vagas, $tag, $cidade) {
        $this->db->where_not_in('vag_codigo', $vagas);
        $this->db->where('cid_codigo', $cidade);
        $this->db->where('vag_tag', $tag);
        $this->db->where('vag_ativo', 1);
        $this->db->order_by('vag_codigo', 'DESC');
        $this->db->limit(1);
        return $this->db->get('vagas')->result();
    }

    public function cleanTags($count) {
        $data = array(1, 2);
        $this->db->where_in('usu_tags_envio_' . $count, $data);
        $remove = array('usu_tags_envio_' . $count => 0);
        return $this->db->update('usuario', $remove);
    }

}
