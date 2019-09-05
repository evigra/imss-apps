<?php
	class contrato_detalle extends general
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
			    "type"              => "input",
			),
			"contrato_id"	    =>array(
			    "title"             => "Contrato",
			    "type"              => "input",
			),
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
				"title_filter"		=> "Descripcion",
			    "type"              => "input",			
			),	
			"char1"	    =>array(
			    "title"             => "Char",
			    "type"              => "input",
			),
			
			"char2"	    =>array(
			    "title"             => "Char",
			    "type"              => "input",
			),
			
			"char3"	    =>array(
			    "title"             => "Char",
			    "type"              => "input",
			),					
			"num1"	    =>array(
			    "title"             => "Int",
			    "type"              => "input",
			),
			
			"num2"	    =>array(
			    "title"             => "Int",
			    "type"              => "input",
			),
			"num3"	    =>array(
			    "title"             => "Int",
			    "type"              => "input",
			),
			"fecha1"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "date",
			),
			"fecha2"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "date",
			),
			"fecha3"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "date",
			),
#*/			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{    		
    		#$this->__PRINT_R($datas);
    		#if(isset($this->module))
	    		$datas["modulo"]	=$this->module;    		    		    		    	    	
			$return 			=parent::__SAVE($datas,$option);
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
