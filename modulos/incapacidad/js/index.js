	
	$(document).ready(function()
	{	
		$("input.personal_cptos1vez").focusout(function() 
		{		
			calculo_cptos1vez();
		});
		

		$("input#con.personal_cptos1vez").focusout(function() 
		{		
			var seccion_plaza="";	
			if($("#che_plaza").prop('checked')!=true)
			{
				seccion_plaza="";
			}
			else			
			{
				seccion_plaza="_1";
			}			
			$.ajax({
				type: 'GET',
				url: '../modulos/reglas/ajax/index.php',
				contentType:"application/json",
				data:"&concepto="+$(this).val(),				
				success: function (response) 
				{
					var existe=0;
					var obj = $.parseJSON( response);
					$("div#cptos1vez_descripcion").html("");
					for(i_obj in obj)
					{
						
						$("div#cptos1vez_descripcion").html(obj[i_obj].descripcion);
						if(obj[i_obj].campo=="importe")		
						{	
							$("input#imp.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#imp.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							if(obj[i_obj].accion=="1")	$("input#imp.personal_cptos1vez").val("1");
							if(obj[i_obj].accion=="0")	$("input#imp.personal_cptos1vez").val("0");							
							existe=1;
						}	
						if(obj[i_obj].campo=="unidades")		
						{	
							$("input#uni.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#uni.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							//if(obj[i_obj].accion=="1")	$("#unidades_"+grupo).val("1");
							existe=1;
						}						
						if(obj[i_obj].campo=="jorgrup")		
						{	
							$("input#jor.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#jor.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							if(obj[i_obj].accion=="JORNADA LABORADA 6.5 8")	
							{	
								var puesto	=$("#trabajador_puesto_id" + seccion_plaza).val();
								var varrUrl	=puesto.substr(-2) / 10;
								$("input#jor.personal_cptos1vez").val( varrUrl ) ;
							}	
							if(obj[i_obj].accion=="SIN DATO")		$("input#jor.personal_cptos1vez").val("") ;
							existe=1;
						}	
						if(obj[i_obj].campo=="diagrup")		
						{	
							$("input#dia.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#dia.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							if(obj[i_obj].accion=="SUELDO TABULAR DIARIO")	
							{	
								var sueldo	=$("#sueldo" + seccion_plaza).val();	
								var diario=sueldo/15;																
								var diario=sueldo/30;								
								diario=parseInt(diario*100)/100;
								$("input#dia.personal_cptos1vez").val( diario ) ;
							}	
							if(obj[i_obj].accion=="SUELDO -CONCEPTO 11 DIARIO")	
							{	
								var sueldo		=$("#sueldo" + seccion_plaza).val();										
								var concepto11	=sueldo*.5405

								var diario		=concepto11/15;								
								diario			=sueldo-diario;								
								diario=parseInt(diario*100)/100;
								$("input#dia.personal_cptos1vez").val( diario ) ;
							}	

							if(obj[i_obj].accion=="BASE 8")		$("input#dia.personal_cptos1vez").val( $("#b8" + seccion_plaza).val() ) ;
							if(obj[i_obj].accion=="BASE 5")		$("input#dia.personal_cptos1vez").val( $("#b5" + seccion_plaza).val() ) ;
							if(obj[i_obj].accion=="BASE 4")		$("input#dia.personal_cptos1vez").val( $("#b4" + seccion_plaza).val() ) ;
							if(obj[i_obj].accion=="BASE 2")		$("input#dia.personal_cptos1vez").val( $("#b2" + seccion_plaza).val() ) ;
						}							
						if(obj[i_obj].campo=="factor67")		
						{								
							$("input#fac.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#fac.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							if(obj[i_obj].accion=="SIN DATO")		$("#fac").val("") ;
							if(obj[i_obj].accion=="EL QUE CORRESPONDA 1.4, 2.3, 3.5")													  
							{								
								if($("#turno" + seccion_plaza).val()==1)	$("input#fac.personal_cptos1vez").val("1.4") ;
								if($("#turno" + seccion_plaza).val()==2)	$("input#fac.personal_cptos1vez").val("1.4") ;
								if($("#turno" + seccion_plaza).val()==3)	$("input#fac.personal_cptos1vez").val("2.3334") ;
								if($("#turno" + seccion_plaza).val()==5)	$("input#fac.personal_cptos1vez").val("3.5") ;
							}	
							if(obj[i_obj].accion=="P/ DEVOLVER 1, 1.67, 2.5")		
							{
								if($("#turno" + seccion_plaza).val()==1)	$("input#fac.personal_cptos1vez").val("1");
								if($("#turno" + seccion_plaza).val()==2)	$("input#fac.personal_cptos1vez").val("1");
								if($("#turno" + seccion_plaza).val()==3)	$("input#fac.personal_cptos1vez").val("1.67");
								if($("#turno" + seccion_plaza).val()==5)	$("input#fac.personal_cptos1vez").val("2.5");
							}		
							if(obj[i_obj].accion=="MENOR 1, 1.67, 2.5 MAYOR 1.4, 2.3, 3.5")		
							{
								if($("#unidades_"+grupo).val()<=3)
								{	
									if($("#turno" + seccion_plaza).val()==1)	$("input#fac.personal_cptos1vez").val("1");
									if($("#turno" + seccion_plaza).val()==2)	$("input#fac.personal_cptos1vez").val("1");
									if($("#turno" + seccion_plaza).val()==3)	$("input#fac.personal_cptos1vez").val("1.67");
									if($("#turno" + seccion_plaza).val()==5)	$("input#fac.personal_cptos1vez").val("2.5");
								}
								else								
								{
									if($("#turno" + seccion_plaza).val()==1)	$("input#fac.personal_cptos1vez").val("1.4");
									if($("#turno" + seccion_plaza).val()==2)	$("input#fac.personal_cptos1vez").val("1.4");
									if($("#turno" + seccion_plaza).val()==3)	$("input#fac.personal_cptos1vez").val("2.3334");
									if($("#turno" + seccion_plaza).val()==5)	$("input#fac.personal_cptos1vez").val("3.5");									
								}		
								existe=1;
							}							
						}	
						if(obj[i_obj].campo=="base22")		
						{	
							$("input#bas.personal_cptos1vez").attr({'title':obj[i_obj].accion});
							$("input#bas.personal_cptos1vez").attr({'placeholder':obj[i_obj].accion});
							if(obj[i_obj].accion=="SIN DATO")		$("input#bas.personal_cptos1vez").val("") ;			
							if(obj[i_obj].accion=="BASE 9")			
							{								
								$("input#bas.personal_cptos1vez").val( $("#b9" + seccion_plaza).val() ) ;							
							}	
							existe=1;
						}	
						
					}
					if(existe==0)
					{	
						$("input#bas.personal_cptos1vez").val( "" );
						$("input#fac.personal_cptos1vez").val( "" );
						$("input#dia.personal_cptos1vez").val( "" );
						$("input#jor.personal_cptos1vez").val( "" );
						$("input#uni.personal_cptos1vez").val( "" );
						$("input#imp.personal_cptos1vez").val( "" );
						$("input#con.personal_cptos1vez").focus();
						//alert("El concepto no existe");
					}	
					calculo_cptos1vez();
					//$("#imp").focus();
				}
			});
			
		});	
		
		if($("#agregar3").length>0) 
		{
			$("#agregar3")
				.button()
				.click(function()
				{

					agregar3();				
				}
			);			
		}		
        $("input#cif.personal_cptos1vez").on('keydown', function (e) 
		{			
            if (e.keyCode == 13) 
			{						
				$("font#agregar3").focus();

					agregar3();				
				
			}	
        });


		
    });
	
	
	
	function agregar3(option)
	{
		$("#con").focus();	
	}
    
    // ###########################################################################
    // ######################### FUNCIONES #######################################
    // ###########################################################################
	function calculo_cptos1vez()
	{
		var total=0;
		
		if(!isNaN(parseFloat($("#con.personal_cptos1vez").val())))		total=total+parseFloat($("#con.personal_cptos1vez").val());		
		
		if(!isNaN(parseFloat($("#imp.personal_cptos1vez").val())))		total=total+parseFloat($("#imp.personal_cptos1vez").val());		
		
		if(!isNaN(parseFloat($("#uni.personal_cptos1vez").val())))		total=total+parseFloat($("#uni.personal_cptos1vez").val());		
		
		if(!isNaN(parseFloat($("#dia.personal_cptos1vez").val())))		total=total+parseFloat($("#dia.personal_cptos1vez").val());		
		
		if(!isNaN(parseFloat($("#jor.personal_cptos1vez").val())))		total=total+parseFloat($("#jor.personal_cptos1vez").val());
		
		
		total=parseInt(Math.round(total*100))/100;								
		
		//total=parseInt(parseFloat(total*100))/100;		
		$("#cif.personal_cptos1vez").val(total);
	}	
