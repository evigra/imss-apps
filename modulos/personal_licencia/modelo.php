<?php
	class personal_licencia extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"trabajador_nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Trabajador",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),
			"txt_id"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),			
			
			"trabajador_clave"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
  			    "attr"             => array(
					"required",
					"title"			=>"Matricula del trabajador",
			    	"tabindex"		=>"1"			    
			    ),				
			),
			"trabajador_horario"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
  			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    			    

			),
			"trabajador_puesto"	    =>array(
			    "title"             => "Puesto",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    			    
			    
			),
			"trabajador_departamento"	    =>array(
			    "title"             => "Departamento",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"trabajador_departamento_id"	    =>array(
			    "title"             => "Depto ID",
				"title_filter"		=> "Depto ID",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),			

			"sustituto_clave"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"sustituto_nombre"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),						
			"sustituto_horario"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),
			"sustituto_puesto"	    =>array(
			    "title"             => "Puesto",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),
			"sustituto_departamento"	    =>array(
			    "title"             => "Departamento",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"sustituto_departamento_id"	    =>array(
			    "title"             => "DepartamentoID",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),			
			
			/*	
			"dias"	    =>array(
			    "title"             => "Dias",
			    "showTitle"         => "si",
			    "type"              => "multidate",
			    "default"           => "",
			    "value"             => "",			    
			),
			*/			
			"total"	    =>array(
			    "title"             => "Total",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"estatus"	    =>array(
			    "title"             => "Estatus",
				"title_filter"		=> "Estatus",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"clausula"	    =>array(
			    "title"             => "Clausula",
				"title_filter"		=> "Clausula",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    
				"source"			=>array(
					""				=>"",
					"44"			=>"44",
					"41"			=>"41",
				)
				
			),
			
			"articulo"	    =>array(
			    "title"             => "Articulo",
				"title_filter"		=> "Articulo",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",		
				"source"			=>array(
					""				=>"",
					"65"			=>"65",
					"63"			=>"63",
				)
			),
			"fraccion"	    =>array(
			    "title"             => "Fraccion",
				"title_filter"		=> "Fraccion",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    
				"source"			=>array(
					""				=>"",
					"I"				=>"I",
					"II"			=>"II",
					"XVI"			=>"XVI",
				)
				
			),
			"fraccion_clausula"	    =>array(
			    "title"             => "Fraccion",
				"title_filter"		=> "Fraccion",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    
				"source"			=>array(
					""				=>"",
					"I"				=>"I",
					"II"			=>"II",
					"XVI"			=>"XVI",
				)
				
			),
			
			"inciso"	    =>array(
			    "title"             => "Inciso",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    			    
				"source"			=>array(
					""				=>"",
					"A"				=>"A",
					"B"				=>"B",
					"C"				=>"C",
					"D"				=>"D",
					"E"				=>"E",
					"F"				=>"F",
					"G"				=>"G",
					"H"				=>"H",
					"I"				=>"I",
					"J"				=>"J",
					"K"				=>"K",
					"L"				=>"L",
				)
				
			),
			"observacion"	    =>array(
			    "title"             => "Observacion",
			    "showTitle"         => "si",
			    "type"              => "textarea",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"motivo"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"comprovante"	    =>array(
			    "title"             => "Comprovantes",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			

			#/*
			"goce"	    =>array(
			    "title"             => "Goce de sueldo",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),
			#*/
			"inicio"	    =>array(
			    "title"             => "Inicio",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",		
  			    "attr"             => array(
					"required",
					"title"			=>"Inicio de la licencia",
			    	"tabindex"		=>"2",			    
					"placeholder"	=>"AAAA-MM-DD",			    
			    ),					
			),			
			"fin"	    =>array(
			    "title"             => "Fin",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",			    
  			    "attr"             => array(
					"required",
					"title"			=>"Fin de la licencia",
			    	"tabindex"		=>"3",
					"placeholder"	=>"AAAA-MM-DD",			    
					
			    ),					
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
    		## GUARDAR USUARIO
			$datetime1 = new DateTime($datas["inicio"]);
			$datetime2 = new DateTime($datas["fin"]);
			$interval = $datetime1->diff($datetime2);
		
    		$datas["total"]		=$interval->format('%a') +1 ;
    		    		
    	    $user_id=parent::__SAVE($datas,$option);
		}				
   		public function __GENERAR_PDF($option=array("type"=>"unico"))
    	{
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=35;	
			$_SESSION["pdf"]["PAGE"]				=17.6;
			
			if($option["type"]=="unico")			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_primary_id);
			else									$_SESSION["pdf"]["template"]			=$this->__FORMATO_REPORTE($option);
		}		
		public function __FORMATO_REPORTE($option)
		{	

			$template								=$this->__TEMPLATE("modulos/personal_licencia/html/PDF_FORMATO_IMSS_HOR");																				
			$words["sys_titulo"]					="JEFATURA DE SERVICIOS DE DESARROLLO DE PERSONAL";		
			$words["sys_subtitulo"]					="DEPARTAMENTO DE PERSONAL";			
			$words["sys_subtitulo"]					.="<br>OFICINA DE CONTROL DE FUERZA DE TRABAJO";			
						
			$template								=$this->__REPLACE($template,$words);
			
			
	
			$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"] ="L";			
			$_SESSION["pdf"]["HEADER"] =array(
				"body"		=>"$template",
				#"body"		=>"LALO",
				"height"	=>20,				
				"top"		=>60,				
			);
									
						
			return $option["pdf"];			
		}
   		public function __FORMATO($option)
    	{
			$template="";	
			$datos									=$this->__BROWSE($option);
						
			if(@$datos["data"])						$datos=$datos["data"];			
						
			foreach($datos as $dato)
			{
				$words									=$dato;				
				if(is_array($words) AND count($words)>0)
				{	
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO")),$words);
					
					$words["sys_titulo"]					="COORDINACION DE GESTION DE RECURSOS HUMANOS";		
					$words["sys_subtitulo"]					="DEPARTAMENTO DELEGACIONAL DE PERSONAL";					
				
					if(@$dato["trabajador_departamento_id"])
						$words["lugar"]						=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
					$words["fecha"]							=$this->sys_date;		
					
					$words["total_1_3"]						="";
					$words["total_4_60"]					="";
					$words["total_61_365"]					="";
					
					if(@$words["total"]<=3)					$words["total_1_3"]		=" X";
					elseif(@$words["total"]<=60)			$words["total_4_60"]	=" X";
					elseif(@$words["total"]<=365)			$words["total_61_365"]	=" X";
																						
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
					$template								=$this->__REPLACE($template,$words);
				}	
			}	
			return                  					$template;
		}		
   		public function __REPORT_PENDIENTE()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["actions"]							= array();
			
			$option["actions"]["write"]					="true";
			$option["actions"]["show"]					="tre";
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";
			
			
			$option["where"]=array("estatus =''");
			
			#/*
			if($this->__NIVEL_SESION(">=10")==true)	 // NIVEL SUPER ADMINISTRADOR 			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			#$option["echo"]="PENDIENTE";
			#*/
			
			if(@$this->request["sys_order_personal_licencia"]=="")
				$option["order"]="inicio desc";			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_APROVADO()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["where"]=array("estatus = 'APROVADO'");

			$option["actions"]							= array();
			$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
			$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";

			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			if(@$this->request["sys_order_personal_licencia"]=="")
				$option["order"]="inicio desc";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_CANCELADOS()
    	{
			$option=array();			
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
   		public function __REPORT_LICENCIA($option="")
    	{
			
			if($option=="")	$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_licencia_title";
			$option["template_body"]	                = $this->sys_module . "html/report_licencia_body";
			
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $this->__NIVEL_SESION(\">=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				$option["actions"]["check"]					="false";
				$option["actions"]["delete"]				="false";
			}	
			if(!isset($option["where"]))					$option["where"]=Array();
			
			$option["where"][]="goce!=1";				
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			if(@$this->request["sys_order_personal_licencia"]=="")
				$option["order"]="inicio desc";
			
			
			
			return $this->__VIEW_REPORT($option);
		}
   		public function __REPORTE($option="")
    	{
			
			if($option=="")	$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_estatus_title";
			$option["template_body"]	                = $this->sys_module . "html/report_estatus_body";
			
			
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
			if(@$this->request["sys_order_personal_licencia"]=="")
				$option["order"]="id desc";
								
			return $this->__VIEW_REPORT($option);
		}						

   		public function __REPORT_ESPECIFICO()
    	{
			$this->sys_fields["departamento_id"]	=array("title"             => "Departamento");
			$this->sys_fields["puesto_id"]			=array("title"             => "Categoria");
			$this->sys_fields["jornada"]			=array("title"             => "Jornada");

				## GUARDAR USUARIO
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_especifico_title";
			$option["template_body"]	                = $this->sys_module . "html/report_especifico_body";
			
			$option["select"]=array(				
				"trabajador_clave",
				"left(departamento_id,6)"	=>"departamento_id",
				"right(puesto_id,2)"		=>"jornada",
				"puesto_id",				
				"sum(total)"				=>"total",
			);				
			$option["where"]=array(
				"dias LIKE '%-". date("m")."-%'",	
				"estatus = 'APROVADO'"
			);			
			
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			
			$option["from"]="personal_txt join plazas on trabajador_clave=matricula";
			$option["group"]="trabajador_clave";
			
			$option["actions"]							="false";
			
			#$option["echo"]="REPORT1";
			
			/*
			99062212    1ra de junio    Ma sara marquez preciado			
			*/						
			return $this->__VIEW_REPORT($option);
		}				

   		public function __REPORT_GENERAL()
    	{
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
			
				## GUARDAR USUARIO
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_general_title";
			$option["template_body"]	                = $this->sys_module . "html/report_general_body";
			
			$option["select"]=array(
				"trabajador_puesto",
				#"IF(LOCATE('/1/',dias)>0,SUM(total),0)"=>"Ene",
				"IF(locate('-01-',group_concat(inicio))>0,sum(total),0)"=>"Ene",
				"IF(locate('-02-',group_concat(inicio))>0,sum(total),0)"=>"Feb",
				"IF(locate('-03-',group_concat(inicio))>0,sum(total),0)"=>"Mar",
				"IF(locate('-04-',group_concat(inicio))>0,sum(total),0)"=>"Abr",
				"IF(locate('-05-',group_concat(inicio))>0,sum(total),0)"=>"May",
				"IF(locate('-06-',group_concat(inicio))>0,sum(total),0)"=>"Jun",
				"IF(locate('-07-',group_concat(inicio))>0,sum(total),0)"=>"Jul",
				"IF(locate('-08-',group_concat(inicio))>0,sum(total),0)"=>"Ago",
				"IF(locate('-09-',group_concat(inicio))>0,sum(total),0)"=>"Sep",
				"IF(locate('-10-',group_concat(inicio))>0,sum(total),0)"=>"Oct",
				"IF(locate('-11-',group_concat(inicio))>0,sum(total),0)"=>"Nov",
				"IF(locate('-12-',group_concat(inicio))>0,sum(total),0)"=>"Dic",
			);				
			$option["from"]="personal_licencia join plazas on trabajador_clave=matricula";
			$option["where"]=array(
				"inicio LIKE '%-". date("m")."-%'",	
				"estatus = 'APROVADO'"
			);
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}

			$option["group"]="trabajador_puesto";
			#$option["echo"]="GROUP trabajador_puesto";
			
			$option["actions"]							="false";
			
			/*
			99062212    1ra de junio    Ma sara marquez preciado
			*/						
			return $this->__VIEW_REPORT($option);
		}				
	}
?>

