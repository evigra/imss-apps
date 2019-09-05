<?php
	set_time_limit(180);
	class personal_checador extends general
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
			"ip"	    =>array(
			    "title"             => "IP",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"user"	    =>array(
			    "title"             => "Usuario",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"pass"	    =>array(
			    "title"             => "Pass",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),
			"unidad"	    =>array(
			    "title"             => "Unidad",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			
			"inicio"	    =>array(
			    "title"             => "inicio",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",			    
			),	
			"fin"	    =>array(
			    "title"             => "fin",
				#"title_filter"		=> "Matricula",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",			    
			),			

				
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO    		
			
			$id		=parent::__SAVE($datas,$option);
			
			if(@$datas["inicio"]!="" AND @$datas["fin"]!="")	
			{
				$data=$this->__BROWSE($id);
				$this->BAJAR_CHECADAS($data[0]);
			}    		
    	    return $id;
		}		
		public function BAJAR_CHECADAS($data)
    	{
			if(@$data["inicio"]=="")						$data["inicio"]	= date("Y-m-d");
			if(@$data["fin"]=="")							$data["fin"]	= date("Y-m-d");
					
			
			$this->checadas=new personal_checadas();
			
			$ch = curl_init();

			$fields = array( 'username'=>'administrator', 'userpwd'=>'123456');
			$postvars = '';
			foreach($fields as $key=>$value) {
				$postvars .= $key . "=" . $value . "&";
			}
			$url = "http://11.1.6.13/csl/check";
			$url = "http://{$data["ip"]}/csl/check";
			
			
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);

			$response="";
	
			$postvars = "sdate={$data["inicio"]}&edate={$data["fin"]}&period=1";
			for($a=1; $a<500; $a++)
			{
				$postvars.= "&uid=$a";					
			}			
			
			$url = "http://{$data["ip"]}/form/Download  ";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 40);
			$response	= curl_exec($ch);
			
			$rows		=explode("\n",$response);		
			
			$this->__PRINT_R($rows);
			$todo=array();
			foreach($rows as $row)
			{
				$array		=explode("\t",$row);
				if($array[0]>0)
				{										
					$time		=explode(" ",$array[2]);								
					$data_save=array(
						"matricula"	=>$array[0],
						"fecha"		=>$time[0],
						"hora"		=>$time[1],
						"ip"		=>$data["ip"],
						
					);					
					$this->checadas->__SAVE_NOT_EXISTS($data_save);									
					$todo[]=$data_save;
				}
			}				
			
			curl_close ($ch);		
			
			
		}		
	}
?>
