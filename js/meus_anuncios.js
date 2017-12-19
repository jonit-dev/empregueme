// JavaScript Document
$(document).ready(function(e) {


//Carrega a função de criar o banner (lembre-se que scripts de função externas não funcionam se tivem $(document).ready...etc.
    $.getScript('js/banner_direto_js.js');

//*----------------- DIVULGAR VAGA ------------------------**	
    $(".divulga_link").click(function() {

        var link_para_divulgar = $(this).parent('.vaga_editar_item').parent('.vaga_editar').siblings('a').attr('href');

        link_para_divulgar = 'https://www.facebook.com/sharer/sharer.php?u=http://www.empregue-me.com/novo/' + link_para_divulgar;
        //mostra o banner
        mostra_banner('Divulgue sua vaga', '<p>Para divulgar, <strong>Clique no link abaixo ou copie e cole em algum lugar para compartilhar</strong>. Sugerimos que você divulgue em redes sociais (Facebook), twitter, para seus contatos de e-mail, etc. Seja criativo e terá bons resultados!</p><center><p><strong><a class="vermelho_destaque" href="' + link_para_divulgar + '" target="_blank">Clique aqui para divulgar</a></strong></p></center><p></p><br><br><br><br><center><input type="button" id="ok_btm" value="Fechar"/></center>');


    });//end divulga link click




//*----------------- DELETAR VAGA ------------------------**

    $(".deletar_vaga").on('click', function() {


        //eu tenho que jogar o escopo do this para uma variável.. porque se tentar usar somente o this no callback do ajax, nao vao funcionar (parece que ele tem um escopo próprio que nao reconhece o escopo da função em que está rodando). Confuso, mas é o que ocorre =p
        var $this = this;
        //pega id da vaga
        var id_vaga = $(this).parent('.vaga_editar_item').parent('.vaga_editar').siblings('input[name=vaga_codigo]').val();
        //alert(id_vaga);

        //remove vaga da base de dados

        $.post('ajax/remove_vaga.php',
                {
                    id_vaga: id_vaga
                }, function(data) {
            //callback
            switch (data)
            {
                case 'sucesso':
                    //vamos remover a vaga do fluxo 
                    //dá fadeout na vaga que removeu
                    //alert('Vaga removida');

                    $($this).parent('.vaga_editar_item').parent('.vaga_editar').parent('.vaga').fadeOut(1000);

                    break;

                case 'erro':
                    alert('Erro ao deletar a vaga. Tente novamente.');
                    break;
            }


        }

        );//end post



    });//end click deletar vaga

    //*----------------- DELETAR SERVIÇO------------------------**

    $(".deletar_servico").on('click', function() {
        //eu tenho que jogar o escopo do this para uma variável.. porque se tentar usar somente o this no callback do ajax, nao vao funcionar (parece que ele tem um escopo próprio que nao reconhece o escopo da função em que está rodando). Confuso, mas é o que ocorre =p
        var $this = this;
        //pega id da vaga
        var id_servico = $(this).parent('.vaga_editar_item').parent('.vaga_editar').siblings('input[name=servico_codigo]').val();
        var free_vip = $(this).parent('.vaga_editar_item').parent('.vaga_editar').siblings('input[name=free_vip]').val();

        //remove vaga da base de dados

        $.post('ajax/remove_servico.php',
                {
                    id_servico: id_servico
                }, function(data) {
            //callback
            switch (data)
            {
                case 'sucesso':
                    //vamos remover a vaga do fluxo 
                    //dá fadeout na vaga que removeu
                    //alert('Vaga removida');
                    if (free_vip == 0) {
                        $($this).parent('.vaga_editar_item').parent('.vaga_editar').parent('.vaga').fadeOut(1000);
                    } else {
                        $($this).parent('.vaga_editar_item').parent('.vaga_editar').parent('.vaga_exclusiva').fadeOut(1000);
                    }

                    break;

                case 'erro':
                    alert('Erro ao deletar o serviço. Tente novamente.');
                    break;
            }


        }

        );//end post



    });//end click deletar vaga

});//end ready