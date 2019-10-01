			
	$(document).ready(function()
	{		
		if($("#procesar").length>0) 
		{		
			$("#procesar").click(function(){
				
				$.ajax(
				{				
					cache:			false,				
					type: 			"GET",  				
					url: 			"../modulos/personal_ausentismo/ajax/index.php",					
					success:  function(res)
					{	
						$("#script").html(res);						
					},		
				});	
				window.location="../personal_cobertura/"

				
			});
		}	
			
    });
