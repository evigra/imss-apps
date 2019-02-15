<?php
			$ch = curl_init();

			$fields = array( 'j_username'=>'rayosx', 'j_password'=>'rayosx');
			#$fields = array( 'username'=>'rayosx', 'password'=>'rayosx');
			$postvars = '';
			foreach($fields as $key=>$value) {
				$postvars .= $key . "=" . $value . "&";
			}
			$url = "http://172.24.20.13:8080/login";	
			$url = "http://172.24.20.13:8080/pureweb/server/login";	
			
			#$url = "http://{$data["ip"]}/csl/check";
			
			
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);
			
			#echo $response;
			header('Location: http://172.24.20.13:8080/pureweb/server/launch');
			#header('Location: http://172.24.20.13:8080/pureweb/viewer?expediente=' . $_REQUEST["trabajador_nss"] . '&mn=false');

			/*
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

			curl_close ($ch);		
			*/

?>
