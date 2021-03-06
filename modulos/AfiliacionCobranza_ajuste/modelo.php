<?php
	class AfiliacionCobranza_ajuste extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_import			=array(
			"type"		=>"restore_table",
			"fields"	=>",",
			"enclosed"	=>"\"",
			"lines"		=>"\\n",
			"ignore"	=>"11",
		);		
		
		var $mod_menu=array();
		var $sys_table		="rale";
		var $sys_fields		=array( 
			"credito"	    =>array(
			    "title"             => "credito",
			    "type"              => "primary key",
			    "title_filter"		=> "credito",
			),

			"registro_patronal"	    =>array(
			    "title"             => "registro_patronal",
			    "type"              => "input",
			    "title_filter"		=> "registro_patronal",
			),		
			"movimiento"	    =>array(
			    "title"             => "movimiento",
				"title_filter"		=> "movimiento",
			    "type"              => "input",
			),
			"fecha_movimiento"	    =>array(
			    "title"             => "fecha_movimiento",
			    "type"              => "input",
			),
			"sector"	    =>array(
			    "title"             => "sector",
			    "type"              => "input",
		  
			),

			"ce"	    =>array(
			    "title"             => "ce",
			    "type"              => "input",
			),
			"periodo"	    =>array(
			    "title"             => "periodo",
			    "type"              => "input",
			),
			"td"	    =>array(
			    "title"             => "td",
				"title_filter"		=> "td",
			    "type"              => "input",
			),
			"falta"	    =>array(
			    "title"             => "falta",
			    "type"              => "input",
			),
			"fecha_notificacion"	    =>array(
			    "title"             => "fecha_notificacion",
			    "type"              => "input",
			),			
			"fecha_incidencia"	    =>array(
			    "title"             => "fecha_incidencia",
			    "type"              => "input",
			),			
			"fecha_inc"	    =>array(
			    "title"             => "fecha_inc",
			    "type"              => "input",
			),			
			"dias"	    =>array(
			    "title"             => "dias",
			    "type"              => "input",
			),			
			"importe"	    =>array(
			    "title"             => "importe",
			    "type"              => "input",
			),			
			"sub_cont"	    =>array(
			    "title"             => "sub_cont",
			    "type"              => "input",
			),			
			"observaciones"	    =>array(
			    "title"             => "observaciones",
			    "type"              => "input",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    	    $id=parent::__SAVE($datas,$option);
		}				
	}
?>
