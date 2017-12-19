<?php
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');//para lidarmos com a sessão de usuário
require_once('funcoes/db_functions.php');
require_once('funcoes/funcoes_estruturais.php');

//inicia sessão
if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
$display_main = new display_main;//associa uma variával à classe de carregamento do layout

$display_main->head('@import url(\'css/lista_email.css\');');

//verifica se usuario esta logado
check_loggedin();


$display_main->topo();
$display_main->painel_esquerda();

//conteúdo

echo '<h2>Expanda seus contatos e faça bons negócios!</h2>';

echo 'Aguarde enquanto criamos sua rede de negócios...';

//redireciona usuário para main, se importou email = 1 ( ou seja, se já importou);

if($_SESSION['importou_email'] == 1)
{
	redireciona('main.php');	
}

require_once('funcoes/url_functions.php');

//function for parsing the curl request
function curl_file_get_contents($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
$client_id = '000000004811A9D0';
$client_secret = 'F7ME5YZ3b99Zm8gQrfu1DUrsnjBNcbo9';
$redirect_uri = 'http://www.empregue-me.com/novo/oauth-hotmail.php';
$auth_code = $_GET["code"];
$fields=array(
'code'=>  urlencode($auth_code),
'client_id'=>  urlencode($client_id),
'client_secret'=>  urlencode($client_secret),
'redirect_uri'=>  urlencode($redirect_uri),
'grant_type'=>  urlencode('authorization_code')
);
$post = '';
foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
$post = rtrim($post,'&');
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
curl_setopt($curl,CURLOPT_POST,5);
curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
$result = curl_exec($curl);
curl_close($curl);
$response =  json_decode($result);
$accesstoken = $response->access_token;
$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken.'&limit=10000';
$xmlresponse =  curl_file_get_contents($url);
$xml = json_decode($xmlresponse, true);
$msn_email = "";


//SALVA DADOS NO MYSQL
//conecta-se com base de dados para registro de emails
require_once('funcoes/db_functions.php');
		clean_stmt();
		$mysqli = mysqli_full_connection();


foreach($xml['data'] as $emails)
{
// echo $emails['name'];
		
$email_ids = implode(",",array_unique($emails['emails'])); //will get more email primary,sec etc with comma separate
$msn_email .= "<div><span>".$emails['name']."</span> &nbsp;&nbsp;&nbsp;<span>". rtrim($email_ids,",")."</span></div>";
$email_info = rtrim($email_ids,",");

if(!empty($email_info) > 0)
			{

			
					$qry = "INSERT INTO lista_email VALUES (NULL, ?, ?, ?, 0, 0 )";
					$stmt = $mysqli->prepare($qry);
					$stmt->bind_param('iss',$_SESSION['userid'],$emails['name'],$email_info);
					$stmt->execute();
					//atualiza perfil
					clean_stmt();
					$qry = "UPDATE usuario SET importou_email = 1 WHERE usu_codigo=?";
					$stmt = $mysqli->prepare($qry);
					$stmt->bind_param('i',$_SESSION['userid']);
					$stmt->execute();
					clean_stmt();
				
					
					
		
			}


}


		echo '<p>Contatos salvos com sucesso!</p>
		
		<p class="texto_verde"><a href="main.php" target="_self">Clique aqui ou aguarde enquanto redirecionamos você para página principal...</a></p>
		';

		?>
      
			<script type="text/javascript">
        	$(document).ready(function(e) {
								
				
                setTimeout('document.location.href="main.php"', 3000)
            });//end ready
        </script>
<?php
///

$display_main->painel_direita();
$display_main->fundo();
			

 
?>