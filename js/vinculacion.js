var admin = function (){
	var parametros="";
	
	var alumnosSolicitudes = function(){
		var parametros ="opc=muestraSolicitudes";
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,

			success: function(data){
				if(data.respuesta){

					$("#tablaSolicitudes").html(" ");
					$("#tablaSolicitudes").append(data.tabla);
					$("#divSolicitudes").show();
				}
				
			}
		});

		$("#listadoAlumnos").show();
	}
	var aceptarSolicitudes = function(){
		var solicitud 	= $(this).val();
		var parametros	= "opc=aceptarSolicitudes"+"&solicitud="+solicitud;
		var r = confirm("¿Estas seguro de que quieres aceptar la solicitud del usuario "+solicitud+"?");
		if(r){
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "../datos/vinculacion.php",
					data: parametros,

					success: function(data){
						if(data.respuesta){
							alumnosSolicitudes();
						}else{
							alert("Esta solicitud no puede ser aceptada");
						}
					}


				})


		}		

	}
 	var rechazarSolicitudes = function(){
		var solicitud 	= $(this).val();
		var parametros	= "opc=rechazarSolicitudes"+"&solicitud="+solicitud;
		var r = confirm("¿Estas seguro de que quieres rechazar la solicitud del usuario "+solicitud+"?");
		if(r){
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "../datos/vinculacion.php",
					data: parametros,

					success: function(data){
						if(data.respuesta){
							alumnosSolicitudes();
						}else{
							alert("Esta solicitud no puede ser rechazada");
						}
					}


				})


		}		

	}

	var muestraTarjeta = function (){
		console.log("si");
		$("#tarjetaControl").show("slow");
	}
	/*var detallesAlumno = function() {
		var solicitud 	= $(this).val();
		var parametros 	= "opc=detallesAlumno"+"&solicitud"+solicitud;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "php/adminalumnos.php",
			data:parametros,


			success: function(data){
				if(data.respuesta){
					#tablaSolicitudes.hide();
					#detallesAlumno.append(data.tabla);
					#detallesAlumno.show();
				}else{
					alert("Error");
				}
			}
		})
	}*/
	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
	$("#tablaSolicitudes").on("click","#rechazar",rechazarSolicitudes);
	//$("#tablaSolicitudes").on("click", "#detalles",detallesAlumno);
	$("#menuTarjeta").on("click",muestraTarjeta);
}
$(document).on("ready",admin);