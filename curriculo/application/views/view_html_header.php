<?php
echo doctype('html5');
echo "<html>";
echo "<head>";
echo "<title>" . $titulo . "</title>";
$meta = array(
    array('name' => 'description', 'content' => $descricao),
    array('name' => 'keywords', 'content' => $palavras_chave),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);
echo meta($meta);
echo link_tag(array('href' => 'assets/images/favicon.ico', 'rel' => 'shortcut icon', 'type' => 'image/x-icon'));
echo link_tag(array('href' => 'assets/css/cadastro.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
echo link_tag(array('href' => 'assets/css/vip.css', 'rel' => 'stylesheet', 'type' => 'text/css'));

echo "<script type='text/javascript' src='" . base_url('./assets/js/jquery-1.11.0.min.js') . "'></script>";
//echo "<script type='text/javascript' src='" . base_url('./assets/js/getCidades.js') . "'></script>";
?>
<!--  jquery masked input -->
<script src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(function($) {
        //Inicio Mascara Telefone
        $('input[type=tel]').mask("(99) 9999-9999?9").ready(function(event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        });
        //Fim Mascara Telefone
        $('#rel_dt_visita').mask("99/99/9999");
        $('#inicio_dt_visita').mask("99/99/9999");
        $('#fim_dt_visita').mask("99/99/9999");
    });
</script>
<!-----SCRIPT PARA CAMPO DE SALARIO----->
<script src="<?php echo base_url('assets/js/jquery.price_format.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#pretensao_salarial').priceFormat({
            prefix: 'R$ ',
            centsSeparator: '.',
            thousandsSeparator: '',
            clearPrefix: true
        });
    });
</script>
<!-------->
<script type="text/javascript">
    function resetaCombo(el) {
        $("select[name='" + el + "']").empty();
        var option = document.createElement('option');
        $(option).attr({value: ''});
        $(option).append('Escolha');
        $("select[name='" + el + "']").append(option);
    }
    $(function() {

        $("select[name=estado]").change(function() {

            estado = $(this).val();

            if (estado === '')
                return false;

            resetaCombo('cidade');
            $.getJSON('<?php echo base_url('curriculo/getCidades'); ?>' +'/'+ estado, function(data) {

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

    (function($) {
        $.fn.extend({
            limiter: function(limit, elem) {
                $(this).on("keyup focus", function() {
                    setCount(this, elem);
                });
                function setCount(src, elem) {
                    var chars = src.value.length;
                    if (chars > limit) {
                        src.value = src.value.substr(0, limit);
                        chars = limit;
                    }
                    elem.html(limit - chars);
                }
                setCount($(this)[0], elem);
            }
        });
    })(jQuery);
    
    var elem = $("#chars");
    $("#objetivo").limiter(300, elem);
    $("#empresa1_responsabilidades").limiter(300, elem);
    $("#empresa2_responsabilidades").limiter(300, elem);
    $("#outras_informacoes").limiter(300, elem);
</script>
<?php
echo "</head>";
echo "<body>";
