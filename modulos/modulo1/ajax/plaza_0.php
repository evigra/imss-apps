<?php
	require_once("../../../nucleo/sesion.php");
	require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
		SELECT *, 0 as clave, '' as turno, '' as horario, '' as matricula
		FROM 
			plazas 
		WHERE 1=1
			AND puesto_id = '{$_REQUEST["puesto_id"]}'			
			AND departamento_id LIKE '%0000'
			AND left('{$_SESSION["departamento_id"]}',6)=left(departamento_id,6)			
		LIMIT 1	
	";	
	#$objeto->__PRINT_R($comando_sql);
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	
	
	echo json_encode($data);
?>
