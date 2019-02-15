<?php
	require_once("../../../nucleo/sesion.php");	
	$option				=array();	
	$option["name"]		="p_lic";	
	
	$objeto				=new personal_licencia($option);	
	
	$option["actions"]	="false";
	$option["where"]	=array("trabajador_clave='{$_GET["matricula"]}'");
	$option["limit"]	=5;
		
				
	$data										= $objeto->__REPORT_LICENCIA($option);
	
	echo $data["html"];
	
	#$objeto->__PRINT_R($data);
	
?>
