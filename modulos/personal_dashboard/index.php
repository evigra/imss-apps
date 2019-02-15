<?php	
	$objeto											=new personal_dashboard();		
	#$objeto->personal_licencia						=new personal_licencia();
	#$objeto->personal_acs							=new personal_acs();
	$objeto->__SESSION();
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
	
	
	#CARGANDO VISTA PARTICULAR Y CAMPOS
	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/show");	
	$objeto->words["reporte_txt"]				=$objeto->__REPORT_TXT();
	$objeto->words["reporte_licencia"]			=$objeto->__REPORT_LICENCIA();
	$objeto->words["reporte_pase"]				=$objeto->__REPORT_PASE();
	$objeto->words["reporte_calculo"]				=$objeto->__REPORT_CALCULO();
	
	
	#$objeto->__PRINT_R($objeto->words["reporte_txt"]);
	
	
	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    		    
    	
  
    
	$objeto->words["module_title"]              ="$module_title DASHBOARD";
	
	
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             =$objeto->__BUTTON($module_center);
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS	 :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
?>
