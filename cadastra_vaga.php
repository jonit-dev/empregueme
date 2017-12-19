<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/array_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/url_functions.php');
require_once('funcoes/top_functions.php');

$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//update session vars
//session_start();
check_loggedin(); //check if user is logged in!
//if (isset($_GET['refresh'])) {//atualiza variáveis na sessão, após modificarmos a bd
session_refresh();
//}
?>

<?php


$display_main->head('','<!--CÓDIGO PRA SOMENTE PERMITIR SOMENTE NUMEROS NO INPUT-->
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

<!--carrega plugin jquery para manejo do input preço-->
<script type="text/javascript" src="plugins_jquery/numero/autoNumeric.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $(\'.preco\').autoNumeric(\'init\');
    });//end ready
</script>');

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

            $qtd_vaga = "";
//gera opções para a vaga
            for ($i = 1; $i < 101; $i++) {
                $qtd_vaga .= '<option name="vaga_quantidade" value="' . $i . '">' . $i . '</option>';
            }

            //vamos carregar os estados de nossa base de dados
            $mysqli = mysqli_full_connection();
            $qry = "SELECT est.sigla, est.cod_estados FROM estados as est";
            $stmt = $mysqli->prepare($qry);

            $stmt->execute();
            $stmt->bind_result($r_sigla, $r_cod_est);

            $estados = '';
            while ($stmt->fetch()) {
                $estados .= '<option value="' . $r_cod_est . '">' . $r_sigla . '</option>';
            }

			$stmt->close();
			
			//carrega categorias
			//COMEÇA CARREGAMENTO DE OPÇÕES CATEGORIAS 
	$categorias = '';

	$qry = "SELECT cat_codigo, cat_nome FROM categoria";

	$stmt = $mysqli->prepare($qry);
	$stmt->execute();

$stmt->bind_result($r_cat_codigo,$cat_nome);

while($stmt->fetch())
	{
		$categorias .= '<option name="categoria" value="'.$r_cat_codigo.'" />'.utf8_encode($cat_nome).'</option>';
	}

			



