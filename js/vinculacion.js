var admin = function (){
	var parametros="";
	const TECLA_ENTER = 13;
	var alumnosSolicitudes = function(){
		var pagina 	= $(this).val();
		if(pagina == ""){
			pagina =1;
		}
		funcionAlumnosSolicitudes(pagina);
		
	}
	var funcionAlumnosSolicitudes = function(pagina){
		var parametros 	= "opc=muestraSolicitudes"+"&pagina="+pagina;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$('#opcVinculacion>div').hide();
					$("#filtroSolicitudes").attr('disabled',false);
					$("#opcionSolicitudes").attr('disabled',false);
					$("#filtroPeriodo").attr('disabled',false);
					$("#filtroNoControlSolicitudes").attr('disabled','disabled');
					$("#filtroNoControlSolicitudes").val("");
					$("#btnFiltroSolicitudes").attr('disabled',false);
					$("#opcionSolicitudes").find('option').remove();
					$("#filtroPeriodo").find('option').remove();
		    		$("#filtroSolicitudes").prop('selectedIndex',0);
					$("#opcionSolicitudes").material_select();
					$("#filtroPeriodo").material_select();
		    		$("#filtroSolicitudes").material_select();
					$('#btnClearFiltroSol').attr('disabled','disabled');
					$('#opcVinculacion>div').hide();
					$("#tablaSolicitudes").html("");
					$("#tablaSolicitudes").append(data.tabla);
					$("#paginacionSolicitudes").html("");
					$("#paginacionSolicitudes").append(data.botones);
					$("#listadoSolicitudes").show();
					$("#opcionActualSol").val(2);					
					$("#paginaActualSol").val(pagina);
				}else{
					funcionAlumnosSolicitudes(1);
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
										var opcion = 	$("#opcionActualSol").val();
										var pagina =	$("#paginaActualSol").val();
										if(opcion == 1){
												funcionFiltrarSolicitudes(pagina);
										}else{
												funcionAlumnosSolicitudes(pagina);
										}
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
										var opcion = 	$("#opcionActualSol").val();
										var pagina = 	$("#paginaActualSol").val();
										if(opcion == 1){
												funcionFiltrarSolicitudes(pagina);
										}else{
												funcionAlumnosSolicitudes(pagina);
										}
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
	var muestralistaprogramas =function(){
		var pagina = $(this).val();
		if(pagina== ""){
			pagina =1;
		}
		$("#paginaActualG").val(1);
		funMuestraListaProgramas(pagina);

	}
	var funMuestraListaProgramas = function(pagina){
		var parametros="opc=tablaprogramas"+"&pagina="+pagina;
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data:parametros,
			success: function(data){
				if(data.respuesta==true){
					$("#opcionActual").val(1);
					$("#opcionProgramas").find('option').remove();
		    		$("#filtroProgramas").prop('selectedIndex',0);
					$("#btnClearFiltroPro").attr('disabled','disabled');
					$("#btnFiltroProgramas").attr('disabled',false);
					$("#filtroProgramas").attr('disabled',false);
					$("#opcionProgramas").attr('disabled',false);
					$("#filtroProgramas").material_select();
					$("#opcionProgramas").material_select();
					$('#opcVinculacion>div').hide();
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.renglones);
					$("#botonesProgramas").html("");
					$("#botonesProgramas").append(data.botones);
					$("#listadoProgramas").show();
					$("#paginaActualG").val(pagina);

				}else{
					funMuestraListaProgramas(1);

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
						$("#cveexpediente").val(data.cveexpediente);
						if(data.cvesolicitud!=""){
								$("#solicitud").prop("checked",true);
								$("#isolicitudEmpty").hide();
								$("#isolicitud").show();
								$("#isolicitud").attr("href", '../datos/descargarArchivos.php?solicitud='+data.cvesolicitud);
						}
					
						$.each(data.documentos, function( i, value ) {
							//estado de revision del documento
							var estado ='';
							switch(value.revisado){
							  		case '0':
							  			estado = 'Pendiente';
							  			break;
							  		case '1': 
							  			estado = 'Aceptado';
							  			break;
							  		case '2':
							  			estado = 'Rechazado';
							  			break;
						  		}	

							//opcion por tipo de documento
						  switch(i){
						  	case '1': 
						  		$("#estadoSolicitud").val(estado);	
						  		break;
						  	case '2': 
						  	$("#cartaap").prop("checked", true);
						  	$("#icartaapEmpty").hide();
						  	$("#icartaap").show();
						  	$("#icartaap").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
						  	$("#estadoCartaAp").val(estado);
						  	if(estado=='Pendiente'){
						  		$("#aceptarCartaApr").attr('disabled',false);
						  		$("#rechazarCartaApr").attr('disabled',false);
						  	}else{
						  		$("#aceptarCartaApr").attr('disabled',true);
						  		$("#rechazarCartaApr").attr('disabled',true);
						  	}
						  	$("#aceptarCartaApr").val(value.cvedoc);
							$("#rechazarCartaApr").val(value.cvedoc);	
						  		break;
						  	case '3': 
						  	$("#plantra").prop("checked",true);
						  	$("#iplantraEmpty").hide();
						  	$("#iplantra").show();
						  	$("#iplantra").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
							$("#estadoPlanTra").val(estado); 
							if(estado=='Pendiente'){
						  		$("#aceptarPlanTra").attr('disabled',false);
						  		$("#rechazarPlanTra").attr('disabled',false);
						  	}else{
						  		$("#aceptarPlanTra").attr('disabled',true);
						  		$("#rechazarPlanTra").attr('disabled',true);
						  	} 
						  	$("#aceptarPlanTra").val(value.cvedoc);
							$("#rechazarPlanTra").val(value.cvedoc);	
						  		break;
						  	case '7': 
						  	$("#cartaterm").prop("checked",true);
						  	$("#icartatermEmpty").hide();
						  	$("#icartaterm").show();
						  	$("#icartaterm").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
						  		break;
						  }
						});
						$("#controlexpediente1").show("slow");
					}
				}
			});
	}
	var reportesExpediente=function(nocontrol){
		var ncontrol = $("#txtbuscaTarjeta").val();
		$("#btnmodalcalificar").show();
		$("#calTotal1","#calTotal2","#calTotal3").attr('type','hidden').val("");
		if(ncontrol==""){
			Materialize.toast('Ingresa el No. de Control', 4000);
			collapseAll();
			return;
		}
		var parametros ="opc=reportesExpediente"+"&ncontrol="+ncontrol;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/vinculacion.php",
				data: parametros,

				success: function(data){
					if(data.respuesta==false){
						collapseAll();
						Materialize.toast('No hay reportes entregados', 4000);
					}else{
						$("#cveexpediente").val(data.cveexpediente);
						$.each(data.reportes, function( i, value ) {
							if(parseInt(value.califVinc)>0 && estado!=0){
								$("#calTotal"+i+"").val(value.califTotal);
								$("#btnmodalcalificar[value='"+i+"']").hide();
								$("#calTotal"+i+"").attr('type','text').css("width","50%");				
							}
							//estado del reporte
							var estado ='';
						  	switch(value.estado){
						  		case '0': 
						  			estado = 'Sin revisar';
						  			break;
						  		case '1': 
						  			estado = 'Aceptado';	
						  			break;
						  		case '2':
						  			estado = 'Rechazado';
						  			break;
						  	}
							//opcion por numero de reporte
						  switch(i){	
						  	case '1': 
						  	$("#repouno").prop("checked",true);
						  	$("#irepounoEmpty").hide();
						  	$("#irepouno").show();
						  	$("#irepouno").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
						  	$("#btnmc1").val(value.cvereporte);						  	
							$("#estadoRepUno").val(estado);
							if(value.estado==0){$("#btnmodalcalificar[value='"+i+"']").attr("disabled",false);}
						  	$("#calEmpR1").val(value.califEmp);				  							  	
						  		break;
						  	case '2': 
						  	$("#repodos").prop("checked",true);
						  	$("#irepodosEmpty").hide();
						  	$("#irepodos").show();
						  	$("#irepodos").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
						  	$("#btnmc2").val(value.cvereporte);									  	
						  	$("#estadoRepDos").val(estado);
						  	if(value.estado==0){$("#btnmodalcalificar[value='"+i+"']").attr("disabled",false);}
						  	$("#calEmpR2").val(value.califEmp);						  							  	
						  		break;
						  	case '3': 
							$("#repotres").prop("checked",true);
						  	$("#irepotresEmpty").hide();
						  	$("#irepotres").show();
							$("#irepotres").attr("href", '../datos/EXPEDIENTES/'+ncontrol+'/'+value.ruta+'');
							$("#btnmc3").val(value.cvereporte);									  	
							$("#estadoRepTres").val(estado);
							if(value.estado==0){$("#btnmodalcalificar[value='"+i+"']").attr("disabled",false);}
						  	$("#calEmpR3").val(value.califEmp);						  	
						  		break;
						  }
						});
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
														var opcion = 	$("#opcionActualSol").val();
														var pagina = 	$("#paginaActualSol").val();
														if(opcion == 1){
																funcionFiltrarSolicitudes(pagina);
														}else{
																funcionAlumnosSolicitudes(pagina);
														}
													}else{
														if(dataM.borrarExp){
															$.alert("No se puede modificar la solicitud");
															$('#divDetalles').hide();
															var opcion = 	$("#opcionActualSol").val();
															var pagina = 	$("#paginaActualSol").val();
																if(opcion == 1){
																		funcionFiltrarSolicitudes(pagina);
																}else{
																		funcionAlumnosSolicitudes(pagina);
																}
														}else{
															$.alert("No se puede modificar el estado de la solicitud debido a que tiene un expediente existente");
															$('#divDetalles').hide();
															var opcion = 	$("#opcionActualSol").val();
															var pagina = 	$("#paginaActualSol").val();
																if(opcion == 1){
																		funcionFiltrarSolicitudes(pagina);
																}else{
																		funcionAlumnosSolicitudes(pagina);
																}										
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
							var opcion = 	$("#opcionActualSol").val();
						 	var pagina = 	$("#paginaActualSol").val();
							if(opcion == 1){
									funcionFiltrarSolicitudes(pagina);
							}else{
									funcionAlumnosSolicitudes(pagina);
							}
					}
				}
			});	
	}
	var llenarTarjeta=function(){
		//fn para llenar los badges de la tarjeta
		documentosExpediente();
		reportesExpediente();
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
					$('#nombrePrograma').val(data.nombreP);
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
									var opcion = $("#opcionActual").val();
									var pagina = $("#paginaActualG").val();
									if(opcion == 1){
											funMuestraListaProgramas(pagina);
									}else{
											mostrarProgramasFiltro(pagina);
									}
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
										var opcion = $("#opcionActual").val();
										var pagina = $("#paginaActualG").val();
										if(opcion == 1){
											funMuestraListaProgramas(pagina);
										}else{
											mostrarProgramasFiltro(pagina);
										}
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
												var opcion = $("#opcionActual").val();
												var pagina = $("#paginaActualG").val();
												if(opcion == 1){
														funMuestraListaProgramas(pagina);
												}else{
														mostrarProgramasFiltro(pagina);
												}
											}
										}
									});
								}
							},
							cancel: function () {
								$.alert("El programa no fue modificado");
								var opcion = $("#opcionActual").val();
								var pagina = $("#paginaActualG").val();
									if(opcion == 1){
											funMuestraListaProgramas(pagina);
									}else{
											mostrarProgramasFiltro(pagina);
									}

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
														var opcion = $("#opcionActual").val();
														var pagina = $("#paginaActualG").val();
															if(opcion == 1){
																	funMuestraListaProgramas(pagina);
															}else{
																	mostrarProgramasFiltro(pagina);
															}

														}	
												}
											});
										}
									},
									cancel: function () {
										$.alert("El programa no fue modificado");
										var opcion = $("#opcionActual").val();
										var pagina = $("#paginaActualG").val();
											if(opcion == 1){
													funMuestraListaProgramas(pagina);
											}else{
													mostrarProgramasFiltro(pagina);
											}


									}
								}
							});
					}else{
						var opcion = $("#opcionActual").val();
						var pagina = $("#paginaActualG").val();
							if(opcion == 1){
									funMuestraListaProgramas(pagina);
							}else{
									mostrarProgramasFiltro(pagina);
							}

					}
				}
			}
		});
	}
	var nextMuestraAlumnos= function(){
		var paginaActual = $("#valorPaginaA").val();
		var pagina 		 = parseInt(paginaActual)+1;
		if(pagina== ""){
			pagina =1;
		}
		funMuestraAlumnos(pagina);
	}

	var previousMuestraAlumnos= function(){
		var paginaActual 	= $("#valorPaginaA").val();
		var pagina 			= parseInt(paginaActual)-1;
		funMuestraAlumnos(pagina);
	
	}
	var muestraAlumnos = function(){
		var pagina = 1;
		funMuestraAlumnos(1);
	}
	var btnMuestraAlumnos = function(){
		var pagina 	= $(this).val();
		funMuestraAlumnos(pagina);
	}
	var funMuestraAlumnos = function(pagina){
		var parametros ="opc=muestraAlumnos"+"&pagina="+pagina;
		$("#btnClearFiltroAlu").attr('disabled','disabled');
		$('#opcVinculacion>div').hide();
		$("#tablaAlumnos").html("");
		$("#paginacionAlumnos").html(" ");
		$("#loadAlumnos").show();
		$("#listadoAlumnos").show();
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$("#tablaAlumnos").append(data.tabla);
					$("#paginacionAlumnos").append(data.botones);
					$("#loadAlumnos").hide();
					$("#valorPaginaA").val(pagina);
				}else{
			 		Materialize.toast("No se encuentran registros",4000);
			 		muestraAlumnos();
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
				$("#filtroNoControlSolicitudes").attr('disabled',false);
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
		var pagina = 1;
		funFiltrarAlumnos(pagina);
	}
	var btnFiltrarAlumnos =	function(){
		var pagina = $(this).val();
		funFiltrarAlumnos(pagina);
	}
	var nextMuestraAlumnosF = function(){
		var paginaActual = $("#valorPaginaAF").val();
		var pagina 		 = parseInt(paginaActual)+1;
		funFiltrarAlumnos(pagina);
	}

	var previousMuestraAlumnosF = function(){
		var paginaActual 	= $("#valorPaginaAF").val();
		var pagina 			= parseInt(paginaActual)-1;
		funFiltrarAlumnos(pagina);
	
	} 
	var funFiltrarAlumnos = function(pagina){
		$('#opcVinculacion>div').hide();
		$("#tablaAlumnos").html("");
		$("#paginacionAlumnos").html(" ");
		$("#loadAlumnos").show();
		$("#listadoAlumnos").show();
		$("#btnClearFiltroAlu").attr('disabled',false);
		$("#btnFiltroAlumnos").attr('disabled','disabled');
		$("#filtroAlumnos").attr('disabled','disabled');		
		$("#opcionAlumnos").attr('disabled','disabled');
		$("#filtroPeriodoAlumnos").attr('disabled','disabled');
		$("#filtroAlumnos").material_select();		
		$("#opcionAlumnos").material_select();
		$("#filtroPeriodoAlumnos").material_select();
		var filtro 		= $("#filtroAlumnos").val();
		var opcion		= $("#opcionAlumnos").val();
		var periodo 	= $("#filtroPeriodoAlumnos").val();
		var parametros = "opc=filtrarAlumnos"+"&opcion="+opcion+"&filtro="+filtro+"&periodo="+periodo+"&pagina="+pagina;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
			 if(data.respuesta==true){
				$("#tablaAlumnos").append(data.tabla);
				$("#paginacionAlumnos").append(data.botones);
				$("#listadoAlumnos").show();
				$("#loadAlumnos").hide();
				$("#valorPaginaAF").val(pagina);
				console.log(pagina);
			 }else{
			 	Materialize.toast("No se encuentran registros",4000);
			 	muestraAlumnos();
			 }			 
			}
		});
	}
	var muestraRegAlumnos	=	function(){
		$('#opcVinculacion>div').hide();
		$("#tblcandidatos").html("");
		$("#ulpagregalm").html("");
		$("#registroAlumnos").show();
		$("#load").show("slow");
		var parametros ="opc=registroAlumnos";
			$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
			 if(data.respuesta==true){
			 	
				$("#tblcandidatos").append(data.tabla);
				$("#load").hide("slow");
				$("#registroAlumnos").show();
				$("#ulpagregalm").html("");
    		var npags=data.total/100;
				if(data.total%100!=0){
					npags=parseInt(npags)+1;
				}
				$("#paginastotal").val(npags);
				if(npags>1){
					$("#ulpagregalm").append('<li class="disabled" id="btnpagcandidatos"><a href="#!"><i class="material-icons">chevron_left</i></a></li>');
					$("#ulpagregalm").append('<li class="teal lighten-2 active" value=1 id="btnpagcandidatos"><a>1</a></li>');
					for (var i = 2; i <= npags; i++) {
						$("#ulpagregalm").append('<li class="waves-effect" value='+i+' id="btnpagcandidatos"><a>'+i+'</a></li>');
					}
						$("#ulpagregalm").append('<li class="" id="btnpagcandidatos" value=2><a href="#!"><i class="material-icons">chevron_right</i></a></li>');
				}
				var tabla="<tr><th>No. Control</th><th>PORCENTAJE AVANCE</th><th>Asignación</th></tr>";

				$.each(data.tablaArray, function( i, opc ) {
					tabla+="<tr><td>"+opc[0]+"</td>"+
							"<td id='"+opc[0]+"''>"+opc[1]+"</td>"+
							"<td><button class='btn-floating waves-effect waves-light blue' id='btnasignaprog' value='"+opc[0]+"'><i class='material-icons'>library_add</i></button></td></tr>"; 	
			 	});
				$("#tblcandidatos").html("");
				$("#tblcandidatos").append(tabla);$("#load").hide("slow");
				$("#registroAlumnos").show();
			 }			 
			}
		});
	}
	
	var pagAlmReg=function(){
		//devuelve contenido para una sola pagina, limite 100 (controlado en php) totRegistroAlumnos
		var pagstotal=$("#paginastotal").val();
		var pagina 	=	$(this).val();
		$("#paginaactual").val(pagina);
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: "opc=totRegistroAlumnos&pagina="+pagina,
			success: function(data){
			 if(data.respuesta==true){
			 	$(this).addClass('active');
			 	$("#tblcandidatos").html("");
				$("#tblcandidatos").append(data.candidatos);
				
				$("#registroAlumnos").show();
				$("#ulpagregalm").html("");
				if(pagina==1){
					$("#ulpagregalm").append('<li class="disabled" id="btnpagcandidatos"><a href="#!"><i class="material-icons">chevron_left</i></a></li>');
				}else{
						$("#ulpagregalm").append('<li class="" id="btnpagcandidatos" value='+(pagina-1)+'><a href="#!"><i class="material-icons">chevron_left</i></a></li>');	
				}

				for (var i = 1; i <= pagstotal; i++) {
					if(i==pagina){
						$("#ulpagregalm").append('<li class="teal lighten-2 active" value='+i+' id="btnpagcandidatos"><a>'+i+'</a></li>');
						continue;
					}
					$("#ulpagregalm").append('<li class="waves-effect" value='+i+' id="btnpagcandidatos"><a>'+i+'</a></li>');
				}

				if(pagina>=pagstotal){
					$("#ulpagregalm").append('<li class="disabled" id="btnpagcandidatos"><a href="#!"><i class="material-icons">chevron_right</i></a></li>');
				}else{
					$("#ulpagregalm").append('<li class="" id="btnpagcandidatos" value='+(pagina+1)+'><a href="#!"><i class="material-icons">chevron_right</i></a></li>');	
				}
				$("#load").hide("slow");
			 }			 
			}
		});
	}
	
	var btnprogramasAsignacion =function(){
		var ncontrol= $(this).val();
		programasAsignacion(ncontrol);
	}
	var programasAsignacion	=	function(ncontrol){
		var parametros ="opc=programasAsignacion&ncontrol="+ncontrol;
			$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
			 if(data.respuesta==true){
			 	var opciones="";
			 	$.each(data.opciones, function( i, opc ) {
					opciones+="<option value='"+opc.cveprograma+"'>"+opc.nombre+"</option>";
			 	});
			 	$("#pdisponibles").html("").append(opciones);
			 	$("#pdisponibles").material_select();
			 	$("#carrera").val(data.carrera);
			 	$("#nombre").val(data.nombrealm);
			 	$("label").addClass('active');
			 	$("#pcreditos").val($("#"+ncontrol).html());
			 	$("#ncontrol").val(ncontrol);
			 	$("#observaciones").val("");
			 	$('#asignarprograma').openModal();
			 }			 
			}
		});
	}
	var asignarprogramaAl	= function(){
		var programaSel	= $("#pdisponibles").val();
		var alumno 		= $("#ncontrol").val();
		var observaciones=$("#observaciones").val();
		var parametros 	="opc=asignarprogramaAl&programa="+programaSel+"&alumno="+alumno+"&observaciones="+observaciones;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
			 if(data.respuesta==true){
			 	if(data.permisoAlumno==false){
			 		//El alumno no es usuario
			 		$.confirm({
					title: 'Faltan requisitos',
					content: "El alumno incumple al menos 1 requisito, ¿Desea habilitarlo como usuario?",
					buttons: {
						aceptar: {
							text: 'Habilitar como usuario',
							btnClass: 'waves-effect waves-light btn',
							keys: ['enter', 'shift'],
							action: function(){
								$.ajax({
									type: "POST",
									dataType: "json",
									url: "../datos/vinculacion.php",
									data: 'opc=altaAlumnoUsuario&alumno='+alumno,
									success: function(data){
										//$.alert(data.mensaje);
										if(data.respuesta==true){
											continuarAsignacion(alumno);					
										}
									}
								});
							}
						},
						cancel: function () {
							$.alert("No se ha asignado un programa al alumno");
						}
					}
				});	

			 	}
			 	//el alumno si es usuario
			 	if(data.mensaje){
	  				$.alert(data.mensaje);
			 	}
			 	//eliminar de la lista de candidatos
			 	muestraRegAlumnos();

			 }			 
			}
		});
	} 
	var continuarAsignacion = function(alumno){
		$.confirm({
		    title: 'Continuar asignación de programa',
		    content: 'El alumno ya puede ingresar al sistema.. ¿Desea continuar con la asignación?',
		    buttons: {
		        continuar: {
		            text: 'Continuar',
					btnClass: 'waves-effect waves-light btn',
					keys: ['enter', 'shift'],
		            action: function(){
		                programasAsignacion(alumno);
		            }
		        },
		        cancel: function () {
		            $.alert('No se ha asignó programa al alumno');
		        }
		    }
		});
	}

	var filtrarSolicitudes = function(){
		var pagina 	= $(this).val();
		if(pagina == ""){
			pagina = 1;
		}
		funcionFiltrarSolicitudes(pagina);
	}
	var filtrarProgramas = function(){
		var pagina 	= $(this).val();
		if(pagina == ""){
			pagina = 1;
		}
		var filtro 	= $("#filtroProgramas").val();
		var opcion 	= $("#opcionProgramas").val();
		var parametros = "opc=filtrarProgramas"+"&filtro="+filtro+"&opcion="+opcion+"&pagina="+pagina;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function (data){
				if(data.respuesta== true){
					$("#opcionActual").val(2);
					$('#opcVinculacion>div').hide();
					$("#btnFiltroProgramas").attr('disabled','disabled');
					$("#btnClearFiltroPro").attr('disabled',false);
					$("#filtroProgramas").attr('disabled','disabled');
					$("#opcionProgramas").attr('disabled','disabled');
					$("#filtroProgramas").material_select();
					$("#opcionProgramas").material_select();
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.tabla);
					$("#botonesProgramas").html("");
					$("#botonesProgramas").append(data.botones);
					$("#listadoProgramas").show();
					$("#paginaActualG").val(pagina);
/*
					$("#opcionActual").val(1);
					$('#opcVinculacion>div').hide();

*/
				}else{
					Materialize.toast("No hay programas que coincidan",3000);
				}
			}

		});
	}
	var muestraResultados = function(){
		$('#loadResultados').show();
		$('#ulResultados').html("");
		$('#opcVinculacion>div').hide();
		$('#listadoResultados').show("slow");
		var parametros ="opc=mostrarResultados";
		event.preventDefault();
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta==true){
					$('#loadResultados').hide();
					$('#ulResultados').html(data.ul);
					$("#opcionResultados").material_select();
					$("#filtroResultados").material_select();
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
	var mostrarProgramas = function (pagina){
		var parametros="opc=tablaprogramas"+"&pagina="+pagina;
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data:parametros,
			success: function(data){
				if(data.respuesta==true){
					$("#opcionActual").val(1);
					$('#opcVinculacion>div').hide();
					$('#opcVinculacion>div').hide();
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.renglones);
					$("#botonesProgramas").html("");
					$("#botonesProgramas").append(data.botones);
					$("#listadoProgramas").show();
					$("#paginaActualG").val(pagina);
				}
			}
		});
	}
	var nextProgramasN =function(){
		var paginaActual = $("#valorPaginaN").val();
		var pagina = parseInt(paginaActual)+1;
		if(pagina== ""){
			pagina =1;
		}
		mostrarProgramas(pagina);
	}
	var previousProgramasN = function(){
		var paginaActual = $("#valorPaginaN").val();
		var pagina = parseInt(paginaActual)-1;
		if(pagina== ""){
			pagina =1;
		}
		mostrarProgramas(pagina);

	}
	var mostrarProgramasFiltro = function(pagina){
		var filtro 	= $("#filtroProgramas").val();
		var opcion 	= $("#opcionProgramas").val();
		var parametros = "opc=filtrarProgramas"+"&filtro="+filtro+"&opcion="+opcion+"&pagina="+pagina;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function (data){
				if(data.respuesta== true){
					$("#opcionActual").val(2);
					$('#opcVinculacion>div').hide();
					$("#tblprogramas").html("");
					$("#tblprogramas").append(data.tabla);
					$("#botonesProgramas").html("");
					$("#botonesProgramas").append(data.botones);
					$("#listadoProgramas").show();
					$("#paginaActualG").val(pagina);
				}else{
					funMuestraListaProgramas(1);
				}
			}

		});
	}
	var nextProgramas = function(){
		var paginaActual = $("#valorPagina").val();
		var pagina = parseInt(paginaActual)+1;
		if(pagina== ""){
			pagina =1;
		}
		mostrarProgramasFiltro(pagina);
	}
	var previousProgramas = function(){
		var paginaActual = $("#valorPagina").val();
		var pagina = parseInt(paginaActual)-1;
		if(pagina== ""){
			pagina =1;
		}
		mostrarProgramasFiltro(pagina);
	}
	var funcionAlumnosSol = function(pagina){
		var parametros 	= "opc=muestraSolicitudes"+"&pagina="+pagina;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$('#btnClearFiltroSol').attr('disabled','disabled');
					$('#opcVinculacion>div').hide();
					$("#tablaSolicitudes").html("");
					$("#tablaSolicitudes").append(data.tabla);
					$("#paginacionSolicitudes").html("");
					$("#paginacionSolicitudes").append(data.botones);
					$("#listadoSolicitudes").show();
					$("#paginaActualSol").val(pagina);
					$("#opcionActualSol").val(2);
				}else{
					funcionAlumnosSolicitudes(1);
				}
				
			}
		});

	}
	var previousSolicitudes = function(){
		var paginaActual = $("#valorPagSol").val();
		var pagina = parseInt(paginaActual)-1;
		if(pagina== ""){
				pagina =1;
		}
		funcionAlumnosSol(pagina);
	}
	var nextSolicitudes = function(){
		var paginaActual = $("#valorPagSol").val();
		var pagina = parseInt(paginaActual)+1;
		if(pagina== ""){
				pagina =1;
		}
		funcionAlumnosSol(pagina);

	}
	var previousSolicitudesFiltro = function(){
		var paginaActual = $("#valorPaginaSF").val();
		var pagina = parseInt(paginaActual)-1;
		if(pagina== ""){
			pagina =1;
		}
		funcionFiltrarSolicitudes(pagina);
	}
	var nextSolicitudesFiltro = function(){
		var paginaActual = $("#valorPaginaSF").val();
		var pagina = parseInt(paginaActual)+1;
		if(pagina== ""){
			pagina =1;
		}
		funcionFiltrarSolicitudes(pagina);

	}
	var funcionFiltrarSolicitudes = function(pagina){
		var filtro 	= $("#filtroSolicitudes").val();
		var opcion 	= $("#opcionSolicitudes").val();
		var periodo 	= $("#filtroPeriodo").val();
		var nocontrol 	= $("#filtroNoControlSolicitudes").val();
		var parametros = "opc=filtrarSolicitudes"+"&filtro="+filtro+"&opcion="+opcion+"&periodo="+periodo+"&nocontrol="+nocontrol+"&pagina="+pagina;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function (data){
				if(data.respuesta== true){
					$('#opcVinculacion>div').hide();
					$("#filtroSolicitudes").attr('disabled','disabled');
					$("#opcionSolicitudes").attr('disabled','disabled');
					$("#filtroPeriodo").attr('disabled','disabled');
					$("#filtroSolicitudes").material_select();
					$("#opcionSolicitudes").material_select();
					$("#filtroPeriodo").material_select();
					$("#tablaSolicitudes").html("");
					$("#tablaSolicitudes").append(data.tabla);
					$("#paginacionSolicitudes").html("");
					$("#btnFiltroSolicitudes").attr('disabled','disabled');
					$("#btnClearFiltroSol").attr('disabled',false);
					$("#paginacionSolicitudes").append(data.botones);
					$("#listadoSolicitudes").show();
					$("#paginaActualSol").val(pagina);
					$("#opcionActualSol").val(1);
				}else{
					funcionAlumnosSolicitudes(1);
					Materialize.toast("No se encuentran solicitudes que coincidan",5000);
				}
			}

		});
	}

	var infoarchivo =function(){
		if($("#txtcargacsv").val()==""){
			$.alert({type: 'red', title: 'No se ha seleccionado un archivo', content: 'Seleccione un archivo CSV.',});
			return;
		}
		$.confirm({
			icon: 'fa fa-warning',
		    title: 'Aviso',
		    content: 'Recuerde que solo se registrarán alumnos con Total del curso (Real) 100.',
		    type: 'blue',
		    typeAnimated: true,
		    buttons: {
		        tryAgain: {
		            text: 'Continuar',
		            btnClass: 'btn-blue',
		            action: function (){
		            	subirarchivo();
		            }
		        },
		        close: {
		        	text: 'Cancelar',
		        	action: function () {
		        	}
		        }
		        
		    }
		});
	}
	var subirarchivo =function(){
		var ruta=$("#txtcargacsv").val();
		$("#tblalmNOencontrados").html("");
		$("#tblalmencontrados").html("");
		var tablaencontrados="";
		var tablaNOencontrados="";
		var cuerpoCorreo='Pasa a la oficina de servicio social a actualizar tu informacion';
		if(ruta==""){
			$.alert({type: 'red', title: 'No se ha seleccionado un archivo', content: 'Seleccione un archivo CSV.',});
			return;
		}
		
		var formData = new FormData();
		formData.append('file', $('#fileToUpload')[0].files[0]);

		$.ajax({
		   url : '../datos/cargarcursomoodle.php',
		   type : 'POST',
		   dataType: 'json',
		   data : formData,
		   processData: false,  // tell jQuery not to process the data
		   contentType: false,  // tell jQuery not to set contentType
		   success : function(data) {
		       if(data.respuesta== true){
					$("#correosEn").val(data.alumnos);
					
					if(data.alumnos.length>0){
						tablaencontrados+="<tr><th>No. Control</th><th>Nombre</th><th>Correo</th></tr>";
						$.each(data.alumnos, function( i, value ) {
							tablaencontrados+="<tr><td>"+value['ncontrol']+"</td><td>"+value['nombre']+"</td><td>"+value['correo']+"</td></tr>";
						});
						$("#tblalmencontrados").append(tablaencontrados);
						$("#tabEncontrados").addClass("active");
					}
					if(data.noencontrados.length>0){
						tablaNOencontrados+="<thead><tr><th>Correos</th></tr></thead>";
						$.each(data.noencontrados, function( i, almcorreo ) {
							tablaNOencontrados+="<tr><td><a href='mailto:"+almcorreo+"?Subject=Actualiza tus datos&Body="+cuerpoCorreo+"'>"+almcorreo+"</a></td></tr>";
						});
						$("#tblalmNOencontrados").append(tablaNOencontrados);
						$("#tabNOencontrados").addClass("active");
					}
					
					//$("#almnoencontrados").addClass("active");
					//$("#tblalmencontrados").append(tablaencontrados);
  					$(".collapsible").collapsible({accordion: false});
  					if(tablaencontrados!=""){
  						//$("#btnRegAlm").show();
  					}
				}else{
					$.alert({type: 'orange', title: 'Aviso', content: data.mensaje,});
				}
				$('#frmcurso').trigger("reset");
		   }
		});
	}

	var clearFiltroAlu = function(){
		$("#filtroAlumnos").attr('disabled',false);		
		$("#opcionAlumnos").attr('disabled',false);
		$("#filtroPeriodoAlumnos").attr('disabled',false);
		$("#btnFiltroAlumnos").attr('disabled',false);
		$("#btnClearFiltroAlu").attr('disabled','disabled');
		$("#filtroAlumnos").material_select();		
		$("#opcionAlumnos").material_select();
		$("#filtroPeriodoAlumnos").material_select();
		muestraAlumnos();
	}
	var filtroResultadosSem = function(){
		$('#loadResultados').show();
		$('#ulResultados').html("");
		$('#opcVinculacion>div').hide();
		$('#listadoResultados').show("slow");
		var filtro = $("#filtroResultados").val();
		var opcion = $("#opcionResultados").val();
		var parametros ="opc=mostrarResultadosFiltro"+"&filtro="+filtro+"&opcion="+opcion;
		event.preventDefault();
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta==true){
					$('#loadResultados').hide();
					$('#ulResultados').html(data.ul);
					$("#opcionResultados").material_select();
					$("#filtroResultados").material_select();
				}
			}

		});

	}

	var mostrarcargacsv =function(){
		$('#opcVinculacion>div').hide();
		$("#registroAlumnosSubirCurso").show("slow");
	}

	var calificarreporte=function(cvereporte, calificacion){
		$("#cvereporte").val(cvereporte);
		$("#txtcalempresa").val(calificacion);
		$("#txtcalififinal").html(calificacion);
		$(".cals").not("#observacionesreportes").val("0");
		$("#selniveldes,#selestadorep").prop('selectedIndex',0);
		$("#selniveldes,#selestadorep").material_select();
		$("#modalcalificarreporte").openModal();
	}
	var btncalificarreporte=function(){
		var btnid=$(this).val();
		$("#numreporte").val(btnid);
		var cvereporte=$("#btnmc"+btnid+"").val();
		var califEmmpresa=$("#calEmpR"+btnid+"").val();
		var claveexpediente= $("#cveexpediente").val();
		calificarreporte(cvereporte, califEmmpresa);
	}
	var cambiaCalifFinal=function(){
		if(parseInt($("#txttiempoforma").val())>25) $("#txttiempoforma").val("25");
		if(parseInt($("#txtresponsabilidad").val())>10) $("#txtresponsabilidad").val("10");
		var sumaV=parseInt($("#txttiempoforma").val())+parseInt($("#txtresponsabilidad").val());
		var sumaT=sumaV+parseInt($("#txtcalempresa").val());
		$("#txtcalVinc").val(sumaV);
		$("#txtcalififinal").html(sumaT);
		var index=0;		
			if(sumaT > 94){
				index=1;
			}else if(sumaT > 84 && sumaT < 95) {
				index=2;
			}else if(sumaT > 74 && sumaT < 85){
				index=3;
			}else if(sumaT > 69 && sumaT < 75){
				index=4;
			}else if(sumaT <70){
				index=5;
			}

		$("#selniveldes").prop('selectedIndex',index);;
		$("#selniveldes").material_select();
	}
	var actualizarCalifReporte=function(){
		var cvereporte		=$("#cvereporte").val();
		var califVincRep	=$("#txtcalVinc").val();
		var estadorep 		=$("#selestadorep").val();
		var observaciones 	=$("#observacionesreportes").val();
		var parametros ="opc=calificarReporte"+"&cvereporte="+cvereporte+"&calificacion="+califVincRep+"&observaciones="+observaciones+"&estado="+estadorep;
		$.ajax({
			type:"POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta==true){
					var nrep=$("#numreporte").val();
					console.log(nrep);
					$("#calTotal"+nrep+"").html($("#txtcalififinal").html());
					$("#btnmodalcalificar[value='"+nrep+"']").attr("disabled",true).hide();
				}
			},
			complete: function(){
				$("#observacionesreportes").val("");
				llenarTarjeta();
				//limpiar inputs
			}

		});
}
	var aceptarDocumentos = function(){
		var doc = $(this).val();
		var parametros = "opc=aceptarDocumentos"+"&doc="+doc;
		$.confirm({
			title: 'Confirmación',
			content: "¿Esta seguro que desea aceptar el documento ?",
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
								if(data.respuesta== true){
									$.alert("El documento ha sido aceptado");
									llenarTarjeta();									
								}else{
									$.alert("El documento no ha podido ser aceptada");
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

	var cambiaestadoreporte=function(){
		index=$(this).val();
		switch(index){
			case '0':
			$(".cals").attr("disabled",true);
			break;
			case '1':
			$(".cals").removeAttr("disabled");
			break;
			case '2':
			$(".cals").removeAttr("disabled");
			break;
		}
			
			$("select").material_select();
	}

	var rechazarDocumentos = function(){
		var cvedoc = $(this).val();
		$("#btnEnviaObs").val(cvedoc);
		$("#observacionesDoc").val('');
		$("#modalrechazardocumento").openModal();

	}
	var guardarObservaciones = function(){
		var obs = $("#observacionesDoc").val();
		var doc = $("#btnEnviaObs").val();
		var parametros="opc=guardarObservaciones"+"&doc="+doc+"&obs="+obs;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/vinculacion.php",
			data: parametros,
			success: function(data){
				if(data.respuesta== true){
					$.alert("Se han enviado las observaciones");
				}else{
					$.alert("ERROR");
				}
			}

		});
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
	$("#menuregistroAlumnos").on("click",muestraRegAlumnos);
	//$("").on("click",registrarAlumno);
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
	$("#tblcandidatos").on("click","#btnasignaprog",btnprogramasAsignacion);
	$("#btnasignarmodal").on("click",asignarprogramaAl);

	$("#muestraResultados").on("click",muestraResultados);
	$("#btnCambioClave").on("click",cambioClave);
	$("#btnGuardarNuevaClave").on("click",guardarNuevaClave);
	$("#botonesProgramas").on("click","#btnPag",muestralistaprogramas);
	$("#botonesProgramas").on("click","#btnPagF",filtrarProgramas);
	$("#botonesProgramas").on("click","#btnNext",nextProgramas);
	$("#botonesProgramas").on("click","#btnPrevious",previousProgramas);
	$("#botonesProgramas").on("click","#btnNextN",nextProgramasN);
	$("#botonesProgramas").on("click","#btnPreviousN",previousProgramasN);
	$("#btnClearFiltroPro").on("click",muestralistaprogramas);
	$("#paginacionSolicitudes").on("click","#btnPagSol",alumnosSolicitudes);
	$("#paginacionSolicitudes").on("click","#btnNextSol",nextSolicitudes);
	$("#paginacionSolicitudes").on("click","#btnPreviousSol",previousSolicitudes);
	$("#btnClearFiltroSol").on("click",alumnosSolicitudes);
	$("#paginacionSolicitudes").on("click","#btnPagFS",filtrarSolicitudes);
	$("#paginacionSolicitudes").on("click","#btnNextFS",nextSolicitudesFiltro);
	$("#paginacionSolicitudes").on("click","#btnPreviousFS",previousSolicitudesFiltro);
	$("#paginacionAlumnos").on("click","#btnPag",btnMuestraAlumnos);
	$("#paginacionAlumnos").on("click","#btnPagF",btnFiltrarAlumnos);
	$("#paginacionAlumnos").on("click","#btnNextN",nextMuestraAlumnos);
	$("#paginacionAlumnos").on("click","#btnPreviousN",previousMuestraAlumnos);
	$("#paginacionAlumnos").on("click", "#btnPreviousFA",previousMuestraAlumnosF);
	$("#paginacionAlumnos").on("click", "#btnNextFA",nextMuestraAlumnosF);
	$("#btnClearFiltroAlu").on("click",clearFiltroAlu);
	$("#frmRegistroAlumnos").on("click","#btnpagcandidatos",pagAlmReg);
	$("#menusubirCSV").on("click",mostrarcargacsv)
	$("#listadoResultadosC").on("click","#btnFiltroResultados",filtroResultadosSem);
	$("#btnsubmitcurso").on("click",infoarchivo);
	
	$("#tblreportes").on("click","#btnmodalcalificar",btncalificarreporte);
	$("#txttiempoforma").on("change",cambiaCalifFinal);
	$("#txtresponsabilidad").on("change",cambiaCalifFinal);
	$("#btncalificarmodal").on("click",actualizarCalifReporte);
	$("#selestadorep").on("change",cambiaestadoreporte);
	$("#aceptarCartaApr").on("click",aceptarDocumentos);
	$("#rechazarCartaApr").on("click",rechazarDocumentos);
	$("#aceptarPlanTra").on("click",aceptarDocumentos);
	$("#rechazarPlanTra").on("click",rechazarDocumentos);
	$("#btnEnviaObs").on("click",guardarObservaciones);

}
$(document).on("ready",admin);