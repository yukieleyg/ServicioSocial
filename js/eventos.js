 var inicio = function(){
	var parametros="";
	var usuario="";
	var clave="";

	var entrar = function(){
		

		usuario = $("#txtUsuario").val();
		clave   = $("#txtClave").val();

		var parametros ="opc=validaentrada"+
							"&usuario="+usuario+
							"&clave="+clave+
							"&id="+Math.random();

		if(usuario=="" || clave==""){
			alert("Complete los campos para acceder");
		}else{
			$.ajax({
				type: "POST",
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