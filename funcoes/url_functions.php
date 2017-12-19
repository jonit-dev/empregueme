<?php
//função para redirecionamento de URL..

function redireciona($link,$delay = 0){
	

if($delay != 0)//se for para dar um delay no redirecionamento...
	{
		echo ' <script type="text/javascript">
        $(document).ready(function(e) {


            setTimeout(\'document.location.href="'.$link.'"\', '.$delay.')
        });//end ready
    </script>';
		
	}
	else//se for para redirecionar na hora
	{
		

	
	
if ($link==-1){
echo" <script>history.go(-1);</script>";
}else{
echo" <script>document.location.href='$link'</script>";
}
	}//end else



}

//pega url da pagina
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/*
Basta utilizar a função acima que não da mais esse erro, para chama-la usem assim:

<? php
$link = 'index.php?pagina=teste'; // especifica o endereço
redireciona($link); // chama a função

?>


Pra usar um link "VOLTAR" use:
redireciona(-1);

*/

?>