<?php	
	require_once("nucleo/sesion.php");
	
	$eval="$"."objeto=new {$_GET["sys_name"]}();";
	eval($eval);
	 
	
?>
