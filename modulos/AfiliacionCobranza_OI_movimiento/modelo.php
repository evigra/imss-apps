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
			    "title"             => "Credito",
			    "type"              => "input",
			),
			"periodo"	    =>array(
			    "title"             => "Periodo",				
			    "type"              => "input",			
			),	
			"td"	    =>array(
			    "title"             => "TD",
			    "type"              => "input",
			),
			
			"cuota_fija"	    =>array(
			    "title"             => "Cuota Fija",
			    "type"              => "input",
			),			
			"excedente"	    =>array(
			    "title"             => "Excedente",
			    "type"              => "input",
			),					
			"pres"	    =>array(
			    "title"             => "PRES",
			    "type"              => "input",
			),
			
			"riesgo_trabajo"	    =>array(
			    "title"             => "Riesgo de Trabajo",
			    "type"              => "input",
			),
			"invalidez_viudez"	    =>array(
			    "title"             => "Invalidez Viudez",
			    "type"              => "input",
			),
			"guarderia"	    =>array(
			    "title"             => "Guarderia",
			    "type"              => "input",
			),
			"total_cop"	    =>array(
			    "title"             => "Total COP",
			    "type"              => "input",
			),
			"actualizacion"	    =>array(
			    "title"             => "Actualizacion",
			    "type"              => "input",
			),
			"recargo"	    =>array(
			    "title"             => "Recargo",
			    "type"              => "input",
			),
			"gastos"	    =>array(
			    "title"             => "Gastos",
			    "type"              => "input",
			),
			"total"	    =>array(
			    "title"             => "Total",
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
    	    
    	    #$this->__PRINT_R($_SESSION["SAVE"]["AfiliacionCobranza_OI"]["movimiento_ids"]);
    	    return $return;

		}
		/*				   		
		public function autocomplete()		
    	{	
    		$option					=array();
    		$option["where"]		=array();    		
    		
    		$option["where"][]		="nombre LIKE '%{$_GET["term"]}%'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}
		*/				
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
