<?php
	require_once("../../../nucleo/sesion.php");
	
	$objeto				=new AfiliacionCobranza_rale();	
	
	$objeto->__PRINT_R($_REQUEST);	
	
	
	$option				=array();
	$option["where"]	=array();	
	$option["where"][]	="registro_patronal='{$objeto->sys_fields["registro_patronal"]["value"]}'";
	$option["where"][]	="td in ('80','81','82')";
				
	$data										= $objeto->__BROWSE($option);
	if(isset($data["data"]))
	{	
		$row=array();
		foreach($data["data"] as $row_data)
		{
			$importe=str_replace(",", "", $row_data["importe"]); 

			if($_REQUEST["tipo"]=="condonacion")
			{
				$cuota_fija	=$importe;
				$excedente	=(floor(($importe-$importe*0.1)*100))/100;
				$total		=(floor(($importe-$importe*0.9)*100))/100; 
			}
			else
			{
				$cuota_fija	=$importe;
				$excedente	=0;
				$total		=$importe;
			}
		
			$row[]=array(
                "sys_filter_movimiento_ids"	=>"",
                "sys_order_movimiento_ids"	=>"",
                "sys_torder_movimiento_ids"	=>"",
                "sys_page_movimiento_ids"	=>"",
                "sys_row_movimiento_ids"	=>"",						
				"credito"					=>$row_data["credito"],
				"periodo"					=>$row_data["periodo"],
				"td"						=>$row_data["td"],
				"cuota_fija"				=>$cuota_fija,
				"excedente"					=>$excedente,
				"pres"						=>"",
				"riesgo_trabajo"			=>"",
				"invalidez_viudez"			=>"",
				"guarderia"					=>"",
				"total_cop"					=>"",
				"actualizacion"				=>"",
				"recargo"					=>"",
				"gastos"					=>"",
				"total"						=>$total,
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
		}
	}	
?>





