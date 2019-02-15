<?php
	class modulo extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################

		var $sys_table="modulos";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"clase"	    =>array(
			    "title"             => "Clase",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),
			"descripcion"	    =>array(
			    "title"             => "Descripcion",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",				
			),

			"fields_ids"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "modulos_fields",			    
				#"class_template"  	=> "many2one_lateral",			    
				"class_report" 		=> "kanban",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "modulo_id",				
				#"class_field_l"    	=> "horario",	
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
