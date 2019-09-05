<?php
	class sppstims_pendientes extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_table="vsppstims_pendientes";
		var $sys_fields		=array( 
			"matricula"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"trabajador_nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    "attr"            	=> array(					
					"title"			=>"Nombre del trabajador",
			    ),			    			    
  			    "style"             => array(			    	
					"color"			=>array("red"=>"1==1"),
					"font-size"		=>array("25px"=>"1==1"),					
			    ),			    			    
			),
			"trabajador_clave"	    =>array(
			    "title"             => "Matricula",				
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
  			    "attr"             => array(
					#"required",
					"title"			=>"Matricula del trabajador",
			    	"tabindex"		=>"1"			    
			    ),			    			    
				

			),
			"adscripcion"	    =>array(
			    "title"             => "Adscripcion",
				"title_filter"		=> "Adscripcion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),

			"trabajador_puesto"	    =>array(
			    "title"             => "Puesto",
				"title_filter"		=> "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=> array(
			    	"readonly"		=>"readonly"
			    ),		
				
				
				
			),
			"trabajador_departamento"	    =>array(
			    "title"             => "Departamento",				
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"trabajador_departamento_id"	    =>array(
			    "title"             => "DepartamentoID",
			    "showTitle"         => "si",
			    "type"              => "hidden",
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
			if($this->sys_action=="__SAVE")		$this->__JS="var sys_action=\"__SAVE\";";
			else								$this->__JS="var sys_action=\"\";";
		}
		
   		public function __SAVE($datas=NULL,$option=NULL)
    	{					
			return parent::__SAVE($datas);
		}			
   		public function __FORMATO_INTERCONSULTA($id)		
    	{									
			#$this->sys_action_sppstimss_citados="";
			#$this->__PRINT_R($this->request);
			
			
			
			$datos									=$this->__BROWSE($this->sys_primary_id);
			$words									=$datos[0];	
			
			$words["especialidad"]					=substr($id,3,strlen($id)-2);
			$words["motivo"]						=$this->request["motivo"];
			$words["umf"]						="";
			#$words["especialidad"]=					$id;
			
			#if($id=="ic_cirugia_gral") 			$words["especialidad"]="CIRUGIA GENERAL";
			#if($id=="ic_oftalmo") 					$words["especialidad"]="OFTALMOLOGIA";
			
			$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_interconsulta")),$words);
			
			$words["sys_titulo"]					="DIRECCCION DE PRESTACIONES MEDICAS";		
			$words["sys_subtitulo"]					="";		
			
			@$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
			$template              					=$this->__REPLACE($template,$words); 			
			
						
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$template;
		}
		
   		public function __FORMATO()
    	{
			$datos									=$this->__BROWSE($this->sys_primary_id);
			$words									=$datos[0];				
			
			$dato = explode("-", $words["cita"]); 
			
			if($dato[1]=='01') $mes="ENERO";
			if($dato[1]=='02') $mes="FEBRERO";
			if($dato[1]=='03') $mes="MARZO";
			if($dato[1]=='04') $mes="ABRIL";
			if($dato[1]=='05') $mes="MAYO";
			if($dato[1]=='06') $mes="JUNIO";
			if($dato[1]=='07') $mes="JULIO";
			if($dato[1]=='08') $mes="AGOSTO";
			if($dato[1]=='09') $mes="SEPTIEMBRE";
			if($dato[1]=='10') $mes="OCTUBRE";
			if($dato[1]=='11') $mes="NOVIEMBRE";
			if($dato[1]=='12') $mes="DICIEMBRE";

			$dato_h = explode(":", $words["horario"]); 
			
			if(intval($dato_h[0])!=8) $words["horario"]=intval($dato_h[0]) - 1 . ":30";
			
			
			$words["dia"]							=$dato[2];
			$words["mes"]							=$mes;
			
			$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_sppstimss")),$words);
			
			$words["sys_titulo"]					="JEFATURA DE PRESTACIONES MEDICAS";		
			$words["sys_subtitulo"]					="Servicio de Prevencion y Promocion de la Salud para los Trabajadores IMSS (SPPSTIMSS)";			

			@$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
			$template_sppstimss        				=$this->__REPLACE($template,$words); 			
			
			$words									=$datos[0];	
			$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_lab")),$words);
			
			$words["sys_titulo"]					="DIRECCCION DE PRESTACIONES MEDICAS";		
			$words["sys_subtitulo"]					="";		
			
			@$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
			$template_lab              				=$this->__REPLACE($template,$words); 		

			#if($datos[0]["cita_laboratorio"]=="0000-00-00" OR $datos[0]["cita_laboratorio"]< "{date("Y-m-d")}")		
			if($datos[0]["cita_laboratorio"]=="0000-00-00")		
				$template_lab="";	
			//////////
			$words["puesto_tipo"]	=substr($words["trabajador_puesto_id"],2,2);			
			$template_consentimiento="";
			if(in_array($words["puesto_tipo"],array(12,21,31,36)))
			{	
				$words									=$datos[0];	
				$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_consentimiento")),$words);
				
				$words["sys_titulo"]					="DIRECCCION DE PRESTACIONES MEDICAS";		
				$words["sys_subtitulo"]					="HOJA DE CONSENTIMIENTO PARA LA REALIZACIÓN DE LA PRUEBA SEROLÓGICA PARA LA DETECCIÓN DE HIV";		
				
				@$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
				$template_consentimiento   				="<br><br>".$this->__REPLACE($template,$words); 			
			
			}

			
			/////////////
			
			@$template								="$template_sppstimss<br><br><br><br><br><br><br>$template_lab<br>$template_consentimiento";
			
			
			

						
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$template;
		}
   		public function __REPORT_PENDIENTE($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["actions"]							= array();
			
			$option["actions"]["write"]					="true";
			$option["actions"]["show"]					="tre";
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";
			
			
			
			
			
			$option["where"][]							="estatus =''";
			
			$option["color"]["red"]						="$"."row[\"trabajador_turno\"]==$"."row[\"sustituto_turno\"]";			
			
			$option["color"]["blue"]					="substr($"."row[\"trabajador_puesto_id\"],2,4) != substr($"."row[\"sustituto_puesto_id\"],2,4)";			
			
			$option["color"]["blue"]					.="OR (substr($"."row[\"trabajador_puesto_id\"],2,4) == substr($"."row[\"sustituto_puesto_id\"],2,4)";			
			$option["color"]["blue"]					.="AND substr($"."row[\"trabajador_puesto_id\"],0,2) > substr($"."row[\"sustituto_puesto_id\"],0,2))";											
			
			
			
			#/*
			if($this->__NIVEL_SESION(">=10")==true)	 // NIVEL SUPER ADMINISTRADOR 			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			#$option["echo"]="PENDIENTE";
			#*/
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_APROVADO($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["where"][]							="estatus = 'APROVADO'";

			$option["actions"]							= array();
			$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
			$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";
			
			

			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}


			$option["color"]["red"]						="$"."row[\"trabajador_turno\"]==$"."row[\"sustituto_turno\"]";			
			
			$option["color"]["blue"]					="substr($"."row[\"trabajador_puesto_id\"],2,4) != substr($"."row[\"sustituto_puesto_id\"],2,4)";			
			
			$option["color"]["blue"]					.="OR (substr($"."row[\"trabajador_puesto_id\"],2,4) == substr($"."row[\"sustituto_puesto_id\"],2,4)";			
			$option["color"]["blue"]					.="AND substr($"."row[\"trabajador_puesto_id\"],0,2) > substr($"."row[\"sustituto_puesto_id\"],0,2))";											


			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_CANCELADOS($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["where"]=array("estatus = 'CANCELADO'");

			$option["actions"]							="false";

			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_SUSTITUTO($option=NULL)
    	{			
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();			
			
			
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			

			
			
			$option["color"]["green"]						="$"."row[\"estatus\"]==\"APROVADO\"";			
			$option["color"]["red"]							="$"."row[\"estatus\"]==\"CANCELADO\"";			

			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $this->__NIVEL_SESION(\">=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				$option["actions"]["check"]					="false";
				$option["actions"]["delete"]				="false";
			}				
			
			$option["template_title"]	                = $this->sys_module . "html/report_sustituto_title";
			$option["template_body"]	                = $this->sys_module . "html/report_sustituto_body";
			
			
			return $this->__VIEW_REPORT($option);
		}
   		public function __REPORTE($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
						
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
			}	
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				#$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";							
			}

			$this->sys_fields["laboratorio"]["title"]	="Lab";
			$this->sys_fields["cita_cumplida"]["title"]	="Cita";
						

#			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
#				$option["order"]="horario ASC";
			
			

			#	$option["where"][]="cita ='".date("Y-m-d")."'";	
			#*/
			
			$option["date"]="cita";
			
			return $this->__VIEW_REPORT($option);
		}						

   		public function __REPORT_HOY($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();

			

			
			$option["where"][]="cita ='".date("Y-m-d")."'";	
			
			#$option["date"]="cita";
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
						
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				#$option["actions"]["check"]				="false";
				#$option["actions"]["delete"]				="false";
			}	

			
			
			$this->sys_fields["laboratorio"]["title"]	="Lab";
			$this->sys_fields["cita_cumplida"]["title"]	="Cita";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_MANANA($option=NULL)
    	{
			#$this->__PRINT_R(DateInterval::createfromdatestring('+1 day'));
			
			#$fecha = new DateTime(date("Y-m-d"));
			#$fecha->add(new DateInterval('P1D'));
			#$this->__PRINT_R($fecha->format('Y-m-d'));			
			
			
			
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();

						
			 # 			   ".date("Y-m-d")."'    ADDDATE(currentDate, INTERVAL 13 DAY)			
						
			$option["where"][]="cita =ADDDATE('".date("Y-m-d")."', INTERVAL 1 DAY)";
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				#$option["actions"]["check"]				="false";
				#$option["actions"]["delete"]				="false";
			}	
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";			
			
			$this->sys_fields["laboratorio"]["title"]	="Lab";
			$this->sys_fields["cita_cumplida"]["title"]	="Cita";			
	
			
			#$option["date"]="cita";
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_AYER($option=NULL)
    	{
			#$this->__PRINT_R(DateInterval::createfromdatestring('+1 day'));
			
			#$fecha = new DateTime(date("Y-m-d"));
			#$fecha->add(new DateInterval('P1D'));
			#$this->__PRINT_R($fecha->format('Y-m-d'));			
			
			
			
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();

						
			 # 			   ".date("Y-m-d")."'    ADDDATE(currentDate, INTERVAL 13 DAY)			
						
			$option["where"][]="cita =SUBDATE('".date("Y-m-d")."', INTERVAL 1 DAY)";
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				#$option["actions"]["check"]				="false";
				#$option["actions"]["delete"]				="false";
			}	
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";			
			
			$this->sys_fields["laboratorio"]["title"]	="Lab";
			$this->sys_fields["cita_cumplida"]["title"]	="Cita";			
			
	
			
			#$option["date"]="cita";
			
			return $this->__VIEW_REPORT($option);
		}				
				

   		public function __REPORT_GENERAL($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			$this->sys_fields["unidad"]=array("title"             => "Unidad");
			$this->sys_fields["Ene"]=array("title"             => "Ene");
			$this->sys_fields["Feb"]=array("title"             => "Feb");
			$this->sys_fields["Mar"]=array("title"             => "Mar");
			$this->sys_fields["Abr"]=array("title"             => "Abr");
			$this->sys_fields["May"]=array("title"             => "May");
			$this->sys_fields["Jun"]=array("title"             => "Jun");
			$this->sys_fields["Jul"]=array("title"             => "Jul");
			$this->sys_fields["Ago"]=array("title"             => "Ago");
			$this->sys_fields["Sep"]=array("title"             => "Sep");
			$this->sys_fields["Oct"]=array("title"             => "Oct");
			$this->sys_fields["Nov"]=array("title"             => "Nov");
			$this->sys_fields["Dic"]=array("title"             => "Dic");
			
				
						
			
			if(!isset($option["template_title"]))		$option["template_title"]	                = $this->sys_module . "html/report_general_title";
			$option["template_body"]	                = $this->sys_module . "html/report_general_body";
			#$option["echo"]="a";
		
			$option["select"]=array(
				"trabajador_puesto",				
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-01-',dias),total,0))"=>"Ene",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-02-',dias),total,0))"=>"Feb",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-03-',dias),total,0))"=>"Mar",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-04-',dias),total,0))"=>"Abr",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-05-',dias),total,0))"=>"May",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-06-',dias),total,0))"=>"Jun",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-07-',dias),total,0))"=>"Jul",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-08-',dias),total,0))"=>"Ago",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-09-',dias),total,0))"=>"Sep",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-10-',dias),total,0))"=>"Oct",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-11-',dias),total,0))"=>"Nov",
				"sum(IF(estatus = 'APROVADO' and locate('".date("Y")."-12-',dias),total,0))"=>"Dic",
			);				
			#*/
			$option["from"]="personal_txt";
			
			$option["where"][]="estatus = 'APROVADO'";
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}

			$option["group"]="trabajador_puesto";
			
			$option["actions"]							="false";
			
			/*
			99062212    1ra de junio    Ma sara marquez preciado
			*/						
			return $this->__VIEW_REPORT($option);
		}				

	}
?>
