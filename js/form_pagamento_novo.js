// JavaScript Document

$(document).ready(function() {


//SELEÇÃO DE PLANOS 
    $("#plano_trimestral:checked").parent('.planos').css('background-color', '#fff3b3');//deixa o plano mensal amarelo, logo de início

    $("#plano_mensal").click(function() {

        $("#plano_mensal:checked").parent('.planos').css('background-color', '#fff3b3');//deixa o plano mensal amarelo

        $(this).parent('.planos').siblings('.planos').css({'background-color': 'white'});//deixa os outros planos brancos
    });

    $("#plano_trimestral").click(function() {

        $("#plano_trimestral:checked").parent('.planos').css('background-color', '#fff3b3');
        $(this).parent('.planos').siblings('.planos').css({'background-color': 'white'});

    });

    $("#plano_semestral").click(function() {

        $("#plano_semestral:checked").parent('.planos').css('background-color', '#fff3b3');
        $(this).parent('.planos').siblings('.planos').css({'background-color': 'white'});

    });

    $("#plano_anual").click(function() {

        $("#plano_anual:checked").parent('.planos').css('background-color', '#fff3b3');
        $(this).parent('.planos').siblings('.planos').css({'background-color': 'white'});

    });


//SCRIPT DE VALIDAÇÃO ==> LEMBRAR QUE TEM QUE VALIDAR NO PHP TB!!

    $("#go2").click(function() {

        var cat_selecionada = $("#cat_vip:checked").val();//verifica o valor da categoria selecionada

        var $tem_cat_selecionada = false;

//alert(plano_selecionado);
        if (cat_selecionada > 0)//se for maior que 0 é porque tem categoria selecionada
        {
            $tem_cat_selecionada = true;
        }

        if ($tem_cat_selecionada == false)//se nao tem categoria selecionada
        {
            alert('Selecione uma categoria antes de prosseguir!');
            return false;
        }
        else//se tem categoria selecionada, prossiga!
        {
            $("#form_processa_pagamento").submit();

        }//end else
    });
});//end ready