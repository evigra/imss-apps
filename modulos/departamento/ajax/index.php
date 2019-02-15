<?php
	require_once("../../../nucleo/sesion.php");
	require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
        select 
            u.*
        from 
            usuario u 
        where  1=1
			AND clave LIKE '{$_REQUEST["matricula"]}'
	";	
	#echo $comando_sql;
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	

	echo json_encode($data);
?>
