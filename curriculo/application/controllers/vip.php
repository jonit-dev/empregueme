<?php

class Vip extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Vip_model', 'vip');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->library('enviaemail');
        //$this->output->enable_profiler(TRUE);
    }

    /*
     * ATIVA VIP
     */

    public function ativaVip_cron() {
        //verifica se tem algum pagante
        $vip_pagante = $this->vip->getPagantes();
        if ($vip_pagante) {
            //descobre o id do usuário
            $usu_codigo = explode("/", $vip_pagante[0]->tran_referencia);
            $usu_codigo = $usu_codigo[1];
            $vip = $this->vip->getVip($usu_codigo);
            if ($vip) {
                $tipo_conta = $this->vip->getTipoConta($vip[0]->fk_tpCont_codigo);
                //data de vencimento do vip ---INICIO          
                $dt = time() + (86400 * $tipo_conta[0]->tpCont_dias);

                $get_di = getdate($dt);
                $data_vencimento = $get_di['year'] . '-' . $get_di['mon'] . '-' . $get_di['mday'];
                //data de vencimento do vip ---FIM
                //atualiza vip e o ativa
                if ($this->vip->ativaVip($usu_codigo, $data_vencimento)) {
                    $this->vip->desativaTransacao($vip_pagante[0]->tran_codigo);
                    //pega dados usuario
                    $dados['usuario'] = $this->usuario->getById($usu_codigo);
                    //envia email para VIP de boas vindas
                    $assunto = "Ativação do Membro VIP";
                    $dados['sucesso'] = ""
                            . "<p>Olá " . $dados['usuario']->usu_nome . "!</p>
                                <p>Primeiramente gostaríamos de agradecer a confiança em nosso trabalho. Desejamos que o plano VIP traga bons frutos e que você consiga rapidamente uma entrevista ou um novo emprego. Acabamos de realizar a ativação de seu plano VIP. Está tudo ok? Acesse sua conta e veja se realmente foi ativado, por favor.</p>
                                <p>Este é um e-mail automático, favor não responder. A equipe empregue-me agradece pela confiança.</p>";
                    $mensagem = $this->load->view('view_novovip_email', $dados, TRUE);
                    $enviado = $this->enviaemail->envia_email($dados['usuario']->usu_login, $dados['usuario']->usu_nome, $mensagem, $assunto);
                }
            }
        }
    }

    /*
     * VENCIMENTO VIP
     */

    public function desativaVip_cron() {
        /*
         * 1 - pega vip com dt vencimento e vip_envio_emailVenc = 0
         * 2 - manda e-mail
         * 3 - altera status para 2 e vip_envio_emailVenc 1
         */
        $vip_vencidos = $this->vip->getVipsVencidos();
        //var_dump($vip_vencidos);
        //exit;
        foreach ($vip_vencidos as $vip_vencido) {
            $data_vencimento = strtotime($vip_vencido->vip_dt_vencimento);
            $data_hoje = strtotime(date('Y-m-d'));
            if ($data_vencimento < $data_hoje) {
                //pega dados usuario
                $dados['usuario'] = $this->usuario->getById($vip_vencido->fk_usu_codigo);
                if ($dados['usuario'] != null) {
                    //envia email para VIP de boas vindas
                    $assunto = "Vencimento de sua conta membro VIP";
                    $dados['sucesso'] = "
              <p>Informamos que sua conta de Membro Vip está desativada, efetue novo pagamento para a renovação da sua conta e continue usufruindo de todos os benefícios.</p>
              <p>Este é um e-mail automático, favor não responder. A equipe empregue-me agradece pela confiança.</p>
              <p>Dúvidas: sac@empreguemeagora.com.br</p>";
                    $mensagem = $this->load->view('view_novovip_email', $dados, TRUE);
                    $enviado = $this->enviaemail->envia_email($dados['usuario']->usu_login, $dados['usuario']->usu_nome, $mensagem, $assunto);
                    if ($enviado) {
                        //altero no bd vip_envio_emailVenc = 1 e fk_stat_codigo = 2
                        $this->vip->alteraStatus($dados['usuario']->usu_codigo);
                    } else {
                        echo "erro";
                    }
                }
            }
            sleep(8);
        }
    }

    /*
     * CORRIG BUG VIP ANTIGOS
     */

    public function corrigeVip_cron() {
        $vips = $this->vip->getVipOld();
        if ($vips) {
            //$assunto = "Conheça o novo empregue-me";
            //$dados['sucesso'] = "<p>Olá! O empregue-me está diferente, mais moderno, mais fácil e com muitas vagas disponíveis. Estamos enviando esse e-mail para informar que ocorreu uma mudança no seu login, acesse o <a href='http://www.empregue-me.com' target='_blank'>empregue-me</a> e digite no campo Login: " . $vips[0]->usu_login . " e a Senha: empregueme. Caso o e-mail de login não seja seu entre em contato no sac@empreguemeagora.com.br.</p>
            //<p>Este é um e-mail automático, favor não responder. A equipe empregue-me agradece pela confiança.</p>";
            $assunto = "Atualização do Currículo";
            $dados['sucesso'] = "Olá! Após o lançamento do novo empregue-me ocorreu um problema no cadastro do currículo devido a quantidade de acessos simultâneos no site. Estamos enviando esse e-mail para lhe informar que o site foi atualiado e o cadastro de currículos se encontra em funcionamento. 
                <p>Este é um e-mail automático, favor não responder. A equipe empregue-me agradece pela confiança.</p>";
            $mensagem = $this->load->view('view_novovip_email', $dados, TRUE);
            $enviado = $this->enviaemail->envia_email($vips[0]->usu_login, $vips[0]->usu_nome, $mensagem, $assunto);
            if ($enviado) {
                $this->vip->desativaFlag($vips[0]->vip_codigo);
            }
        }
    }

}
