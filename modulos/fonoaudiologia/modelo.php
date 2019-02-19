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
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"nss"	    =>array(
			    "title"             => "NSS",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"             => array(		
					"required",					
			    ),				
				
			),			
			"nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"      => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
  			    "style"             => array(			    	
					"color"=>array("red"=>"1==1"),
					"font-size"=>array("25px"=>"1==1"),					
			    ),			    			    
				
			),		
			"agregado"	    =>array(
			    "title"             => "Agregado",				
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
			),
			"conceptos_ids"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "incapacidad",			    
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
			
			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_primary_id);
		}		
   		public function __FORMATO($option)
    	{
			$template="";	
			$datos										=$this->__BROWSE($option);
			
			if(@$datos["data"])							$datos=$datos["data"];			
						
			foreach($datos as $dato)
			{
				/*	
				$conceptos_ids_options=array(					
					"where"=>array(
						"calculo_id={$dato["id"]}"
					)
				);
				*/
				$words									=$dato;				
				$hoja2=0;
				if(is_array($words) AND count($words)>0)
				{	
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");							
					
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO")),$words);
					
					$words["sys_titulo"]					="COORDINACION DE GESTION DE RECURSOS HUMANOS";		
					$words["sys_subtitulo"]					="DEPARTAMENTO DELEGACIONAL DE PERSONAL";					
				
					if(@$dato["trabajador_departamento_id"])
						$words["lugar"]						=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
					$words["fecha"]							=$this->sys_date;		
					
					#####################################
					/*
					$datas_conceptos=$this->conceptos_ids_obj->__BROWSE($conceptos_ids_options);		
					if($datas_conceptos["total"]>0)
					{						
						$a=0;
						foreach($datas_conceptos["data"] as $data_conceptos)
						{
							$a++;	
							if(!isset($words["CP1V_matricula$a"]))
							{
								if($a==2 AND $hoja2==0)	
								{	
									$hoja2=1;
									$template					.="<br><br>".$this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO2");						
								}	
							}
						}
					}
*/					
					#####################################
					/*
					$datas_fijos=$this->fijos_ids_obj->__BROWSE($conceptos_ids_options);					
					if($datas_fijos["total"]>0)
					{								
						$a=0;
						foreach($datas_fijos["data"] as $data_conceptos)
						{
							$a++;	
							if(!isset($words["CPF1_matricula$a"]))
							{								
								if($a==2 AND $hoja2==0)	
								{	
									$hoja2=1;
									$template					.="<br><br>".$this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO2");						
								}	
								$words["CPF1_matricula$a"]		=$datos[0]["trabajador_clave"];
								$words["CPF1_con$a"]			=@$data_conceptos["con"];
								$words["CPF1_imp$a"]			=@$data_conceptos["imp"];
								$words["CPF1_uni$a"]			=@$data_conceptos["uni"];																																
								$words["CPF1_cif$a"]			=@$data_conceptos["cif"];								
								$words["CPF1_ini$a"]			=@$data_conceptos["ini"];								
								$words["CPF1_fin$a"]			=@$data_conceptos["fin"];								
								$words["CPF1_noc$a"]			=@$data_conceptos["noc"];								
								$words["CPF1_des$a"]			=@$data_conceptos["des"];								
							}

						}
					}						
					#####################################
					$datas_fijos=$this->historicos_ids_obj->__BROWSE($conceptos_ids_options);					
					if($datas_fijos["total"]>0)
					{								
						$a=0;
						foreach($datas_fijos["data"] as $data_conceptos)
						{
							$a++;	
							if(!isset($words["H1_matricula$a"]))
							{								
								if($a==2 AND $hoja2==0)	
								{	
									$hoja2=1;
									$template					.="<br><br>".$this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO2");						
								}	
								$words["H1_matricula$a"]		=$datos[0]["trabajador_clave"];
								$words["H1_con$a"]				=@$data_conceptos["con"];
								$words["H1_imp_s$a"]			=@$data_conceptos["imp_s"];
								$words["H1_imp_r$a"]			=@$data_conceptos["imp_r"];
								$words["H1_uni_s$a"]			=@$data_conceptos["uni_s"];			
								$words["H1_uni_r$a"]			=@$data_conceptos["uni_r"];			
								$words["H1_des$a"]				=@$data_conceptos["des"];								
								$words["H1_dic$a"]				=@$data_conceptos["dic"];								
								$words["H1_deb$a"]				=@$data_conceptos["deb"];								
								$words["H1_mes$a"]				=@$data_conceptos["mes"];								
							}
						}
					}						
					*/
					for($a=1; $a<7;$a++)
					{	
						if(!isset($words["CPF1_matricula$a"]))
						{
							$words["CPF1_matricula$a"]	="";
							$words["CPF1_con$a"]		="";
							$words["CPF1_imp$a"]		="";
							$words["CPF1_uni$a"]		="";
							$words["CPF1_cif$a"]		="";
							$words["CPF1_ini$a"]		="";
							$words["CPF1_fin$a"]		="";						
							$words["CPF1_noc$a"]		="";						
							$words["CPF1_des$a"]		="";						
							
						}						
						if(!isset($words["H1_matricula$a"]))
						{
							$words["H1_matricula$a"]		="";
							$words["H1_con$a"]				="";
							$words["H1_imp_s$a"]			="";
							$words["H1_imp_r$a"]			="";
							$words["H1_uni_s$a"]			="";
							$words["H1_uni_r$a"]			="";
							$words["H1_des$a"]				="";
							$words["H1_dic$a"]				="";
							$words["H1_deb$a"]				="";
							$words["H1_mes$a"]				="";
							
						}							
						if(!isset($words["CP1V_matricula$a"]))
						{
							$words["CP1V_matricula$a"]	="";
							$words["CP1V_con$a"]		="";
							$words["CP1V_imp$a"]		="";
							$words["CP1V_uni$a"]		="";
							$words["CP1V_dia$a"]		="";
							$words["CP1V_jor$a"]		="";
							$words["CP1V_fac$a"]		="";
							$words["CP1V_bas$a"]		="";
							$words["CP1V_mar$a"]		="";
							$words["CP1V_cif$a"]		="";
							$words["CP1V_des$a"]		="";
							$words["CP1V_ini$a"]		="";
							$words["CP1V_fin$a"]		="";							
						}						
						
					}						
					$template								=$this->__REPLACE($template,$words);
					
					#$this->__PRINT_R($datas_conceptos);	
					
					
					/*
					if($datos[0]["concepto_2"]>0)
					{			
						$template							.=$this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO2");						
						$words["matricula3_2"]				=$datos[0]["trabajador_clave"];
						
						$template							=$this->__REPLACE($template,$words);				
					}
					*/
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
   		public function __REPORT_DEV()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/dev/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/dev/report_pie_pdf";
						
			$option["actions"]							="false";			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
						
			$option["where"][]="fecha_devolucion !='0000-00-00'";	
			$option["date"]="fecha_devolucion";	
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_FS()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/dev/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/dev/report_pie_pdf";
						
			$option["actions"]							="false";			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
						
			$option["where"][]="fecha_fs !='0000-00-00'";	
			$option["date"]="fecha_fs";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_SI()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/dev/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/dev/report_pie_pdf";
						
			$option["actions"]							="false";			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
						
			$option["where"][]="fecha_calificacion !='0000-00-00'";	
			$option["where"][]="texto_calificacion LIKE '%SI%'";	
			$option["date"]="fecha_calificacion";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_NO()
    	{
			$option=array();			
			$option["template_title"]	                = $this->sys_module . "html/dev/report_title";
			$option["template_body"]	                = $this->sys_module . "html/dev/report_body";
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/dev/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/dev/report_pie_pdf";
						
			$option["actions"]							="false";			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
						
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
			$option["template_asunto_pdf"]	            = $this->sys_module . "html/dev/report_asunto_pdf";
			$option["template_pie_pdf"]	            	= $this->sys_module . "html/dev/report_pie_pdf";
						
			#$option["actions"]							="false";			
			$option["select"]							="a.*, i.*";
			$option["from"]								="asegurado a left join incapacidad i on a.id=i.asegurado_id";
						
			$option["where"][]="solicitud_incapacidad !='0000-00-00'";	
			$option["date"]="solicitud_incapacidad";			
			
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


	}
?>

