	$(document).ready(function()
	{		
	
	
	
		if($(".abrir_checador").length>0) 
		{
			$(".abrir_checador")
			.button()
			.click(function()
			{				
			
				var campo="<form class=\"checador\" target=\"_blank\" name=\"myform\" action=\"\" method=\"post\">\
						<input type=\"hidden\"  name=\"username\" id=\"username\" value=\"administrator\">\
						<input value=\"123456\" type=\"hidden\"  name=\"userpwd\" id=\"userpwd\">\
					</form>\
				";
			
				if($("#username").length>0) {}
				else	
					$("body").append(campo);
				
				var ip=$(this).attr("ip");
								
				$("form.checador")
					.attr({"action":"http://"+ip+"/csl/menu"})					
					.submit();					
				window.setTimeout(function()
							{  				
								window.location=window.location;
							},50);						
			});			
		}	
	
		if($("#action_aprovar").length>0) 
		{
			$("#action_aprovar").click(function()
			{
				
				$.ajax(
				{				
					cache:false,
					dataType:"html",
					type: "POST",  
					url: '../modulos/personal_checador/ajax/index.php?id='+$("#sys_id_personal_checador").val(),
					success:  function(res)
					{											
						$("td#checadas").html(res);
					},		
				});
			});			
		}	
		if($("#bajar_checadas").length>0) 
		{
			$("#bajar_checadas").click(function()
			{
				var option_data={};
				option_data["inicio"]	=$("#inicio").val();
				option_data["fin"]		=$("#fin").val();
				option_data["ip"]		=$("#ip").val();
				
				for (i = 0; i < 50; i++) 
				{ 
					option_data["cont"]		=i;
					bajar(option_data);
				}
			});			
		}		

    });
	
	function bajar(option_data)
	{
		$.ajax(
		{				
			cache:		false,
			dataType:	"html",
			type:		"POST",  
			url:		"../modulos/personal_checador/ajax/index.php",
			data:		option_data,
			success:  	function(res)
			{											
				$("td#checadas").append(res);
			},		
		});
	}
