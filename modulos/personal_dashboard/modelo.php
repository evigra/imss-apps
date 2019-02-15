<?php
	class personal_dashboard extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
	
		##############################################################################	
		##  Metodos	
		##############################################################################
        
		var $sys_fields		=array( 
			"acs"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_acs",			    	   
			),			
			"txt"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_txt",			    	   
			),			
			"licencia"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_licencia",			    	   
			),			
			"pase"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_pase",			    	   
			),			
			"calculo"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_calculo",
			),
		);
		
		public function __CONSTRUCT()
		{	
			parent::__CONSTRUCT();			
		}
		

   		public function __REPORT_TXT()
    	{
			$option=array();
			$option["template_title"]=NULL;			
			$data	=$this->txt_obj->__REPORT_GENERAL($option);
			return $data["html"];
		}				
   		public function __REPORT_LICENCIA()
    	{
			$option=array();
			$option["template_title"]=NULL;			
			$data	=$this->licencia_obj->__REPORT_GENERAL($option);
			return $data["html"];
		}
   		public function __REPORT_PASE()
    	{
			$option=array();
			$option["template_title"]=NULL;			
			$data	=$this->pase_obj->__REPORT_GENERAL($option);
			return $data["html"];
		}		
   		public function __REPORT_CALCULO()
    	{
			$option=array();
			$option["template_title"]=NULL;			
			$data	=$this->calculo_obj->__REPORT_GENERAL($option);
			return $data["html"];
		}		


	}
?>

