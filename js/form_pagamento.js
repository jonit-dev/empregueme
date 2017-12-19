// JavaScript Document

$(document).ready(function(e) {


//DEFINIÇÕES PADRÃO	

    $("#tab1").addClass('tab_active');


    $('.content').children().not('#content1').hide();//esconde todos menos o content1


    //$("#content3_boleto").siblings().not("#content3_boleto").hide();
    //$("#content3_boleto").show();


//VERIFICANDO FORMA DE PAGAMENTO
    $("input[name=forma_pagto]").click(function() {
        var tipo_pagamento = $(this).val();
        switch (tipo_pagamento)
        {
            case 'boleto':
                $("#content3_boleto").siblings().not("#content3_boleto").hide();
                $("#content3_boleto").show();//mostra div boleto
                break;


            case 'cartao':
                $("#content3_cartao").siblings().not("#content3_cartao").hide();
                $("#content3_cartao").show();//mostra div cartão

                break;


        }
    });





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

        var plano_selecionado = $("input[name=plano]:checked").val();
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
            String(plano_selecionado)



            //se está tudo selecionado, vamos prosseguir
            if (plano_selecionado.length > 0)
            {

                //PROSSEGUE DE ETAPA, SE TIVER PREENCHIDO
                //deixa a aba 2 ativa e deixa essa aba inativa (a primeira)
                $('#tab2').addClass('tab_active');
                $("#tab1").removeClass('tab_active');

                $('.content').children().not('#content2').hide();
                $("#content2").show();//mostra a div da segunda etapa e esconde as outras


            }

        }//end else
    });




    $("#go3").click(function() {

        var falta_preencher = '';
        var erro = false;
        var nome = $("input[name=nome]").val();
        String(nome);
        var email = $("input[name=email]").val();
        String(email);
        var endereco = $("input[name=endereco]").val();
        String(endereco);
        var n_residencial = $("input[name=n_residencial]").val();
        String(n_residencial);
        var complemento = $("input[name=complemento]").val();
        String(complemento);
        var bairro = $("input[name=bairro]").val();
        String(bairro);
        var cep = $("input[name=cep]").val();
        String(cep);
        var estado = $("select[name=estado]").val();
        String(estado);
        var cidade = $("select[name=cidade]").val();
        String(cidade);

        //executa verificação... se encontrar algo salva na variável o que está errado e torna o campo errado vermelho

        if (nome.length > 0 && email.length > 0 && endereco.length > 0 && n_residencial.length > 0 && complemento.length > 0 && bairro.length > 0 && cep.length > 0 && estado != 'none' && cidade != 'none')
        {
            erro = false;	//está tudo ok, vamos prosseguir
        }


        if (nome.length == 0)
        {
            falta_preencher += 'Nome,';
            erro = true;
            $("input[name=nome]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (email.length == 0)
        {
            falta_preencher += 'E-mail,';
            erro = true;
            $("input[name=email]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (endereco.length == 0)
        {
            falta_preencher += 'Endereço,';
            erro = true;
            $("input[name=endereco]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (n_residencial.length == 0)
        {
            falta_preencher += 'Número residencial,';
            erro = true;
            $("input[name=n_residencial]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (complemento.length == 0)
        {
            falta_preencher += 'Complemento,';
            erro = true;
            $("input[name=complemento]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (bairro.length == 0)
        {
            falta_preencher += 'Bairro,';
            erro = true;
            $("input[name=bairro]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (cep.length == 0)
        {
            falta_preencher += 'CEP,';
            erro = true;
            $("input[name=cep]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (estado == 'none')
        {
            falta_preencher += 'Estado,';
            erro = true;
            $("select[name=estado]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }
        if (cidade == 'none')
        {
            falta_preencher += 'Cidade,';
            erro = true;
            $("select[name=cidade]").css({'background-color': '#ffe8e8'});//deixa campo vermelho
        }


        //vamos validar o email
        $.getScript('js/funcoes_js/funcoes_validacao.js', function() {//DEVEMOS RODAR A FUNÇÃO NO CALLBACK DO GETSCRIPT, POIS É ASSÍNCRONO (tipo AJAX).. ou seja, se tentar rodar fora NÃO FUNCIONA (dá reference error)


            if (validateEmail(email) == false)
            {
                erro = true;

                alert('Seu e-mail está inválido. Por favor, insira novamente.');
                falta_preencher += 'E-mail válido,';
                $("input[name=email]").val('Insira um e-mail válido!');
                $("input[name=email]").css({'background-color': '#ffe8e8'});//deixa campo vermelho

            }


            if (erro == false)//se está tudo correto, vamos prosseguir
            {
                //prossegue de etapa
                //deixa a aba 2 ativa e deixa essa aba inativa
                //$('#tab3').addClass('tab_active');
                $("#tab1,#tab2").removeClass('tab_active');


                //$('.content').children().not('#content3').hide();
                //$("#content3").show();
                
                $("#form_processa_pagamento").submit();
            }
            else
            {
                String(falta_preencher);
                falta_preencher = falta_preencher.slice(0, -1);//remove última vírgula
//se nao, mostre o que falta preencher
                alert('Você esqueceu de preencher os seguites itens: ' + falta_preencher);
            }





        });//end getScript


    });


//CONTROLE DO SELECT PARCELAMENTO
    $("select[name=cartao]").change(function() {

        var tipo_cartao = $(this).val();

        var parcelamento = $("select[name=parcelamento]");

        switch (tipo_cartao)
        {
            case 'visa':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
            case 'mastercard':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
            case 'americanexpress':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
            case 'elo':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
            case 'aura':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option>');
                break;
            case 'dinersclub':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
            case 'hipercard':
                parcelamento.html('<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>  <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
                break;
        }



    });

//CONTROLE AJUDA DO PREENCHIMENTO DO CARTÃO
    $('#n_cartao,select[name=mes_expira],select[name=ano_expira],input[name=cvv_cartao],input[name=nome_cartao]').focus(function() {

        $(this).siblings('.box_cartao').fadeIn(1000);
        $('.box_cartao').not($(this).siblings('.box_cartao')).hide();//esconde todos as outras boxes de ajuda que nao sejam essa
    });	//end focus

    $('#n_cartao,select[name=mes_expira],select[name=ano_expira],input[name=cvv_cartao],input[name=nome_cartao]').blur(function() {

        $(this).siblings('.box_cartao').fadeOut(1000);
    });	//end blur	



//FUNÇÃO PARA VALIDAR N° DO CARTAO DE CREDITO
    $('input[name=n_cartao]').blur(function() {
        //carrega script de validação do cartao
        $.getScript('js/funcoes_js/creditcard.js', function() {

            var numero_cartao = $('#n_cartao').val(), nome_cartao = $('select[name=cartao]').val();


            //primeiro, só vamos checar alguns números

            if (nome_cartao == 'Visa' || nome_cartao == 'MasterCard' || nome_cartao == 'AmEx' || nome_cartao == 'DinersClub')
            {

                obj_n_cartao = $('#n_cartao');
                if (!checkCreditCard(numero_cartao, nome_cartao))
                {
                    obj_n_cartao.css({'background-color': '#ffe8e8'})
                    obj_n_cartao.siblings('.checa_valido').show();
                    //alert('Número do cartão incorreto. Verifique se você digitou tudo corretamente');

                }
                else
                {
                    $('#n_cartao').css({'background-color': '#e2ffe2'})
                    obj_n_cartao.siblings('.checa_valido').hide();
                }

            }//end verification


        });



    });


//FUNÇÃO PARA VALIDAR CPF

    $('input[name=cpf_cartao]').blur(function() {
        $.getScript('js/funcoes_js/funcoes_validacao.js', function() {

            var cpf = $('input[name=cpf_cartao]').val();
            var obj_cpf = $('input[name=cpf_cartao]');
            if (TestaCPF(cpf) == false)//se é falso
            {


                obj_cpf.css({'background-color': '#ffe8e8'})
                obj_cpf.siblings('.checa_valido').show();
                //alert('CPF Inválido. Verifique se você digitou tudo corretamente');

            }
            else
            {
                obj_cpf.css({'background-color': '#e2ffe2'})
                obj_cpf.siblings('.checa_valido').hide();
            }


        });

    });//quando usuário sair do campo preenchido, vamos verificar





});//end ready