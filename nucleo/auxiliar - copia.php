<?php
	include('basededatos.php');
#	require_once('class.phpmailer.php');
#	require_once('class.smtp.php');
	
	class auxiliar extends basededatos 
	{   
		##############################################################################	
		##  PROPIEDADES
		##############################################################################
		var $request			=array();	# este arrat recibe las variables del POST		
		var $sys_true			=array(1,"1","true", "si");
		var $sys_false		    =array(0,"0","false", "no");
		var $sys_modules	    =array("historico","menu","user_group", "group","modulos","permiso","sesion");
		var $sys_section	    ="";
		var $sys_action		    ="";
		var $html				="";
		var $sitio_web			="";		
		var	$jquery				="";
		var	$jquery_aux			="";	
		var $sys_html           ="sitio_web/html/";
		
		var $sys_date; 
		var $sys_object; 
		var $sys_name; 
		var $sys_table; 
		
		var $sys_historico;
		
		
		var $words              =array(
		    "html_head_title"           => "ESTE ES EL TITULO DE LA VENTANA :: words[html_head_title]",
		    "html_head_description"     => "ESTA ES LA DESCRIPCION OCULTA DEL MODULO :: words[html_head_description]",		
		);

			
		##############################################################################	
		##  METODOS	
		##############################################################################
		

   
		public function __SESSION()
		{  
			$redireccionar= "<script>window.location=\"../sesion/\";</script>";
			if(is_array($_SESSION))
			{
				
				if(array_key_exists("user",$_SESSION))
				{
					#$this->__PRINT_R($_SESSION);
					if(is_array($_SESSION["user"]))
					{
						if(array_key_exists("clave",$_SESSION["user"]))
							$redireccionar= "";					
					}					
				}			
			}
			if($redireccionar!="")
			{
				$_SESSION=array();
				$_SESSION["user"]="Invitado";
				#echo $redireccionar;
				exit();
			}
			
    	}    	
		public function __FIND_FIELD_ID()
		{  
			# BUSCA EL CAMPO y VALOR PRIMARY KEY
			# DEL MODELO DECLARADO
			if(isset($this->sys_fields) AND is_array($this->sys_fields))
			{
				foreach($this->sys_fields as $campo=>$valor)
				{        			
					if(@$valor["type"]=="primary key")
					{    				
						if(@$this->sys_vpath==$this->sys_object."/")
						{
					    	if(isset($this->request["sys_id"]))     $this->sys_primary_id       =$this->request["sys_id"];
						    else                                    $this->sys_primary_id       =$valor["value"];
						}   
						$this->sys_primary_field                =$campo; 
					}	
				}	
			}	
    	}  
    	/*
    	public function __FIND_FIELDS($id=NULL)
    	{
    	
    	}
    	*/
		public function __FIND_FIELDS($id=NULL)
		{
		 	# ASIGNA EL ROW CON EL $id enviado
		 	# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields
			if(isset($this->sys_fields) AND is_array($this->sys_fields))
			{
		    	foreach($this->sys_fields as $field =>$value)
		    	{

		    		if(isset($value["relation"]) AND $value["relation"]=="one2many")
		    		{
		    			$eval="$"."this->$field"."_obj			=new {$value["class_name"]}();";
						if(@eval($eval)===false)	
							echo "$eval"; #$eval; ---------------------------								        			
		    		}			        		
		    	}
			}

			
		    if(isset($id) and $id>0)
		    {
		    		
		        #if(@$this->request["sys_action"]!="__SAVE")
		        {
					$option_conf=array();
					
					$option_conf["open"]	=1;
					$option_conf["close"]	=1;

		            $sql    	="SELECT * FROM {$this->sys_table} WHERE {$this->sys_primary_field}='{$id}'";
			        $datas   	= $this->__EXECUTE("$sql",$option_conf);
			        
			        if(@is_array($datas[0]))
			        {
			        	foreach($this->sys_fields as $field =>$value)
			        	{			        	
			        		if(isset($value["type"]) AND $value["type"]!="class")	
			        		{
					    		if(isset($value["relation"]) AND $value["relation"]=="one2many")
					    		{
					    			$eval="
					    				$"."option=array();
					    				#$"."option[\"echo\"]=array(\"CLASS {$value["class_name"]}\");
					    				$"."option[\"where\"]=array(\"{$value["class_field_m"]}={$datas[0][$value["class_field_o"]]}\");
					    				$"."$field=$"."this->$field"."_obj->__BROWSE($"."option);
					    				$"."this->sys_fields[\"$field\"][\"values\"]=\"\";
					    				$"."this->sys_fields[\"$field\"][\"values\"]=$"."$field"."[\"data\"];
					    			";
									if(@eval($eval)===false)	
										echo ""; #$eval; ---------------------------								        			
					    		}
					    	}	
			        	}
			        	
					    foreach($datas[0] as $field =>$value)
					    {
					        $eval="$"."this->sys_fields[\"$field\"]"."[\"value\"]=\"$value\";";
							if(@eval($eval)===false)	
								echo ""; #$eval; ---------------------------					
					    }
			        }
			    }    
			}	
    	}
		##############################################################################	
		##  METODOS	
		##############################################################################
		public function __TABLE_MAIL($option)
		{


		}
		public function __VIEW($template)
		{ 
	
		
			#/*
			if (isset($_COOKIE)) 
			{
				#$this->__PRINT_R($_COOKIE);
			}			
			#*/
			
			if(!isset($words["system_user"]))		$words["system_user"]						="";
			if(!isset($words["system_img"]))		$words["system_img"]						="";
			if(!isset($words["system_company"]))	$words["system_company"]					="";
			if(!isset($words["system_submenu"]))	$words["system_submenu"]					="";
			
			$words["system_message"]				="";
			$words["system_js"]						="";
			$words["sys_date"]						=$this->sys_date;
			

			#$this->__PRINT_R($this->__SAVE_JS);
			
			#if(@$this->sys_vpath==$this->sys_object."/" AND @$this->request["sys_action"]=="__SAVE" AND ($this->request["sys_section"]=="create" OR $this->request["sys_section"]=="write"))
			if(@$this->sys_vpath==$this->sys_object."/" AND @$this->sys_action=="__SAVE" AND ($this->sys_section=="create" OR $this->sys_section=="write"))				
			{
		        $words["system_message"]    		=@$this->__SAVE_MESSAGE;
		        $words["system_js"]     			=@$this->__SAVE_JS;		        
		        #$this->__PRINT_R(@$this->__SAVE_JS);
			}
			
			if(array_key_exists("user",$_SESSION))
			{ 				
			    if(@$_SESSION["user"]!="Invitado" AND count($_SESSION["user"])>1)
			    {			    			    			    
				    $words							=$this->__MENU($words);
				    
				    $words["system_logo"]           ="";
				    
				    if(isset($_SESSION["system_company"]))
				    {
					    $words["system_company"]        =$_SESSION["system_company"];
					    $words["system_user"]           =$_SESSION["system_user"];
					    #$words["system_logo"]           =@$_SESSION["company"]["img_files_id_med"];
					    #$words["system_img"]           	=$this->__HTML_USER();
					    $words["sys_page"]           	=@$this->request["sys_page"];
					    #$words["companys"]           	=@$this->__COMPANYS();
					}
			    }
			    else
			    {
			    	$_SESSION["company"]			=array("razonSocial");
			    }	
            }
			if(!isset($words["system_submenu2"]))  	$words["system_submenu2"]		="";
			if(!isset($words["html_head_css"]))  	$words["html_head_css"]			="";
			
			
			if(!isset($words["sys_historico"]))  	////////// HISTORICO 
			{
				if($this->sys_primary_id!="")
				{	
					$option=array();
					$option["name"]="historico";					
					$this->sys_historico			=new historico();				
					
					$option=array();
					
					$option["template_body"]	    = $this->sys_historico->sys_module . "html/report_historico_body";				
					$option["order"]	    		= "id DESC";				
					$option["where"]	    		= array();				
					$option["where"][]				="clave=$this->sys_primary_id";
					$option["where"][]				="objeto='$this->sys_object'";
					$option["where"][]				="tabla='$this->sys_table'";
					
					
					
					$reporte						=$this->sys_historico->__VIEW_REPORT($option);			
					$words["sys_historico"]			=$reporte["html"];							
				}		
			}
			$words=array_merge($this->words,$words);
		
			$template                   			=$this->__REPLACE($template,$words); 			
			
			if(@$this->request["sys_action"]=="print_pdf")
		    {
		    	if(!isset($_SESSION["pdf"]))	$_SESSION["pdf"]	=array();		    					
				
				if(!isset($_SESSION["pdf"]["title"]))					$_SESSION["pdf"]["title"]					=$this->words["module_title"];
				if(!isset($_SESSION["pdf"]["subject"]))					$_SESSION["pdf"]["subject"]					=$this->words["html_head_title"];
				if(!isset($_SESSION["pdf"]["template"]))				$_SESSION["pdf"]["template"]				=$template;
				
				if(!isset($_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]))	$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]	="P";   	# (P=portrait, L=landscape)
				if(!isset($_SESSION["pdf"]["PDF_UNIT"]))				$_SESSION["pdf"]["PDF_UNIT"]				="mm";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_PAGE_FORMAT"]))			$_SESSION["pdf"]["PDF_PAGE_FORMAT"]			="A4";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO"]))			$_SESSION["pdf"]["PDF_HEADER_LOGO"]			="tcpdf_logo.jpg";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]))	$_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]	=20;   	
				if(!isset($_SESSION["pdf"]["PDF_MARGIN_TOP"]))			$_SESSION["pdf"]["PDF_MARGIN_TOP"]			=50;   	

				
				if(!isset($_SESSION["pdf"]["save_name"]))				$_SESSION["pdf"]["save_name"]=$_SESSION["pdf"]["subject"].".pdf";
				if($_SESSION["pdf"]["save_name"]=="")					$_SESSION["pdf"]["save_name"]=$_SESSION["pdf"]["title"].".pdf";
				#$_SESSION["html"]	="<table><tr><td>Eduardo Vizcaino</td></tr></table><table><tr><td>granados</td></tr></table>";
				$url 				= 'nucleo/tcpdf/crear_pdf.php';				
				$path				.="../$url";
				
				header('Location:'.$path);		
				exit;
			}
			#else	
			echo $template;	
		    
    	}
    	 
        ##############################################################################
		public function __REPORT_TITLES($sys_order,$sys_torder,$font,$name)
		{  

			$iorder									="";			
			$title									=@$this->sys_fields[$font]["title"];
			
			#$this->__PRINT_R($this->sys_fields_l18n);
						
        	if(isset($this->sys_fields_l18n) AND is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$font"]))	
        	{			        	
        		$title								=$this->sys_fields_l18n["$font"];
        	}
						
			if($sys_order==@$this->request["sys_order_$name"])
			{
			     if($sys_torder=="ASC") 			$iorder 						="<font class=\"ui-icon ui-icon-carat-1-n\"></font>";
			     else                   			$iorder 						="<font class=\"ui-icon ui-icon-carat-1-s\"></font>";
			}

			$base="";

		    $sys_action     						=@$this->request["sys_action"];		   

			if(@$this->request["sys_action"]=="print_excel")
		    {
				return "
					<div name=\"title_$name\" style=\"height:25px;\">
							<b><font class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">$title</font><b>
					</div>
				";
			}
			if(@$this->request["sys_action"]=="print_pdf")
		    {
				return "
					<div name=\"title_$name\" style=\"width:10px;\">
						<font class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">$title</font>
					</div>
				";
			}			
			else
			{
				return "
					<div name=\"title_$name\">
						<table height=\"40\"><tr>
							<td><b><font class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">$title</font><b></td> 
							<td>$iorder</td>
						</tr></table>
					</div>
				";
			
			}

		}	
		public function __MENU($words)
		{  			
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;			

			if(@$_SESSION["user"]["id"])
			{
				#$_SESSION["user"]["id"]=1;
				$comando_sql        ="
		            select
		            	distinct(m.id) as id_m, 
			            m.*
		            from 
			            usuario u join 
			            user_group ug on u.id=ug.user_id join
			            groups g on g.id=ug.active and g.name!='No activar' join
			            menu m on m.id=g.menu_id			            
		            WHERE  1=1
			            AND ug.active!=0
			            AND u.id={$_SESSION["user"]["id"]}
			        GROUP BY  m.id    
				";

				$datas_menu =$this->__EXECUTE($comando_sql, $option_conf);			
			
				#$this->__PRINT_R($comando_sql);
				
				$menu_html								="";
				foreach($datas_menu as $data_menu)
				{
					$link								=$data_menu["link"]."&sys_menu=".$data_menu["id"];				
					$alertas="";
					if(@$data_menu["c_menu_id"]>0)
					{
						$alertas="
							<div style=\"color:white; float:left; margin-left:5px; background-color:red; border-radius: 15px; width:15px; align:center; padding:0px 2px 0px 2px;\">
								<center>{$data_menu["c_menu_id"]}</center>	
							</div>					
						";				
					}	
					$menu_html.="				
						<a href=\"{$link}\">	
						<div class = \"menuHorizontal\" style=\"margin-top:4px; float:left; padding:5px 10px 5px 10px;\">
							<div style=\"float:left;\">
							{$data_menu["name"]}
							</div>
							$alertas
						</div>
						</a>
					";	
				}
				$words["system_menu"]		    		=$menu_html;
						
				$sys_menu								=@$_SESSION["sys"]["menu"];			
				$comando_sql        ="
		            select 
		            	m.id as id_m, 
			            m.*
		            from 
			            usuario u join 
			            user_group ug on u.id=ug.user_id join
			            groups g on g.id=ug.active join
			            permiso p on p.usergroup_id=ug.active AND p.s=1 join
			            menu m on m.id=p.menu_id
			            
		            WHERE  1=1
			            AND ug.active!=0
			            AND u.id={$_SESSION["user"]["id"]}
			            AND parent=$sys_menu
			            AND m.type='submenu'
			        GROUP BY  m.id        
				";
				$datas_submenu =$this->__EXECUTE($comando_sql,$option_conf);
				#$this->__PRINT_R($comando_sql);
									
				$submenu_html							="";
			
				foreach($datas_submenu as $data_submenu)
				{
					$alertas="";
					if(@$data_submenu["c_submenu_id"]>0)
						$alertas="
							<div style=\"color:white; float:right; margin-right:10px; background-color:red; border-radius: 15px; width:15px; align:center; padding:0px 2px 0px 2px;\">
								<center>{$data_submenu["c_submenu_id"]}</center>	
							</div>					
						";				

					$submenu_html	="
						$submenu_html
						<div style=\"height:25px;\" class=\"submenu\" active=\"{$data_submenu["name"]}\">	
							<div style=\"float:left;\">
								<font style=\"padding-left:5px; color:SteelBlue; font-size:13; font-weight:bold;\">
									{$data_submenu["name"]}
								</font>
							</div>
							$alertas
						</div>
					";
				
					#$datas_opcion  						=$menu->opcion_sesion($data_submenu["id"]);
				
					$comando_sql        ="
				        select
				        	distinct(m.id) as id_m,  
					        m.*
				        from 
					        usuario u join 
					        user_group ug on u.id=ug.user_id join
					        groups g on g.id=ug.active join
					        permiso p on p.usergroup_id=ug.active join
					        menu m on m.id=p.menu_id 
					    
				        where  1=1
					        AND ug.active!=0
					        AND u.id={$_SESSION["user"]["id"]}
					        AND parent={$data_submenu["id"]}
					        AND m.type='opcion'
					    GROUP BY  m.id            
					";
					$datas_opcion =$this->__EXECUTE($comando_sql,$option_conf);
				
					$option_html	="";
					foreach($datas_opcion as $data_opcion)
					{
						$alertas="";
						if(@$data_opcion["c_opcion_id"]>0)
							$alertas="
								<div style=\"color:white;float:right; margin-right:10px; background-color:red; border-radius: 15px; width:15px; align:center; padding:0px 2px 0px 2px;\">
									<center>{$data_opcion["c_opcion_id"]}</center>	
								</div>					
							";				


						$option_html	.="
							<a href=\"{$data_opcion["link"]}&sys_menu={$sys_menu}\">
								<div class=\"submenu2\">
									{$data_opcion["name"]}
									$alertas
								</div>
							</a>
						";
					}	
					$submenu_html	="
						$submenu_html
						<div class=\"option d_none\"  active=\"{$data_submenu["name"]}\">
							$option_html
						</div>
					";
				}
				$words["system_submenu"]	    		=$submenu_html;
			
				#$this->__PRINT_R($words);
			}			
			return $words;
		} 

		public function __COMPANYS()
		{ 
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;
				
			$comando_sql = "
				SELECT 
					id, 
					razonSocial 
				FROM 
					company
				WHERE 
					razonSocial is not null"; 

		    $datas              =$this->__EXECUTE($comando_sql, $option_conf);
			
		    foreach($datas as $data)
		    {    
		    	$selected="";
		    	if($_SESSION["company"]["id"]==$data["id"])
		    		$selected="selected";
		    	$vOption = $vOption."<option value=\"".$data["id"]."\"  $selected >".$data["id"]." :: ".$data["razonSocial"]."</option>";		    	
		    }

			$vRespuesta = "	<select id = \"setting_company\" system=\"yes\" name = \"setting_company\">".$vOption."</select>";

			return $vRespuesta;
		} 

        ##############################################################################

		public function __REQUEST()
		{  
			# ASIGNA TODAS LAS VARIABLES QUE CONTENGAN VALOR
			# AL ARRAY DECLARADO $this->sys_fields EN EL MODEDLO
			# O CREANDO UNA NUEVA PROPIEDAD 
						
			
			foreach($_REQUEST as $campo =>$valor)
			{
				if(!($valor=="" OR $valor=="undefined"))
				{					
					$this->request["$campo"]		=$valor;
					if(is_array($valor))
					{
						$eval="
							if(is_array(@$"."this->sys_fields[\"$campo\"]))	
							{
								$"."this->sys_fields[\"$campo\"]"."[\"value\"]=$"."valor;
							}									
						";					
					}
					else
					{					
						$eval="
							if(is_array(@$"."this->sys_fields[\"$campo\"]))	
							{
								$"."this->sys_fields[\"$campo\"]"."[\"value\"]=\"$valor\";
							}		
							else
							{
								$"."this->$campo=\"$valor\";
							}
							
						";
					}	
				    if(@eval($eval)===false)	
				    	echo ""; #$eval; ---------------------------					
				}	
			}
			if(is_array($_FILES))
			{
				$this->request["files"]=array();				
				foreach($_FILES as $valor)
				{
					$this->request["files"]			=$valor;						
				}	
			}	
			
			if(isset($this->request["sys_menu"]))
			{
				$_SESSION["sys"]["menu"]			=$this->request["sys_menu"];
			}	
			
			if(!isset($this->request["sys_view"]))	$this->request["sys_view"]	="";	
		} 
		##############################################################################
		public function __VIEW_TEMPLATE($template,$words)
		{  
			# CON LA PLANTILLA BASE, 
			# CARGA LA PLANTILLA INDICADA
			# VERIFICANDO QUE LA SOLICITUD, NO SEA UNA, IMPRESION, EXCEL, O PDF
			
		    $view   								=$this->__TEMPLATE("sitio_web/html/index");		    
		    if(@$this->request["sys_action"]=="print_pdf")
		    {
				$view="{system_template}";
			}	
		    
		    $sys_action     						=@$this->request["sys_action"];
		    
		    if(@$this->request["sys_action"]=="print_excel")
		    {
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment;filename=\"{$words["module_title"]}.xlsx\"");
				header("Cache-Control: max-age=0");		    
		    	$sys_action							="print_report";
		    }
		    if(@$this->request["sys_action"]=="print_pdf")
		    {
		    	/*
				header("Content-Type: application/pdf");
				header("Content-Disposition: attachment;filename=\"filename.pdf\"");
				header("Cache-Control: max-age=0");		    
				*/
		    	$sys_action							="print_report";
		    }		    
		    $path           						="sitio_web/html/$sys_action";
		    
		    if(file_exists($path.".html"))			
		    {
		        $template="$sys_action";
		        #if(@$this->request["sys_action"]!="print_excel")
			        #$words["system_js"]				="window.print();";
		    }    		    
		    
		    $array  								=array("system_template"=> $this->__TEMPLATE("sitio_web/html/$template"));
		    $words									=array_merge($array,$words);
		    
            return $this->__REPLACE($view,$words);
    	} 
    	##############################################################################
		function __TEMPLATE($form=NULL)
		{
			# RETORNA UNA CADENA, QUE ES LA PLANTILLA
			# DE LA RUTA ENVIADA		
	    	if(!is_null($form))
	    	{
	    		$archivo = $form.'.html';
	    		if(file_exists($archivo))			    			
		    		$return 						= file_get_contents($archivo);		    
	    		elseif(file_exists("../".$archivo))			    			
		    		$return 						= file_get_contents("../".$archivo);		    		    		
	    		elseif(file_exists("../../".$archivo))			    			
		    		$return 						= file_get_contents("../../".$archivo);		    		    		
	    		elseif(file_exists("../../../".$archivo))			    			
		    		$return 						= file_get_contents("../../../".$archivo);		    		    		
		    		
		    	else	
		    		$return							="<br>NO EXISTE EL ARCHIVO: ".$archivo;
		    }	
		    else	$return							="";		    		
		    return $return;
		}		
		function __TEMPLATE2($form=NULL)
		{
			$return=$this->__TEMPLATE($form);
			$return.="<br><br><br><br>";
			$return.=$this->__TEMPLATE($form);					
		    return $return;
		}			
		##############################################################################
		function send_mail($option)
		{
			if(!isset($option["title"]))	$option["title"]="SolesGPS :: Sistema";
			if(!isset($option["from"]))		$option["from"]	="contacto@solesgps.com";
			if(!isset($option["bbc"]))		$option["bbc"]	="evigra@gmail.com";
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			if(isset($option["from"]))		$headers .= "From: <{$option["from"]}>\r\n";
			if(isset($option["cc"]))		$headers .= "Cc: {$option["cc"]}\r\n";
			if(isset($option["bbc"]))		$headers .= "bbc: {$option["bbc"]}\r\n";
			#if(isset($option["reply"]))		$headers .= "Reply-To: {$option["reply"]}\r\n";
			
			$boSend =  @mail($option["to"], $option["title"], $option["html"], $headers);

			if(!$boSend) 
			{
				throw new Exception('Email fail');
			} 			
		}		
		##############################################################################
		public function __REPLACE($str,$words)
		{  
			# REMPLAZA Y RETORNA LAS PALABRAS CLAVE
			# EN UNA CADENA, ESTA CADENA POR LO REGULAR ES UNA VISTA
			if(is_array($words))
			{
				$return								=$str;
				foreach($words as $word=>$replace)
				{
		        	if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$word"]))	
		        		$replace					=$this->sys_view_l18n["$word"];
		        	if(is_array($replace))	$replace="";	
		        	
					$return							=str_replace("{".$word."}", $replace, $return);     	    	
				}
			}	
			else
				$return								="ERROR:: La funcion __REPLACE necesita un array para remplazar";
			return $return;
		} 		
		##############################################################################
		public function __PRE_SAVE()
    	{
			# ENVIA UN ARRAY AL METODO SAVE
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields

			$fields	=$this->__FIELDS();		
    					
			$opcion=array(
				"message"=>"DATOS GUARDADOS",
			);				
			$this->__SAVE($fields, $opcion);
    	}
		##############################################################################    
		public function __FIELDS()
    	{
			# RETORNA UN ARRAR DE LOS CAMPOS Y LOS VALORES 
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields
    	
			$this->__VARS();
			$datas		=$this->sys_fields;
			$return		=array();
    		foreach($datas as $campo=>$valor)
    		{
    			if(isset($valor["value"]) and $valor["value"]!="")
    			{
    				$return[$campo]=$valor["value"];
    			}
    		}    		
    		return $return;
    	}
		public function __IMPORT()
    	{		
			if(@$this->request["seccion_import"]=="subiendo_archivo")
			{
				
				if(isset($this->request["files"]) AND $this->sys_table!="general")
				{
					if(isset($this->request["files"]["error"]) AND $this->request["files"]["error"]==0)
					{
						$uploads_dir 			= 'import/mysql-files';
						$uploads_dir 			= 'C:/xampp/mysql/data/mysql-files';
						$datas					=array();
						
						$tmp_name 				= $this->request["files"]["tmp_name"];
						$name 					= $this->request["files"]["name"];
						$type 					= $this->request["files"]["type"];
						
						$vtype					=explode(".",$name);
						$ctype					=count($vtype) - 1;
						$extencion				=$vtype[$ctype];
						$path					="$uploads_dir/$name.{$this->sys_date}.$extencion";
						$path					="$uploads_dir/$name";

						move_uploaded_file($tmp_name, $path);		
						echo json_encode(array("mensaje"=>"<br> > Archivo Cargado <b>$name</b>","name"=>"$name","path"=>"$path"));
					}						
				}	
			}
			if(@$this->request["seccion_import"]=="preparar_tabla")
			{
				$option_conf=array();					
				$option_conf["open"]	=1;
				
				#$comando_sql 			="call import_csv('{$this->sys_table}','$name')";
				#$this->__EXECUTE($comando_sql,$option_conf);					

				$comando_sql 			="DROP TABLE IF EXISTS t_{$this->sys_table};";
				$this->__EXECUTE($comando_sql,$option_conf);					
				$comando_sql 			="CREATE TABLE t_{$this->sys_table} LIKE {$this->sys_table};";
				$this->__EXECUTE($comando_sql,$option_conf);					
				echo "<br> > Preparando base de datos temporal <b>{$this->sys_table}</b>";
			}
			if(@$this->request["seccion_import"]=="cargar_tabla")
			{
				$option_conf=array();
				/*		
				$comando_sql ="
					LOAD DATA INFILE '/var/lib/mysql-files/$name' 
					replace INTO TABLE t_{$this->sys_table}
					FIELDS TERMINATED BY ',' 
					ENCLOSED BY '\"'
					LINES TERMINATED BY '\\n'
					IGNORE 1 ROWS;					
				";
				*/
				$comando_sql ="
					LOAD DATA INFILE 'C:/xampp/mysql/data/mysql-files/{$this->request["name"]}' 
					replace INTO TABLE t_{$this->sys_table}
					FIELDS TERMINATED BY ',' 
					ENCLOSED BY '\"'
					LINES TERMINATED BY '\\n'
					IGNORE 1 ROWS;					
				";
				#$this->__PRINT_R($comando_sql);
				$this->__EXECUTE($comando_sql);
				echo "<br> > Cargando datos a tabla temporal <b>{$this->sys_table}</b>
					<div id=\"import_pendiente\"></div>
				";			

			}
			if(@$this->request["seccion_import"]=="actualizando_datos")
			{			
						
						foreach($this->sys_fields as $field=>$data)
						{
							# compara 	10   11
							# no update	01   11						
							if(@$data["type"]=="primary key") 	$clave=$field;
							
							if(@$data["import"]=="11" or @$data["import"]=="10")   
							{	#COMPARA
								if(!isset($to)) 
								{
									@$to	="torg.$field";
									@$tt	="tt.$field";
								}	
								else		
								{
									@$to	.=",torg.$field";
									@$tt	.=",tt.$field";
								}							
							}
							if(@$data["import"]=="11" or @$data["import"]=="01")
							{	#UPDATE
								if(!isset($sto)) 
								{
									@$sto	="torg.$field as torg_$field";
								}	
								else		
								{
									@$sto	.=",torg.$field as torg_$field";
								}							
							}
						}
						
						$comando_sql ="
							select 
								CASE 
									when concat($to) is NULL then 'add' 
									when concat($tt) != concat($to) then 'upd'     
								END as torg_status,
								tt.*
							from t_{$this->sys_table} tt left join {$this->sys_table} torg on tt.$clave=torg.$clave
							WHERE
								concat($tt) <> concat($to)
								OR
								concat($to) is NULL							
							ORDER BY torg_status
						";
						$datos_analizados=$this->__EXECUTE($comando_sql);
						$pendientes=count($datos_analizados);

						$upd=0;
						$add=0;
						$maximo=183;
						$script="";
						if($pendientes<$maximo)	$maximo=$pendientes;
						else
						{
							$script="
							<script>	
								var datos={		
									type: 'POST',													
									async: true,
									cache: false,
									contentType: false,
									enctype: 'multipart/form-data',
									processData: false,
								};
								var actualizar=datos;
								actualizar.url		='../sitio_web/ajax/general.php&seccion_import=actualizando_datos&sys_name={$this->sys_name}';										
								actualizar.success	=function (response) 
								{
									$(\"#import_pendiente\").html(response);												
								};											
								$.ajax(actualizar);								
							</script>						
							";
						}
						for($a=0;$a<$pendientes; $a++)
						{	
						#foreach($datos_analizados as $data)



						
						



						
							if(@$data["torg_status"]=="upd")
							{
								@$upd++;
								$fields=array();						
							}								
							if(@$data["torg_status"]=="add")
							{
								@$add++;
								$this->sys_primary_field	="";
								$this->sys_primary_id		="";
							
								unset($data["torg_status"]);
								$fields=$data;
							}
							if(is_array(@$fields))
							{								
								$this->__SAVE($fields);
							}	
							$comando_sql="DELETE FROM t_{$this->sys_table} WHERE {$this->sys_primary_field}='{$this->sys_primary_id}'";
							$this->__EXECUTE($comando_sql);								
							
						}
						
						echo "	
							<br><br> 
							$pendientes :: Registros pendientes<br> 
							$add :: Registros Nuevos <br>
							$upd :: Registros Actualizados		
							$script
						";
						
						#$comando_sql ="truncate t_{$this->sys_table}";
						#$option_conf["close"]	=1;										
						#$this->__EXECUTE($comando_sql,$option_conf);
			}
		}


    	##############################################################################    
		public function __VARS()
		{	
			# RECOGE LAS VARIABLES ENVIADAS DESDE EL FORM, 
			# ASIGNANDO UNICAMENTE LAS DECLARADAS EN EL MODELO 
			# $this->sys_fields
			
			foreach($this->sys_fields as $campo=>$valor)
			{
				if(!isset($this->request["$campo"]))		$this->request["$campo"]="";
				else $this->sys_fields["$campo"]["value"]	=$this->request["$campo"];
			}		
		}    
		public function __GET_PRIMARY()
		{	
    		foreach($this->sys_fields as $campo=>$valor)
    		{
				if($this->sys_fields["$campo"]["type"]=='primary key')
				{
					$this->sys_primary_field=$campo;	
				}
			}				
		} 		
		public function lugar($option)
		{				
			$comando_sql	="SELECT * FROM lugar WHERE clave='$option'";
			$return			=$this->__EXECUTE($comando_sql);
			
			if(is_array($return) AND isset($return[0]["lugar"])) 		$return=@$return[0]["lugar"];
			else $return="COLIMA";
						
			return $return;
		}
    	##############################################################################    
		public function __INPUT($words=NULL, $fields=NULL)
		{				    
		    if(!is_array($words))    $words=array();
		    if(is_array($fields))
		    {
			    foreach($fields as $campo=>$valor)
			    {		
			        if(!isset($valor["type"]))	        $valor["type"]			="input";
			        if(!isset($valor["showTitle"]))	    $valor["showTitle"]		="si";
			        if(!isset($valor["title"]))	    	$valor["title"]			="";
			        if(!isset($valor["value"]))	    	$valor["value"]			="";
			        if(!isset($valor["source"]))	   	$valor["source"]		="";
			        if(!isset($valor["holder"]))	   	$valor["holder"]		="";
			        if(!isset($valor["attr"]))	   		$valor["attr"]			="";
					if(!isset($valor["style"]))	   		$valor["style"]			="";
					
					$style="style=\"";
					if(is_array($valor["style"]))
					{
						
						if(@is_array($valor["style"]["background-color"]))
						{								
			        		foreach($valor["style"]["background-color"] as $color => $eval_color)
			        		{
								$eval_color="if({$eval_color}) 			$"."style.=\"background-color:$color;\";";
			        		}			        	
						}	
						if(@is_array($valor["style"]["border"]))
						{								
			        		foreach($valor["style"]["border"] as $color => $eval_color)
			        		{
								$eval_color="if({$eval_color}) 			$"."style.=\"border: 1px solid $color; \";";
			        		}			        	
						}						
						#$this->__PRINT_R($eval_color);
						eval($eval_color);
					}
					$style.="\"";
			        
			        if(!is_array($valor["value"]))
			        {
			        	if(!isset($valor["description"]))	$valor["description"]="";
			        	
			        	$description	=$valor["description"];

			        	$attr="";
			        	if(is_array($valor["attr"]))
			        	{	
			        		#$this->__PRINT_R($valor["attr"]);
			        		foreach($valor["attr"] as $attr_field => $attr_value)
			        		{
			        			$attr.=" $attr_field='$attr_value'";
			        		}			        	
			        	}			        				        	
			        				        	
					    if(in_array($valor["showTitle"],$this->sys_true))	
					    {			        
					    	if(is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$campo"]))	
					    	{			        	
					    		$valor["title"]		=$this->sys_fields_l18n["$campo"];
					    	}	

							if($valor["type"]=="txt")	$titulo					="{$valor["title"]}";			        	
							else						$titulo					="<font id=\"$campo\" $attr style=\"color:gray;\">{$valor["title"]}</font>";			        	
					    	
					    }	
					    else                                				$titulo					="";

					    
					    if($valor["type"]=="input")	
					    {			        	
					        $words["$campo"]  ="$titulo<input id=\"$campo\"  type=\"text\" name=\"$campo\" value=\"{$valor["value"]}\" placeholder=\"{$valor["holder"]}\" class=\"formulario\" >";
					        $words["$campo"]  ="<input id=\"$campo\" $style title=\"$description\" type=\"text\" $attr name=\"$campo\" placeholder=\"{$valor["holder"]}\"  value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\"><br>$titulo";
					    } 
					    if($valor["type"]=="date")	
					    {
					        #$words["$campo"]  ="$titulo<input id=\"$campo\" type=\"text\" name=\"$campo\" value=\"{$valor["value"]}\" placeholder=\"{$valor["holder"]}\" class=\"formulario\" >";
					        $words["$campo"]  ="
					        	<input id=\"$campo\" type=\"text\" name=\"$campo\" title=\"$description\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\"><br>$titulo
			        			<script>
									$(\"input#$campo\").datepicker({dateFormat:\"yy-mm-dd\"});
					        	</script>			            	
					        	";
					    } 
					    if($valor["type"]=="multidate")	
					    {
					        #$words["$campo"]  ="$titulo<input id=\"$campo\" type=\"text\" name=\"$campo\" value=\"{$valor["value"]}\" placeholder=\"{$valor["holder"]}\" class=\"formulario\" >";
					        $js_multidate="";
							if(@$this->request["sys_section_".$this->sys_name]=="write")
							{
								$valores_multidate=explode(",",$valor["value"]);
								$days_value="";
								foreach($valores_multidate as $day)
								{
									$day=trim($day);
									if($days_value=="")	$days_value="'$day'";
									else				$days_value.=", '$day'";
								}
								
								$js_multidate="addDates: [$days_value]";
					        }
					        $words["$campo"]  ="
					        	<input id=\"$campo\" type=\"text\" name=\"$campo\" title=\"$description\"  $attr class=\"formulario {$this->sys_name}\"><br>$titulo
			        			<script>
									$(\"input#$campo\").multiDatesPicker(
									{
										dateFormat: \"yy-mm-dd\",
										$js_multidate
									});
					        	</script>			            	
					        	";
					    } 
					    
					    if($valor["type"]=="checkbox")	
					    {
					        //$words["$campo"]  ="<input id=\"$campo\" type=\"checkbox\" name=\"$campo\" class=\"formulario\"><br>$titulo";

					    	$words["$campo"]  = 
					        "$titulo<div class=\"checkbox-2\">
		    					<input type=\"checkbox\" id=\"$campo"."c\" title=\"$description\" $attr checked value=\"1\" name=\"$campo\" />
		    					<label for=\"$campo"."c\">".""."</label>
							</div>
							<br>
							";


					    }      
					    if($valor["type"]=="file")	
					    {
					        $words["$campo"]  ="$titulo<input id=\"$campo\" name=\"$campo\" type=\"file\" class=\"formulario\">";
					        $words["$campo"]  ="<input id=\"$campo\" title=\"$description\" $attr name=\"$campo\" type=\"file\" class=\"formulario {$this->sys_name}\"  placeholder=\"{$valor["holder"]}\"><br>$titulo";
					    }    

					    if($valor["type"]=="font")	
					    {
					        $words["$campo"]  ="$titulo<div id=\"$campo\" class=\"{$this->sys_name}\" $attr style=\"height:22px;\"> {$valor["value"]}</div><br>&nbsp;";
					    } 
					    if($valor["type"]=="txt")	
					    {
					        $words["$campo"]  ="$titulo";
					    } 
					    
					    if($valor["type"]=="textarea")	
					    {
					        $words["$campo"]  ="<textarea id=\"$campo\" title=\"$description\" name=\"$campo\" $attr class=\"formulario {$this->sys_name}\" style=\"height:150px;\" placeholder=\"{$valor["holder"]}\">{$valor["value"]}</textarea><br>$titulo";
					    } 			           
					    if($valor["type"]=="password")	
					    {
					        $words["$campo"]  ="$titulo<input type=\"password\" id=\"$campo\" name=\"$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\">";
					        $words["$campo"]  ="<input type=\"password\" title=\"$description\" id=\"$campo\" $attr name=\"$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\"><br>$titulo";
					    }    
					    if($valor["type"]=="select")	
					    {
					        $options="";
					        
					        foreach($valor["source"] as $value =>$text)
					        {
					        	$selected="";
					        	if($valor["value"]==$value) $selected="selected";
					        	$options.="<option value=\"$value\" $selected>$text</option>";			            
					        }			            
						        $words["$campo"]  ="<select id=\"$campo\" title=\"$description\" name=\"$campo\"  $attr class=\"formulario {$this->sys_name}\">
					        		$options
					        	</select><br>$titulo
					        ";
					    }			        
					    if($valor["type"]=="autocomplete")	
					    {
					    	if(!isset($fields["auto_$campo"]["value"]))	$fields["auto_$campo"]["value"]="";
					    	
					    	
					    	$json=$this->__JSON_AUTOCOMPLETE($valor);
					    	
					    	if(isset($this->request["auto_$campo"]))	$fields["auto_$campo"]["value"]	=$this->request["auto_$campo"];
					    	else										$fields["auto_$campo"]["value"]	=@$json[0]->label;
					    	
					    	if(isset($this->request["$campo"]))			$fields["$campo"]["value"]		=$this->request["$campo"];
					    	else										$fields["$campo"]["value"]		=@$json[0]->clave;
					    	
					    	$label	=$fields["auto_$campo"]["value"];
					    	if(isset($fields["$campo"]["class_field_l"]))
					    	{
					    		if(isset($fields["$campo"]["values"]) AND count($fields["$campo"]["values"])>0)
					    		{
					    			$label=$fields["$campo"]["values"][0][$fields["$campo"]["class_field_l"]];
					    		
					    		}
					    	}
					    
					        $words["$campo"]  ="					        	
					        	<input id=\"auto_$campo\" type=\"text\"  name=\"auto_$campo\" title=\"$description\" $attr value=\"$label\" class=\"formulario {$this->sys_name}\"  placeholder=\"{$valor["holder"]}\"><br>$titulo
					        	<input id=\"$campo\" name=\"$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\" type=\"hidden\">
					        	<script type=\"\">
									$(\"input#auto_$campo\").autocomplete(
									{		
										source:\"{$valor["source"]}\",
										dataType: \"jsonp\",
										select: function( event, ui ) // CUANDO SE SELECCIONA LA OPCION REALIZA LO SIGUIENTE
										{	
											$(\"input#$campo\").val(ui.item.clave);					
											$(\"input#auto_$campo\").val(ui.item.label);										
										}				
									});				            	
					        	</script>
					        ";
					    }    
					    if($valor["type"]=="class")	
					    {					    
							if(isset($valor["relation"]) AND $valor["relation"]=="one2many")
							{
								$eval="";
								$eval="
									$"."this->$campo				=new {$valor["class_name"]}();									
									$"."this->$campo"."_obj->sys_module	=\"{$valor["class_name"]}\";
								";	
								$eval="
									$"."this->$campo"."_obj				=new {$valor["class_name"]}();																	
								";	
								/*
								if(isset($valor["template_title"]) AND isset($valor["template_body"]));
								{
									$eval.="
										$"."option[\"template_title\"]		=	\"". $valor["template_title"] ."\";
										$"."option[\"template_body\"]		=	\"". $valor["template_body"] ."\";
									";
								}
								if(array_key_exists("template_search",$valor) AND $valor["template_search"]!="")
								{																	
									$eval.="$"."option[\"template_search\"]		=	\"{$valor["template_search"]}\";";
								}
								if(array_key_exists("template_create",$valor) AND $valor["template_create"]!="")
								{									
									$eval.="$"."option[\"template_create\"]		=	\"". $valor["template_create"] ."\";";
								}	
								/*
								$eval.="
									$"."data			=	$"."this->$campo"."_obj->__BROWSE($"."option);
								";
								*/
								if(@eval($eval)===false)	
									echo ""; #$eval; ---------------------------								        			
							}			        		
					    	#$words["$campo"]  =$data["html"];
					    }					    
					    if($valor["type"]=="hidden")	
					    {
					        $words["$campo"]  ="<input type=\"hidden\" id=\"$campo\" name=\"$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario\">";
					    }    
					    if($valor["type"]=="img")	
					    {
					        $words["$campo"]  ="$titulo<img id=\"$campo\" name=\"$campo\" $attr src=\"{$valor["value"]}\">";
					    }    
					}
			        
			    }
			}    
			else $words="ERROR :: No se asigno el array de campos $"."this->sys_fields";

			
			return $words;
		}   		
    	##############################################################################    
		public function __INPUT_TYPE($type=NULL, $fields=NULL)
		{
			if(is_null($fields))
			{
				foreach($this->sys_fields as $field=>$value)
					$this->sys_fields[$field]["type"]=$type;
			}				
			else
			{
				foreach($fields as $field)
					$this->sys_fields[$field]["type"]=$type;
			}
		}
    	##############################################################################    
		public function __VIEW_OPTION($data)
		{
			$view="";
			foreach($data as $row)			
			{
				if($row["type"]=="menu")	$view   .=$this->__TEMPLATE("sitio_web/html/menu_option");
				else						$view   .=$this->__TEMPLATE("sitio_web/html/menu_link");
				$view	=$this->__REPLACE($view,$row);				
			}		
			return $view;
		}    	

    	##############################################################################    
		public function __VIEW_CREATE($template)
		{
			$view   =$this->__TEMPLATE("$template");
			$view	=$this->__VIEW_INPUTSECTION($view);
			return $view;
		}    	
    	##############################################################################    
		public function __VIEW_WRITE($template)
		{
			$view   =$this->__TEMPLATE("$template");
			$view	=$this->__VIEW_INPUTSECTION($view);
			
			return $view;
		}    	
		public function __VIEW_INPUTSECTION($view)
		{								
			$sys_section	=@$this->request["sys_section_".$this->sys_name];
			$sys_action		="";
			$sys_id			=@$this->request["sys_id_".$this->sys_name];
		
			$view.="
				<input id=\"sys_section_{$this->sys_name}\" system=\"yes\"  name=\"sys_section_{$this->sys_name}\" value=\"{$sys_section}\" type=\"hidden\">
				<input id=\"sys_action_{$this->sys_name}\" system=\"yes\" name=\"sys_action_{$this->sys_name}\" value=\"{$sys_action}\" type=\"hidden\">
				<input id=\"sys_id_{$this->sys_name}\" system=\"yes\" name=\"sys_id_{$this->sys_name}\" value=\"{$sys_id}\" type=\"hidden\">
			";			
			return $view;
		}    	

    	##############################################################################    
		public function __VIEW_KANBAN($template,$data,$option=NULL)
		{
		    if(is_null($option))	$option=array();
		    if(!array_key_exists("name",$option))   $option["name"]=$this->sys_name;
	    
		    
		    $return=$this->__VIEW_KANBAN2($template,$data,$option);
		    $return="
                <div id=\"base_{$option["name"]}\" style=\"position:relative; height:100%; width:100%;\">
                    <div id=\"div_{$option["name"]}\" style=\"height:100px; overflow:hidden; width:100%; \">	
                        $return
                    </div>
                </div>
				<script>
					var alto_{$option["name"]}	    =$(\"#base_{$option["name"]}\").height() -20;
					$(\"div#div_{$option["name"]}\").attr({\"style\":\"height:\"+alto_{$option["name"]}+\"px; overflow:auto; width:100%;\"});													
				</script>                
            ";
		    
		    return $return;
        }
		public function __VIEW_KANBAN2($template,$data,$option=NULL)
		{			
			$view="";
			$class="even";

			if(is_null($option))	$option=array();	
			if(!array_key_exists("name",$option))   $option["name"]=$this->sys_name;
			
			if(is_array($data))
			{
			    foreach($data as $row)			
			    {
					foreach($row as $field=>$fieldvalue)			
					{		
						#$this->sys_fields[$field]["value"]=$fieldvalue;
										
						if(@$this->sys_fields[$field]["type"]=="autocomplete")
						{
							$this->sys_fields[$field]["value"]=$fieldvalue;
							
							$json				=$this->__JSON_AUTOCOMPLETE($this->sys_fields[$field]);							
							if(@$json[0]->label!="Sin resultados para ")		$row["auto_$field"]	=@$json[0]->label;
							else												$row["auto_$field"]	="";
						}	
					}			    
                    if($class=="odd")   
                    {
                    	$class="even";
                    	$style="background-color:#D5D5D5; height:30px;";	
                    }	
                    else                
                    {
                    	$class="odd";
                    	$style="background-color:#E5E5E5; heigth:30px;";	
                    }	
                    
                    $actions				=array();
                    $colors					=array();
                    if(substr(@$this->request["sys_action"],0,5)!="print")	              
	                    $actions["class"]		=$class;
	                else    
	                    $actions["style_tr"]	=$style;
                    
                    				
                    $show	="<font data=\"&sys_section_{$this->sys_name}=show&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-contact\"></font>";
                    $write	="<font data=\"&sys_section_{$this->sys_name}=write&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-pencil\"></font>";
                    $delete	="<font data=\"&sys_section_{$this->sys_name}=delete&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-trash\"></font>";
                    $check	="<input type=\"checkbox\" id=\"{$option["name"]}\" name=\"{$option["name"]}[]\" value=\"{id}\">";
                    
                    if(!is_null($option))
                    {
                    	
                    	if(!isset($option["actions"]))				$option["actions"]=array();	
                    	
                    	if($option["actions"]=="false")
                    	{
                    		$option["actions"]			=array();		
                       		$option["actions"]["show"]	="1==0";
	                		$option["actions"]["write"]	="1==0";
	                		$option["actions"]["delete"]="1==0";
	                		$option["actions"]["check"]	="1==0";	
                    	}
                    	else
                    	{
		                	if(!isset($option["actions"]["show"]))		$option["actions"]["show"]	="1==1";
		                	if(!isset($option["actions"]["write"]))		$option["actions"]["write"]	="1==1";
		                	if(!isset($option["actions"]["delete"]))	$option["actions"]["delete"]="1==1";
		                	if(!isset($option["actions"]["check"]))		$option["actions"]["check"]	="1==1";
                    	}           

						

	                	if($option["actions"]["show"]=="true")			$option["actions"]["show"]	="1==1";
	                	elseif($option["actions"]["show"]=="false")		$option["actions"]["show"]	="1==0";
	                	if($option["actions"]["write"]=="true")			$option["actions"]["write"]	="1==1";
	                	elseif($option["actions"]["write"]=="false")	$option["actions"]["write"]	="1==0";
	                	if($option["actions"]["delete"]=="true")		$option["actions"]["delete"]="1==1";
	                	elseif($option["actions"]["delete"]=="false")	$option["actions"]["delete"]="1==0";
	                	if($option["actions"]["check"]=="true")			$option["actions"]["check"]	="1==1";
	                	elseif($option["actions"]["check"]=="false")	$option["actions"]["check"]	="1==0";
                    	
                    	
                    	         	
                    	$eval="
                    		if({$option["actions"]["show"]}) 						$"."show='$show';
                    		else													$"."show='';
                    		
                    		if({$option["actions"]["write"]}) 						$"."write='$write';
                    		else													$"."write='';
                    		
                    		if({$option["actions"]["delete"]}) 						$"."delete='$delete';
                    		else													$"."delete='';
                    		                    		
                    		if({$option["actions"]["check"]}) 						$"."check='$check';
                    		else													$"."check='';                    		
                    	";
                    	$eval_color="";
                    	if(!isset($option["color"]))				$option["color"]=array();
                    	
                    	if(!isset($option["color"]["black"]))		$option["color"]["black"]="1==1";
                    	
                    	foreach($option["color"] as $color => $filter)
                    	{							
							
							
							#$this->__PRINT_R("echo ". $option["color"]["$color"] .";");
							#if(substr($row["trabajador_puesto_id"],1,6) != substr($row["sustituto_puesto_id"],1,6))
							#$this->__PRINT_R(substr($row["trabajador_puesto_id"],0,6) ."!=". substr($row["sustituto_puesto_id"],0,6));
							
                    		if($eval_color=="")	$eval_color="if({$option["color"]["$color"]}) 			$"."colors[\"style_td\"]='color:$color;';";
                    		else 				$eval_color.="else if({$option["color"]["$color"]}) 	$"."colors[\"style_td\"]='color:$color;';";
                    	}
                    	
                    	$eval.=$eval_color;
                    	#$this->__PRINT_R($eval); #$eval; ---------------------------					
                    	if(@eval($eval)===false)	
				    		echo ""; #$eval; ---------------------------					
				    	
				    	

                    }
                    if(substr(@$this->request["sys_action"],0,5)!="print")
                    {
						$actions["actions"]	="
							<table class=\"cBotones cBodyReport\">
								<tr>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_selected}\">	
										$check
									</td>								
									<td class=\"cAction\" align=\"center\" width=\"22\"  style=\"border-radius:10px 10px 10px 10px;\"  title =\"{actions_show}\">	
										$show			
									</td>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_write}\">	
										$write
									</td>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_delete}\">	
										$delete
									</td>					    		
								</tr>
							</table>
						";
						$actions["actionsv"]	="
							<table class=\"cBotones actionsv\" style=\"display:none;\">
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_selected}\">$check</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_show}\">$show</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_write}\">$write</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_delete}\">$delete</td></tr>
							</table>
						";
					}
					else
					{
						$actions["actionsv"]	="";
						$actions["actions"]		="";
					}                   
                    
                    $row = array_merge($actions, $row);
                    $row = array_merge($colors, $row);
                    
				    if(@$html_template=="")  
				    {
				    	$html_template  =$this->__TEMPLATE("$template");
				    	$html_template	=str_replace("<td>", "<td style=\"{style_td}\" >", $html_template);				    	
				    }	

				    $view   .=$html_template;
				    $view	=$this->__REPLACE($view,$row);				
			    }		

	        	if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n))	
	        	{
	        		#$actions_lang["actions_selected"]	=$this->sys_view_l18n["actions_selected"];
	        		$actions_lang["actions_show"]		=$this->sys_view_l18n["actions_show"];
	        		$actions_lang["actions_write"]		=$this->sys_view_l18n["actions_write"];
	        		$actions_lang["actions_delete"]		=$this->sys_view_l18n["actions_delete"];
	        				        		
	        		#$row 	= array_merge($actions_lang, $row);
					$view	=$this->__REPLACE($view,$actions_lang);
	        	}                                        			    
			}    
			$view =$this->__VIEW_INPUTSECTION($view);
			return $view;
		}    	
    	##############################################################################    
		public function __VIEW_SHOW($template)
		{
			$this->__INPUT_TYPE("font");
			$view   =$this->__TEMPLATE("$template");
			$view	=$this->__VIEW_INPUTSECTION($view);
			return $view;
		} 		
    	##############################################################################        
		public function __VIEW_REPORT($option)
		{
			$return=array();
		    $view_title="";
		    if(is_array($option))
		    {
				if(isset($option["total"]))		$return["total"]	=$option["total"];
				if(isset($option["inicio"]))	$inicio				=$option["inicio"];
				if(isset($option["fin"]))		$fin				=$option["fin"];
		    	
		        $sys_order="";
		        $sys_torder="";
		    	if(!isset($option["name"]))    	$name	=@$this->sys_name;
		    	else							$name	=$option["name"];
				
				$this->sys_name=$name;		
		    	
		    	if(isset($this->request["sys_page_$name"]))		$sys_page	=$this->request["sys_page_$name"];
		    	else											$sys_page	=1;

		    	if(isset($this->request["sys_order_$name"]))	$sys_order	=$this->request["sys_order_$name"];
		    	
		    	if(isset($this->request["sys_torder_$name"]))	$sys_torder	=$this->request["sys_torder_$name"];
		    	
		    	if(isset($this->request["sys_row_$name"]))	    $sys_row	=$this->request["sys_row_$name"];
		    	else                                            $sys_row	=50;

		    	$option["sys_page_$name"]           =$sys_page;		        		        
				
		    	if(isset($option["data"]))          $return["data"] =$option["data"];	
		    	else
		    	{	
		    		
		    	    $option["name"]                 =$name;
		    	   
		    		$browse 						=$this->__BROWSE($option);		    	
		    		
					

		    		$return["data"]					= $browse["data"];
		    		$option["title"]				= @$browse["title"];
		    		
		    		if(isset($browse["total"]))		
		    		{
						$return["total"]				= $browse["total"];	
						
						$inicio				            = $browse["inicio"] + 1;
						$aux_fin                        = $inicio + $sys_row -1;
						
						if($aux_fin<$return["total"])   $fin    =$aux_fin;
						else                            $fin    =$return["total"];
					}			    		
		    	}	


				$view_title="";
		    	if(isset($option["template_title"]))    
		    	{
		    	    $view_title     =$this->__TEMPLATE($option["template_title"]);		    	    
		    	    $view_title		=str_replace("<td>", "<td class=\"title\">", $view_title);
		    	    
		    	    if(isset($option["title"]))
		    	    {

			    	    $view_title	    =$this->__REPLACE($view_title,$option["title"]);
			    	}    		    	    
		    	}    
		    	$view_create	="";
		    	$button_create	="";
		    	if(isset($option["template_create"]) AND $option["template_create"] !="")
		    	{
					$this->words               	=	$this->__INPUT($this->words,$this->sys_fields);
		    
		    		$view_create		=	$this->__REPLACE($this->__VIEW_CREATE($option["template_create"]),$this->words);
					$view_create="
            			<div id=\"create_$name\" title=\"Crear Resgistro\" class=\"report_search d_none\" style=\"width:100%; background-color:#373737;\">
	            			$view_create
	            			<script>
	            				$(\"font#create_$name\").click(function()
	            				{
	            					$(\"div#create_$name\").dialog({
	            						open: function(event, ui){
											var dialog = $(this).closest('.ui-dialog');
											if(dialog.length > 0)
											{
												$('.ui-autocomplete.ui-front').zIndex(dialog.zIndex()+1);
											}
										},
	            						width:\"700px\"
	            					});
	            				});
	            			</script>
            			</div>
					";		    	    
					$button_create="
						<td width=\"15\" align=\"center\">
							<font id=\"create_$name\" active=\"$name\" class=\"show_form ui-icon ui-icon-document\"></font>
						</td>	
					";					
		    	}    

		    	$view_search="";
		    	$button_search="";
		    	if(isset($option["template_search"]) AND $option["template_search"] !="")    
		    	{		    		
		    		$this->words["module_body"]     =$this->__VIEW_CREATE($option["template_search"]);
		    		$this->words					=$this->__INPUT($this->words,$this->sys_fields); 


					$view_search					=$this->words["module_body"];
		    		$this->words["module_body"]		="";
		    		
		    	    $view_search     				=$this->__TEMPLATE($option["template_search"]);		    	    
		    	    $view_search					=str_replace("<td>", "<td class=\"title\">", $view_search);
		    	    		    	    
					$view_search="
            			<div id=\"search_$name\" title=\"Filtrar Resgistro\" class=\"report_search d_none\" style=\"width:100%; background-color:#373737;\">
	            			$view_search
	            			<script>
	            				$(\"font#search_$name\").click(function()
	            				{
	            					$(\"div#search_$name\").dialog({
	            						open: function(event, ui){
											var dialog = $(this).closest('.ui-dialog');
											if(dialog.length > 0)
											{
												$('.ui-autocomplete.ui-front').zIndex(dialog.zIndex()+1);
											}
										},
	            						width:\"700px\"
	            					});
	            				});
	            			</script>	            			
            			</div>
					";		    	    
					$button_search="
						<td width=\"25\" align=\"center\">
							<font id=\"search_$name\" active=\"$name\" class=\"show_form ui-icon ui-icon-search\"></font>
						</td>	
					";		    	    
		    	}    
                $view_body="";
		    	if(isset($option["template_body"]))
		    	{    
		    	    $template       =$option["template_body"];
		    	    $option_kanban	=array();
		    	    if(isset($option["actions"]))	$option_kanban["actions"]	=$option["actions"];
		    	    if(isset($option["color"]))		$option_kanban["color"]		=$option["color"];
		    	    if(isset($option["name"]))		$option_kanban["name"]		=$name;

		    	    $view_body=$this->__VIEW_KANBAN2($template,$return["data"],$option_kanban);
		    	}    
                if(isset($inicio) AND $return["total"]>0)
                {                	
                	if(@$this->request["sys_action"]=="print")	$view_head="";                	                
                	else
                	{	
                		#<div id=\"report_$name\" style=\"height:35px; width:100%; \" class=\"ui-widget-header\">
                		$view_head="
							<div id=\"report_$name\" style=\"height:35px; width:100%;\" class=\"ui-widget-header\">
								<table width=\"100%\" height=\"100%\">
									<tr>
										$button_search
										$button_create
										
										<td align=\"left\" width=\"33%\">
											<b>Mostrando registros del $inicio al $fin de {$return["total"]}</b>
										</td>								
										<td></td>
										<td  width=\"30\" align=\"center\" >
											<font action=\"-\" name=\"$name\" class=\"page ui-icon ui-icon-carat-1-w\"></font>
										</td>
										<td width=\"50\">
						";
						if(@$this->request["sys_action"]!="print_pdf")	
						{
							$view_head.="
											<select type=\"report\" name=\"sys_row\" id=\"sys_row\">
												<option value=\"20\">20</option>
												<option value=\"50\">50</option>
												<option value=\"100\">100</option>
												<option value=\"200\">200</option>
												<option value=\"500\">500</option>
											</select>
							";
						}				
						$view_head.="	
										</td>
										<td width=\"30\" align=\"center\" >
											<font action=\"+\" name=\"$name\" class=\"page ui-icon ui-icon-carat-1-e\"></font>
										</td>
										<td></td>
								
										<td align=\"right\" width=\"33%\"  style=\"padding-left:10px; padding-right:10px;\">
											<b>Mostrando la pagina $sys_page </b>
										</td>
									</tr>
								</table>		
								
							</div>                
                		";
                	}
					$view="
						<div id=\"base_$name\" style=\"height:100%; width:100%;\">
							<div id=\"div_$name\" style=\"height:100%; width:100%; \">								
								$view_head													
								<table width=\"100%\" style=\"background-color:#fff;\">
								$view_title
								$view_body							
								</table>
					";
					if(@$this->request["sys_action"]!="print_pdf")	
					{
						$view.="
								<input name=\"sys_order_$name\" id=\"sys_order_$name\" type=\"hidden\" value=\"$sys_order\">		
								<input name=\"sys_torder_$name\" id=\"sys_torder_$name\" type=\"hidden\" value=\"$sys_torder\">
								<input name=\"sys_page_$name\" id=\"sys_page_$name\" type=\"hidden\" value=\"$sys_page\">
								<input name=\"sys_row_$name\" id=\"sys_row_$name\" type=\"hidden\" value=\"$sys_row\">
						";
					}				
					$view.="
							</div>
						</div>		
					";
					if(@$this->request["sys_action"]!="print_pdf")	
					{				
						$view.="
							$view_search
							$view_create
							<script>						
								$(\".page\").click(function(){
									var action      	=$(this).attr(\"action\");						    
									var sys_page    	=$(\"#sys_page_$name\").val();
									if(action==\"-\")   sys_page--;
									else                sys_page++;
						
									$(\"#sys_page_$name\").val(sys_page);
									$(\"form\").submit(); 
								});				
								$(\".title\").resizable({
									handles: \"e\"
								});
							</script>							
						";
					}
					$return["html"]	=$view;
				}	
				else
				{
					$view="
							<div id=\"report_$name\" style=\"height:35px; width:100%; \" class=\"ui-widget-header\">
								<table width=\"100%\" height=\"100%\">
									<tr>
										<td align=\"center\">
											<b>No se encontraron registros</b>
										</td>								
									</tr>
								</table>		
								
							</div>                					
					";				
					$view	=$this->__VIEW_INPUTSECTION($view);										
					$return["html"]	=$view;
				}
		    }	
		    else $return["html"]="Es necesario un array para generar el reporte";
		    
		    #$return["html"]	=$this->__VIEW_INPUTSECTION($return["html"]);
		    
		    return $return;
		}   
    	##############################################################################        
		public function __MESSAGE($message,$option=NULL)
		{
			if(is_null($option))	$option=array();
			
			if(isset($option["template"]))		$template 	=$option["template"];
			else 								$template 	="message";
		    
		    #if(isset($option["message"]))  		$message    =$option["message"];
		    #else                           		$message    ="No se ha indicado un mensaje";
		    
		    if(isset($option["image"]))    		$image      =$option["image"];
		    else                           		$image      ="sitio_web/alerta_azul.png";
		    
			$html_template  =$this->__TEMPLATE("sitio_web/html/".$template);
			$html_template  ="";		  
		    
		    $datas          =array("message"=>$message,"image"=>$image);
	        $view	        =$this->__REPLACE($html_template,$datas);	
		    
		    $jquery="
		    	$(\"#message\").dialog({
					show: {
						effect: \"shake\",
						duration: 750
					},		    			    	
		    		width:\"350\",
		    		modal: true,
		    	});
				setTimeout(function() 
				{
					$(\"#message\").dialog(\"close\")
				}, 2500 );
		    ";
		    
		    $return=array(
		    	"html"		=>$view,
		    	"message"	=>$message,
		    	"js"		=>$jquery		    	
		    );
		    
			return $return;
		}    

	}  	
?>



