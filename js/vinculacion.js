var admin = function (){
	var parametros="";
	const TECLA_ENTER = 13;

	var alumnosSolicitudes = function(){
		$('#opcVinculacion>div').hide();
		var parametros ="opc=muestraSolicitudes";
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,

			success: function(data){
				if(data.respuesta){
					$("#tablaSolicitudes").html("");
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
					$("#inputDependencia").val(data.dependencia);
					$("#inputPrograma").val(data.programa);
					$("#selectEstado").val(data.estado+"");
					$("#selectEstado").material_select();
					$("#divSolicitudes").hide();
					$("#divDetalles").show();
					//$("#idSolicitud").val()
				}
			}
		})
	}

	/*var buscarTarjeta =function(tecla){
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
		
	}*/

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

	/*$("#selprogdep").change(function() {
 		$("#second-choice").load("getter.php?choice=" + $("#first-choice").val());
	});*/
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
	var muestralistaprogramas=function(){
		console.log("muestraprogramas");
		$('#opcVinculacion>div').hide();
		$("#listadoProgramas").show("slow");
		var parametros="opc=tablaprogramas";
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data:parametros,
			success: function(data){
				if(data.respuesta==true){
					$("#tblprogramas").find('tr').remove();
					$("#tblprogramas").append(data.renglones).html();
				}
			}
		});

	}

    var disponibilidad=function(){
    	var username = $("#txtdepusuario").val(); // Get username textbox using $(this)
        var Result = $('#resultado'); // Get ID of the result DIV where we display the results
        if(username.length > 2) { // if greater than 2 (minimum 3)
            Result.html('Cargando...'); // you can use loading animation here
            var parametros = 'action=disponible&username='+username;
            $.ajax({ // Send the username val to available.php
            type : 'POST',
            data : parametros,
            url  : '../datos/disponible.php',
            success: function(responseText){ // Get the result
                if(responseText == 0){
                    Result.html('<span class="success"  style="color:green">Disponible</span>');
                }
                else if(responseText > 0){
                    Result.html('<span class="error" style="color:red">No disponible</span>');
                }
                else{
                    alert('Problem with sql query');
                }
            }
            });
        }else{
            Result.html('Ingresa al menos 3 caracteres');
        }
        if(username.length == 0) {
            Result.html('');
        }
    }

    var buscarTarjeta =function(){
		var ncontrol = $("#txtbuscaTarjeta").val();

		$(':input','#frmdatosExpediente')
 					.not(':button, :submit, :reset, :hidden')
 					.val('')
 					.removeAttr('checked')
 					.removeAttr('selected');
		if(ncontrol==""){
			Materialize.toast('Ingresa el No. de Control', 4000);
			return;
		}

			var parametros ="opc=obtenerTarjetaAlm"+
												"&ncontrol="+ncontrol;
			$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
					if(data.respuesta==false){
						Materialize.toast('No se encontró el expediente', 4000);
					}else{
						$("#datosAlm:text").val("");
						$("#datosAlm").show("slow");
						$("#tnombre").val(data.alumno.nombre);
						$("#tedad").val(data.alumno.edad);
						$("#tsexo").val(data.alumno.sexo).material_select();

						$("#tdomicilio").val(data.alumno.domicilio);
						$("#ttelefono").val(data.alumno.telefono);
						$("#tncontrol").val(data.alumno.nocontrol);
						$("#tcreditos").val(data.alumno.creditos);
						if(data.periodo==1){
							$("#pdotarjeta1").prop('checked', true);
						}else{
							$("#pdotarjeta3").prop('checked', true);
						}
						$("#datosAlm").show("slow");
						$("#frmdatosExpediente").show("slow");
					}

				}
			});		
	}

	var documentosExpediente=function(nocontrol){
		var ncontrol = $("#txtbuscaTarjeta").val();

		$(':input','#controlexpediente1')
 					.not(':button, :submit, :reset, :hidden')
 					.val('')
 					.removeAttr('checked')
 					.removeAttr('selected');
		if(ncontrol==""){
			Materialize.toast('Ingresa el No. de Control', 4000);
			return;
		}
		var parametros ="opc=documentosExpediente"+"&ncontrol="+ncontrol;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
					if(data.respuesta){
						/*
						determinar si ya realizo o no el curso de induccion
						if(data.solicitud ==1){
							$("#solicitud").prop("checked", true);
						}
						if(data.cursoin ==1){
							$("#cursoin").prop("checked", true);
						}*/
						if(data.cartaacep ==1){
							$("#cartaap").prop("checked", true);
						}
						if(data.plantrabajo==1){
							$("#plantra").prop("checked",true);
						}
						if(data.cartatermina==1){
							$("#cartaterm").prop("checked",true);
						}
						if(data.reporteuno==1){
							$("#repouno").prop("checked",true);
						}
						if(data.reportedos==1){
							$("#repodos").prop("checked",true);
						}
						if(data.reportetres==1){
							$("#repotres").prop("checked",true);
						}

						$("#controlexpediente1").show("slow");
					}else{
						Materialize.toast('No se encontró el expediente', 4000);
					}

				}
			});	
		
	}
	var llenarTarjeta=function(){
		//fn para llenar los badges de la tarjeta
		documentosExpediente();
		buscarTarjeta();
	}

	var modificarSolicitud = function(){
		var frm = $("#frmDetallesAlumno").serialize()
		console.log(frm);
		
	}
	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
	$("#tablaSolicitudes").on("click","#rechazar",rechazarSolicitudes);
	$("#tablaSolicitudes").on("click", "#detalles",detallesAlumno);
	$("#menuTarjeta").on("click",muestraTarjeta);
	//$("#txtbuscaTarjeta").on("keypress",buscarTarjeta);
	$("#menuregistroEmpresas").on("click",muestraRegEmpresas);
	$("#frmRegistroEmpresa").on("submit",registrarEmpresa);

	$("#menuregistroProgramas").on("click",muestraRegProgramas);
	$("#selprogdep").on("change", cargadepartamentos);
	$("#frmRegistroProgramas").on("submit",registroProgramas);
	$("#muestraProgramas").on("click",muestralistaprogramas);

	$("#txtdepusuario").on('keyup',disponibilidad);
	$("#btnbuscaTarjeta").on("click",llenarTarjeta);

	$("#frmDetallesAlumno").on("submit",modificarSolicitud);
	$("#badgeexpediente").on("click",documentosExpediente);
	$("#badgedatos").on("click",buscarTarjeta);
}
$(document).on("ready",admin);