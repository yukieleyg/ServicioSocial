var admin = function (){
	var parametros="";
	
	var alumnosSolicitudes = function(){
		var parametros ="opc=muestraSolicitudes";
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"php/adminalumnos.php",
			data: parametros,

			success: function(data){
				if(data.respuesta){

					$("#tablaSolicitudes").html(" ");
					$("#tablaSolicitudes").append(data.tabla);
					$("#divSolicitudes").show();
				}
				
			}
		});

		
	}
	var aceptarSolicitudes = function(){
		var solicitud = $(this).val();
		var parametros	= "opc=aceptarSolicitudes"+"&solicitud="+solicitud;
		var r = confirm("¿Estas seguro de que quieres aceptar la solicitud del usuario "+solicitud+"?");
		if(r){
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "php/adminalumnos.php",
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
	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
}
$(document).on("ready",admin);