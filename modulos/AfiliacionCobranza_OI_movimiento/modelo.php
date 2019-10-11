<?php
	class AfiliacionCobranza_OI_movimiento extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		public $mod_menu=array();
		public $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"oi_id"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			),
			"credito"	    =>array(
			    "title"             => "CREDITO",
			    "type"              => "input",
			),
			"periodo"	    =>array(
			    "title"             => "PERIODO",				
			    "type"              => "input",			
			),	
			"td"	    =>array(
			    "title"             => "TD",
			    "type"              => "input",
			),
			
			"cuota_fija"	    =>array(
			    "title"             => "CUOTA FIJA",
			    "type"              => "input",
			),			
			"excedente"	    =>array(
			    "title"             => "EXCEDENTE",
			    "type"              => "input",
			),					
			"pres"	    =>array(
			    "title"             => "PRES",
			    "type"              => "input",
			),
			
			"riesgo_trabajo"	    =>array(
			    "title"             => "RIESGO DE TRABAJO",
			    "type"              => "input",
			),
			"invalidez_viudez"	    =>array(
			    "title"             => "INVALIDEZ VIUDEZ",
			    "type"              => "input",
			),
			"guarderia"	    =>array(
			    "title"             => "GUARDERIA",
			    "type"              => "input",
			),
			"total_cop"	    =>array(
			    "title"             => "TOTAL COP",
			    "type"              => "input",
			),
			"actualizacion"	    =>array(
			    "title"             => "ACTUALIZACION",
			    "type"              => "input",
			),
			"recargo"	    =>array(
			    "title"             => "RECARGO",
			    "type"              => "input",
			),
			"gastos"	    =>array(
			    "title"             => "GASTOS",
			    "type"              => "input",
			),
			"total"	    =>array(
			    "title"             => "TOTAL",
			    "type"              => "input",
			),
#*/			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{   
    		if(isset($datas["class_field_id"]))
    		{ 
				$index=$datas["class_field_id"];    		
				$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"][$index]=$datas["row"];

				#$this->__PRINT_R($datas);
				if(!isset($datas["row"]["total_cop"]) OR $datas["row"]["total_cop"]=="")			$datas["row"]["total_cop"]=0;
				if(!isset($datas["row"]["actualizacion"]) OR $datas["row"]["actualizacion"]=="")	$datas["row"]["actualizacion"]=0;
				if(!isset($datas["row"]["recargo"]) OR $datas["row"]["recargo"]=="")				$datas["row"]["recargo"]=0;
				if(!isset($datas["row"]["gastos"]) OR $datas["row"]["gastos"]=="")					$datas["row"]["gastos"]=0;
		
		
					$datas["row"]["total"]		=$datas["row"]["total_cop"] + $datas["row"]["actualizacion"] + $datas["row"]["recargo"] + $datas["row"]["gastos"];  
			    
			    foreach($_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"] as $index => $row)
			    {
					@$total_cuota			+=@$row["cuota_fija"];
					@$total_excedente		+=@$row["excedente"];
					@$total_cop				+=@$row["total_cop"];

					@$total_actualizacion	+=@$row["actualizacion"];
					@$total_recargo			+=@$row["recargo"];
					@$total_gasto			+=@$row["gastos"];					

					if(!isset($row["total_cop"]) OR $row["total_cop"]=="")			$row["total_cop"]=0;
					if(!isset($row["actualizacion"]) OR $row["actualizacion"]=="")	$row["actualizacion"]=0;
					if(!isset($row["recargo"]) OR $row["recargo"]=="")				$row["recargo"]=0;
					if(!isset($row["gastos"]) OR $row["gastos"]=="")				$row["gastos"]=0;

					$row["total"]			=@$row["total_cop"]+@$row["actualizacion"]+@$row["recargo"]+@$row["gastos"];

					@$total_total			+=@$row["total"];
					
					$_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"][$index]=$row;
			    }    	    
				
				@$return=array(
					"total"			=>(round(($total_total)*100,2))/100,
					"cuota"			=>(round(($total_cuota)*100,2))/100,
					"excedente"		=>(round(($total_excedente)*100,2))/100,
					"cop"			=>(round(($total_cop)*100,2))/100,

					"actualizacion"	=>@$total_actualizacion,
					"recargo"		=>@$total_recargo,
					"gasto"			=>@$total_gasto,
					"count"			=>count($row),
				);
				/*
				$option["js"]		="
					alert('aaa');
					asignar($.parseJSON(". json_encode($return) ."));
				";
	*/
			}			

    	
    	
    	    $return=parent::__SAVE($datas,$option);
    	    
						
    	    
    	    return $return;
		}
		public function __BROWSE($option=array())
    	{	
    		if(!is_array($option))				$option					=array();
    		if(!isset($option["where"]))		$option["where"]		=array();    		
    		
    		#if(!isset($option["from"]))			$option["from"]			="contrato_detalle";    		
    		
    		if(isset($this->module))
	    		$option["where"][]				="contrato_detalle.modulo='{$this->module}'";
    		
			$return =parent::__BROWSE($option);    				
			return $return;			
		}						
	}
?>
