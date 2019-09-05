	function auto_lente_id(ui)
	{
		$("input#lente_id[name='anteojos_lente_id']").val(ui.item.clave);					
		$("input#auto_lente_id[name='anteojos_auto_lente_id']").val(ui.item.label);
		
		$("input#lente_costo[name='anteojos_lente_costo']").val(ui.item.num1);
	}	
	$(document).ready(function()
	{

	});	
		
		
