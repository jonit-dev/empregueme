// JavaScript Document
$(document).ready(function(e) {
    
	$("#registrar").click(function(){
		
		$this = $(this);
		
		
		
		
var $campos_vazios = '';
		
		
		if($("#nome").val() == '')
			{
				$("#nome").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Nome, ";
			}
			
			if($("#sexo").val() == '')
			{
				$("#sexo").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Sexo, ";
			}
			
				if($("#idade").val() == '')
			{
				$("#idade").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Idade, ";
			}
			
			if($("#estado").val() == '')
			{
				$("#estado").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Estado, ";
			}
			
				if($("#cidade").val() == '')
			{
				$("#cidade").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Cidade, ";
			}
			
						if($("#bairro").val() == '')
			{
				$("#bairro").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Bairro, ";
			}
			
					if($("#telefone1").val() == '')
			{
				$("#telefone1").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Telefone(1°), ";
			}
			
			if($("#objetivo").val() == '')
			{
				$("#objetivo").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Objetivo Profissional, ";
			}
		
			if($("#area_profissional").val() == '')
			{
				$("#area_profissional").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Área Profissional, ";
			}
			
				
		
		if($("#categoria_profissional").val() == '')
			{
				$("#categoria_profissional").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Categoria Profissional, ";
			}
			
				if($("#escolaridade").val() == '')
			{
				$("#escolaridade").css(
										{
							'background-color':'#ffe8e8'
									});	
									$campos_vazios += "Escolaridade, ";
			}
		
		//ingles e office nao precisa validar pq tá sempre setado
		
		//valida CNH
			var	$horario_disp = $("input[name=horario_disp\\[\\]]:checked").length;		
				String($horario_disp)
				
			//	alert($horario_disp);
		if($horario_disp == 0)//se nao tem checkbox marcado
			{
				$("#horario_disp_txt").css(
										{
							'background-color':'#ffe8e8'
									});	
				$campos_vazios += "Horário Disponível, ";
			}
		
		
		if($campos_vazios.length > 0)//se tem algum erro
		{
			/*var str = "12345.00";
str = str.substring(0, str.length - 1);*/
			
		$campos_vazios = $campos_vazios.substring(0,$campos_vazios.length-2);//remove última vírgula
		
		alert('Você esqueceu de preencher os seguintes campos:  '+$campos_vazios);
		
		
		//verifica para qual campo irá mandar o foco (sempre pro primeiro
		
		var foco = $campos_vazios.split(',');
		
		var foco_principal = foco[0];
		
		if(foco_principal == 'Nome') { $("#nome").focus();	}
		if(foco_principal == 'Idade') { $("#idade").focus();	}
		if(foco_principal == 'Sexo') { $("#sexo").focus();	}
		if(foco_principal == 'Estado') { $("#estado").focus();	}
		if(foco_principal == 'Cidade') { $("#cidade").focus();	}
		if(foco_principal == 'Bairro') { $("#bairro").focus();	}
		if(foco_principal == 'Telefone(1°)') { $("#telefone1").focus();	}
		if(foco_principal == 'Área Profissional') { $("#area_profissional").focus();	}
		if(foco_principal == 'Objetivo Profissional') { $("#objetivo").focus();	}
		if(foco_principal == 'Categoria Profissional') { $("#categoria_profissional").focus();	}
		if(foco_principal == 'Escolaridade') { $("#escolaridade").focus();	}
		if(foco_principal == 'Horário Disponível') { $("#horario_focus").focus();	}
		
		//se der erro...nao deixa registrar!
		return false;
		}
		
		$this.attr('value','Registrar Currículo');
		
		
		});//end registrar click	
	
});//