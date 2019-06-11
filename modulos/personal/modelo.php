<?php
	class personal extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_import			=array(
			"type"		=>"replace",
			"fields"	=>"|",
			"enclosed"	=>"\"",
			"lines"		=>"\\n",
			"ignore"	=>"1",
		);		
		var $sys_fields		=array( 
			"matricula"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "type"              => "primary key",
			    "import"            => "10",			  
			),
			"nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Trabajador",
			    "type"              => "input",
			),
			"puesto_id"	    =>array(
			    "title"             => "Puesto ID",
			    "type"              => "input",
			),
			"puesto"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Puesto",
			    "type"              => "input",
			),			
			"categoria_id"	    =>array(
			    "title"             => "Categoria ID",
			    "type"              => "input",
			),
			"telefono"	    =>array(
			    "title"             => "Telefono",
				"title_filter"		=> "telefono",
			    "type"              => "input",
			    "import"            => "01",			  
			),
			"status"	    =>array(
			    "title"             => "Estatus",
			    "type"              => "input",
			),
			"tipo_empleado"	    =>array(
			    "title"             => "Tipo Empleado",
			    "type"              => "input",
			),
			"tipo_contratacion"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "type"              => "input",
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################     
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();			
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#$this->__PRINT_R($datas);
    		#$option=array("echo"=>"SAVE");
    	    $id=parent::__SAVE($datas,$option);
		}				
	}
?>
