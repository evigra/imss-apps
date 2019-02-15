<?php
	class modulos_fields extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "ID",				
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    		  
			),
			"nombre"	    =>array(
			    "title"             => "nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    			    
			),
			"tipo"	    =>array(
			    "title"             => "tipo",
				"title_filter"		=> "Type",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",		
				"source"			=>array(
					""				=>"Seleccciona un tipo",					
					"primary key"	=>"primary key",
					"input"			=>"input",
					"select"		=>"select",
					"date"			=>"date",
					"multidate"		=>"multidate",
					"checkbox"		=>"checkbox",
					"file"			=>"file",
					"textarea"		=>"textarea",
					"password"		=>"password",
					"autocomplete"	=>"autocomplete",
					"form"			=>"form",
					"class"			=>"class",
					"hidden"		=>"hidden",
					
					
				)				
				#"import"            => "11",				
			),
			"titulo"	    =>array(
			    "title"             => "titulo",
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
			$this->words["html_head_js"]              	=$this->__FILE_JS(array("../".$this->sys_module."js/index"));			
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#$this->__PRINT_R($datas);
    		#$option=array("echo"=>"SAVE");
    	    $id=parent::__SAVE($datas,$option);
		}				
	}
?>
