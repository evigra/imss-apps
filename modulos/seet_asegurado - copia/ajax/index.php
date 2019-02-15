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
	
	/*
	if($data["total"]>0)
	{
		echo " 
			<script>
				alert(\"aaa\");
				$(\"#sys_id_seet_asegurado\").val(\"{$data["data"][0]["id"]}\");
				$(\"#sys_section_seet_asegurado\").val(\"write\");
				//$(\"form\").submit();
				
			</script>
		";	

	}
	*/
	#$objeto->__PRINT_R($data);
	
?>
