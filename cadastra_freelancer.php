<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/funcoes_estruturais.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}

$display_main->head("", "
<!-- Gerenciador Ajax - Select Categoria / Cargo-->
 <script type='text/javascript' src='js/categoria_cargo_load.js'></script>
     
<!--SCRIPT PARA GERENCIAR SALARIO-->
<script type='text/javascript' src='js/jquery.price_format.min.js'></script>
<script type='text/javascript'>
    $(document).ready(function(e) {
        $('#preco').priceFormat({
            prefix: 'R$ ',
            centsSeparator: '.',
            thousandsSeparator: '',
            clearPrefix: true
        });
    });
</script>
");

$display_main->topo();
$display_main->painel_esquerda();

//O CÓDIGO ABAIXO SERVE PARA MOSTRAR MENSAGENS DE ALTERAÇÕES!
if (isset($_GET['show_message'])) {//mostra a mensagem de alteração
    switch ($_GET['tipo']) {//verifica o tipo da mensagem
        case 'sucesso'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'sucesso');
            break;
        case 'error'://se for de sucesso...
            $display_main->show_system_message($_GET['show_message'], 'error');
            break;
    }
}

$data = explode(' ', $_SESSION['nome']);
$primeiro_nome = ucwords($data[0]);

/* if (isset($_SESSION['membro_vip_ativo'])) {

  if ($_SESSION['membro_vip_ativo'] == 0) {//se não é vip
  $convite_vip = '<a href="membro_vip.php" target="_self">' . $primeiro_nome . ', você ainda não faz parte de nossa exclusiva comunidade Membro VIP Empregue-me. <strong>Clique aqui para criar sua conta VIP!</strong></a>';
  } else {
  $convite_vip = '';
  }
  } */

