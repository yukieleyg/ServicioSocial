var dependencia = function (){
	var parametros="";
	const TECLA_ENTER = 13;
	var cambioClave = function(){
		$('#opcDependencia>div').hide();
		$('#cambioClaveDep').show("slow");
	}
	var mostrarMisDatos = function(){
		var usuario = $('#txtUsuario').val();
		var parametros = "opc="+"mostrarMisDatos"+"&usuario="+usuario;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/dependencia.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					$('#opcDependencia>div').hide();
					$('#nomDep').val(data.nombre);
					$('#dirDep').val(data.direccion);
					$('#telDep').val(data.telefono);
					$('#titDep').val(data.titular);
					$('#pueDep').val(data.puesto);
					$('#nomDep').attr('disabled', "disabled"); 
					$('#dirDep').attr('disabled', "disabled");
					$('#telDep').attr('disabled', "disabled"); 
					$('#titDep').attr('disabled', "disabled"); 
					$('#pueDep').attr('disabled', "disabled"); 
					$("#btnModificarDatos").attr("disabled",false);
					$("#btnGuardarDatos").attr("disabled",true);
					$("#btnCancelarDatos").attr("disabled",true);
					$('#misDatos').show("slow");

				}
			}
		});
	}
	var modificarDatos = function(){
		$("#btnModificarDatos").attr("disabled",true);
		$("#btnGuardarDatos").attr("disabled",false);
		$("#btnCancelarDatos").attr("disabled",false);
		$('#nomDep').attr('disabled', false);
		$('#dirDep').attr('disabled', false);
		$('#telDep').attr('disabled', false);
		$('#titDep').attr('disabled', false);
		$('#pueDep').attr('disabled', false);
	}
	var guardarDatos = function(){
		var usuario 	= $('#txtUsuario').val();
		var nombreDep 	= $('#nomDep').val();
		var dirDep 		= $('#dirDep').val();
		var telDep 		= $('#telDep').val();
		var titDep 		= $('#titDep').val();
		var pueDep 		= $('#pueDep').val();
		var parametros 	= "opc="+"guardarDatos"+"&usuario="+usuario+"&nombreDep="+nombreDep+
		"&dirDep="+dirDep+"&telDep="+telDep+"&titDep="+titDep+"&pueDep="+pueDep;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/dependencia.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					var parametros 	= "opc="+"guardarDatosModif"+"&usuario="+usuario+"&nombreDep="+nombreDep+
						"&dirDep="+dirDep+"&telDep="+telDep+"&titDep="+titDep+"&pueDep="+pueDep;
					$.confirm({
						title: 'Confirmación',
						content: "¿Esta seguro que desea modificar los datos?",
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
												Materialize.toast("Datos modificados",4000);
												mostrarMisDatos();
											}else{
												$alert("Los datos no han podido ser modificados");
											}
										}
									});
								}
							},
							cancel: function () {
								$.alert("Los datos no han sido modificados");
								mostrarMisDatos();
							}
						}
					});
				}else{
						$.alert("No has modifcados los datos");
				}
			}
		});
	}
	var funMostrarProgramasVacantes=function(){
		var usuario 	= $('#txtUsuario').val();//from login
		var parametros = "opc="+"mostrarProgramasVac"+"&usuario="+usuario;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:"../datos/dependencia.php",
			data: parametros,
			success: function(data){
				if(data.respuesta){
					var tablaProgV="<tr><th>PROGRAMA</th><th>VACANTES</th></tr>";

				$.each(data.tablaProgramas, function( i, opc ) {
					if(opc[1]==0){
						tablaProgV+="<tr><td>"+opc[0]+"</td>"+
									"<td class='center red lighten-1'><b>"+opc[1]+"</b></td>";	
					}else{
						tablaProgV+="<tr><td>"+opc[0]+"</td>"+
									"<td class='center'>"+opc[1]+"</td>";	
					}
					
			 	});
				$("#tblProgramasVac").html("");
				$("#tblProgramasVac").append(tablaProgV);
				}
			}
		});
	}
	var llenarSelectProgVac=function(){
		var usuario 	= $('#txtUsuario').val();//from login
		var parametros = "&opc=llenaProgramasVac"+"&usuario="+usuario;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	$("#selProgramaV").find('option').remove();
				 	$("#selProgramaV").append('<option value="" disabled selected>Seleccione programa..</option>');
				 	var opcs="";
				 	$.each(data.opciones, function(i,opc){
				 		opcs+='<option value="'+opc[0]+'">'+opc[1]+'</option>';
				 	});
				 	$("#selProgramaV").append(opcs).html();
				 	$('select').material_select();
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
	var mostrarabrirVacantes=function(){
		$('#opcDependencia>div').hide();
		funMostrarProgramasVacantes();
		llenarSelectProgVac();
		$("#solicitarSSVacantes").show("slow");
	}
	var mostrarSolicitudesSeg = function(){
		var usuario 	= $('#txtUsuario').val();//from login
		var parametros  = "opc="+"mostrarSolicitudesSeg"+"&usuario="+usuario;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/dependencia.php",
			data: parametros,
			success: function(data){
				$('#tblAlumnos').html("");
				$('#tblAlumnos').append(data.tabla);
				$("#divTablaAlumnos").show("slow");
				$('#opcDependencia>div').hide();
				$("#seguimientoSolicitudes").show("slow");

			}
		});
	}
	var filtroSolicitudes = function(){
		var usuario 	= $('#txtUsuario').val();//from login
		var value 		= $("#filtroSolicitudesDependencia").val();
		switch(value){
			case '0':  
					opcs="<option value='0'>Pendiente</option><option value='1'>Aceptado</option><option value='2'>Rechazado</option>"
					$("#opcionSolicitudesDP").find('option').remove();
					$("#opcionSolicitudesDP").append(opcs).html();
					$("#opcionSolicitudesDP").material_select();
					$("#opcionSolicitudesDivDP").show();
			break;
			case '1': 
				var parametros = "opc=consultaFiltroSolicitudesDP"+"&usuario="+usuario;
				var opcs= "";
				$.ajax({
					type: "POST",
					dataType: "json",
					url:"../datos/dependencia.php",
					data: parametros,
					success: function(data){
					 if(data.respuesta==true){
					  	opcs=data.opciones;
					 	$("#opcionSolicitudesDP").find('option').remove();
					 	$("#opcionSolicitudesDP").append(opcs).html();
					 	$("#opcionSolicitudesDP").material_select();
						$("#opcionSolicitudesDivDP").show();
					 }			 
					}
				});
			break;
		}
	}
$("#btnCambioClaveDep").on("click",cambioClave);
$("#btnMisDatosDep").on("click",mostrarMisDatos);
$("#btnModificarDatos").on("click", modificarDatos);
$("#btnGuardarDatos").on("click",guardarDatos);
$("#btnCancelarDatos").on("click",mostrarMisDatos);
$("#menuabrirVacantes").on("click",mostrarabrirVacantes);
$("#menuSolicitudesSeg").on("click",mostrarSolicitudesSeg);
$("#tblAlumnos").on("click","#aceptar",aceptarSolicitudes);
$("#tblAlumnos").on("click","#rechazar",rechazarSolicitudes);
$("#filtroSolicitudesDependencia").on("change",filtroSolicitudes);

//$("#menuProgramasSeg").on("click",mostrarProgramasSeg);
}
$(document).on("ready",dependencia);