<?php

class Cidades_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* Variaveis relacionadas ao estado
     * 
     */

    var $cod_estados;
    var $sigla;
    var $nome_estado;

    /* Variaveis relacionadas a cidade
     * 
     */
    var $estados_cod_estados;
    var $cod_cidades;
    var $nome_cidade;
    var $cep;

    public function getEstados() {
        $this->db->order_by('nome', 'asc');
        return $this->db->get('estados')->result();
    }

    public function getEstadoById($cod_estados) {
        $this->db->where('cod_estados', $cod_estados);
        $estados = $this->db->get('estados')->result();
        if (count($estados) == 1) {
            foreach ($estados as $estado) {
                $this->cod_estados = $estado->cod_estados;
                $this->sigla = $estado->sigla;
                $this->nome_estado = $estado->nome;
            }
            return $this;
        }
    }

    public function getCidades($estados_cod_estados) {
        $this->db->where('estados_cod_estados', $estados_cod_estados);
        $this->db->order_by('nome', 'asc');
        return $this->db->get('cidades')->result();
    }

    public function getCidadeById($cod_cidade) {
        $this->db->where('cod_cidades', $cod_cidade);
        $cidades = $this->db->get('cidades')->result();
        if (count($cidades) == 1) {
            foreach ($cidades as $cidade) {
                $this->estados_cod_estados = $cidade->estados_cod_estados;
                $this->cod_cidades = $cidade->cod_cidades;
                $this->nome_cidade = $cidade->nome;
                $this->cep = $cidade->cep;
            }
            $dados = $this;
            $dados = $this->getEstadoById($this->estados_cod_estados);
        } else {
            $dados = null;
            $dados = null;
        }
        return $dados;
    }

}
