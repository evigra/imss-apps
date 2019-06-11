<?php
	class personal_ausentismo extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_import			=array(
			"type"		=>"restore_table",
			"fields"	=>",",
			"enclosed"	=>"\"",
			"lines"		=>"\\n",
			"ignore"	=>"1",
		);		
		
		var $mod_menu=array();
		var $sys_fields		=array( 
			"plaza"	    =>array(
			    "title"             => "Plaza",
			    "type"              => "primary key",
			),
		
			"quincena"	    =>array(
			    "title"             => "quincena",
				"title_filter"		=> "Matricula",
			    "type"              => "input",
			    "import"            => "11",			  
			),
			"concepto"	    =>array(
			    "title"             => "concepto",
			    "type"              => "input",
			    "import"            => "11",			  
			),
			"matricula"	    =>array(
			    "title"             => "Matricula",
			    "type"              => "input",
			   # "import"            => "11",			  
			),
			"nombre"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			   # "import"            => "11",			  
			),

			"tipo_contratacion"	    =>array(
			    "title"             => "Contratacion",
				"title_filter"		=> "Puesto",
			    "type"              => "input",
				#"import"            => "11",				
			),
			"puesto"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Dep ID",
			    "type"              => "input",
				#"import"            => "11",
			),
			"departamento_id"	    =>array(
			    "title"             => "Departamento ID",
				"title_filter"		=> "Departamento",
			    "type"              => "input",
			),
			"cantidad"	    =>array(
			    "title"             => "Cantidad",
				"title_filter"		=> "Horario",
			    "type"              => "input",
				#"import"            => "11",				
			),
			"importe"	    =>array(
			    "title"             => "Importe",
			    "type"              => "input",
				#"import"            => "11",
			),			
			"movimiento"	    =>array(
			    "title"             => "Movimiento",
			    "type"              => "input",
				#"import"            => "11",
			),			
			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#$this->__PRINT_R($datas);
    		#$option=array("echo"=>"SAVE");
    	    $id=parent::__SAVE($datas,$option);
		}				
	}
?>
