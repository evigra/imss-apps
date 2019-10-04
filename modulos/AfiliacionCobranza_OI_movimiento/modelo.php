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
    	    $return=parent::__SAVE($datas,$option);
    	    
    	    foreach($_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]["data"] as $row)
    	    {
				@$total_total+=@$row["total"];
				@$total_cuota+=@$row["cuota_fija"];
				@$total_excedente+=@$row["excedente"];
				@$total_cop+=@$row["total_cop"];
				@$total_actualizacion+=@$row["actualizacion"];
				@$total_recargo+=@$row["recargo"];
				@$total_gasto+=@$row["gastos"];
    	    }
    	    
    	    $return["js"]="alert('a');";
    	    
    	    #$this->__PRINT_R($_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]);
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
