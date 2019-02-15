	function goce(object)
	{		
		if($("#estatus").val()!="")
		{
			$("#block_nota").show();
		}	
		else
		{
			$("#block_nota").hide();
		}
		if($(object).is(':checked')) { 
			$("#block_no_goce").hide();
			$("#block_goce").show();
			
		} else {  
			$("#block_goce").hide();
			$("#block_no_goce").show();
		}  	
	}
	function fraccion(objeto)
	{
		var option="";
		if($(objeto).val()==65)
		{
			$("#fraccion option[value='XVI']").hide();
			$("#fraccion option[value!='XVI']").show();
			$("#fraccion option[value='']").show();	
		}			
		else if($(objeto).val()==63)
		{
			$("#fraccion option[value!='XVI']").hide();	
			$("#fraccion option[value='XVI']").show();	
			$("#fraccion option[value='']").show();	
		}
		//$("#fraccion").html(option);		
	}
	function matricula_trabajador(objecto)
	{
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(objecto).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					valida_matricula("trabajador", obj);
				}
			});
			
			$.ajax({
				type: 'GET',
				url: '../modulos/personal_licencia/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(objecto).val(),				
				success: function (res) 
				{
					$("div#REPORT").html(res);
				}
			});
		
	}
	$(document).ready(function()
	{		
		goce($("#goce"));
		fraccion($("#articulo"));
		matricula_trabajador($("#trabajador_clave"));
		
		
		
		
		
		if($("#action_aprovar").length>0) 
		{
			$("#action_aprovar").click(function()
			{
				$("#estatus").val("APROVADO");
				$("#sys_action_personal_licencia").val("__SAVE");				
				$("form").submit();					
			});			
		}	
		if($("#articulo").length>0) 
		{
			$("#articulo").change(function()
			{
				$("#fraccion").val("");		
				$("div#nota_fraccion").html("");
				fraccion($(this));
			});						
		}		
		if($(".fraccion").length>0) 
		{
			$(".fraccion").change(function()
			{								
				var comentario="";
				$("#inciso").show();	
				if($("#articulo").val()==65 && $(this).val()=="I") 		comentario	="Las causas de fuerza mayor que darán derecho para la concesión de tres días";
				if($("#articulo").val()==65 && $(this).val()=="II") 	comentario	="Las causas de fuerza mayor que darán derecho para la concesión de uno a tres días laborables del trabajador";
				if($("#articulo").val()==63 && $(this).val()=="XVI") 	
				{	
					$("#inciso").val("");	
					$("#inciso").hide();	
					comentario	="Las causas de fuerza mayor que darán derecho a permisos económicos";
				}	
				
				comentario	="<b>Fraccion "+$(this).val()+"</b><br>"+comentario;
	
				$("div#nota_fraccion").html(comentario);
				$("div#nota_inciso").html("");
			});						
		}
		if($("#inciso").length>0) 
		{
			$("#inciso").change(function()
			{								
				var comentario="";
				
				if($(this).val()=="A") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR FALLECIMIENTO DE PADRES, HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO";
					if($("#fraccion").val()=="II") 	comentario	="POR INTERVENCIONES QUIRÚRGICAS A PADRES O HERMANOS";
				}	
				if($(this).val()=="B") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR ACCIDENTES GRAVES A PADRES, HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO;";
					if($("#fraccion").val()=="II") 	comentario	="-DEROGADO-";
				}	
				if($(this).val()=="C") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR ACCIDENTE GRAVE OCURRIDO A PADRES, HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO; ACAECIDO EN POBLACIÓN O LUGAR AJENO A LA RESIDENCIA DEL TRABAJADOR";
					if($("#fraccion").val()=="II") 	comentario	="POR FALLECIMIENTO DE HERMANOS;";
				}	
				if($(this).val()=="D") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR PRIVACIÓN DE LA LIBERTAD DE PADRES, HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO;";
					if($("#fraccion").val()=="II") 	comentario	="POR ACCIDENTES GRAVES DE HERMANOS;";
				}	
				if($(this).val()=="E") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR MATRIMONIO DEL TRABAJADOR;";
					if($("#fraccion").val()=="II") 	comentario	="POR PRIVACIÓN DE LA LIBERTAD DE HERMANOS";
				}	
				if($(this).val()=="F") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="EN CASO DE CUALQUIER SINIESTRO QUE AFECTE EL HOGAR DEL TRABAJADOR;";
					if($("#fraccion").val()=="II") 	comentario	="POR ASISTIR EL TRABAJADOR A DILIGENCIAS JUDICIALES, ASÍ COMO DE LA SECRETARÍA DE LA FUNCIÓN PÚBLICA O EL ÓRGANO INTERNO DE CONTROL EN EL INSTITUTO, PARA LAS QUE HAYA RECIBIDO CITA;";
				}	
				if($(this).val()=="G") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR TRASLADO AUTORIZADO POR LA OFICINA DE TRASLADO DE ENFERMOS FORÁNEOS, A POBLACIÓN DISTINTA A LA DE SU DOMICILIO PARA ATENCIÓN MÉDICA DE PADRES, HIJOS, CÓNYUGE Y DEL PROPIO TRABAJADOR;";
					if($("#fraccion").val()=="II") 	comentario	="POR SUSPENSIÓN DE SERVICIOS DE TRANSPORTES QUE IMPIDAN EL TRASLADO DEL TRABAJADOR A SU CENTRO DE LABORES;";
				}	
				if($(this).val()=="H") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR DESAPARICIÓN DE HIJOS, PADRES, CÓNYUGE QUE VIVAN CON EL TRABAJADOR;";
					if($("#fraccion").val()=="II") 	comentario	="POR MATRIMONIO DE HIJOS;";
				}	
				if($(this).val()=="I") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR ENFERMEDAD GRAVE DE HIJOS MENORES DE 16 AÑOS DEBIDAMENTE ACREDITADA;";
					if($("#fraccion").val()=="II") 	comentario	="POR CAMBIO DE DOMICILIO DEL TRABAJADOR;";
				}	
				if($(this).val()=="J") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR INTERNAMIENTO EN INSTALACIÓN HOSPITALARIA POR ENFERMEDAD DE PADRES, HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO;";
					if($("#fraccion").val()=="II") 	comentario	="POR DESAPARICIÓN DE HERMANOS;";
				}	
				if($(this).val()=="K") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="POR INTERVENCIONES QUIRÚRGICAS A HIJOS, CÓNYUGE O CONCUBINA O CONCUBINARIO.";
					if($("#fraccion").val()=="II") 	comentario	="POR EXAMEN PROFESIONAL DEL TRABAJADOR;";
				}	
				if($(this).val()=="L") 		
				{	
					if($("#fraccion").val()=="I") 	comentario	="";
					if($("#fraccion").val()=="II") 	comentario	="CUANDO EL O LOS HIJOS NO SEAN RECIBIDOS POR ENFERMEDAD EN GUARDERÍA DEL INSTITUTO.";
				}	
				
				$("#observacion").val(comentario);
				
				comentario	="<br><b>Inciso "+$(this).val()+"</b><br>"+comentario;
				
				$("div#nota_inciso").html(comentario);
				
				
				
			});						
		}
		
		if($("#goce").length>0) 
		{
			$("#goce").change(function()
			{
				goce($(this));
			});			
		}		
		
		if($("#action_cancelar").length>0) 
		{
			$("#action_cancelar").click(function()
			{
				$("#estatus").val("CANCELADO");
				$("#sys_action_personal_licencia").val("__SAVE");				
				$("form").submit();									
			});			
		}		
		if($("#action_incumplir").length>0) 
		{
			
			$("#action_incumplir").click(function()
			{				
				$("#estatus").val("INCUMPLIDO");
				$("#sys_action_personal_licencia").val("__SAVE");				
				$("form").submit();									
			});			
		}		

		$("#trabajador_clave").focusout(function() 
		{		
			matricula_trabajador($(this));
			
		});	

		$("#sustituto_clave").focusout(function() 
		{		
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					valida_matricula("sustituto", obj);
				}
			});
		});	
    });
    
    // ###########################################################################
    // ######################### FUNCIONES #######################################
    // ###########################################################################
    
	function valida_matricula(tipo, obj)
	{
		if(obj.length>0)
		{					
			$("font#trabajador").html(obj[0].nombre);
			$("#"+tipo+"_nombre").val(obj[0].nombre);
			if($("#"+tipo+"_puesto").length)			$("#"+tipo+"_puesto").val(obj[0].puesto);
			if($("#"+tipo+"_horario").length)			$("#"+tipo+"_horario").val(obj[0].horario);
			if($("#"+tipo+"_departamento").length)		$("#"+tipo+"_departamento").val(obj[0].departamento);
			if($("#"+tipo+"_departamento_id").length)	$("#"+tipo+"_departamento_id").val(obj[0].departamento_id);
		}	
		else
		{
			$("#"+tipo+"_nombre").val("");
			if($("#"+tipo+"_puesto").length)	$("#"+tipo+"_puesto").val("");
			if($("#"+tipo+"_horario").length)	$("#"+tipo+"_horario").val("");		
		}		
	}
    
