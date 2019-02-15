<?php
	require_once("../../../nucleo/sesion.php");
	#require_once("../../../nucleo/general.php");
	
	$objeto				=new general();		
	
	$retun=array();
	$comando_sql        ="
		INSERT INTO personal_cobertura		
		SELECT '',pa.plaza,p.puesto_id,p.puesto,pa.matricula,pa.nombre,p.turno,right(p.puesto_id,2)/10 as jor,p.horario_id, p.horario,                 
			case 
				when p.turno=1 OR p.turno=2 THEN '1.4'
				when p.turno=3 THEN '2.3' 
				when p.turno=5 THEN '3.5' 
			end as factor, '',
			case 
				when pa.concepto=29 then 'VAC' 
			end as motivo, '',

			case 
				when p.turno=1 OR p.turno=2 	THEN cantidad
				
				when p.turno=3 AND cantidad=7	THEN 4
				when p.turno=3 AND cantidad=8	THEN 5
				when p.turno=3 AND cantidad=9	THEN 5
				when p.turno=3 AND cantidad=10	THEN 6
				when p.turno=3 AND cantidad=11	THEN 7
				when p.turno=3 AND cantidad=12	THEN 7
				when p.turno=3 AND cantidad=13	THEN 8
				when p.turno=3 AND cantidad=14	THEN 8
				when p.turno=3 AND cantidad=15	THEN 9
				when p.turno=3 AND cantidad=16	THEN 10
				when p.turno=3 AND cantidad=17	THEN 10
				when p.turno=3 AND cantidad=18	THEN 11
				when p.turno=3 AND cantidad=19	THEN 11
				when p.turno=3 AND cantidad=20	THEN 12
				
				when p.turno=5 AND cantidad=7	THEN 3
				when p.turno=5 AND cantidad=8	THEN 3
				when p.turno=5 AND cantidad=9	THEN 4
				when p.turno=5 AND cantidad=10	THEN 4
				when p.turno=5 AND cantidad=11	THEN 4
				when p.turno=5 AND cantidad=12	THEN 5
				when p.turno=5 AND cantidad=13	THEN 5
				when p.turno=5 AND cantidad=14	THEN 6
				when p.turno=5 AND cantidad=15	THEN 6
				when p.turno=5 AND cantidad=16	THEN 6
				when p.turno=5 AND cantidad=17	THEN 7
				when p.turno=5 AND cantidad=18	THEN 7
				when p.turno=5 AND cantidad=19	THEN 8
				when p.turno=5 AND cantidad=20	THEN 8	
			end as dias
			
			,'',cantidad,u.departamento,p.departamento_id,p.departamento,'',''						
		FROM 
			personal_ausentismo pa JOIN 
			plazas p on p.clave=pa.plaza    JOIN
			(select distinct(departamento_id) as departamento_id, departamento FROM plazas WHERE departamento_id like '%0000') u 
				on left(p.departamento_id,6)=left(u.departamento_id,6)
		 
		ORDER BY puesto_id DESC, p.departamento DESC, cantidad DESC, turno ASC
	";	
	#echo $comando_sql;
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	
	

	$comando_sql        ="		
		TRUNCATE  personal_ausentismo;               
	";
	$data =$objeto->__EXECUTE($comando_sql, "DEVICE MODELO");	

	#echo json_encode($data);
?>
