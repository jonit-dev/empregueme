// JavaScript Document

$(document).ready(function(e) {
    $("input[name=rst_telefone]").mask("(99) 9999-9999?9");
	$("input[name=rst_cep]").mask("99999-999");
	
	
	//preço
	 	$(".dinheiro").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
});//end ready