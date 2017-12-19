$(document).ready(function(e) {


    var $mudou_cargo_primeiro_banner = false;


    //se tentarmos alterar o cargo sem termos mudado a categoria primeiro...
    $("#cargo").click(function() {
        if ($mudou_cargo_primeiro_banner == false)
        {//mostra mensagem de erro!
            alert('Selecione uma categoria primeiro!');
        }//end if

    });



    //ao alterarmos o select da categoria


    $("#categoria").on('change', function() {//atualiza quando clicar e trocar o select

        //vamos limpar nosso conteudo
        $("#categoria option[value='']").remove();

        //primeiro, vamos limpar o conteúdo do select subcategoria
        $("#cargo option").html('');
        //altera variável que registra que mudamos primeiro a categoria
        $mudou_cargo_primeiro_banner = true;


        //REQUISIÇÃO AJAX!
        var qry = $("#categoria").val();//armazena o valor selecionado no select categoria, que corresponde à ID da categoria (iremos enviar isso ao nosso script de processamento ajax, para que este retorne os dados de subcategoria referentes a esta categoria selecionada)		

        //agora, vamos fazer a requisição ajax do conteúdo do select
        $.post('ajax/get_categoria_cargo_content.php',
                {
                    categoria_id: qry,
                }
        , function(data)
        {
            //inicia manejo de resposta do servidor
            //alert(data);// importante para debugar
            //seleciona subcategoria e atualiza seu valor
            $("#cargo").html(data);



        });//end requisição AJAX




    });//end select estado								
});//end ready// JavaScript Document