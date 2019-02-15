<?php
	require_once("../../../nucleo/sesion.php");
	#require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
        select 
            pe.*, pl.*
        from 
            personal pe left join 
            plazas pl on pe.matricula=pl.matricula 
        where  1=1
			AND pe.matricula LIKE '{$_REQUEST["matricula"]}'
	";	
	#$objeto->__PRINT_R($comando_sql);
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	

	echo json_encode($data);
?>
