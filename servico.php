<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/atualiza_cargo_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/alert_functions.php');

function url_exists($url) {
    // Version 4.x supported
    $handle = curl_init($url);
    if (false === $handle) {
        return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);
    return $connectable;
}

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado
//verifica se está logado
//check_loggedin();

if (session_id() == '') {
    session_start();
}


if (isset($_SESSION['userid'])) {
    session_refresh();

    atualiza_cargo(); //verifica se cargo do usuário está atualizado. Se não estiver, redireciona-o para atualizar!
}
//o HEAD dessa página é diferente... cuidado
$display_main->head('@import url(\'css/anuncio_interno.css\');@import url(\'css/botoes.css\');', '');
$display_main->topo();
?>
<!--JAVASCRIPT SDK - FACEBOOK -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=457411647692763";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php
//no caso do painel a esquerda, vamos verificar. Se estiver logado, mostra versão original. Se não, vai mostrar o painel do visitante.
//veja scripts internos
$display_main->painel_esquerda();
if (isset($_GET['id'])) {//se tem script nos passando parametro por GET ID é porque quer mostrar dados do anúncio
//primeiro, vamos nos conectar à base de dados para capturar informações
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");

//prepara variável
    @$servico_id = mysqli_secure_query($_GET['id']);

//seleciona dados necessáriso
    $qry = "SELECT free.free_codigo,"
            . "free.fk_freecargo_id,"
            . "free.usu_codigo,"
            . "free.free_descricao,"
            . "free.free_turno,"
            . "free.free_preco,"
            . "free.free_pos_preco,"
            . "free.free_tipo_trabalhador,"
            . "free.free_tel1,"
            . "free.free_tel2,"
            . "free.free_email,"
            . "free.free_dt_cadastro,"
            . "free.free_ativo,"
            . "usu.cid_codigo,"
            . "usu.usu_nome,"
            . "usu.usu_foto_perfil,"
            . "usu.usu_foto_curriculo,"
            . "usu.tipo_conta,"
            . "cid.nome,"
            . "est.nome,"
            . "est.sigla,"
            . "free.free_vip "
            . "FROM freelancer free, usuario usu, cidades cid, estados est WHERE free.usu_codigo = usu.usu_codigo AND usu.cid_codigo = cid.cod_cidades AND cid.estados_cod_estados = est.cod_estados AND free.free_codigo = ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $servico_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($free_codigo, $fk_freecargo_id, $usu_codigo, $free_descricao, $free_turno, $free_preco, $free_pos_preco, $free_tipo_trabalhador, $free_tel1, $free_tel2, $free_email, $free_dt_cadastro, $free_ativo, $cid_codigo, $usu_nome, $usu_foto_perfil, $usu_foto_curriculo, $tipo_conta, $cidade, $estado, $sigla, $free_vip);

    require_once('funcoes/string_functions.php');

    $tem_resultado = false;

    while ($stmt->fetch()) {//se tiver resultado
        $tem_resultado = true;
        $qry = "SELECT cargo.descricao,cat.descricao FROM freelancer_cargo cargo, freelancer_categoria cat WHERE cat.id = cargo.fk_freecategoria_id AND cargo.id = ?";
        $stmt2 = $mysqli->prepare($qry);
        $stmt2->bind_param('i', $fk_freecargo_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($r_cargo, $r_categoria);
        while ($stmt2->fetch()) {
            
        }
        $stmt2->close();


//--------------- END BANNER LOGIN-------------------//
//CÓDIGO DO FACEBOOk
        echo '
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=392928604125411";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';


        $page_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $facebook_code = '<div class="fb-like" data-href="' . $page_url . '/servico.php?id=' . $free_codigo . '" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>'; //código padrão, se nao encontrar estado específico para mostrar fan page


        switch ($sigla) {//vamos analisar o nome do estado e mostrar fan page do estado de acordo
            case 'ES':
                $facebook_code = '<div class="fb-like" data-href="http://www.facebook.com/empreguemeoficial" data-width="400" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>'; //fan page do ES
                break;
            case 'SP'://fan page sp
                $facebook_code = '<div class="fb-like" data-href="http://www.facebook.com/empreguemesp" data-width="400" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>'; //fan page do SP
                break;
        }



        $sistema_viral = '<div id="like_box">' . $facebook_code . '<br /><br />
<div class="fb-comments" data-href="' . $page_url . '/servico.php?id=' . $free_codigo . '" data-numposts="10" data-colorscheme="light"></div>

</div>';

        //nome do candidato
        $nome = explode(" ", $usu_nome);
        //ajusta data
        $data_hora = explode(" ", $free_dt_cadastro);
        $data = explode('-', $data_hora[0]);
        $data_ajustada = $data[2] . "/" . $data[1] . "/" . $data[0];
        //foto do prestador
        $local_foto_real = "../upload/gfx/perfil/usu_" . $usu_codigo . ".jpeg";
        $usu_foto = '<img src="' . $local_foto_real . '" class="vaga_logo_img" width="150" height="150" />'; //se user tiver foto cadastrada, deixa como cadastrada...
        //preco servico
        if ($free_preco == 0.00) {
            $free_preco = "Á combinar";
        } else {
            $free_preco = "R$ " . $free_preco . ' ' . $free_pos_preco;
        }
        //turno
        if ($free_turno == "Geral") {
            $free_turno = "Matutino, Vespertino e Noturno";
        }
        if (!file_exists($local_foto_real)) {//troca foto para foto de usuario anonimo, se nao tiver foto cadastrada
            $usu_foto = '<img src="gfx/ui/sem_foto.png" class="vaga_logo_img" />';
        }

        if ($free_tel2 != "") {
            $telefone = $free_tel1 . "/" . $free_tel2;
        } else {
            $telefone = $free_tel1;
        }

        $contato = "<h3>E-mail: " . $free_email . "<br /> Telefone: " . $telefone . "</h3>";

        if ($tipo_conta == 0) {
            $conta = '<div id="anuncio_vip">
    <div id="anuncio_vip_titulo">Consiga um emprego rápido</div>
    <div id="anuncio_vip_info">
			 Crie já sua <strong>conta VIP</strong> exclusiva e aumente suas chances de conseguir um emprego em 17x!
			 <br />
<br />

			 <a href="membro_vip.php" style="margin-left:0%;" class="botao_cta">Criar conta VIP</a>
			 
			  
			  </div>

	</div>
	</div>';
        } else {
            $conta = '';
        }

        $display_main->conteudo('
<div class="anuncio_nome">' . ($r_cargo) . '</div>
	<div id="anuncio_cat"><a href="busca_freelancer.php" target="_self">Principal</a> > ' . ($r_categoria) . '</div>

<div class="anuncio_info">
				<strong>Serviço: </strong> ' . $r_categoria . ' - ' . $r_cargo . '<br />
				<strong>Preço do serviço: </strong>' . $free_preco . '<br />
                                <strong>Turno: </strong> ' . $free_turno . '<br />
				<strong>Descrição: </strong> ' . $free_descricao . '<br />'
                . '<div id="candidatar_box"><center>' . $contato . '</center></div>' . $sistema_viral . ' 
   
   
   
    <div id="anuncio_vendedor">
    <div id="anuncio_vendedor_titulo">Informações do anunciante</div>
    <div id="anuncio_vendedor_info">
                           <strong>Nome:</strong><span class="link">' . $usu_nome . '</span><br />
			  <strong>Prestador:</strong>' . $free_tipo_trabalhador . '<br />
			  <strong>Localização: </strong> ' . $cidade . ', ' . $sigla . '<br /><br />
			  <div id="map-canvas">' . $usu_foto . '</div>

	</div>
	</div>
' . $conta . '
</div>




');
    }

    if ($tem_resultado == false) {
//se por algum motivo nao achar o produto, mostra pagina de error e encerra carregamento de dados
        $display_main->show_system_message('Serviço não encontrado!', 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }

//Veja que os links passam parametros por GET, para mostrar os seus respectivos banners
    $display_main->painel_direita();
    $display_main->fundo();
} else {
    $display_main->show_system_message('Serviço não encontrado', 'error');
    $display_main->painel_direita();
    $display_main->fundo();
    exit;
}
?>


