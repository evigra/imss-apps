<?php
	require_once("../../../nucleo/sesion.php");
	require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
		SELECT pl1.*, pl3.departamento as dependencia
		FROM 
			imss.plazas pl1  JOIN 
			(
				SELECT * FROM imss.plazas pl2 WHERE pl2.departamento_id LIKE '%0000'
				GROUP BY left(pl2.departamento_id,6)
			) pl3 on left(pl1.departamento_id,6)=left(pl3.departamento_id,6)
		WHERE 1=1
			AND pl1.clave LIKE '{$_REQUEST["plaza"]}'
	";	
	#$objeto->__PRINT_R($comando_sql);
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	
	
	echo json_encode($data);
?>
