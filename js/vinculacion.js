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
					$('#opcVinculacion>div').hide();
					$("#tablaSolicitudes").html("");
					$("#tablaSolicitudes").append(data.tabla);
					$("#listadoSolicitudes").show();
				}
				
			}
		});

		
	}

	var aceptarSolicitudes = function(){
		var solicitud 	= $(this).val();
		var parametros	= "opc=aceptarSolicitudes"+"&solicitud="+solicitud;
		var r = confirm("¿Esta seguro que desea aceptar la solicitud ");
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
						alert("Esta solicitud no ha podido ser aceptada");
					}
				}


			})


		}		

	}
	var rechazarSolicitudes = function(){
		var solicitud 	= $(this).val();
		var parametros	= "opc=rechazarSolicitudes"+"&solicitud="+solicitud;
		var r = confirm("¿Esta seguro que desea rechazar la solicitud ?");
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
						alert("Esta solicitud no ha podido ser rechazada");
					}
				}


			})


		}		

	}

	var muestraTarjeta = function (){
		$('#opcVinculacion>div').hide();
		$("#tarjetaControl").show("slow");
	}
	var verDetallesSolicitud = function() {
		var solicitud 	= $(this).val();
		var parametros 	= "opc=verDetallesSolicitud"+"&solicitud="+solicitud;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data:parametros,
			
			success: function(data){
				if(data.respuesta){
					$('#opcVinculacion>div').hide();
					$("#inputTelefono").val(data.tel);
					$("#inputNombre").val(data.nombre);
					$("#inputEmail").val(data.email);
					$("#inputCarrera").val(data.carrera);
					$("#inputSemestre").val(data.semestre);
					$("#inputDireccion").val(data.direccion);
					$("#inputPeriodo").val(data.periodoAct);
					$("#inputDependencia").val(data.dependencia);
					$("#inputPrograma").val(data.programa);
					$("#inputObservaciones").val(data.observaciones);
					$("#inputMotivo").val(data.motivo);
					$("#idSolicitud").val(data.solicitud);
					$("#selectEstado").val(data.estado+"");
					$("#selectEstado").material_select();
					$("#detallesSolicitudA").show();
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
				 	$("#selprogdep").find('option').remove();
				 	$("#selprogdep").append('<option>Seleccione dependencia..</option>');
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
		var parametros="opc=tablaprogramas";
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data:parametros,
			success: function(data){
				if(data.respuesta==true){
					$('#opcVinculacion>div').hide();
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.renglones);
					$("#listadoProgramas").show();
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
			collapseAll();
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
						collapseAll();
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
			collapseAll();
			return;
		}
		var parametros ="opc=documentosExpediente"+"&ncontrol="+ncontrol;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
					if(data.respuesta==false){
						collapseAll();
						Materialize.toast('No se encontró el expediente', 4000);
					}else{
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
					}
				}
			});
	}
	var detallesSolicitud = function(){
		event.preventDefault();
		var solicitud 		= $("#idSolicitud").val();
		var estado 			= $("#selectEstado").val();
		var motivo 			= $("#inputMotivo").val();
		var observaciones	= $("#inputObservaciones").val();
		var parametros		= "opc=detallesSolicitud"+"&solicitud="+solicitud+"&estado="+estado+"&motivo="+motivo+"&observaciones="+observaciones;	
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){ 
					if(data.respuesta){
						var r = confirm("¿Esta seguro que desea modificar la solicitud?");
						if(r){	
							var parametros2 = "opc=modificarSolicitud"+"&solicitud="+solicitud+"&estado="+estado+"&motivo="+motivo+"&observaciones="+observaciones;	
							$.ajax({
								type: "POST",
								dataType: "json",
								url:"../datos/vinculacion.php",
								data: parametros2,
								success: function(dataM){
									if(dataM.respuestaM){
										alert("Modificación Exitosa");
										$('#divDetalles').hide();
										alumnosSolicitudes();
									}else{
										alert("No se puede modificar esta solicitud");
										$('#divDetalles').hide();
										alumnosSolicitudes();									
									}
								}
								

							});

						}

					}else{
						alumnosSolicitudes();
					}
				}
			});	
	}
	var llenarTarjeta=function(){
		//fn para llenar los badges de la tarjeta
		documentosExpediente();
		buscarTarjeta();
		$(".collapsible-header").addClass("active");
  		$(".collapsible").collapsible({accordion: false});
	}
	var detallesProgramas = function () {
		var programa 	= $(this).val();
		var estado 		= $("#estadoPrograma").val();
		var vigencia	= $("#vigenciaPrograma").val();
		var parametros 	= "opc=detallesPrograma"+"&programa="+programa+"&vigencia="+vigencia+"&estado="+estado;
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$("#idPrograma").val(programa);
					$('#nombre').val(data.nombreP);
					$('#tipodeactividades').val(data.tipoAct);
					$('#desAct').val(data.desAct);
					$('#tipoprograma').val(data.tipoP);
					$('#empresa').val(data.empresa);
					$('#responsable').val(data.resposable);
					$('#modalidad').val(data.modalidad);
					$('#departamento').val(data.departamento);
					$('#puesto').val(data.puesto);
					$('#objetivo').val(data.objetivo);
					$("#estadoPrograma").val(data.estado+"");
					$("#estadoPrograma").material_select();
					$("#vigenciaPrograma").val(data.vigencia+"");
					$("#vigenciaPrograma").material_select();
					$('#opcVinculacion>div').hide();
					$("#detallesPrograma").show("slow");
				}else{
					alert("No se ha podido mostrar los detalles de este programa");
				}
			}

		});
	}
	var aceptarProgramas = function (){
		var programa 	= $(this).val();
		var parametros	= "opc=aceptarPrograma"+"&programa="+programa;
		var r = confirm("¿Esta seguro que desea aceptar este programa ?");
		if(r){
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "../datos/vinculacion.php",
				data: parametros,
				success: function(data){
					if(data.respuesta){
						muestralistaprogramas();
					}else{
						alert("Este programa no ha podido ser aceptado");
					}
				}


			});


		}		
	}
	var rechazarProgramas = function(){
		var programa 	= $(this).val();
		var parametros	= "opc=rechazarPrograma"+"&programa="+programa;
				var r = confirm("¿Esta seguro que desea rechazar este programa ?");
				if(r){
					$.ajax({
						type: "POST",
						dataType: "json",
						url: "../datos/vinculacion.php",
						data: parametros,
						success: function(data){
							if(data.respuesta){
								muestralistaprogramas();
							}else{
								alert("Este programa no ha podido ser rechazado");
							}
						}


					});


				}		
	}
	var modificarPrograma = function(){
		event.preventDefault();
		var programa 	= $("#idPrograma").val();
		var estado 		= $("#estadoPrograma").val();
		var vigencia	= $("#vigenciaPrograma").val();
		var parametros  = "opc=modificarPrograma"+"&programa="+programa+"&estado="+estado+"&vigencia="+vigencia;

		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.modificar){
					var r = confirm("¿Esta seguro que desea modificar el programa ?");
					if(r){
						var parametros2 = "opc=guardarPrograma"+"&programa="+programa+"&estado="+estado+"&vigencia="+vigencia;
						$.ajax({
							type: "POST",
							dataType: "json",
							url:"../datos/vinculacion.php",
							data: parametros2,
							success:function(data){
								alert("Programa Modificado");
								muestralistaprogramas();
							}
						});
					}
				}else{
					muestralistaprogramas();
				}
			}
		});
	}
	var muestraAlumnos = function(){

		var parametros ="opc=muestraAlumnos";
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$('#opcVinculacion>div').hide();
					$("#tablaAlumnos").html("");
					$("#tablaAlumnos").append(data.tabla);
					$("#listadoAlumnos").show();
				}
				
			}
		});
		
	}

	var collapseAll=function(){
		$(".collapsible-header").removeClass(function(){
		    return "active";
		  });
		  $(".collapsible").collapsible({accordion: true});
	}

	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
	$("#tablaSolicitudes").on("click","#rechazar",rechazarSolicitudes);
	$("#tablaSolicitudes").on("click", "#detalles",verDetallesSolicitud);
	$("#frmDetallesSolicitud").on("submit",detallesSolicitud);
	
	$("#muestraProgramas").on("click",muestralistaprogramas);
	$("#tblprogramas").on("click","#detallesProgramas",detallesProgramas);
	$("#tblprogramas").on("click","#aceptar",aceptarProgramas);
	$("#tblprogramas").on("click","#rechazar",rechazarProgramas);
	$("#frmDetallesPrograma").on("submit",modificarPrograma);

	$("#muestraAlumnos").on("click", muestraAlumnos);
	//$("#txtbuscaTarjeta").on("keypress",buscarTarjeta);
	$("#menuregistroEmpresas").on("click",muestraRegEmpresas);
	$("#frmRegistroEmpresa").on("submit",registrarEmpresa);
	$("#menuregistroProgramas").on("click",muestraRegProgramas);
	$("#frmRegistroProgramas").on("submit",registroProgramas);

	$("#selprogdep").on("change", cargadepartamentos);
	$("#txtdepusuario").on('keyup',disponibilidad);
	$("#btnbuscaTarjeta").on("click",llenarTarjeta);

//	$("#frmDetallesAlumno").on("submit",modificarSolicitud);
	$("#badgeexpediente").on("click",documentosExpediente);
	$("#badgedatos").on("click",buscarTarjeta);
	$("#menuTarjeta").on("click",muestraTarjeta);

}
$(document).on("ready",admin);