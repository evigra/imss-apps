<?php
	require_once("../../../nucleo/sesion.php");
	#require_once("../../../nucleo/general.php");
	
	$objeto				=new horario();		


	$option					=array();			
	$option["select"]		=array(
		"horario"	=>"clave",
		"horario"	=>"label",		
	);
	$option["where"]		=array();
	
	if(@$_REQUEST["turno"]>0)	$option["where"][]		="turno='{$_REQUEST["turno"]}'";
	
	if(@$_REQUEST["id"]>0)		$option["where"][]		="horario='{$_REQUEST["id"]}'";
	else						$option["where"][]		="horario LIKE '%{$_REQUEST["term"]}%'";
	#$option["echo"]			="AJAX horario";
	
	$data					=$objeto->__BROWSE($option);
	echo json_encode($data["data"]);
	
	
	
	/*
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

	
	*/
	
	
	
?>
