
	var grupo;
	var map;
	var geocoder;
	var gMEvent				=undefined;

	var flightPath			=undefined;	
	var lineas				=new Array();
	var linea;
	
	var localizacion;		
	var localizaciones			=new Array();
	var localizacion_anterior;
	var vehicle_data			=new Array();
	var locationsMarker 		=new Array();
	var infoGeofences 			=new Array();
	var showGeofences 			=0;
	var device_active			=0;
	var device_random			=0;
	var coordinate_active		=undefined;
	var simulation_action		="stop";
	var simulation_time			=100;
	var waypts					=new Array();
	var devices_all				=new Array();	
	var many2one_data			=new Array();
	var row						={};
	
	


	/*
	##################################################################
  	### FUNCIONES ESTANDAR
	##################################################################
	*/
	function many2one_get(options)
	{								
		class_one		=options["class_one"];
		class_one_id	=options["class_one_id"];
		
		class_field		=options["class_field"];
		class_field_id	=options["class_field_id"];
		
		class_many		=options["class_many"];
		object			=options["object"];
				
		row["sys_action"]="__SAVE";
		var options_row={
			"class_one":		class_one, 	
			"class_one_id":		class_one_id, 	
			"class_field":		class_field, 
			"class_field_id":	class_field_id, 			
		};				
		$.ajax(
		{				
			cache:			false,				
			type: 			"GET",  				
			url: 			"../sitio_web/ajax/many2one_get.php",
			data:			{"many2one_json":JSON.stringify(options_row)},														
			success:  function(res)
			{	
				$("#script").html(res);
				
			},		
		});			
	}	
	function many2one_post(options)
	{	
		class_one		=options["class_one"];
		class_one_id	=options["class_one_id"];
		class_field		=options["class_field"];
		class_field_id	=options["class_field_id"];
		class_id		=options["id"];
		class_many		=options["class_many"];
		object			=options["object"];		
				
		
		var require="";				
		$("." + class_field).each(function()
		{
			var id			=$(this).attr("id");			
			row[id]		=$(this).val();	 			
			
			if($(this).val()== "")
			{				
				if($("#"+id+"[class*='require']").length>0)
				{						
					require="require";
				}			
			}		
		});
		if(require=="")		
		{	
			$("div#create_"+ class_field +" ."+class_field).val("");
						
			row["sys_action"]="__SAVE";
			
			var options_row={
				"class_one":		class_one, 	
				"class_one_id":		class_one_id, 	
				"class_field":		class_field, 			
				"class_field_id":	class_field_id, 
				"class_id":			class_id, 
				"class_many":		class_many,									
				"objet":			object, 												
				"row":				row, 
			};		
			
			$.ajax(
			{				
				cache:			false,				
				type: 			"GET",  				
				url: 			"../sitio_web/ajax/many2one.php",
				data:			{"many2one_json":JSON.stringify(options_row)},														
				success:  function(res)
				{										
					$("#base_"+class_field).html(res);					
				},		
			});						
		}	
		else
		{
			alert("Verifica que los cambos no esten vacios");	
		}	
	}	
	function many2one_report(object, template)
	{				
		if($("td[id='"+ object+"']").html()==undefined)
		{				
			$.ajax(
			{				
				cache:false,
				dataType:"html",
				type: "POST",  
				url: "../"+ template+"report_title.html",
				success:  function(res)
				{											
					$("table[id='"+ object+"']").append(res);
				},		
			});
			$.ajax(
			{				
				cache:false,
				dataType:"html",
				type: "POST",  
				url: "../"+ template+"report_body.html",
				success:  function(res)
				{						
					$("table[id='"+ object+"']").append(res);
				},		
			});
			
		}		
		
	}	
		function sys_report_memory()
		{	
			if($(".sys_report_memory").length>0) 
			{
				$(".sys_report_memory").click(function()
				{					
					
					var class_field_id			=$(this).attr("class_field_id"); 
					var id						=$(this).attr("id"); 
					
					var class_field				=$(this).attr("class_field"); 
					
					var data        			=$(this).attr("data");               
					var variables				=serializar_url(data);
					
					var class_one 				=$(this).attr("class_one");     

					var options					={};				
					options["class_one"]		=class_one;
					//options["class_one_id"]		=class_one_id;
					options["class_field"]		=class_field;
					options["class_field_id"]	=class_field_id;
					options["id"]				=id;
					
					options["object"]			=class_one;
					options["class_many"]		=class_one;						
										
					many2one_get(options);
					
					
					
					$("div#create_"+ class_field).dialog({
						open: function(event, ui){
							var dialog = $(this).closest('.ui-dialog');
						},
						buttons: {
							"Registrar y Cerrar": function() {																			
								many2one_post(options);
								$( this ).dialog("close");
							},
							"Cerrar": function() {
								$( this ).dialog("close");
							}
						},										
						width:"700px"
					});				
					
				
					for(ivariables in variables)
					{
						var input="";
						if($("input#"+ivariables).length>0) {}
						else	
						{	
							input="<input id=\""+ivariables+"\" name=\""+ivariables+"\" type=\"hidden\">";						
							$("form").append(input);
						}			
					}	

				});
			}	   		
		}	
	
		
	function tracert(origen, destino,puntos)
	{			
		var directionsDisplay;
		var directionsService;
		var distanceMatrixService;
	
		directionsService=new google.maps.DirectionsService();
		directionsDisplay=new google.maps.DirectionsRenderer();
		//distanceMatrixService 	= new google.maps.DistanceMatrixService;
			
		var request = {
			origin: 		origen,
			destination: 	destino,
			travelMode: 	google.maps.DirectionsTravelMode["DRIVING"],
			unitSystem: 	google.maps.DirectionsUnitSystem["METRIC"],
		};		
		if(puntos!=undefined)		
		{		
			if(puntos.length>0)		
				request["waypoints"]=puntos;
		}			
		//for(d in directionsService)
		{
			directionsService.route(request, function(response, status) 
			{
				if (status == google.maps.DirectionsStatus.OK) 
				{
						directionsDisplay.setMap(map);
						//directionsDisplay.setPanel($("div#text").get(0));
						directionsDisplay.setDirections(response);
								
						if($("div#text.instrucciones").length>0) 
						{
							setTimeout(function()
							{  				
								$("div#text.instrucciones").html(ruta_pasos(directionsDisplay["directions"]["routes"][0]["legs"]));
								$("input#description").val($("div#text.instrucciones").html());
								
								
							},200);	
						}	
				} 
				else 	alert("No existen rutas entre ambos puntos");
			});
		}	
	}
	function ruta_pasos(datos)
	{		
		var tr="";
		var distancia=0;
		var tiempo=0;
		for(d in datos)
		{				
			pasos=datos[d]["steps"];
			distancia	=distancia + datos[d]["distance"]["value"];
			tiempo		=tiempo + datos[d]["duration"]["value"];
			tr=tr+"<tr><td colspan='3' height='20'></td></tr>";
			tr=tr+"<tr><td colspan='2' height='40'>"+datos[d]["start_address"]+"</td><td colspan='1'>"+datos[d]["distance"]["text"]+"</td><td>"+datos[d]["duration"]["text"]+"</td><td></td></tr>";
			for(p in pasos)
			{
				var instruccion=parseInt(p)+1;
				tr=tr+"<tr><td width='50'>"+instruccion+"</td><td>"+pasos[p]["instructions"]+"</td><td  width='80'>"+pasos[p]["distance"]["text"]+"</td><td width='140'>"+pasos[p]["duration"]["text"]+"</td></tr>";
			}
		}	
		var metros		=distancia;
		var kilometros	="";
		var minutos		=parseInt(tiempo/60);
		var duracion	="";
		var recorrido	="";
		if(distancia/1000>0)
		{
			kilometros	=parseInt(distancia/1000);
			var metros	=distancia % 1000;
			kilometros= kilometros + " Km(s) ";			
		}
		recorrido= kilometros + metros + " Metro(s)";
		
		if(minutos>59)
		{
			var horas=minutos/60;	
			var minutos=(minutos % 60);
			horas=parseInt(horas);			
			duracion= horas + " Hora(s) ";
		}
		duracion= duracion + minutos + " Minuto(s)";
		
		$("input#tiempo.formulario").val(duracion);
		$("input#distancia.formulario").val(recorrido);
		
		
		return "<table width='100%'>"+tr+"</table>";
	}
	
	function foreach_anidado(datos)
	{
		var ret="";
		for(i in datos)
		{	
			//path,lat_lngs,instructions,distance,text,value,duration
			//if(i=="path" || i=="lat_lngs" || i=="instructions" || i=="distance" || i=="text" || i=="value" || i=="duration")
			
						
			if(i=="instructions" || i=="text")
			{
				ret=ret + "<td>" + datos[i] +"</td>";			
			}	
			if(typeof datos[i]=="object")
			{
				var dat=foreach_anidado(datos[i]);
				if(dat!="")
					ret=ret + "<tr>" + dat + "</tr>";
			}	
		}		
		return ret;		
	}
	function serializar_url(url)
	{
		var arrUrl 	= url.split("&");
		var varrUrl	= arrUrl.splice(0, 1); 
		
		var urlObj	={};   
		for(var i=0; i<arrUrl.length; i++)
		{
			var x			= arrUrl[i].split("=");			
			urlObj[x[0]]	=x[1]
		}
		return urlObj;	
	}	
	function getVarsUrl()
	{
		var url		= location.search.replace("?", "");
		
		var url		= location.href;		
		var arrUrl 	= url.split("&");
		var varrUrl	= arrUrl.splice(0, 1); 
		
		var urlObj	={};   
		for(var i=0; i<arrUrl.length; i++)
		{			
			if(arrUrl[i].indexOf('=') != -1)
			{
				var x			= arrUrl[i].split("=");
				urlObj[x[0]]	=x[1]
			}

		}
		return urlObj;		
		/*
		$("#action").button({
			icons: {	primary: "ui-icon-document" },
			text: true
		    })
		    .click(function()
		    {
				var variables=getVarsUrl();
				var str_url="";
				for(ivariables in variables)
				{
					if(ivariables=="sys_action")	str_url+="&"+ivariables+"=__SAVE";
					else							str_url+="&"+ivariables+"="+ variables[ivariables];
				}		        
				$("form")
					.attr({"action":str_url})
					.submit();		        
		    }
	    );
		*/
	}
	function showGeofence()
	{
		if(infoGeofences.length>0) 
		{			
			if(map.getZoom() > 7)
			{
				if(showGeofences==0)
				{
					showGeofences=1;
					for(iG in infoGeofences)
					{				
						var obj_igeo=infoGeofences[iG];				
						obj_igeo.info.open(map,obj_igeo.geofence);
					}
				}	
			}
			else
			{
				if(showGeofences==1)
				{
					showGeofences=0;
					for(iG in infoGeofences)
					{				
						var obj_igeo=infoGeofences[iG];				
						obj_igeo.info.close();
					}
				}				
			}	
		}					
	}
	function action_cancel()
	{
		$("#cancel").button({
			icons: {	primary: "ui-icon-closethick" },
			text: true
		    })
		    .click(function(){


		    }
	    );
	}
	
	function filter_html(field,title,term,name)
	{			
		var filter="\
			<td id=\"" + field + "_" + term + "\" valign=\"middle\">\
				<table height=\"28\">\
					<tr>\
						<td style=\"background-color:#555; color:#fff; padding-left:5px; padding-right:5px;\">" + title + "</td>\
						<td style=\"background-color:#aaa; padding-left:5px;\">" + term + "</td>\
						<td class=\"filter_close\" style=\"background-color:#aaa;  padding-right:5px;\"><font class=\"ui-icon ui-icon-close\"></font></td>\
					</tr>\
				</table>\
				<input class=\"sys_filter\" type=\"hidden\"id=\"sys_filter_" + name +"_" + field + "\"  name=\"sys_filter_" + name +"_" + field + "\" value=\"" + term + "\">\
			</td>\
			<script>\
				$(\"#" + field + "_" + term + "\").click(function()\
				{\
					$(this).remove();\
				});\
			</script>\
		";
		return filter;
	}
	
	function link_report(link)
	{	
		link_base(link,"report","note");
	}
	function link_kanban(link)
	{
		link_base(link,"kanban","newwin");
	}

	function link_base(link,type,image)
	{
		$("#"+type)
		    .button({
			    icons: {	primary: "ui-icon-" + image },
			    text: false
		    })
		    .click(function(){
		        window.location=link;		    
		    }
	    );		
	}
 	function render()
 	{
	    if($(".render_h_origen").length>0)
	    {					
			$(".render_h_origen").each(function(){
				var diferencia	=$(this).attr("diferencia_h");
				var id			=$(this).attr("id");			
				
				var destino		=$("#" + id + ".render_h_origen").children(".render_h_destino");
				
				destino.height(1);
				var alto  =$(this).height() + parseInt(diferencia);
				
				destino.height(alto);				
			});	
		}
 	}
 	function ajustar_device()
 	{
	    setTimeout(function()
	    {  
			$("div#devices_all").height(1);
			var height  =$("td#system_submenu2").height() - 50;
			$("div#devices_all").height(height);
		},50);
 	}
	
	/*
	##################################################################
  	### FUNCIONES GMAPS
	##################################################################
	*/
	
    function CreateMap(iZoom,iMap,coordinates,object) 
    {
    	if($("div#map").length>0) 
    	{
    	    /*
		    setTimeout(function()
		    {  
            */       
				if(iMap=="ROADMAP")	            	var tMap = google.maps.MapTypeId.ROADMAP;
				if(iMap=="HYBRID")	            	var tMap = google.maps.MapTypeId.HYBRID;								
				var directionsService;	
				
				maxZoomService 						= new google.maps.MaxZoomService();

				var position		            	=LatLng(coordinates);
				var mapOptions 		            	= new Object();
		
				if(iZoom!="")		            	mapOptions.zoom			=iZoom;
				if(position!="")	            	mapOptions.center		=position;
				if(iMap!="")		            	mapOptions.mapTypeId	=tMap;	            
				
				mapOptions.zoomControlOptions		={position: google.maps.ControlPosition.TOP_RIGHT};
				mapOptions.streetViewControlOptions	={position: google.maps.ControlPosition.TOP_RIGHT}
				
				map 							= new google.maps.Map(document.getElementById(object), mapOptions);        
				geocoder 		   				= new google.maps.Geocoder();      
				var trafficLayer 				= new google.maps.TrafficLayer();
				
				
	  			trafficLayer.setMap(map);
	  					    
				gMEvent                         = google.maps.event;
				
				$("#buscar_address").button({
					text: false
					})
					.click(function(){
						codeAddress($("#address").val());
					}
				);
				//status_device();
				$.ajax(
				{
					async:true,
					cache:false,
					dataType:"html",
					type: "POST",  
					url: "../modulos/geofences/ajax/index.php",
					success:  function(res)
					{					
						$("div#script").html(res);
					},
					beforeSend:function(){},
				});
			//} ,200);
		}		
    }
	function polilinea(LocationsLine,color)
	{	
		if(color==undefined)	var color="#FF0000";
		if(color=="") 			var color="#FF0000";
		
		flightPath = new google.maps.Polyline({
			path: LocationsLine,
			geodesic: true,
			strokeColor: color,
			
			strokeOpacity: 1.0,
			strokeWeight: 2
		});		
		flightPath.setMap(map);
		lineas.push(flightPath);
	} 
	function poligono(LocationsLine,option) 
	{	
		if(option==undefined)		option={};
		if(option.color==undefined)	option.color="#FF0000";
		
	
		//if(color==undefined)	var color="#FF0000";
		if(option.color=="") 		option.color="#FF0000";
		flightPath = new google.maps.Polygon({
			paths: LocationsLine,
			strokeColor: option.color,
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: option.color,
			fillOpacity: 0.35
		});	


		if(option.geofence!=undefined)
		{
		    var infowindow = new google.maps.InfoWindow({
		      content: option.geofence,
		      position: LocationsLine[1]
		    });		
		    infoGeofences.push({info:infowindow,geofence:flightPath});		    
			flightPath.addListener('click', function() 
			{
				infowindow.open(map,flightPath);
			});
			//infowindow.close();
		}
		
		
		flightPath.setMap(map);
		//lineas.push(flightPath);
	} 	   
	function map_info(objeto)  
	{
		return new google.maps.InfoWindow(objeto);				
	} 
	
	function LatLng(co)  
	{
		return new google.maps.LatLng(co.latitude,co.longitude);
	} 
    function centerMap(marcador)
	{
		map.panTo(marcador);		
	}
	function hablar(item)
	{
		if(!(item["ev"]==undefined || item["ev"]==false || item["ev"]=="false" || item["ev"]=="REPORTE DE TIEMPO"))
        {        
            var fechaactual = item["ti"].split(" ");  
            	
        	var voz=item["na"] + " reporta " + fechaactual[1];
        	if(!(item["ev"]==undefined || item["ev"]==false || item["ev"]=="false"))
        		voz=voz + ", " + item["ev"];
		    if(!(item["ad"]==undefined || item["ad"]==false || item["ad"]=="false"))       
				voz=voz + ", " + item["ad"];		                		
        	responsiveVoice.speak(voz,"Spanish Latin American Female");            	
        }		
	}

    function odometro(item)	 
    {    	

    	
    	if(item["ot"]["battery"])			item["ba"]  =item["ot"]["battery"];
    	else								item["ba"]  =0;
    	if(item["al"])						item["al"]  =item["al"];
    	else								item["al"]  =0;

    	if(item["ot"]["ip"])				item["ip"]  =item["ot"]["ip"];
    	else								item["ip"]  =undefined;
    	

		/*    	
    	if(item["ot"]["totalDistance"]>0)	
    		item["mi"]  =parseInt(item["ot"]["totalDistance"]/1000);

    	if(item["ot"]["odometer"]>0)		
    		item["mi"]  =parseInt(item["ot"]["odometer"]/1000);    	

    	*/
    	
    	if(item["ts"])						item["ts"]  =item["ts"];
    	else								item["ts"]  =1.852;
    	

    	if(item["ba"]>100) item["ba"]=125;    
        var bat=item["ba"]*12/12.5-110;
        $("path.bateria").attr({"transform":"rotate("+ bat +" 250 250)"});            
        
        var vel=item["sp"]*item["ts"]*12/10-110;  // 
        $("path.velocidad").attr({"transform":"rotate("+ vel +" 250 250)"});
        
        var alt=item["al"]*12/40-15;
        $("path.altitude").attr({"transform":"rotate("+ alt +" 250 250)"});            

        $("#millas").html(item["mi"]);

        var tablero1="";
        var tablero2="";
                        
        if(!(item["ti"]==undefined || item["ti"]==false || item["ti"]=="false"))	//tiempo
            tablero1= tablero1 + item["ti"];
        if(!(item["ge"]==undefined || item["ge"]==false || item["ge"]=="false"))        
            tablero1= tablero1 + " :: " + item["ge"];
  
        if(!(item["ev"]==undefined || item["ev"]==false || item["ev"]=="false"))	//evento
            tablero2= " :: " + item["ev"];
        
		
        if(!(item["ad"]==undefined || item["ad"]==false || item["ad"]=="false"))       
            tablero2= "UBICACION :: " + item["ad"] + tablero2;          
                       
        if(item["ni"]<=40)
        {
			var tablero="\
				<table>\
					<tr><td width=\"40\"  style=\"color:#fff;\"><a href=\"#\"onclick=\"command_device('Bloquear motor'," + item["de"] +")\"><img width=\"32\" src=\"../sitio_web/img/button_red.png\"></a></td>\
					<td style=\"color:#fff;\">" + tablero1 + "</td></tr>\
					<tr><td width=\"40\"  style=\"color:#fff;\"><a href=\"#\"onclick=\"command_device('Activar motor'," + item["de"] +")\"><img width=\"32\" src=\"../sitio_web/img/button_green.png\"></a></td>\
					<td style=\"color:#fff;\">" +tablero2 + "</td></tr>\
				</table>\
			";	
		}
		else
		{	
			var tablero="\
				<table>\
					<tr><td width=\"40\"  style=\"color:#fff;\"></td>\
					<td style=\"color:#fff;\">" + tablero1 + "</td></tr>\
					<tr><td width=\"40\"  style=\"color:#fff;\"></td>\
					<td style=\"color:#fff;\">" +tablero2 + "</td></tr>\
				</table>\
			";	
		}	
        $("#tablero").html(tablero);
    }

	function locationsMap(vehicle, type)
	{	
		if(type==undefined)     type="icon";
		else                    type="marker";

		if(vehicle["st"]==undefined)	vehicle["st"]="1";
		if(vehicle["st"]=="")			vehicle["st"]="1"; 
	    
		if(vehicle["st"]=="1")
		{		
			var device_id=vehicle["de"];
			if(localizacion_anterior==undefined)	
			{
				localizacion_anterior=new Array();				
				localizacion_anterior[device_id]={ti:"2000-01-01 00:00:01"}			
			}
			if(localizacion_anterior[device_id]==undefined)	
			{
				localizacion_anterior[device_id]={ti:"2000-01-01 00:00:01"}			
			}									
			
			if(vehicle["se"]=="historyMap" || vehicle["ti"] >= localizacion_anterior[device_id]["ti"])
			{
				if(vehicle["ti"] > localizacion_anterior[device_id]["ti"] && vehicle["se"]!="simulator")
					hablar(vehicle);
				localizacion_anterior[device_id]=vehicle;
			
				var coordinates			={latitude:vehicle["la"],longitude:vehicle["lo"]};
	
				$("table.select_devices[device="+ vehicle["de"] +"]")
					.attr("lat", vehicle["la"])
					.attr("lon", vehicle["lo"]);
			
				var icon        		=undefined;
				
				var posicion 		    = LatLng(coordinates);						    	
				if(type=="icon")
				{
					var marcador;
					if(vehicle["co"]==undefined)        vehicle["co"]	=1;
					if(vehicle["co"])                   icon    		=vehicle["co"];
					
					if(icon>22 && icon<67)	icon=45;
					else if(icon<112)		icon=90;
					else if(icon<157)		icon=135;
					else if(icon<202)		icon=180;
					else if(icon<247)		icon=225;
					else if(icon<292)		icon=270;
					else if(icon<337)		icon=315;
					else					icon=0;		

					var image="01";
					if(!(vehicle["im"]==undefined || vehicle["im"]==false))		image	=vehicle["im"];


					icon	="../sitio_web/img/car/vehiculo_" +image+ "/i"+icon+ ".png";		    	
					
					/*
					if(image != "stop")							
							icon	="../sitio_web/img/car/vehiculo_" +image+ "/i"+icon+ ".png";		    	
					else	icon	="../sitio_web/img/marker/stop.png";
					*/	

					if(device_active==vehicle["de"] && vehicle["se"]==undefined || vehicle["se"]=="simulator") 
					{	        
					    centerMap(posicion);			
					    odometro(vehicle);
					} 
				}
				var marcador 		    = markerMap(posicion, icon);		
				var infowindow 		    = messageMap(marcador, vehicle);
		
				fn_localizaciones(marcador, vehicle);
			}
			else
			{
				//alert(vehicle["ti"] + ">"+ localizacion_anterior[device_id]["ti"]);
			}	
				
		}
		else 
		{
			var marcador 		    =undefined;
			
			var tablero="<table><tr><td style=\"color:red;\"><b>Los vehiculos se encuentran bloqueados</b></td></tr><tr><td style=\"color:#fff;\">Favor de contactar con el administrador del sistema</td></tr></table>";	
    	    $("#tablero").html(tablero);			
		}
		return marcador;
	}
	function markerMap(position, icon) 
	{
		var markerOptions 			= new Object();
		markerOptions.position		=position;
		markerOptions.map			=map;
		if(icon!=undefined)
			markerOptions.icon		=icon;

		return new google.maps.Marker(markerOptions);
	}
    function codeAddress(address,city,country) 
    {
    	var txt_address="";
    	if(country!=undefined)	txt_address+=country+", ";
    	if(city!=undefined)		txt_address+=city+", ";
    	if(address!=undefined)	txt_address+=address;
    	
        geocoder.geocode({'address': txt_address}, 
        function(results, status) 
        {
            if (status == google.maps.GeocoderStatus.OK) 
            {
                map.setCenter(results[0].geometry.location);
                map.setZoom(17);

                markerMap(results[0].geometry.location,undefined);
            } 
            else 	alert('Geocode was not successful for the following reason: ' + status);

        });
    }

    function ajax_positions_now(link,time)
    {    	
    	if(link==undefined)		link="../modulos/position/ajax/index.php?refresh=";
    	if(time==undefined)		time=0;
    	
	    setTimeout(function()
	    {  
			$.ajax(
			{
				async:true,
				cache:false,
				dataType:"html",
				type: "POST",  
				url: link,
				success:  function(res)
				{				    	
				    $("#script").html(res);
				}
			});    
		},time);    	
    }
    function ajax_positions(link,time)
    {
    	if(time==undefined)		time="15000";
    	if(link==undefined)		link="../modulos/position/ajax/index.php?refresh=";

        timer_position=setInterval(function()
        {     
			ajax_positions_now(link);
        },time);
    }    
    
    function fn_localizaciones(position, vehiculo)
    {
    	var ivehiculo=vehiculo["de"];
		if(localizaciones[ivehiculo]==undefined)     	
		{
			localizaciones[ivehiculo]	=Array(position);
			if(vehiculo["se"]!="simulator")    	vehicle_data[ivehiculo]		=Array(vehiculo)
		}	
		else
		{
			localizaciones[ivehiculo].unshift(position);			
			if(vehiculo["se"]!="simulator")        vehicle_data[ivehiculo].unshift(vehiculo)
		}	
    }    
	function del_locations(borrar)  
	{			    
		if(borrar==undefined)	borrar="si";
        if(localizaciones.length>0)                
        {
            for(idvehicle in localizaciones)
            {
                var positions_vehicle			= localizaciones[idvehicle];                    
                if(positions_vehicle.length>0)                
                {
                    for(iposiciones in positions_vehicle)
                    {    
                        //if(iposiciones>0)
                        {	
	                    	localizaciones[idvehicle][iposiciones].setVisible(false);								
                    		localizaciones[idvehicle][iposiciones].setMap(null);                     
                        	//if(iposiciones>0)	                        	localizaciones[idvehicle]=[]; 
	                    } 	                    
                    }                    
                }
            }

        }
        
	}

	function messageMaps(marcador, vehicle, infowindow) 
	{
		gMEvent.addListener(marcador, 'click', function() 
		{
		    device_active=vehicle["de"];
		    		    		    
			$(".select_devices").removeClass("device_active");
			$(".select_devices[device="+ vehicle["de"] +"]").addClass("device_active");			
			
			if(vehicle["se"]=="historyMap")	infowindow.open(map,marcador);
			else							status_device();
		});							
	}
	function paint_history(iposiciones, section)
	{			    
        if(vehicle_data[device_active].length>iposiciones)                
        {        	
        	localizacion_anterior=undefined;
	    	var vehicle			=vehicle_data[device_active][iposiciones];	    	
	    	vehicle["se"]		="simulator";
	    	locationsMap(vehicle); 
	    	if(section=="historyStreet")			execute_streetMap(vehicle);
            setTimeout(function()
            {                                               		    	
            	del_locations();
            	iposiciones=iposiciones+1;
            	if(simulation_action=="play")		
            		paint_history(iposiciones, section);
            },simulation_time);
        }
	}
	function dateTimes()
	{
		$('#fInicio').datetimepicker({
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss',
			changeMonth: false,
			changeYear: false,
			currentText: "Ahora",
			closeText: "Listo",
			showSecond: false,			
			showMillisec:false,
			showMicrosec:false,
			showTimezone:false,
			dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
			monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
			monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
		});

		$('#fFinal').datetimepicker({
			dateFormat: "yy-mm-dd",
			timeFormat: 'HH:mm:ss',
			changeMonth: false,
			changeYear: false,
			currentText: "Ahora",
			closeText: "Listo",
			showSecond: false,			
			showMillisec:false,
			showMicrosec:false,
			showTimezone:false,
			dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
			monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
			monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
		});	
		
	}

	function butons_simulation()
	{
		var butons_html=" \
			<font id=\"back\"> -- </font>\
			<font id=\"play\">Play</font>\
			<font id=\"stop\">Stop</font>\
			<font id=\"next\"> ++ </font>\
		";
		$("#tablero2").html(butons_html);
		$("#tablero").html("");
	
	    $("#play").button({
			icons: {
				primary: "ui-icon-play"
			},
			text: false
			})
			.click(function()
			{			    
				if(localizaciones.length>0)                
				{
				    simulation_action="play";
				    del_locations();
				    $("div#odometro").show();
					paint_history(1, historyMap);
				}    					
			}
		);
	    $("#next").button({
			icons: {
				primary: "ui-icon-seek-next"
			},
			text: false
			})
			.click(function()
			{
				if(simulation_time>=50)
					simulation_time=simulation_time-50;
			}
		);
	    $("#back").button({
			icons: {
				primary: "ui-icon-seek-prev"
			},
			text: false
			})
			.click(function()
			{
				simulation_time=simulation_time+50;
			}
		);				
	    $("#stop").button({
			icons: {
				primary: "ui-icon-stop"
			},
			text: false
			})
			.click(function()
			{
				simulation_action="stop";
			}
		);		
	
	}
	
	
    function status_device(actualiza, obj)
    {	    	
        if(device_active==undefined)    device_active	=0;        
        if(obj!=undefined)
        {	        	
        	var lat	=$(obj).attr("lat");
        	var lon	=$(obj).attr("lon");        	
        	if(lat!=undefined)
        	{
				var coordinates={latitude:lat,longitude:lon};
		    	var posicion		=LatLng(coordinates);
			    centerMap(posicion);
			}
        }    
		if(device_active==0)	
		{
			$("div#odometro").hide();
			$("#tablero").html("Estatus : Seleccionar un vehiculo");			
			$("#tablero").animate({				
				height: 25
			}, 1000 );			
		}	
		else
		{
			map.setZoom(16);
			$("#tablero").animate({				
				height: 58
			}, 1000 );
			$("#tablero").html("<h4>Cargando...</h4> <img id=\"loader1\" src=\"../sitio_web/img/loader1.gif\" height=\"30\" width=\"30\"/>");	
			//status_device2();
			$("#odometro").show(); 
		}	  			
	}
	
	function execute_streetMap(vehicle)
	{
		var coordinates						={latitude:vehicle["la"],longitude:vehicle["lo"]};
		
		if(coordinate_active==undefined)	coordinate_active={};
		var txt_active						=coordinate_active["latitude"]+","+coordinate_active["longitude"];
		var txt_history						=coordinates["latitude"]+","+coordinates["longitude"];

		var txt 							= txt_active + " " +txt_history;
		//$("#pie").html(txt);
		
		if(txt_active!=txt_history)
		{	
			coordinate_active				=coordinates;
		    var posicion					=LatLng(coordinates);
		    
		    centerMap(posicion);
		    var curso           			=vehicle["co"];		        
		    var panoramaOptions = {
		        position: posicion,
		        pov: {
		          heading:  curso,
		          pitch:    10
		        }
		    };
		    
		    var panorama = new google.maps.StreetViewPanorama(document.getElementById('street'), panoramaOptions);
		    map.setStreetView(panorama);	                		    
		}        
	}


	
	$(document).ready(function()
	{
		var vURL = window.location.href
		var aURL = vURL.split("/");
		var	vURL = aURL[aURL.length-2]+"/"+aURL[aURL.length-1];
		render();
		

		
		
		if($("[tabindex='1']").length>0)
			$("[tabindex='1']").focus();
		
        $("input[type!='hiden|checkbox'][tabindex], select[tabindex] ").on('keydown', function (e) 
		{			
            if (e.keyCode == 13) 
			{						
				e.preventDefault();
				
				var tabindex =parseInt($(this).attr("tabindex")) + 1;
				$("input[tabindex="+tabindex+"], select[tabindex="+tabindex+"]").focus();
			}	
        });		
		
		
		$(".submenu2").removeClass("submenu2_active");
		
		$(".submenu2").click(function(e)
		{				
			vLINK = $(this).parents( "a" ).attr('href');
			aLINK = vLINK.split("/");
			vLINK = aLINK[aLINK.length-2]+"/"+aLINK[aLINK.length-1];	
			if(vURL == vLINK)
			{
			    e.stopPropagation();
			    e.preventDefault();			
			}					    					    			
		});


	    if($("div.submenu").length>0)
	    {
			$("div.submenu").click(function()
			{
                var active        =$(this).attr("active");               
                $("div.option").removeClass("d_block");                
				$("div.option[active='"+active+"']").addClass("d_block");
				
				ajustar_device();
			});
		}
	    if($("font.show_form").length>0)
	    {
			$("font.show_form").button({	    
				icons: {	primary: "ui-icon-extlink" },
				text: false
				})
			$("font.show_form").click(function()
			{
                var active	=$(this).attr("active");                
                $("#form_"+active).removeClass("d_none");
				$("#form_"+active).addClass("d_block");				
			});
		}
		
	    $("div#setting").hide();
	    
	    if($("font#update_settings").length>0)
	    {
			$("font#update_settings").button({	    
				icons: {	primary: "ui-icon-refresh" },
				text: true
				})
				.click(function()
				{				
					$("div#setting").dialog("destroy");
					var setting_company = $("input#setting_company").val();
				
					$.ajax(
					{
						async:true,
						cache:false,
						dataType:"html",
						type: "POST",  
						url: "../modulos/sesion/ajax/index.php",
						data: "setting_company="+setting_company,
						success:  function(res)
						{					
							$("#script").html(res);
						}
					});    														
					$("form").submit();		        
				}
			);			    
		}	    
	    
	    $("font#setting").click(function(){
	        $("div#setting").dialog({
	        	width:"700px"
	        });
	    
	    });
	    if($("img#excel").length>0)
	    {
			$("img#excel").click(function()
			{
				var url=location.href;
				var arrUrl=url.split("/");
				
				var clase =arrUrl[ arrUrl.length -2];
				
				$("form")
					.attr("target","_blank")
					.attr("action","&sys_action=print_excel")
					.submit();
				$("form")				
					.attr("action","")
					.removeAttr("target");					
		    });	        
	    }	    
	    if($("img#pdf").length>0)
	    {
			$("img#pdf").click(function()
			{
				var url=location.href;
				
				var arrUrl=url.split("/");
				
				var clase =arrUrl[ arrUrl.length -2];
				
				$("form")
					.attr("target","_blank")
					.attr("action","&sys_action=print_pdf")
					.submit();
				$("form")				
					.attr("action","")
					.removeAttr("target");					
				/*
				var variables=getVarsUrl();
				var str_url="";
				var sys_action=0;
				for(ivariables in variables)
				{
					if(ivariables=="sys_action")	
					{
						sys_action=1;
						str_url+="&"+ivariables+"=print_pdf";
					}	
					else	str_url+="&"+ivariables+"="+ variables[ivariables];
				}		        
				if(sys_action==0)	str_url+="&sys_action=print_pdf";
				
				window.open(str_url);
				*/
		    });	        
	    }	    

	    if($("img#print").length>0)
	    {
			$("img#print").click(function()
			{
				var url=location.href;				
				var arrUrl=url.split("/");
				
				var clase =arrUrl[ arrUrl.length -2];
				
				$("form")
					.attr("target","_blank")
					.attr("action","&sys_action=print_report")
					.submit();
				$("form")				
					.attr("action","")
					.removeAttr("target");									
				
		    });
	    }	    
	   
	    if($("td#system_submenu2").length>0)
	    {
	    	ajustar_device();
			$( window ).resize(function() 
			{
				ajustar_device();
			});	   	   
	    }
		
    	if($(".sys_report").length>0) 
    	{
            $(".sys_report").click(function()
            {
				var data        =$(this).attr("data");               
				envio_var(data);	
				
			});
		}
		
        if($(".report_title_action").length>0)
        {
            $(".report_title_action").click(function()
            {		
				$(this).children("div.filter_window").dialog({
					width:"700px"
				});

             });               
		 }


		
		
        if($(".sys_order").length>0)
        {
            $(".sys_order").click(function()
            {
                var name        =$(this).attr("name");
                var sys_order   =$(this).attr("sys_order");
                var sys_torder  =$(this).attr("sys_torder");
				
				
                                
	            $("input#sys_order_"+name).val(sys_order);
	            $("input#sys_torder_"+name).val(sys_torder);
	            
	            $("form").submit(); 
            });               
        }
		

		if($(".cKanban").length>0) 
		{
			var colorAction;
			var colorKanban;
			var colorHover;

			$(".cKanban").mouseover(function()
			{					
				$(this).find(".cBotones").css("display", "block");
				/*
				if($(this).find("[type=checkbox]").is(':checked'))
				{
				}
				else
				{					
					colorKanban	=$(this).css("background-color");
					$(this).css("background-color", "#EFEFFB");
					colorHover	=$(this).css("background-color");
				}
				*/
			});
			$(".cKanban").mouseout(function()
			{				
				$(this).find(".cBotones").css("display", "none");
				if ($(this).css("background-color") == colorHover)
				{
					$(this).css("background-color", colorKanban);
				}
			}); 
			$(".cAction").mouseover(function()
			{
				colorAction	=$(this).css("background-color");
				$(this).css("background-color", "#A4A4A4");

			});
			$(".cAction").mouseout(function()
			{
				$(this).css("background-color", colorAction);
			});		   
		
			/*
			$("[type=checkbox]").click(function() {  //input.myclass[type=checkbox]   
			
				if($(this).is(':checked')) { 
					$(this).parents( ".cKanban" ).css( "background","#58FAF4"); 
				} else {  
					$(this).parents( ".cKanban" ).css( "background", colorKanban); 
				}  
			});
			*/

		}
	    if($(".echo").length>0)
	    {
			$(".echo").dialog();
		}		
		if($(".cBodyReport").length>0) 
		{
			var colorAction;
			var colorRowOdd = $(".odd").css( "background-color");	
			var colorRowEven = $(".even").css( "background-color");
			var classRow;
			/*
			$(".cAction").mouseover(function()
			{
				colorAction	=$(this).css("background-color");
				$(this).css("background-color", "#58FAF4");	

			});
			$(".cAction").mouseout(function()
			{
				$(this).css("background-color", colorAction);
			});		   
			
			$("[type=checkbox]").click(function() 
			{  
			    if($(this).is(':checked')) 
			    { 	        	
			        $(this).parents( "tr" ).css( "background-color","#58FAF4");
			    } 
			    else 
			    {  

			        classRow = $(this).parents( "table" ).parents( "tr" ).attr('class');
			        
		        	if(classRow == "odd")
		        	{
		        		$(this).parents( "tr" ).css( "background-color",colorRowOdd);
		        	}
		        	else if (classRow == "even") 
		        	{
		        		$(this).parents( "tr" ).css( "background-color",colorRowEven);
		        	};	            
			    }  
	    	});
			*/

		}
		if($(".sys_report_blank").length>0) 
		{
				
			$(".sys_report_blank").click(function()
			{					
				var obj        =$(this).attr("obj");
				var section		=$("#sys_section_" + obj).val();					
				
            	var data        =$(this).attr("data");               
				generacion_var(data);
				
				$("form")
					.attr({"target":"_blank"})					
					.submit()					
					.removeAttr("target");
					
				$("#sys_section_" + obj).val(section);									
				$("#sys_action").val("");													
			});			
		}		
		
    });	
	function generacion_var( data ) 
	{	
		var variables	=serializar_url(data);	
		for(ivariables in variables)
		{
				var input="";
				if($("input#"+ivariables).length>0) {}
				else	
				{	
					input="<input id=\""+ivariables+"\" name=\""+ivariables+"\" type=\"hidden\">";						
					$("form").append(input);
				}			
				$("input#"+ivariables).val(variables[ivariables]);	
		}			
	}	
	
	
	
	function envio_var( data ) 
	{	
		generacion_var( data ); 
		$("form").submit(); 	    
	}
	
	
		
	function split( val ) {
		return val.split( /,\s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}

	
	function page(sys_page,sys_row)
	{
	    $("#sys_page").val(sys_page);
	    $("#sys_row").val(sys_row);
	    
	    $("form").submit(); 
	}
	
	function command_device(comando,device_id)
	{
		var r = confirm(comando);
		if (r == true) 
		{
			if(comando=="Bloquear motor") 	comando="engineStop";
			if(comando=="Activar motor")	comando="engineResume";
						
			$.ajax({
				type: 'POST',
				url: 'http://solesgps.com:8082/api/commands',
				headers: {
					"Authorization": "Basic " + btoa("admin:EvG30")
				},
				contentType:"application/json",
				data:JSON.stringify({attributes:{},deviceId:device_id,type:comando}),
				success: function (response) 
				{
					console.log(response);
				}
			});

		} 				
	}	
	
	/*
	$(function() 
	{
    	if($(document).length>0) 
    	{
	
			$(document).tooltip();
		}	
	});
	*/
	
	
