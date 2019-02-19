	$(document).ready(function()
	{			
	    if($("#sobres_patrones").length>0)
	    {
			$("#sobres_patrones").click(function()
			{
				generacion_var("&sys_action=print_pdf&sys_section_seet_asegurado=carta_patron");
				
				$("form")
					.attr({"target":"_blank"})					
					.submit()					
					.removeAttr("target");
					
				$("#sys_section_" + obj).val(section);									
				$("#sys_action").val("");													
				
				
				
				//&sys_action=print_pdf&sys_section_seet_asegurado=carta_patron&sys_id_seet_asegurado={id}	
				$("#sys_section_seet_asegurado").val("sobres_patrones");				
				$("#sys_action").val("print_pdf");				
				$("form").submit();				
		    });
	    }	    

		if($("#action_dev").length>0)
	    {
			$("#action_dev").click(function()
			{
				$("#sys_section_seet_asegurado").val("__SAVE");				
				$("form").submit();				
		    });
	    }	    
	    if($("#action_si_trabajo").length>0)
	    {
			$("#action_si_trabajo").click(function(){$("#texto_calificacion").val("SI DE TRABAJO");	 });
	    }	
	    if($("#action_no_trabajo").length>0)
	    {
			$("#action_no_trabajo").click(function(){$("#texto_calificacion").val("NO DE TRABAJO");	 });
	    }	
	    if($("#action_si_trayecto").length>0)
	    {
			$("#action_si_trayecto").click(function(){$("#texto_calificacion").val("SI DE TRAYECTO");	 });
	    }	
		
	    if($("#action_no_trayecto").length>0)
	    {
			$("#action_no_trayecto").click(function(){$("#texto_calificacion").val("NO DE TRAYECTO");	 });
	    }	

		if($("#action_cancelar").length>0) 
		{
			$("#action_cancelar").click(function()
			{
				$("#estatus").val("CANCELADO");
				$("form").submit();									
			});			
		}		
			
		$("#nss").focusout(function() 		
		{		
			
			$.ajax({
				type: 'GET',
				url: '../modulos/seet_asegurado/ajax/index.php',
				contentType:"application/json",
				data:"&nss="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					if(obj.length>0)
					{		
						if(obj[0].id>0)
						{															
							var data="&sys_section_seet_asegurado=write&sys_action_seet_asegurado=__clean_session&sys_id_seet_asegurado=" + obj[0].id;
							envio_var(data);
							
							/*
							$(".seet_asegurado").val("");
							$("#sys_id_seet_asegurado").val(obj[0].id);
							$("#sys_id_seet_asegurado").val(1);
							$("#sys_section_seet_asegurado").val("write");
							$("#sys_action_seet_asegurado").val("");
							
							
							//$("#sys_filter_seet_asegurado_nss").val(obj[0].nss);
							//$("#sys_section_seet_asegurado").val("");
							
							
							
							/*
							$("#sys_filter_seet_asegurado").val("");
							$("#sys_rows_seet_asegurado").val("50");
							$("#sys_order_seet_asegurado").val("");
							$("#sys_torder_seet_asegurado").val("");
							$("#sys_page_seet_asegurado").val("1");
							$("#sys_row_seet_asegurado").val("50");
							*/
							
							
							
							//$("form").submit();
						}					
					}	
				}
			});			
			
		});
		$("#registro_patronal").focusout(function() 		
		{					
			$.ajax({
				type: 'GET',
				url: '../modulos/patron/ajax/index.php',
				contentType:"application/json",
				data:"&rp_rale="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					if(obj.length>0)
					{		
							$("#patron").val(obj[0].nombre);
							$("#patron_locacion").val(obj[0].mpio_edo);
							$("#patron_domicilio").val(obj[0].domicilio);

					}	
				}
			});			
			
		});
	});	
	
	function valida_matricula(tipo, obj,)
	{
	}	
	
	function bases(obj, grupo)
	{
	}		
    
    // ###########################################################################
