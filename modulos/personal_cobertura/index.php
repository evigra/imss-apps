<?php	
	$objeto											=new personal_cobertura();
	$objeto->__SESSION();
	
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

	$module_center=array(
		array("action_process"=>"CERRAR QUINCENA"),
	);    

    if($objeto->sys_section=="write")
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
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/write");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    		    
    	$module_title								="Modificar ";
    }	
	elseif($objeto->sys_section=="report_special")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		$data										= $objeto->__REPORT_SPECIAL();
		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }    
	elseif($objeto->sys_section=="report_colima")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA

		$data										= $objeto->__REPORT_COLIMA();
		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }    
	elseif($objeto->sys_section=="report_manzanillo")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA

		$data										= $objeto->__REPORT_MANZANILLO();
		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }    
	elseif($objeto->sys_section=="report_tecoman")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		#BOTONES SECCION DERECHA

		$data										= $objeto->__REPORT_TECOMAN();
		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }    

    else
    {


		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$option=array();
		$option["template_title"]	                = $objeto->sys_module . "html/report_title";
		$option["template_body"]	                = $objeto->sys_module . "html/report_body";
		#$option["echo"]	          	      = "REPORT ";
				
		$data										= $objeto->__VIEW_REPORT($option);
		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
		
		$module_center=array(

		);    
		
		
    }

		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("report"=>"Reporte"),
			array("report_special"		=>"Reporte"),
			array("report_colima"		=>"COLIMA"),
			array("report_manzanillo"	=>"MANZANILLO"),
			array("report_tecoman"	=>"TECOMAN"),
		);


    
	$objeto->words["module_title"]              ="$module_title Cobertura";
	
	
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             =$objeto->__BUTTON($module_center);
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS	 :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
?>
