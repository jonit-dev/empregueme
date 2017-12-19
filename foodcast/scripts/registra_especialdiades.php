<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="msapplication-tap-highlight" content="no" />
        <!-- WARNING: for iOS 7, remove the width=device-width and height=device-height attributes. See https://issues.apache.org/jira/browse/CB-4323 -->
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
   
   
   			
   		   <link rel="stylesheet" type="text/css" href="css/fonts/stylesheet.css" />
   			 <link rel="stylesheet" type="text/css" href="css/principal.css" />
              <link rel="stylesheet" type="text/css" href="jqm/jquery.mobile-1.4.3.min.css" />
   		       <link rel="stylesheet" href="css/themes/sosplantoes.min.css" />
 		 <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
   
          
        
        <title>SOS Plantões</title>
                <script type="text/javascript" src="cordova.js"></script>
                 <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
                 	<script type="text/javascript" src="js/init.js"></script>
                 
                  <script type="text/javascript" src="jqm/jquery.mobile-1.4.3.min.js"></script>
        
        
        <!--- TEMPLATE-->
        <!--esse código clona os mestres e aplica o conteúdo nos childrens (para repetir o mesmo layout ao longo das paginas!-->
              <script type="text/javascript" src="js/importa_layout.js">            
              </script>
              
              <!--GERENCIA CRIAÇÃO DE CONTA-->
              <script type="text/javascript" src="js/nova_conta.js"></script>
              
                        
        
    </head>
  <body>
<?php

$especialidades = file('especialidades.txt');

require_once('../funcoes/db_functions.php');

//inicia conexão
require_once('../classes/connect_class.php');
$connect= new ConnectionFactory;
$mysqli = $connect->getConnection();
$mysqli->set_charset("utf8");



for($i=0;$i<count($especialidades);$i++)
	{

			$qry = "INSERT INTO especialidades VALUES (null,?)";
			$stmt = $mysqli->prepare($qry);
			$stmt->bind_param('s',utf8_encode($especialidades[$i]));
				$stmt->execute();
				
	}




?>
</body>
</html>