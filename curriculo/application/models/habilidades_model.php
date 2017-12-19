<?php

class Habilidades_model extends CI_Model {

    var $id;
    var $cnh;
    var $disponivel_viagem;
    var $disponivel_horario;
    var $pretensao_salarial;
    var $ingles;
    var $ingles_nivel;
    var $office;
    var $office_nivel;

    public function getById($id_habilidades) {
        $this->db->where('id', $id_habilidades);
        $habilidades = $this->db->get('habilidades')->result();
        if (count($habilidades) > 0) {
            foreach ($habilidades as $habilidade) {
                $this->id = $habilidade->id;
                $this->cnh = $habilidade->cnh;
                $this->disponivel_viagem = $habilidade->disponivel_viagem;
                $this->disponivel_horario = $habilidade->disponivel_horario;
                $this->pretensao_salarial = $habilidade->pretensao_salarial;
                $this->ingles = $habilidade->ingles;
                $this->ingles_nivel = $habilidade->ingles_nivel;
                $this->office = $habilidade->office;
                $this->office_nivel = $habilidade->office_nivel;
            }
            $dados = $this;
        } else {
            $dados = null;
        }
        return $dados;
    }

    public function getOutrasByid($id_habilidades) {
        $this->db->where('fk_habilidades_id', $id_habilidades);
        $outras = $this->db->get('outras_habilidades')->result();
        if (count($outras) > 0) {
            return $outras;
        } else {
            return 0;
        }
    }

    public function insertHabilidades($cnh, $disponivel_viagem, $disponivel_horario, $pretensao_salarial, $ingles, $ingles_nivel, $office, $office_nivel) {
        if ($this->verificaDuplicadoHabilidades($cnh, $disponivel_viagem, $disponivel_horario, $pretensao_salarial, $ingles, $office)) {
            $dados = array(
                'id' => null,
                'cnh' => $cnh,
                'disponivel_viagem' => $disponivel_viagem,
                'disponivel_horario' => $disponivel_horario,
                'pretensao_salarial' => $pretensao_salarial,
                'ingles' => $ingles,
                'ingles_nivel' => $ingles_nivel,
                'office' => $office,
                'office_nivel' => $office_nivel
            );
            if ($this->db->insert('habilidades', $dados)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function verificaDuplicadoHabilidades($cnh, $disponivel_viagem, $disponivel_horario, $pretensao_salarial, $ingles, $office) {
        $this->db->where('cnh', $cnh);
        $this->db->where('disponivel_viagem', $disponivel_viagem);
        $this->db->where('disponivel_horario', $disponivel_horario);
        $this->db->where('pretensao_salarial', $pretensao_salarial);
        $this->db->where('ingles', $ingles);
        $this->db->where('office', $office);
        $habilidades = $this->db->get('habilidades')->result();
        if (count($habilidades) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function insertOutras($fk_habilidades, $habilidade, $inicio, $termino, $instituicao) {
        if ($this->verificaDuplicados($fk_habilidades, $habilidade)) {
            $dados = array(
                'id' => null,
                'fk_habilidades_id' => $fk_habilidades,
                'habilidade' => $habilidade,
                'inicio' => $inicio,
                'termino' => $termino,
                'instituicao' => $instituicao
            );
            if ($this->db->insert('outras_habilidades', $dados)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function verificaDuplicados($fk_habilidades, $habilidades) {
        $this->db->where('fk_habilidades_id', $fk_habilidades);
        $this->db->where('habilidade', $habilidades);
        $habilidades = $this->db->get('outras_habilidades')->result();
        if (count($habilidades) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

}
