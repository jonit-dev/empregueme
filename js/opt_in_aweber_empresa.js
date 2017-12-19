// JavaScript Document

//script para fazer opt in no aweber

$(document).ready(function(e) {
    
	
		alert('registrando lead...');
		$.post('http://www.aweber.com/scripts/addlead.pl',
		{
			meta_web_form_id:'620423551',
			meta_split_id:'',
			listname:'empresas_es',
			redirect:'www.empregue-me.com',
			name:'Testador',
			email:'testador@gmail.com',
			meta_forward_vars:'1',
		
			meta_adtracking:'Form_empresas_ES',
			meta_message:'1',
			meta_required:'name,email',
			meta_tooltip:''
			
			},function(data){
				
				alert(data);
				
				
				});
	
	
});//end ready