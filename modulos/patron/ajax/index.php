<?php
	require_once("../../../nucleo/sesion.php");	
	$option				=array();	
	$option["name"]		="p_txt";	
	
	$objeto				=new patron($option);	
	
	$option["where"]	=array("rp_rale='{$_GET["rp_rale"]}'");
				
	$data										= $objeto->__BROWSE($option);
	
	echo json_encode($data["data"]);
	
?>
