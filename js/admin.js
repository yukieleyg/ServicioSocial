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
	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
}
$(document).on("ready",admin);