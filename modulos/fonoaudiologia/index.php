<?php	
	$objeto											=new fonoaudiologia();		
	$objeto->__SESSION();
	$_SESSION["pdf"]["subject"]						="DIRECCION DE PRESTACIONES ECONOMICAS Y SOCIALES";
	
	#$objeto->__PRINT_R($_SESSION);
	
	# CARGANDO PLANTILLAS GENERALES
	$objeto->words["system_body"]               	=$objeto->__TEMPLATE($objeto->sys_html."system_body"); 		
	$objeto->words["system_module"]             	=$objeto->__TEMPLATE($objeto->sys_html."system_module");	
	
	# CARGANDO ARCHIVOS PARTICULARES		
	$objeto->words["html_head_js"]              	=$objeto->__FILE_JS(array("../".$objeto->sys_module."js/index"));
	#$objeto->words["html_head_css"]             	=$objeto->__FILE_CSS(array("../sitio_web/css/basicItems"));
		
	$module_left		="";	
	$module_right		="";	
	$module_center		="";	
	
	$module_title									="";
	
    if($objeto->sys_section=="create")
	{
		#BOTONES SECCION IZQUIERDA
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA
		$module_right=array(
		    #array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);
		
		$module_title								="Crear ";
    	$objeto->words["module_body"]               =$objeto->__VIEW_CREATE($objeto->sys_module . "html/create");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);    
    	
    }	
    elseif($objeto->sys_section=="write")
	{
		#BOTONES SECCION IZQUIERDA
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);

		if($objeto->__NIVEL_SESION("<=20")==true)	 // NIVEL ADMINISTRADOR 
		{
			$module_center=array(
				array("action_aprovar"=>"Aprovar"),
				array("action_cancelar"=>"Cancelar"),
			);	    			
		}		
		
		
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);		
		#CARGANDO VISTA PARTICULAR Y CAMPOS

		#$objeto->__PRINT_R($objeto->words["html_head_js"]);	
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/create");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);

		#$objeto->__PRINT_R($objeto->words["html_head_js"]);	

    		    							
		
		#$objeto->__GENERAR_PDF();

		
    	$module_title								="Modificar ";
    }	
    elseif($objeto->sys_section=="show")
	{
		#BOTONES SECCION IZQUIERDA
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);		
		#CARGANDO VISTA PARTICULAR Y CAMPOS
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/show");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    		    
    	$module_title								="Formato ";
    }	

	elseif($objeto->sys_section=="kanban")
	{
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    #array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);
	
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$template_body								=$objeto->sys_module . "html/kanban";
	   	$data										=$objeto->__BROWSE();
    	$objeto->words["module_body"]               =$objeto->__VIEW_KANBAN($template_body,$data["data"]);	
    }    
	/*
    elseif($objeto->sys_section=="sobres_patrones")
    {
		#CARGANDO VISTA PARTICULAR Y CAMPOS			

		$datas									= $objeto->__REPORT_CAR_REALIZADA();		
		$_SESSION["pdf"]["template"]			=array();
		
		
		foreach($datas["data"] as $data)
		{
			$_SESSION["pdf"]["template"][]=	array(
				"format"		=>array(104,241),					
				"html"			=>$objeto->__FORMATO_SOBRE($data["id"]),					
				"orientation"	=>"L",								
			);			
		}
		
    }    
	*/
    else
    {
		#BOTONES SECCION DERECHA
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$option["template_title"]	                = $objeto->sys_module . "html/report_title";
		$option["template_body"]	                = $objeto->sys_module . "html/report_body";
		
				
		$data										= $objeto->__REPORTE($option);		
		$objeto->words["module_body"]				=$data["html"];
		
		$module_title								="Reporte de ";
    }
	$module_right=array(
		array("create"=>"Crear"),			
		array("report"=>"Reporte"),		    
	/*	
		array("report_sol"=>"","icon"=>"ui-icon-caret-1-s", "title"=>"Solicitud de Incapacidades"),	
		array("report_dev"=>"","icon"=>"ui-icon-caret-1-n", "title"=>"Devolucion de Incapacidades"),	
		array("report_fs"=>"FS", "title"=>"Solicitud de F1 y F3 para calificacion"),		    		    
		array("report_no"=>"","icon"=>"ui-icon-closethick" , "title"=>"Calificada NO"),
		array("report_si"=>"","icon"=>"ui-icon-check" , "title"=>"Calificada SI"),
		array("report_carta_realizada"=>"","icon"=>"ui-icon-mail-closed" , "title"=>"Cartas Realizadas"),
	*/	
	);

	$boton_calificacion_si=array(		    
		array("action_si_trabajo"=>"SI DE TRABAJO"),	
		array("action_si_trayecto"=>"SI DE TRAYECTO"),	
		array("action_si_recaida"=>"SI DE RECAIDA"),	
	);
	$boton_calificacion_no=array(		    
		array("action_no_trabajo"=>"NO DE TRABAJO"),	
		array("action_no_trayecto"=>"NO DE TRAYECTO"),			
		array("action_no_recaida"=>"NO DE RECAIDA"),			
	);
	
    
	$objeto->words["module_title"]              ="$module_title Incapacidades";
	$objeto->words["fecha_impresion"]           =$objeto->sys_date;
	
	$_SESSION["pdf"]["sys_titulo"]				="DIRECCION DE PRESTACIONES ECONOMICAS Y SOCIALES";
	$_SESSION["pdf"]["sys_subtitulo"]			="COORDINACION DE SALUD EN EL TRABAJO";
	
	$objeto->words["asunto_edificio"]			="UNIDAD DE MEDICINA FAMILIAR No 17";
	$objeto->words["pie_titular"]				="<b>DRA CINTHIA ZULEMA DIAZ</b>";
	$objeto->words["pie_puesto"]				="MEDICO DE SALUD EN EL TRABAJO";
	$objeto->words["pie_edificio"]				=$objeto->words["asunto_edificio"];
	
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             =$objeto->__BUTTON($module_center);
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
	$objeto->words["botones_calificacion_si"]   =$objeto->__BUTTON($boton_calificacion_si);
	$objeto->words["botones_calificacion_no"]   =$objeto->__BUTTON($boton_calificacion_no);
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS	 :: {$objeto->words["module_title"]}";
    
	
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
?>
