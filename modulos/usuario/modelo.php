<?php
	class usuario extends general
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
			"nombre"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"clave"	    =>array(
			    "title"             => "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"password"	    =>array(
			    "title"             => "Password",
			    "showTitle"         => "si",
			    "type"              => "password",
			    "default"           => "",
			    "value"             => "",			    
			),

			"usergroup_ids"	    	=>array(
			    "title"             => "Permisos",
			    "type"              => "input",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "user_group",
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "user_id",
			    "value"             => "",			    
			),

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			$this->menu_obj			=new menu();
			parent::__CONSTRUCT();			
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    	    if(isset($datas["password"]))
	    	    $datas["password"]		=md5($datas["password"]);
    	    
    	    $user_id=parent::__SAVE($datas,$option);
    	    
    	    if($user_id>0)
    	    {
		 	    if(isset($datas["usergroup_ids"]))
			    {
					foreach($datas["usergroup_ids"] as $index => $data)
					{
						$usergroup_option=array();
						## BUSCA PERFIL PREVIO 
						## SI EXISTE, LO MODIFICA
						## SI NO, LO CREA
						#$usergroup_option["echo"]="PERFILES";
						$usergroup_option["where"]=array(
							"user_id=$user_id",
							"menu_id={$index}",
						);    	    	
						#/*	    	    		
						$usergroup_data						=$this->usergroup_ids_obj->groups($usergroup_option);

						if($usergroup_data["total"]>0)		$this->usergroup_ids_obj->sys_primary_id=$usergroup_data["data"][0]["id"];
						else								$this->usergroup_ids_obj->sys_primary_id=NULL;

						$usergroup_save=array(
							"user_id"		=>"$user_id",
							"menu_id"		=>"{$index}",
							"active"		=>"$data"
						);	
						$this->usergroup_ids_obj->__SAVE($usergroup_save);
						#*/
					}	
				}    
			}	
    	    
		}				
		public function session($user,$pass)
    	{
    	    $option=array();
			$option["select"]="u.*, pe.*,pl.*, u.clave as matricula";		
    	    $option["from"]="
				usuario u left join 
				personal pe on pe.matricula=u.clave left join
				plazas pl on pe.matricula=pl.matricula				
			";    	    			
    	    $option["where"]=array(
				"u.clave='$user'",
				"u.password=md5('$pass')"
			);    	    
    	    #$option["echo"]="SESSION usuario";
			
    	    $data_user 	=$this->__BROWSE($option);	
    	    
			
			
    	    if(is_array($data_user) AND array_key_exists("data",$data_user))
    	    {    	    	
    	    	if(count($data_user["data"])>0)	$return=$data_user["data"][0];
    	    	else							$return=$data_user["data"];
    	    }
			
			#$this->__PRINT_R($return);
			
			
			return $return;
		}		
		public function __FIND_FIELDS($id=NULL)
		{
			parent::__FIND_FIELDS($id);
			if($this->sys_section=="write")
			{
				$this->sys_fields["password"]["value"]="";			
			}			
    	}		

	}
?>
