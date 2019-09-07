	function auto_lente_id(ui)
	{
		$("input#lente_id[name='anteojos_lente_id']").val(ui.item.clave);					
		$("input#auto_lente_id[name='anteojos_auto_lente_id']").val(ui.item.label);
		
		$("input#lente_costo[name='anteojos_lente_costo']").val(ui.item.num1);
	}			
	function valida_matricula(tipo, obj)
	{
		if(obj.length>0)
		{					
			$("#"+tipo+"_nombre").val(obj[0].nombre);
			if($("#"+tipo+"_puesto").length)	$("#"+tipo+"_puesto").val(obj[0].puesto);
			if($("#"+tipo+"_puesto_id").length)	$("#"+tipo+"_puesto").val(obj[0].puesto_id);
			if($("#"+tipo+"_horario").length)	$("#"+tipo+"_horario").val(obj[0].horario);
			if($("#"+tipo+"_departamento").length)	$("#"+tipo+"_departamento").val(obj[0].departamento);
			if($("#"+tipo+"_departamento_id").length)	$("#"+tipo+"_departamento_id").val(obj[0].departamento_id);
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
		$("#trabajador_clave").focusout(function() 
		{		
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					valida_matricula("trabajador", obj);
				}
			});
			
		});	
});		
		
