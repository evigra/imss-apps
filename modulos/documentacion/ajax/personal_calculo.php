<?php
	require_once("../../../nucleo/sesion.php");
	require_once("../../../nucleo/general.php");
	
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
	
	#$objeto->__PRINT_R($data);
	
	if(@$data[0]["puesto"]=="")
	{	
		$comando_sql        ="
			select 
				pe.*, pl.*, pe.puesto_id, pe.puesto, pl.b2, pl.b3, pl.b4, pl.b5, pl.b6, pl.b7, pl.b8, pl.b9, '' as horario, '' as turno
			from 
				personal pe left join 
				plazas pl on pe.puesto_id=pl.puesto_id 
			where  1=1
				AND pe.matricula LIKE '{$_REQUEST["matricula"]}'
		";	
		#$objeto->__PRINT_R($comando_sql);
		$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	
	}
	#*/
	echo json_encode($data);
?>
