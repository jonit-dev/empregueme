<?php

function gerencia_erros_nova_conta()
{
	require_once('classes/display_main.php');
	require_once('funcoes/url_functions.php');
	$display_main = new display_main();
//*---------------VALIDAÇÃO DA CRIAÇÃO DE CONTA----------//*

if (isset($_GET['error'])) {//se ta passando error por get é porque quer mostrar codigo de erro
    switch ($_GET['error']) {
        case 1:
            $display_main->show_banner('Erro: Campo vazio no formulário!', '
			<p>Você esqueceu algum campo vazio no formulário. </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 2:
            $display_main->show_banner('Erro: Caracter inválido', '
			<p>Você inseriu algum caracter inválido no campo de formulário para criação de conta. </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 3:
            $display_main->show_banner('Erro: E-mail inválido', '
			<p>O e-mail que você inseriu é inválido. Verifique se está tudo digitado corretamente ou registre com outro e-mail </p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 4:
            $display_main->show_banner('Erro: Senhas não são as mesmas', '
			<p>As novas senhas que você inseriu não são as mesmas! Escolha uma nova senha e depois digite-a novamente abaixo.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 5:
            $display_main->show_banner('Erro: Os e-mails não são os mesmos', '
			<p>Os e-mails que você inseriu não são os mesmos! Certifique-se de que os dois e-mails inseridos sejam os mesmos.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 6:
            $display_main->show_banner('Erro: Nome de usuário', '
			<p>O nome de usuário possui mais de 100 caracteres! Abrevie seu nome para evitar qualquer erro.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 7:
            $display_main->show_banner('Erro: Apelido', '
			<p>Seu apelido está muito grande. Tente um outro apelido com até 8 letras.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 8:
            $display_main->show_banner('Erro: Apelido', '
			<p>Comprimento inválido de senha! Tente alguma senha entre 6 a 16 caracteres</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 9:
            $display_main->show_banner('Erro: Tamanho da foto', '
			<p>O tamanho da foto excede o limite máximo de upload do servidor (1MB).</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 10:
            $display_main->show_banner('Erro: Foto enviada parcialmente', '
			<p>Algum erro ocasionou o envio parcial de sua foto.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 11:
            $display_main->show_banner('Erro: Esqueceu de enviar a foto', '
			<p>Você esqueceu de enviar sua foto.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
        case 12:
            $display_main->show_banner('Erro: Arquivo de foto inválido', '
			<p>O arquivo que você tentou enviar como foto não corresponde aos formatos aceitos (.jpeg, .png ou .bmp)</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 13:
            $display_main->show_banner('Erro: Foto do perfil muito pequena', '
			<p>Sua foto de perfil está muito pequena! Insira uma foto com tamanho maior que 75x75 pixels.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;



        case 14:
            $display_main->show_banner('Erro: Usuário já existe', '
			<p>Já existe um usuário com a conta de e-mail que você está tentando registrar.</p>
			<br />
<p>Por favor, tente registrar novamente com outro e-mail!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 15:
            $display_main->show_banner('Erro: Apelido já existe', '
			<p>O apelido que você está tentando registrar já está em uso.</p>
			<br />
<p>Por favor, tente registrar novamente com outro apelido!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 16:
            $display_main->show_banner('Erro: Envio de conta por e-mail', '
			<p>Sua conta foi criada, porém não foi enviada via e-mail.</p>
			<p>Tente acessá-la agora e, caso não consiga efetuar login, crie uma nova conta.</p>
			<br />
		
			<center><input type="button" id="ok_btm" value="Ok" class="btm_error"/></center>
			
			', 'small');

            break;

        case 17:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Não foi possível criar pasta para salvar dados de usuário.</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 18:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Não foi possível mover o arquivo de dados do usuário ao diretório de destino</p>
			<br />
<p>Por favor, tente novamente!
	</p>		
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;


        case 19:
            $display_main->show_banner('Erro: Dados de usuário', '
			<p>Possível ataque de upload. Abortando!!</p>
			<br />
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 20://para o esqueci minha senha
            $display_main->show_banner('Erro: E-mail inválido', '
			<p>O e-mail que você inseriu é inválido.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 21://para o esqueci minha senha
            $display_main->show_banner('Erro: E-mail inexistente', '
			<p>O e-mail não existe. Insira um registrado em nosso sistema!</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;

        case 22://para LOGIN

            $display_main->show_banner('Erro: Combinação e-mail ou senha incorreta', '
			<p>A combinação e-mail x senha inserida está incorreta.
			<br />
<br />
<p><strong>ATENÇÃO MEMBROS GRATUITOS:</strong> Como migramos para nossa nova rede social, é necessário que você crie uma NOVA CONTA.</p>

<p>
<strong>ATENÇÃO MEMBROS VIP:</strong> Sua conta é a mesma de antes. Caso não tenha recebido, envie um e-mail para sac@empreguemeagora.com.br</p>

Por favor, tente novamente! <strong>Caso não lembre de sua senha, <a href="index.php?esqueci_senha=true"><span style="text-decoration:underline">clique aqui</span></a></strong></p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');
            break;
        
        case 23://para o campo cidade
            $display_main->show_banner('Erro: Cidade Inválida', '
			<p>Selecione sua cidade.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;
			
		  case 24:// esqueceu de especificar tipo de conta
		              $display_main->show_banner('Você esqueceu de especificar o tipo de sua conta', '
			<p>Você esqueceu de especificar o tipo de sua conta (empresa ou candidato) no formulário.</p>
			<br />
			<p>Por favor, tente novamente.</p>
			<center><input type="button" id="ok_btm" value="Tentar novamente" class="btm_error"/></center>
			
			', 'small');

            break;	
			
    }
}	
	
	
}



?>