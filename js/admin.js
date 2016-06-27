var admin = function (){
	var parametros="";
	
	var alumnosExpedientes = function(){
		var parametros ="opc=mostrarExpedientes";
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"php/adminalumnos.php",
			data: parametros,

			success: function(data){
				if(data.respuesta){
					$("#tablaExpedientes").append(data.tabla);
					$("#tablaExpedientes").show();
				}
				
			}
		});

		
	}
	$("#muestraAlumnos").on("click",alumnosExpedientes);
}
$(document).on("ready",admin);