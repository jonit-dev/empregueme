<?php
//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/check_valid_functions.php');
require_once('funcoes/url_functions.php');



$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}

$display_main->head();

?>
<!--CÓDIGO PRA SOMENTE PERMITIR NUMEROS NO INPUT-->
<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<?php
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

//dump_network();


if ($_SESSION['cidade_id'] == "") {//se nao tem nada para carregar na cidade
    $r_estado_nome = "Não informado";
    $r_cidade_nome = "Não informado";
	
	//vamos carregar os estados
	 $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
	$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
	$stmt = $mysqli->prepare($qry);
	
	$stmt->execute();
	$stmt->bind_result($r_sigla,$r_cod_est);
	
	$estados = '';
	while($stmt->fetch())
		{
			$estados .= '<option value="'.$r_cod_est.'">'.$r_sigla.'</option>';
		}
	
	
	
} else {//agora, se usuário tem dados de cidade... vamos carregá-los
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "SELECT cid.nome,est.nome, est.cod_estados FROM usuario as usu,cidades as cid, estados as est WHERE 
usu.usu_codigo = ? AND
cid.cod_cidades = usu.cid_codigo AND
cid.estados_cod_estados = est.cod_estados";
    $stmt = $mysqli->prepare($qry);
    $usu_codigo = $_SESSION['userid'];
    $stmt->bind_param('i', $usu_codigo);
    $stmt->execute();
    $stmt->bind_result($cid_nome, $estado_nome,$estado_id);

    $tem_resultado = false;
    while ($stmt->fetch()) {
        $r_cidade_nome = $cid_nome;
        $r_estado_nome = $estado_nome;
    }

//vamos carregar os estados
	$stmt->close();
	$qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
	$stmt = $mysqli->prepare($qry);
	
	$stmt->execute();
	$stmt->bind_result($r_sigla,$r_cod_est);
	
	$estados = '';
	while($stmt->fetch())
		{
			$estados .= '<option value="'.$r_cod_est.'">'.$r_sigla.'</option>';
		}



}//end se tem dados da cidade
	

if(isset($_SESSION['cidade_id']))//Se tem a variável de sessão da cidade é porque tem registrada, então vamos carregar o resto.
	{
		$inputs_cidade_estado = '<input type="hidden" id="user_estado" value="' . $_SESSION['estado_id'] . '"/>
	<input type="hidden" id="user_cidade" value="' . $_SESSION['cidade_id'] . '"/>';	
	}
	else//se nao, joga o valor dos inputs escondidos para zero (eles são utilizados junto aos scripts js)
	{
		$inputs_cidade_estado = '<input type="hidden" id="user_estado" value="0"/>
	<input type="hidden" id="user_cidade" value="0"/>';	
		
	}

echo "<h2>Meus dados</h2>";
echo
'<p><strong>Nome: </strong> ' . $_SESSION['nome'] . '</br>
	<strong>Nickname: </strong>' . $_SESSION['nickname'] . '</br>
	<strong>Estado: </strong> <em id="texto_estado">' . $r_estado_nome . '</em> - <strong>Alterar para:</strong> <select name="estado" id="estado" >
    	<option name="">Selecione seu estado...</option>
	'.$estados.'
        </select></br>
    <strong>Cidade: </strong>  <em id="texto_cidade">' . $r_cidade_nome . '</em> - <strong>Alterar para:</strong> <select name="cidade" id="cidade" ><option value="">Selecione seu estado primeiro...</option></select><br />
    <strong>CEP:</strong><input type="text" name="CEP" value="' . $_SESSION['usu_cep'] . '" maxlenght = "8" placeholder="Somente números" maxlength="8" onkeypress="return isNumber(event)"/></br>
    <strong>Foto: </strong><img width = 16 height = 16 src="../upload/gfx/perfil/' . $_SESSION['usu_foto_perfil'] . '"/> - <a href="edit_profile.php?alterar_foto=true" target="_self" class="texto_vermelho">[ Alterar Foto ]</a><br />
	<input type="hidden" id="userid" value="' . $_SESSION['userid'] . '"/>
	'.$inputs_cidade_estado.'
	<input type="button" class="input_submit" value="Salvar dados" id="salvar_dados"/></p>
	';
?>

<script type="text/javascript" src="js/estado_cidade_load.js"></script>

