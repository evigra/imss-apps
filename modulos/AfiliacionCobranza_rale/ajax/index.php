<?php
	require_once("../../../nucleo/sesion.php");
	
	$objeto				=new AfiliacionCobranza_rale();
	
	
	
	$option				=array();
	$option["where"]	=array("registro_patronal='{$objeto->sys_fields["registro_patronal"]["value"]}'");
	
	
				
	$data										= $objeto->__BROWSE($option);
	if(isset($data["data"]))
	{	
		$row=array();
		foreach($data["data"] as $row_data)
		{
			$row[]=array(
                "sys_filter_movimiento_ids"	=>"",
                "sys_order_movimiento_ids"	=>"",
                "sys_torder_movimiento_ids"	=>"",
                "sys_page_movimiento_ids"	=>"",
                "sys_row_movimiento_ids"	=>"",						
				#/*
				"credito"					=>$row_data["credito"],
				"periodo"					=>$row_data["periodo"],
				"td"						=>$row_data["td"],
				"cuota_fija"				=>$row_data["importe"],
				#/*
				"excedente"					=>"",
				"pres"						=>"",
				"riesgo_trabajo"			=>"",
				"invalidez_viudez"			=>"",
				"guarderia"					=>"",
				"total_cop"					=>"",
				"actualizacion"				=>"",
				"recargo"					=>"",
				"gastos"					=>"",
				"total"						=>"",
				#*/
				"sys_action" 				=>"__SAVE",
				"id"						=>"",
			);		
		}
		if(count($row)>0)
		{
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["inicio"]=0;
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"]=$row;
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["total"]=count($row);
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["active_id"]=count($row);
			echo count($row);
			#$objeto->__PRINT_R($_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]);
		}
	}	
?>