if (isset($_POST['free_ativo']) && $_POST['free_ativo'] == 1) {
    @$cargo = mysqli_secure_query($_POST['cargo']);
    @$usu_codigo = $_SESSION['userid'];
    @$descricao = mysqli_secure_query($_POST['descricao']);
    @$turno = mysqli_secure_query($_POST['turno']);
    @$preco = mysqli_secure_query($_POST['preco']);
    @$pos_preco = mysqli_secure_query($_POST['pos_preco']);
    @$tipo_prestador = mysqli_secure_query($_POST['tipo_prestador']);
    @$tel = mysqli_secure_query($_POST['tel']);
    @$tel1 = mysqli_secure_query($_POST['tel1']);
    @$email = mysqli_secure_query($_POST['email']);
    if (checa_vazio(array($cargo, $descricao, $turno, $preco, $tipo_prestador, $tel, $email), array('Cargo', 'Descrição', 'Turno', 'Tipo de Prestador', 'Telefone (1°)', 'E-mail'))) {
        $display_main->show_system_message('Não foi possível cadastrar pois os seguintes campos encontram-se vazios: ' . $resultados_vazios, 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    } else {
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, "utf8");
        //verifica se ja tem um servico duplicado
        $qry = "SELECT * FROM freelancer WHERE fk_freecargo_id = ? and usu_codigo = ? and free_ativo = 1";
        $stmt = $mysqli->prepare($qry);
        $stmt->bind_param('ii', $cargo, $usu_codigo);
        $stmt->execute();
        $tem_resultado = false;
        while ($stmt->fetch()) {
            $tem_resultado = true;
        }
        $stmt->close();
        if ($tem_resultado == false) { //pode cadastrar novo servico

            /*
             * verifica se usuario é membro vip para salvar na flag
             */
            $qry = "SELECT * FROM membro_vip where fk_usu_codigo = ? and fk_stat_codigo = 1";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('i', $usu_codigo);
            $stmt->execute();
            $free_vip = 0;
            while ($stmt->fetch()) {
                $free_vip = 1;
            }
            $stmt->close();

            $qry = "INSERT INTO freelancer VALUES (NULL,?,?,?,?,?,?,?,?,?,?,NULL,1,?)";
            $stmt = $mysqli->prepare($qry);
            $stmt->bind_param('iissssssssi', $cargo, $usu_codigo, $descricao, $turno, $preco, $pos_preco, $tipo_prestador, $tel, $tel1, $email, $free_vip);
            $stmt->execute();
            $stmt->close();
            $display_main->show_system_message('Serviço cadastrado com sucesso! Você será redirecionado para sua página pessoal de serviços cadastrados', 'sucesso');
            $display_main->painel_direita();
            $display_main->fundo();
        }
        if ($tem_resultado == true) {
            $display_main->show_system_message('Você já cadastrou esse serviço. Para cadastrar um novo serviço <a href=\cadastra_freelancer.php\>clique aqui</a>', 'error');
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }

        echo '  <script type="text/javascript"> '
        . '$(document).ready(function(e) {  '
        . 'setTimeout(\'document.location.href="meus_servicos.php"\', 4000) '
        . '});'
        . '</script>';

        exit;
    }
} else {
    $categoria = '<option value="">Selecione uma opção</option>';
    $mysqli = mysqli_full_connection();
    $mysqli->set_charset('utf8');
    $qry = "SELECT id,descricao FROM freelancer_categoria  ORDER BY descricao";

    $stmt = $mysqli->prepare($qry);
    $stmt->execute();

    $stmt->store_result();
    $stmt->bind_result($r_categoria_id, $r_categoria_descricao);

    while ($stmt->fetch()) {
        $categoria .= '<option value="' . $r_categoria_id . '">' . $r_categoria_descricao . '</option>';
    }
    $stmt->close();

    $display_main->conteudo('<h1>Cadastro de Prestador de Serviços</h1><p>' . $primeiro_nome . ', se você deseja divulgar seus serviços prestados, realize o cadastro abaixo.</p>');
    ?>
    <form action="" method="post">
        <ul>
            <li>Categoria: <select name="categoria" id="categoria"><?php echo $categoria; ?></select><span class="campo_obrigatorio">* Campo obrigatório</span></li>
            <li>Serviço: <select name="cargo" id="cargo"><option value="">Selecione uma categoria primeiro</option></select><span class="campo_obrigatorio">* Campo obrigatório</span></li>
            <li>Descrição: <textarea name="descricao" placeholder="Faça um breve resumo de sua experiência nesse tipo de serviço escolhido acima. Máximo de 300 caracteres." style="width:400; height:200;" maxlength="300" rows="4" cols="100"></textarea> <span class="campo_obrigatorio"><br />* Campo obrigatório</span></li>
            <li>Turno: <select name="turno">
                    <option value="">Selecione um turno</option>
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                    <option value="Noturno">Noturno</option>
                    <option value="Noturno">Matutino e Vespertino</option>
                    <option value="Noturno">Vespertino e Noturno</option>
                    <option value="Geral">Todos os Turnos</option>
                </select>
                <span class="campo_obrigatorio">* Campo obrigatório</span>   
            </li>
            <li>Preço pelo serviço: <input type="text" name="preco" id="preco"/>
                <select name="pos_preco">
                    <option value='por serviço realizado'>por serviço realizado</option>
                    <option value='por hora'>por hora</option>
                    <option value='por dia'>por dia</option>
                    <option value='por semana'>por semana</option>                
                </select>
                <span class="campo_obrigatorio">* Campo obrigatório</span>
            </li>
            <li>Tipo de Prestador de Serviço: 
                <select name="tipo_prestador">
                    <option>Pessoa Física</option>
                    <option>Pessoa Jurídica</option>
                </select>
                <span class="campo_obrigatorio">* Campo obrigatório</span>   
            </li>
            <li>Telefone de contato 1°: <input type="tel" name="tel" /><span class="campo_obrigatorio">* Campo obrigatório</span></li>
            <li>Telefone de contato 2°: <input type="tel" name="tel1" /></li>
            <li>E-mail: <input type="text" name="email" /><span class="campo_obrigatorio">* Campo obrigatório</span></li>
            <li><input type="submit" value="Cadastrar serviço"/></li>        
            <input type="hidden" value="1" name="free_ativo" />
        </ul>            
    </form>
<?php } ?>

<?php
$display_main->painel_direita();
$display_main->fundo();
?>


