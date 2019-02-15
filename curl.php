<?php
  $ch = curl_init();

  $fields = array( 'username'=>'administrator', 'userpwd'=>'123456');
  $postvars = '';
  foreach($fields as $key=>$value) {
    $postvars .= $key . "=" . $value . "&";
  }
  $url = "http://11.1.6.13/csl/check";
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
  curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
  curl_setopt($ch,CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch);
  


$response="";

#/*
	$a=1;
	#for($a=1; $a<1000; $a++)
	{
		$fields = array( 'sdate'=>date("Y-m-d"), 'edate'=>date("Y-m-d"), 'period'=>'1', 'uid'=>$a);
		$fields = array( 'sdate'=>date("Y-m-d"), 'edate'=>date("Y-m-d"), 'period'=>'1');
		$postvars = '';
		foreach($fields as $key=>$value) 
		{
			$postvars .= $key . "=" . $value . "&";
		}
		for($a=1; $a<10; $a++)
		{
			$postvars .= "uid=" . $a . "&";
		}	
		
		$url = "http://11.1.6.13/form/Download  ";
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		$response	= curl_exec($ch);
		echo "$response\n\r";
	}
#*/
  
  
  curl_close ($ch);
?>