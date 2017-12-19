// JavaScript Document

$(document).ready(function(e) {
    
	$(".candidatar,.btm_cadastrar").click(function(){
		
		$candidatar = $(this);
		var userid = $(this).siblings('input[name=userid]').val(),
		vaga_codigo = $(this).siblings('input[name=vaga_codigo]').val()
		
		;
		
		
$.post('ajax/envia_curriculo.php',
{
	userid:userid,
	vaga_codigo:vaga_codigo
	},function(data){
		//callback
	



String(data);

if(data.indexOf('VIP') > 0 && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
					  
					  var n = noty(
			  {
				  text: 'Seu currículo de membro VIP foi enviado com sucesso e já se encontra no e-mail da empresa!',
				  type: 'success',
				  layout:'topCenter',
				  timeout:6000
			  });
			  
			  //vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Membro VIP: Seu currículo foi enviado para essa vaga</h4>');


	}
	
	/*
if(data.indexOf('VIP') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
										  var n = noty(
						  {
							  text: 'Seu currículo de membro VIP não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	
	}	*/



if((data.indexOf('normal') > 0 || data.indexOf('empresa') > 0  ) && data.indexOf('Registrada') > 0  )//se foi vaga VIP enviada
	{
				noty({
  text: 'Seu currículo foi adicionado à fila e somente após 48 horas será enviado para a empresa. Caso queira ter o envio realizado AGORA MESMO, clique em ENVIAR AGORA para criar sua conta VIP.',type:'success',layout:'topCenter'
  
  ,
  buttons: [
    {addClass: 'btn btn-warning', text: 'Enviar AGORA', onClick: function($noty) {

        // this = button element
        // $noty = $noty element

        $noty.close();
  document.location.href="membro_vip.php";//redireciona para pagina VIP
      }
    },
    {addClass: 'btn btn-danger', text: 'Continuar na Fila', onClick: function($noty) {
        $noty.close();
        noty({text: 'Seu currículo está na fila junto com outros candidatos, e só será enviado após 48 horas.', type: 'error', timeout:6000});
      }
    }
  ]
});
		
	//vamos mudar o botão para mostrar que a vaga já foi enviada!
			$candidatar.replaceWith('<h4 style="color:#6ac824;">Seu currículo será enviado para essa vaga.</h4>');	
		
		
	}
	
	/*
if(data.indexOf('normal') > 0  && data.indexOf('Erro') > 0 )//se foi vaga VIP enviada
	{
  var n = noty(
						  {
							  text: 'Seu currículo não foi enviado por algum erro! Entre em contato com sac@empreguemeagora.com.br',
							  type: 'error',
							  layout:'topCenter',
							  timeout:6000
						  });
	}	*/




		
		
		
		
		
		});



		
		
		});//end candidatar click
	
	
});//end ready