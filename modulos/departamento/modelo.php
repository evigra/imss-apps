<?php
	class departamento extends plazas
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_table="plazas";
		
		var $sys_field=array(
			"clave"=>array(
			    "title"             => "Clave",
			),
			"departamento"=>array(
			    "title"             => "Departamento",
			),			
		);
	
		##############################################################################	
		##  Metodos	
		##############################################################################
		
        
		public function __CONSTRUCT()
		{

			parent::__CONSTRUCT();			
		}
   		public function __BROWSE($option=NULL)
    	{
			if(!is_array($option))	$option=array();			
			if(!isset($option["select"]))					$option["select"]=array();

			$option["select"]["left(departamento_id,6)"]	="clave";
			$option["select"]["departamento"]				="departamento";
								
			if(!isset($option["where"])) 					$option["where"]								=array();
			$option["where"][]								="departamento_id LIKE '%0000'";
			
			$option["group"]								="left(departamento_id,6)";	
			
			$option["order"]								="departamento_id";
			
			
			#$option["echo"]									="departamento_id";
			
			return parent::__BROWSE($option);
		}				
	}
?>
