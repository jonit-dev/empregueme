<?php

class date_management
{
	function gera_data($time_unix,$formato,$com_horario = false,$delimiter = "-")
		{
			
		$data = getdate($time_unix);
		
		if($com_horario == false)
			{
				$horario = '';	
			}
		if($com_horario == true)
			{
				$horario = $data['hours'].':'.$data['minutes'].':'.$data['seconds'];
			}
		
		
		switch($formato)
			{
				case 'pt-br':
						$data_output = $data['mday'].$delimiter.$data['mon'].$delimiter.$data['year'].' '.$horario;
						return $data_output;
				break;
				case 'eng':
				
						$data_output = $data['year'].$delimiter.$data['mon'].$delimiter.$data['mday'].' '.$horario;
						return $data_output;
				break;	
				
			}

			
		}
		
		
	function converte_data($data_string,$formato_entrada,$formato_saida)
	{
		
	switch($formato_entrada)
		{
			case 'eng':
				if($formato_saida == 'pt-br')
					{
						$data = explode($delimiter,$data_string);
						$output_data = $data[2].$delimiter.$data[1].$delimiter.$data[0];
						return $output_data;	
					}
			break;	
		}
		
		
	}
	
	
	
}


?>