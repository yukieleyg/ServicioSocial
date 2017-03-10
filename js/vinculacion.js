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
		$.confirm({
			title: 'Confirmación',
			content: "¿Esta seguro que desea aceptar la solicitud ?",
			buttons: {
				aceptar: {
					text: 'Aceptar',
					btnClass: 'waves-effect waves-light btn',
					keys: ['enter', 'shift'],
					action: function(){
						$.ajax({
							type: "POST",
							dataType: "json",
							url: "../datos/vinculacion.php",
							data: parametros,
							success: function(data){
								if(data.respuesta){
									alumnosSolicitudes();
									Materialize.toast("Solicitud Aceptada",4000);
								}else{
									$.alert("Esta solicitud no ha podido ser aceptada");
								}
							}


						});
					}
				},
				cancel: function () {
					$.alert("La solicitud no fue modificada");
				}
			}
		});	
	}
	var rechazarSolicitudes = function(){
		var solicitud 	= $(this).val();
		var parametros	= "opc=rechazarSolicitudes"+"&solicitud="+solicitud;
		$.confirm({
				title: 'Confirmación',
				content: "¿Esta seguro que desea rechazar la solicitud ?",
				buttons: {
					aceptar: {
						text: 'Aceptar',
						btnClass: 'waves-effect waves-light btn',
						keys: ['enter', 'shift'],
						action: function(){
							$.ajax({
								type: "POST",
								dataType: "json",
								url: "../datos/vinculacion.php",
								data: parametros,

								success: function(data){
									if(data.respuesta){
										Materialize.toast("Solicitud Rechazada",4000);
										alumnosSolicitudes();
									}else{
										$alert("Esta solicitud no ha podido ser rechazada");
									}
								}
							})
						}
					},
					cancel: function () {
						$.alert("La solicitud no fue modificada");
					}
				}
			});	
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
				 	$("#selprogdep").append('<option value="" disabled selected>Seleccione dependencia..</option>');
				 	var opcs=data.opciones;
				 	$("#selprogdep").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
	}

	var muestraRegProgramas= function(){
		llenaDepProgramas();
		llenaTipoProg();
		llenaCarreraPref();
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
		var anyInvalid=false;
		if($("#selprogdep").val()	=== '' ||
		$("#selprogdpto").val()	=== '' ||
		$("#selprogtipo").val()	=== '' ||
		$("#selprogest").val()	=== '' ||
		$("#selprogmod").val()	=== '' ||
		$("#selprogcar").val().length==0){
			anyInvalid=true;
		}
		if (anyInvalid) {
		    $.alert('Uno o más campos no tienen opcion seleccionada');
		    return false;
		}
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
				 if(data.respuesta){
				 	console.log("recibe");
				 	Materialize.toast(data.mensaje, 4000);
				 
 					$('input:not([type=radio],[type=submit])').val("");
 					$('textarea').val("");
 					$('input[type="radio"]').prop('checked', false);
 					$("#btnagregardpto").attr('disabled','disabled');
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
	var cargaFiltros = function(){
		var opcs = "";
		var value = $("#filtroProgramas").val();
		var parametros = "";
		if(value == '0'){
				opcs ='<option value= "0">Sin asignar</option><option value= "1">Vigente</option><option value= "2">Expirado</option>';
				$("#opcionProgramas").find('option').remove();
				$("#opcionProgramas").append(opcs).html();
				$("#opcionProgramas").material_select();
		}else if(value =='3'){
				opcs ='<option value= "0">Pendiente</option><option value= "1">Aceptado</option><option value= "2">Rechazado</option>';
				$("#opcionProgramas").find('option').remove();
				$("#opcionProgramas").append(opcs).html();
				$("#opcionProgramas").material_select();

		}else{
			 	parametros = "opc=consultaFiltro"+"&value="+value;
				$.ajax({
				type: "POST",
				dataType: "json",
				url: "../datos/vinculacion.php",
				data: parametros,
				success: function(data){
					if(data.respuesta){
						opcs = data.opciones;
						$("#opcionProgramas").find('option').remove();
						$("#opcionProgramas").append(opcs).html();
						$("#opcionProgramas").material_select();
					}
				}

			});
		}
	}
	var cargaVigencia = function(){
		var value = $("#estadoPrograma").val();
		if(value == '0'){//PENDIENTE
			$("#vigenciaPrograma").val(0+"");
			$("#vigenciaPrograma").attr('disabled','disabled');
			$("#vigenciaPrograma").material_select();

		}else if(value == '1'){//ACEPTADO
			$("#vigenciaPrograma").attr('disabled',false);
			$("#vigenciaPrograma").material_select();

		}else if(value == '2'){//RECHAZADO
			$("#vigenciaPrograma").val(0+"");
			$("#vigenciaPrograma").attr('disabled','disabled');
			

		}
	}
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
				 	$("#selprogdpto").append('<option value="" disabled selected>Seleccione departamento..</option>');
				 	$("#selprogdpto").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
		if($("#selprogdep").val()!=""){
			$("#btnagregardpto").attr('disabled',false);
		}
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
                    Materialize.toast('Problem with sql query');
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
		/*$("#icartaap").attr("href", "");
		$("#iplantra").attr("href", "");
		$("#irepouno").attr("href", "");
		$("#irepodos").attr("href", "");
		$("#irepotres").attr("href", "");
		$("#icartaterm").attr("href", "");*/
		$(".ligadoc").attr("href","").hide();

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
						$.each(data.documentos, function( i, value ) {
						  switch(i){
						  	case '1': console.log("Esta es una solicitud");
						  		break;
						  	case '2': 
						  	$("#cartaap").prop("checked", true);
						  	$("#icartaap").show();
						  	$("#icartaap").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es una cartaA");
						  		break;
						  	case '3': 
						  	$("#plantra").prop("checked",true);
						  	$("#iplantra").show();
						  	$("#iplantra").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es un plantrabajo");
						  		break;
						  	case '4': 
						  	$("#repouno").prop("checked",true);
						  	$("#irepouno").show();
						  	$("#irepouno").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es un reporteuno");
						  		break;
						  	case '5': 
						  	$("#repodos").prop("checked",true);
						  	$("#irepodos").show();
						  	$("#irepodos").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es un reportedos");
						  		break;
						  	case '6': 
							$("#repotres").prop("checked",true);
						  	$("#irepotres").show();
							$("#irepotres").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es un reportetres");
						  		break;
						  	case '7': 
						  	$("#cartaterm").prop("checked",true);
						  	$("#icartaterm").show();
						  	$("#icartaterm").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');						  	
						  	console.log("Esta es una cartaterminacion");
						  		break;
						  }
						});

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
						$.confirm({
							title: "Confirmación",
							content: "¿Esta seguro que desea modificar la solicitud?",
							buttons: {
								aceptar: {
									text: 'Aceptar',
									btnClass: 'waves-effect waves-light btn',
									keys: ['enter', 'shift'],
									action: function(){
										var parametros2 = "opc=modificarSolicitud"+"&solicitud="+solicitud+"&estado="+estado+"&motivo="+motivo+"&observaciones="+observaciones;	
										$.ajax({
											type: "POST",
											dataType: "json",
											url:"../datos/vinculacion.php",
											data: parametros2,
												success: function(dataM){
													if(dataM.respuestaM){
														Materialize.toast("Modificación Exitosa",4000);
														$('#divDetalles').hide();
														alumnosSolicitudes();
													}else{
														if(dataM.borrarExp){
															$.alert("No se puede modificar la solicitud");
															$('#divDetalles').hide();
															alumnosSolicitudes();	
														}else{
															$.alert("No se puede modificar el estado de la solicitud debido a que tiene un expediente existente");
															$('#divDetalles').hide();
															alumnosSolicitudes();											
														}								
													}
												}


										});
									}
								},
								cancel: function (){
									$.alert("No se modifico la solicitud");
								}
							}
						});
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
					$("#vacantesInput").val(data.vacantes);
					$("#alumnosInput").val(data.totalAlumnos);
					$("#alumnosInput").attr('disabled', 'disabled');
					var listacar = $.map(data.carreras.split(','), function(name){
					    return ''+name+'\n'
					}).join('');
					$("#carrerapref").val(listacar).trigger('autoresize');
					if(data.estado == '1' && data.expedientes) {	
						//	SE DESHABILITA EL ESTADO DEBIDO A QUE TIENE EXPEDIENTES EN PROCESO NO PUEDE SER MODIFICADO			
						$("#estadoPrograma").val(data.estado+"");
						$("#estadoPrograma").attr('disabled','disabled');
						$("#estadoPrograma").material_select();
						$("#vigenciaPrograma").val(data.vigencia+"");
						$("#vigenciaPrograma").attr('disabled','disabled');
						$("#vigenciaPrograma").material_select();
					}else if( data.estado == '0' || data.estado == '2'){
						$("#estadoPrograma").val(data.estado+"");
						$("#estadoPrograma").material_select();
						$("#vigenciaPrograma").val(data.vigencia+"");
						$("#vigenciaPrograma").attr('disabled','disabled');
						$("#vigenciaPrograma").material_select();	

					}else{
						$("#estadoPrograma").attr('disabled',false);
						$("#vigenciaPrograma").attr('disabled',false);
						$("#estadoPrograma").val(data.estado+"");
						$("#estadoPrograma").material_select();
						$("#vigenciaPrograma").val(data.vigencia+"");
						$("#vigenciaPrograma").material_select();
						
					}
					$('#opcVinculacion>div').hide();
					$("#detallesPrograma").show("slow");
				}else{
					Materialize.toast("No se ha podido mostrar los detalles de el programa",4000);
				}
			}

		});
	}
	var aceptarProgramas = function (){
		var programa 	= $(this).val();
		var parametros	= "opc=aceptarPrograma"+"&programa="+programa;
		$.confirm({
			title: 'Confirmación',
			content: "¿Esta seguro que desea aceptar el programa ?",
			buttons: {
				aceptar: {
					text: 'Aceptar',
					btnClass: 'waves-effect waves-light btn',
					keys: ['enter', 'shift'],
					action: function(){
						$.ajax({
							type: "POST",
							dataType: "json",
							url: "../datos/vinculacion.php",
							data: parametros,
							success: function(data){
								if(data.respuesta){
									muestralistaprogramas();
									Materialize.toast("Programa Aceptado",4000);
								}else{
									$.alert("El programa no ha podido ser aceptado");
								}
							}


						});
					}
				},
				cancel: function () {
					$.alert("El programa no fue modificado");
				}
			}
		});
	}
	var rechazarProgramas = function(){
		var programa 	= $(this).val();
		var parametros	= "opc=rechazarPrograma"+"&programa="+programa;
			$.confirm({
				title: 'Confirmación',
				content: "¿Esta seguro que desea rechazar el programa ?",
				buttons: {
					aceptar: {
						text: 'Aceptar',
						btnClass: 'waves-effect waves-light btn',
						keys: ['enter', 'shift'],
						action: function(){
							$.ajax({
								type: "POST",
								dataType: "json",
								url: "../datos/vinculacion.php",
								data: parametros,
								success: function(data){
									if(data.respuesta){
										muestralistaprogramas();
										Materialize.toast("Programa Rechazado",4000);
									}else{
										$.alert("El programa no ha podido ser rechazado");
									}
								}


							});
						}
					},
					cancel: function () {
						$.alert("El programa no fue modificado");
					}
				}
			});
	
	}
	var modificarPrograma = function(){
		event.preventDefault();
		var programa 	= $("#idPrograma").val();
		var estado 		= $("#estadoPrograma").val();
		var vigencia	= $("#vigenciaPrograma").val();
		var vacantes    = $("#vacantesInput").val();
		var parametros  = "opc=modificarPrograma"+"&programa="+programa+"&estado="+estado+"&vigencia="+vigencia+"&vacantes="+vacantes;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.modificar){
					if(data.solicitudes){
						var mensaje = "Este programa tiene solicitudes, estas se eliminaran ¿Esta seguro que desea modificar el programa ?"
					}else{
						var mensaje = "¿Esta seguro que desea modificar el programa ?";
					}
					var solicitudes = data.solicitudes;
					$.confirm({
						title: 'Confirmación',
						content: mensaje,
						buttons: {
							aceptar: {
								text: 'Aceptar',
								btnClass: 'waves-effect waves-light btn',
								keys: ['enter', 'shift'],
								action: function(){
									var parametros2 = "opc=guardarPrograma"+"&programa="+programa+"&estado="+estado+"&vigencia="+vigencia+"&solicitudes="+solicitudes+"&vacantes="+vacantes;
									$.ajax({
										type: "POST",
										dataType: "json",
										url:"../datos/vinculacion.php",
										data: parametros2,
										success:function(data){
											if(data.respuesta){
												Materialize.toast("Modificación Exitosa",4000);
												muestralistaprogramas();
											}
										}
									});
								}
							},
							cancel: function () {
								$.alert("El programa no fue modificado");
								muestralistaprogramas();

							}
						}
					});
				}else{
					if(data.modificarVacantes){
							$.confirm({
								title: 'Confirmación',
								content: "¿Esta seguro que desea modificar el numero de vacantes del programa?",
								buttons: {
									aceptar: {
										text: 'Aceptar',
										btnClass: 'waves-effect waves-light btn',
										keys: ['enter', 'shift'],
										action: function(){
											var parametros2 = "opc=guardarPrograma"+"&programa="+programa+"&estado="+estado+"&vigencia="+vigencia+"&solicitudes="+false+"&vacantes="+vacantes;
											$.ajax({
												type: "POST",
												dataType: "json",
												url:"../datos/vinculacion.php",
												data: parametros2,
												success:function(data){
													if(data.respuesta){
														Materialize.toast("Modificación Exitosa",4000);
														muestralistaprogramas();
													}
												}
											});
										}
									},
									cancel: function () {
										$.alert("El programa no fue modificado");
										muestralistaprogramas();

									}
								}
							});
					}else{
						muestralistaprogramas();
					}
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

	var llenaTipoProg=	function(){
		var parametros = $("#selprogtipo").val()+"&opc=llenaTipoProg"+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	var opcs=data.opciones;
				 	$("#selprogtipo").find('option').remove();
				 	$("#selprogtipo").append('<option value="" disabled selected>Seleccione un tipo de programa..</option>');
				 	$("#selprogtipo").append(opcs).html();
				 	$('#selprogtipo').material_select();
				 }			 
				}
		});
	}
	var llenaCarreraPref=	function(){
		console.log("ALGO");
		var parametros = $("#selprogcar").val()+"&opc=llenaCarreraPref"+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	console.log(data.opciones);
				 	var opcs=data.opciones;
				 	$("#selprogcar").find('option').remove();
				 	$("#selprogcar").append('<option value="" disabled selected>Seleccione carrera preferente..</option>');
				 	$("#selprogcar").append(opcs).html();
				 	$("#selprogcar").material_select();
				 }			 
				}
		});
	}
	var filtroSolicitudes = function(){
		var value = $("#filtroSolicitudes").val();
		var parametros= "opc=consultaPeriodos";
		$.ajax({
			type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				if(data.respuesta==true){
					var opcs = data.periodos;
				 	$("#filtroPeriodo").find('option').remove();
				 	$("#filtroPeriodo").append(opcs).html();
				 	$("#filtroPeriodo").material_select();
				 }			 
				}
		});
		switch(value){
			case '0':  
					opcs="<option value='0'>Pendiente</option><option value='1'>Aceptado</option><option value='2'>Rechazado</option>"
					$("#opcionSolicitudes").find('option').remove();
					$("#opcionSolicitudes").append(opcs).html();
					$("#opcionSolicitudes").material_select();
					$("#opcionSolicitudesNC").hide();
					$("#opcionPeriodo").show();
					$("#opcionSolicitudesDiv").show();
			break;
			case '1': 
				var parametros = "opc=consultaFiltroSolicitudes";
				var opcs= "";
				$.ajax({
					type: "POST",
					dataType: "json",
					url:"../datos/vinculacion.php",
					data: parametros,
					success: function(data){
					// alert(data.opciones);
					 if(data.respuesta==true){
					  	opcs=data.opciones;
					 	$("#opcionPeriodo").show();
					 	$("#opcionSolicitudes").find('option').remove();
					 	$("#opcionSolicitudes").append(opcs).html();
					 	$("#opcionSolicitudes").material_select();
					 	$("#opcionSolicitudesNC").hide();
						$("#opcionSolicitudesDiv").show();
					 }			 
					}
				});
			break;
			case '2': 
				$("#opcionPeriodo").hide();
				$("#opcionSolicitudesDiv").hide();
				$("#opcionSolicitudesNC").show();
			break;
		}
	}
	var filtroAlumnos = function(){
		var value = $("#filtroAlumnos").val();
		var parametros= "opc=consultaPeriodos";
		$.ajax({
			type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				if(data.respuesta==true){
					var opcs = data.periodos;
				 	$("#filtroPeriodoAlumnos").find('option').remove();
				 	$("#filtroPeriodoAlumnos").append(opcs).html();
				 	$("#filtroPeriodoAlumnos").material_select();
				 }			 
				}
		});
		if(value =='2'){
			$("#opcionPeriodoAlumnos").show();
			opcs ='<option value= "1">Captura</option><option value= "2">Finalizado</option>';
			$("#opcionAlumnosNC").hide();
			$("#opcionAlumnosDiv").show();
			$("#opcionAlumnos").find('option').remove();
			$("#opcionAlumnos").append(opcs).html();
			$("#opcionAlumnos").material_select();
		}else{
				var parametros = "opc=consultaFiltro"+"&value="+value;
				$.ajax({
					type: "POST",
					dataType: "json",
					url:"../datos/vinculacion.php",
					data: parametros,
					success: function(data){
					 if(data.respuesta==true){
					 	var opcs=data.opciones;
						$("#opcionPeriodoAlumnos").show();
					 	$("#opcionAlumnosNC").hide();
						$("#opcionAlumnosDiv").show();
					 	$("#opcionAlumnos").find('option').remove();
					 	$("#opcionAlumnos").append(opcs).html();
					 	$("#opcionAlumnos").material_select();
					 }			 
					}
				});
		}
	}
	var agregarDepartamento	= function(){
		$.confirm({
		    title: 'Agregar departamento',
		    content:  '' +
    '<form action="" class="formName">' +
	    '<div>' +
		    '<label>Nombre Departamento</label>' +
		    '<input type="text" placeholder="Nombre Departamento" class="name" id="agdpto" required />' +
	    '</div>' +
    '</form>',
		    buttons: {
		        confirm: {
		            text: 'Agregar',
		            btnClass: 'btn-blue',
		            action: function () {
		                var name = this.$content.find('.name').val();
		                if(!name){
		                    $.alert('Ingrese el nombre del departamento');
		                    return false;
		                }
		                var dep=$("#selprogdep").val();
		                test(name,dep);

		            },
		            
		        },
		        cancel: {
		        	text: 'Cancelar',
		        	function () {
		            //close
		        	},
		        }
		    },
		    onContentReady: function () {
		        // bind to events
		        var jc = this;
		        this.$content.find('form').on('submit', function (e) {
		            // if the user submits the form by pressing enter in the field.
		            e.preventDefault();
		            jc.$$formSubmit.trigger('click'); // reference the button and click it
		        });
		    },
		    onDestroy: function(){
		    	var lastOpc=$("#selprogdpto").find('option').length-1;
		    	$("#selprogdpto").prop('selectedIndex',lastOpc);
		    	$("#selprogdpto").material_select();
		    }
		});
	}
	var test = function(name,dependencia){
		var parametros = "opc=agregarDepartamento"+"&dependencia="+dependencia+"&nombre="+name+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta){
				 	$.alert('Se ha registrado el departamento: '+name);
				 	cargadepartamentos();
				 }else{
				 	Materialize.toast(data.mensaje, 4000);
				 }
				}

			});
	}
	var expedienteAlumno = function(){
		var nocontrol = $("#expediente").val();
		$("#txtbuscaTarjeta").val(nocontrol);
		llenarTarjeta();
		muestraTarjeta();		
	}
	var filtrarAlumnos = function(){
		var filtro 		= $("#filtroAlumnos").val();
		var opcion		= $("#opcionAlumnos").val();
		var periodo 	= $("#filtroPeriodoAlumnos").val();
		var parametros = "opc=filtrarAlumnos"+"&opcion="+opcion+"&filtro="+filtro+"&periodo="+periodo;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
			 if(data.respuesta==true){
			 	$("#tablaAlumnos").html("");
				$("#tablaAlumnos").append(data.tabla);
				$("#listadoAlumnos").show();
			 }			 
			}
		});
	}
	var filtrarSolicitudes = function(){
		var filtro 	= $("#filtroSolicitudes").val();
		var opcion 	= $("#opcionSolicitudes").val();
		var periodo 	= $("#filtroPeriodo").val();
		var nocontrol 	= $("#filtroNoControlSolicitudes").val();
		var parametros = "opc=filtrarSolicitudes"+"&filtro="+filtro+"&opcion="+opcion+"&periodo="+periodo+"&nocontrol="+nocontrol;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function (data){
				if(data.respuesta== true){
					$("#tablaSolicitudes").html("");
					$("#tablaSolicitudes").append(data.tabla);
					$("#listadoSolicitudes").show();
				}
			}

		});
	}
	var filtrarProgramas = function(){
		var filtro 	= $("#filtroProgramas").val();
		var opcion 	= $("#opcionProgramas").val();
		var parametros = "opc=filtrarProgramas"+"&filtro="+filtro+"&opcion="+opcion;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function (data){
				if(data.respuesta== true){
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.tabla);
					$("#listadoProgramas").show();
				}
			}

		});
	}
	var muestraResultados = function(){
		var parametros ="opc=mostrarResultados";
		event.preventDefault();
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta==true){
					$('#opcVinculacion>div').hide();
					$('#listadoResultados').show("slow");
					$('#ulResultados').html(data.ul);
					
				}
			}

		});

	}
	var cambioClave = function(){
		$('#opcVinculacion>div').hide();
		$('#cambioClave').show("slow");
	}
	var guardarNuevaClave = function(){
		var user 			= $("#txtUsuario").val();
		var claveActual 	= $("#txtClaveActual").val();
		var nuevaClave  	= $("#txtClaveNueva").val();
		var confNuevaClave 	= $("#txtClaveNuevaConfirmacion").val();
		var parametros 		= "opc=guardarNuevaClave"+"&nuevaClave="+nuevaClave+"&claveActual="+claveActual+"&user="+user;
		if(nuevaClave == confNuevaClave ){
			if(nuevaClave.length<8){
				Materialize.toast("La contraseña debe contener al menos 8 caracteres",4000);
			}else{
				$.ajax({
					type:"POST",
					dataType: "json",
					url: "../datos/vinculacion.php",
					data: parametros,
					success: function (data){
						if(data.respuesta== true){
							Materialize.toast("Contraseña Modificada",4000);
							$("#txtClaveNuevaConfirmacion").val("");
							$("#txtClaveActual").val("");
							$("#txtClaveNueva").val("");
							$('#cambioClave').hide();
						}else{
							Materialize.toast("La contraseña actual es incorrecta",4000);
							$("#txtClaveNuevaConfirmacion").val("");
							$("#txtClaveActual").val("");
							$("#txtClaveNueva").val("");
						}
					}			
				});	
			}		
		}else{
				Materialize.toast("Las Contraseñas no coinciden",4000);
				$("#txtClaveNuevaConfirmacion").val("");
				$("#txtClaveActual").val("");
				$("#txtClaveNueva").val("");
		}

	}
	$("#muestraSolicitudes").on("click",alumnosSolicitudes);
	$("#tablaSolicitudes").on("click","#aceptar",aceptarSolicitudes);
	$("#tablaSolicitudes").on("click","#rechazar",rechazarSolicitudes);
	$("#tablaSolicitudes").on("click", "#detalles",verDetallesSolicitud);
	$("#frmDetallesSolicitud").on("submit",detallesSolicitud);
	$("#filtroSolicitudes").on("change",filtroSolicitudes);
	$("#btnFiltroSolicitudes").on("click",filtrarSolicitudes);
	
	$("#muestraProgramas").on("click",muestralistaprogramas);
	$("#tblprogramas").on("click","#detallesProgramas",detallesProgramas);
	$("#tblprogramas").on("click","#aceptar",aceptarProgramas);
	$("#tblprogramas").on("click","#rechazar",rechazarProgramas);
	$("#frmDetallesPrograma").on("submit",modificarPrograma);
	$("#estadoPrograma").on("change", cargaVigencia);
	$("#filtroProgramas").on("change",cargaFiltros);
	$("#btnFiltroProgramas").on("click",filtrarProgramas);

	$("#muestraAlumnos").on("click", muestraAlumnos);
	$("#filtroAlumnos").on("change",filtroAlumnos);
	$("#tablaAlumnos").on("click","#expediente",expedienteAlumno);
	$("#btnFiltroAlumnos").on("click", filtrarAlumnos);

	//$("#txtbuscaTarjeta").on("keypress",buscarTarjeta);
	$("#menuregistroEmpresas").on("click",muestraRegEmpresas);
	$("#frmRegistroEmpresa").on("submit",registrarEmpresa);
	$("#menuregistroProgramas").on("click",muestraRegProgramas);
	$("#frmRegistroProgramas").on("submit",registroProgramas);

	$("#selprogdep").on("change", cargadepartamentos);
	$("#txtdepusuario").on('keyup',disponibilidad);
	$("#btnbuscaTarjeta").on("click",llenarTarjeta);

	$("#badgeexpediente").on("click",documentosExpediente);
	$("#badgedatos").on("click",buscarTarjeta);
	$("#menuTarjeta").on("click",muestraTarjeta);
	$("#btnagregardpto").on("click",agregarDepartamento);

	$("#muestraResultados").on("click",muestraResultados);
	$("#btnCambioClave").on("click",cambioClave);
	$("#btnGuardarNuevaClave").on("click",guardarNuevaClave);

}
$(document).on("ready",admin);