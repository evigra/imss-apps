	var var_modulo="fonoaudiologia";

	$(document).ready(function()
	{			
		if($("#action_cancelar").length>0) 
		{
			$("#action_cancelar").click(function()
			{
				$("#estatus").val("CANCELADO");
				$("form").submit();									
			});			
		}		
		/*
		$("#nss").focusout(function() 				
		*/
		$("#agregado").focusout(function() 		
		{		
			
			$.ajax({
				type: 'GET',
				url: '../modulos/' + var_modulo +'/ajax/index.php',
				contentType:"application/json",
				data:"&nss="+$("#nss").val() +"&agregado="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					if(obj.length>0)
					{		
						if(obj[0].id>0)
						{															
							var data="&sys_section_"+var_modulo+"=write&sys_action_"+var_modulo+"=__clean_session&sys_id_"+var_modulo+"=" + obj[0].id;
							envio_var(data);							
						}					
					}	
				}
			});			
			
		});
	});	


    
    // ###########################################################################
