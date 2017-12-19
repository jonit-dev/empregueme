<?php
require_once('../funcoes/db_functions.php');

header ('Content-type: text/html; charset=utf-8');


$url = $_POST['url'];//captura variável passada pelo ajax

//$url = "http://www.posthaus.com.br/moda/regata-com-renda-branca_art86548.html";
function make_absolute_path ($baseUrl, $relativePath) {

    // Parse URLs, return FALSE on failure
    if ((!$baseParts = parse_url($baseUrl)) || (!$pathParts = parse_url($relativePath))) {
        return FALSE;
    }

    // Work-around for pre- 5.4.7 bug in parse_url() for relative protocols
    if (empty($baseParts['host']) && !empty($baseParts['path']) && substr($baseParts['path'], 0, 2) === '//') {
        $parts = explode('/', ltrim($baseParts['path'], '/'));
        $baseParts['host'] = array_shift($parts);
        $baseParts['path'] = '/'.implode('/', $parts);
    }
    if (empty($pathParts['host']) && !empty($pathParts['path']) && substr($pathParts['path'], 0, 2) === '//') {
        $parts = explode('/', ltrim($pathParts['path'], '/'));
        $pathParts['host'] = array_shift($parts);
        $pathParts['path'] = '/'.implode('/', $parts);
    }

    // Relative path has a host component, just return it
    if (!empty($pathParts['host'])) {
        return $relativePath;
    }

    // Normalise base URL (fill in missing info)
    // If base URL doesn't have a host component return error
    if (empty($baseParts['host'])) {
        return FALSE;
    }
    if (empty($baseParts['path'])) {
        $baseParts['path'] = '/';
    }
    if (empty($baseParts['scheme'])) {
        $baseParts['scheme'] = 'http';
    }

    // Start constructing return value
    $result = $baseParts['scheme'].'://';

    // Add username/password if any
    if (!empty($baseParts['user'])) {
        $result .= $baseParts['user'];
        if (!empty($baseParts['pass'])) {
            $result .= ":{$baseParts['pass']}";
        }
        $result .= '@';
    }

    // Add host/port
    $result .= !empty($baseParts['port']) ? "{$baseParts['host']}:{$baseParts['port']}" : $baseParts['host'];

    // Inspect relative path path
    if ($relativePath[0] === '/') {

        // Leading / means from root
        $result .= $relativePath;

    } else if ($relativePath[0] === '?') {

        // Leading ? means query the existing URL
        $result .= $baseParts['path'].$relativePath;

    } else {

        // Get the current working directory
        $resultPath = rtrim(substr($baseParts['path'], -1) === '/' ? trim($baseParts['path']) : str_replace('\\', '/', dirname(trim($baseParts['path']))), '/');

        // Split the image path into components and loop them
        foreach (explode('/', $relativePath) as $pathComponent) {
            switch ($pathComponent) {
                case '': case '.':
                    // a single dot means "this directory" and can be skipped
                    // an empty space is a mistake on somebodies part, and can also be skipped
                    break;
                case '..':
                     // a double dot means "up a directory"
                    $resultPath = rtrim(str_replace('\\', '/', dirname($resultPath)), '/');
                    break;
                default:
                    // anything else can be added to the path
                    $resultPath .= "/$pathComponent";
                    break;
            }
        }

        // Add path to result
        $result .= $resultPath;

    }

    return $result;

}

require_once('../classes/simple_html_dom.php');

//verifica se url tem http... se nao tiver, adiciona
if(!stristr($url,"http://"))
		{
			$url = "http://".$url;//adiciona http, se nao tiver
		}
	
	$data = explode("/",$url);
	$server_path = 'http://'.$data[2];
	

// Create DOM from URL or file
$html = file_get_html($url);

// Find all images 
foreach($html->find('img') as $element) 
{

	
	$image_src = $element->src;
	//verifica se o SRC é absoluto ou relativo
	if(!stristr($image_src,"http://"))//se nao encontrar o http é porque é relativo
		{
		@ $image_src = make_absolute_path($url,$image_src);
		}
	



	//antes de enviar, verifica se o src realmente é uma imagem

$results = "";
if(!stristr($image_src,".gif"))//exclui imagens .gif, que geralmente são muito pequenas
	{

//permite somente jpg, bpm e png
	if(stristr($image_src,".png") || stristr($image_src,".jpg") || stristr($image_src,".bmp"))
	{
		$results .= '<a href="javascript:void(0)" ><img class = "loaded_image" style="width:'.$element->width.'px; height:'.$element->height.'px;" src="'.$image_src.'" /></a>';
	}
}

echo $results;
}


?>