
	$(document).ready(function()
	{
		$("#action_process").click(function(){
			
			$("#sys_action_personal_cobertura").val("__SAVE_PROCESS");
			$("form").submit();
			
		});
		$("input.valida").focusout(function(){
			var dias=$(this).attr("dias");
			var dias_solicitados=$(this).val();
			
			if(dias_solicitados>=0 && dias_solicitados<=dias)
				$(this).attr({"style":""});	
			else	
				$(this).attr({"style":"background-color:red;"});
			
			
		});
    });
