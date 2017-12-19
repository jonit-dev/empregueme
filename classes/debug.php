<?php

class debug
{
	function speed_test_init()//deve ser colocado no início da página a calcular velocidade de carregamento
		{
		global $start;	
			$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;	
		}
		
	function speed_test_result()
	{
		$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
		
	}
	
	
}

?>