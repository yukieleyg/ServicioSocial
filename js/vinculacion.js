var admin = function (){
	var parametros="";
	const TECLA_ENTER = 13;
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
		$('#opcVinculacion>div').hide();
		$("#tarjetaControl").show("slow");
	}
	var detallesAlumno = function() {
		var solicitud 	= $(this).val();
		var parametros 	= "opc=detallesAlumno"+"&solicitud="+solicitud;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data:parametros,
			
			success: function(data){
				if(data.respuesta){
					$("#inputTelefono").val(data.tel);
					$("#inputNombre").val(data.nombre);
					$("#inputEmail").val(data.email);
					$("#inputCarrera").val(data.carrera);
					$("#inputSemestre").val(data.semestre);
					$("#inputDireccion").val(data.direccion);
					$("#inputPeriodo").val(data.periodoAct);
					$("#selectEstado").val(data.estado+"");
					$("#selectEstado").material_select();
					$("#divSolicitudes").hide();
					$("#divDetalles").show();
				}
			}
		})
	}

	var buscarTarjeta =function(tecla){
		if(tecla.which == TECLA_ENTER)
		{
			var ncontrol = $("#txtbuscaTarjeta").val();
			var parametros ="opc=obtenerTarjetaAlm"+
												"&ncontrol="+ncontrol;
			$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
					if(data.respuesta){
						//provisional
						alert(data.nombre);
					}

				}
			});
		}
		
	}

	var muestraRegEmpresas= function(){
		$('#opcVinculacion>div').hide();
		$("#registroEmpresas").show("slow");

	}

	var registrarEmpresa= function(){
		var parametros = $("#frmRegistroEmpresa").serialize()+"&opc=registrarEmpresa"+"&id="+Math.random();
		//serialize concatena los parametros contenidos en el formulario
		console.log(parametros);
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
				 if(data.respuesta){
				 	console.log("recibe");
				 	Materialize.toast('Registro de empresa exitoso', 4000);
				 	$(':input','#frmRegistroEmpresa')
 					.not(':button, :submit, :reset, :hidden')
 					.val('')
 					.removeAttr('checked')
 					.removeAttr('selected');
				    
				 }else{
				 	Materialize.toast(data.mensaje, 4000);
				 }
				}

		});

	}

	var llenaDepProgramas= function(){
		var parametros = $("#selprogdep").val()+"&opc=llenaDepProgramas"+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	var opcs=data.opciones;
				 	$("#selprogdep").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
	}

	var muestraRegProgramas= function(){
		llenaDepProgramas();
		$('#opcVinculacion>div').hide();
		$("#registroProgramas").show("slow");
	}
	var llenaActProg= function(){
		var parametros = $("#selprogact").val()+"&opc=llenaActProg"+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	var opcs=data.opciones;
				 	$("#selprogact").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
	}



	var registroProgramas=function(){
		var parametros = $("#frmRegistroProgramas").serialize()+"&opc=registrarPrograma"+"&id="+Math.random();
		console.log($("#selprogest").val());
		console.log(parametros);
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
				 if(data.respuesta){
				 	console.log("recibe");
				 	Materialize.toast('Registro de programa exitoso', 4000);
				 
 					$('input:not([type=radio],[type=submit])').val("");
 					$('textarea').val("");
 					$('input[type="radio"]').prop('checked', false);
 					$('select').prop('selectedIndex',0);
 					$('select').material_select();
				    
				 }else{
				 	Materialize.toast(data.mensaje, 4000);
				 }
				}

		});
	}

	$("#selprogdep").change(function() {
 		$("#second-choice").load("getter.php?choice=" + $("#first-choice").val());
	});
	var cargadepartamentos= function(){
		var parametros={selprogdep:$("#selprogdep").val(), opc:'llenaDptoProgramas'};
		//var parametros = $("#selprogdep").val()+"&opc=llenaDptoProgramas"+"&id="+Math.random();
		console.log(parametros);
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	var opcs=data.opciones;
				 	$("#selprogdpto").find('option').remove();
				 	$("#selprogdpto").append('<option>Seleccione departamento..</option>');
				 	$("#selprogdpto").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
	}

	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
	$("#tablaSolicitudes").on("click","#rechazar",rechazarSolicitudes);
	$("#tablaSolicitudes").on("click", "#detalles",detallesAlumno);
	$("#menuTarjeta").on("click",muestraTarjeta);
	$("#txtbuscaTarjeta").on("keypress",buscarTarjeta);
	$("#menuregistroEmpresas").on("click",muestraRegEmpresas);
	$("#frmRegistroEmpresa").on("submit",registrarEmpresa);

	$("#menuregistroProgramas").on("click",muestraRegProgramas);
	$("#selprogdep").on("change", cargadepartamentos);
	$("#frmRegistroProgramas").on("submit",registroProgramas);

}
$(document).on("ready",admin);