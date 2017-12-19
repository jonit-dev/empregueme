<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

require_once('connect_class.php');

$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();

$qry = "SELECT email FROM auth";
$stmt = $mysqli->prepare($qry);
$stmt->execute();
$stmt->bind_result($r_email);

while($stmt->fetch())
{
	echo $r_email;
}


?>
</body>
</html>
