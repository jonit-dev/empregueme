// JavaScript Document

$(document).ready(function(e) {
    
	$("#menu_settings").hide();//esconde menu de settings
		var mostra_menu = false;
	
	
	$(".settings").click(function(){
		
			if (mostra_menu == false)
			{
			//mostra menu
			$("#menu_settings").show();
			mostra_menu = true;
			}
			else
			{
				$("#menu_settings").hide();
			mostra_menu = false;
			}
		
	
	})
	
$(document).mouseup(function (e)
{
    var container = $("#menu_settings");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
});
	
	
	
	
});//end ready