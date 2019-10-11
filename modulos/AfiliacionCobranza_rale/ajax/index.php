<?php
	require_once("../../../nucleo/sesion.php");	
	$objeto				=new AfiliacionCobranza_rale();	
	
	$option				=array();
	$option["where"]	=array();	
	$option["where"][]	="registro_patronal='{$objeto->sys_fields["registro_patronal"]["value"]}'";
	$option["where"][]	="td in ('80','81','82')";
				
	$data										= $objeto->__BROWSE($option);
	if(isset($data["data"]))
	{	
		$total_total		=0;
		$total_cuota		=0;
		$total_excedente	=0;
		$total_cop			=0;
		$total_actualizacion=0;
		$total_recargo		=0;
		$total_gasto		=0;

		$row				=array();

		foreach($data["data"] as $row_data)
		{
			$importe=str_replace(",", "", $row_data["importe"]); 

			if($_REQUEST["tipo"]=="condonacion")
			{
				$cuota_fija	=$importe;
				$excedente	=(floor(($importe-$importe*0.1)*100))/100;
				$total		=(floor(($importe-$importe*0.9)*100))/100;
				$cop		=(floor(($importe-$importe*0.9)*100))/100;  
			}
			else
			{
				$cuota_fija	=$importe;
				$excedente	=0;
				$total		=$importe;
				$cop		=$importe;
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
				"total_cop"					=>$cop,
				"actualizacion"				=>"",
				"recargo"					=>"",
				"gastos"					=>"",
				"total"						=>$total,
				"sys_action" 				=>"__SAVE",
				"id"						=>"",
			);
			$total_total+=$total;
			$total_cuota+=$cuota_fija;
			$total_excedente+=$excedente;
			$total_cop+=$cop;
			/*
			@$total_actualizacion+=@$row_data["actualizacion"];
			@$total_recargo+=@$row_data["recargo"];
			@$total_gasto+=@$row_data["gastos"];
			*/
		}
		if(count($row)>0)
		{
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["inicio"]		=0;
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"]		=$row;
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["total"]		=count($row);
			$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["active_id"]	=count($row);
			
			#$excedente	=(floor(($total_cop-$total_cop*0.1)*100))/100;
			
			@$return=array(
				"total"			=>(round(($total_total)*100,2))/100,
				"cuota"			=>(round(($total_cuota)*100,2))/100,
				"excedente"		=>(round(($total_excedente)*100,2))/100,
				"cop"			=>(round(($total_cop)*100,2))/100,

				"actualizacion"	=>0,
				"recargo"		=>0,
				"gasto"			=>0,
				"count"			=>count($row),
			);	
			echo json_encode($return);			
		}
	}	
?>





