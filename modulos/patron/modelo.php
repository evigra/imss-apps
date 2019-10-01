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
			    "title"             => "Registro Patronal",
				"title_filter"		=> "Matricula",
			    "type"              => "primary key",
			),
			"rp_ema"	    =>array(
			    "title"             => "RP EMA",
				"title_filter"		=> "Trabajador",
			    "type"              => "input",
			),
			"dv"	    =>array(
			    "title"             => "DV",
			    "type"              => "input",
			),
			"rp_1"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Puesto",
			    "type"              => "input",
			),			
			"c1"	    =>array(
			    "title"             => "C1",
			    "type"              => "input",
			),
			"c2"	    =>array(
			    "title"             => "C2",
				"title_filter"		=> "telefono",
			    "type"              => "input",
			),
			"rp_2"	    =>array(
			    "title"             => "Estatus",
			    "type"              => "input",
			),
			"rp_3"	    =>array(
			    "title"             => "Tipo Empleado",
			    "type"              => "input",
			),
			"curp"	    =>array(
			    "title"             => "CURP",
			    "type"              => "input",
			),
			"sub"	    =>array(
			    "title"             => "SUB",
			    "type"              => "input",
			),
			"mpio"	    =>array(
			    "title"             => "Tipo Contratacion",
			    "type"              => "input",
			),
			"nombre"	    =>array(
			    "title"             => "Patron",
			    "type"              => "input",
			),
			"domicilio"	    =>array(
			    "title"             => "Domicilio",
			    "type"              => "input",
			),
			"mpio_edo"	    =>array(
			    "title"             => "Municipio",
			    "type"              => "input",
			),
			"cp"	    =>array(
			    "title"             => "CP",
			    "type"              => "input",
			),			
			"actividad"	    =>array(
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
		public function __AUTOCOMPLETE()		
    	{	
    		$option					=array();
    		if(!isset($option["where"]))		$option["where"]		=array();    		
    		
    		$option["where"][]					="rp_rale LIKE '%{$_GET["term"]}%'";
    		    		
			$return 							=$this->__BROWSE($option);    				
			return $return;			
		}									

	}
?>