$display_main->conteudo('<h1>Cadastre sua vaga abaixo</h1>

<p>Preencha o formulário abaixo para cadastrar sua vaga em nosso sistema. Lembre-se que <strong>os currículos serão enviados para o e-mail informado abaixo!</strong></p>

			
			<form action="cadastra_vaga.php" enctype="multipart/form-data" method="post">
			
			<ul>
				<li>Nome do cargo:
					<input type="text" name="vaga_nome" placeholder="Restam 38 caracteres..." maxlength="38" class="long_text"/><span class="campo_obrigatorio">* Campo obrigatório</span>
					</li>
					<li>Tipo contratação:
						<select name="vaga_tipo">
							<option value="CLT">CLT</option>
							<option value="Temporário">Temporário</option>
							<option value="Freelancer">Freelancer</option>
						</select>
					</li>
					
					<li>Empresa:
					<input type="text" name="vaga_empresa" placeholder="Empresa anunciante" maxlength="38" /></li>	
						
					
					<li>Estado: <select name="estado" id="estado" >
    	<option value="">Selecione seu estado...</option>
	' . $estados . '
	
		 			 </select><span class="campo_obrigatorio">  * Campo obrigatório</span></li>
		<li> Cidade: <select name="cidade" id="cidade" >
    	<option value="">Selecione seu estado primeiro...</option>
    </select><span class="campo_obrigatorio">  * Campo obrigatório</span></li>
					
														
				<li>Categoria:
						  <select name="categoria" id="categoria"><span class="campo_obrigatorio">* Campo obrigatório</span>
							<option value="">Selecione a categoria...</option>
									' . $categorias. '
						  </select><span class="campo_obrigatorio">  * Campo obrigatório</span>
						</li>
						
					
				<li>Foto da logomarca da empresa:
						 <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						 <input type="file" name="vaga_logomarca"/><span class="campo_obrigatorio" style="color:silver;">* Tamanho máximo: 1Mb - Formato:.jpeg, .bmp, .png</span>
						 
						 
						</li>		
						
						<li>E-mail:
						 <input type="email" name="vaga_email" placeholder="E-mail que receberá os currículos" class="long_text"/><span class="campo_obrigatorio">* Campo obrigatório </span>
						 
						 
						</li>		
						<li>Telefone:
						 <input type="tel" name="vaga_telefone" placeholder="Telefone da empresa" maxlength="13" />
						 
						</li>						
					
					<li>Descrição<span class="campo_obrigatorio">  * Campo obrigatório</span><br />

			<textarea name = "vaga_descricao" cols="50" rows="4" spellcheck="true" maxlength="600" placeholder="Digite aqui a descrição de sua vaga (máximo de 600 caracteres)"></textarea>
							</li>	
							
					<li>
						Quantidade de vagas:<select name="vaga_quantidade" value="1">
							' . $qtd_vaga . '
						</select>
							
					</li>		
							
							
						<li>Salário: 

				<input type="text" name="vaga_salario" class="preco" data-a-sep="." data-a-dec="," data-a-sign="R$ "/><span class="campo_obrigatorio">* Se não quiser informar, deixe em branco</span>
							</li>	
							
						<li>Site da empresa: 

				<input type="text" name="vaga_site" placeholder="Opcional"/>
							</li>		
								
			
			</ul>
			
			<center>
			<input type="submit" class="botao_cta" value="Cadastrar vaga" class="disable_submit"/>
			</center>
			
			</form>
			');


//-------------------> INSERÇÃO DE NOVAS VAGAS NO SISTEMA ------------------------------//

if (isset($_POST['vaga_nome'])) {//se usuário postou nova vaga
    //primeiro captura variáveis e faz sua segurança
    @ $vaga_nome = mysqli_secure_query($_POST['vaga_nome']);
    @ $vaga_tipo = mysqli_secure_query($_POST['vaga_tipo']);
    @ $vaga_empresa = mysqli_secure_query($_POST['vaga_empresa']);
    @ $vaga_estado = mysqli_secure_query($_POST['estado']);
    @ $vaga_cidade = mysqli_secure_query($_POST['cidade']);
    @ $vaga_categoria = mysqli_secure_query($_POST['categoria']);
    @ $vaga_logomarca = mysqli_secure_query($_POST['vaga_logomarca']);
    @ $vaga_email = mysqli_secure_query($_POST['vaga_email']);
    @ $vaga_descricao = mysqli_secure_query($_POST['vaga_descricao']);
    @ $vaga_quantidade = mysqli_secure_query($_POST['vaga_quantidade']);
    @ $vaga_salario = mysqli_secure_query($_POST['vaga_salario']);
    @ $vaga_telefone = mysqli_secure_query($_POST['vaga_telefone']);
    @ $vaga_link = mysqli_secure_query($_POST['vaga_site']);
    @ $vaga_tag = "";

    //inicia validação de dados
    //somente verifica se está vazio os campos obrigatórios... o restante nao precisa
    if (checa_vazio(array($vaga_nome, $vaga_tipo, $vaga_estado, $vaga_cidade, $vaga_categoria, $vaga_email, $vaga_descricao, $vaga_quantidade), array('Nome', 'Tipo', 'Estado', 'Cidade', 'Categoria', 'E-mail', 'Descrição', 'Quantidade'))) {
        $display_main->show_system_message('Não foi possível inserir a vaga pois os seguintes campos encontram-se vazios: ' . $resultados_vazios, 'error');
        $display_main->painel_direita();
        $display_main->fundo();

        exit;
    }

    //valida estado e cidade
    if ($vaga_estado == "" || $vaga_cidade == "") {
        $display_main->show_system_message('Não foi possível inserir a vaga pois você esqueceu de especificar o estado ou a cidade', 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }
    //valida categoria
    if ($vaga_categoria == "") {
        $display_main->show_system_message('Não foi possível inserir a vaga pois você esqueceu de especificar a categoria', 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }
    //validação de email
    require_once('funcoes/email_functions.php');
    if (!check_email_address($vaga_email)) {//se retornou false na verificação é porque o email está em formato inválido
        $display_main->show_system_message('Não foi possível inserir a vaga pois o e-mail é inválido', 'error');
        $display_main->painel_direita();
        $display_main->fundo();
        exit;
    }


    //validação de upload de logomarca
    //inicia validação de upload
//---------------Upload da foto
//a pasta de UPLOAD DEVE FICAR FORA DO DIRETORIO PRINCIPAL DO SITE, como medida de segurança

    $tem_foto = false;
    if (($_FILES['vaga_logomarca']['size']) > 0) {//se o tamanho da foto é maior que zero, é pq tem foto!
        $tem_foto = true;
    }


    if ($tem_foto == true) {//se o usuário tentou enviar logomarca da empresa... vamos prosseguir com validação
        $file_temp_path = $_FILES['vaga_logomarca']['tmp_name'];
        $file_name = $_FILES['vaga_logomarca']['name'];
        $file_size = $_FILES['vaga_logomarca']['size'];
        $file_type = $_FILES['vaga_logomarca']['type'];
        $file_error = $_FILES['vaga_logomarca']['error'];


//Validação upload foto
        if ($file_error > 0) {//se existe algum erro
            switch ($file_error) {
                case 1:
                    $display_main->show_system_message("O tamanho da logomarca excede o limite máximo de upload do servidor.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 2:
                    $display_main->show_system_message("O tamanho da logomarca enviada excede 1MB. Por favor, tente novamente com uma foto menor.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 3:
                    $display_main->show_system_message("A logomarca foi enviada parcialmente. Por favor, tente novamente.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;

                case 4:
                    $display_main->show_system_message("Você esqueceu de enviar a foto da logomarca. Por favor, tente novamente.", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                    break;
            }//end switch
            exit; //para execução do script
        }//end if	
//continua validação da foto...
//verifica tipos permitidos
        $allowed_types = array("image/jpeg", "image/png", "image/bmp");

        $arquivo_permitido = false;
        for ($i = 0; $i < count($allowed_types); $i++) {//faz um loop pela array de arquivo permitidos, verificando se o arquivo enviado pelo usuário é permitido
            if ($file_type == $allowed_types[$i]) {//se for, altere a variável
                $arquivo_permitido = true;
            }
        }


        if ($arquivo_permitido === false) {//se o tipo de arquivo não é permitido
            $display_main->show_system_message("ERROR: A imagem da logomarca enviada não é do tipo .jpeg, .png ou .bmp", 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }

//tem que verificar os tipos permitidos antes de verificar o tamanho da foto! Se não da erro no simple image, porque ele poderá tentar analisar algo que não seja imagem (ex. arquivo de txt) e irá dar erro!

//Verifica tamanho da foto enviada
        require_once('classes/SimpleImage.php');
        $image = new SimpleImage();
        $image->load($file_temp_path);
//essa variável armazena aonde iremos salvar o arquivo de foto
//pega tamanho da foto e verifica se o tamanho está adequado!
        $image_height = $image->getHeight();
        $image_width = $image->getWidth();

//o tamanho mínimo é 75x75.. menos que isso não tem como aceitar!
        if ($image_height < 75 && $image_width < 75) {
            $display_main->show_system_message('Error: A foto da logomarca enviada é muito pequena. Favor enviar uma foto maior que 75 x 75 pixels.', 'error');
            //vamos mostrar o final do site, para não bugar
            $display_main->painel_direita();
            $display_main->fundo();
            exit;
        }


    }
//::: Estabelece variáveis padrões
//verifica salário
    if (empty($vaga_salario) || !isset($vaga_salario)) {
        $vaga_salario = "0.00"; //deixa como "A combinar" = 0	
    } else {//se tem salário, vamos acertar o número para inserir na base de dados (converte R$ 1500,00 em 1500.00, por ex)
        require_once('funcoes/number_functions.php');
        $vaga_salario = concerta_preco($vaga_salario); //conserta o salário inserido pelo usuário e transforma-o em double(float)
    }

//se o nome da empresa não foi especificado, coloque como empregue-me
    if (empty($vaga_empresa) || !isset($vaga_empresa)) {
        $vaga_empresa = "empregue-me";
    }

//inicio e término da duração da vaga
    /* 3600 seconds in one hour
      86400 seconds in one day
      1296000 seconds in 15 days */


    //corta espaços vazios do campo email
    $vaga_email = trim($vaga_email);


//ATENÇÃO!! TEM QUE INSERIR A DATA COMO STRING NO BIND_PARAM ==> Senão no mysqli vai ficar bugado (0000-00-00)!!! Isso custou 4 horas da minha vida.
    $di = time();
    $dt = time() + (86400 * 30);//86400 = 1 dia * 30 = 1 mes

    $get_di = getdate($di);
    $data_inicio = $get_di['year'] . '-' . $get_di['mon'] . '-' . $get_di['mday'];

    $get_dt = getdate($dt);
    $data_termino = $get_dt['year'] . '-' . $get_dt['mon'] . '-' . $get_dt['mday'];

//variáveis padrão

    $vaga_ativo = 1; //vaga inicia ativa
    $vaga_destaque = 0; //nao é destaque
    $vaga_exclusivo = 0; //nao é exclusiva
//Insere nova vaga na base de ddos
    $mysqli = mysqli_full_connection();
    mysqli_set_charset($mysqli, "utf8");
    $qry = "INSERT INTO vagas VALUES(NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('iiissssssiiiissssss', $_SESSION['userid'], $vaga_cidade, $vaga_categoria, $vaga_nome, $vaga_email, $vaga_descricao, $vaga_salario, $data_inicio, $data_termino, $vaga_ativo, $vaga_quantidade, $vaga_destaque, $vaga_exclusivo, $vaga_logomarca, $vaga_link, $vaga_telefone, $vaga_tipo, $vaga_empresa, $vaga_tag);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        if ($tem_foto) {//se tem foto especifica da logomarca, vamos salvá-la
//Após inserirmos a vaga, vamos pegar a ID do anúncio para associarmos às fotos que iremos enviar
            $vaga_id = $mysqli->insert_id;

//insere local para armazenamento
//essa variável armazena aonde iremos salvar o arquivo de foto
            $file_path = "../upload/gfx/vagas/";

            $data = explode('/', $file_type);
            $file_extension = $data[1]; //pegamos a extensão do arquivo
            $file_extension = "jpeg";
//Agora vamos manejar o arquivo enviado
            if (is_uploaded_file($file_temp_path)) {//se arquivo temporário já chegou é porque o upload já foi concluido
                $uploaded_file = $file_path . "vag_" . $vaga_id . "." . $file_extension;


                if (!move_uploaded_file($file_temp_path, $uploaded_file)) {//se nao conseguir mover
                    $display_main->show_system_message("Error: Vaga inserida porem não foi possível mover o arquivo ao diretório de destino", 'error');
                    //vamos mostrar o final do site, para não bugar
                    $display_main->painel_direita();
                    $display_main->fundo();
                    exit;
                }

//--photo resize (vamos alterar o tamanho do arquivo
                //   $uploaded_file_thumb = $file_path . "thumb_" . $vaga_id . "." . $file_extension;
               
                $image->load($uploaded_file);
                $image->resize(100, 100);
                $image->save($uploaded_file); //salva no lugar da foto original (substitui)
            } else {//se o arquivo temporário não existe... é possível que seja um ataque em arquivo de upload
                $display_main->show_system_message("Error: Possível ataque de upload. Abortando! - Nome do arquivo: " . $file_name, 'error');
                //vamos mostrar o final do site, para não bugar
                $display_main->painel_direita();
                $display_main->fundo();
                exit;
            }
        }//end isset vaga logomarca        
        //redireciona e atualiza vagas
        require_once('funcoes/url_functions.php');
        redireciona('main.php?show_message=Vaga inserida com sucesso! Agora é só aguardar a chegada dos currículos em seu e-mail. Obrigado&&tipo=sucesso');
    }

//abre nova query e registra foto
}//end postar nova vaga--------------------------------------------------------



$display_main->painel_direita();
$display_main->fundo();
?>


