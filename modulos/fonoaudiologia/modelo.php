<?php
	class fonoaudiologia extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu			=array();
		var $sys_enviroments	="DEVELOPER";
		var $sys_table			="asegurado";
		var $sys_filter		=array(
			"fecha_devolucion"=>array(				
				"title_filter"      => "Devolucion"
			),
			"fecha_fs"=>array(				
				"title_filter"      => "F1yF3"
			),			
			
		);
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"nss"	    =>array(
			    "title"             => "NSS",
			    "type"              => "input",
			    "attr"             => array(		
					"required",					
			    ),				
				
			),			
			"nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"      => "Nombre",
			    "type"              => "input",
  			    "style"             => array(			    	
					"color"=>array("red"=>"1==1"),
					"font-size"=>array("25px"=>"1==1"),					
			    ),			    			    
				
			),		
			"agregado"	    =>array(
			    "title"             => "Agregado",				
			    "type"              => "input",
			),
			
/*			
			"conceptos_ids"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "incapacidad",			    
				#"class_template"  	=> "many2one_lateral",			    
				"class_report" 		=> "kanban",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "asegurado_id",				
				#"class_field_l"    	=> "horario",	
	
			),							
*/
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
        
		public function __CONSTRUCT()
		{	
			parent::__CONSTRUCT();		
			#$this->__PRINT_R($_SESSION);
			
		}
		#/*
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    	    return parent::__SAVE($datas,$option);
		}
		#*/		
	}
?>

