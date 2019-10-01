	function auto_registro_patronal(ui)
	{
		$("input#registro_patronal").val(ui.item.clave);
		$("input#auto_registro_patronal").val(ui.item.label);
		$("input#patron").val(ui.item.nombre);				

		momentoActual = new Date()
		ahora = "?hora=" + momentoActual.getHours() + momentoActual.getMinutes() +momentoActual.getSeconds()
		
		$.ajax({
			type: 'GET',
			url: '../modulos/AfiliacionCobranza_rale/ajax/index.php'+ahora,
			contentType:"application/json",
			data:"&registro_patronal="+ui.item.clave,				
			success: function (response) 
			{
				//options_movimiento_ids["class_id"]		=response;
				//options_movimiento_ids["class_section"]	="delete";
				many2one_post(options_movimiento_ids);
				
			}
		});
	}			

	$(document).ready(function()
	{		


	});		
