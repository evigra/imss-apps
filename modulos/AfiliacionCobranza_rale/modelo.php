<?php
	class AfiliacionCobranza_rale extends general
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
		var $sys_fields		=array( 
			"credito"	    =>array(
			    "title"             => "Credito",
			    "type"              => "primary key",
			    "title_filter"		=> "credito",
			),

			"registro_patronal"	    =>array(
			    "title"             => "Registro Patronal",
			    "type"              => "input",
			    "title_filter"		=> "Registro Patronal",
			),		
			"movimiento"	    =>array(
			    "title"             => "Movimiento",
				"title_filter"		=> "movimiento",
			    "type"              => "input",
			),
			"fecha_movimiento"	    =>array(
			    "title"             => "Fecha Movimiento",
			    "type"              => "input",
			),
			"sector"	    =>array(
			    "title"             => "sector",
			    "type"              => "input",
			),

			"ce"	    =>array(
			    "title"             => "CE",
			    "type"              => "input",
			),
			"periodo"	    =>array(
			    "title"             => "Periodo",
			    "type"              => "input",
			),
			"td"	    =>array(
			    "title"             => "TD",
				"title_filter"		=> "TD",
			    "type"              => "input",
			),
			"falta"	    =>array(
			    "title"             => "Falta",
			    "type"              => "input",
			),
			"fecha_notificacion"	    =>array(
			    "title"             => "F. Notificacion",
			    "type"              => "input",
			),			
			"fecha_incidencia"	    =>array(
			    "title"             => "F. Incidencia",
			    "type"              => "input",
			),			
			"fecha_inc"	    =>array(
			    "title"             => "Fecha inc",
			    "type"              => "input",
			),			
			"dias"	    =>array(
			    "title"             => "Dias",
			    "type"              => "input",
			),			
			"importe"	    =>array(
			    "title"             => "Importe",
			    "type"              => "input",
			),			
			"sub_cont"	    =>array(
			    "title"             => "Sub Cont",
			    "type"              => "input",
			),			
			"observaciones"	    =>array(
			    "title"             => "Observaciones",
			    "type"              => "input",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    	    return parent::__SAVE($datas,$option);
		}				
	}
?>
