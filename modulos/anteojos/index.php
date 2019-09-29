<?php	
	$objeto											=new anteojos();		
	$objeto->__SESSION();
	#$objeto->__PRINT_R($_SESSION);
	
	# CARGANDO PLANTILLAS GENERALES
	$objeto->words["system_body"]               	=$objeto->__TEMPLATE($objeto->sys_html."system_body"); 		
	$objeto->words["system_module"]             	=$objeto->__TEMPLATE($objeto->sys_html."system_module");	
	
	# CARGANDO ARCHIVOS PARTICULARES		
	$objeto->words["html_head_js"]              	=$objeto->__FILE_JS();
	#$objeto->words["html_head_css"]             	=$objeto->__FILE_CSS(array("../sitio_web/css/basicItems"));
		
	$module_left		="";	
	$module_right		="";	
	$module_center		="";	
	
	$module_title									="";
	
  	if($objeto->sys_private["section"]=="create")
	{
		#BOTONES SECCION IZQUIERDA
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);
		
		$module_title								="Crear ";
    	$objeto->words["module_body"]               =$objeto->__VIEW_CREATE();	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);    
    	
    }	

    elseif($objeto->sys_private["section"]=="write")
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
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);
		#CARGANDO VISTA PARTICULAR Y CAMPOS
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE();
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
	    
    	$module_title								="Modificar ";		
    }	
	elseif($objeto->sys_private["section"]=="graph")
	{
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);
	
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		
		$data												=$objeto->__VIEW_GRAPH();		
		$objeto->words["module_body"]						=$data["html"];
    }    
    elseif($objeto->sys_private["section"]=="show")
	{
		#BOTONES SECCION IZQUIERDA
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);
		#CARGANDO VISTA PARTICULAR Y CAMPOS
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE();	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    		    
    	$module_title								="Formato ";
    }	

	elseif($objeto->sys_private["section"]=="kanban")
	{
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		
		$option=array();		
    	$option										=$objeto->__REPORT_ANTEOJOS($option);
		$data										=$objeto->__VIEW_KANBAN($option);		
		$objeto->words["module_body"]				=$data["html"];
    }    
    else
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"	=>"Crear"),
		    #array("write"	=>"Modificar"),
		    array("kanban"	=>"Kanban"),
		    array("graph"	=>"Grafica"),
		    array("report"	=>"Reporte"),		    
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$option=array();
		
		if($objeto->__NIVEL_SESION("<=20")==true)	 // NIVEL ADMINISTRADOR 
		{
			$option["template_title"]	=$objeto->sys_var["module_path"]."html/medico/report_title";
			$option["template_body"]	=$objeto->sys_var["module_path"]."html/medico/report_body";			
		}
		if($objeto->__NIVEL_SESION(">=50")==true)	 // NIVEL MEDICO  
		{
			$option["template_title"]	=$objeto->sys_var["module_path"]."html/personal/report_title";
			$option["template_body"]	=$objeto->sys_var["module_path"]."html/personal/report_body";			
		}


		$data										= $objeto->__VIEW_REPORT($option);		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }
    

    if($objeto->__NIVEL_SESION("<=20")==true)	 // NIVEL ADMINISTRADOR 
    {
    	$module_right_admin=array(
		    array("report_pendiente"=>"","icon"=>"ui-icon-help"),
		    array("report_cancelados"=>"","icon"=>"ui-icon-closethick"),
		    array("report_aprovados"=>"","icon"=>"ui-icon-check"),
		);	    
		$module_right=array_merge($module_right, $module_right_admin);		
	/*	
	}
    if($objeto->__NIVEL_SESION("<=10")==true)   // NIVEL SUPER ADMINISTRADOR
    {
		*/
    	$module_right_admin=array(
		    array("report_especifico"=>"R Esp."),
		    array("report_general"=>"R Gral."),
		);	    
		$module_right=array_merge($module_right, $module_right_admin);		
	}

    
	$objeto->words["module_title"]              ="$module_title Anteojos";
	
	
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             =$objeto->__BUTTON($module_center);
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS	 :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
?>
