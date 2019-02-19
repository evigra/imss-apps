<?php
	require_once("../../../nucleo/sesion.php");	
	$option				=array();	
	$option["name"]		="p_txt";	
	
	$objeto				=new seet_asegurado($option);	
	#$objeto->__PRINT_R($option);
	#$objeto->__PRINT_R($objeto);

	
	$option["actions"]	="false";
	$option["where"]	=array("nss='{$_GET["nss"]}'");
				
	$data										= $objeto->__BROWSE($option);
	
	echo json_encode($data["data"]);
	
?>
