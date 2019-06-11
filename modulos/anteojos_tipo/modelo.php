<?php
	class anteojos_tipo extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"partida"	    =>array(
			    "title"             => "partida",
			    "type"              => "input",
			),
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
				"title_filter"		=> "Descripcion",
			    "type"              => "input",			),
			"armazon"	    =>array(
			    "title"             => "Armazon",
			    "type"              => "input",
			),
			"unidad"	    =>array(
			    "title"             => "Unidad",
			    "type"              => "input",
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function autocomplete_tipos()		
    	{	
    		$option					=array();
    		$option["where"]		=array();    		
    		
    		$option["where"][]		="descripcion LIKE '%{$_GET["term"]}%'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}				
		
	}
?>

