<?php
/*
       <div class="tr">
			<div class="td">
				<input name="ctl00$MainContent$UserName" type="text" id="MainContent_UserName" accesskey="u" class="caja" />
						<span id="MainContent_UserNameRequired" title="El nombre de usuario es obligatorio." style="visibility:hidden;">*</span>
			</div>
		</div>
		<div class="tr">
			<div class="td">
				<label for="MainContent_Password" id="MainContent_PasswordLabel">Contraseña:</label>
			</div>
		</div>
		<div class="tr">
			<div class="td">
				<input name="ctl00$MainContent$Password" type="password" id="MainContent_Password" class="caja" />
						<span id="MainContent_PasswordRequired" title="La contraseña es obligatoria." style="visibility:hidden;">*</span>
			</div>
		</div>

*/



			$ch = curl_init();

			$fields = array( 'ctl00$MainContent$UserName'=>'MEDICO', 'ctl00$MainContent$Password'=>'medico');
			$postvars = '';
			foreach($fields as $key=>$value) {
				$postvars .= $key . "=" . $value . "&";
			}
			$url = "http://172.24.20.14";
			#$url = "http://{$data["ip"]}/csl/check";
			
			
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);
			
			header('Location: http://172.24.20.14/Historial.aspx?expediente=' . $_REQUEST["trabajador_nss"] . '&mn=false');

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
			*/
			curl_close ($ch);		

?>
