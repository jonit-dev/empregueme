<?php

class Formacao_model extends CI_Model {
    
    var $id;
    var $area_formacao;
    var $escolaridade_formacao;

    public function getById($id_formacao) {
        $this->db->select('formacao.id as formacao_id, escolaridade_formacao.descricao as escolaridade,area_formacao.descricao as area');
        $this->db->join('escolaridade_formacao', 'escolaridade_formacao.id = formacao.fk_escolaridade_formacao_id', 'inner');
        $this->db->join('area_formacao', 'area_formacao.id = formacao.fk_area_formacao_id', 'inner');
        $this->db->where('formacao.id', $id_formacao);
        $formacoes = $this->db->get('formacao')->result();
        if (count($formacoes) > 0) {
            foreach ($formacoes as $formacao) {
                $this->id = $formacao->formacao_id;
                $this->area_formacao = $formacao->area;
                $this->escolaridade_formacao = $formacao->escolaridade;
            }
            $dados = $this;
        } else {
            $dados = null;
        }
        return $dados;
    }

    public function getCursosById($formacao_id) {
        $this->db->where('fk_formacao_id', $formacao_id);
        $formacoes = $this->db->get('cursos_formacao')->result();
        if (count($formacoes) > 0) {
            return $formacoes;
        } else {
            return 0;
        }
    }

    public function getArea() {
        $this->db->order_by('descricao', 'asc');
        return $this->db->get('area_formacao')->result();
    }

    public function getEscolaridade() {
        return $this->db->get('escolaridade_formacao')->result();
    }

    public function insertFormacao($fk_area_formacao, $fk_escolaridade_formacao) {
        $dados = array(
            'fk_area_formacao_id' => $fk_area_formacao,
            'fk_escolaridade_formacao_id' => $fk_escolaridade_formacao
        );
        if ($this->db->insert('formacao', $dados)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function verificaDuplicadosCursos($fk_formacao_id, $curso) {
        $this->db->where('fk_formacao_id', $fk_formacao_id);
        $this->db->where('curso', $curso);
        $cursos = $this->db->get('cursos_formacao')->result();
        if (count($cursos) == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public function insertCursos($fk_formacao, $curso, $inicio, $termino, $instituicao) {
        if ($this->verificaDuplicadosCursos($fk_formacao, $curso)) {
            $dados = array(
                'id' => null,
                'fk_formacao_id' => $fk_formacao,
                'curso' => $curso,
                'inicio' => $inicio,
                'termino' => $termino,
                'instituicao' => $instituicao
            );
            if ($this->db->insert('cursos_formacao', $dados)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
