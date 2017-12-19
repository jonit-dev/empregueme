$(document).ready(function(e) {
    $(".results_box").hide();

	
$("#tag").bind("keyup",function(e){//quando usuário apertar um caracter
  //  var value = this.value + String.fromCharCode(e.keyCode);
	var tag_value = $("#tag").val();
	var qry_lenght = tag_value.length;
		if(qry_lenght >= 3)//se digitou pelo menos 3 caracteres vamos começar a busca 
		{
	
		$.post('autocomplete_ajax.php',{
			qry:tag_value
			},function(data){
				//callback function
								//quando o script nos retornar os dados
				//primeiro, vamos limpar os últimos resultados
				
				if (data.length > 0)//se tem algo para mostrar
					{
							  $(".results_box").show();//mostra resultado se tiver escondido
					  $("#results").html('');
					  $("#results").append(data);
					}
		  });//end ajax
		}//end qry lenght
		
		if(qry_lenght < 3)//se é menor, esconde a result box
		{
			$(".results_box").hide();
		}
		
		
});//end key up

$("#results").on('click', '.not_selected', function() {//tem que selecionar dessa forma porque a classe foi gerada dinamicamente pelo PHP.. se fizer $(".not_selected") nao funciona!

$("#tag").val($(this).text());//coloca input como texto da tag

$("#results").html("");//remove valor dos resultados
$("#results").hide();//esconde resultados



});


});//end ready

