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
				url: "php/entrar.php",
				data: parametros,

				success: function(data){
					if(data.respuesta){
						switch(data.tipo){
							case '1':
								$(".entradaUsuario").hide("slow");
								$("#barra").show("slow");
								$("#user").append("<i class='material-icons'>perm_identity</i>"+data.nombre+"<br><br>");
								$("#user").show("slow");
								break;
							case '2':
								alert("dependencia" + data.nombre);break;
							case 3:
								if(data.creditos){
									alert("alumno");
									//programacion para cuando el alumno pueda a entrar al sistema
									break;
								}else{
									alert("No cuentas con los créditos suficientes");
								}break;
								
						}
					}else{
						alert("Usuario no registrado");
					}
				}
			});
		}
		
	}
	var muestraClave = function(){
		var val = $("#mostrarClave").find("i");
		if(val.html() == "visibility"){
			$("#txtClave").attr("type","password");
			val.html("visibility_off");
		}else{
			$("#txtClave").attr("type","text");
			val.html("visibility");
		}

	}
	$("#mostrarClave").on("click",muestraClave);
	$("#btnEntrar").on("click",entrar);
}
$(document).on("ready",inicio);