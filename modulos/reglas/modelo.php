<?php
	class reglas extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"clave"	    =>array(
			    "title"             => "Clave",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"campo"	    =>array(
			    "title"             => "Campo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"accion"	    =>array(
			    "title"             => "Accion",
			    "showTitle"         => "si",
			    "type"              => "password",
			    "default"           => "",
			    "value"             => "",			    
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
	}
?>
