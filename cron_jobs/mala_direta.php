<?php
//ESSE SCRIPT DE PHP TEM A FINALIDADE DE ENVIAR EMAILS PARA OS ENDEREÇOS CAPTURADOS PELO BANCO DE DADOS


/*Como não cair no filtro de SPAM?
- IP unico
- adicionar $headers.= "MIME-version: 1.0\n";
$headers.= "Content-type: text/html; charset= iso-8859-1\n";
- enviar somente 250 por hora*/


echo 'Iniciando disparo de e-mails...';
	require_once('../classes/connect_class.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

//------VARIÁVEIS DE CONFIGURAÇÃO---------/
$max_envio_hora = 250;

//------------------------//


//Conecta com base de dados e carrega lista de emails que não foram enviados


$qry = "SELECT 
lista_email.email_id,
lista_email.email_contato,
lista_email.nome_contato,
perfil_usuario.nome_completo 
  FROM lista_email, perfil_usuario WHERE enviou_email = 0 AND perfil_usuario.userid = lista_email.id_quem_convidou";//vamos selecionar os endereços para os quais não enviamos nada ainda
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($r_email_id,$r_email_contato,$r_nome_contato,$r_nome_convidou);

//cria lista de envio
$lista_envio = "";
$cadastros = 0;//pra controlar numero de cadastros de envio

while($stmt->fetch())//quando tiver resultado
	{
		if($cadastros < $max_envio_hora)//se ainda não cadastramos o máximo permitido por hora em nossa lista de envio..
			{
				//cadastra em lista de envio
				
					
				$lista_envio .= $r_email_id."|".$r_email_contato."|".$r_nome_contato."|".$r_nome_convidou."#";
				$cadastros += 1;//add 1 cadastro
			}
	}
	
	
	
//após carregarmos a lista, vamos inicializar a classe de envio de emails
require_once('../php_mailer/PHPMailerAutoload.php');//PHPmail (envia o email com a nova senha)


$mail = new PHPMailer();
// Charset para evitar erros de caracteres
$mail->CharSet  = "UTF-8";  


//roda um LOOP FOR pela lista de contatos salvos, adicionando para quem iremos enviar os emails
$dados = explode("#",$lista_envio);


for($i=0; $i < $cadastros;$i++)//roda o script somente até o n de cadastrados para envio
	{
		// Dados de quem está enviando o email
		
		
$mail->From = 'no-reply@sociallia.com.br';
$mail->FromName = 'Sociallia Oficial';
 
// Setando o conteudo
$mail->IsHTML(true);
// Validando a autenticação
$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->Host     = "192.185.176.30";
//$mail->Port     = 465;
$mail->Username = 'no-reply@sociallia.com.br';
$mail->Password = '32258190';
$mail->AddReplyTo( 'no-reply@sociallia.com.br', 'Sociallia Oficial' );	

$subdados = explode("|",$dados[$i]);

//echo 'adding contact name...'.$subdados[2];
$mail->ClearBCCs();

$mail->AddBCC($subdados[1],$name = $subdados[2]);//adiciona email e nome do contato

$mail->Subject = utf8_encode('Bom dia '.$subdados[2].'! '.$subdados[3].'  tem um convite exclusivo lhe aguardando!');

$mensagem = utf8_encode('Ei '.$subdados[2].' tudo certo? Seu amigo lhe convidou para partipar da <strong>rede social de compras que mais cresce no Brasil</strong>! E o melhor, tudo gratuitamente!! <br>
<br>
<p>Acesse agora mesmo: <a href="http://www.sociallia.com.br" target="_new">http://www.sociallia.com.br</a>
</p>');


$mail->Body    = $mensagem;
$mail->AltBody =strip_tags($mensagem);




	if ($cadastros > 0)	
	{ 
		if($mail->send())//se realmente enviou o email ---------------> ENVIA UMA VEZ SÓ!
				  {
		echo 'E-mail enviado para: '.$subdados[1].' - '.$subdados[2].' - '.$subdados[3].'</br>';
				  }
		  
	}
	else
	{
	echo "Todos os e-mails já foram enviados.";	
	}
unset($stmt);


if(!empty($subdados[0]))
{
$qry = "UPDATE lista_email SET enviou_email = 1 WHERE email_id = ?";
$stmt = $mysqli->prepare($qry);
$stmt->bind_param('i',$subdados[0]);
$stmt->execute();
}
sleep(60);//aguarda 1 minuto antes de passar ao próximo.

		
	}//end for loop
	

//pronto =D 



//após envio de emails atualiza status


?>