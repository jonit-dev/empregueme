<?php
function box_feedback_init()
{
echo '


<div id="feedback">

<a href="javascript:void(0)">
<img src="gfx/ui/de_sua_ideia.jpg" class="feedback_tag"/>
</a>


<div class="feedback_box">
	
	
		<div class="feedback_content">
			  
				  <ul>
					  <li><strong>Assunto:</strong>
									  <select name="feedback_assunto" id="feedback_assunto">
										  <option value="melhorias">Melhorias</option>
										  <option value="criticas">Críticas</option>
									  </select>
									  
					  </li>
					  <li>
						  <textarea name="feedback_txt" id="feedback_txt" placeholder="Escreva aqui..."></textarea>
						  <input type="hidden" name="userid" id="userid" value="'.$_SESSION['userid'].'"
					  </li>
					  
				  </ul>
				  <center>
				  <input type="submit" value="Enviar" style="top:170px;left:40%;" class="candidatar" id="enviar_feedback"/>
				  </center>
		</div>


</div>

</div>

';	
	
}
?>