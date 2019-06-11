<?php
	class modulo extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu			=array();
		var $sys_enviroments	="DEVELOPER";
		var $sys_table			="modulos";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"clase"	    =>array(
			    "title"             => "Clase",
			    "type"              => "input",
			),			
			"Descripcion"	    =>array(
			    "title"             => "Descripcion",
				"title_filter"      => "Nombre",
			    "type"              => "input",
			    "attr"             => array(
			    	"readonly"=>"readonly"
			    ),			    			    
  			    "style"             => array(			    	
					"color"=>array("red"=>"1==1"),
					"font-size"=>array("25px"=>"1==1"),					
			    ),			    			    
				
			),		
			/*
			"campos"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "modulos_fields",			    
				#"class_template"  	=> "many2one_lateral",			    
				"class_report" 		=> "kanban",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "modulo_id",				
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
    		#$datas["total"]		=count(explode(",",$datas["dias"]));
			#$datas["registro"]=$this->sys_date;
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
			
			$datas["cptos_fijos"]		=count($datas["fijos_ids"]);		
			$datas["cpto_1vez"]			=count($datas["conceptos_ids"]);		
			$datas["hist_acum"]			=count($datas["historicos_ids"]);		
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
			
			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_primary_id);
		}		
   		public function __FORMATO($option)
    	{



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
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["where"]=array("estatus = 'APROVADO'");

			$option["actions"]							= array();
			$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
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
   		public function __REPORT_SUSTITUTO($option="")
    	{
			
			if($option=="")	$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/report_sustituto_title";
			$option["template_body"]	                = $this->sys_module . "html/report_sustituto_body";
			
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $this->__NIVEL_SESION(\">=20\")==true";
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
			$option["template_title"]	                = $this->sys_module . "html/report_general_title";
			$option["template_body"]	                = $this->sys_module . "html/report_general_body";
			
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

