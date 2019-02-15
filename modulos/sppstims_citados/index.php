<?php	
	$objeto											=new sppstims_citados();		
	#$objeto->personal_licencia						=new personal_licencia();
	#$objeto->personal_acs							=new personal_acs();
	$objeto->__SESSION();
	#$objeto->__PRINT_R($_SESSION);
	
	# CARGANDO PLANTILLAS GENERALES
	$objeto->words["system_body"]               	=$objeto->__TEMPLATE($objeto->sys_html."system_body"); 		
	$objeto->words["system_module"]             	=$objeto->__TEMPLATE($objeto->sys_html."system_module");	
	
	# CARGANDO ARCHIVOS PARTICULARES		
	$objeto->words["html_head_js"]              	=$objeto->__FILE_JS(
		array("../".$objeto->sys_module."js/index")
	);
	
	
	
	#$objeto->words["html_head_css"]             	=$objeto->__FILE_CSS(array("../sitio_web/css/basicItems"));
		
	$module_left		="";	
	$module_right		="";	
	$module_center		="";	
	
	$module_title									="";
	
	$module_left=array(
		array("report_actual"=>"Actual","title"=>"Reporte Mensual Actual","icon"=>"ui-icon-note" ),
		array("report_acterior"=>"Anterior","title"=>"Reporte Mensual Anterior","icon"=>"ui-icon-note"),
	);
	
	$fecha = new DateTime(date("Y-m-d"));

	$fecha->sub(new DateInterval('P1D'));
	$a1=	$fecha->format('d');						
	
	$fecha->add(new DateInterval('P2D'));
	$m1=	$fecha->format('d');			
	$fecha->add(new DateInterval('P1D'));
	$m2=	$fecha->format('d');			
	$fecha->add(new DateInterval('P1D'));
	$m3=	$fecha->format('d');			
	$fecha->add(new DateInterval('P1D'));
	$m4=	$fecha->format('d');			
	$fecha->add(new DateInterval('P1D'));
	$m5=	$fecha->format('d');	
	
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
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"		=>"Reporte"),
			array("calendar"	=>"Vista Calendario"),		    
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
				array("action_aprovar"=>"Aprobar", "title"=>"Aprobar documento solicitado"),
				array("action_cancelar"=>"Cancelar", "title"=>"Cancelar documento solicitado"),
			);	    			
		}			
		
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);		
		#CARGANDO VISTA PARTICULAR Y CAMPOS
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/write");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);

		$objeto->__FORMATO();
		
    	$module_title								="Modificar ";
    }	
    elseif($objeto->sys_section=="citas")
	{
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/write");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);

		$objeto->__FORMATO();
    }		
    elseif($objeto->sys_section=="interconsulta")
	{
    	$objeto->words["module_body"]               =$objeto->__VIEW_WRITE($objeto->sys_module . "html/write");	
    	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);

		$objeto->__FORMATO_INTERCONSULTA($objeto->sys_section);
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
			array("report_pendientes_lab"=>"Pendientes Laboratorio"),
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
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);
	
		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$template_body								=$objeto->sys_module . "html/kanban";
	   	$data										=$objeto->__BROWSE();
    	$objeto->words["module_body"]               =$objeto->__VIEW_KANBAN($template_body,$data["data"]);	
    }    
    elseif($objeto->sys_section=="report_hoy")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_HOY();		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="HOY ";
    }    
    elseif($objeto->sys_section=="report_m2")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_MANANA(array("manana"=>$m2));		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    }    
    elseif($objeto->sys_section=="report_m3")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_MANANA(array("manana"=>$m3));		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    }    
    elseif($objeto->sys_section=="report_m4")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_MANANA(array("manana"=>$m4));		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    } 
    elseif($objeto->sys_section=="report_pendientes_lab")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_PEND_LAB(array("manana"=>$m5));		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    } 

    elseif($objeto->sys_section=="report_m5")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_MANANA(array("manana"=>$m5));		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    } 
    elseif($objeto->sys_section=="report_manana")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);
		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_MANANA();		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="MAÑANA ";
    }	
	
	
    elseif($objeto->sys_section=="report_ayer")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_AYER();		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="AYER ";
    }    

    elseif($objeto->sys_section=="report_general")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_GENERAL();		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte General de ";
    }
    elseif($objeto->sys_section=="report_pendiente")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_PENDIENTE();
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de Pendientes de ";
    }
    elseif($objeto->sys_section=="report_aprovados")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_APROVADO();
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte Aprobados de ";
    }
	
    elseif($objeto->sys_section=="report_cancelados")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_CANCELADOS();
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de Cancelados de ";
    }    
    elseif($objeto->sys_section=="report_actual")
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("kanban"=>"Kanban"),
		    array("report"=>"Reporte"),
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS			
		$data										= $objeto->__REPORT_ACTUAL();
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de Cancelados de ";
    }    

    else
    {
		#BOTONES SECCION DERECHA
		$module_right=array(
		    array("create"		=>"Crear"),
		    #array("write"=>"Modificar"),
		    array("report_pendientes_lab"=>"Pendientes Laboratorio"),
		    array("report"		=>"Vista Reporte"),		    
			
		);

		#CARGANDO VISTA PARTICULAR Y CAMPOS
		$option["template_title"]	                = $objeto->sys_module . "html/report_title";
		$option["template_body"]	                = $objeto->sys_module . "html/report_body";
		
				
		$data										= $objeto->__REPORTE($option);		
		$objeto->words["module_body"]				=$data["html"];
		$module_title								="Reporte de ";
    }
    

    if($objeto->__NIVEL_SESION("<=20")==true)	 // NIVEL ADMINISTRADOR 
    {
		/*	
    	$module_right_admin=array(
		    array("report_pendiente"=>"","icon"=>"ui-icon-help", "title"=>"Pendientes"),
		    array("report_cancelados"=>"","icon"=>"ui-icon-closethick", "title"=>"Cancelados"),
		    array("report_aprovados"=>"","icon"=>"ui-icon-check", "title"=>"Aprobados"),
		);	    
		$module_right=@array_merge(@$module_right, @$module_right_admin);		
	*/
	}
	
    if($objeto->__NIVEL_SESION("<=10")==true)   // NIVEL SUPER ADMINISTRADOR
    {			
		

    	$module_center=array(
			array("report_ayer"		=>"$a1"),
		    array("report_hoy"		=>"HOY", "icon"=>"ui-icon-calendar","title"=>"Reporte Hoy"),
		    array("report_manana"	=>"$m1", ),
			array("report_m2"		=>"$m2"),
			array("report_m3"		=>"$m3"),
			array("report_m4"		=>"$m4"),
			array("report_m5"		=>"$m5"),
		);	    
	}

    $module_citas=array(   
		array("citas"			=>"Solicitud de citas","icon"=>"ui-icon-note"),
		array("bot_laboratorio"	=>"Examenes de laboratorio","icon"=>"ui-icon-note")
	);
	
	$objeto->words["boton_citas"]              =$objeto->__BUTTON(  $module_citas  );


    $module_citas=array(   
		array("enviar_interconsulta"			=>"Enviar InsterConsulta",	"icon"=>"ui-icon-note"),		
	);	
	$objeto->words["boton_interconsultas"]     =$objeto->__BUTTON(  $module_citas  );
	
	
	
	$objeto->words["module_title"]              ="$module_title Citados SPPSTIMSS";
	
	
	
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             =$objeto->__BUTTON($module_center);
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="IMSS	 :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
?>
