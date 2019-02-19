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
				"holder"             => "0000 00 0000",			    
			    "type"              => "input",
			    "attr"             => array(		
					"required",					
					"placeholder" 	=> "0000 00 0000",			    
					"title" 		=> "Numero de Seguridad Social (Con espacios)",			    
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
			"colonia"	    =>array(
			    "title"             => "Colonia",				
			    "type"              => "input",
			),
			"cp"	    =>array(
			    "title"             => "CP",				
			    "type"              => "input",
			),
			"calle"	    =>array(
			    "title"             => "Calle",				
			    "type"              => "input",
			),
			"numero"	    =>array(
			    "title"             => "Numero",				
			    "type"              => "input",
			),
			"Telefono"	    =>array(
			    "title"             => "Telefono",				
			    "type"              => "input",
			),

			"incapacidad_ids"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "detalle_fonoaudiologia",			    
				#"class_template"  	=> "many2one_lateral",			    
				"class_report" 		=> "kanban",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "asegurado_id",				
				#"class_field_l"    	=> "horario",	
			),							
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
    		#$datas["total"]		=count(explode(",",$datas["dias"]));
			#$datas["registro"]=$this->sys_date;
			/*
			if($datas["estatus"]=="APROVADO")
			{
				$datas["autorizo"]		=$_SESSION["user"]["nombre"];
				$datas["m_autorizo"]	=$_SESSION["user"]["matricula"];								
			}				
			
			
    		if($this->sys_section_personal_calculo=="create")
			{
				$datas["registro"]		=$this->sys_date;
				$datas["elaboro"]		=$_SESSION["user"]["nombre"];
				$datas["m_elaboro"]		=$_SESSION["user"]["matricula"];				
			}
			
			
			$datas["cpto_1vez"]			=count($datas["conceptos_ids"]);		
			*/
			#$option["echo"]=$datas["total"];
			
			#$this->__PRINT_R($datas);
    		
    	    return parent::__SAVE($datas,$option);
		}
		#*/		
   		public function __GENERAR_PDF()
    	{
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			#$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_primary_id);
			
			/*
			$_SESSION["pdf"]["template"]			=array(
				array(
					"format"		=>"A7",					
					"html"			=>"PRUEBA",					
					"orientation"	=>"L",					
				),			
			
				array(
					"format"		=>"A4",					
					"html"			=>$this->__FORMATO($this->sys_primary_id),					
					"orientation"	=>"P",					
				),			
				
			);
			*/
			
		}		
   		
   		public function __REPORT_DEV()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
						
			$option["actions"]							="false";			
						
			$option["where"][]="fecha_devolucion !='0000-00-00'";	
			$option["date"]="fecha_devolucion";	
			
			return $this->__VIEW_REPORT($option);
		}				
		public function __REPORT_CAR_REALIZADA()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/car_r/report_title";
			$option["template_body"]	                = $this->sys_module . "html/car_r/report_body";
						
			$option["actions"]							="false";			
						
			$option["where"][]="f_carta_realizada !='0000-00-00'";	
			$option["date"]="f_carta_realizada";	
			
			return $this->__VIEW_REPORT($option);
		}
		
   		public function __REPORT_FS()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/fs/report_title";
			$option["template_body"]	                = $this->sys_module . "html/fs/report_body";
						
			$option["actions"]							="false";			
			
			$option["where"][]="fecha_fs !='0000-00-00'";	
			$option["date"]="fecha_fs";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_SI()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
						
			$option["actions"]							="false";			
						
			$option["where"][]="fecha_calificacion !='0000-00-00'";	
			$option["where"][]="texto_calificacion LIKE '%SI%'";	
			$option["date"]="fecha_calificacion";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_NO()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/cal/report_title";
			$option["template_body"]	                = $this->sys_module . "html/cal/report_body";
						
			$option["actions"]							="false";			
						
			$option["where"][]="fecha_calificacion !='0000-00-00'";	
			$option["where"][]="texto_calificacion LIKE '%NO%'";	
			$option["date"]="fecha_calificacion";			
			
			return $this->__VIEW_REPORT($option);
		}		
		
   		public function __REPORT_SOL()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
						
			#$option["actions"]							="false";			
						
			$option["where"][]="solicitud_incapacidad !='0000-00-00'";	
			$option["date"]="solicitud_incapacidad";			
			
			return $this->__VIEW_REPORT($option);
		}				

   		public function __REPORTE($option="")
    	{			
			if($option=="")	$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
	
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				$option["actions"]["check"]					="false";
				$option["actions"]["delete"]				="false";
			}	
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"]=Array();
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			
			$option["order"]="a.id desc";
			
			return $this->__VIEW_REPORT($option);
		}						
   		public function __BROWSE($option = Array())
    	{			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
		
			return parent::__BROWSE($option);
		}						
		
   		public function __VIEW_REPORT($option="")
    	{			
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/report_pie_pdf";
		
			return parent::__VIEW_REPORT($option);
		}						
   		public function __FORMATO_CARTA($id)
    	{
			$option["where"]=array("i.id=$id");	
			$template="";	
			
			$words									=array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/car_r/PDF_FORMATO_CARTA"));								
			$data									=$this->__BROWSE($option);
			$words									=array_merge($words,$data["data"][0]);
			
			$words["sys_titulo"]					="COORDINACION DE GESTION DE RECURSOS HUMANOS";		
			$words["sys_subtitulo"]					="DEPARTAMENTO DELEGACIONAL DE PERSONAL";					
		
			if(@$dato["trabajador_departamento_id"])
				$words["lugar"]							=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
			$words["fecha"]							=$this->sys_date;		
			$words["matricula3"]					=$datos[0]["trabajador_clave"];
			$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");							
			$template								=$this->__REPLACE($template,$words);
			return                  				$template;
		}	
   		public function __FORMATO_SOBRE($id)
    	{
			$option["where"]=array("i.id=$id");	
			$template="";	
			
			$words									=array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/car_r/PDF_FORMATO_SOBRE"));								
			$data									=$this->__BROWSE($option);
			$words									=array_merge($words,$data["data"][0]);
			
			$words["sys_titulo"]					="COORDINACION DE GESTION DE RECURSOS HUMANOS";		
			$words["sys_subtitulo"]					="DEPARTAMENTO DELEGACIONAL DE PERSONAL";					
		
			if(@$dato["trabajador_departamento_id"])
				$words["lugar"]							=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
			$words["fecha"]							=$this->sys_date;		
			#$words["matricula3"]					=$datos[0]["trabajador_clave"];
			$template								.="{sys_asunto}{sys_modulo}{sys_pie}";							
			$template								=$this->__REPLACE($template,$words);
			return                  				$template;
		}	

	}
?>

