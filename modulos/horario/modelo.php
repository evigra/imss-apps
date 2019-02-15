<?php
	class horario extends plazas
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_table="plazas";
		
		var $sys_field=array(
			"horario_id"=>array(
			    "title"             => "Clave",
			),
			"horario"=>array(
			    "title"             => "Departamento",
			),			
			"turno"=>array(
			    "title"             => "Clave",
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

			
			$option["select"][]								="turno";
			$option["select"][]								="horario_id";
			$option["select"][]								="horario";			
			#LPAD("34",5,'0')
			$option["group"]								="horario_id";	
			
			$option["order"]								="turno asc, lpad(trim(left(horario,5)),5,0) asc";
			
			
			#$option["echo"]									="departamento_id";
			
			return parent::__BROWSE($option);
		}				
	}
?>
