<?php include 'config.php';

switch($_SERVER['QUERY_STRING'])
{
        case 404:
                $title = '404 Not found';
                $message = 'Don\'t really know where that is...';
                break;

        case 500:
                $title = '500 Internal error';
                $message = 'Say whaa...? My bad...';
                break;

        case 403:
                $title = '403 Forbidden';
                $message = 'Just move along, nothing to see here...';
                break;

        default:
                $title = 'Unknown error';
                $message = 'I... just don\'t know...';
                break;
                
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <?php include DOCROOT.'header.php' ?>
        <style>
                body
                {
                        border-top: 3px solid #a00;
                        border-bottom: 1px solid #a00;
                }
        </style>

        <title>Error</title>
        
</head>

<body>
        <h1><?php echo $title ?></h1>

        <p><?php echo $message ?></p>

        <?php include DOCROOT.'footer.php' ?>

</body>

</html>