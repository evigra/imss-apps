	function crea_tabla(obj)
	{
		setTimeout(function()
		{  
			$("table.view_report_t1").append("<tr style='height:30px;' class='ui-widget-header'><td colspan='4' align='right' >SUBTOTALES</td>\
			<td id='subtotal_cuota_fija' align='right'></td>\
			<td id='subtotal_excedente' align='right'></td>\
			<td colspan='3'></td>\
			<td id='subtotal_cop' align='right'></td>\
			<td id='subtotal_actualizacion' align='right'></td>\
			<td id='subtotal_recargo' align='right'></td>\
			<td id='subtotal_gasto' align='right'></td>\
			<td id='subtotal' align='right'></td>\
			<tr>\
			<tr style='height:30px;' class='ui-widget-header'><td colspan='4' align='right' >TOTALES</td>\
			<td id='total_cuota_fija' align='right'></td>\
			<td id='total_excedente' align='right'></td>\
			<td colspan='3'></td>\
			<td id='total_cop' align='right'></td>\
			<td id='total_actualizacion' align='right'></td>\
			<td id='total_recargo' align='right'></td>\
			<td id='total_gasto' align='right'></td>\
			<td id='total' align='right'></td>\
			<tr>");
			
			asignar_valor("subtotal", obj["total"]);
			asignar_valor("subtotal_cuota_fija", obj["cuota"]);
			asignar_valor("subtotal_excedente", obj["excedente"]);
			asignar_valor("subtotal_cop", obj["cop"]);			
			asignar_valor("subtotal_actualizacion", obj["actualizacion"]);
			asignar_valor("subtotal_recargo", obj["recargo"]);
			asignar_valor("subtotal_gasto", obj["gasto"]);			
			
			asignar_valor("total_cop", obj["cop"]);
			asignar_valor("total_gasto", obj["gasto"]);
							
			var act	=parseFloat(obj["actualizacion"]) + parseFloat($("input#umas").val());			
			var rec	=parseFloat(obj["recargo"]) + parseFloat($("input#plazo").val()) + parseFloat($("input#extemporaneo").val());
			var tot	=parseFloat(obj["cop"]) + act + rec +  parseFloat(obj["gasto"]);
									
			asignar_valor("total_actualizacion", act);
			asignar_valor("total_recargo", rec);

			asignar_valor("total", tot);
			
		},1500);   
	}
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
				var obj = $.parseJSON( response);

				options_movimiento_ids["class_one"]				="AfiliacionCobranza_OI";
				options_movimiento_ids["class_field"]			="movimiento_ids";
				options_movimiento_ids["class_field_id"]		=obj["count"];
				options_movimiento_ids["class_id"]				=obj["count"];
				options_movimiento_ids["id"]					=obj["count"];
				options_movimiento_ids["object"]				=options_movimiento_ids["class_one"];
				options_movimiento_ids["class_many"]			=options_movimiento_ids["class_one"];
				options_movimiento_ids["class_section"]			="delete";
												
				many2one_post(options_movimiento_ids);
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
