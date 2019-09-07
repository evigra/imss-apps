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
			"lente_costo"	    =>array(
			    "title"             => "Costo",
			    "type"              => "hidden",
			),				

			"lente_id"	    =>array(
			    "title"             => "Bifocal",
			    "description"       => "Responsable del dispositivo",
			    "type"              => "autocomplete",
			    "procedure"       	=> "__AUTOCOMPLETE",
			    #"relation"          => "one2many",
			    "relation"          => "many2one",
			    "class_name"       	=> "contrato_lente_detalle",
			    "class_field_l"    	=> "nombre",				# Label
			    "class_field_o"    	=> "lente_id",
			    "class_field_m"    	=> "id",			    
			),			
			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#$this->__PRINT_R($datas);

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

		public function __REPORT_ANTEOJOS($option=array())
		{
			if($option=="")					$option				=array();			
			if(!isset($option["where"]))	$option["where"]	=array();
			if(!isset($option["select"]))	$option["select"]	=array();
						
			$option["select"][]						="lente_id";
			$option["select"]["sum(lente_costo)"]	="lente_costo";

			$option["group"]						="lente_id";
			
			$option["echo"]						="lente_id";
			
			
			return $option;
		}
		##############################################################################	

		public function __BROWSE($option=array())
		{
			$return = parent::__BROWSE($option);			
			return $return;
		}
		##############################################################################	

		public function __VIEW_GRAPH($option_graph=array(),$template=NULL)
		{
			$option				=array();	
			$option["select"][]	="contrato_detalle.nombre";
			$option["select"][]	="count(*)";
			$option["from"]		="anteojos join contrato_detalle on anteojos.lente_id=contrato_detalle.id";
			$option["group"]	="anteojos.lente_id";			
			$option["title"]	="['Lente','Cantidad'],";
			$option_graph["PieChart"]	=$option;						

			$option				=array();	
			$option["select"][]	="contrato_detalle.nombre";
			$option["select"][]	="count(*)";
			$option["from"]		="anteojos join contrato_detalle on anteojos.lente_id=contrato_detalle.id";
			$option["group"]	="anteojos.lente_id";
			$option["title"]	="['Lente','Cantidad'],";
			$option_graph["AreaChart"]	=$option;

			$option				=array();	
			$option["select"][]	="contrato_detalle.nombre";
			$option["select"][]	="sum(anteojos.lente_costo)";
			$option["from"]		="anteojos join contrato_detalle on anteojos.lente_id=contrato_detalle.id";
			$option["group"]	="anteojos.lente_id";
			$option["title"]	="['Lente','Costo'],";
			
			$option_graph["ColumnChart"]=$option;


			$option_graph["BarChart"]	=$option;
			$option_graph["LineChart"]	=$option;

			return parent::__VIEW_GRAPH($option_graph);
		}

		##############################################################################	
		
   		public function __PDF($Output="I")
    	{				
			$datos										=$this->__BROWSE($this->sys_private["id"]);			
			if(@$datos["data"])							$datos=$datos["data"];		
			
			#$this->__PRINT_R($datos);
			
			$return=array();	

			foreach($datos as $dato)
			{				
				$words									=$dato;
				
				if(is_array($words) AND count($words)>0)
				{
					$nroMes = date("m", strtotime($dato["fecha_registro"])); //Coloca la fecha que desees
					$nroDia = date("d", strtotime($dato["fecha_registro"])); //Coloca la fecha que desees
					
					if($nroDia<=15)
					{
						$quincena=$nroMes*2-1;
					}
					else
						$quincena=$nroMes*2;
#*/				
					$words["quincena"]						="$quincena / $nroMes";
				
					$template="";	
					$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
					$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
					$words["trabajador_nombre"]				=str_replace("/"," ",$words["trabajador_nombre"]);
					$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));					
					$words["trabajador_departamento"]		=str_replace("-","&nbsp;",str_pad($words["trabajador_departamento"], 40,"-"));					
					$words["RT"]							=" &nbsp;  &nbsp; ";
					$words["EG"]							=" &nbsp;  &nbsp; ";														
					$words[ $dato["tipo"] ]					="&nbsp;<b>X</b>&nbsp;";
										
					$words["lente_id"]						=$this->sys_fields["lente_id"]["values"][0][$this->sys_fields["lente_id"]["class_field_l"]];
					
					$words2									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_var["module_path"] . "html/PDF_RECETA")),$words);
					
					$words2["sys_title"]					="DELEGACION REGIONAL COLIMA";				
					$words2["sys_subtitle"]					="";		
					$words2["sys_titulo2"]					="";		
					$words2["sys_subtitulo2"]				="";
					$words2["sys_asunto"]					="";				
					$words2["sys_pie"]						="1A72-009-027";		
									
					$words["fecha"]							=$this->sys_date;		
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO");
					$template								=$this->__REPLACE($template,$words2);					
					
					$return[]=				array(
						"format"		=>"A4",					
						"html"			=>$template,					
						"orientation"	=>"P",					
					);					
					////////////////////////////////////////				
					$template="";
					$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
					$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_var["module_path"] . "html/PDF_DOTACION")),$words);
					
					$words["sys_title"]						=$words2["sys_title"];
					$words["sys_subtitle"]					="TARJETA DE CONTROL DE DOTACION DE ANTEOJOS";		
					$words["sys_titulo2"]					="";		
					$words["sys_subtitulo2"]				="";
					$words["sys_asunto"]					="";				
					$words["sys_pie"]						="1A72-009-028";		
									
					$words["fecha"]							=$this->sys_date;		
					$template								.=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO");
					$template								=$this->__REPLACE($template,$words);					

					$return[]=				array(
						"format"		=>"A4",					
						"html"			=>$template,					
						"orientation"	=>"P",					
					);
				}	
			}				
			$_SESSION["pdf"]["template"]=$return;		
			@parent::__PDF("I");
		}
			
	}
?>
