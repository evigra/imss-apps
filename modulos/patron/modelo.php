<?php
	class patron extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_import			=array(
			"type"		=>"replace",
			"fields"	=>",",
			"enclosed"	=>"",
			"lines"		=>"\\n",
			"ignore"	=>"1",
		);		
		var $sys_fields		=array( 
			"rp_rale"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "10",			  
			),
			"rp_ema"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Trabajador",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    

			),
			"dv"	    =>array(
			    "title"             => "Puesto ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    

			),
			"rp_1"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    			    
			),			
			"c1"	    =>array(
			    "title"             => "Categoria ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"c2"	    =>array(
			    "title"             => "Telefono",
				"title_filter"		=> "telefono",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			   
			    "import"            => "01",			  
			),
			"rp_2"	    =>array(
			    "title"             => "Estatus",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"rp_3"	    =>array(
			    "title"             => "Tipo Empleado",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			      
			),
			"curp"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"sub"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"mpio"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"nombre"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"domicilio"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"mpio_edo"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"cp"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"actividad"	    =>array(
			    "title"             => "Tipo Contratacion",
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
