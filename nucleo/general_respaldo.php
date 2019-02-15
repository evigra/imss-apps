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
		public function __CONSTRUCT($option=Array())
		{  
			if(!isset($option))		$option=Array();
			if(!is_array($option))	$option=Array();
			
			
			
			if(!isset($_SESSION))
				@$_SESSION						=array();

			if(!isset($_SESSION["user"]))
				@$_SESSION["user"]				=array();
    		if(!isset($_SESSION["user"]["huso_h"]))
   				@$_SESSION["user"]["huso_h"]		=5;
				
			if(!isset($_SESSION["user"]["l18n"])) 
				@$_SESSION["user"]["l18n"]		="es_MX";
		

			parent::__CONSTRUCT($option);						
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
    		
	    	if(!isset($option["name"]))    	$name	=@$this->sys_name;
	    	else							$name	=$option["name"];
            
			if(isset($this->request["sys_order_$name"]))     $option["sys_order_$name"]    =$this->request["sys_order_$name"];
			if(isset($this->request["sys_torder_$name"]))    $option["sys_torder_$name"]   =$this->request["sys_torder_$name"];
    		
    		
    		if(!isset($option["sys_torder_$name"])) 	    $sys_torder="ASC";
    		else
    		{
    		    if($option["sys_torder_$name"]=="ASC")      $sys_torder="DESC";
    		    else                                        $sys_torder="ASC";
    		}
    		
    		if(!isset($option["select"])) 	
    		{
    			$select="*";
    		}    		
    		else							
    		{
    			if(is_array($option["select"]))
    			{
    				$select		="";
    				$html_title	=array();
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
							$html_title["$title"]	=$this->__REPORT_TITLES($sys_order,$sys_torder,$font,$name);
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
    		if(isset($option["where"]))
    		{
    			if(is_array($option["where"]))
    			{
					foreach($option["where"] as $datas)
					{ 			
						$where.=" and $datas";
					}    		
				}
				else	$where.=" ". $option["where"];
					
    		}    		
    		#####################
			$order="";
    		if(isset($option["order"]))		
    		{
    			$order=	" ORDER BY ".$option["order"];
    		}
    		if(isset($option["sys_order_$name"]))		
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

    		if(isset($option["sys_page_$name"]))		
    		{
    			$option["sys_row_$name"]	=50;
    			$inicio						=$option["sys_page_$name"] * $option["sys_row_$name"] - $option["sys_row_$name"];
    			
    			$return["inicio"]    		=$inicio;
    			
    			$limit						=" LIMIT $inicio, {$option["sys_row_$name"]}";
    		}	

    		if(isset($option["limit"]))
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
						$html_title["$campo"]	=$this->__REPORT_TITLES($sys_order,$sys_torder,$sys_order,$name);
					}	
				}    			
			}
   			
   			if(isset($html_title))	$return["title"]	= $html_title;
    		if($id!="")				$return				=$return["data"];

    		if(!isset($return["total"]) AND isset($return["data"]))
    		{
    			$return["total"]=count($return["data"]);
    		}
    		
    		return $return;    		
    	}		
		##############################################################################		 		
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#echo "<br>INI __SAVE ";
    		$fields	="";
    		$return	="";
    		
    		if(!isset($option) OR is_null($option))	$option=array();
			
			if(!array_key_exists("message",$option))   
				$option["message"]="DATOS GUARDADOS";
			
    		#echo "<br>__SAVE :: ". $this->__PRINT_R($this->sys_fields);
			
			if(!(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id==""))
			{
				$data_anterior=$this->__BROWSE($this->sys_primary_id);				
			}		
			
    		foreach($datas as $campo=>$valor)
    		{
    			if(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id=="") 
    			{

					if(count(@$this->sys_fields["$campo"])>1 and $valor!="")
					{
						if(!is_array($valor))	
							$fields	.="$campo='$valor',";
					}
    			}
    			else
    			{
					if(count(@$this->sys_fields["$campo"])>1 and $valor!="" and @$this->sys_fields["$campo"]["type"]!='primary key')
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
    		#echo "<br>__SAVE :: ". $this->__PRINT_R($fields);
    		if($fields!="")
    		{
    			$SAVE_JS="";
    			$fields				=substr($fields,0,strlen($fields)-1);
    			$insert=0;					
				
				$data_historico="
					tabla='$this->sys_table',
					objeto='$this->sys_object',
					matricula='{$_SESSION["user"]["matricula"]}',
					trabajador='{$_SESSION["user"]["nombre"]}',
					fecha='$this->sys_date',
				";
				
				
                if(is_null(@$this->sys_primary_id) OR @$this->sys_primary_id=="") 
                {
                    #echo "ENTRO {$this->sys_object}";
                	$insert=1;
                	$this->sys_sql	="INSERT INTO {$this->sys_table} SET $fields";
                	$SAVE_JS="
                		$(\"input[system!='yes']\").each(function(){
                		
                			$(this).val(\"\");
                			
                		})
                	";            
					$data_historicos="descripcion='<font title=\"{$_SESSION["user"]["nombre"]}\">{$_SESSION["user"]["matricula"]}</font> <b>CREO</b> El registro'";					
					#$data_historicos="descripcion='{$_SESSION["user"]["matricula"]}<b>CREO</b> El registro'";					
                }	
                else 
				{	
					$this->sys_sql	="UPDATE {$this->sys_table} SET $fields WHERE {$this->sys_primary_field}='{$this->sys_primary_id}'";					
					if(@$modificados!="")
					{
						$data_historicos="descripcion='<font title=\"{$_SESSION["user"]["nombre"]}\">{$_SESSION["user"]["matricula"]}</font> <b>MODIFICO</b> los valores $modificados'";	
						#$data_historicos="descripcion='{$_SESSION["user"]["matricula"]}<b>MODIFICO</b> los valores $modificados'";	
					}	
					
				}	
				

				#$option_conf=array();


				$option["open"]	=1;
				#$option_conf["close"]	=1;
    			$this->__EXECUTE($this->sys_sql,$option);
    			
    			#$this->__PRINT_R($this->OPHP_conexion->error);
    			
				if(@$this->OPHP_conexion->error=="")
				{					
					unset($option["open"]);
										
					if($this->__MESSAGE_EXECUTE!="")    $this->__SAVE_MESSAGE   =$this->__MESSAGE_EXECUTE;
					else                                $this->__SAVE_MESSAGE   =$option["message"];
					
					$data_message						=$this->__MESSAGE($this->__SAVE_MESSAGE,$option);
					
					$this->__SAVE_HTML	=$data_message["html"];
					$this->__SAVE_JS	=$data_message["js"] . $SAVE_JS;
					    			
					#$this->__PRINT_R($this->OPHP_conexion->error);
					
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
					echo "<div class=\"echo\" style=\"display:none;\" title=\"Error $title\">{$this->OPHP_conexion->error}</div>";
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
       		    $this->__MESSAGE_EXECUTE    =$error;
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
