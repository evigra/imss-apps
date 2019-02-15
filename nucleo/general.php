<?php
	include('auxiliar.php');	
	class general extends auxiliar
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		#var $ophp_fields		=array();
			
		##############################################################################	
		##  Metodos	
		##############################################################################
		var $sys_fields_l18n	=NULL;		
		#var $sys_enviroments	="DEVELOPER";
		var $sys_enviroments	="PRODUCTION";
		public function __CONSTRUCT($option=array())
		{  	
			if(!isset($this->sys_fields))			$this->sys_fields=array();
			
			if(!isset($option))						$option=Array();
			if(!is_array($option))					$option=Array();
						
			if(!isset($_SESSION))
				@$_SESSION							=array();

			if(!isset($_SESSION["user"]))
				@$_SESSION["user"]					=array();
    		if(!isset($_SESSION["user"]["huso_h"]))
   				@$_SESSION["user"]["huso_h"]		=5;
				
			if(!isset($_SESSION["user"]["l18n"])) 
				@$_SESSION["user"]["l18n"]			="es_MX";
			
			$this->sys_date							=date("Y-m-d H:i:s");
			$this->sys_date2						=date("Y-m-d");
						
			$nuevafecha								= strtotime ( '-7 hour' , strtotime ( $this->sys_date ) ) ;
			$this->sys_date 						= date ( 'Y-m-d H:i:s' , $nuevafecha );
			 
			
			if(!is_array($option)) 					$option=array();
			
			
			if(isset($option["object"])) 			$this->sys_object				=$option["object"];
			if(isset($option["name"])) 				$this->sys_name					=$option["name"];
			if(isset($option["table"])) 			$this->sys_table				=$option["table"];
			if(isset($option["memory"])) 			$this->sys_memory				=$option["memory"];
			if(isset($option["class_one"])) 		$this->class_one				=$option["class_one"];

			if(isset($option["sys_enviroments"])) 	$this->sys_enviroments			=$option["sys_enviroments"];
			if(!isset($this->sys_enviroments)) 		$this->sys_enviroments			="PRODUCTION";
			if(!isset($this->sys_object)) 			$this->sys_object				= get_class($this);
			if(!isset($this->sys_name)) 			$this->sys_name					= $this->sys_object;			
			if(!isset($this->sys_table)) 			$this->sys_table				= $this->sys_object;			
			if(!isset($this->sys_module)) 			$this->sys_module               ="modulos/".$this->sys_object."/";
			
			$this->words["sys_asunto"]				="";
			$this->words["sys_pie"]					="";
			
			
					
			$this->sys_l18n    		       		 =$this->sys_module."l18n/";			
			
			if($this->sys_enviroments=="DEVELOPER")
			{	
				error_reporting(-1);
				ini_set('display_errors', 1);				
			}
			else if($this->sys_enviroments=="TESTING")	
			{
				ini_set('display_errors', 0);
			}				
			else if($this->sys_enviroments=="PRODUCTION")	
			{
				ini_set('display_errors', 0);
			}				
			ini_set('display_errors', 0);
			
			if($this->sys_object!="general")
			{	
				if(file_exists($this->sys_l18n . @$_SESSION["user"]["l18n"].".php"))
				{				
					include($this->sys_l18n . @$_SESSION["user"]["l18n"].".php");				
				}	
				@include("nucleo/l18n/" . @$_SESSION["user"]["l18n"].".php");

				$this->__REQUEST();				
				
				$eval="
					if(@$"."this->request[\"sys_section_".$this->sys_name."\"]!=\"\")
					{
						$"."this->sys_action	=@$"."this->request[\"sys_action_".$this->sys_name."\"];
						$"."this->sys_section	=@$"."this->request[\"sys_section_".$this->sys_name."\"];
						
						#if(isset($"."this->request[\"sys_id_".$this->sys_name."\"]))
						
						$"."this->request[\"sys_id\"]	=@$"."this->request[\"sys_id_".$this->sys_name."\"];					
					}	
				";
				eval($eval);	
				
				#$_REQUEST["LALO_sys_object"]=$this->sys_object;		
				#$this->__PRINT_R($_REQUEST);

				
				$this->__FIND_FIELD_ID();		
				$this->__FIND_FIELDS();
				
				#if(@$this->sys_vpath==$this->sys_object."/" AND @$this->sys_action=="__SAVE" AND ($this->sys_section=="create" OR $this->sys_section=="write"))
				if(@$this->sys_vpath==$this->sys_object."/" AND substr(@$this->sys_action,0,6)	=="__SAVE" )
					
				{
					$this->__PRE_SAVE();
					$words["system_message"]    		=@$this->__SAVE_MESSAGE;
					$words["system_js"]     			=@$this->__SAVE_JS;	            
				}
				else 
				{
					$this->__IMPORT();
				} 
				$this->__FIND_FIELDS(@$this->sys_primary_id);
				#$this->__PRINT_R($_SESSION["SAVE"]);
			}
    	}
		public function __SAVE_NOT_EXISTS($data_save)
    	{		
			$data_where=array();
			foreach($data_save as $field => $value)
			{
				$data_where[]="$field='$value'";
			}
				
			$option		=array("where"=>$data_where);
		
			$datas_where		=$this->__BROWSE($option);
			
		
			if($datas_where["total"]==0)
			{	
				$this->sys_primary_id="";
				$this->__SAVE($data_save);		
			}	
		}
		public function __BROWSE($option=array())
    	{    	
    		$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;
    		
    		#####################
    		$retun				=array();
    		$id="";
    		if(is_numeric($option))
    		{    			
    			$this->__FIND_FIELD_ID();
    			$id		=$option;
    			$option	=array();
				
    			$option["where"]=array(
    				"{$this->sys_primary_field}='$id'"
    			);
    		}
    		
	    	if(!isset($option["name"]))    					$name							=@$this->sys_name;
	    	else											$name							=$option["name"];
            
			if(isset($this->request["sys_order_$name"]))	$option["sys_order_$name"]		=$this->request["sys_order_$name"];
			if(isset($this->request["sys_torder_$name"]))	$option["sys_torder_$name"]		=$this->request["sys_torder_$name"];
    		
    		
    		if(!isset($option["sys_torder_$name"]))			$sys_torder						="ASC";
    		else
    		{
    		    if($option["sys_torder_$name"]=="ASC")      $sys_torder						="DESC";
    		    else                                        $sys_torder						="ASC";
    		}
    		
    		if(!isset($option["select"])) 	
    		{
    			$select="*";
    		}    		
    		else							
    		{
    			if(is_array($option["select"]))
    			{
    				$select				="";
    				$html_title			=array();
					$html_title_clean	=array();
    				foreach($option["select"] as $campo => $title)
    				{
    					$font		=$title;
    					if(is_string($campo))
    					{
							if($select=="")		
							{
							    $select		    ="$campo as $title";									
							}
							else
							{
								$select		    .=", $campo as $title";
							}				
							$sys_order	=$campo;	
													
						}
						else
						{
    						if($select=="")		
    						{
    						    $select		    ="$title";
    						}
    						else
    						{				
    						    $select		    .=", $title";
    						}
    						$sys_order	=$title;    						
						}
						if(!isset($html_title["$title"]))	
						{
							$option_report_titles=array(
								"sys_order"		=>"$sys_order",
								"sys_torder"	=>"$sys_torder",
								"sys_order"		=>"$sys_order",
								"font"			=>"$campo",
								"name"			=>"$name",
							);
							$html_title["$title"]				=$this->__REPORT_TITLES($option_report_titles);
							
							$option_report_titles["option"]		="pdf";
							$html_title_clean["$campo"]			=$this->__REPORT_TITLES($option_report_titles);
						}	
    				}    			
    			}
    			else 
    			{
    				$select=$option["select"];
    			}	
    		}	
    		#####################
    		if(!isset($option["from"]))	$from=	$this->sys_table;
    		else						$from=	$option["from"];
			#####################
    		$where='WHERE 1=1';
			
			

			##   FILTER AUTOCOMPLETE ######
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
						if(!isset($option["where"]))    $option["where"]=array();		

						$busqueda					=$this->request["sys_filter_{$this->sys_name}_{$campo}"];
						
						if(@$this->sys_fields[$campo]["relation"]=="one2many")
						{
							
							$class_field_o			=$valor["class_field_o"];
							$class_field_m			=$valor["class_field_m"];
							$class_field_l			=$valor["class_field_l"];
							
							$eval="
								$"."obj_$campo   				=new {$valor["class_name"]}();
								
								$"."option_$campo=array(
									\"where\"=>array(
										\"$class_field_l LIKE '%{$busqueda}%'\"
									)
								);									
								$"."data_$campo					=$"."obj_$campo"."->__BROWSE($"."option_$campo);
								
								$"."busqueda=\"\";
								foreach($"."data_$campo"."[\"data\"] as $"."row_$campo)
								{									
									if($"."busqueda==\"\") 	$"."busqueda		= $"."row_$campo"."[\"$class_field_o\"];
									else					$"."busqueda		.= \",\" . $"."row_$campo"."[\"$class_field_o\"];
								}															
							";
							#$this->__PRINT_R($eval);
							eval($eval);										

							$option["where"][]="$class_field_m IN ($busqueda)";			
						}
						else	$option["where"][]="$campo LIKE '%$busqueda%'";	
						
						#$this->__PRINT_R($option["where"]);
					}
					
				}	
			}	
			
			
    		if(isset($option["where"]))
    		{
    			if(is_array($option["where"]))
    			{
					foreach($option["where"] as $datas)
					{ 			
						$where.=" AND $datas";
					}    		
				}
				else	$where.=" ". $option["where"];
					
    		}    		
#			$this->__PRINT_R($where);
    		#####################
			$order="";
    		if(isset($option["order"]) AND $option["order"]!="")		
    		{
    			$order=	" ORDER BY ".$option["order"];
    		}
    		if(isset($option["sys_order_$name"]) AND $option["sys_order_$name"]!="")		
    		{
    			if($order=="")	$order	=" ORDER BY ";
    			else    		$order	.=", ";
    			
    			$order			.=$option["sys_order_$name"];
    			
				if(isset($option["sys_torder_$name"]))	$order.=" ".$option["sys_torder_$name"];
    		}	
    		#####################
    		$group="";
    		if(isset($option["group"]))		
    		{
    			$group=	" GROUP BY ".$option["group"];				
    		}	
    		#####################

    		$having="";
    		if(isset($option["having"]))
    		{
    			$having=" HAVING 1=1 ";
    			if(is_array($option["having"]))
    			{
					foreach($option["having"] as $datas)
					{ 			
						$having.=" and $datas";
					}    		
				}
				else	$having.=" ". $option["having"];					
    		}    		
    		
    		#####################
    		$limit="";

    		if(isset($option["sys_page_$name"]) AND $option["sys_page_$name"]>0)		
    		{
    			if(isset($this->request["sys_row_$name"]))     	$option["sys_row_$name"]    =$this->request["sys_row_$name"];
				else											$option["sys_row_$name"]	=50;
    			$inicio						=$option["sys_page_$name"] * $option["sys_row_$name"] - $option["sys_row_$name"];
    			
    			$return["inicio"]    		=$inicio;
    			
    			$limit						=" LIMIT $inicio, {$option["sys_row_$name"]}";
    		}	

    		if(isset($option["limit"]) AND $option["limit"]>0)
    		{    			
    			$limit						=" LIMIT {$option["limit"]}";
    		}			
    		
    		#####################
    		
    		#if(isset($option["total"]))
    			$this->sys_sql					="SELECT count(*) as total FROM $from $where  $group $having";
			#$this->sys_sql		="SELECT $select FROM $from $where  $group  $having";
    		#else	
    		#$this->sys_sql					="SELECT count(*) as total, $select FROM $from $where  $group $having";    			    			
    		$total 	            = $this->__EXECUTE($this->sys_sql);
			$echo_total=array();
			
			$echo_total["sql_total"]	=$this->sys_sql;
			$echo_total["total"]		=$total;
			
			
			

            $subtotal			=count($total);
			
			$echo_total["count(total)"]	=$subtotal;
			
			
    		if($subtotal>1)        
			{	
				$return["total"]    =$subtotal;
			}	
    		elseif($subtotal=1)     
    		{    			
    			if(is_array(@$total[0]))
	    			$return["total"]    =@$total[0]["total"];
    		}
			
			#$return["total"]    =$subtotal;
    			

			#$this->__PRINT_R($echo_total);		

			
    		$this->sys_sql		="SELECT $select FROM $from $where  $group  $having $order $limit";
    		    		
    		if(isset($option["echo"]))
             	echo "<div class=\"echo\" title=\"{$option["echo"]}\">".$this->sys_sql."</div>";
   			
   			#$return["data"] 	= $this->__EXECUTE($this->sys_sql, $option);
   			$return["data"] 	= $this->__EXECUTE($this->sys_sql);
			
			
			
			#$return["total"]=$this->sys_total_row;
			
			
   			#echo "<br><br>OPTIONS<<<<<<<<<<<<<<<<<<<<<br>";
   			#$this->__PRINT_R($option);
   			#$this->__PRINT_R($return["data"]);
			if(is_array(@$return["data"][0]))
			{
				foreach($return["data"][0] as $campo => $title)
				{
					$font		=$title;
					if(is_string($campo))	$sys_order	=$campo;							
					else					$sys_order	=$title;    						

					if(!isset($html_title["$campo"]))	
					{						
						$option_report_titles=array(
							"sys_order"		=>"$sys_order",
							"sys_torder"	=>"$sys_torder",						
							"font"			=>"$campo",
							"name"			=>"$name",
						);
						$html_title["$campo"]				=$this->__REPORT_TITLES($option_report_titles);
						
						$option_report_titles["option"]		="pdf";
						$html_title_clean["$campo"]			=$this->__REPORT_TITLES($option_report_titles);
							
					}	
				}    			
			}
			
			if(!is_array(@$html_title))
			{
				$return["data_0"][0]=array();	
				foreach($this->sys_fields as $campo => $value)
				{	
					$return["data_0"][0]["$campo"]="";
					if(isset($value["title"]))	$font		=$value["title"];					
					else 						$font		=$campo;
					
					if(is_string($campo))	$sys_order	=$campo;									
					else					$sys_order	=$title;    						

					if(!isset($html_title["$campo"]))	
					{						
						$option_report_titles=array(
							"sys_order"		=>"$sys_order",
							"sys_torder"	=>"$sys_torder",
							"font"			=>"$campo",
							"name"			=>"$name",
						);
						$html_title["$campo"]				=$this->__REPORT_TITLES($option_report_titles);
						
					}	

				}	
				
			}	
   			
   			if(isset($html_title))			$return["title"]		= $html_title;			
			if(isset($html_title_clean))	$return["title_pdf"]	= $html_title_clean;
			
    		if($id!="")						$return					= $return["data"];

    		if(!isset($return["total"]) AND isset($return["data"]))
    		{
    			$return["total"]			=count($return["data"]);
    		}
    		
    		return $return;    		
    	}		
		##############################################################################		 		
		public function __SAVE($datas=NULL,$option=NULL)
    	{
			
			
			#echo ">>>>>>>>>>>>>>>>>>>>>>>";
			#$this->__PRINT_R($datas);
			
			
			if(!isset($this->sys_memory) OR $this->sys_memory=="")
			{	
				###########################################################	
				##################  REAL ##################################
				###########################################################		
				$fields			="";
				$return			="";
				$many2one		=array();
				
				if(!isset($option) OR is_null($option))	$option=array();
				
				if(!array_key_exists("message",$option))   
					$option["message"]="DATOS GUARDADOS";
								
				if(!(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id==""))
				{
					$data_anterior=$this->__BROWSE($this->sys_primary_id);				
				}		
				
				if(is_array(@$datas))
				{	
					foreach(@$datas as $campo=>$valor)
					{					
						if(is_array($valor))
						{
							$many2one["$campo"]=$valor;						
						}				
						if(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id=="") 
						{
							#if(count(@$this->sys_fields["$campo"])>1 and $valor!="")
							if(count(@$this->sys_fields["$campo"])>1 )
							{
								if(!is_array($valor))	
									$fields	.="$campo='$valor',";
							}
						}
						else
						{
							#if(count(@$this->sys_fields["$campo"])>1 and $valor!="" and @$this->sys_fields["$campo"]["type"]!='primary key')
							if(count(@$this->sys_fields["$campo"])>1 and @$this->sys_fields["$campo"]["type"]!='primary key')
							{
								if(!is_array($valor))	
								{									
									if($data_anterior[0][$campo]!=$valor)		
										@$modificados.=" 
											<b title=\"{$data_anterior[0][$campo]}\">{$this->sys_fields["$campo"]["title"]}</b>= $valor
										";
									$fields	.="$campo='$valor',";
								}	
							}
						}	
					}    
				}
				#echo "<br>__SAVE :: ". $this->__PRINT_R($fields);
				if($fields!="")
				{
					$SAVE_JS="";
					$fields				=substr($fields,0,strlen($fields)-1);
					$insert=0;					
					
					$matricula			=@$_SESSION["user"]["matricula"];
					$nombre				=@$_SESSION["user"]["nombre"];
									
					$data_historico="
						tabla='$this->sys_table',
						objeto='$this->sys_object',
						matricula='$matricula',
						trabajador='$nombre',
						fecha='$this->sys_date',
						remote_addr='{$_SERVER["REMOTE_ADDR"]}',												
					";
					
					if(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id=="") 
					{
						$insert=1;
						$this->sys_sql	="INSERT INTO {$this->sys_table} SET $fields";
						$this->__PRINT_JS.="
							$(\"input[system!='yes']\").each(function(){                		
								$(this).val(\"\");                			
							})
						";            
						$data_historicos="descripcion='<font title=\"$nombre\">$matricula</font> <b>CREO</b> El registro'";					
						#$data_historicos="descripcion='{$_SESSION["user"]["matricula"]}<b>CREO</b> El registro'";					
					}	
					else 
					{	
						$this->sys_sql	="UPDATE {$this->sys_table} SET $fields WHERE {$this->sys_primary_field}='{$this->sys_primary_id}'";					
						if(@$modificados!="")
						{
							$data_historicos="descripcion='<font title=\"$nombre\">$matricula</font> <b>MODIFICO</b> los valores $modificados'";	
							#$data_historicos="descripcion='{$_SESSION["user"]["matricula"]}<b>MODIFICO</b> los valores $modificados'";	
						}	
					}	

					$option["open"]	=1;
					#$option_conf["close"]	=1;
					$this->__EXECUTE($this->sys_sql,$option);
					
					#$this->__PRINT_R($this->sys_sql);
					
					if(@$this->OPHP_conexion->error=="")
					{					
						unset($option["open"]);
									
						$this->__PRINT="Datos guardados correctamente";
											
						
						$option["close"]=1;
						
						if($insert==1)
						{
							#$option_conf["open"]	=1;
							$option["close"]	=1;
						
							#echo "ENTRO {$this->sys_object}";
							$data = $this->__EXECUTE("SELECT LAST_INSERT_ID() AS ID",$option); 
							unset($option["close"]);
							#echo "<br>__SAVE :: ". $this->__PRINT_R($data);
							$this->sys_primary_id=$data[0]["ID"];
						}	
						$return=@$this->sys_primary_id;
						
						#$this->__PRINT_R($many2one);
						foreach($many2one as $campo =>$valores)	
						{										
							$valor_campo	=$this->sys_fields["$campo"];
							
							$eval="								
								$"."this->$campo"."_obj									=new {$valor_campo["class_name"]}();		
								$"."class_field_m										=$"."valor_campo[\"class_field_m\"];
											
								foreach($"."valores as $"."valor)
								{	
									if(!(isset(    $"."valor_campo[@$"."class_field_m]     ) AND @$"."valor_campo[@$"."class_field_m]==\"\"))								
										@$"."valor[@$"."class_field_m]						=$"."this->sys_primary_id;								

									
									$"."primary_field					=$"."this->$campo"."_obj->sys_primary_field;
									
									if(isset($"."valor[$"."primary_field]) AND  $"."valor[$"."primary_field]>0	)
									{										
										$"."this->$campo"."_obj->sys_primary_id		=$"."valor[$"."primary_field];	
									}	
									else
									{	
										$"."this->$campo"."_obj->sys_primary_id		=\"\";
									}
									$"."this->$campo"."_obj->__SAVE($"."valor);		
								}	
							";
							eval($eval);														
							unset($_SESSION["SAVE"][$this->sys_object][$campo]);	
							#unset($_SESSION["SAVE"][$this->sys_object]);	
							
						}
						
						if(!in_array($this->sys_table,$this->sys_modules))
						{	
							if(!isset($data_historicos))	$data_historicos="";
							$comando_sql="INSERT INTO historico SET $data_historico $data_historicos, clave=$this->sys_primary_id	";						
							if(@$data_historicos!="")
							{	
								$this->__EXECUTE($comando_sql);					
							}	
						}					
					}						
				}				
				#echo "<br>FIN __SAVE $return";
				return $return;
			}
			else
			{
				###########################################################	
				##################  MEMORIA ###############################
				###########################################################
				if(isset($datas["class_one"]))
				{						
					$class_one		=$datas["class_one"];
					$class_field	=$datas["class_field"];
					
					if(!isset($_SESSION["SAVE"]["$class_one"][$class_field]))
					{	
						$_SESSION["SAVE"]=array(
							"$class_one"	=>array(						
								"$class_field"	=> array()
							)
						);
					}				

					$valor_campo	=$this->sys_fields[$this->sys_primary_field]["value"];
	
					$row														=$datas["row"];				

					if(!isset($row[$this->sys_primary_field]))		$row[$this->sys_primary_field]=@$this->sys_primary_id;
					
					if(!isset($_SESSION["SAVE"]["$class_one"][$class_field]["data"]))	
						$_SESSION["SAVE"]["$class_one"][$class_field]["data"]=array();
					
					if(isset($datas["class_field_id"]) AND $datas["class_field_id"]>=0 )
					{
						$active_id		=$datas["class_field_id"];						
						$_SESSION["SAVE"]["$class_one"][$class_field]["data"][$active_id]	=	$row;							
					}
					else	$_SESSION["SAVE"]["$class_one"][$class_field]["data"][]	=	$row;
	
					$_SESSION["SAVE"]["$class_one"][$class_field]["total"]	=	count($_SESSION["SAVE"]["$class_one"][$class_field]["data"]);
			
				}		
			}
    	}
    	##############################################################################	   	
		public function __EXECUTE($comando_sql, $option=array("open"=>1,"close"=>1))
    	{
    		if(is_string($option))
    		{
    			$option=array("open"=>1,"close"=>1);
    		}
    	
    		$return=array();    		   
    		
    		if(@$this->sys_sql=="") 		$this->sys_sql=$comando_sql;
    		
	   		if(is_array($option))
    		{
    			#echo "<br>RESULTADO ABIERTO $comando_sql ";    			
    			#if(!isset($option["open"]))	$option["open"]=1;
    			    			

				if(isset($option["echo"]))
		        	echo "<div class=\"echo\" style=\"display:none;\" title=\"{$option["echo"]}\">".$this->sys_sql."</div>";
    		
    			if(isset($option["open"]))	
    			{    			
    				$this->abrir_conexion();
    				if(isset($option["e_open"]))
    				{    				
    					echo "<br><b>CONECCION ABIERTA</b><br>$comando_sql<br>{$option["e_open"]}";
    					$this->__PRINT_R($this->OPHP_conexion);
    				}	
    			}	
    		}
			if(isset($option["e_coneccion"]))	
			{
				$this->cerrar_conexion();
			    if(isset($option["e_coneccion"]))
				{    				
					echo "<br><b>CONECCION CONTINUA</b><br>$comando_sql<br>{$option["e_coneccion"]}";
					$this->__PRINT_R($this->OPHP_conexion->ping());
				}	
			}	

			$row=0;			
			
			#$this->__PRINT_R($this->OPHP_conexion);
			
			
			if(is_object($this->OPHP_conexion)) 
			{
				$resultado	= @$this->OPHP_conexion->query($comando_sql);
				
				$this->sys_total_row = @$resultado->num_rows;
				
				#mysql_num_rows
				if(isset($this->OPHP_conexion->error) AND $this->OPHP_conexion->error!="") 
				{					
					$title=get_called_class();
					echo "<div class=\"echo\" style=\"display:none;\" title=\"Error $title\">{$this->OPHP_conexion->error} <br><br>$comando_sql</div>";
				}						
			}	
			else
			{
				$resultado=array();
				echo "<div class=\"echo\" style=\"display:none;\" title=\"Coneccion\">Error en la conecion</div>";
			}	

			#echo "<br><br>$comando_sql";
			#$this->__PRINT_R($resultado);
						
			if(is_object(@$resultado)) 
			{			
				while($datos = $resultado->fetch_assoc())
				{			

					foreach($datos as $field =>$value)
					{
						
						if(is_string($field) AND !is_null($field) )
						{
							$return[$row][$field]=$value;
						}	
					}		
					$row++;	
				}
				#$this->__PRINT_R($return);
				$resultado->free();					
			}


			$this->__MESSAGE_EXECUTE="";
       		if(@$error!="")	
       		{
       			$sql='INSERT INTO sql_erros SET sql="$comando_sql"';
				@mysql_query($comando_sql);
       		    $this->__MESSAGE_EXECUTE    ="$error";
       		}
       		#/*
    		if(is_array($option))
    		{
    			if(isset($option["close"]))	
    			{
    				$this->cerrar_conexion();
   				    if(isset($option["e_close"]))
    				{    				
    					echo "<br><b>CONECCION CERRADA</b><br>$comando_sql<br>{$option["e_close"]}";
    					$this->__PRINT_R($this->OPHP_conexion);
    				}	
    			}	
    		}
       		#*/
       		return $return;	
    		//
    	}    	   	
	}
?>
