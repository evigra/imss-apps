<?php
	require_once("../../../nucleo/sesion.php");	
	$option				=array();	
	$option["name"]		="p_pase";	

		
	
	$objeto				=new personal_txt($option);	
	#$objeto->__PRINT_R($option);
	#$objeto->__PRINT_R($_GET);
	$mensaje="";
	if($_GET["sys_action"]!="__SAVE")
		$mensaje="Situacion de las solicitudes<br><br>";

	$option["header"]		="false";
	
	$option["actions"]	="false";
	$option["where"]	=array(
		"estatus in('APROVADO','')",
		"trabajador_clave='{$_GET["matricula"]}'",
		"dias LIKE '".date("Y-m")."-%'")
	;
	#$option["echo"]		="Ajax personal_txt";
				
	$data										= $objeto->__REPORT_SUSTITUTO($option);
	$aprovados		=0;
	$s_aprovados	=0;
	$pendientes		=0;
	$s_pendientes	=0;
	foreach($data["data"] as $row)
	{

		if(isset($row["estatus"]) AND $row["estatus"]=="APROVADO")	
		{	
			$aprovados	+=$row["total"];
			$s_aprovados++;
		}
		if(isset($row["estatus"]) AND $row["estatus"]=="")			
		{	
			$pendientes	+=$row["total"];
			$s_pendientes++;
		}
		
	}
	$dias=4;
	
	if(@$row["trabajador_turno"]==1 OR @$row["trabajador_turno"]==2)	$dias=4;
	if(@$row["trabajador_turno"]==3)									$dias=2;
	if(@$row["trabajador_turno"]==5)									$dias=1;
	
	
	
	$mensaje_aux="$s_aprovados Solicitud(des) Aprovadas :: $aprovados Dia(s)<br>$s_pendientes Solicitud(des) Pendientes :: $pendientes Dia(s)<br>";
		
	echo $data["html"];
	
	if(@$mensaje!="" and $aprovados>=$dias) 
		$objeto->__PRINT("$mensaje $mensaje_aux", array("time"=>""));
	
?>
