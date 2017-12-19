// JavaScript Document

$(document).ready(function(e) {
    noty({
  text: 'Você não possui o Plano Recrutador e tem direito a apenas 5 contatos com usuário por semana. Tem certeza que deseja entrar em contato com esse candidato?.',type:'success',layout:'topCenter'
  
  ,
  buttons: [
    {addClass: 'btn btn-warning', text: 'Sim', onClick: function($noty) {

        // this = button element
        // $noty = $noty element

        $noty.close();
//mostra contato de candidato

var empresaid = $("input[name=id_empresa]").val();//pega o ID DA EMPRESA E PASSA COMO USER ID
	
var userid = $("input[name=id_candidato]").val();//
//queima 1 crédito do candidato
	$.post('ajax/diminui_credito.php',
	{
	empresaid:empresaid
	},function(data)
		{
		
		});
	
	
		//mostra contato do candidato
	$.post('ajax/carrega_contato.php',
	{
	userid:userid	
	},function(data)
	{
		
	$("#resposta_contato").html(data);
	$.getScript('js/banner_direto_js.js', function() {
	
	mostra_banner('Contato do Candidato',data);});
	
	});
	
	


      }
    },
    {addClass: 'btn btn-danger', text: 'Não', onClick: function($noty) {
        $noty.close();
     
      }
    },{addClass: 'btn btn-info', text: 'Criar Plano Recrutador', onClick: function($noty) {
        $noty.close();
        window.location.replace('plano_recrutador.php');
      }
    }
  ]
});
});//end ready