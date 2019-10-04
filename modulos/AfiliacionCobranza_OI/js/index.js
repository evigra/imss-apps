	function movimientos(tipo)
	{
		momentoActual = new Date()
		ahora = "?hora=" + momentoActual.getHours() + momentoActual.getMinutes() +momentoActual.getSeconds()
		
		$.ajax({
			type: 'GET',
			url: '../modulos/AfiliacionCobranza_rale/ajax/index.php'+ahora,
			contentType:"application/json",
			data:"&tipo="+tipo+"&registro_patronal="+$("input#registro_patronal").val(),				
			success: function (response) 
			{
				many2one_post(options_movimiento_ids);
								
				var obj = $.parseJSON( response);

				setTimeout(function()
				{  

					$("table.view_report_t1").append("<tr style='height:30px;' class='ui-widget-header'><td colspan='4'>TOTALES</td>\
					<td id='total_cuota_fija' align='right'></td>\
					<td id='total_excedente' align='right'></td>\
					<td colspan='3'></td>\
					<td id='total_cop' align='right'></td>\
					<td colspan='3'></td>\
					<td id='total' align='right'></td>\
					<tr>");
					
					asignar_valor("total", obj["total"]);
					asignar_valor("total_cuota_fija", obj["cuota"]);
					asignar_valor("total_excedente", obj["excedente"]);
					asignar_valor("total_cop", obj["cop"]);
			
				},1500);   				

				//options_movimiento_ids["class_id"]		=response;
				//options_movimiento_ids["class_section"]	="delete";
								
			}
		});	
	}
	function asignar_valor(obj, val)
	{
		$("input#"+obj+".AfiliacionCobranza_OI").val(val);
		$("td#"+obj).html(val);
	}			
	
	function auto_registro_patronal(ui)
	{
		$("input#registro_patronal").val(ui.item.clave);
		$("input#auto_registro_patronal").val(ui.item.label);
		$("input#patron").val(ui.item.nombre);				
	}			

	$(document).ready(function()
	{		
		$("#condonacion").click(function(){
			movimientos("condonacion");
		});
		
		$("#orden_ingreso").click(function(){
			movimientos("oi");
		});
		
	});		
