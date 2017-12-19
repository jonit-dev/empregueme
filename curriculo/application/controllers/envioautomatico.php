<?php

class Envioautomatico extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tag_model', 'tag');
        $this->load->model('Curriculo_model', 'curriculo');
        //$this->output->enable_profiler(TRUE);
    }

    public function add($usu_codigo) {

        $dados['tags'] = $this->tag->getTags();
        $dados['usuario'] = $usu_codigo;
        $dados_header = array(
            'titulo' => 'Monte seu Currículo',
            'descricao' => 'Tenha um currículo personalizado e profissional em suas mãos.',
            'palavras_chave' => 'empregue-me, curriculo, empregos es'
        );
        $this->layout->region('html_header', 'view_html_header', $dados_header);
        $this->layout->region('corpo', 'view_tag_conteudo', $dados);
        $this->layout->region('html_footer', 'view_html_footer');
//chama o layout que irá exibir as views parciais..
        $this->layout->show('layout');
    }

    public function setAdd() {
        $usu_codigo = $this->input->post('user');
        $this->form_validation->set_rules('vaga1', 'Primeira Opção', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->add($usu_codigo);
        } else {
            $primeiro = $this->input->post('vaga1');
            $segundo = $this->input->post('vaga2');
            $terceiro = $this->input->post('vaga3');
            $tags = $primeiro . "/" . $segundo . "/" . $terceiro;
            if ($this->tag->insertTags($usu_codigo, $tags)) {
                $mensagem['sucesso'] = '<strong><span class="special">Vagas Cadastradas com sucesso!<br /> Envio automático de currículos funcionando!</strong></span>';
            } else {
                $mensagem['sucesso'] = '<strong><span class="special">Ocorreu um problema, tente novamente.</strong></span>';
            }
            $this->load->view('view_sucesso', $mensagem);
        }
    }

    public function funcao_envio_automatico($count = 0) {
//faco a verificacao por envio e mando curriculo
        $envio = $this->tag->getEnvio($count);
        if ($envio) {
//descobre o id do curriculo do usuário
            $dados['curriculo'] = $this->curriculo->getCurriculoByUsuCodigo($envio[0]->usu_codigo);
//faz explode das tags e pesquisa apenas a primeira
            $ex_tags = explode('/', $envio[0]->usu_tags);
            if ($ex_tags[$count] != "") {
                $vagas_nao_disponiveis = $this->tag->getVagasNaoDisponiveis($dados['curriculo']->id); //array de vagas que estou cadastrado (NAO POSSO ME CANDIDATAR)
                $vagas_disponiveis = $this->tag->getVagasDisponiveis($vagas_nao_disponiveis, $ex_tags[$count], $envio[0]->cid_codigo); //vaagas disponiveis, basta me candidatar
                if ($vagas_disponiveis) {
                    $this->curriculo->grava_curriculo_vaga($dados['curriculo']->id, $vagas_disponiveis[0]->vag_codigo, 0, 1, date("Y-m-d H:i:s")); //grava na tabela curriculo vagas
                    $this->tag->updateEnvioTags($envio[0]->usu_codigo, $count, 1); //atualiza usu_tags_envio: 1 - enviado 2 - não encontrou vaga
                } else {
                    $this->tag->updateEnvioTags($envio[0]->usu_codigo, $count, 2);
                }
            } else {
//não achou tag entao automaticamente status 2
                $this->tag->updateEnvioTags($envio[0]->usu_codigo, $count, 2);
            }
        }
    }

    public function envio_cron() {
        $this->funcao_envio_automatico(0);
        $this->funcao_envio_automatico(1);
        $this->funcao_envio_automatico(2);
    }

    public function limpa_cron() {
        $this->tag->cleanTags(0);
        $this->tag->cleanTags(1);
        $this->tag->cleanTags(2);
    }

}
