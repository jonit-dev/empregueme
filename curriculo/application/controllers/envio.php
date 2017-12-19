<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Envio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Curriculo_model', 'curriculo');
        $this->load->model('Habilidades_model', 'habilidades');
        $this->load->model('Formacao_model', 'formacao');
        $this->load->model('Historicos_model', 'historicos');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Cidades_model', 'cidade');
        $this->load->model('Vaga_model', 'vaga');
        $this->load->model('Feedback_model', 'feedback');
        //$this->output->enable_profiler(TRUE);
    }

    public function envia_curriculo($usu_codigo, $vag_codigo) {
        /*
         * Antes de enviar currículo verifico se o usuário é VIP ou não
         * VIP: Envia o currículo normalmente
         * FREE: Grava no banco mas nao envia
         */
        if (!$this->usuario->getVip($usu_codigo)) { //verifica se é membro vip
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo);
            $this->curriculo->grava_curriculo_vaga($dados['curriculo']->id, $vag_codigo, 0);
            //redirect('http://localhost/empre941/novo/main.php#vaga' . $vag_codigo); //offline
            redirect('http://www.empregue-me.com/novo/main.php?flag=free#vaga' . $vag_codigo); //online
        } else {
            /*
             * para montar o currículo, é necessário chamar cada parte do currículo
             * 1 curriculo
             * 2 habilidades
             * 3 formacao
             * 4 historicos profissionais
             * 5 dados do usuário
             */
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo);
            $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
            $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
            $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
            $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view
            $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
            $dados['usuario'] = $this->usuario->getById($usu_codigo);
            $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
            $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
            $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
            if ($this->curriculo->grava_curriculo_vaga($dados['curriculo']->id, $vag_codigo)) {
                $this->feedback->insert($usu_codigo, $vag_codigo);
                $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados, TRUE);
                $this->load->library('enviaemail');
                $email = $dados['vaga']->vag_email; //email da vaga
                $assunto = "Candidato para a vaga de " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
                $enviado = $this->enviaemail->envia_email_vaga($email, $mensagem, $assunto);
                //redirect('http://localhost/empre941/novo/main.php#vaga' . $dados['vaga']->vag_codigo); //offline
                redirect('http://www.empregue-me.com/novo/main.php?flag=vip#vaga' . $dados['vaga']->vag_codigo); //online
            } else {
                //redirect('http://localhost/empre941/novo/main.php#vaga' . $dados['vaga']->vag_codigo); //offline
                redirect('http://www.empregue-me.com/novo/main.php#vaga' . $dados['vaga']->vag_codigo); //online
            }
        }
    }

    public function getFeedback($usu_codigo, $vag_codigo, $feedback) {
        if ($this->feedback->getFeedback($usu_codigo, $vag_codigo, $feedback)) {
            $this->email_usuario($usu_codigo, $vag_codigo, $feedback);
            $dados['mensagem'] = "Muito Obrigado, foi enviado um e-mail de feedback para o candidato.";
        } else {
            $dados['mensagem'] = "Ocorreu um problema ao gerar o feedback, tente novamente. Obrigado.";
        }
        $this->load->view('view_sucesso_feedback', $dados);
    }

    public function email_usuario($usu_codigo, $vag_codigo, $opcoes) {
        $dados['usuario'] = $this->usuario->getById($usu_codigo);
        $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
        $dados['feedbacks'] = $this->feedback->getFeedbackEmail($opcoes);
        $mensagem_email = $this->load->view('view_feedback_candidato', $dados, TRUE);
        $this->load->library('enviaemail');
        $email = $dados['usuario']->usu_login;
        $assunto = "Feedback da vaga: " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
        $enviado = $this->enviaemail->envia_email($email, $dados['usuario']->usu_nome, $mensagem_email, $assunto);
    }

    public function envia_curriculo_cron() {
        /*
         * Envia currículo automático dos membros FREE / Envio automático
         * 1 - Busca na tabela curriculos-vagas por curriculos não enviados ->>> 3 em 3
         * 2 - Descobri o código do usuario pelo curriculo
         */
        $curriculos = $this->curriculo->getCurriculosNaoEnviados();
        foreach ($curriculos as $curriculo) {
            $usu_codigo = $this->curriculo->getUsuByCurriculo($curriculo->curr_codigo);
            $vag_codigo = $curriculo->vag_codigo;
            /*
             * para montar o currículo, é necessário chamar cada parte do currículo
             * 1 curriculo
             * 2 habilidades
             * 3 formacao
             * 4 historicos profissionais
             * 5 dados do usuário
             */
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo, $curriculo->curr_codigo);
            $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
            $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
            $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
            $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view
            $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
            $dados['usuario'] = $this->usuario->getById($usu_codigo);
            $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
            $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
            $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
            $atualiza_tbl = $this->curriculo->edita_curriculo_vaga($dados['curriculo']->id, $vag_codigo, 1);
            if ($atualiza_tbl) {
                $this->feedback->insert($usu_codigo, $vag_codigo);
                $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados, TRUE);
                $this->load->library('enviaemail');
                $email = $dados['vaga']->vag_email; //email da vaga
                $assunto = "Candidato para a vaga de " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
                $enviado = $this->enviaemail->envia_email_vaga($email, $mensagem, $assunto);
            }
            sleep(8);
        }
    }

    public function envia_curriculo_vip_cron() {
        /*
         * Envia currículo automático dos membros FREE / Envio automático
         * 1 - Busca na tabela curriculos-vagas por curriculos não enviados ->>> 3 em 3
         * 2 - Descobri o código do usuario pelo curriculo
         */
        $curriculos = $this->curriculo->getCurriculosNaoEnviadosVip();
        foreach ($curriculos as $curriculo) {
            $usu_codigo = $this->curriculo->getUsuByCurriculo($curriculo->curr_codigo);
            $vag_codigo = $curriculo->vag_codigo;
            /*
             * para montar o currículo, é necessário chamar cada parte do currículo
             * 1 curriculo
             * 2 habilidades
             * 3 formacao
             * 4 historicos profissionais
             * 5 dados do usuário
             */
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo, $curriculo->curr_codigo);
            $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
            $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
            $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
            $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view
            $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
            $dados['usuario'] = $this->usuario->getById($usu_codigo);
            $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
            $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
            $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
            $atualiza_tbl = $this->curriculo->edita_curriculo_vaga($dados['curriculo']->id, $vag_codigo, 1);
            if ($atualiza_tbl) {
                $this->feedback->insert($usu_codigo, $vag_codigo);
                $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados, TRUE);
                $this->load->library('enviaemail');
                $email = $dados['vaga']->vag_email; //email da vaga
                $assunto = "Candidato para a vaga de " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
                $enviado = $this->enviaemail->envia_email_vaga($email, $mensagem, $assunto);
            }
            sleep(8);
        }
    }

    public function envia_curriculo_empresa_cron() {
        /*
         * Envia currículo automático dos membros FREE / Envio automático
         * 1 - Busca na tabela curriculos-vagas por curriculos não enviados ->>> 3 em 3
         * 2 - Descobri o código do usuario pelo curriculo
         */
        $curriculos = $this->curriculo->getCurriculosNaoEnviadosEmpresa();
        foreach ($curriculos as $curriculo) {
            $usu_codigo = $this->curriculo->getUsuByCurriculo($curriculo->curr_codigo);
            $vag_codigo = $curriculo->vag_codigo;
            /*
             * para montar o currículo, é necessário chamar cada parte do currículo
             * 1 curriculo
             * 2 habilidades
             * 3 formacao
             * 4 historicos profissionais
             * 5 dados do usuário
             */
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo, $curriculo->curr_codigo);
            $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
            $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
            $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
            $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view
            $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
            $dados['usuario'] = $this->usuario->getById($usu_codigo);
            $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
            $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
            $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
            //$atualiza_tbl = $this->curriculo->edita_curriculo_vaga($dados['curriculo']->id, $vag_codigo, 1);
            if ($atualiza_tbl) {
                $this->feedback->insert($usu_codigo, $vag_codigo);
                $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados, TRUE);
                $this->load->library('enviaemail');
                $email = $dados['vaga']->vag_email; //email da vaga
                $assunto = "Candidato para a vaga de " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
                $enviado = $this->enviaemail->envia_email_vaga($email, $mensagem, $assunto);
            }
            sleep(8);
        }
    }

    public function desativaVaga($curr_codigo, $vag_codigo) {
        if ($this->vaga->confirmaVaga($curr_codigo, $vag_codigo)) {
            $this->vaga->removeVaga($vag_codigo);
            $dados['mensagem'] = "Vaga removida com sucesso.";
        } else {
            $dados['mensagem'] = "Ocorreu um problema, tente novamente. Obrigado.";
        }
        $this->load->view('view_sucesso_feedback', $dados);
    }

    /*
     * TESTES
     */

    public function testa_pagina_email($usu_codigo, $vag_codigo) {
        $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo);
        $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
        $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
        $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
        $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view        
        $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
        $dados['usuario'] = $this->usuario->getById($usu_codigo);
        $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
        $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
        $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
        //$mensagem = $this->load->view('view_curriculo_conteudo_email', $dados);

        $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados, TRUE);
        $this->load->library('enviaemail');
        $email = "diogokdc@gmail.com"; //email da vaga
        $assunto = "Candidato para a vaga de " . $dados['vaga']->vag_nome . " #" . $dados['vaga']->vag_codigo;
        $enviado = $this->enviaemail->envia_email_vaga($email, $mensagem, $assunto);
    }

    public function testa_pagina_email_off($usu_codigo, $vag_codigo) {
        $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($usu_codigo);
        $dados['habilidades'] = $this->habilidades->getById($dados['curriculo']->fk_habilidades_id);
        $dados['outras_habilidades'] = $this->habilidades->getOutrasById($dados['habilidades']->id); // necessita foreach na view
        $dados['formacao'] = $this->formacao->getById($dados['curriculo']->fk_formacao_id);
        $dados['cursos_formacao'] = $this->formacao->getCursosById($dados['formacao']->id); // necessita foreach na view        
        $dados['historicos'] = $this->historicos->getById($dados['curriculo']->id); // necessita foreach na view
        $dados['usuario'] = $this->usuario->getById($usu_codigo);
        $dados['cidade'] = $this->cidade->getCidadeById($dados['usuario']->cid_codigo);
        $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
        $dados['feedback_opcoes'] = $this->feedback->getOpcoes();
        $mensagem = $this->load->view('view_curriculo_conteudo_email', $dados);
    }

    public function feedback_teste($usu_codigo, $vag_codigo, $opcoes) {
        $dados['usuario'] = $this->usuario->getById($usu_codigo);
        $dados['vaga'] = $this->vaga->getVagaByCodigo($vag_codigo);
        $dados['feedbacks'] = $this->feedback->getFeedbackEmail($opcoes);
        $mensagem_email = $this->load->view('view_feedback_candidato', $dados);
    }

}
