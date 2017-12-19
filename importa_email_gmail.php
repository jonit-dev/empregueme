<?php
session_start();
//carrega arquivo com o layout

require_once('classes/display_main.php');
require_once('funcoes/session_functions.php'); //para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');
require_once('funcoes/array_functions.php');


if(!check_session())
{
    session_start();
}

$display_main = new display_main; //associa uma variával à classe de carregamento do layout

$display_main->head('@import url(\'css/lista_email.css\');');

//verifica se usuario esta logado
//check_loggedin();


$display_main->topo();
$display_main->painel_esquerda();

//conteúdo

echo '<h2>Expanda seus contatos e faça bons negócios!</h2>';


//redireciona usuário para main, se importou email = 1 ( ou seja, se já importou);

if ($_SESSION['importou_email'] == 1) {

if(!check_session())
{
    session_start();
}
    redireciona('main.php');
}


if($_SESSION['tipo_conta'] == 0)
{
$link_skip = '<a href="main.php?tipo=usuario" class="texto_verde" id="email_list_skip">Agora não, obrigado</a>';
}
if($_SESSION['tipo_conta'] == 1)
{
$link_skip = '<a href="main.php?tipo=empresa" class="texto_verde" id="email_list_skip">Agora não, obrigado</a>';	
}


//==========>> IMPORTAÇÃO DE CONTATOS
 $nomecurto = explode(' ', $_SESSION['nome']);
    echo '
	<p>Olá ' . $nomecurto[0] . ', tudo certo? Você sabia que <strong>77% das oportunidades de trabalho são provenientes de amigos próximos?</strong> Por isso que ressaltamos que uma das melhores formas de se conseguir uma vaga de emprego <strong>é a partir da criação de sua rede de relacionamentos profissionais</strong>.
	Seguem abaixo alguns dos principais motivos pelos quais você já deveria ter criado a sua:	
	</p>	
		<ul>
			<li>Quanto <strong>mais amigos</strong> você trouxer, maior a chance de algum deles conhecer uma <strong>oportunidade</strong> e anunciar por aqui</li>
			<li>Uma rede de relacionamentos profissionais pode lhe ajudar a encontrar as melhores oportunidades mais facilmente, através da troca de informações</li>
		</ul>
		
		
	<p><span style="text-decoration:underline;">Clique abaixo</span> para importar seus contatos do Gmail e desfrutar todos os benefícios de uma boa rede de contatos:</p>
	<a style="margin-left:20%;" href="https://accounts.google.com/o/oauth2/auth?client_id=407034157765-vmjbivj8eni815tgk2gl204vfnd12ttj.apps.googleusercontent.com&redirect_uri=http://www.empregue-me.com/novo/importa_email_gmail.php&scope=https://www.google.com/m8/feeds/&response_type=code">
		<img src="gfx/ui/btm_importar_gmail.png" /></a> 
		<br />
<br />
<br />

        
		
				'.$link_skip.'
		
		';


//setting parameters
if(isset($_GET['scope']))
{
if(!check_session())
{
    session_start();
}	
}


if(isset($_GET['code']))//só iremos rodar esse código quando o gmail enviar a resposta..
{

if(!check_session())
{
    session_start();
}

	  $authcode= $_GET["code"];
	  
	  $clientid='407034157765-vmjbivj8eni815tgk2gl204vfnd12ttj.apps.googleusercontent.com';
	  
	  $clientsecret='CSxKvWCsrB1DDY9JmiNrL8mZ';
	  
	  $redirecturi='http://www.empregue-me.com/novo/importa_email_gmail.php';
	  
	  //criação de string a ser enviada para o google
	  $fields=array(
	  
	  'code' => urlencode($authcode),
	  
	  'client_id' => urlencode($clientid),
	  
	  'client_secret' => urlencode($clientsecret),
	  
	  'redirect_uri' => urlencode($redirecturi),
	  
	  'grant_type' => urlencode('authorization_code')
	  
	  );
	  
	  //url-ify the data for the POST
	  
	  $fields_string='';
	  
	  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	  
	  $fields_string=rtrim($fields_string,'&');
	  
	  //open connection curl
	  
	  $ch = curl_init();
	  
	  //set the url, number of POST vars, POST data
	  
	  curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
	  
	  curl_setopt($ch,CURLOPT_POST,5);
	  
	  curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	  
	  // Set so curl_exec returns the result instead of outputting it.
	  
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
	  //to trust any ssl certificates
	  
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  
	  //execute post
	  
	  $result = curl_exec($ch);
	  
	  //close connection
	  
	  curl_close($ch);
	  
	  //extracting access_token from response string
	  
	  $response = json_decode($result);
	  
	  $accesstoken = $response->access_token;
	  
	  //passing accesstoken to obtain contact details
	  
	  $xmlresponse= file_get_contents('https://www.google.com/m8/feeds/contacts/default/full?oauth_token='.$accesstoken.'&max-results=10000');
	  
	  //reading xml using SimpleXML
	  
	  $xml = new SimpleXMLElement($xmlresponse);
	  
	  $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
	  
	  $result = $xml->xpath('//gd:email');
	  
	  
//=========== REGISTRO EM BASE DE DADOS
	  //se conecta à base de dados para registro 
	
	  
	  $lista_email = array();
	  
	  foreach ($result as $title) {
	  
	  $lista_email[$i] = $title->attributes()->address;
	  $i += 1;
	  
	  
	  }//end foreach
	  

if(!check_session())
{
    session_start();
}
	  
	    $mysqli = mysqli_full_connection();
	  
	  for($i=0; $i<count($lista_email); $i++)//registra conteúdo da array no email
	  	{
			if (!empty($lista_email[$i])) {
			 $qry = "INSERT INTO lista_email VALUES (NULL, ?, 0, ?, 0, 0 )";
                $stmt = $mysqli->prepare($qry);
                $stmt->bind_param('is', $_SESSION['userid'],$lista_email[$i]);
                $stmt->execute();
			}

		}
	  
//abre base de dados e registra que usuário já importou lista.

    $qry = "UPDATE usuario SET importou_email = 1 WHERE usu_codigo=?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('i', $_SESSION['userid']);
    $stmt->execute();

 echo '<h4>Contatos salvos com sucesso!</h4>
		
		<p class="texto_verde"><a href="main.php" target="_self">Clique aqui ou aguarde enquanto redirecionamos você para página principal...</a></p>
		';
    ?>
    <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout('document.location.href="main.php"', 3000)
        });//end ready
    </script>

    <?php
	  
}










$display_main->painel_direita();
$display_main->fundo();
?>