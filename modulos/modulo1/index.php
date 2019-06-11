<?php	
	$objeto											=new modulo();		
	$objeto->__SESSION();
	$_SESSION["pdf"]["subject"]						="DIRECCION DE PRESTACIONES ECONOMICAS Y SOCIALES";
	
	#$objeto->__PRINT_R($_SESSION);
	
	# CARGANDO PLANTILLAS GENERALES
	$objeto->words["system_body"]               	=$objeto->__TEMPLATE($objeto->sys_html."system_body"); 		
	$objeto->words["system_module"]             	=$objeto->__TEMPLATE($objeto->sys_html."system_module");	
	
	# CARGANDO ARCHIVOS PARTICULARES		
	$objeto->words["html_head_js"]              	=$objeto->__FILE_JS();
		
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
		    #array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
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
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);		
		#CARGANDO VISTA PARTICULAR Y CAMPOS
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE();	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);

		
    	$module_title								="Modificar ";
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
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
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
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    #array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);
	
		#CARGANDO VISTA PARTICULAR Y CAMPOS
	   	$option=array();
    	$objeto->words["module_body"]               =$objeto->__VIEW_KANBAN($option);	
    }    
    else
    {
		#BOTONES SECCION DERECHA
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$option=array();
		$data										= $objeto->__REPORTE($option);		
		$objeto->words["module_body"]				=$data["html"];
		
		$module_title								="Reporte de ";
    }
	$module_right=array(
		array("create"=>"Crear"),			
		array("report"=>"Reporte"),		    
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
