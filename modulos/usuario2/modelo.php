<?php
	class usuario2 extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_table="usuario";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"nombre"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"clave"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"mail_personal"	    =>array(
			    "title"             => "Mail Personal",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"mail_institucional"	    =>array(
			    "title"             => "Mail Institucional",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"telefono"	    =>array(
			    "title"             => "Telefono",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"usergroup_ids"	    	=>array(
			    "title"             => "Permisos",
			    "type"              => "input",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "user_group",
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "user_id",
			    "value"             => "",			    
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			$this->menu_obj			=new menu();
			parent::__CONSTRUCT();			
		}
		
		
		public function __FIND_FIELDS($id=NULL)
		{
			parent::__FIND_FIELDS($id);
			if($this->sys_section=="write")
			{
				$this->sys_fields["password"]["value"]="";			
			}			
    	}		

	}
?>
