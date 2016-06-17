 var inicio = function(){
	var parametros="";
	var usuario="";
	var clave="";

	var entrar = function(){
		debugger

		usuario = $("#txtUsuario").val();
		clave   = $("#txtClave").val();

		if(docente=="" || clave==""){
			alert("Complete los campos para acceder");
		}else{
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "php/utilerias.php",
				data: parametros,

				success: function(data){

					if(data.respuesta){
						$(".entradaUsuario").hide("slow");
						$("#barra").show("slow");
						$("#user").append("<i class='material-icons'>perm_identity</i>"+usuario+"<br><br>");
						$("#user").show("slow");
					}else{
						alert("Usuario no registrado");
					}
				}
			});
		}
		
	}

	$("#btnEntrar").on("click",entrar);
}
$(document).on("ready",inicio);