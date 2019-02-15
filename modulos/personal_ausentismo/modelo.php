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
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			      
			),
		
			"quincena"	    =>array(
			    "title"             => "quincena",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"concepto"	    =>array(
			    "title"             => "concepto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"matricula"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),
			"nombre"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),

			"tipo_contratacion"	    =>array(
			    "title"             => "Contratacion",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",				
			),
			"puesto"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Dep ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),
			"departamento_id"	    =>array(
			    "title"             => "Departamento ID",
				"title_filter"		=> "Departamento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"cantidad"	    =>array(
			    "title"             => "Cantidad",
				"title_filter"		=> "Horario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			
				#"import"            => "11",				
			),
			"importe"	    =>array(
			    "title"             => "Importe",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			
				#"import"            => "11",
			),			
			"movimiento"	    =>array(
			    "title"             => "Movimiento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
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