<!--SALVANDO DADOS DO FORMULARIO-->
<script type="text/javascript">
    $(document).ready(function(e) {


        //salvando dados
        $("#salvar_dados").click(function() {

            //capta variáveis
            //var estado = $("#estado option:selected").val();
            var cidade = $("#cidade option:selected").val();
            //var telefone = $("input[name=telefone]").val();
            //var ddd = $("input[name=ddd]").val();
            var CEP = $("input[name=CEP]").val();
            //var endereco = $("input[name=endereco]").val();
            //var bairro = $("input[name=bairro]").val();
            //var n_residencial = $("input[name=n_residencial]").val();
            var userid = $("#userid").val();
            //inicia requisição ajax
            $.post('ajax/update_user_info.php',
                    {
                        cidade: cidade,
                        userid: userid,
                        CEP:CEP
                    }, function(callback)
            {
                //maneja resposta
                //alert(callback);

                switch (callback)
                {
                    case 'sucesso':
                        mostra_mensagem("Alterações realizadas com sucesso!", "sucesso");
                        $('#texto_estado').text($("#estado option:selected").text());
                        $('#texto_cidade').text($("#cidade option:selected").text());

                        setTimeout('document.location.href="edit_profile.php?refresh=true";', 2000);

                        break;
                    case 'nao_alterou':
                        mostra_mensagem("Não foi possível realizar alterações. Provavelmente os dados alterados são os mesmos já presentes no perfil do usuário.", "error");
                        break;
                    case 'erro:estadocidade':
                        mostra_mensagem("Você precisa alterar seu estado ou cidade para algum valor, antes de modificá-los.", "error");


                        break;

                }
                var val = callback;
                if (val.indexOf('vazios', val) != -1)
                {
                    mostra_mensagem(callback, "error");

                }



            });


        });//end salvar dados click	





    });//end ready

</script>     


