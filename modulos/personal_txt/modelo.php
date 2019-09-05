<?php
	class personal_txt extends general
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
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    "attr"            	=> array(					
					"title"			=>"Nombre del trabajador",
			    	"readonly"		=>"readonly"
			    ),			    			    
  			    "style"             => array(			    	
					"color"			=>array("red"=>"1==1"),
					"font-size"		=>array("25px"=>"1==1"),					
			    ),			    			    
			),
			"trabajador_clave"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula Trabajador",
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
			    "type"              => "autocomplete",
			    "default"           => "",
				"source"			=> "../modulos/horario/ajax/index.php",
				
				#"vars"				=> "?turno=\" + $(\"select#trabajador_turno option:selected\").val() + \"",
			    "value"             => "",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "horario",			    
			    "class_field_o"    	=> "trabajador_horario",
			    "class_field_m"    	=> "horario_id",				
				"class_field_l"    	=> "horario",	
				"write"				=>array(
					"style"         =>array(
						"border"	=>array("red"=>"$"."this->sys_fields[\"trabajador_turno\"][\"value\"]==$"."this->sys_fields[\"sustituto_turno\"][\"value\"] AND $"."this->sys_fields[\"trabajador_turno\"][\"value\"]!=\"\"")
					),			    			    
				),	
				
  			    "attr"             => array(
					"title"			=>"Horario del trabajador",
			    	"readonly"		=>"readonly",
					"tabindex"		=>"3"
			    ),			    			    				
			),
			"trabajador_puesto"	    =>array(
			    "title"             => "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=> array(
			    	"readonly"		=>"readonly"
			    ),		
				"write"				=>array(	
					"style"         =>array(
						"border"	=>array("red"=>"$"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"]!=\"\" AND (substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],2,4) != substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],2,4)     OR (substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],2,4) == substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],2,4) AND substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],0,2) > substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],0,2)))")	
					),	
				)
				
				
				
			),
			"trabajador_puesto_id"	    =>array(
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
			    "title"             => "DepartamentoID",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"trabajador_turno"	    =>array(
			    "title"             => "Turno",				
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",		
			    "attr"             => array(
					"readonly"=>"readonly",
					"tabindex"		=>"2"
			    ),					
				
				"source"			=>array(
					""				=>"Seleccciona un Turno",
					"1"				=>"Matutino",
					"2"				=>"Vespertino",
					"3"				=>"Nocturno",
					"4"				=>"Movil",
					"5"				=>"Jornada Acumulada",
				)		
			),			

			"sustituto_clave"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Sustituto Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=>array(
					"required",
					"tabindex"		=>"4"
			    ),				
			),
			"sustituto_nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Sustituto Trabajador",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),						
			"sustituto_horario"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    "default"           => "",
				"source"			=> "../modulos/horario/ajax/index.php",
				
				#"vars"				=> "?turno=\" + $(\"select#trabajador_turno option:selected\").val() + \"",
			    "value"             => "",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "horario",			    
			    "class_field_o"    	=> "sustituto_horario",
			    "class_field_m"    	=> "horario_id",				
				"class_field_l"    	=> "horario",				
  			    "attr"             => array(
			    	"readonly"		=>"readonly",
					"tabindex"		=>"6"

			    ),			    			    
				"write"				=>array(
					"style"         => array(
						"border"=>array("red"=>"$"."this->sys_fields[\"trabajador_turno\"][\"value\"]==$"."this->sys_fields[\"sustituto_turno\"][\"value\"] AND $"."this->sys_fields[\"trabajador_turno\"][\"value\"]!=\"\"")
					),			    			    
				),	
				
			),
			"sustituto_puesto"	    =>array(
			    "title"             => "Puesto",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",		
				"write"				=>array(	
					"style" 		=>array(
						"border"	=>array("red"=>"(substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],2,4) != substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],2,4)     OR (substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],2,4) == substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],2,4) AND substr($"."this->sys_fields[\"trabajador_puesto_id\"][\"value\"],0,2) > substr($"."this->sys_fields[\"sustituto_puesto_id\"][\"value\"],0,2))) AND $"."this->sys_fields[\"trabajador_puesto_id\"]!=\"\"")	
					),	
				),	
				
			),
			"sustituto_puesto_id"	    =>array(
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
			"sustituto_turno"	    =>array(
			    "title"             => "Turno",
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",		
			    "attr"             => array(
					"readonly"=>"readonly",
					"tabindex"		=>"5"
			    ),					
				"source"			=>array(
					""				=>"Seleccciona un Turno",
					"1"				=>"Matutino",
					"2"				=>"Vespertino",
					"3"				=>"Nocturno",
					"4"				=>"Movil",
					"5"				=>"Jornada Acumulada",
				)			    
			),			
			
			"dias"	    =>array(
			    "title"             => "Dias",
				"title_filter"		=> "Dia solicitado",
			    "showTitle"         => "si",
			    "type"              => "multidate",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"             => array(
					"required",
			    ),					
			),						
			"total"	    =>array(
			    "title"             => "Total",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"estatus"	    =>array(
			    "title"             => "Estatus",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"acs"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_acs",			    	   
			),			
			"licencia"	    =>array(
			    "relation"          => "one2many",
			    "type"              => "class",			    	   
				"class_name"        => "personal_licencia",			    	   
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
			$guardar=1;	
    		## GUARDAR USUARIO
			#$this->__PRINT_R($datas);
			
			
			$dias										=explode(",",$datas["dias"]);
			
			
			
			if(@!$datas["departamento_id"])				$datas["departamento_id"]				=@$_SESSION["departamento_id"];
			if(@!$datas["trabajador_departamento"])		$datas["trabajador_departamento"]		="Trabajador 08";
			
			
    		$datas["total"]								=count($dias);    	

			
			#$this->__PRINT_R($this->sys_section_personal_txt);
			
			if($this->sys_section_personal_txt=="create")
			{
				$option_where								=array("where");
				$option_where["where"][]					="trabajador_clave='{$datas["trabajador_clave"]}'";
				$option_where["where"][]					="sustituto_clave='{$datas["sustituto_clave"]}'";
				$option_where["where"][]					="dias like '%{$datas["dias"]}%'";
				
				$data_where									=$this->__BROWSE($option_where);
				
				if($data_where["total"]>0)	
				{	
					$guardar=0;				
					
					$this->__PRINT							="Favor de verificar, <br>> Datos repetidos";
					$this->__PRINT_OPTION					=array(
						"title"		=>"ERROR, Mensaje del Sistema",
						"time"		=>"5000"
					);
					
				}	
			}		
			
			
			if($guardar==1)
			{	
			
				$id											=parent::__SAVE($datas);

			
				
				## LICENCIA ###########################################"##				
				$data_licencia								=array();
				$data_licencia["trabajador_clave"]			=@$datas["sustituto_clave"];
				$data_licencia["trabajador_nombre"]			=@$datas["sustituto_nombre"];
				$data_licencia["trabajador_puesto"]			=@$datas["sustituto_puesto"];
				$data_licencia["trabajador_puesto_id"]		=@$datas["sustituto_puesto_id"];
				$data_licencia["trabajador_horario"]		=@$datas["sustituto_horario"];
				$data_licencia["trabajador_departamento"]	=@$datas["sustituto_departamento"];
				$data_licencia["trabajador_departamento_id"]=@$datas["sustituto_departamento_id"];
				
				$data_licencia["sustituto_clave"]			=@$datas["trabajador_clave"];
				$data_licencia["sustituto_nombre"]			=@$datas["trabajador_nombre"];			
				$data_licencia["sustituto_horario"]			=@$datas["trabajador_horario"];
				$data_licencia["sustituto_departamento"]	=@$datas["trabajador_departamento"];			
				$data_licencia["sustituto_departamento_id"]	=@$datas["trabajador_departamento_id"];	
				$data_licencia["estatus"]					=@$datas["estatus"];
				$data_licencia["txt_id"]					=@$id;

						
				$comando_sql="DELETE FROM personal_licencia WHERE txt_id='$id'";
				$this->__EXECUTE($comando_sql);

				$comando_sql="DELETE FROM personal_acs WHERE txt_id='$id'";
				$this->__EXECUTE($comando_sql);
				
							
				$fin="";		
				foreach($dias as $index => $actual)
				{
					if(@$inicio=="")							$inicio=$actual;
					
					$dia_actual_aux								=new DateTime($actual);				
					$dia_actual_aux->add(new DateInterval('P1D'));
					$dia_actual									=@$dia_actual_aux->format('Y-m-d');
					
					$fecha_fin_aux								=new DateTime(@$dias[$index + 1]);								
					$fecha_fin									=@$fecha_fin_aux->format('Y-m-d');
									
					if($dia_actual!=@$fecha_fin)				$fin=$actual;
					if($fin!="")
					{						
						if(@$datas["estatus"]=="" OR @$datas["estatus"]=="APROVADO" OR (@$datas["estatus"]=="CANCELADO" AND @$this->licencia_obj->sys_primary_id>0))
						{	
							$this->licencia_obj->sys_primary_id="";
							$data_licencia["inicio"]		=$inicio;
							$data_licencia["fin"]			=$fin;
							$this->licencia_obj->__SAVE($data_licencia);					
						}	
						$inicio							="";						
						$fin							="";
					}	
				}		
				
				## ACS ###################################################		
				
				$horario_inicio_t	=trim(substr(@$datas["trabajador_horario"],0,5));
				$horario_fin_t		=trim(substr(@$datas["trabajador_horario"],8,6));
				
				#$this->__PRINT_R(array($horario_inicio_t,$horario_fin_t));
				#$this->__PRINT_R($datas);
				
				for($a=@$horario_inicio_t; $a<=@$horario_fin_t; $a=$a+0.01)
				{
					$horario_t[]=$a;
				}
				
				$horario_inicio_s	=trim(substr(@$datas["sustituto_horario"],0,5));
				$horario_fin_s		=trim(substr(@$datas["sustituto_horario"],8,6));
				
				$horario_s=Array();
				if(@$horario_inicio_s>0 AND @$horario_fin_s>0)
				{	
					for($a=$horario_inicio_s; $a<=$horario_fin_s; $a=$a+0.01)
					{
						$horario_s[]=$a;
					}
				}	
				#$this->__PRINT_R(array($horario_t,$horario_s));
				$traslape = @array_intersect(@$horario_t,@$horario_s);			
				#$this->__PRINT_R($traslape);
				
				if(count($traslape)>0)
				{	
					$option_acs									=array();
					$option_acs["where"]						=array();
					$option_acs["where"][]						="txt_id='$id'";
					$datos_acs									=$this->acs_obj->__BROWSE($option_acs);
				
					$data_acs									=array();
					$data_acs["trabajador_clave"]				=$datas["sustituto_clave"];
					$data_acs["trabajador_nombre"]				=$datas["sustituto_nombre"];
					$data_acs["trabajador_puesto"]				=$datas["sustituto_puesto"];
					$data_acs["trabajador_puesto_id"]			=$datas["sustituto_puesto_id"];
					$data_acs["trabajador_horario"]				=$datas["sustituto_horario"];
					$data_acs["trabajador_departamento"]		=@$datas["sustituto_departamento"];
					$data_acs["trabajador_departamento_id"]		=@$datas["sustituto_departamento_id"];
					
					$data_acs["sustituto_clave"]				=$datas["trabajador_clave"];
					$data_acs["sustituto_nombre"]				=$datas["trabajador_nombre"];			
					$data_acs["sustituto_horario"]				=$datas["trabajador_horario"];
					$data_acs["sustituto_departamento"]			=$datas["trabajador_departamento"];			
					$data_acs["sustituto_departamento_id"]		=@$datas["trabajador_departamento_id"];
					$data_acs["dias"]							=$datas["dias"];
					$data_acs["estatus"]						=@$datas["estatus"];
					$data_acs["txt_id"]							=$id;

					if($datos_acs["total"]!=0)				$this->acs_obj->sys_primary_id		=$datos_acs["data"]["0"]["id"];						
					if(@$datas["estatus"]=="APROVADO" OR (@$datas["estatus"]=="CANCELADO" AND @$this->acs_obj->sys_primary_id>0))
					{	
						$this->acs_obj->__SAVE($data_acs);
					}	
				}	
			}			
		}			
		
   		public function __FORMATO()
    	{
			$datos									=$this->__BROWSE($this->sys_primary_id);
			$words									=$datos[0];				
			$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO")),$words);
			
			$words["sys_titulo"]					="SOLICITUD DE CONVENIO";		
			$words["sys_subtitulo"]					="TRABAJADOR POR TRABAJADOR";		
		
			$words["lugar"]							=$this->lugar(substr($words["trabajador_departamento_id"],0,6));		
			$words["fecha"]							=$this->sys_date;		

			@$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS_SNTSS");														
			$template                 				=$this->__REPLACE($template,$words); 			
			
			if($this->sys_fields["estatus"]["value"]=="APROVADO" OR $this->sys_fields["estatus"]["value"]=="")
			{				
				if($this->sys_fields["estatus"]["value"]=="APROVADO")
				{
					$option								=array("where"=>array("txt_id={$this->sys_primary_id}"));											
					$template							.=$this->licencia_obj->__FORMATO($option);		
					
					$option								=array("where"=>array("txt_id={$this->sys_primary_id}"));											
					$template							.=$this->acs_obj->__FORMATO($option);		
					
				}		
			}	
			else 
			{				
				$words["tramite_solicitado"]			="TRABAJADOR POR TRABAJADOR";			
				$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_CANCELADO");			
				$template                   			=$this->__REPLACE($template,$words); 						
			}
			
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
			
			$option["order"]="id desc";
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
			
			

			$option["order"]="id desc";
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
			
			$option["order"]="id desc";
			
			
			
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
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
				#$option["echo"]="REPORT";
			}
			
			$option["order"]="id desc";
			
			return $this->__VIEW_REPORT($option);
		}						

   		public function __REPORT_ESPECIFICO($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();


			$this->sys_fields["departamento_id"]	=array("title"             => "Departamento");
			$this->sys_fields["puesto_id"]			=array("title"             => "Categoria");
			$this->sys_fields["jornada"]			=array("title"             => "Jornada");

				## GUARDAR USUARIO
		
			$option["template_title"]	                = $this->sys_module . "html/report_especifico_title";
			$option["template_body"]	                = $this->sys_module . "html/report_especifico_body";
			
			$option["select"]=array(				
				"trabajador_clave",
				"left(departamento_id,6)"	=>"departamento_id",
				"right(puesto_id,2)"		=>"jornada",
				"puesto_id",				
				"sum(total)"				=>"total",
			);				
			$option["where"][]="dias LIKE '".date("Y")."-". date("m")."-%'";
			$option["where"][]="estatus = 'APROVADO'";
			
			if($this->__NIVEL_SESION(">=20")==true)	 // NIVEL ADMINISTRADOR 			
			{					
				$option["where"][]="left(trabajador_departamento_id,6)=left('{$_SESSION["user"]["departamento_id"]}',6)";				
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
