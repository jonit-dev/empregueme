<?php

class Categorias_model extends CI_Model {

    public function getCategorias() {
        return $this->db->get('categoria')->result();
    }

}
