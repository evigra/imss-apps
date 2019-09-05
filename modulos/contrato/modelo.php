<?php
	class contrato extends general
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
			"nombre"	    =>array(
			    "title"             => "Nombre",
				#"title_filter"		=> "Trabajador",
			    "type"              => "input",
			),
			"modulo"	    =>array(
			    "title"             => "Modulo",
			    "type"              => "input",
			),

			"fecha_inicio"	    =>array(
			    "title"             => "Fecha de Inicio",
			    "type"              => "date",
			),
			"fecha_fin"	    =>array(
			    "title"             => "Fecha de Termino",
			    "type"              => "date",
			),
			"fecha_registro"	    =>array(
			    "title"             => "Registrado",
			    "type"              => "input",
			),
			"monto_minimo"	    =>array(
			    "title"             => "$ Minimo ",
			    "type"              => "input",
			),										
			"monto_maximo"	    =>array(
			    "title"             => "$ Maximo",
			    "type"              => "input",
			),										
			"fecha_registro"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "input",
			),
			"detalle_ids"	    =>array(
			    "type"              => "form",
			    "relation"          => "one2many",
			    "class_name"       	=> "contrato_detalle",
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "contrato_id",			    
			),			
		);				
			##############################################################################	
		##  Metodos	
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{    		
    		if(isset($this->module))
	    		$datas["modulo"]	=$this->module;    		    		    		    	    	
			$return 			=parent::__SAVE($datas,$option);
    	    return $return;
		}				
		public function autocomplete()		
    	{	
    		if(!is_array($option))				$option					=array();
    		if(!is_array($option["where"]))		$option["where"]		=array();    		
    		
    		$option["where"][]			="nombre LIKE '%{$_GET["term"]}%'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}				
		public function __BROWSE($option=array())
    	{	
    		if(!is_array($option))				$option					=array();
    		if(!isset($option["where"]))		$option["where"]		=array();    		
    		
    		if(isset($this->module))
	    		$option["where"][]		="modulo='{$this->module}'";
    		
			$return =parent::__BROWSE($option);    				
			return $return;			
		}				
	}
?>
