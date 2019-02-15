<?php
	#if(file_exists("../menu/modelo.php")) require_once("../menu/modelo.php");
	
	class groups extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"name"	    =>array(
			    "title"             => "Perfil",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"menu_id"	    =>array(
			    "title"             => "Menu",
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    "source"            => "../modulos/menu/ajax/index.php",
			    
			    "relation"          => "one2many",			    
			    "class_name"       	=> "menu",
			    #"class_path"        => "modulos/menu/modelo.php",
			    "class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "menu_id",			# Origen
			    "class_field_m"    	=> "id",				# Destino
			    "value"             => "",			    
			),

			"permiso_ids"	    =>array(
			    "title"             => "Menu",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "permiso",
			    #"class_path"        => "modulos/permiso/modelo.php",
			    #"class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "id",					# Origen
			    "class_field_m"    	=> "usergroup_id",			# Destino
			    "value"             => "",			    
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			#$this->menu_obj=new menu();
			parent::__CONSTRUCT();

		}
		public function __VIEW_REPORT($option=NULL)		
		{		
    		if(is_null($option))	$option=array();
    		#/*
			$option["select"]	=array(
				"g.*",
				"m.name"=>"menu_name",
			);
			#*/
			$option["from"]		="groups g join menu m on m.id=g.menu_id";
			$option["order"]	="menu_name asc, nivel asc";
			
			#$option["echo"]		="GRUPO";
			return parent::__VIEW_REPORT($option);
		}
		public function groups($option=NULL)		
    	{	
    		if(is_null($option))	$option=array();
    		
			$option["select"]	=array(
				"g.*",
				"m.name"=>"menu_name",
			);
			$option["from"]		="groups g join menu m on m.id=g.menu_id";
			$option["order"]	="menu_name asc, nivel asc";
			
			$return =$this->__VIEW_REPORT($option);
			return $return;
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    	    $group_id=parent::__SAVE($datas,$option);
    	    
    	    #echo "<br>USUARIO=$user_id<br>";

    	    ## GUARDAR PERFILES DE USUARIO
    	    $usergroup_datas=array();
    	    if(isset($datas["permiso_ids"]))
    	    {
    	    	#$this->__PRINT_R($datas["permiso_ids"]);
			    foreach($datas["permiso_ids"] as $index => $data)
			    {
					$usergroup_option=array();
					## BUSCA PERFIL PREVIO 
					## SI EXISTE, LO MODIFICA
					## SI NO, LO CREA
					#$usergroup_option["echo"]="PERFILES";
					$usergroup_option["where"]=array(
						"usergroup_id=$group_id",
						"menu_id={$index}",
					);    	    		    	    		
					$usergroup_data						=$this->permiso_ids_obj->groups($usergroup_option);

					if($usergroup_data["total"]>0)		$this->permiso_ids_obj->sys_primary_id=$usergroup_data["data"][0]["id"];
					else								$this->permiso_ids_obj->sys_primary_id=NULL;

					$usergroup_save=array(
						"usergroup_id"	=>"$group_id",
						"menu_id"		=>"{$index}"					
					);
	
					if(isset($data["s"]))			$usergroup_save["s"]="{$data["s"]}";
					if(isset($data["c"]))			$usergroup_save["c"]="{$data["c"]}";
					if(isset($data["w"]))			$usergroup_save["w"	]="{$data["w"]}";
					if(isset($data["d"]))			$usergroup_save["d"]="{$data["d"]}";
					
					$this->permiso_ids_obj->__SAVE($usergroup_save);

			    }	
			}    
		}				
	}
?>

