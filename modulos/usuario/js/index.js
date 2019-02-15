
	$(document).ready(function()
	{	
		$("#clave").focusout(function() 
		{		
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (response) 
				{
					var obj 		= $.parseJSON( response);
					var nombre		=obj[0].nombre;					
					var a_nombre	=nombre.split("/");
					
					var pass="";
					for(an in a_nombre)
					{
						var separado 	=a_nombre[an];
						var a_separado	=separado.split(" ");
						
						for(as in a_separado)
						{
							var palabras =a_separado[as];							
							//pass		=pass + palabras.splice(0, 1); 
							pass		=pass + palabras[0];
						}						
					}					
					//alert(pass);
					$("#nombre").val(obj[0].nombre);
					$("#password").val(pass);	
				}
			});
		});	

    });
    

