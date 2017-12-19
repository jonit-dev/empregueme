// JavaScript Document// JavaScript Document

$(document).ready(function(e) {
    noty({
  text: 'Quer criar sua conta VIP e ter mais chances de conseguir um emprego?',type:'success',layout:'topCenter'
  
  ,
  buttons: [
    {addClass: 'btn btn-success', text: 'Sim', onClick: function($noty) {

        // this = button element
        // $noty = $noty element

        $noty.close();
//mostra contato de candidato

        window.location.replace('membro_vip.php');

      }
    },
    {addClass: 'btn btn-danger', text: 'Não', onClick: function($noty) {
        $noty.close();
     
      }
    }
  ]
});
});//end ready