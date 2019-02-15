<?php
	class sesion extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_mensaje="";
		var $sys_fields	=array(
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"user"	    =>array(
			    "title"             => "Usuario",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"pass"	    =>array(
			    "title"             => "Password",
			    "showTitle"         => "si",		
			    "type"              => "password",
			    "default"           => "",
			    "value"             => "",			    
			),
			
			"user_id"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"server_addr"	    =>array(
			    "title"             => "Servidor",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"date"	    =>array(
			    "title"             => "Fecha",
			    "showTitle"         => "si",
			    "type"              => "password",
			    "default"           => "",
			    "value"             => "",			    
			),
			"remote_addr"	    =>array(
			    "title"             => "Servidor",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"http_user_agent"	    =>array(
			    "title"             => "Agente",
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
		}        
		public function huso_horario($option)
		{
			$return=-5;
			foreach(timezone_abbreviations_list() as $timezone)
			{
				foreach($timezone as $val)
				{
				    if(isset($val['timezone_id']) AND $val['timezone_id']==$option)
				    {
				    	$return=$val['offset']/60/60;
				    	exit();						    	
				    }
				}
			}
			
			return $return;
		}        
		/*
		public function sesion($option=NULL)		
    	{	
			
    		if(is_null($option))	$option=array();
    		
			$option["select"]	=array(				
				"s.*",
				"u.*",
				"c.*",
			);
			$option["from"]		="
				sesion s join
				users u on s.user_id=u.id join
				company c on c.id=u.company_id
			";
			$option["order"]		="date desc";
			
			if(!isset($option["where"]))
				#$option["where"]=" and u.company_id={$_SESSION["company"]["id"]} or u.id={$_SESSION["user"]["id"]}";
				$option["where"]=" and u.id={$_SESSION["user"]["id"]}";
			#$option["echo"]="";
			$return =$this->__VIEW_REPORT($option);    				
			return $return;
		}				
		*/
		public function __SAVE($datas=NULL,$option=NULL)
    	{    		
    		$this->words["mensaje_sesion"]	= 	"
    			<div id=\"messajeSesion\" class=\"messajeSesion borderRed\">
					<table>
						<tr>
							<td>
								<img src=\"../modulos/sesion/img/noCheck.png\" alt=\"\" />
							</td>
							<td style = \"padding-left: 10px;\">
								Error de Sesion. Verifique Sus Datos.
							</td>    														 
						</tr>    													
					</table>    												
				</div>
			";
			$this->obj_user   		=new usuario();
			
    		if(array_key_exists("user",$datas) AND array_key_exists("pass",$datas))
    		{
				$user       								=$this->obj_user->session($datas["user"],$datas["pass"]);								
				if(count($user)>0)
				{
					#$this->__PRINT_R($user);			
					#$this->__PRINT_R($user["matricula"]."=".$datas["user"]);
					if($user["matricula"]==$datas["user"])
					{
						#$this->__PRINT_R($user);		
						if($user["password"]==md5($datas["pass"]))						
						{
							
							#$this->__PRINT_R($user);	
									
							
							$comando_sql="
								SELECT * 
								FROM 
									groups g join 
									user_group ug on ug.active=g.id 
								WHERE 1=1
									AND user_id={$user["id"]}
									AND active>0
							";		
					
							$data_usergroup 				=$this->__EXECUTE($comando_sql);						
							
							
							/*
							$option_company					=array("where"=>array("company.id={$user["company_id"]}"));
							$data_company					=$this->obj_company->companys($option_company);
							*/
							$data_sesion					=array();
							
							$data_sesion["user_id"]			=$user["id"];
							$data_sesion["date"]			=$this->sys_date;
							$data_sesion["server_addr"]		=$_SERVER["SERVER_ADDR"];
							$data_sesion["remote_addr"]		=$_SERVER["REMOTE_ADDR"];
							$data_sesion["http_user_agent"]	=$_SERVER["HTTP_USER_AGENT"];
						
							parent::__SAVE($data_sesion,$option);
						    $_SESSION["user"]       		=$user;		
						    $_SESSION["session"]    		=@$data_sesion;							
							$_SESSION["system_company"]		=$user["departamento"];
							$_SESSION["departamento_id"]	=$user["departamento_id"];
							$_SESSION["departamento"]		=$user["departamento"];
							
							
							
							$_SESSION["system_company"]		="";
							$_SESSION["system_user"]		=$user["nombre"];
						   						    
						    
						    #$huso_horario					=$_SESSION["company"]["huso_horario"];
						    #$_SESSION["user"]["huso_h"]		=$this->huso_horario($huso_horario);
						    $_SESSION["user"]["huso_h"]		=5;
						    
						    $_SESSION["group"]				=@$data_usergroup;
						    
						    if(@$_SESSION["user"]["sesion_start"]!="")	$sesion_start	=@$_SESSION["user"]["sesion_start"];
						    else										$sesion_start	="";
						    
						    if(@$user["sesion_start"]!="")   $locacion	=@$user["sesion_start"];
						    else							$locacion	="../personal_txt/&sys_menu=1";
						    
						    setcookie("solesgps", $user["id"]);
							
						      
							$nombre=str_replace("/", " ", $user["nombre"]);
						    $this->__SAVE_JS        		="
								//responsiveVoice.speak(\"Bienvenido $nombre\",\"Spanish Latin American Female\");            	
								window.location =\"$locacion\";  
							";
						    $this->__SAVE_MESSAGE   		="";
						    
						    $this->words["mensaje_sesion"]	=	"
						    	<div id=\"messajeSesion\" class=\"messajeSesion borderGreen\">
									<table>
										<tr>
											<td>
												<img src=\"../modulos/sesion/img/Check.png\" alt=\"\" />
											</td>
											<td style = \"padding-left: 10px;\">
												Datos Correctos. Iniciando Sesion...
											</td>				    														   														
											<td style = \"padding-left: 10px;\">
												<img src=\"../modulos/sesion/img/gps.gif\" alt=\"\" />
											</td>
										</tr>    													
									</table>    												
								</div>
							";
						}
					}
				}						
			}	
		}			
	}
?>