<?php
//================= ALTERANDO FOTO DE USUARIO
if (isset($_GET['alterar_foto'])) {
    $display_main->show_banner('Altere sua foto', '
		
		<p>Selecione sua foto abaixo e depois clique no botão enviar:</p>
		<form action="edit_profile.php" method="post" enctype="multipart/form-data">
		
		    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<ul>
			<li>Procurar foto: <input type="file" name="usuario_foto" />
			</li>
		</ul>
		<input type="submit" value="Enviar nova foto"/>
		</form>
		
		
		
		', 'small');
}

//============ UPLOAD DE FOTO -- validação


if (isset($_POST['MAX_FILE_SIZE'])) {

    $file_temp_path = $_FILES['usuario_foto']['tmp_name'];
    $file_name = $_FILES['usuario_foto']['name'];
    $file_size = $_FILES['usuario_foto']['size'];
    $file_type = $_FILES['usuario_foto']['type'];
    $file_error = $_FILES['usuario_foto']['error'];


//ERROR HANDLING
    if ($file_error > 0) {//se existe algum erro
        switch ($file_error) {
            case 1:
                $display_main->show_system_message("O tamanho da foto excede o limite máximo de upload do servidor.", 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;

                break;

            case 2:
                $display_main->show_system_message("O tamanho da foto enviada excede 1MB. Por favor, tente novamente com uma foto menor.", 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;

                break;

            case 3:
                $display_main->show_system_message("A foto foi enviada parcialmente. Por favor, tente novamente.", 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;

                break;

            case 4:
                $display_main->show_system_message("Você esqueceu de enviar a foto do anúncio. Por favor, tente novamente.", 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;

                break;
        }//end switch
        exit; //para execução do script
    }//end if

    $allowed_types = array("image/jpeg", "image/png", "image/bmp");

    $arquivo_permitido = false;
    for ($i = 0; $i < count($allowed_types); $i++) {//faz um loop pela array de arquivo permitidos, verificando se o arquivo enviado pelo usuário é permitido
        if ($file_type == $allowed_types[$i]) {//se for, altere a variável
            $arquivo_permitido = true;
        }
    }


    if ($arquivo_permitido === false) {//se o tipo de arquivo não é permitido
        $display_main->show_system_message("ERROR:O arquivo enviado não é do tipo .jpeg, .png ou .bmp", 'error');
        //vamos mostrar o final do site, para não bugar
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }
//vamos verificar o tamanho da foto

    require_once('classes/SimpleImage.php');
    $image = new SimpleImage();
    $image->load($file_temp_path);
//essa variável armazena aonde iremos salvar o arquivo de foto
//pega tamanho da foto e verifica se o tamanho está adequado!
    $image_height = $image->getHeight();
    $image_width = $image->getWidth();

//o tamanho mínimo é 75x75.. menos que isso não tem como aceitar!
    if ($image_height < 75 && $image_width < 75) {
        $display_main->show_system_message("ERROR: A sua foto deve ter um tamanho maior que 75x75 pixels", 'error');
        //vamos mostrar o final do site, para não bugar
        $display_main->painel_direita();
        $display_main->fundo();
    }

//------------------ TERMINA VALIDAÇÃO
//SALVA FOTO DO USUÁRIO
//insere local para armazenamento
//vamos criar uma pasta com a ID do usuário (nao podemos usar o nome dele aqui porque isso pode comprometer a criação da pasta!)
    /*
      $nome_usuario = $_SESSION['userid'];
      if (!is_dir("../upload/gfx/perfil/" . $nome_usuario)) {//se usuário ainda não tem diretório criado, vamos criá-lo
      if (!mkdir("../upload/gfx/perfil/" . $nome_usuario)) {

      $display_main->show_system_message("Não foi possível criar pasta para armazenar dados do usuário", 'error');
      //vamos mostrar o final do site, para não bugar
      $display_main->painel_direita();
      $display_main->fundo();
      }
      }


      if (@!mkdir("../upload/gfx/perfil/" . $nome_usuario . "/perfil_fotos")) {//vamos criar o diretório para armazenar os arquivos associados ao anúncio
      $display_main->show_system_message("Não foi possível criar pasta para armazenar dados do anúncio do usuário", 'error');
      //vamos mostrar o final do site, para não bugar
      $display_main->painel_direita();
      $display_main->fundo();
      }
     *
     * 
     */
//essa variável armazena aonde iremos salvar o arquivo de foto
    $file_path = "../upload/gfx/perfil/";
    $data = explode('/', $file_type);
    $file_extension = $data[1]; //pegamos a extensão do arquivo
//Agora vamos manejar o arquivo enviado
    if (is_uploaded_file($file_temp_path)) {//se arquivo temporário já chegou é porque o upload já foi concluido
        $uploaded_file = $file_path . "usu_" . $usu_codigo . "." . $file_extension;
        if (!move_uploaded_file($file_temp_path, $uploaded_file)) {//se nao conseguir mover
            $display_main->show_system_message("Error: Não foi possível mover o arquivo ao diretório de destino", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }
        $mysqli = mysqli_full_connection();
        mysqli_set_charset($mysqli, 'UTF-8');
        $qry = "UPDATE usuario SET usu_foto_perfil = ? WHERE usu_codigo = ?";
        $stmt = $mysqli->prepare($qry);
        $foto_usuario = "usu_" . $usu_codigo . "." . $file_extension;
        $stmt->bind_param('si', $foto_usuario, $usu_codigo);
        $stmt->execute();
		
		//redimensiona a foto original do usuário em 150x150 pixels
		 $image->load($uploaded_file);
  		  $image->resize(150, 150);
   		 $image->save($uploaded_file);

		
		
    } else {//se o arquivo temporário não existe... é possível que seja um ataque em arquivo de upload
        $display_main->show_system_message("Error: Possível ataque de upload. Abortando! - Nome do arquivo: " . $file_name, 'error');
        //vamos mostrar o final do site, para não bugar
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }

//--photo resize (vamos alterar o tamanho do arquivo
//tamanho da foto
    //gerando versão thumbnail ==> para comentários!
    $image->load($uploaded_file);
    $image->resize(32, 32);
    $image->save($file_path . "comentario_" . "$usu_codigo." . $file_extension);


//se chegou até aqui é porque salvou tudo direitinho...
    $display_main->show_system_message("Foto salva com sucesso!", 'sucesso');
    //vamos mostrar o final do site, para não bugar

    session_refresh();
    clearstatcache();
    //redireciona('main.php');
}//end post foto
//=========END FOTO 


$display_main->painel_direita();
$display_main->fundo();
?>


