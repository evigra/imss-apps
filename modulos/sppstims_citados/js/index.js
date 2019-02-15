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

		sys_action="";
	}
	
	function valida_matricula(tipo, obj)
	{
		if(obj.length>0)
		{								
			$("#"+tipo+"_clave");
			$("#"+tipo+"_nombre").val(obj[0].nombre);
			if($("#"+tipo+"_puesto").length)			
				$("#"+tipo+"_puesto").val(obj[0].puesto);
			if($("#"+tipo+"_puesto_id").length)			
				$("#"+tipo+"_puesto_id").val(obj[0].puesto_id);
			if($("#"+tipo+"_horario").length)			
			{					
				$("input#auto_"+tipo+"_horario").val(obj[0].horario);
				$("input#"+tipo+"_horario").val(obj[0].horario);
			}	
			if($("#"+tipo+"_departamento").length)		$("#"+tipo+"_departamento").val(obj[0].departamento);
			if($("#"+tipo+"_departamento_id").length)	$("#"+tipo+"_departamento_id").val(obj[0].departamento_id);
			if($("#"+tipo+"_turno").length)				$("#"+tipo+"_turno").val(obj[0].turno);
			if($("#"+tipo+"_dependencia").length)		$("#"+tipo+"_dependencia").val(obj[0].dependencia);


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
		//$("img.module").hide();
		if($("#sys_section_sppstims_citados").val()=="write")
		{	
			reporte_ajax($("#trabajador_clave"));		
			//$("img#pdf.module").show();
			
		}	
		if($(".citas").length>0) 
		{
			$(".citas").click(function()
			{	
				var section=$("#sys_section_sppstims_citados").val();					
	
            	var data        =$(this).attr("data");               
				if(data!=undefined)
				{	
					var variables	=serializar_url(data);
				
					for(ivariables in variables)
					{
						var input="";
						if($("input#"+ivariables).length>0) {}
						else	
						{	
							input="<input id=\""+ivariables+"\" name=\""+ivariables+"\" type=\"hidden\">";						
							$("form").append(input);
						}			
						$("input#"+ivariables).val(variables[ivariables]);
					}					
				}	
				
				$("form")
					.attr({"target":"_blank"})
					.attr("action","&sys_action=print_pdf")
					.submit()
					.attr("action","")
					.removeAttr("target");
					
				$("#sys_section_sppstims_citados").val(section);					
	
	
			});			
		}		
		if($("#enviar_interconsulta").length>0) 
		{
			$("#enviar_interconsulta").click(function()
			{	
				var id=$("#especialidad").val();

				//var id=$(this).attr("id");													
				var section=$("#sys_section_sppstims_citados").val();					
				
				$("#sys_section_sppstims_citados").val("interconsulta");	
				$("#sys_action_sppstimss_citados").val("report_pdf");
				
				$("form")
					.attr({"target":"_blank"})
					.attr("action","&sys_action=print_pdf")
					.submit()
					.attr("action","")
					.removeAttr("target");
					
				$("#sys_section_sppstims_citados").val(section);					

			});			
		}

		if($("#especialidad").length>0) 
		{
			$("#especialidad").change(function()
			{					
				if($(this).val()=="ic_CIRUGIA GENERAL")									$("#motivo").val("");
				else if($(this).val()=="ic_OFTALMOLOGIA")								$("#motivo").val("DOTACION DE LENTES");
				else if($(this).val()=="ic_PROGRAMA DE ATENCION SOCIAL A LA SALUD")		$("#motivo").val("CONTROL ANUAL");
				else if($(this).val()=="ic_CLINICA DE MAMA")							$("#motivo").val("BI RADS ");
				else if($(this).val()=="ic_NEUMOLOGIA")							$("#motivo").val("VALORACION DE BRONQUITIS AGUDA");
				
				
				
				
				
				else											$("#motivo").val("");
				
			});			
		}	
		
		if($("#bot_laboratorio").length>0) 
		{
			$("#bot_laboratorio").click(function()
			{	
				var form_action=$("form").attr("action");
				$("form")
					.attr({"target":"_blank"})					                
					.attr("action","http://172.24.20.14/Historial.aspx?expediente="+$("#trabajador_nss").val()+"&mn=false")
					.attr("action","../modulos/sppstims_citados/ajax/laboratorio.php")
					.submit()
					.attr("action",form_action)
					.removeAttr("target");								
			});			
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
					url: '../modulos/personal/ajax/personal_calculo.php',					
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
				
			}	
			
		});	

			
    });
    
    // ###########################################################################
    // ######################### FUNCIONES #######################################
    // ###########################################################################
    
