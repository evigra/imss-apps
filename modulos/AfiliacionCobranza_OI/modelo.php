<?php
	class AfiliacionCobranza_OI extends general
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
			"registro_patronal"	    =>array(
			    "title"             => "Registro Patronal",
			    "type"              => "autocomplete",
			    "attr"             => array(
				#	"required",
			    ),			    			    				
			    "procedure"       	=> "__AUTOCOMPLETE",
			    "relation"          => "many2one",
			    "class_name"       	=> "patron",
			    "class_field_l"    	=> "rp_rale",				# Label
			    "class_field_o"    	=> "registro_patronal",
			    "class_field_m"    	=> "rp_rale",			    
			),			
			"patron"	    =>array(
			    "title"             => "Patron",
			    "type"              => "input",
			    "title_filter"		=> "Patron",
			),		
			"jefe"	    =>array(
			    "title"             => "Jefe de Oficina",
			    "type"              => "input",
			),		
			"formulo"	    =>array(
			    "title"             => "Formulo",
			    "type"              => "input",
			),		
			"reviso"	    =>array(
			    "title"             => "Reviso",
			    "type"              => "input",
			),		


			"folio"	    =>array(
			    "title"             => "Folio",
			    "type"              => "hidden",
			),
			"subtotal"	    =>array(
			    "title"             => "SubTotal",
			    "type"              => "hidden",
			),
			"fecha"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "value",
			),
			"plazo"	    =>array(
			    "title"             => "Recargo Plazo",
			    "type"              => "input",
			),
			"extemporaneo"	    =>array(
			    "title"             => "Recargo Extemporaneo",
			    "type"              => "input",
			),
			"umas"	    =>array(
			    "title"             => "UMAS",
			    "type"              => "input",
			),
			"letra_total"	    =>array(
			    "title"             => "IMPORTE CON LETRA",
			    "type"              => "input",
			),

			"total"	    =>array(
			    "title"             => "Total",
			    "type"              => "hidden",
			),
			"subtotal_cuota_fija"	    =>array(
			    "title"             => "Cuota",
			    "type"              => "hidden",
			),
			"subtotal_excedente"	    =>array(
			    "title"             => "Excedente",
			    "type"              => "hidden",
			),
			"subtotal_cop"	    =>array(
			    "title"             => "COP",
			    "type"              => "hidden",
			),
			"subtotal_actualizacion"	    =>array(
			    "title"             => "Actualizacion",
			    "type"              => "hidden",
			),

			"subtotal_recargo"	    =>array(
			    "title"             => "Recargo",
			    "type"              => "hidden",
			),
			"subtotal_gasto"	    =>array(
			    "title"             => "Gasto",
			    "type"              => "hidden",
			),
			"subtotal_cuota_fija"	    =>array(
			    "title"             => "Cuota",
			    "type"              => "hidden",
			),
			"total_excedente"	    =>array(
			    "title"             => "Excedente",
			    "type"              => "hidden",
			),
			"total_cop"	    =>array(
			    "title"             => "COP",
			    "type"              => "hidden",
			),
			"total_actualizacion"	    =>array(
			    "title"             => "Actualizacion",
			    "type"              => "hidden",
			),

			"total_recargo"	    =>array(
			    "title"             => "Recargo",
			    "type"              => "hidden",
			),
			"total_gasto"	    =>array(
			    "title"             => "Gasto",
			    "type"              => "hidden",
			),

			"movimiento_ids"	    =>array(
			    "type"              => "form",
			    "relation"          => "one2many",
			    "class_name"       	=> "AfiliacionCobranza_OI_movimiento",
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "oi_id",			    
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function __CONSTRUCT($option=array())
		{	

			if(in_array(@$_REQUEST["sys_action"],$_SESSION["var"]["print"]) )
			{
				$this->sys_fields["folio"]["type"]				="value";
				$this->sys_fields["patron"]["type"]				="value";
				$this->sys_fields["registro_patronal"]["type"]	="value";
				$this->sys_fields["total_cuota_fija"]["type"]	="value";
				$this->sys_fields["total_excedente"]["type"]	="value";
				$this->sys_fields["total_cop"]["type"]			="value";
				$this->sys_fields["total_recargo"]["type"]		="value";
				$this->sys_fields["total_gasto"]["type"]		="value";
				$this->sys_fields["total_actualizacion"]["type"]="value";
				$this->sys_fields["total"]["type"]				="value";
				$this->sys_fields["letra_total"]["type"]		="value";												
				$this->sys_fields["subtotal_cuota_fija"]["type"]	="value";
				$this->sys_fields["subtotal_excedente"]["type"]	="value";
				$this->sys_fields["subtotal_cop"]["type"]			="value";
				$this->sys_fields["subtotal_recargo"]["type"]		="value";
				$this->sys_fields["subtotal_gasto"]["type"]		="value";
				$this->sys_fields["subtotal_actualizacion"]["type"]="value";
				$this->sys_fields["subtotal"]["type"]				="value";

				$this->sys_fields["umas"]["type"]		="value";
				$this->sys_fields["plazo"]["type"]="value";
				$this->sys_fields["extemporaneo"]["type"]				="value";

			}
					
			$_SESSION["pdf"]["formato"]		="";		    	    
												
    	    parent::__CONSTRUCT($option);
		}				
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		
    		$guardar						=1;	
    		$datas["letra_total"]			=$this->NUM_A_LETRA($datas["total"],1);
    		$datas["fecha"]					=$_SESSION["var"]["datetime"];
	   		$datas["fecha"]					=$_SESSION["var"]["datetime"];
    		    	        	    
			if(!isset($datas["folio"]) OR $datas["folio"]=="")
			{	
				$option_folio				=array();
				$option_folio["variable"]	= substr(@$_SESSION["user"]["departamento_id"],0,2);    /// CONFIGURACION DE FOLIO
				$option_folio["subvariable"]= date ("Y");
				$option_folio["tipo"]		= "Orden Ingreso";
				$option_folio["subtipo"]	= "";
				$option_folio["objeto"]		= $this->sys_object;
				
				$datas["folio"]				=$this->__FOLIOS($option_folio);
			}
    	    
    	    $return							=parent::__SAVE($datas,$option);
    	    
    	    
    	    #$this->__PRINT_R($this->sys_sql);    	    
			if($guardar==1)
			{    		    		    		    					
				if($this->sys_private["section"]=="create")
				{
					$this->PDF_PRINT($return);
				}
				return $return;	
			}			    	    
		}				
   		public function __PDF($Output="I")
    	{	

		#/*
			if(!isset($_SESSION["pdf"]["template"]["html"]))
			{
				$return[]=				array(
					"format"		=>"A4",					
					"html"			=>$_SESSION["pdf"]["template"],					
					"orientation"	=>"L",					
				);
				$_SESSION["pdf"]["template"]=$return;		
			}
		#*/
		/*
			$datos										=$this->__BROWSE($this->sys_private["id"]);			
			if(@$datos["data"])							$datos=$datos["data"];					
			$return=array();	

			foreach($datos as $dato)
			{				
				$words									=$dato;
				
				if(is_array($words) AND count($words)>0)
				{
					$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));					
										
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
	#*/


			@parent::__PDF("I");
		}	
	}
	
?>
