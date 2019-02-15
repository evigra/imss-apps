<?php
	class personal_cobertura extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_import			=array(
			"type"		=>"replace",
			"fields"	=>",",
			"enclosed"	=>"\"",
			"lines"		=>"\\n",
			"ignore"	=>"1",
		);		
		
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"plaza"	    =>array(
			    "title"             => "Plaza",
				"title_filter"		=> "Plaza",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"puesto"	    =>array(
			    "title"             => "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "import"            => "11",			  
			),
			"trabajador_matricula"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),
			"trabajador_nombre"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			   # "import"            => "11",			  
			),

			"jornada"	    =>array(
			    "title"             => "Jornada",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
				
				#"import"            => "11",				
			),
			"horario_id"	    =>array(
			    "title"             => "Hr ID",
				"title_filter"		=> "Dep ID",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),
			"horario"	    =>array(
			    "title"             => "Horario",
				"title_filter"		=> "Departamento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"factor"	    =>array(
			    "title"             => "Factor",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",	
				"source"            => array(
					"1.6"			=> "1.4",
					"2.3"			=> "2.3",
					"3.5"			=> "3.5",
				),
				
			),
			"descanzo"	    =>array(
			    "title"             => "Descanzo",
				"title_filter"		=> "Horario",
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
			"motivo"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			
				#"import"            => "11",
			),			
			"periodo"	    =>array(
			    "title"             => "Periodo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"dias_pendientes"	    =>array(
			    "title"             => "Disfrutar",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"dias"	    =>array(
			    "title"             => "Disfrutar",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"unidad"	    =>array(
			    "title"             => "Unidad",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),			
			"departamento"	    =>array(
			    "title"             => "Departamento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),				
			"sustituto_matricula"	    =>array(
			    "title"             => "Sust. Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				#"import"            => "11",
			),				
			"sustituto_nombre"	    =>array(
			    "title"             => "Sustituto",
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
		
			$datas=array();
			if($this->sys_action=="__SAVE")
			{	
				foreach($this->request["id"] as $this->sys_primary_id => $dias_solicitados)			
				{
					$this->sys_primary_field="id";
						
					$datas["dias"]=$dias_solicitados;
					
					$id=parent::__SAVE($datas);			
				}
			}	
			if($this->sys_action=="__SAVE_PROCESS")
			{	
				$comando_sql        ="
					UPDATE personal_cobertura SET dias_pendientes=dias_pendientes-dias, dias=0 
					WHERE dias_pendientes>0
				";	
				#echo $comando_sql;
				$data =$this->__EXECUTE($comando_sql, "DEVICE MODELO");	
			}	
			
		}				
   		public function __REPORT_COLIMA($option=array())		
    	{
			if(!isset($option["where"]))		$option["where"]				=array();						
			$option["where"][]							="left(departamento_id,6) IN ('06HC01','06UA05','06UA06','06UA09','06UA11','06UA16','06UA18','06UA19','06AG01','06CS01','06DL06','06GB01','06SD01','06TE01','06IB01')";						
			return $this->__REPORT_SPECIAL($option);
		}
   		public function __REPORT_MANZANILLO($option=array())		
    	{
			if(!isset($option["where"]))		$option["where"]				=array();
			$option["where"][]							="left(departamento_id,6) IN ('06HC10','06UA02','06UA17','06CS02','06SD02')";
			return $this->__REPORT_SPECIAL($option);
		}
   		public function __REPORT_TECOMAN($option=array())		
    	{
			if(!isset($option["where"]))		$option["where"]				=array();
			$option["where"][]							="left(departamento_id,6) IN ('06HF04','06CS03','06SD03','06UA03')";
			return $this->__REPORT_SPECIAL($option);
		}

   		public function __REPORT_SPECIAL($option=array())		
    	{			
			$option["select"]	            =array(
				"*", 
				"
					case 
						when turno=1 OR turno=2 THEN 'Dias'
						when turno=3 THEN 'Veladas' 
						when turno=5 THEN 'Jornadas' 
					end				
				"=>"disfrutar",
				"dias*factor"=>"calculo"
			);
			
			if(!isset($option["where"]))		$option["where"]				=array();
			
			#$option["echo"]									="REPORT SPECIAL";
			
			$option["order"]								="puesto_id DESC, departamento DESC, dias DESC, turno ASC";
			$option["where"][]								="dias_pendientes>0";

			$option["template_separator"]	            	= "puesto";		
			if(@$this->request["sys_action"]=="print_excel")
			{	
				$option["where"][]							="dias>0";
				$option["template_title"]	                = $this->sys_module . "html/report_special_title";
				$option["template_body"]	                = $this->sys_module . "html/report_special_body";
			}	
			else
			{	
				$option["template_title"]	                = $this->sys_module . "html/report_process_title";
				$option["template_body"]	                = $this->sys_module . "html/report_process_body";
			}	
			return	 $this->__VIEW_REPORT($option);
		}						
	}
?>
