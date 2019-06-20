<?php
	class anteojos extends general
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

			"fecha_registro"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "hidden",
			),
			"tipo"	    =>array(
			    "title"             => "Prescripcion",
				"title_filter"		=> "Prescripcion",
			    "type"              => "select",
			    "attr"             => array(
					"required",
			    ),				
			    "source"             => Array(
					""=>"Selecciona",
					"EG"			=>"Enfermedad General",
					"RT"			=>"Riesgo de Trabajo",
				),			    
			),
			"od_esfera"	    =>array(
			    "title"             => "esfera",
			    "type"              => "input",
			),			
			"od_cilindro"	    =>array(
			    "title"             => "Cilindro",
			    "type"              => "input",
			),			
			"od_eje"	    =>array(
			    "title"             => "Eje",
			    "type"              => "input",
			),
			"oi_esfera"	    =>array(
			    "title"             => "esfera",
			    "type"              => "input",
			),			
			"oi_cilindro"	    =>array(
			    "title"             => "Cilindro",
			    "type"              => "input",
			),			
			"oi_eje"	    =>array(
			    "title"             => "Eje",
			    "type"              => "input",
			),
			"prisma"	    =>array(
			    "title"             => "Prisma",
			    "type"              => "input",
			),			
			"color"	    =>array(
			    "title"             => "Color",
			    "type"              => "input",
			),			
			"dip"	    =>array(
			    "title"             => "Dip",
			    "type"              => "input",
			),			
			"add_cilindro"	    =>array(
			    "title"             => "ADD",
			    "type"              => "input",
			),			
		
			"bifocal"	    =>array(
			    "title"             => "Bifocal",
			    "type"              => "autocomplete",
			    "procedure"       	=> "autocomplete_tipos",
			    "relation"          => "many2one",
			    "class_name"       	=> "anteojos_tipo",
			    "class_field_l"    	=> "descripcion",				# Label
			    "class_field_o"    	=> "bifocal",
			    "class_field_m"    	=> "descripcion",			    
			),
			"medico"	    =>array(
			    "title"             => "Medico",
			    "type"              => "input",
			),			
			"matricula_medico"	    =>array(
			    "title"             => "Matricula",
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
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		if($this->sys_private["section"]=="create")
    		{
				$datas["fecha_registro"]	=$_SESSION["var"]["datetime"];
				$datas["matricula_medico"]	=$_SESSION["user"]["email"];
				$datas["medico"]			=$_SESSION["user"]["name"];

				if(!isset($datas["folio"]) OR $datas["folio"]=="")
				{	
					$option_folio				=array();
					$option_folio["variable"]	= substr($datas["trabajador_departamento_id"],0,6);    /// CONFIGURACION DE FOLIO
					$option_folio["subvariable"]= date ("Y");
					$option_folio["tipo"]		= "folio";
					$option_folio["subtipo"]	= "";
					$option_folio["objeto"]		= $this->sys_object;
					
					$datas["folio"]=$this->__FOLIOS($option_folio);
				}	
			}    		
    		    		    		    	
			$return =	parent::__SAVE($datas,$option);
			
			if($this->sys_private["section"]=="create")
			{
				$this->PDF_PRINT($return);
			}	
			
    	    return $return;
		}				
   		public function __GENERAR_PDF()
    	{
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="ANTEOJOS";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_private["id"]);
		}		
   		public function __FORMATO($option)
    	{
				
			$datos										=$this->__BROWSE($option);			
			if(@$datos["data"])							$datos=$datos["data"];		
			
			$return=array();	

			foreach($datos as $dato)
			{				
				$words									=$dato;			
				
				if(is_array($words) AND count($words)>0)
				{
					$template="";	
					$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
					$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
					$words["trabajador_nombre"]				=str_replace("/"," ",$words["trabajador_nombre"]);
					$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));					
					$words["trabajador_departamento"]		=str_replace("-","&nbsp;",str_pad($words["trabajador_departamento"], 40,"-"));					
					$words["RT"]							=" &nbsp;  &nbsp; ";
					$words["EG"]							=" &nbsp;  &nbsp; ";														
					$words[ $dato["tipo"] ]					="&nbsp;<b>X</b>&nbsp;";
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_var["module_path"] . "html/PDF_RECETA")),$words);
					
					$words["sys_titulo"]					="DELEGACION REGIONAL COLIMA";		
					$words["sys_subtitulo"]					="";		
					$words["sys_titulo2"]					="";		
					$words["sys_subtitulo2"]				="";
					$words["sys_asunto"]					="";				
					$words["sys_pie"]						="1A72-009-027";		
									
					$words["fecha"]							=$this->sys_date;		
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");
					$template								=$this->__REPLACE($template,$words);					
					
					$return[]=				array(
						"format"		=>"A4",					
						"html"			=>$template,					
						"orientation"	=>"P",					
					);

					
					////////////////////////////////////////
				
					$template="";
					$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
					$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
					$words["trabajador_nombre"]				=str_replace("/"," ",$words["trabajador_nombre"]);
					$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));					
					$words["trabajador_departamento"]		=str_replace("-","&nbsp;",str_pad($words["trabajador_departamento"], 40,"-"));					
					$words["RT"]							=" &nbsp;  &nbsp; ";
					$words["EG"]							=" &nbsp;  &nbsp; ";														
					$words[ $dato["tipo"] ]					="&nbsp;<b>X</b>&nbsp;";
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_var["module_path"] . "html/PDF_DOTACION")),$words);
					
					$words["sys_titulo"]					="DELEGACION REGIONAL COLIMA";		
					$words["sys_subtitulo"]					="";		
					$words["sys_titulo2"]					="";		
					$words["sys_subtitulo2"]				="";
					$words["sys_asunto"]					="";				
					$words["sys_pie"]						="1A72-009-027";		
									
					$words["fecha"]							=$this->sys_date;		
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");
					$template								=$this->__REPLACE($template,$words);					

					$return[]=				array(
						"format"		=>"A4",					
						"html"			=>$template,					
						"orientation"	=>"P",					
					);


				}	
			}	
			
			

			return $return;
		}	
	}
?>

