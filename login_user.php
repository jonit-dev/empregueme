<?php
require_once('class_display.php');
//Script functions
require_once('funcoes/session_functions.php');
require_once('funcoes/top_functions.php');
require_once('funcoes/db_functions.php');
require_once('funcoes/email_functions.php');
require_once('funcoes/login_functions.php');


//CÓDIGO GOOGLE ANALYTICS
		
		echo "<script type=\"text/javascript\">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34989993-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";



//form vars
if(isset($_POST['login']))
{
@$login = mysqli_secure_query($_POST['login']);
@$password = mysqli_secure_query($_POST['password']);
}

if(isset($_POST['login_up']))
{
@$login = mysqli_secure_query($_POST['login_up']);
@$password = mysqli_secure_query($_POST['password_up']);
}

if(isset($_GET['vaga_id']))
{
	$vaga_id = $_GET['vaga_id'];
login_user($login,$password,false,true,$vaga_id);
exit;
}

	
	



if(isset($_GET['loadafter']))
{	


login_user($login,$password,$url_redireciona,false,false);//login com redirect
}
else//login normal
{
	login_user($login,$password,false,false,false);
}


?>


</body>
</html>