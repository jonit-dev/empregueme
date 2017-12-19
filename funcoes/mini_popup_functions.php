<?php
function mini_popup()
{

    require_once('classes/display_main.php');
    $display_main = new display_main; //associa uma variával à classe de carregamento do layout

    if (isset($_SESSION['tipo_conta'])) {
        if ($_SESSION['tipo_conta'] == 0 && $_SESSION['membro_vip_ativo'] != 1)//se for conta tipo pessoa física e nao tiver VIP ativo...
        {
            $chance = rand(1, 100);
            $variar_mensagem = rand(0, 100);
            $mostra_mensagem = 0;

            if ($variar_mensagem >= 0 && $variar_mensagem <= 50) {
                $mostra_mensagem = 0;
            }
            if ($variar_mensagem >= 51 && $variar_mensagem <= 60) {
                $mostra_mensagem = 1;
            }

            if ($variar_mensagem >= 61 && $variar_mensagem <= 80) {
                $mostra_mensagem = 2;
            }

            if ($variar_mensagem >= 81 && $variar_mensagem <= 100) {
                $mostra_mensagem = 3;
            }

            if ($chance >= 0) {

                $data = explode(' ', $_SESSION['nome']);
                $primeiro_nome = $data[0];

                $propaganda_vip = array(
                    '<a href=\'membro_vip.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Cansado das filas de envio de currículo? Clique aqui!</a>',
                    '<a href=\'membro_vip.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer ter acesso a vagas exclusivas, com menor concorrência? Clique aqui!</a>',
                    '<a href=\'membro_vip.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer enviar seu currículo automaticamente para as vagas? Clique Aqui!</a>',
                    '<a href=\'membro_vip.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer deixar seu currículo em destaque?!</a>'
                );

                //$display_main->show_mini_popup($propaganda_vip[$mostra_mensagem]);
            }
        }


    }


    if (isset($_SESSION['tipo_conta'])) {
        if ($_SESSION['tipo_conta'] == 1 && $_SESSION['plano_recrutador_ativo'] != 1)//se for conta tipo pessoa física e nao tiver PLANO RECRUTADOR ativo...
        {
            $chance = rand(1, 100);
            $variar_mensagem = rand(0, 100);
            $mostra_mensagem = 0;

            if ($variar_mensagem >= 0 && $variar_mensagem <= 40) {
                $mostra_mensagem = 0;
            }
            if ($variar_mensagem >= 41 && $variar_mensagem <= 60) {
                $mostra_mensagem = 1;
            }

            if ($variar_mensagem >= 61 && $variar_mensagem <= 80) {
                $mostra_mensagem = 2;
            }

            if ($variar_mensagem >= 81 && $variar_mensagem <= 100) {
                $mostra_mensagem = 3;
            }

            if ($chance >= 20) {

                $data = explode(' ', $_SESSION['nome']);
                $primeiro_nome = $data[0];

                $propaganda_vip = array(
                    '<a href=\'plano_recrutador.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer poder <b>entrar em contato com qualquer candidato</b> do Empregue-me? Clique Aqui!</a>',
                    '<a href=\'plano_recrutador.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer <b>acelerar sua captação de currículos</b> com uma Vaga Destaque? Clique aqui!</a>',
                    '<a href=\'plano_recrutador.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer poder <b>salvar seus currículos favoritos</b>? Clique aqui!</a>',
                    '<a href=\'plano_recrutador.php\' target=\'_self\'>Ei ' . $primeiro_nome . '! Quer poder <b>gerenciar seu processo seletivo</b> com mais eficácia ? Clique aqui!</a>'
                );

                //$display_main->show_mini_popup($propaganda_vip[$mostra_mensagem]);
            }
        }


    }


}

?>