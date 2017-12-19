$(function() {

    $("select[name=estado]").change(function() {

        estado = $(this).val();

        if (estado === '')
            return false;

        resetaCombo('cidade');
        //função para pegar o caminho da aplicação-----INICIO*/
        //var l = window.location;
        //var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
        //função para pegar o caminho da aplicação-----FIM*/
        $.getJSON('http://www.empreguemeagora.com.br/devempregueme/rede/novo/curriculo/curriculo/getCidades/' + estado, function(data) {

            var option = new Array();

            $.each(data, function(i, obj) {

                option[i] = document.createElement('option');
                $(option[i]).attr({value: obj.cod_cidades});
                $(option[i]).append(obj.nome);

                $("select[name='cidade']").append(option[i]);

            });

        });

    });

});

function resetaCombo(el) {
    $("select[name='" + el + "']").empty();
    var option = document.createElement('option');
    $(option).attr({value: ''});
    $(option).append('Escolha');
    $("select[name='" + el + "']").append(option);
}