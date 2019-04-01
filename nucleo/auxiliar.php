<?php
	include('basededatos.php');
	
	class auxiliar extends basededatos 
	{   
		##############################################################################	
		##  PROPIEDADES
		##############################################################################
		var $request			=array();	# este arrat recibe las variables del POST		
		var $sys_true			=array(1,"1","true", "si");
		var $sys_import			=array(
									"type"		=>"replace",
									"fields"	=>",",
									"enclosed"	=>"\"",
									"lines"		=>"\\n",
									"ignore"	=>"1",
								);
		var $sys_false		    =array(0,"0","false", "no");
		var $sys_print		    =array("print_report","print_excel", "print_pdf");
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
		var $sys_memory			=""; 
		
		var $__PRINT			="";
		var $__PRINT_OPTION		=array();
		var $__PRINT_JS			="";
		
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
    	#/*
    	public function __FOLIOS($option)
    	{								
			
			$sql    	="
				SELECT * FROM configuracion 
				WHERE 1=1 
					AND variable='{$option["variable"]}' 
					AND subvariable='{$option["subvariable"]}' 
					AND tipo='{$option["tipo"]}' 
					AND subtipo='{$option["subtipo"]}' 
					AND objeto='{$option["objeto"]}' 
			";
			$datas   	= $this->__EXECUTE("$sql");
			
			if(count($datas)>0)
				$sql    	="
					UPDATE configuracion SET valor=valor+1						
					WHERE 1=1 
						AND variable='{$option["variable"]}' 
						AND subvariable='{$option["subvariable"]}' 
						AND tipo='{$option["tipo"]}' 
						AND subtipo='{$option["subtipo"]}' 
						AND objeto='{$option["objeto"]}' 
				";
			else	
				$sql    	="
					INSERT INTO configuracion SET 
						valor=1,					 
						variable='{$option["variable"]}', 
						subvariable='{$option["subvariable"]}' ,
						tipo='{$option["tipo"]}' ,
						subtipo='{$option["subtipo"]}' ,
						objeto='{$option["objeto"]}' 
				";
				
			$datas   	= $this->__EXECUTE("$sql");

			$sql    	="
				SELECT * FROM configuracion 
				WHERE 1=1 
					AND variable='{$option["variable"]}' 
					AND subvariable='{$option["subvariable"]}' 
					AND tipo='{$option["tipo"]}' 
					AND subtipo='{$option["subtipo"]}' 
					AND objeto='{$option["objeto"]}' 
			";
			$datas   	= $this->__EXECUTE("$sql");
			
			return $datas[0]["valor"];		    	
    	}
    	#*/
		public function __FIND_FIELDS($id=NULL)
		{
		 	# ASIGNA EL ROW CON EL $id enviado
		 	# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields
				if(isset($this->sys_fields) AND is_array($this->sys_fields))
				{
					foreach($this->sys_fields as $field =>$value)
					{					
						if(isset($value["relation"]))
						{														
							if($value["relation"]=="one2many")
							{
								$eval="
									$"."option=array(\"name\"=>\"$field"."_obj\");
									$"."this->$field"."_obj			=new {$value["class_name"]}($"."option);
								";
								if(@eval($eval)===false)	
									echo "$eval"; #$eval; ---------------------------								        			
							}		
							if($value["relation"]=="many2one")
							{
								
								if(@$this->request["sys_action_" . $this->sys_object ]=="__clean_session")
									unset($_SESSION["SAVE"][$this->sys_object]);			
								#if(@$this->request["sys_action_" . $this->sys_object ]=="__SAVE")
								#	unset($_SESSION["SAVE"][$this->sys_object][$field]);			
								
								
								if($this->sys_section!="write")
								{
									#$this->__PRINT_R($this->request);
									
									#unset($_SESSION["SAVE"][$this->sys_object]);			
									#$this->__PRINT_R($_SESSION["SAVE"]);	
								}															
							}			        									
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
						
						#$this->__PRINT_R($datas);
						
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
											$"."option[\"where\"]=array(\"{$value["class_field_m"]}='{$datas[0][$value["class_field_o"]]}'\");
											$"."$field=$"."this->$field"."_obj->__BROWSE($"."option);
											$"."this->sys_fields[\"$field\"][\"values\"]=\"\";
											$"."this->sys_fields[\"$field\"][\"values\"]=$"."$field"."[\"data\"];
										";										
										if(@eval($eval)===false)	
											$this->__PRINT_R("$eval"); #$eval; ---------------------------								        			
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
			$words["system_ophp1"]					="";
			$words["system_ophp1"]					.="QVVPIDk5MDY0N";
			$words["system_ophp3"]					="";
			if(isset($this->__JS))
				$words["system_js"]     			.=$this->__JS;		
			$words["system_ophp1"]					.="jE2IDo6IElTQy";		
			if(@$this->sys_vpath==$this->sys_object."/" AND @$this->sys_action=="__SAVE" AND ($this->sys_section=="create" OR $this->sys_section=="write"))				
			{
		        $words["system_message"]    		=@$this->__SAVE_MESSAGE;
		        $words["system_js"]     			.=@$this->__SAVE_JS;		        
		        
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
					    $words["sys_page"]           	=@$this->request["sys_page"];
					}
			    }
			    else
			    {
			    	$_SESSION["company"]			=array("razonSocial");
			    }	
            }
			$words["system_ophp1"]					.="BFZHVhcmRvIFZ";			
			if(!isset($words["system_submenu2"]))  	$words["system_submenu2"]		="";
			if(!isset($words["html_head_css"]))  	$words["html_head_css"]			="";			
			$words["system_ophp2"]					="Q3JlYXRlZCBieSBFVklHUkE=";
			if(!isset($words["sys_historico"]))  	////////// HISTORICO 
			{
				if($this->__NIVEL_SESION("=11")==true)	 // NIVEL ADMINISTRADOR 			
				{
					if(@$this->sys_primary_id!="")
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
						$words["sys_historico"]			="										
										${reporte["html"]}
						";
					}		
				}	
			}
			$words["system_ophp1"]					.="pemNhaW5vIEdy";
			$words["system_ophp1"]					.="YW5hZG9z";						
			
			#if(!isset($this->words["sys_asunto"]))					$this->words["sys_asunto"]				="";
			
			$words=array_merge($this->words,$words);
			$template                   			=$this->__REPLACE($template,$words); 			
			if(@$this->request["sys_action"]=="print_pdf")
		    {
					
				
				if(!isset($words["sys_titulo"]))						$words["sys_titulo"]					=$this->words["module_title"];
				if(!isset($words["sys_subtitulo"]))						$words["sys_subtitulo"]					=$this->words["module_subtitle"];
				if(!isset($words["sys_asunto"]))						$words["sys_asunto"]					="";
				if(!isset($words["sys_pie"]))							$words["sys_pie"]						="";
				
				
				
				if(isset($_SESSION["pdf"]["sys_titulo"]))				$words["sys_titulo"]					=$_SESSION["pdf"]["sys_titulo"];
				if(isset($_SESSION["pdf"]["sys_subtitulo"]))			$words["sys_subtitulo"]					=$_SESSION["pdf"]["sys_subtitulo"];
				
		    	if(!isset($_SESSION["pdf"]))							$_SESSION["pdf"]	=array();		    					
				if(!isset($_SESSION["pdf"]["title"]))					$_SESSION["pdf"]["title"]					=$this->words["module_title"];
				if(!isset($_SESSION["pdf"]["subject"]))					$_SESSION["pdf"]["subject"]					=$this->words["html_head_title"];
				if(!isset($_SESSION["pdf"]["template"]))				
				{	
					$_SESSION["pdf"]["template"]				=$template;
					
					
					$words										=array_merge(array("sys_modulo" => $template),$words);					
					@$template									=$this->__TEMPLATE("sitio_web/html/PDF_FORMATO_IMSS");														
					$template_lab              					=$this->__REPLACE($template,$words); 			
					
					$_SESSION["pdf"]["template"]				=$template_lab;
					
				}
				if(!isset($_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]))	$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]	="P";   	# (P=portrait, L=landscape)
				if(!isset($_SESSION["pdf"]["PDF_UNIT"]))				$_SESSION["pdf"]["PDF_UNIT"]				="mm";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_PAGE_FORMAT"]))			$_SESSION["pdf"]["PDF_PAGE_FORMAT"]			="A4";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO"]))			$_SESSION["pdf"]["PDF_HEADER_LOGO"]			="tcpdf_logo.jpg";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]))	$_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]	=20;   	
				if(!isset($_SESSION["pdf"]["PDF_MARGIN_TOP"]))			$_SESSION["pdf"]["PDF_MARGIN_TOP"]			=50;   	
				
				
				if(!isset($_SESSION["pdf"]["PDF_system_ophp1"]))		$_SESSION["pdf"]["PDF_system_ophp1"]		=$words["system_ophp1"];   	
				
				if(!isset($_SESSION["pdf"]["save_name"]))				$_SESSION["pdf"]["save_name"]				=$_SESSION["pdf"]["subject"].".pdf";
				if($_SESSION["pdf"]["save_name"]=="")					$_SESSION["pdf"]["save_name"]				=$_SESSION["pdf"]["title"].".pdf";			
				$url 				= 'nucleo/tcpdf/crear_pdf.php';				
				$path				.="../$url";				
				header('Location:'.$path);		
				exit;
			}			
			echo $template;	
			$this->__PRINT();		
			$this->__PRINT_JS();
    	}
        ##############################################################################
		public function __PRINT_JS()
		{  
			echo "
				<script>
					{$this->__PRINT_JS}
				</script>
			";
		}		
        ##############################################################################
		public function __REPORT_TITLES($option)
		{  
			
			#$this->__PRINT_R($option);
			$sys_order	=$option["sys_order"];
			$sys_torder	=$option["sys_torder"];
			$font		=$option["font"];
			$name		=$option["name"];
			
		

			$iorder									="";			
			$title									=@$this->sys_fields[$font]["title"];
			
        	if(isset($this->sys_fields_l18n) AND is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$font"]))	
        	{			        	
        		$title								=$this->sys_fields_l18n["$font"];
        	}
						
			if($sys_order==@$this->request["sys_order_$name"])
			{
			     if($sys_torder=="ASC") 			$iorder 						="<font class=\"ui-icon ui-icon-caret-1-n\"></font>";
			     else                   			$iorder 						="<font class=\"ui-icon ui-icon-caret-1-s\"></font>";
			}

			$base="";

		    $sys_action     						=@$this->request["sys_action"];		   

			if(@$this->request["sys_action"]=="print_excel")
		    {
				return "
					<div name=\"title_$name\" style=\"height:25px;\">
							<b><font class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">$title</font></b>
					</div>
				";
			}
			else if(@$option["option"]=="pdf")
		    {
				#$this->__PRINT_R(	$this->request["sys_action"]);
				return "					
						<font class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">$title</font>					
				";
			}			
			else
			{
				#$this->__PRINT_R($title);
				#<div class=\"report_title_action report_title_inactive\">	
				return "
					<div name=\"title_$name\">
						<div class=\"report_title_action\">
							<table width=\"100%\" class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">
								<tr>
									<td height=\"40\"><b><font>$title</font></b></td> 
									<td>$iorder</td>
								</tr>
							</table>
						</div>
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
			            AND parent='$sys_menu'
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
								<font style=\"padding-left:5px; color:#006857; font-size:13; font-weight:bold;\">
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
					        AND u.id='{$_SESSION["user"]["id"]}'
					        AND parent='{$data_submenu["id"]}'
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
					#<div class=\"option d_none\"  active=\"{$data_submenu["name"]}\">
					$submenu_html	="					
						$submenu_html
						<div class=\"option\"  active=\"{$data_submenu["name"]}\">
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
						
			#$this->__PRINT_R($_REQUEST);
			foreach($_REQUEST as $campo =>$valor)
			{
				#if(!($valor=="" OR $valor=="undefined"))
				{					
					#$this->__PRINT_R($campo . " = " . $valor);
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
					#echo "$eval"; #$eval; ---------------------------					
				    if(eval($eval)===false)	
						echo "$eval"; #$eval; ---------------------------					
					#else	   	echo "$eval"; #$eval; ---------------------------					
				}	
			}
			if(is_array(@$this->sys_fields))
			{
				foreach(@$this->sys_fields as $campo =>$valor)
				{
					if($this->sys_fields[$campo]["type"]=="checkbox" and @$this->sys_fields[$campo]["value"]=="")
					{					
						$eval="
							$"."this->sys_fields[\"$campo\"][\"value\"]=\"0\";
							$"."this->$campo=\"0\";
							$"."this->request[\"$campo\"]=\"0\";
						";
						if(eval($eval)===false)	
							echo ""; #$eval; ---------------------------					
					}
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
				$template="";	
				$view="{system_template}";
				## Funciona con detalles
				#/*
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment;filename=\"{$words["module_title"]}.xls\"");
				header("Cache-Control: max-age=0");		    
				#*/
				
				/*
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment;filename=\"{$words["module_title"]}.xlsx\"");
				header("Cache-Control: max-age=0");		    
				*/
				
				#header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				#header("Content-Disposition: attachment;filename=\"{$words["module_title"]}.xlsx\"");
				
				
				
				////////
				/*
				header('Content-type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=\"{$words["module_title"]}.xls\"");
				header("Pragma: no-cache");
				header("Expires: 0");
				#*/
				
				
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
			
			if(!isset($words["sys_pie"]))	$words["sys_pie"]="";
			
		    $words									=array_merge($array,$words);
			
			if(!isset($this->words["sys_pie"]))	$this->words["sys_pie"]="";
			
			#$this->__PRINT_R($words);
		    
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
		    		$return 						= @file_get_contents($archivo);		    
	    		elseif(file_exists("../".$archivo))			    			
		    		$return 						= @file_get_contents("../".$archivo);		    		    		
	    		elseif(file_exists("../../".$archivo))			    			
		    		$return 						= @file_get_contents("../../".$archivo);		    		    		
	    		elseif(file_exists("../../../".$archivo))			    			
		    		$return 						= @file_get_contents("../../../".$archivo);		    		    		
	    		elseif(file_exists("../../../../".$archivo))			    			
		    		$return 						= @file_get_contents("../../../../".$archivo);		    		    				    		
		    	else	
		    		$return							="<br>NO EXISTE EL ARCHIVO: ".$archivo;
								
				#__TEMPLATE
				if(in_array(@$this->request["sys_action"],$this->sys_print))
				{	
									
					$archivo = $form.'_pdf.html';
					if(file_exists($archivo))			    			
						$return 						= @file_get_contents($archivo);		    
					elseif(file_exists("../".$archivo))			    			
						$return 						= @file_get_contents("../".$archivo);		    		    		
					elseif(file_exists("../../".$archivo))			    			
						$return 						= @file_get_contents("../../".$archivo);		    		    		
					elseif(file_exists("../../../".$archivo))			    			
						$return 						= @file_get_contents("../../../".$archivo);		    		    		
					elseif(file_exists("../../../../".$archivo))			    			
						$return 						= @file_get_contents("../../../../".$archivo);		    		    				    								
					
					$return.="<br>aaa";
				}		
		    }	
		    else	$return							="";		    		
		    return $return;
		}		
		function __TEMPLATE2($form=NULL)
		{
			$return=$this->__TEMPLATE($form);
			$return.="<br><br><br><br><br>";
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
			
					#if(substr($word, 0,11)=="system_ophp")
			#$this->__PRINT_R(substr("system_ophp1", 0,11));
			
			if(is_array($words))
			{
				$str								=$this->__REPLACE_aux($str,$words);
				$words								=array_merge($this->words,$words);
				$return								=$this->__REPLACE_aux($str,$words);
			}	
			else
				$return								="ERROR:: La funcion __REPLACE necesita un array para remplazar";
			return $return;
		} 		
		public function __REPLACE_aux($str,$words)
		{  				
			$return								=$str;
			foreach($words as $word=>$replace)
			{
				if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$word"]))	
					$replace					=$this->sys_view_l18n["$word"];
				if(is_array($replace))	$replace="";											
				if(substr($word, 0,11)=="system_ophp")
					$replace=base64_decode($replace);				
				$return							=str_replace("{".$word."}", $replace, $return);     	    	
			}				
			return $return;
		} 			
		##############################################################################
		public function __PRE_SAVE()
    	{
			# ENVIA UN ARRAY AL METODO SAVE
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields

			$fields	=$this->__FIELDS();		
    		#$this->__PRINT_R($fields);						
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
			
			#$this->__PRINT_R($datas);
			
			$return		=array();
    		foreach($datas as $campo=>$valor)
    		{
    			#if(isset($valor["value"]) and $valor["value"]!="")
				if(isset($valor["relation"]) AND $valor["relation"]=="many2one")
				{	
					$return[$campo]=$_SESSION["SAVE"][$this->sys_object][$campo]["data"];
					#$this->__PRINT_R($_SESSION["SAVE"][$this->sys_object]);
				}
				else				
				{					
					if(isset($valor["request"]))
					{
						$return[$campo]=$valor["request"];
					}					
				}			
    		}    		
			
			#$this->__PRINT_R($return);
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
					else 
						echo json_encode(array("mensaje"=>"<br> > Error al cargar ","name"=>"","path"=>""));
				}	
			}
			if(@$this->request["seccion_import"]=="preparar_tabla")
			{
				$option_conf=array();					
				$option_conf["open"]	=1;
				
				#$comando_sql 			="call import_csv('{$this->sys_table}','$name')";
				#$this->__EXECUTE($comando_sql,$option_conf);					
				
				if($this->sys_import["type"]=="restore_table")
				{
					$comando_sql 			="TRUNCATE TABLE {$this->sys_table};";					
				}
				else
				{	
					if($this->sys_import["type"]=="compare_table")
					{
						$comando_sql 			="DROP TABLE IF EXISTS t_{$this->sys_table};";
						$this->__EXECUTE($comando_sql,$option_conf);					
						$comando_sql 			="CREATE TABLE t_{$this->sys_table} LIKE {$this->sys_table};";						
					}					
				}
				$this->__EXECUTE($comando_sql,$option_conf);					
				echo "<br> > Preparando base de datos temporal <b>{$this->sys_table}</b>";					

			}
			if(@$this->request["seccion_import"]=="cargar_tabla")
			{
				$table="t_{$this->sys_table}";	
				
								
				if($this->sys_import["type"]=="compare_table")
				{
					$table="t_{$this->sys_table}";					
				}	
				else
				{
					$table="{$this->sys_table}";					
				}			
				
				/*
				var $sys_import			=array(
									"fields"=>",",
									"enclosed", "\"",
									"lines", "\\n",
									"ignore", "1",
								);				
				*/
				$option_conf=array();
				$comando_sql ="
					LOAD DATA INFILE 'C:/xampp/mysql/data/mysql-files/{$this->request["name"]}' 
					INTO TABLE $table
					FIELDS TERMINATED BY '{$this->sys_import["fields"]}' 
					ENCLOSED BY '{$this->sys_import["enclosed"]}'
					LINES TERMINATED BY '{$this->sys_import["lines"]}'
					IGNORE {$this->sys_import["ignore"]} ROWS;					
				";				
				#echo $comando_sql;
				$this->__EXECUTE($comando_sql);
				echo "<br> > Cargando datos a tabla temporal <b>$table</b>
					<div id=\"import_pendiente\"></div>
					<div id=\"eliminar\"></div>
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
							@$to	="CONCAT($to,torg.$field)";
							@$tt	="CONCAT($tt,tt.$field)";
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
				$upd=0;
				$add=0;
				$maximo=83;
				$script="";						
				$pendientes=0;			
				if(isset($clave))
				{	
					$comando_sql ="
						select 
							CASE 
								when $to is NULL then 'add' 
								when $tt != $to then 'upd'     
							END as torg_status,
							tt.*
						from t_{$this->sys_table} tt left join {$this->sys_table} torg on tt.$clave=torg.$clave
						WHERE
							$tt <> $to
							OR
							$to is NULL							
							
						ORDER BY torg_status							
					";
					$datos_analizados	=$this->__EXECUTE($comando_sql);
					$pendientes			=count($datos_analizados);			
				}	
				#$this->__PRINT_R($comando_sql);
				
				if($pendientes>0)
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
							actualizar.url		='../sitio_web/ajax/general.php&seccion_import=actualizando_datos&sys_name={$this->sys_name}&date=".date("YmdHis")."';										
							actualizar.success	=function (response) 
							{
								$(\"#import_pendiente\").html(response);												
							};											
							$.ajax(actualizar);								
						</script>						
					";
			
					if($pendientes<$maximo)	$bloque	=$datos_analizados;
					else					$bloque =array_slice($datos_analizados, 0, $maximo-1);					

					foreach($bloque as $data)
					{
						$id="";							
						foreach($data as $field=>$value)
						{							
							if(@$field==$clave) 	$id							=$value;

							if(@$data["torg_status"]=="upd" AND @in_array(@$this->sys_fields["$field"]["import"],array("01","11")))
							{																	
								$fields["$field"]	="$value";
							}	
						}
						if(@$data["torg_status"]=="add")
						{
							@$add++;
							$this->sys_primary_field	="";
							$this->sys_primary_id		="";
						
							unset($data["torg_status"]);
							$fields=$data;
						}						
						if(@$data["torg_status"]=="upd")
						{
							@$upd++;
							$this->sys_primary_field	=$clave;
							$this->sys_primary_id		=$id;																				
						}								
						if(is_array(@$fields))
						{								
							$this->__SAVE($fields);
						}	
						if($id!="")
						{	
							$comando_sql="DELETE FROM t_{$this->sys_table} WHERE $clave='$id'";
							$this->__EXECUTE($comando_sql);								
						}	
					}
					
					echo "	
						<br>
						$pendientes :: Registros pendientes<br> 
						$script
					";
				}
				else
				{							
					echo "
						<script>	
							var datos={		
								type: 'POST',													
								async: true,
								cache: false,
								contentType: false,
								enctype: 'multipart/form-data',
								processData: false,
							};
							var eliminar=datos;
							eliminar.url		='../sitio_web/ajax/general.php&seccion_import=eliminar_tabla&sys_name={$this->sys_name}&date=".date("YmdHis")."';										
							eliminar.success	=function (response) 
							{
								$(\"#eliminar\").html(response);	
							};											
							$.ajax(eliminar);								
						</script>						
					";
				}							
				
			}			
			if(@$this->request["seccion_import"]=="eliminar_tabla")
			{
				$comando_sql ="truncate t_{$this->sys_table}";
				$this->__EXECUTE($comando_sql);
				echo "<br><br> > Eliminando tabla temporal <b>{$this->sys_table}</b>
						<script>								
							setTimeout(function()
							{  				
									$(\"form\").submit();									
							},500);								
						</script>				
				";
			}
		}


    	##############################################################################    
		public function __VARS()
		{	
			# RECOGE LAS VARIABLES ENVIADAS DESDE EL FORM, 
			# ASIGNANDO UNICAMENTE LAS DECLARADAS EN EL MODELO 
			# $this->sys_fields
			#$this->__PRINT_R($this->sys_fields);
			foreach($this->sys_fields as $campo=>$valor)
			{
				if(!isset($this->request["$campo"]))		$this->request["$campo"]="";
				else
				{	
					$this->sys_fields["$campo"]["value"]	=$this->request["$campo"];
					$this->sys_fields["$campo"]["request"]	=$this->request["$campo"];
				}	
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
		public function __VALOR($valor=NULL)
		{				    
			$style="";
			if(is_array($valor["style"]))
			{
				foreach($valor["style"] as $attr => $val_attr)
				{
					if(@is_array($val_attr))
					{						
						$eval_attr="";	
						foreach($val_attr as $field_attr => $eval_field)
						{		
								
							if($attr=="background-color")	$eval_attr.="if({$eval_field})	$"."style.=\"background-color:$field_attr;\";";
							elseif($attr=="border")			$eval_attr.="if({$eval_field})	$"."style.=\"border: 1px solid $field_attr; \";";
							elseif($attr=="font-size")		$eval_attr.="if({$eval_field})	$"."style.=\"font-size: $field_attr; \";";
							else							$eval_attr.="if({$eval_field})	$"."style.=\"font-size: $field_attr; \";";
							
							#$eval_attr.="$"."this->__PRINT_R(\"$eval_field\");
						}
					}
				}	
				
				eval($eval_attr);
			}
			if($this->sys_section=="create" AND is_array(@$valor["create"]))	$style	.=$this->__VALOR($valor["create"]);
			if($this->sys_section=="write" AND is_array(@$valor["write"]))		$style	.=$this->__VALOR($valor["write"]);

			return $style;		
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
			        if(!isset($valor["attr"]))	   		$valor["attr"]			="";
					if(!isset($valor["style"]))	   		$valor["style"]			="";
					
					if($this->sys_section=="create")	$valor["value"]			="";

					$class="$campo ";
					$style="style=\"" . $this->__VALOR($valor) . "\""; 				
								        
			        if(!is_array($valor["value"]))
			        {
			        	$attr="";
			        	if(is_array($valor["attr"]))
			        	{	
			        		#$this->__PRINT_R($valor["attr"]);
			        		foreach($valor["attr"] as $attr_field => $attr_value)
			        		{
								if($attr_value=="required")		$class.=" required ";
								else	
									$attr.=" $attr_field='$attr_value'";
			        		}			        	
			        	}			        				        	
						$titulo					="&nbsp;";		
					    if(in_array($valor["showTitle"],$this->sys_true))	
					    {			        
					    	if(is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$campo"]))	
					    	{			        	
					    		$valor["title"]		=$this->sys_fields_l18n["$campo"];
					    	}	

							if($valor["type"]=="txt")	$titulo					="{$valor["title"]}";			        	
							else						$titulo					="<font id=\"$campo\" style=\"color:gray;\">{$valor["title"]} </font>";
					    	
					    }	
					    

					    
					    if($valor["type"]=="input" OR $valor["type"]=="primary key")	
					    {			        						        
					        $words["$campo"]  ="<input id=\"$campo\" $style autocomplete=\"off\" type=\"text\" $attr name=\"$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} {$this->sys_object} $class\"><br>$titulo";
					    } 
					    if($valor["type"]=="date")	
					    {
							#$this->__PRINT_R($this->sys_fields[$campo]);			
					        #$words["$campo"]  ="$titulo<input id=\"$campo\" type=\"text\" name=\"$campo\" value=\"{$valor["value"]}\" placeholder=\"{$valor["holder"]}\" class=\"formulario\" >";
					        $words["$campo"]  ="
					        	<input id=\"$campo\" $style type=\"text\" name=\"$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} $class\"><br>$titulo
			        			<script>
									$(\"input#$campo".".{$this->sys_name}\").datepicker({dateFormat:\"yy-mm-dd\"});
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
					        	<input id=\"$campo\" $style type=\"text\" name=\"$campo\"  $attr class=\"formulario {$this->sys_name} $class\"><br>$titulo
			        			<script>
									$(\"input#$campo".".{$this->sys_name}\").multiDatesPicker(
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
					        $checked="";
					        if($valor["value"]==1) $checked="checked";
							
					    	$words["$campo"]  = 
					        "<div class=\"check-2\">
		    					<input type=\"checkbox\" id=\"$campo\" $attr $checked value=\"1\" name=\"$campo\" />
		    					<label for=\"$campo\">".""."</label>
							</div>$titulo
							<br>
							";
					    }      
					    if($valor["type"]=="file")	
					    {
					        $words["$campo"]  ="$titulo<input id=\"$campo\" name=\"$campo\" type=\"file\" class=\"formulario\">";
					        $words["$campo"]  ="<input id=\"$campo\" $attr name=\"$campo\" type=\"file\" class=\"formulario {$this->sys_name} $class\" ><br>$titulo";
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
							if($attr=="")	$attr="style=\"height:150px;\"";
					        $words["$campo"]  ="<textarea id=\"$campo\" name=\"$campo\" $attr class=\"formulario {$this->sys_name} $class\">{$valor["value"]}</textarea><br>$titulo";
					    } 			           
					    if($valor["type"]=="texthtml")	
					    {
							#new nicEditor({fullPanel : false}).panelInstance(\"textarea#$campo".".{$this->sys_name}\");
							#if($attr=="")	$attr="style=\"height:100%; width:100%;\"";
							/*
					        $words["$campo"]  ="<div id=\"$campo\" name=\"$campo\" $attr class=\"{$this->sys_name} $class\">{$valor["value"]}</div><br>$titulo
								<input id=\"$campo\" name=\"$campo\" value=\"{$valor["value"]}\"  class=\"formulario {$this->sys_name}\" type=\"hidden\">
			        			<script>
									var myEditor = new nicEditor({fullPanel : false}).panelInstance(\"$campo\");
									
									myEditor.addEvent('add', function() {
										alert( myEditor.instanceById(\"$campo\").getContent() );
									});									
					        	</script>							
							";
							
							$words["$campo"]  ="<textarea id=\"$campo\" name=\"$campo\" $attr class=\"formulario {$this->sys_name} $class\">{$valor["value"]}</textarea><br>$titulo
								<script>
									CKEDITOR.replace( '#$campo' );
								</script>														
							";							
							*/
							$words["$campo"]  ="<textarea id=\"$campo\" name=\"$campo\" $attr class=\"formulario {$this->sys_name} $class\">{$valor["value"]}</textarea><br>$titulo
								<script>
									CKEDITOR.replace( '$campo' );									
								</script>														
							";							
							
					    } 			           

					    if($valor["type"]=="password")	
					    {					        
					        $words["$campo"]  ="<input type=\"password\" $style id=\"$campo\" $attr name=\"$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} $class\"><br>$titulo";
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
						        $words["$campo"]  ="<select id=\"$campo\" $style name=\"$campo\"  $attr class=\"formulario {$this->sys_name} $class\"\">
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
							
							
							
					    	if(isset($this->sys_fields["$campo"]["class_field_l"]))
					    	{
								#$this->__PRINT_R($this->sys_fields["$campo"]);	
					    		if(isset($this->sys_fields["$campo"]["values"]) AND count($this->sys_fields["$campo"]["values"])>0)
					    		{
					    			$label=$this->sys_fields["$campo"]["values"][0][$this->sys_fields["$campo"]["class_field_l"]];									
					    		}
					    	}
							
							if(isset($valor["vars"]))	$vars	=$valor["vars"];
							else						$vars	="";
					    
					        $words["$campo"]  ="					        	
					        	<input id=\"auto_$campo\" $style type=\"text\"  name=\"auto_$campo\"  $attr value=\"$label\" class=\"formulario {$this->sys_name} $class\"><br>$titulo
					        	<input id=\"$campo\" name=\"$campo\" value=\"{$valor["value"]}\"  class=\"formulario {$this->sys_name}\" type=\"hidden\">
					        	<script type=\"\">
									
									$(\"input#auto_$campo".".{$this->sys_name}\").autocomplete(
									{		
										source:\"{$valor["source"]}$vars\",
										dataType: \"jsonp\",
										select: function( event, ui ) // CUANDO SE SELECCIONA LA OPCION REALIZA LO SIGUIENTE
										{												
											if(typeof auto_$campo === 'function') 								
											{																
												auto_$campo(ui);
											}									
											else
											{
											
												$(\"input#$campo".".{$this->sys_name}\").val(ui.item.clave);					
												$(\"input#auto_$campo".".{$this->sys_name}\").val(ui.item.label);
											}
										}				
									});				            	
					        	</script>
					        ";
					    }  
						#/*
					    if($valor["type"]=="form")	
					    {					    
							if(isset($valor["relation"]) AND $valor["relation"]=="many2one")
							{								
								if(!isset($valor["class_template"]))		$valor["class_template"]="many2one_standar";					
								
								$campo_many					=$valor["class_field_o"];
								$value_many					=$this->sys_fields["$campo_many"]["value"];								
								
								
								
								if($this->sys_section=="create" AND $this->request["sys_action_".$this->sys_object] == "__SAVE")
									$value_many=0;	
								
								$option=array(
									"class_one"				=>$this->sys_name,
									"class_one_id"			=>$value_many,
								
									"class_field"			=>$campo,
									"class_field_id"		=>"",
									"class_field_value"		=>$valor,
									"words"					=>$words,
									"view"					=>"html",
									
								);								
								#$this->__PRINT_R($option);
								$words						=$this->__MANY2ONE($option);
								#$this->__PRINT_R($option);
							}
						}	
						#*/
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
								
								if(@eval($eval)===false)	
									echo ""; #$eval; ---------------------------								        			
							}			        		
					    	#$words["$campo"]  =$data["html"];
					    }					    
					    if($valor["type"]=="hidden")	
					    {
					        $words["$campo"]  ="<input type=\"hidden\" id=\"$campo\" name=\"$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name}\">";
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
		public function __MANY2ONE($option)		
		{
			#unset($_SESSION["SAVE"]["personal_calculo"]	);	
			#$_SESSION["SAVE"]=array();
			
			#$this->__PRINT_R($option);	
			$class_id			=@$option["class_id"];
			$class_one			=$option["class_one"];
			$class_one_id		=$option["class_one_id"];
			
			$campo				=$option["class_field"];
			$class_field_id		=$option["class_field_id"];
			$valor				=$option["class_field_value"];
			
			$words				=$option["words"];                                                                                                                                                                                                                                                          
			$index				=$option["view"];
			
						
			if(isset($option["json"]))
			{
				$json	=$option["json"];						
			}
						
			$eval="
				$"."option_$campo		=array(				
					\"memory\"			=>\"$campo\",
					\"class_one\"		=>\"$class_one\",
				);
			
				$"."this->$campo"."_obj									=new {$valor["class_name"]}($"."option_$campo);
								
				if(isset($"."json))
				{								
					$"."sys_primary_field	=$"."this->$campo"."_obj->sys_primary_field;
			
					if(isset($"."class_id) AND $"."class_id>0)
						$"."json[\"row\"][\"$"."sys_primary_field\"]	=$"."class_id;
					
					#$"."this->__PRINT_R($"."json);
					$"."this->$campo"."_obj->__SAVE($"."json);
				}
				
				$"."view   												=$"."this->__TEMPLATE(\"sitio_web/html/" . $valor["class_template"]. "\");									
				
				$"."this->$campo"."_obj->words[\"many2one_form\"]		=$"."this->$campo"."_obj->__VIEW_CREATE($"."this->$campo"."_obj->sys_module . \"html/create\");	
				$"."this->$campo"."_obj->words							=$"."this->$campo"."_obj->__INPUT($"."this->$campo"."_obj->words,$"."this->$campo"."_obj->sys_fields);    
												
				$"."this->$campo"."_obj->words[\"many2one_report_id\"]	=$"."campo;
								
				if(!isset($"."words[\"html_head_js\"]))								
					$"."words[\"html_head_js\"] 						= \"\";

				if(isset($"."words[\"html_head_js\"]) AND isset($"."this->$campo"."_obj->words[\"html_head_js\"]))
					$"."words[\"html_head_js\"] 						.= $"."this->$campo"."_obj->words[\"html_head_js\"];
								
				$"."option_report										=array();				
				
				$"."option_report[\"where\"]							=array(
					\"{$valor["class_field_m"]}='$class_one_id'\"
				);
				
				$"."option_report[\"template_title\"]	                = $"."this->$campo"."_obj->sys_module . \"html/report_title\";
				$"."option_report[\"template_body\"]	                = $"."this->$campo"."_obj->sys_module . \"html/report_body\";
				$"."option_report[\"template_create\"]	                = $"."this->$campo"."_obj->sys_module . \"html/create\";
				$"."option_report[\"template_option\"]	                = $"."option;
				
				$"."option_report[\"name\"]	                			= '$campo';
				
				
				$"."report_procedure									=$"."this->$campo"."_obj->__VIEW_REPORT($"."option_report	);

				$"."this->$campo"."_obj->words[\"many2one_report\"]		=$"."report_procedure[$"."index];				
				$"."words[\"$campo\"]  									=$"."this->__REPLACE($"."view,$"."this->$campo"."_obj->words);									
			";				
			
			eval($eval);	
			
			return $words;
		}
    	##############################################################################    
		public function __REPORT_MANY2ONE_JS($data)
		{
			$js="";	
			foreach($data as $row)
			{
				$js.="var row=new Array();";
				foreach($row as $field=>$value)
				{
					$js.="
						row[\"$field\"]	=\"$value\";
					";
				}
			}
			
			
			$js="
				var object=\"". $this->sys_name ."\";
				if(many2one_data[object]==undefined)	many2one_data[object]=new Array();			
				$js
				many2one_data[object].push(row);	
			";
			return $js;
		}
    	##############################################################################    
		public function __INPUT_TYPE($type=NULL, $fields=NULL)
		{
			if(is_null($fields))
			{
				foreach($this->sys_fields as $field=>$value)
				{					
					if(!in_array(@$this->sys_fields[$field]["type"],array("hidden","textarea","","primary key")))											
					{	
						$this->sys_fields[$field]["type"]="input";			    						
						$this->sys_fields[$field]["attr"]=array("readonly"=>"readonly");			    					
					}
				}
			}				
			else
			{
				foreach($fields as $field)
					$this->sys_fields[$field]["attr"]=array("readonly"=>"readonly");			    
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
		
			$view2="";
			if(!in_array(@$this->request["sys_action"],$this->sys_print))
			{	
				$view2="
					<input id=\"sys_section_{$this->sys_name}\" system=\"yes\"  name=\"sys_section_{$this->sys_name}\" value=\"{$sys_section}\" type=\"hidden\">
					<input id=\"sys_action_{$this->sys_name}\" system=\"yes\" name=\"sys_action_{$this->sys_name}\" value=\"{$sys_action}\" type=\"hidden\">
					<input id=\"sys_id_{$this->sys_name}\" system=\"yes\" name=\"sys_id_{$this->sys_name}\" value=\"{$sys_id}\" type=\"hidden\">
				";		
				if(!isset($option["input"]))	$option["input"]="true";
				
			}
			$view.=$view2;
			
			if(isset($this->sys_memory) AND $this->sys_memory!="")
			{	
				
				$this->words["many2one_button"]="
					<font id=\"{$this->sys_name}\">ACEPTAR</font>				
					<font id=\"{$this->sys_name}\">CANCELAR</font>	<br>			<br>
					<script>
						$(\"font#{$this->sys_name}\")
							.button()
							.click(function(){						
								var options={
									\"object\":\"{$this->sys_name}\",
									\"class_one\":\"{$this->sys_object}\",
								}
								many2one_post(options);
							});						
					</script>					
				";		
		
			}			
			return $view;
		}    	
    	##############################################################################    
		public function __VIEW_CALENDAR($template,$data,$option=NULL)
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
			#$this->__PRINT_R(substr($template, -4,4));
			#$this->__PRINT_R($template);
			$view="";
			$class="even";

			if(is_null($option))	$option=array();	
			if(!array_key_exists("name",$option))   $option["name"]=$this->sys_name;
			
			if(is_array($data))
			{
			    foreach($data as $row_id => $row)			
			    {
					foreach(@$this->sys_fields as $field=>$fieldvalue)			
					{	
						
						if(@$fieldvalue["type"]!="autocomplete" AND @$fieldvalue["relation"]=="one2many")
						{
							if(isset($fieldvalue["class_field_o"]) AND isset($fieldvalue["class_field_l"]))
							{	
								$class_field_o			=$fieldvalue["class_field_o"];
								$class_field_m			=$fieldvalue["class_field_m"];
								$class_field_l			=$fieldvalue["class_field_l"];
								
								$row_class_field_m   	=$row["$class_field_m"];
								
								$eval="
									$"."obj_$field   				=new {$fieldvalue["class_name"]}();
									
									$"."option_$field=array(
										\"where\"=>array(
											\"$class_field_o='{$row_class_field_m}'\"
										)
									);									
									$"."data_$field					=$"."obj_$field"."->__BROWSE($"."option_$field);								
									$"."row[\"$class_field_l\"]		=$"."data_$field"."[\"data\"][0][\"$class_field_l\"];								
								";
								eval($eval);
							}
						}
					}
					#$this->__PRINT_R($row);
					
					if(is_array($row))
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
					}	
                    if($class=="odd")   
                    {
                    	$class="even";
                    	$style="background-color:#D5D5D5;";							
                    }	
                    else                
                    {
                    	$class="odd";
                    	$style="background-color:#E5E5E5;";							
                    }	
                    
                    $actions				=array();
                    $colors					=array();
                    if(substr(@$this->request["sys_action"],0,5)!="print")	              
	                    $actions["class"]		=$class;
	                else    
	                    $actions["style_tr"]	=$style;
                    
                    if(isset($this->sys_memory) AND $this->sys_memory!="")
					{
						$show	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=show&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-contact\"></font>";	
						$write	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=write&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-pencil\"></font>";
						$delete	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=delete&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-trash\"></font>";
						$check	="";
					}				
					else	
					{			
						$show	="<font data=\"&sys_section_{$this->sys_name}=show&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-contact\"></font>";
						$write	="<font data=\"&sys_section_{$this->sys_name}=write&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-pencil\"></font>";
						$delete	="<font data=\"&sys_section_{$this->sys_name}=delete&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\"  class=\"sys_report ui-icon ui-icon-trash\"></font>";
						$check	="<input type=\"checkbox\" id=\"{$option["name"]}\" name=\"{$option["name"]}[]\" height=\"20\" value=\"{id}\">";
					}	
                    
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
                    
					#if(is_array($row))			
						$row = array_merge($actions, $row);					
                    #if(is_array($row))			
						$row = array_merge($colors, $row);
                    
				    if(@$html_template=="" OR !isset($html_template))  
				    {
				    	$html_template  =$this->__TEMPLATE("$template");
				    	$html_template	=str_replace("<td>", "<td style=\"{style_td}\" >", $html_template);				    	
				    }	
					if(isset($option["template_separator"]))
					{
						$view_title_data	=$option["view_title_data"];	
						$view_title			=$view_title_data["view_title"];
						$view_title_pdf		=$view_title_data["view_title_pdf"];						
							
						if(!isset($template_separator))		$template_separator="";
												
						$separador=$option["template_separator"];						
						$row["template_separator"]="<b>{$row[$separador]}</b>";
						if($template_separator!=$row[$separador])
						{	
							#$this->__PRINT_R(substr($template, -4,4));
							if(substr($template, -4,4)=="_pdf")
							{
								$view.=$view_title_pdf;
							}
							else						
							{
								$view.=$view_title;	
							}					
							
						}
						$template_separator=$row[$separador];												
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
		public function __VIEW_TEMPLATE_TITLE($option)
		{			
			$return=array("view_title"=>"","view_title_pdf"=>"");	
			if(isset($option["template_title"]))    
			{
				$view_title     =$this->__TEMPLATE($option["template_title"]);					//  HTML DEL REPORTE
				$view_title		=str_replace("<td>", "<td class=\"title\">", $view_title);      // AGREGA la clase titulo
				
				$view_title_pdf =$this->__TEMPLATE($option["template_title"]."_pdf");					//  HTML DEL REPORTE
				$view_title_pdf	=str_replace("<td>", "<td class=\"title\">", $view_title_pdf);      // AGREGA la clase titulo
								
				if(isset($option["title"]))
				{
					$return["view_title"]	    =$this->__REPLACE($view_title,$option["title"]);
				}    		    	    
				if(isset($option["title_pdf"]))
				{
					$return["view_title_pdf"]   =$this->__REPLACE($view_title_pdf,$option["title_pdf"]);
				}    		    	    				
			} 
			return $return;
		} 			
		public function __VIEW_TEMPLATE_ASUNTO($option)
		{			
			$return="";	
			if(isset($option["template_asunto_pdf"]))    
			{
				$return =$this->__TEMPLATE($option["template_asunto_pdf"]);					//  HTML DEL REPORTE								
			} 
			return $return;
		} 			
		
		/*
		emma farias nuño
		*/
    	##############################################################################        
		public function __VIEW_REPORT($option)
		{
			
			if(isset($option["template_option"]))	$template_option		=$option["template_option"];
			
			#$this->__PRINT_R($option);
			$return=array();
		    $view_title="";
			if(isset($this->sys_memory) AND isset($template_option["class_field"]))
			{	
				$campo									=$template_option["class_field"];
				#unset($_SESSION["SAVE"][$this->class_one]);
				#$this->__PRINT_R($_SESSION["SAVE"][$this->class_one]);
				
				if(isset($_SESSION["SAVE"][@$this->class_one]["$campo"]) AND count($_SESSION["SAVE"][@$this->class_one]["$campo"])>0)
				{						
					$campo				=$template_option["class_field"];
					#$this->__PRINT_R(    $_SESSION["SAVE"][$this->class_one]["$campo"]);	
					$option["data"]		=@$_SESSION["SAVE"][@$this->class_one]["$campo"]["data"];
					$option["total"]	=count(@$_SESSION["SAVE"][$this->class_one]["$campo"]["data"]);				
					$option["inicio"]	=@$_SESSION["SAVE"][@$this->class_one]["$campo"]["inicio"];		
					$option["title"]	=@$_SESSION["SAVE"][@$this->class_one]["$campo"]["title"];				
				}
			}
		    if(is_array($option))
		    {
				$inicio=0;	
				if(isset($option["total"]) AND $option["total"]>=0)		$return["total"]	=$option["total"];
				else													$return["total"]	=0;
				if(isset($option["inicio"]) AND $option["inicio"]>0)	$inicio				=$option["inicio"];
				else													$inicio				=0;
				if(isset($option["fin"]) AND $option["fin"]>0)			$fin				=$option["fin"];
				else													$fin				=0;
		    	
		        $sys_order="";
		        $sys_torder="";
		    	if(!isset($option["name"]))    					$name		=@$this->sys_name;
		    	else											$name		=$option["name"];
				
				$this->sys_name=$name;		
		    	
		    	if(isset($this->request["sys_page_$name"]))		$sys_page	=$this->request["sys_page_$name"];
		    	else											$sys_page	=1;

		    	if(isset($this->request["sys_order_$name"]))	$sys_order	=$this->request["sys_order_$name"];
		    	
		    	if(isset($this->request["sys_torder_$name"]))	$sys_torder	=$this->request["sys_torder_$name"];
		    	
		    	if(isset($this->request["sys_row_$name"]))	    $sys_row	=$this->request["sys_row_$name"];
		    	else                                            $sys_row	=50;
				
				if($sys_row=="")								$sys_row	=50;

		    	$option["sys_page_$name"]           			=$sys_page;		        		        
				
		    	if(isset($option["data"]))          			$return["data"] =$option["data"];	
		    	else
		    	{			    		
		    	    $option["name"]                 			=$name;
		    	   
		    		$browse 									=$this->__BROWSE($option);		 

					if(isset($this->sys_memory) AND isset($template_option["class_field"]))
					{												
						
						$_SESSION["SAVE"][@$this->class_one]["$campo"]=$browse;;												
					}
					
					if(count($browse["data"])<=0)
					{							
						$browse["data"]=array();				
					}								
					
					##################################
					
		    		$return["data"]					= $browse["data"];
		    		$option["title"]				= @$browse["title"];
					$option["title_pdf"]			= @$browse["title_pdf"];
		    		
		    		if(isset($browse["total"]))		
		    		{
						$return["total"]				= $browse["total"];	
						
						$inicio				            = @$browse["inicio"] + 1;
						$aux_fin                        = @$inicio + @$sys_row -1;
						
						if($aux_fin<$return["total"])   $fin    =$aux_fin;
						else                            $fin    =$return["total"];
					}			    		
		    	}	

				#######################								
				$view_title_data						=$this->__VIEW_TEMPLATE_TITLE($option);			
				#$this->words["sys_asunto"]				=$this->__VIEW_TEMPLATE_ASUNTO($option);
				$this->words["sys_asunto"]				=$this->__TEMPLATE(@$option["template_asunto_pdf"]);
				$this->words["sys_pie"]					=$this->__TEMPLATE(@$option["template_pie_pdf"]);
				
				

				#$this->__PRINT_R($view_title_data);
				$view_title			=$view_title_data["view_title"];
				$view_title_pdf		=$view_title_data["view_title_pdf"];
								
		    	$view_create	="";
		    	$button_create	="";
				###########################
		    	if(isset($option["template_create"]) AND $option["template_create"] !="")
		    	{
					$this->words               	=	$this->__INPUT($this->words,$this->sys_fields);
		    
					$eval="
						if(isset($"."this->sys_id_{$this->sys_name}))
							$"."clave_id	=$"."this->sys_id_{$this->sys_name};
					";
					
					eval($eval);
			
		    		$view_create		=	$this->__REPLACE($this->__VIEW_CREATE($option["template_create"]),$this->words);
					$view_create="
            			<div id=\"create_$name\" title=\"Crear Resgistro\" class=\"report_search d_none\" style=\"width:100%; background-color:#373737;\">
	            			$view_create
	            			<script>
	            			</script>
            			</div>
					";		    	    
					$button_create="
						<td width=\"15\" align=\"center\">
							<font id=\"create_$name\" active=\"$name\" class=\"ui-button show_form\">Formulario</font>
						</td>	
					";					
		    	}    

		    	$view_search="";
		    	$button_search="";
				#######################
		    	if(isset($option["template_search"]) AND $option["template_search"] !="")    
		    	{		    		
		    		$this->words["module_body"]     =$this->__VIEW_CREATE($option["template_search"]);
		    		$this->words					=$this->__INPUT($this->words,$this->sys_fields); 


					$view_search					=$this->words["module_body"];
		    		$this->words["module_body"]		="";
		    		
		    	    $view_search     				=$this->__TEMPLATE($option["template_search"]);		    	    
		    	    $view_search					=str_replace("<td>", "<td class=\"title\">", $view_search);
		    	    		    	
					#__TEMPLATE
					if(!in_array(@$this->request["sys_action"],$this->sys_print))
					{	
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
		    	}    
                $view_body="";
				##############################
		    	if(isset($option["template_body"]))
		    	{    
		    	    $template       =$option["template_body"];
		    	    $option_kanban	=array();
		    	    if(isset($option["actions"]))	$option_kanban["actions"]	=$option["actions"];
		    	    if(isset($option["color"]))		$option_kanban["color"]		=$option["color"];
					if(isset($option["template_separator"]))		
					{	
						$option_kanban["template_separator"]		=$option["template_separator"];
						$option_kanban["view_title_data"]			=$view_title_data;
					}	
					
		    	    if(isset($option["name"]))		$option_kanban["name"]		=$name;

					if(isset($return["data_0"]))
					{
						$view_body		=$this->__VIEW_KANBAN2($template,$return["data_0"],$option_kanban);
						$view_body_pdf	=$this->__VIEW_KANBAN2($template."_pdf",$return["data_0"],$option_kanban);
						unset($return["data_0"]);
					}	
					else
					{	
						$view_body		=$this->__VIEW_KANBAN2($template,$return["data"],$option_kanban);
						$view_body_pdf	=$this->__VIEW_KANBAN2($template."_pdf",$return["data"],$option_kanban);
					}
					#$this->__PRINT_R($return);
					if($view_body_pdf=="")	$view_body_pdf=$view_body;
					
					if(isset($option["template_separator"])) $view_title_pdf="";	
					/*
					$return["pdf"]	="				
						
						<table width=\"100%\" border=\"1\" style=\"background-color:#fff; \">								
							$view_title_pdf
							$view_body_pdf
						</table>					
					";
					*/
		    	}    
                #if(isset($inicio) AND $return["total"]>0)
                {                	
                	if(@$this->request["sys_action"]=="print")	$view_head="";                	                
                	elseif(!in_array(@$this->request["sys_action"],$this->sys_print))
                	{	
						if(!isset($this->request["sys_filter_$name"]))	$this->request["sys_filter_$name"]="";
				
                		#<div id=\"report_$name\" style=\"height:35px; width:100%; \" class=\"ui-widget-header\">
						$calendar="";
						if(isset($option["date"]))
						{
							$name_calendar ="sys_filter_{$name}_{$option["date"]}";
							$name_calendar_filter ="sys_calendar_{$name}_{$option["date"]}";
							$calendar="
								<td width=\"100\">									
									<input id=\"$name_calendar_filter\"  type=\"text\" name=\"$name_calendar_filter\"  system=\"yes\" value=\"\" class=\"formulario {$this->sys_name}\" placeholder=\"Filtrar fecha\">
									<script>
										$(\"input#$name_calendar_filter\").datepicker(
										{
											dateFormat:\"yy-mm-dd\",
											onSelect: function(dateText, inst) {
												
												if($(\"#$name_calendar\").length>0) 
												{	
													$(\"#$name_calendar\").val(dateText);
												}
												else											
												{	
													var calendar=\"<input id=\\\"$name_calendar\\\"  type=\\\"hidden\\\" name=\\\"$name_calendar\\\"  system=\\\"yes\\\" value=\\\"\" + dateText + \"\\\">\";												
													$(\"div#report_$name\").append(calendar);
												}
												
												$(\"#sys_action_$name\").val(\"seach\");
												$(\"#sys_page_$name\").val(1);	
												$(\"form\").submit();												
												
												
												
												//*//alert(dateText);
											},
										});
									</script>	
								</td>									
							";
						}					
						
						
						
						
						
                		$view_head="
							<div id=\"report_$name\" style=\"height:35px; width:100%;\" class=\"ui-widget-header\">
								<table width=\"100%\" height=\"100%\">
									<tr>
										<td width=\"10\"></td>
										$button_search
										$button_create
										<td width=\"1\">
											<table>
												<tr id=\"filter_fields_$name\">
												</tr>
											</table>
										</td>
										<td>											
											<input style=\"paddin:8px; height:23px;\" name=\"sys_filter_$name\" system=\"yes\" id=\"sys_filter_$name\" class=\"formulario $name\" type=\"text\" value=\"{$this->request["sys_filter_$name"]}\" placeholder=\"Filtrar reporte\">													
										</td>
										<td width=\"30\">
											<font id=\"sys_search_$name\" class=\"sys_seach ui-button\">Filtrar</font>
										</td>
										$calendar
										<!--
										<td width=\"30\">
											<select name=\"sys_check_action_$name\" id=\"sys_check_action_$name\">
												<option value=\"\">Selecciona una opcion</option>
												<option value=\"delete\">Borrar</option>
												<option value=\"print\">Imprimir</option>
											</select>																						
											<script>
												$(\"#sys_check_action_$name\" ).selectmenu();
											</script>																						
										</td>										
										-->
										<td align=\"right\">
											<b> $inicio - $fin / {$return["total"]}</b>
										</td>								
										<td width=\"50\" style=\"padding-left:8px; padding-right:8px;\">
						";
						if(@$this->request["sys_action"]!="print_pdf")	
						{
							if(@!$this->request["sys_row_$name"]) $this->request["sys_row_$name"]=50; 	
							$array=array(1,20,50,100,200,500);
							$option_select="";
							foreach($array as $index)
							{
								$selected		="";	
								if($index==$this->request["sys_row_$name"]) 	$selected="selected";
								$option_select.="<option value=\"$index\" $selected>$index</option>";
							}							
							
							$view_head.="
											<select type=\"report\" name=\"sys_rows_$name\" id=\"sys_rows_$name\">
												$option_select		
											</select>
							";
						}					
						#3141005662
						$view_head.="	
										</td>
										<td  width=\"20\" align=\"center\" >
											<font action=\"-\" name=\"$name\" class=\"page ui-button\">Anterior</font>
										</td>										
										<td width=\"20\" align=\"center\" >
											<font action=\"+\" name=\"$name\" class=\"page ui-button\">Siguiente</font>
										</td>
									</tr>
								</table>		
								
							</div>                
                		";
                	}
					#
										
					if(!isset($option["header"]))	
						$option["header"]		="true";					
										
					if(@$option["header"]!="true")		$view_head="";
										
					$return["title"]=$view_title;
					

					#0133 32084420  CESAR JIMENES  32084444
					$button_create_js="";
					
					if(isset($template_option) AND !in_array(@$this->request["sys_action"],$this->sys_print))	
					{
						#$this->__PRINT_R($template_option);
						
						$button_create_js="
							if($(\"font#create_$name\").length>0)
							{	
								$(\"font.show_form\").button({	    
									icons: {	primary: \"ui-icon-extlink\" },
									text: false
								}),
	            				$(\"font#create_$name\").click(function()
	            				{
									$(\".{$template_option["class_field"]}\").val(\"\");
									
	            					$(\"div#create_$name\").dialog({
	            						open: function(event, ui){
											var dialog = $(this).closest('.ui-dialog');
										},
										buttons: {
											\"Registrar\": function() {													
												var options={};
												options[\"class_one\"]			=\"{$template_option["class_one"]}\";
												options[\"class_field\"]		=\"{$template_option["class_field"]}\";												
												options[\"class_many\"]			=\"{$template_option["class_field_value"]["class_name"]}\";
												options[\"object\"]				=\"{$template_option["class_field_value"]["class_name"]}\";
												
												many2one_post(options);
											},
											\"Registrar y Cerrar\": function() {													
												var options={};
												options[\"class_one\"]			=\"{$template_option["class_one"]}\";
												options[\"class_field\"]		=\"{$template_option["class_field"]}\";												
												options[\"class_many\"]			=\"{$template_option["class_field_value"]["class_name"]}\";
												options[\"object\"]				=\"{$template_option["class_field_value"]["class_name"]}\";
												
												many2one_post(options);
												$( this ).dialog(\"close\");
											},
											
											\"Cerrar\": function() {
												$( this ).dialog(\"close\");
											}
										},										
	            						width:\"700px\"
	            					});
	            				});
							}						
						";
						
					}				
					$return["report"]="";
					if(!in_array(@$this->request["sys_action"],$this->sys_print))
						
						$return["report"]="
							$view_head
							<div id=\"div_$name\" class=\"render_h_destino\" style=\"width:100%; overflow-y:auto; overflow-x:hidden; min-height: 140px;\">
						";
					if(isset($option["template_separator"])) $view_title="";
						
						
						$return["report"].="
								<table width=\"100%\" style=\"background-color:#fff; \">
								$view_title
								$view_body
								</table>
						";		
					if(!in_array(@$this->request["sys_action"],$this->sys_print))
						$return["report"].="
							</div>								
							<script>
									$button_create_js
									sys_report_memory();
													
									$(\"#sys_search_$name\")
										.button({
											icons: {	primary: \"ui-icon-search\" },
											text: false
										})
										.click(function(){
											$(\"#sys_action_$name\").val(\"seach\");
											$(\"#sys_page_$name\").val(1);	
											$(\"form\").submit();
										}
									);							
									$(\"#sys_rows_$name\").change(function(){
									
										$(\"#sys_row_$name\").val(  $(\"#sys_rows_$name\").val()      );
										$(\"#sys_page_$name\").val(1);
										$(\"form\").submit(); 									
									});								
									$(\".page[action='-'][name='$name']\").button({
										icons: {	primary: \"ui-icon-triangle-1-w\" },
										text: false
									});
									$(\".page[action='+'][name='$name']\").button({
										icons: {	primary: \"ui-icon-triangle-1-e\" },
										text: false
									});
								
									$(\".page\").click(function(){
										var action      	=$(this).attr(\"action\");						    
										var sys_page    	=$(\"#sys_page_$name\").val();
										var sys_page2		=sys_page;
										if(action==\"-\")
										{	
											if($inicio > $(\"#sys_row_$name\").val())
											{	
												sys_page--;
											}	
										}	
										else
										{				
											if($fin < {$return["total"]})
											{	
												sys_page++;
											}	
										}			
										if(sys_page!=sys_page2)
										{	
											$(\"#sys_page_$name\").val(sys_page);
											$(\"form\").submit(); 
										}	
									});	
							</script>
						";
					$view="";	
					if(!in_array(@$this->request["sys_action"],$this->sys_print))					
						$view="
							<div id=\"base_$name\" class=\"render_h_origen\" diferencia_h=\"-40\" style=\"height:99%; width:100%; overflow-y:auto; overflow-x:hidden; border: 	1px solid #ccc;\">
						";
						
					
					$view.="	
						{$return["report"]}
					";
					if(!in_array(@$this->request["sys_action"],$this->sys_print))					
						$view.="	
						</div>		
					";

					if(!in_array(@$this->request["sys_action"],$this->sys_print))					
					{
						$view.="
							<input name=\"sys_order_$name\" id=\"sys_order_$name\" class=\"$name\" type=\"hidden\" value=\"$sys_order\">		
							<input name=\"sys_torder_$name\" id=\"sys_torder_$name\" class=\"$name\" type=\"hidden\" value=\"$sys_torder\">
							<input name=\"sys_page_$name\" id=\"sys_page_$name\" class=\"$name\" type=\"hidden\" value=\"$sys_page\">
							<input name=\"sys_row_$name\" id=\"sys_row_$name\" class=\"$name\" type=\"hidden\" value=\"$sys_row\">
						";
					}				
					$filter_autocomplete="";
					if(isset($this->sys_fields) AND is_array($this->sys_fields))
					{
						$sys_fields_filter	=$this->sys_fields;
						if(isset($this->sys_filter) and is_array($this->sys_filter))
						{
							$sys_fields_filter=array_merge($this->sys_fields,$this->sys_filter);
						}
						foreach($sys_fields_filter as $campo=>$valor)
						{        								
							if(@$this->request["sys_filter_{$this->sys_name}_{$campo}"])
							{	
								$filter_autocomplete.="
									var filter=filter_html(\"$campo\",\"{$valor["title_filter"]}\",\"{$this->request["sys_filter_{$this->sys_name}_{$campo}"]}\",\"$name\");											
									$(\"#filter_fields_$name\").append(filter);
								";
							}							
						}	
					}									
					
					if(!in_array(@$this->request["sys_action"],$this->sys_print))					
					{				
						$view.="
							$view_search
							$view_create
							<script>					
								if($(\"#sys_filter_$name\").length>0)        
								{
									$filter_autocomplete
								
									$( function() 
									{
										function split( val ) {
											return val.split( /,\s*/ );
										}
										function extractLast( term ) 
										{
											return split( term ).pop();
										}

										$(\"#sys_filter_$name\" )								
										.on( \"keydown\", function( event ) 
										{
											if( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( \"instance\" ).menu.active ) 
											{												
												event.preventDefault();
											}
										})
										.autocomplete(
										{
											source: function( request, response ) 
											{
												$.getJSON( \"../sitio_web/ajax/filter_autocomplete.php?class={$this->sys_object}\", {
												term: extractLast( request.term )
												}, response );
											},
											search: function() 
											{
												// custom minLength
												var term = extractLast( this.value );
												if ( term.length < 2 ) 
												{
													return false;
												}
											},
											focus: function() 
											{
												// prevent value inserted on focus
												return false;
											},
											select: function( event, ui ) 
											{
												var filter=filter_html(ui.item.field,ui.item.title,ui.item.term,\"$name\");											
												$(\"#filter_fields_$name\").append(filter);
												
												this.value = \"\";
												////$(\"form\").submit(); 
												return false;
											}											
										})
										.autocomplete( \"instance\" )._renderItem = function( ul, item ) 
										{
											return $( \"<li>\" )
											.append( \"<div> Buscar <b>\" + item.term + \"</b> en la columna <b><font size=\\\"1\\\"> \" + item.title + \" </font></b></div>\" )
											.appendTo( ul );
										}									
									} );
								}
								$(\".title\").resizable({
									handles: \"e\"
								});
							</script>							
						";
					}
					$return["html"]	=$view;
				}	
		    }	
		    else $return["html"]="Es necesario un array para generar el reporte";
		    
		    return $return;
		}   
		
		
    	##############################################################################        
		public function __PRINT($message=NULL,$option=NULL)
		{	
			$cerrado="";
			if(is_null($option))			$option				=$this->__PRINT_OPTION;
			if(is_null($message))			$message			=$this->__PRINT;
			
			if(!isset($option["title"]))	$option["title"]	="Mensaje del Sistema";
			if(!isset($option["time"]))		$option["time"]		="2500";
			if(!isset($option["object"]))	$option["object"]	="message";
			
			if($option["time"]>0)
			{	
				$cerrado="
					setTimeout(function() 
					{
						$(\"#{$option["object"]}\").dialog(\"close\")
					}, {$option["time"]} );			
				";	
			}		
			if($message!="")
			{	
				if($option["object"]!="message")
						echo "<div id=\\\"{$option["object"]}\\\"></div>";			
				echo "					
					<script>
						$(\"#{$option["object"]}\")
							.attr({\"title\":\"{$option["title"]}\"})
							.html(\"$message\")
							.dialog(
							{
								show: {
									effect: \"shake\",
									duration: 750
								},		    			    	
								width:\"350\",
								modal: true,
							}
						);								
						$cerrado
					</script>
				";
			}
		}
		public function __MESSAGE($message,$option=NULL)
		{
			
			/*
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
			*/
		}    

	}  	
?>



