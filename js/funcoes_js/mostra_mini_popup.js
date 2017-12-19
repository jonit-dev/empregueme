function mostra_mini_popup(mensagem)
	{
		$("body").prepend('<div class="mini_popup" id="mini_popup_id"><div class="mini_popup_close"></div><div class="mini_popup_txt">'+mensagem+'</div></div>');
	
	//já coloca um timeout.. se o user nao clicar em close, fecha sozinho
	setTimeout(function(){
		
		$("#mini_popup_id").fadeOut(1000,0,function(){
			
			$("#mini_popup_id").remove();
			
			});
	
		
		},6000);
	
		$("#mini_popup_id").animate(
		{
		bottom:'10px',
		opacity :'1'
		},500);
	

	
$("#mini_popup_id").delegate(".mini_popup_close","click",function(){
$("#mini_popup_id").fadeOut(1000,0,function(){
			
			$("#mini_popup_id").remove();
			
			});
	
	
	});	
		
	}//end function
