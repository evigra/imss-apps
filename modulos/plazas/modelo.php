<?php
	class plazas extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_import			=array(
			"type"		=>"replace",
			"fields"	=>"|",
			"enclosed"	=>"\"",
			"lines"		=>"\\n",
			"ignore"	=>"1",
		);		
		
		var $mod_menu=array();
		var $sys_fields		=array( 
			"matricula"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"clave"	    =>array(
			    "title"             => "Plaza",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"puesto_id"	    =>array(
			    "title"             => "Puesto ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),
			"puesto"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",				
			),
			"departamento_id"	    =>array(
			    "title"             => "Dep ID",
				"title_filter"		=> "Dep ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),
			"departamento"	    =>array(
			    "title"             => "Departamento",
				"title_filter"		=> "Departamento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"horario_id"	    =>array(
			    "title"             => "Horario ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			      
			),
			"horario"	    =>array(
			    "title"             => "Horario",
				"title_filter"		=> "Horario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",				
			),
			"b2"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			
				#"import"            => "11",
			),			
			"b3"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"b4"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"b5"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",				
			),			
			"b6"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
				#"import"            => "11",				
			),			
			"b7"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
				#"import"            => "11",				
			),			
			"b8"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    #"import"            => "11",
			),			
			"b9"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",	
				#"import"            => "11",				
			),			
			"sueldo"	    =>array(
			    "title"             => "B",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
				#"import"            => "11",
			),			
			"turno"	    =>array(
			    "title"             => "Turno",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",	
				#"import"            => "11",
			),			
			
			"conceptos"	    =>array(
			    "title"             => "Concepto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
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
