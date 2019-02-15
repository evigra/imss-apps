<?php
	set_time_limit(180);
	
	
	require_once("../../../nucleo/sesion.php");	

	
		if(@$_REQUEST["inicio"]=="")						$_REQUEST["inicio"]	= date("Y-m-d");
		if(@$_REQUEST["fin"]=="")							$_REQUEST["fin"]	= date("Y-m-d");
				
		
		$obj_checadas=new personal_checadas();
		

		$fields = array( 'username'=>'administrator', 'userpwd'=>'123456');
		$postvars = '';
		foreach($fields as $key=>$value) {
			$postvars .= $key . "=" . $value . "&";
		}
		$url = "http://11.1.6.13/csl/check";
		$url = "http://{$_REQUEST["ip"]}/csl/check";
		
		$ch = curl_init();	
		
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		$response = curl_exec($ch);

		$response="";

		
		for($a=1; $a<=10; $a++)
		{		
			$postvars = "sdate={$_REQUEST["inicio"]}&edate={$_REQUEST["fin"]}&period=1";
			$user		=$_REQUEST["cont"]*10+$a;
			$postvars	.= "&uid=$user";					
						
			
			$url = "http://{$_REQUEST["ip"]}/form/Download  ";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 40);
			$response	= curl_exec($ch);
			
			$rows		=explode("\n",$response);		
			
			$todo=array();
			foreach($rows as $row)
			{
				if($row!="")
					$obj_checadas->__PRINT_R($row);
				
				$array		=explode("\t",$row);
				if($array[0]>0)
				{										
					$time		=explode(" ",$array[2]);								
					$data_save=array(
						"matricula"	=>$array[0],
						"fecha"		=>$time[0],
						"hora"		=>$time[1],
						"ip"		=>$_REQUEST["ip"],					
					);					
					$obj_checadas->__SAVE_NOT_EXISTS($data_save);									
					$todo[]=$data_save;
				}
			}				
		}	
		curl_close ($ch);			
	
?>
