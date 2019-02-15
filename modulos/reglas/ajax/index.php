<?php
	require_once("../../../nucleo/sesion.php");
	#require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
        select 
            r.*, p.*
        from
			personal_cptos p LEFT JOIN
            reglas r on r.clave LIKE CONCAT('%',p.concepto,'%') AND p.concepto='{$_REQUEST["concepto"]}'
        where  1=1
			AND clave LIKE '%,{$_REQUEST["concepto"]},%'
			OR clave = '{$_REQUEST["concepto"]}'
	";	
	$comando_sql        ="
       select 
            p.*, r.*
        from
			personal_cptos p LEFT JOIN
			reglas r ON p.concepto='{$_REQUEST["concepto"]}'  AND   r.clave LIKE CONCAT('%',p.concepto,'%')
        where  1=1
			AND p.concepto='{$_REQUEST["concepto"]}'
	";	
	
	
	
	
	#echo $comando_sql;
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	
	#$objeto->__PRINT_R($data);
	
	echo json_encode($data);
?>
