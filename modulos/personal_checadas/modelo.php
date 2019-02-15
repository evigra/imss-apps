<?php
	class personal_checadas extends general
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
			"matricula"	    =>array(
			    "title"             => "Matricula",
				"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"nombre"	    =>array(
			    "title"             => "Nombre",
				"title_filter"		=> "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
				"relation"			=> "one2many",
			    "default"           => "",
			    "value"             => "",			    
			    "class_name"       	=> "personal",			    
			    "class_field_o"    	=> "matricula",     ##personal
			    "class_field_m"    	=> "matricula",		##checadas		
				"class_field_l"    	=> "nombre",								
			),
			
			"fecha"	    =>array(
			    "title"             => "Fecha",
				"title_filter"		=> "Fecha",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"hora"	    =>array(
			    "title"             => "Hora",
				"title_filter"		=> "Hora",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"ip"	    =>array(
			    "title"             => "IP",
				
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
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
		*/
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    		#$datas["total"]		=count(explode(",",$datas["dias"]));
    		
    		
			#$option["echo"]=$datas["total"];
    		
    	    $user_id=parent::__SAVE($datas,$option);
		}				
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
				$words									=$dato;			

				
				$words["trabajador_clave"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_clave"], 15,"-"));
				$words["trabajador_nombre"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_nombre"], 65,"-"));
				$words["trabajador_puesto"]				=str_replace("-","&nbsp;",str_pad($words["trabajador_puesto"], 143,"-"));
				
				$words["trabajador_departamento"]		=str_replace("-","&nbsp;",str_pad($words["trabajador_departamento"], 40,"-"));
				$words["objeto"]						=str_replace("-","&nbsp;",str_pad($words["objeto"], 140,"-"));
				$words["ocurrir"]						=str_replace("-","&nbsp;",str_pad($words["ocurrir"], 140,"-"));
				
				
				
				
				$words["Entrada"]						=" &nbsp;  &nbsp; ";
				$words["Salida"]						=" &nbsp;  &nbsp; ";
				$words["Intermedio"]					=" &nbsp;  &nbsp; ";
				
				$words["Oficial"]						=" &nbsp;  &nbsp; ";
				$words["Personal"]						=" &nbsp;  &nbsp; ";				
				$words["Medico"]						=" &nbsp;  &nbsp; ";
				
				
				$words[ $dato["entrada_salida"] ]		="&nbsp;<b>X</b>&nbsp;";
				$words[ $dato["tipo"] ]					="&nbsp;<b>X</b>&nbsp;";
				
				
				if(is_array($words) AND count($words)>0)
				{	
					$words									=array_merge(array("sys_modulo" => $this->__TEMPLATE($this->sys_module . "html/PDF_FORMATO")),$words);
					
					$words["sys_titulo"]					="CONSTANCIA DE AUTORIZACION";		
					$words["sys_subtitulo"]					="PASE DE ENTRADA O SALIDA";					
				
					if(@$dato["trabajador_departamento_id"])
						$words["lugar"]						=$this->lugar(substr($dato["trabajador_departamento_id"],0,6));		
					$words["fecha"]							=$this->sys_date;		
																											
					$template								.=$this->__TEMPLATE2("sitio_web/html/PDF_FORMATO_IMSS2");
					$template								=$this->__REPLACE($template,$words);
				}	

			}	

			return                  					$template;
		}	

		public function BAJAR_CHECADAS()
    	{
		
			$ch = curl_init();

			$fields = array( 'username'=>'administrator', 'userpwd'=>'123456');
			$postvars = '';
			foreach($fields as $key=>$value) {
				$postvars .= $key . "=" . $value . "&";
			}
			$url = "http://11.1.6.13/csl/check";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);



			$response="";

			#/*
			$a=1;
			for($a=1; $a<500; $a++)
			{
				$fields = array( 'sdate'=>date("Y-m-d"), 'edate'=>date("Y-m-d"), 'period'=>'1', 'uid'=>$a);
				$fields = array( 'sdate'=>"2017-08-21", 'edate'=>"2017-08-21", 'period'=>'1', 'uid'=>$a);
				$postvars = '';
				foreach($fields as $key=>$value) 
				{
					$postvars .= $key . "=" . $value . "&";
				}
				$url = "http://11.1.6.13/form/Download  ";
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
				curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
				curl_setopt($ch,CURLOPT_TIMEOUT, 20);
				$response	= curl_exec($ch);
				
				$rows		=explode("\n",$response);								
				foreach($rows as $row)
				{
					$array		=explode("\t",$row);
					if($array[0]>0)
					{					
						$this->__PRINT_R($array);
						$time		=explode(" ",$array[2]);								
						$data_save=array(
							"matricula"	=>$array[0],
							"fecha"		=>$time[0],
							"hora"		=>$time[1],
						);					
						$this->__SAVE_NOT_EXISTS($data_save);									
					}
				}
			}
			#*/
			curl_close ($ch);		

		}		
   		public function __BROWSE($option=NULL)
    	{
			if(is_null($option))	$option=array();
			
			#$option["echo"]	="checadas_BROWSE";
			#$option["from"]		="personal p join personal_checadas pc on pc.matricula=p.matricula";
			
			return parent::__BROWSE($option);
		}		
   		public function __REPORTE($option="")
    	{			
			if($option=="")	$option=array();			
						
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
						
			return $this->__VIEW_REPORT($option);
		}			

		
   		public function __REPORT_CANCELADOS($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
			
			$option["having"]							=array("length(hora)>21");
			$option["echo "]							="CANCELADOS CHECADAS";
			



			return $this->__VIEW_REPORT($option);
		}				

   		public function __VIEW_REPORT($option=NULL)
    	{
			if(is_null($option)) 							$option=array();	
			if($option=="")									$option=array();			
			if(!isset($option["where"]))					$option["where"]=array();
									
			$option["select"]=Array(
				"matricula"									=>"matricula",
				"fecha"										=>"fecha",
				"GROUP_CONCAT(DISTINCT(hora) ORDER BY hora ASC SEPARATOR ' <=> ')"		=>"hora"
			);
						
			if(@$this->request["sys_order_personal_checadas"]=="")			
				$option["order"]="fecha desc, matricula asc, hora asc ";
			
			$option["group"]="matricula, fecha";

			return parent::__VIEW_REPORT($option);
		}				

	}
?>

