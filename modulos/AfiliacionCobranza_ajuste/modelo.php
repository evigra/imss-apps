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
		var $sys_fields		=array( 
			"registro_patronal"	    =>array(
			    "title"             => "registro_patronal",
			    "type"              => "input",
			),		
			"credito"	    =>array(
			    "title"             => "credito",
				"title_filter"		=> "Matricula",
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
			    "type"              => "input",
			),
			"falta"	    =>array(
			    "title"             => "falta",
				"title_filter"		=> "Puesto",
			    "type"              => "input",
			),
			"fecha_notificacion"	    =>array(
			    "title"             => "fecha_notificacion",
				"title_filter"		=> "Dep ID",
			    "type"              => "input",
			),
			"fec_inc"	    =>array(
			    "title"             => "fec_inc",
				"title_filter"		=> "Departamento",
			    "type"              => "input",
			),
			"fec_incidencia"	    =>array(
			    "title"             => "fec_incidencia",
				"title_filter"		=> "Horario",
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
			"del_cont"	    =>array(
			    "title"             => "del_cont",
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
