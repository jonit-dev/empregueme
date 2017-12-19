<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Profile - Bookmark</title>
</head>
<body>
<h1>User Profile</h1>

<?php
require_once('class_display.php');
require_once('funcoes/session_functions.php');
$display_site = new display;

//update session vars
//session_start();

check_loggedin();//check if user is logged in!

//se o usuário logou corretamente
echo "

<h2>Product list</h2>
<fieldset>
<p>No product</p></a>
</fieldset>

<br />
<h2>Main Actions</h2>


<h2>Account details</h2>
<strong>UserID:</strong> ".$_SESSION['userid']."</br>
<strong>E-mail:</strong> ".$_SESSION['login']."</br>

<h2>Account Management</h2>
<a href='logout.php'>Logout</a></br>
<a href='change_pw.php'>Change Password</a>


<br />
<br />

</br>
</br>
</br>


";
$display_site->down();



?>



</body>
</html>