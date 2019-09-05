<?php
	class sppstims_citados extends general
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
					#"required",
					"title"			=>"Matricula del trabajador",
			    	"tabindex"		=>"1"			    
			    ),			    			    
				

			),
			"trabajador_nss"	    =>array(
			    "title"             => "NSS",
				"holder"             => "0000 00 0000",			    
				"title_filter"		=> "NSS",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
  			    "attr"             => array(
					"required",
					"title"			=>"Matricula del trabajador",
			    	"tabindex"		=>"2"			    
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
  			    "attr"             => array(
					"title"			=>"Horario del trabajador",
			    	"readonly"		=>"readonly",
					"tabindex"		=>"3"
			    ),			    			    				
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

			"cita"	    =>array(
			    "title"             => "SPPSTIMSS",
				"title_filter"		=> "Cita SPPSTIMS",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=>array(
					"tabindex"		=>"4"
			    ),				
			),
			"horario"	    =>array(
			    "title"             => "Horario",				
			    "showTitle"         => "si",
			    "type"              => "select",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=>array(
					"tabindex"		=>"4"
			    ),				
				"source"			=>array(
					""				=>"Seleccciona un Turno",
					"08:00"				=>"1.- 08:00",
					"09:00"				=>"2.- 09:00",
					"10:00"				=>"3.- 10:00",
					"11:00"				=>"4.- 11:00",
					"12:00"				=>"5.- 12:00",
					"13:00"				=>"6.- 13:00",
					"14:00"				=>"7.- 14:00",
				)		
			),
			"examenes_laboratorio"	    =>array(
			    "title"             => "Laboratorio",				
			    "showTitle"         => "si",
			    "type"              => "texthtml",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=>array(
					"style"			=>"height:150px; width:800px;",
					#"style"			=>"width:100%; heigth:500px;",
			    ),				
				
			),			
			
			"examenes_rayosx"	    =>array(
			    "title"             => "Rayos X",				
			    "showTitle"         => "si",
			    "type"              => "texthtml",
			    "default"           => "",
			    "value"             => "",			    
			    "attr"            	=>array(
					"style"			=>"height:150px; width:800px;",
					#"style"			=>"width:100%; heigth:500px;",
			    ),				
				
			),			
			
			"trabajador_dependencia"	    =>array(
			    "title"             => "Dependencia",
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
				
			),
			"laboratorio"	    =>array(
			    "title"             => "Cita cumplida",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",						
			),
			"cita_cumplida"	    =>array(
			    "title"             => "Cita cumplida",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",						
			),			
			"cita_laboratorio"	    =>array(
			    "title"             => "Laboratorio",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",						
			),
		
			
			"horario_laboratorio"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "07:15",
			    "value"             => "07:15",			    
			),						
			"total"	    =>array(
			    "title"             => "Total",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"edad"	    =>array(
			    "title"             => "edad",
			    "showTitle"         => "si",
			    "type"              => "input",
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
					
			"panel_viral"	    =>array(
			    "title"             => "Panel Viral",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"alergologia"	    =>array(
			    "title"             => "Alergologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_alergologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"angiologia"	    =>array(
			    "title"             => "Angiologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_angiologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),							
			"audiometria"	    =>array(
			    "title"             => "Audiometria",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_audiometria"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),							
			"cardiologia"	    =>array(
			    "title"             => "Cardiologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_cardiologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"c_general"	    =>array(
			    "title"             => "C General",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_c_general"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"c_mama"	    =>array(
			    "title"             => "C Mama",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_c_mama"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"dermatologia"	    =>array(
			    "title"             => "Dermatologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_dermatologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"endocrinologia"	    =>array(
			    "title"             => "Endocrinologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_endocrinologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"estomatologia"	    =>array(
			    "title"             => "Estomatologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_estomatologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"gastroenterologia"	    =>array(
			    "title"             => "Gastroenterologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_gastroenterologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"ginecologia"	    =>array(
			    "title"             => "Ginecologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_ginecologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"hematologia"	    =>array(
			    "title"             => "Hematologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_hematologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"maxilofacial"	    =>array(
			    "title"             => "Maxilofacial",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_maxilofacial"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_familiar"	    =>array(
			    "title"             => "M Familiar",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_m_familiar"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"m_interna"	    =>array(
			    "title"             => "M Interna",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_m_interna"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"neumologia"	    =>array(
			    "title"             => "Neumologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_neumologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"neurologia"	    =>array(
			    "title"             => "Neurologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_neurologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"nutriologia"	    =>array(
			    "title"             => "Nutriologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_nutriologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"oftalmologia"	    =>array(
			    "title"             => "Oftalmologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_oftalmologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"otorrinolaringologia"	    =>array(
			    "title"             => "Otorrinolaringologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_otorrinolaringologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"pass"	    =>array(
			    "title"             => "PASS",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_pass"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"urologia"	    =>array(
			    "title"             => "Urologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_urologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"traumatologia"	    =>array(
			    "title"             => "Traumatologia",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_traumatologia"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"usg"	    =>array(
			    "title"             => "USG",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_usg"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"psiquiatria"	    =>array(
			    "title"             => "Psiquiatria",
			    "showTitle"         => "si",
			    "type"              => "checkbox",
			    "default"           => "",
			    "value"             => "",			    
			),				
			"m_psiquiatria"	    =>array(
			    "title"             => "Motivo",
			    "showTitle"         => "si",
			    "type"              => "input",
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
			unset($datas["especialidad"]);
			unset($datas["motivo"]);			
			
			#$datas["puesto_tipo"]	=substr($datas["trabajador_puesto_id"],2,2);			
			$datas["sexo"]			=substr($datas["trabajador_nss"],14,1);			
			$datas["edad"]			=date('Y')-substr($datas["trabajador_nss"],15,4);
			
			if(@$datas["examenes_laboratorio"]=="")		
			{	
				$datas["examenes_laboratorio"]=">	BIOMETRÍA HEMÁTICA<br>>	GLUCOSA, UREA, CREATININA Y ÁCIDO ÚRICO<br>>	EXAMEN GENERAL DE ORINA <br>>	COLESTEROL, TRIGLICERIDOS,  (HDL-C), (LDL-C),(VLDL-C)<br>>	FACTOR DE RIESGO.";
				
				if($datas["edad"]>40 AND ($datas["sexo"]=="M" or $datas["sexo"]=="m" ))
					$datas["examenes_laboratorio"].="<br>>	ANTIGENO PROSTATICO";						
				
				if(in_array(substr($datas["trabajador_puesto_id"],2,2),array(12,21,31,36)))
				{	
					$datas["panel_viral"]=1;					
				}				
			}
			if(@$datas["examenes_rayosx"]=="")		
			{	
				$datas["examenes_rayosx"]=">	PLACAS (PARADO, DESCALZO Y CON FOCO EN L5)<br>	1.- TELE RADIOGRAFÍA DE TORAX PA<br>	2.- LATERAL DE COLUMNA LUMBAR<br>";				
			}

			if($datas["panel_viral"]==1)
			{
				$datas["examenes_laboratorio"].="<br>>	PANEL VIRAL (HEPATITIS B y C, VIH)";		
			}			
			else
			{

			}			
			
			
			#$this->__PRINT_R($datas);
			return parent::__SAVE($datas);
		}			
   		public function __FORMATO_INTERCONSULTA($id)		
    	{									
			$datos									=$this->__BROWSE($this->sys_primary_id);
			$words									=$datos[0];	
						
			$envio="";
			foreach($words as $campo => $motivo)
			{				
				if(substr($campo,0,2)=="m_")
				{
					$especialidad=substr($campo,2,strlen($campo)-2);
					
					if($words[$especialidad]=="1")
					{
						$words["especialidad"]					=strtoupper($especialidad);
						if($words["especialidad"]=="PASS")		$words["especialidad"]="PROGRAMA DE ATENCION SOCIAL A LA SALUD";
						if($words["especialidad"]=="C_GENERAL")	$words["especialidad"]="CIRUGIA GENERAL";
						if($words["especialidad"]=="C_MAMA")	$words["especialidad"]="CLINICA DE MAMA";
						if($words["especialidad"]=="M_FAMILIAR")$words["especialidad"]="MEDICINA FAMILIAR";
						if($words["especialidad"]=="M_INTERNA")	$words["especialidad"]="MEDICINA INTERNA";
												
						$words["motivo"]						=strtoupper($motivo);
						$words["umf"]							="";
						#$words["especialidad"]=					$id;
						
						
						if($words["especialidad"]=="USG")												
							$words								=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_usg")),$words);					
						else					
							$words								=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_interconsulta")),$words);
					
						
						$words["sys_titulo"]					="DIRECCCION DE PRESTACIONES MEDICAS";		
						$words["sys_subtitulo"]					="";		
						
						@$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
						$template              					=$this->__REPLACE($template,$words); 			
				
						if($envio=="")							$envio=$template;				
						else									$envio.="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>$template";				
					}				
				}
				$words									=$datos[0];	
			}	
			
						
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$envio;
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

			$words									=$datos[0];	
			$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/citas_ray")),$words);
			
			$words["sys_titulo"]					="DIRECCCION DE PRESTACIONES MEDICAS";		
			$words["sys_subtitulo"]					="";		
			
			@$template								=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
			$template_ray              				=$this->__REPLACE($template,$words); 		




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
			if($datos[0]["cita_laboratorio"]=="0000-00-00")		
				$template_consentimiento="";	

			if($template_ray!="")						$template_ray				="<br><br>$template_ray";
			if($template_consentimiento!="")			$template_consentimiento	="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>$template_consentimiento";
			
			/////////////
			
			@$template								="$template_sppstimss<br><br><br><br><br><br><br>$template_lab$template_ray$template_consentimiento";
			
			
			

						
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
			
			
			
			
			if(!isset($this->request["sys_order_sppstims_citados"]))
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
						
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="cita DESC, horario ASC";
			
#			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
#				$option["order"]="horario ASC";
			
			$option["template_separator"]	            	= "cita";		
			#/*
			if(isset($this->request["sys_calendar_sppstims_citados_cita"]) AND $this->request["sys_calendar_sppstims_citados_cita"]!="")
				$option["order"]="horario ASC";
			#else 
			#	$option["where"][]="cita ='".date("Y-m-d")."'";	
			#*/
			
			$option["date"]									="cita";
			$option["template_separator"]	            	= "cita";		
			
			return $this->__VIEW_REPORT($option);
		}			
		

   		public function __REPORT_PEND_LAB()
    	{
			$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();

			
				
			
			$option["where"][]="cita ='' OR cita is null or cita='0000-00-00'";	
			
			
			
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
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="horario ASC";
			
			
			$this->sys_fields["laboratorio"]["title"]		="Lab";
			$this->sys_fields["cita_cumplida"]["title"]		="Cita";	

			$option["template_separator"]	            	= "cita";			
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_HOY($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();

			
			if(isset($this->request["sys_calendar_sppstims_citados_cita"]) AND $this->request["sys_calendar_sppstims_citados_cita"]!="")
				$option["order"]="horario ASC";
			#else 
				
			
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
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="horario ASC";
			
			
			$this->sys_fields["laboratorio"]["title"]		="Lab";
			$this->sys_fields["cita_cumplida"]["title"]		="Cita";			
			
			$option["template_separator"]	            	= "cita";		
			
			return $this->__VIEW_REPORT($option);
		}				
		
   		public function __REPORT_ACTUAL($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
						
			if(!isset($option["where"]))					$option["where"]=array();
			
			if(date("d") <= 25)
			{
				$fecha 										= date('Y-m-d');
				$nuevafecha 								= strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
				$inicio 									= date ( 'Y-m-26"' , $nuevafecha );
				$fin										= date("Y-m-25") ;
			}		
			else 
			{
				$inicio										= date("Y-m-26") ;
				$inicio										= date("Y-m-d") ;
			}
			$option["where"][]="cita BETWEEN '$inicio' AND '$fin' ";
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				#$option["actions"]["check"]				="false";
				#$option["actions"]["delete"]				="false";
			}	
			$option["template_title"]	                	= $this->sys_module . "html/report_title_mensual";
			$option["template_body"]	               		= $this->sys_module . "html/report_body_mensual";			
			
			$this->sys_fields["asistencia"]					=array("title"             => "Asistencia");
						
			$option["select"]=array();
			#$option["echo"]="aaaa";
			
			$option["select"]["
				CASE 
					WHEN cita_cumplida=1 THEN 'REALES' 
					WHEN cita_cumplida=0 THEN 'FALTARON' 
				END
			"]												="asistencia";			
			$option["select"]["COUNT(cita_cumplida)"]		="cita_cumplida";

			$this->sys_fields["laboratorio"]["title"]		="Lab";
			$this->sys_fields["asistencia"]["title"]		="Asistencia";						
			$this->sys_fields["laboratorio"]["title"]		="Lab";
			$this->sys_fields["cita_cumplida"]["title"]		="Cita";			
			
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="horario ASC";			
			
			$option["group"]="cita_cumplida";
			
			return $this->__VIEW_REPORT($option);
		}				
   		public function __REPORT_MANANA($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			
			if(!isset($option["manana"]))					$option["manana"]=1;
			else											$option["manana"]=$option["manana"]-date("d");
			
			if(!isset($option["where"]))					$option["where"]=array();
				
			$option["where"][]="cita =ADDDATE('".date("Y-m-d")."', INTERVAL {$option["manana"]} DAY)";
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				#$option["actions"]["check"]				="false";
				#$option["actions"]["delete"]				="false";
			}	
			$option["template_title"]	                	= $this->sys_module . "html/report_title";
			$option["template_body"]	                	= $this->sys_module . "html/report_body";			
			
			$this->sys_fields["laboratorio"]["title"]		="Lab";
			$this->sys_fields["cita_cumplida"]["title"]		="Cita";			
			
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="horario ASC";			
			
			#$option["date"]="cita";
			$option["template_separator"]	            	= "cita";		
			
			
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
			
			if(!isset($this->request["sys_order_sppstims_citados"]) OR $this->request["sys_order_sppstims_citados"]=="")
				$option["order"]="horario ASC";			
			
			#$option["date"]="cita";
			
			$option["template_separator"]	            	= "cita";		
			
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
