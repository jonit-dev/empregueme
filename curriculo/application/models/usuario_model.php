<?php

class Usuario_model extends CI_Model {

    var $usu_codigo;
    var $usu_id;
    var $usu_nome;
    var $cid_codigo;
    var $usu_dt_cad;
    var $usu_email;
    var $usu_login;
    var $usu_senha;
    var $usu_tags;
    var $usu_permissao;
    var $usu_sexo;
    var $usu_idade;
    var $usu_bairro;
    var $usu_telefone1;
    var $usu_telefone2;
    var $usu_link_facebook;
    var $usu_foto_curriculo;

    public function add($usu_id, $usu_nome, $cid_codigo, $usu_dt_cad, $usu_email, $usu_login, $usu_senha, $usu_tags, $usu_permissao, $usu_sexo, $usu_idade, $usu_bairro, $usu_telefone1, $usu_telefone2, $usu_link_facebook, $usu_foto_curriculo) {
        $this->usu_codigo = null;
        $this->usu_id = $usu_id;
        $this->usu_nome = $usu_nome;
        $this->cid_codigo = $cid_codigo;
        $this->usu_dt_cad = $usu_dt_cad;
        $this->usu_email = $usu_email;
        $this->usu_login = $usu_login;
        $this->usu_senha = $usu_senha;
        $this->usu_tags = $usu_tags;
        $this->usu_permissao = $usu_permissao;
        $this->usu_sexo = $usu_sexo;
        $this->usu_idade = $usu_idade;
        $this->usu_bairro = $usu_bairro;
        $this->usu_telefone1 = $usu_telefone1;
        $this->usu_telefone2 = $usu_telefone2;
        $this->usu_link_facebook = $usu_link_facebook;
        $this->usu_foto_curriculo = $usu_foto_curriculo;
        if ($this->db->insert('usuario', $this)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function update($usu_codigo, $usu_id, $usu_nome, $cid_codigo, $usu_dt_cad, $usu_email, $usu_login, $usu_senha, $usu_tags, $usu_permissao, $usu_sexo, $usu_idade,$usu_bairro, $usu_telefone1, $usu_telefone2, $usu_link_facebook, $usu_foto_curriculo) {
        $this->usu_codigo = $usu_codigo;
        $this->usu_id = $usu_id;
        $this->usu_nome = $usu_nome;
        $this->cid_codigo = $cid_codigo;
        $this->usu_dt_cad = $usu_dt_cad;
        $this->usu_email = $usu_email;
        $this->usu_login = $usu_login;
        $this->usu_senha = $usu_senha;
        $this->usu_tags = $usu_tags;
        $this->usu_permissao = $usu_permissao;
        $this->usu_sexo = $usu_sexo;
        $this->usu_idade = $usu_idade;
        $this->usu_bairro = $usu_bairro;
        $this->usu_telefone1 = $usu_telefone1;
        $this->usu_telefone2 = $usu_telefone2;
        $this->usu_link_facebook = $usu_link_facebook;
        $this->usu_foto_curriculo = $usu_foto_curriculo;
        $this->db->where('usu_codigo', $usu_codigo);
        return $this->db->update('usuario', $this);
    }

    public function getById($usu_codigo) {
        $this->db->where('usu_codigo', $usu_codigo);
        $usuarios = $this->db->get('usuario')->result();
        if (count($usuarios) > 0) {
            foreach ($usuarios as $usuario) {
                $this->usu_codigo = $usuario->usu_codigo;
                $this->usu_id = $usuario->usu_id;
                $this->usu_nome = $usuario->usu_nome;
                $this->cid_codigo = $usuario->cid_codigo;
                $this->usu_dt_cad = $usuario->usu_dt_cad;
                $this->usu_email = $usuario->usu_email;
                $this->usu_login = $usuario->usu_login;
                $this->usu_senha = $usuario->usu_senha;
                $this->usu_tags = $usuario->usu_tags;
                $this->usu_permissao = $usuario->usu_permissao;
                $this->usu_sexo = $usuario->usu_sexo;
                $this->usu_idade = $usuario->usu_idade;
                $this->usu_bairro = $usuario->usu_bairro;
                $this->usu_telefone1 = $usuario->usu_telefone1;
                $this->usu_telefone2 = $usuario->usu_telefone2;
                $this->usu_link_facebook = $usuario->usu_link_facebook;
                $this->usu_foto_curriculo = $usuario->usu_foto_curriculo;
            }
            $dados = $this;
        } else {
            $dados = null;
        }
        return $dados;
    }
    
    public function getVip($usu_codigo) {
        $this->db->where('fk_usu_codigo',$usu_codigo);
        $this->db->where('fk_stat_codigo',1);
        $vip = $this->db->get('membro_vip')->result();
        if(count($vip) > 0) {
            return 1;
        } else {
            return 0;
        }        
    }
}
