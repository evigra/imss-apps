<?php
	class personal_pase extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"trabajador_nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Trabajador",
			    "type"              => "input",
			    "attr"             => array(				
			    	"readonly"=>"readonly"
			    ),			    			    
			),
			"trabajador_clave"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "type"              => "input",
			    "attr"             => array(
					"required",
			    ),			    			    
				
			),
			"trabajador_horario"	    =>array(
			    "title"             => "Horario",
			    "type"              => "input",
  			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    			    

			),
			"trabajador_puesto"	    =>array(
			    "title"             => "Puesto",
			    "type"              => "input",
			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    			    
			    
			),
			"trabajador_departamento"	    =>array(
			    "title"             => "Departamento",
				"title_filter"		=> "Departamento",
			    "type"              => "input",
			    "attr"             => array(					
			    	"readonly"=>"readonly"
			    ),			    
			),										
			"trabajador_departamento_id"	    =>array(
			    "title"             => "ID Departamento",
			    "type"              => "input",
			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    
			),										

			"dias"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "date",
			),
			"tipo"	    =>array(
			    "title"             => "Tipo",
				"title_filter"		=> "Tipo",
			    "type"              => "select",
			    "default"           => "Personal",
			    "attr"             => array(
					"required",
			    ),				
			    "source"             => Array(
					""=>"Selecciona",
					"Particular"	=>"Particular",
					"Oficial"		=>"Oficial",
					"Medico"		=>"Medico"
					
				),			    
			),
			"entrada_salida"	    =>array(
			    "title"             => "Registro",
				"title_filter"		=> "Registro",
			    "type"              => "select",
			    "default"           => "",
			    "attr"             => array(
					"required",
			    ),				
			    "source"             => Array(
					""=>"Selecciona",
					"Entrada"		=>"Entrada",
					"Intermedio"	=>"Intermedio",
					"Salida"		=>"Salida"					
				),			    
			),			
			"ocurrir"	    =>array(
			    "title"             => "a Ocurrir a",
			    "type"              => "input",
			),			
			"objeto"	    =>array(
			    "title"             => "con Objeto de",
			    "type"              => "input",
			),			
			"hora"	    =>array(
			    "title"             => "Hora",
			    "type"              => "input",
			),
			"estatus"	    =>array(
			    "title"             => "Estatus",
			    "type"              => "hidden",
			),			
			"folio"	    =>array(
			    "title"             => "Folio",
			    "type"              => "hidden",
			),				
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
        /*
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();			
		}
		#*/
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    		#$datas["total"]		=count(explode(",",$datas["dias"]));			
			if(!isset($datas["folio"]) OR $datas["folio"]=="")
			{	
				$option_folio=array();
				$option_folio["variable"]= substr($datas["trabajador_departamento_id"],0,6);
				$option_folio["subvariable"]= date ("Y");
				$option_folio["tipo"]	= "folio";
				$option_folio["subtipo"]= "";
				$option_folio["objeto"]= "personal_pase";
				
				$datas["folio"]=$this->__FOLIOS($option_folio);
			}	

    	    return parent::__SAVE($datas,$option);
		}				
   		public function __GENERAR_PDF()
    	{
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_private["id"]);
		}		
   		public function __FORMATO($option)
    	{
			$template="";	
			$datos										=$this->__BROWSE($option);
			
			$this->__PRINT_R($datos);
			
			if(@$datos["data"])							$datos=$datos["data"];			
			
			foreach($datos as $dato)
			{
				$words									=$dato;			
				
				$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
				$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
				$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));
				
				$words["trabajador_departamento"]		=str_replace("-","&nbsp;",str_pad($words["trabajador_departamento"], 40,"-"));
				$words["objeto"]						=str_replace("-","&nbsp;",str_pad($words["objeto"], 140,"-"));
				$words["ocurrir"]						=str_replace("-","&nbsp;",str_pad($words["ocurrir"], 140,"-"));
				$words["hora"]							=str_replace("-","&nbsp;",str_pad($words["hora"], 20,"-"));
				#$words["hora"]							=str_pad($words["hora"], 15,"");
				
				
				$words["Entrada"]						=" &nbsp;  &nbsp; ";
				$words["Salida"]						=" &nbsp;  &nbsp; ";
				$words["Intermedio"]					=" &nbsp;  &nbsp; ";
				
				$words["Oficial"]						=" &nbsp;  &nbsp; ";
				$words["Particular"]					=" &nbsp;  &nbsp; ";				
				$words["Medico"]						=" &nbsp;  &nbsp; ";
				
				
				$words[ $dato["entrada_salida"] ]		="&nbsp;<b>X</b>&nbsp;";
				$words[ $dato["tipo"] ]					="&nbsp;<b>X</b>&nbsp;";
				
				
				if(is_array($words) AND count($words)>0)
				{	
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_var["module_path"] . "html/PDF_FORMATO")),$words);
					
					$words["sys_titulo"]					="DELEGACION REGIONAL COLIMA";		
					$words["sys_subtitulo"]					="";		
					$words["sys_titulo2"]					="CONSTANCIA DE PASE";		
					$words["sys_subtitulo2"]				="";		
					$words["sys_pie"]						="Nota: Para considerarse el pase como oficial o medico, este debera contar con el correspondiente sello o documento anexo 
																comprobatorio que certifica la presencia del trabajador en la dependencia oficial de destino
					";							
				
					if(@$dato["trabajador_departamento_id"])
						$words["lugar"]						=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
					$words["fecha"]							=$this->sys_date;		
					#$words["fecha"]							="2017-09-21";		
																											
					$template								.=$this->__TEMPLATE2("sitio_web/html/PDF_FORMATO_IMSS2_TIT2");
					$template								=$this->__REPLACE($template,$words);
				}	

			}	

			return                  					$template;
		}	

   		public function __REPORT_PENDIENTE()
    	{
			$option=array();			
			$option["actions"]							= array();
			
			$option["actions"]["write"]					="true";
			$option["actions"]["show"]					="tre";
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";
			
			$option["order"]="id desc";
			$option["where"]=array("estatus =''");
			
			#/*
			if($this->__NIVEL_SESION(">=10")==true)	 // NIVEL SUPER ADMINISTRADOR 			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			#$option["echo"]="PENDIENTE";
			#*/
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_APROVADO()
    	{
			$option=array();			
			
			$option["where"]=array("estatus = 'APROVADO'");

			$option["actions"]							= array();
			$option["actions"]["write"]					="$"."row[\"estatus\"]==''";
			$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
			$option["actions"]["check"]					="false";
			$option["actions"]["delete"]				="false";

			$option["order"]="id desc";
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_CANCELADOS()
    	{
			$option=array();			
			
			$option["where"]=array("estatus = 'CANCELADO'");

			$option["actions"]							="false";

			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
			}			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORTE($option="")
    	{
			
			if($option=="")	$option=array();			
			
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
			$option["template_title"]	                = $this->sys_var["module_path"] . "html/report_especifico_title";
			$option["template_body"]	                = $this->sys_var["module_path"] . "html/report_especifico_body";
			
			$option["select"]=array(				
				"trabajador_clave",
				"left(departamento_id,6)"	=>"departamento_id",
				"right(puesto_id,2)"		=>"jornada",
				"puesto_id",				
				"sum(total)"				=>"total",
			);				
			$option["where"]=array(
				"dias LIKE '%/". date("n")."/%'",	
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
			$option["template_title"]	                = $this->sys_var["module_path"] . "html/report_general_title";
			$option["template_body"]	                = $this->sys_var["module_path"] . "html/report_general_body";
			
			$option["select"]=array(
				"trabajador_puesto",
				#"IF(LOCATE('/1/',dias)>0,SUM(total),0)"=>"Ene",
				"IF(locate('/1/',group_concat(dias))>0,sum(total),0)"=>"Ene",
				"IF(locate('/2/',group_concat(dias))>0,sum(total),0)"=>"Feb",
				"IF(locate('/3/',group_concat(dias))>0,sum(total),0)"=>"Mar",
				"IF(locate('/4/',group_concat(dias))>0,sum(total),0)"=>"Abr",
				"IF(locate('/5/',group_concat(dias))>0,sum(total),0)"=>"May",
				"IF(locate('/6/',group_concat(dias))>0,sum(total),0)"=>"Jun",
				"IF(locate('/7/',group_concat(dias))>0,sum(total),0)"=>"Jul",
				"IF(locate('/8/',group_concat(dias))>0,sum(total),0)"=>"Ago",
				"IF(locate('/9/',group_concat(dias))>0,sum(total),0)"=>"Sep",
				"IF(locate('/10/',group_concat(dias))>0,sum(total),0)"=>"Oct",
				"IF(locate('/11/',group_concat(dias))>0,sum(total),0)"=>"Nov",
				"IF(locate('/12/',group_concat(dias))>0,sum(total),0)"=>"Dic",
			);				
			$option["from"]="personal_txt join plazas on trabajador_clave=matricula";
			$option["where"]=array(
				"dias LIKE '%/". date("n")."/%'",	
				"estatus = 'APROVADO'"
			);
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
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
