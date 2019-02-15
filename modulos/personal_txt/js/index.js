	var mensaje="";
	var obj;
	function auto_trabajador_horario(ui)
	{		
		
		$("input#trabajador_horario").val(ui.item.label);					
		$("input#auto_trabajador_horario").val(ui.item.label);		
	}	
	function auto_sustituto_horario(ui)
	{		
		
		$("input#sustituto_horario").val(ui.item.label);					
		$("input#auto_sustituto_horario").val(ui.item.label);		
	}	
	function submit_personal_txt()
	{		
		var retorno=true;
		var mostrar=1;
		
		
		
		/*
		$("input[type='text'][system!='yes']").each(function()
		{				
			alert($(this).attr("id"));
			if($(this).val()==undefined || $(this).val()=="") 	
			{	
				alert($(this).attr("id"));
				$(this).addClass("formulario_alert");
				$(this).removeClass("formulario");
				mostrar=0;					
			}
			else
			{	
				$(this).addClass("formulario");
				$(this).removeClass("formulario_alert");				
			}		
		});						
		*/
		if(mostrar==0) 	retorno=false; 
		else			retorno=true; 	
		
		valida_turno();
		if(retorno==true)	
		{
			$("#trabajador_horario, #trabajador_turno, #sustituto_horario, #sustituto_turno")
				.removeAttr("readonly")
				.removeAttr("disabled");				
		}	
		return retorno;
	}	
	function reporte_ajax(obj)
	{
		$.ajax({
			type: 'GET',
			url: '../modulos/personal_txt/ajax/index.php',
			contentType:"application/json",
			data:"&matricula="+$(obj).val()+"&sys_action="+sys_action,				
			success: function (res) 
			{
				$("div#REPORT").html(res);
				sys_action="";
			}
		});
		sys_action="";
	}
	function valida_turno()
	{
		if($("#trabajador_turno").val() == $("#sustituto_turno").val())
		{
			$("input#trabajador_horario, input#sustituto_horario")
			.addClass("formulario_alert")
			.removeClass("formulario");	
			mensaje+=" > Mismo turno";
		}	
		else
		{
			$("input#trabajador_horario, input#sustituto_horario")
			.addClass("formulario")
			.removeClass("formulario_alert");	
		}		
	}
	
    
	function valida_matricula(tipo, obj)
	{
		if(obj.length>0)
		{								
			$("#"+tipo+"_clave")
				.addClass("formulario")
				.removeClass("formulario_alert");				
			$("#"+tipo+"_nombre").val(obj[0].nombre)
				.addClass("formulario")
				.removeClass("formulario_alert");	
			if($("#"+tipo+"_puesto").length)			
				$("#"+tipo+"_puesto").val(obj[0].puesto)
				.addClass("formulario")
				.removeClass("formulario_alert");	
			if($("#"+tipo+"_puesto_id").length)			$("#"+tipo+"_puesto_id").val(obj[0].puesto_id);
			if($("#"+tipo+"_horario").length)			
			{					
				$("input#auto_"+tipo+"_horario").val(obj[0].horario);
				$("input#"+tipo+"_horario").val(obj[0].horario)
				.addClass("formulario")
				.removeClass("formulario_alert");	
			}	
			if($("#"+tipo+"_departamento").length)		$("#"+tipo+"_departamento").val(obj[0].departamento);
			if($("#"+tipo+"_departamento_id").length)	$("#"+tipo+"_departamento_id").val(obj[0].departamento_id);
			if($("#"+tipo+"_turno").length)				$("#"+tipo+"_turno").val(obj[0].turno);

			valida_turno();
	
			
		}	
		else
		{
			$("#"+tipo+"_nombre").val("");
			if($("#"+tipo+"_puesto").length)	$("#"+tipo+"_puesto").val("");
			if($("#"+tipo+"_horario").length)	$("#"+tipo+"_horario").val("");		
		}		
	}

	$(document).ready(function()
	{		
		$("img.module").hide();
		if($("#sys_section_personal_txt").val()=="write")
		{	
			reporte_ajax($("#trabajador_clave"));		
			$("img#pdf.module").show();
			
		}	
		
		if($("#action_aprovar").length>0) 
		{
			$("#action_aprovar").click(function()
			{
				$("#estatus").val("APROVADO");
				$("#sys_action_personal_txt").val("__SAVE");				
				$("form").submit();					
			});			
		}	
		if($("#action_cancelar").length>0) 
		{
			$("#action_cancelar").click(function()
			{
				$("#estatus").val("CANCELADO");
				$("#sys_action_personal_txt").val("__SAVE");				
				$("form").submit();									
			});			
		}		
		if($("#action_incumplir").length>0) 
		{
			
			$("#action_incumplir").click(function()
			{				
				$("#estatus").val("INCUMPLIDO");
				$("#sys_action_personal_txt").val("__SAVE");				
				$("form").submit();									
			});			
		}		

		$("#trabajador_clave").focusout(function() 
		{	
			if($(this).val()!="")
			{
				$.ajax({
					type: 'GET',
					url: '../modulos/personal/ajax/index.php',
					contentType:"application/json",
					data:"&matricula="+$(this).val(),				
					success: function (response) 
					{
						obj = $.parseJSON( response);				
						
						if(obj[0].turno==null || obj[0].turno==4)			
						{	
							$("#trabajador_turno")
								.removeAttr("disabled")
								.focus();
						}	
						else
						{							
							$("#trabajador_turno").attr({"disabled":"disabled"});	
							$("#sustituto_clave").focus();								
						}
						valida_matricula("trabajador", obj);						
					}
				});
				reporte_ajax(this);
			}	
			
		});	
		$("#trabajador_turno").change(function() 
		{		
			
			if((obj[0].trabajador_horario==null || obj[0].trabajador_horario==undefined) && $(this).val()!=4)
			{
				$("#auto_trabajador_horario")					
					.removeAttr("readonly");			}	
			else
			{				
				$("#auto_trabajador_horario")
					.attr({"readonly":"readonly"});		
			}	
				
		});		

		$("#sustituto_turno").change(function() 
		{					
			if((obj[0].trabajador_horario==null || obj[0].trabajador_horario==undefined) && $(this).val()!=4)
			{			
				$("#auto_sustituto_horario")					
					.removeAttr("readonly");			}	
			else
			{				
				$("#auto_sustituto_horario")
					.attr({"readonly":"readonly"});		
			}	
				
		});		

		$("#sustituto_clave").focusout(function() 
		{	
			if($(this).val()!="")
			{

				$.ajax({
					type: 'GET',
					url: '../modulos/personal/ajax/index.php',
					contentType:"application/json",
					data:"&matricula="+$(this).val(),				
					success: function (response) 
					{
						obj = $.parseJSON( response);				
						
						if(obj[0].turno==null || obj[0].turno==4)			$("#sustituto_turno").removeAttr("disabled");
						else												$("#sustituto_turno").attr({"disabled":"disabled"});	
						
						valida_matricula("sustituto", obj);						
						
						
						
						if($("#trabajador_turno").val()==$("#sustituto_turno").val())
						{	
							var mensaje="Favor de verificar el turno";
					
							$("#message").html(mensaje);
							$("#message").dialog({
								show: {
									effect: "shake",
									duration: 750
								},		    			    	
								width:"350",
								modal: true,
							});	

							setTimeout(function() 
							{
								$("#message").dialog("close")
							}, 2500 );
						}
						
					}
				});
			}
			
			
		});
			
    });
    
    // ###########################################################################
    // ######################### FUNCIONES #######################################
    // ###########################################################################
    
