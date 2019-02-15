<?php
	$objeto											=new groups();	
	$objeto->__SESSION();

	$objeto->words["system_body"]               	=$objeto->__TEMPLATE($objeto->sys_html."system_body"); 			# TEMPLATES ELEJIDOS PARA EL MODULO
	$objeto->words["system_module"]             	=$objeto->__TEMPLATE($objeto->sys_html."system_module");
	
	$objeto->words["html_head_js"]              	=$objeto->__FILE_JS(array("../".$objeto->sys_module."js/index"));
	#$objeto->words["html_head_css"]             	=$objeto->__FILE_CSS(array("../sitio_web/css/basicItems"));
	
	$module_title									="";
    if($objeto->sys_section=="create")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		$module_right=array(
		    #array("create"=>"Crear"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);

		$module_title								="Crear ";
    	$objeto->words["module_body"]               =$objeto->__VIEW_CREATE($objeto->sys_module . "html/create");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);    
    	
    	#$objeto->words["permisos"]	            	=$objeto->permiso_ids_obj->permisos_html();
    }	
    elseif($objeto->sys_section=="write")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		$module_right=array(
		    #array("create"=>"Crear"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);

    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/write");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    	$module_title								="Modificar ";
    	    	
    	$objeto->words["permisos"]	            	=$objeto->permiso_ids_obj->permisos_html($objeto->sys_fields["permiso_ids"]["values"]);
    }	
	elseif($objeto->sys_section=="kanban")
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);
	
		$template_body								=$objeto->sys_module . "html/kanban";
	   	$data										=$objeto->__BROWSE();
    	$objeto->words["module_body"]               =$objeto->__VIEW_KANBAN($template_body,$data["data"]);	
    }    
	else
	{
		$module_left=array(
		    array("action"=>"Guardar"),
		    array("cancel"=>"Cancelar"),
		);
		$module_right=array(
		    array("create"=>"Crear"),
		    array("kanban"=>"Kanban"),
		    #array("report"=>"Reporte"),
		);

		$option=array();

		$option["template_title"]	                = $objeto->sys_module . "html/report_title";
		$option["template_body"]	                = $objeto->sys_module . "html/report_body";
		
		$data										=$objeto->__VIEW_REPORT($option);
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }    
    
	$objeto->words["module_title"]              ="$module_title Grupos";
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             ="";
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);;
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
