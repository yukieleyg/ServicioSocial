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
				url: "../datos/entrar.php",
				data: parametros,

				success: function(data){
					if(data.respuesta){
						switch(data.tipo){
							case '1':
								$(".entradaUsuario").hide("slow");
								$("#barra").show("slow");
								$("#user").html(" ");
								$("#user").append("<i class='material-icons'>perm_identity</i>"+data.nombre+"<br><br>");
								$("#user").show("slow");
								break;
							case '2':
								alert("dependencia" + data.nombre);break;
							case 3:
								if(data.creditos){
									alert("alumno");
									//programacion para cuando el alumno pueda a entrar al sistema
									//insertar alumno pero con curso 0
									alumnoAlta(usuario);
									tomoCurso(usuario);	
									break;
								}else{
									$.alert("No cuentas con los créditos suficientes");
								}break;
								
						}
					}else{
						$.alert('Usuario y/o contraseña incorrectos');
					}
				}
			});
		}
		
	}
	var alumnoAlta =function(alumno){
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: 'opc=altaAlumnoUsuario&alumno='+alumno,
			success: function(data){
				$.alert(data.mensaje);
			}
		});
	}
	var tomoCurso= function(alumno){
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: 'opc=tomoCursoMoodle&alumno='+alumno,
			success: function(data){
				if(data.respuesta){
					//que hacer cuando entre el alumno
				}else{
					$.alert(data.mensaje);
				}				
			}
		});
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

	const TECLA_ENTER = 13;
	var txtCajas = $("#entradaUsuario").find("input");

	
	var teclatxtCajas = function(tecla)
	{
		var cajaActual = txtCajas.index(this);
		if(tecla.which == TECLA_ENTER)
		{
			if(txtCajas[cajaActual + 1]!=null)
			{
				var cajaSiguiente=txtCajas[cajaActual + 1];
				cajaSiguiente.focus();
			}
		}
	}
	var login =function(tecla){
		if(tecla.which == TECLA_ENTER)
		{
			$("#btnEntrar").click();
		}
	}

	$('select').material_select();
	$(txtCajas[1]).on("keypress",login);
	$(txtCajas).on("keypress",teclatxtCajas);
	$("#mostrarClave").on("click",muestraClave);
	$("#btnEntrar").on("click",entrar);
}
$(document).on("ready",inicio);