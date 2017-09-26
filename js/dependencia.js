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
		obtenerDptosDep();
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
					$("#txtdptosDep").removeClass('fake-enabled');
					$("#btnagregardptoDep").attr('disabled', true);
					$("#txtdptomodif").val(0);
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
		$("#txtdptosDep").addClass('fake-enabled');
        $("#btnagregardptoDep").attr('disabled', false);
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
										url: "../datos/dependencia.php",
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
					if($("#txtdptomodif").val()>0){
						$.alert("Se han agregado "+$("#txtdptomodif").val()+ "departamentos");
						mostrarMisDatos();
					}else{
							$.alert("No has modifcados los datos");
						}

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
		var parametros = "opc=llenaProgramasVac"+"&usuario="+usuario;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	$("#selProgramasV").find('option').remove();
				 	$("#selProgramasV").append('<option value="" disabled selected>Seleccione programa..</option>');
				 	var opcs="";
				 	$.each(data.opciones, function(i,opc){
				 		opcs+='<option value="'+opc[0]+'">'+opc[1]+'</option>';
				 	});
				 	$("#selProgramasV").append(opcs).html();
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
										var opcion = 	$("#opcionEstadoSol").val();
										if(opcion == 1){
												Materialize.toast("Solicitud Aceptada, recuerde entregarle la carta de aceptación al alumno.",4500);
												mostrarSolicitudesSeg();
												
										}else{
												Materialize.toast("Solicitud Aceptada, recuerde entregarle la carta de aceptación al alumno.",4500);
												filtrarSolicitudesSeg();
										
										}
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
										var opcion = 	$("#opcionEstadoSol").val();
										if(opcion == 1){
												Materialize.toast("Solicitud Rechazada",4500);
												filtrarSolicitudes();
										}else{
												Materialize.toast("Solicitud Rechazada",4500);
												mostrarSolicitudesSeg();

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
		$("#txtProgVacantes").val("");
		$("#solicitarSSVacantes").show("slow");
	}
	var mostrarSolicitudesSeg = function(){
		try{
			var pagina = $(this).val();
			$("#valorPagina").val(pagina);
		}catch(error){
			var pagina = $("#valorPagina").val();
		}
		if(pagina == ""){
			pagina 		= 1;
		}
		var usuario 	= $('#txtUsuario').val();//from login
		var parametros  = "opc="+"mostrarSolicitudesSeg"+"&usuario="+usuario+"&pagina="+pagina;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../datos/dependencia.php",
			data: parametros,
			success: function(data){
				$("#paginacionSolicitudesDP").html("");
				$("#paginacionSolicitudesDP").append(data.botones);
				$("#filtroSolicitudesDependencia").attr('disabled',false);
				$("#opcionSolicitudesDP").attr('disabled',false);
				$("#btnClearFiltroSolDP").attr('disabled',true);
				$("#btnFiltroSolicitudesDP").attr('disabled',false);
				$("#opcionSolicitudesDP").material_select();
				$("#filtroSolicitudesDependencia").material_select();
				$('#tblAlumnos').html("");
				$('#tblAlumnos').append(data.tabla);
				$("#divTablaAlumnos").show("slow");
				$('#opcDependencia>div').hide();
				$("#btnClearFiltroSolDP").attr('disabled',true);
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
	var filtrarSolicitudes = function(){
		try{
			var pagina = $(this).val();
			$("#valorPaginaFiltro").val(pagina);
		}catch(error){
			var pagina = $("#valorPaginaFiltro").val();
		}
		var usuario 	= $('#txtUsuario').val();//from login
		var value 		= $("#filtroSolicitudesDependencia").val();
		var opc 		= $("#opcionSolicitudesDP").val();
		//var pagina 		= pagina;
		switch(value){
			case '0':
				var parametros	= "opc="+"filtrarSolicitudesEstado"+"&estado="+opc+"&usuario="+usuario+"&pagina="+pagina; 
				$.ajax({					
					type: "POST",
					dataType: "json",
					url:"../datos/dependencia.php",
					data: parametros,
					success: function(data){
						$("#filtroSolicitudesDependencia").attr('disabled',true);
						$("#opcionSolicitudesDP").attr('disabled',true);
						$("#btnClearFiltroSolDP").attr('disabled',false);
						$("#opcionSolicitudesDP").material_select();
						$("#filtroSolicitudesDependencia").material_select();
						$("#btnFiltroSolicitudesDP").attr('disabled',true);
						$("#paginacionSolicitudesDP").html("");
						$("#paginacionSolicitudesDP").append(data.botones);
						$('#tblAlumnos').html("");
						$('#tblAlumnos').append(data.tabla);
						$("#divTablaAlumnos").show("slow");
						$('#opcDependencia>div').hide();
						$("#seguimientoSolicitudes").show("slow");

					}	
				});
				break;
			case '1': 
				var parametros = "opc="+"filtrarSolicitudesProgramas"+"&programa="+opc+"&usuario="+usuario+"&pagina="+pagina;
				$.ajax({
					type: "POST",
					dataType: "json",
					url:"../datos/dependencia.php",
					data: parametros,
					success: function(data){
						$("#filtroSolicitudesDependencia").attr('disabled',true);
						$("#opcionSolicitudesDP").attr('disabled',true);
						$("#btnClearFiltroSolDP").attr('disabled',false);
						$("#opcionSolicitudesDP").material_select();
						$("#filtroSolicitudesDependencia").material_select();
						$("#btnFiltroSolicitudesDP").attr('disabled',true);
						$("#paginacionSolicitudesDP").html("");
						$("#paginacionSolicitudesDP").append(data.botones);
						$('#tblAlumnos').html("");
						$('#tblAlumnos').append(data.tabla);
						$("#divTablaAlumnos").show("slow");
						$('#opcDependencia>div').hide();
						$("#seguimientoSolicitudes").show("slow");
					}	
				});
				break;
		}
	}
var vacanteenPrograma	=	function(){
		$("#txtProgVacantes").val("");
		console.log($("#selProgramasV").val());
		var cveprograma	=	$(this).val();
		var parametros	= "opc=vacanteenPrograma"+"&cveprograma="+cveprograma;
		$.ajax({
			type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				    $("#txtProgVacantes").val(data.numvacantes);
				 }			 
				}
		});
	}

	var modificarVacantes 	= function(){
		console.log($("#selProgramasV").val());
		if($("#selProgramasV").val()==null){
			$.alert('Seleccione un programa para modificar');
		}else{
			$("#btnModificarVacantes").addClass("disabled");
			$("#btnGuardarVac").removeClass("disabled");
			$("#btnCancelarVac").removeClass("disabled");
			$('#txtProgVacantes').removeAttr('readonly').focus();
		}
		
	}

	var guardarVacantes	=function(){
		var programa = $("#selProgramasV").val();
		var vacantes = $("#txtProgVacantes").val();
		var parametros	= "opc=guardarPrograma"+"&cveprograma="+programa+"&vacantes="+vacantes;
		
		$.confirm({
			title: 'Confirmación',
			content: "¿Está seguro que desea modificar las vacantes?",
			buttons: {
				aceptar: {
					text: 'Aceptar',
					btnClass: 'waves-effect waves-light btn',
					keys: ['enter', 'shift'],
					action: function(){
						$.ajax({
							type: "POST",
							dataType: "json",
							url:"../datos/dependencia.php",
							data: parametros,
							success: function(data){
							 if(data.respuesta==true){
							    mostrarabrirVacantes();
							 }			 
							}
						});
					}
				},
				cancel: function () {
					cancelarModifVac();		
				}
			}
		});
		$("#btnGuardarVac").addClass("disabled");
	    $("#btnCancelarVac").addClass("disabled");
	    $("#btnModificarVacantes").removeClass("disabled");
	    $('#txtProgVacantes').attr('readonly',true);

	}
	var cancelarModifVac =function(){
		$.alert("Los datos no han sido modificados");
		$("#btnGuardarVac").addClass("disabled");
	    $("#btnCancelarVac").addClass("disabled");
	    $("#btnModificarVacantes").removeClass("disabled");
	    llenarSelectProgVac();
	    $('#txtProgVacantes').val("").attr('readonly',true);
	}

	var mostrarAperturaProg	=function(){
		$('#opcDependencia>div').hide();
		$("#selprogdepSS").val($("#txtUsuario").val());
		var nomdep = $("#txtUsuario").val();
		var clave=$("#userid").val();
		$("#selprogdepSS").html("<option value='"+clave+"'>"+nomdep+"</option>").prop({'selectedIndex':1}).material_select();
		llenaDptosDep();
		llenaTipoProg();
		$("#solicitarSSProgramas").show("slow");
	}
	
	var llenaDptosDep = function(){
		var nomdep = $("#txtUsuario").val();		
		var parametros = "opc=llenaDptosDep"+"&nomdep="+nomdep;
		
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	$("#selprogdptoSS").find('option').remove();
				 	$("#selprogdptoSS").append('<option value="" disabled selected>Seleccione departamento..</option>');
				 	var opcs="";
				 	$.each(data.opciones, function(i,opc){
				 		opcs+='<option value="'+opc[0]+'">'+opc[1]+'</option>';
				 	});
				 	$("#selprogdptoSS").append(opcs).html();
				 	$('select').material_select();
				 }			 
				}
		});
	}
	var llenaTipoProg=	function(){
		var nomdep = $("#txtUsuario").val();
		var parametros = $("#selprogtipoSS").val()+"&opc=llenaTipoProg"+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta==true){
				 	var opcs=data.opciones;
				 	$("#selprogtipoSS").find('option').remove();
				 	$("#selprogtipoSS").append('<option value="" disabled selected>Seleccione un tipo de programa..</option>');
				 	var opcs="";
				 	$.each(data.opciones, function(i,opc){
				 		opcs+='<option value="'+opc[0]+'">'+opc[1]+'</option>';
				 	});
				 	$("#selprogtipoSS").append(opcs).html();
				 	$('#selprogtipoSS').material_select();
				 }			 
				}
		});
	}

	var solicitarApPrograma=function(){
		if(!$('#sstipoOtras').is(':checked')){
			$("#txttipoOtros").val("-");
		}
		if($("#txtprogvacSS").val()<1){
			$.alert("Cantidad de vacantes insuficiente");
			$("#txtprogvacSS").focus();
			return;
		}
		var parametros = $("#frmDepSSProgramas").serialize()+"&opc=solicitarApPrograma"+"&id="+Math.random();
		var anyInvalid=false;
		if($("#selprogdepSS").val()	=== '' ||
		$("#selprogdptoSS").val()	=== '' ||
		$("#selprogtipoSS").val()	=== '' ||
		$("#selprogestSS").val()	=== '' ||
		$("#selprogmodSS").val() === ''){
			anyInvalid=true;
		}
		if (anyInvalid) {
		    $.alert('Uno o más campos no tienen opcion seleccionada');
		    return false;
		}
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,

				success: function(data){
				 if(data.respuesta){		 
 					$('input:not([type=radio],[type=submit])').not("#txtUsuario").not("#userid").val("");
 					$('textarea').val("");
 					$('input[type="radio"]').prop('checked', false);
 					$("#btnagregardpto").attr('disabled','disabled');
 					$('select').prop('selectedIndex',0);
 					$('select').material_select();
				    
				 }
				 $.alert(data.mensaje);
				}
		});
	}

	var obtenerDptosDep=function(){
		var claved=$("#userid").val();
		var parametros = "opc=obtenerDptosDep"+"&clavedep="+claved;
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta){		 
				    $("#txtdptosDep").val(data.departamentos);
				 }
				}
		});
	}

	var mostrarAgregarDptoDep = function(){
		$.confirm({
		    title: 'Agregar departamento',
		    content:  '' +
    '<form action="" class="formName">' +
	    '<div>' +
		    '<label>Nombre Departamento</label>' +
		    '<input type="text" placeholder="Nombre Departamento" class="name" id="agdptodep" required />' +
	    '</div>' +
    '</form>',
		    buttons: {
		        confirm: {
		            text: 'Agregar',
		            btnClass: 'btn-blue',
		            action: function () {
		                var name = $("#agdptodep").val();
		                if(!name){
		                    $.alert('Ingrese el nombre del departamento');
		                    return false;
		                }
		                var dep=$("#userid").val();
		                agregarDptoDep(name,dep);

		            },
		            
		        },
		        cancel: {
		        	text: 'Cancelar',
		        	function () {
		            //close
		        	},
		        }
		    }
		});
	}

	var agregarDptoDep = function(nomdpto,cvedep){
		var parametros = "opc=agregarDepartamentoDep"+"&dependencia="+cvedep+"&nombre="+nomdpto+"&id="+Math.random();
		$.ajax({
				type: "POST",
				dataType: "json",
				url:"../datos/dependencia.php",
				data: parametros,
				success: function(data){
				 if(data.respuesta){
				 	var dptosmod=$("#txtdptomodif").val();
				 	$("#txtdptomodif").val(Number(dptosmod)+Number(1));
				 	obtenerDptosDep();
				 	$.alert('Se ha registrado el departamento: '+nomdpto);
				 	
				 }else{
				 	Materialize.toast(data.mensaje, 4000);
				 }
				}

			});
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
$("#btnFiltroSolicitudesDP").on("click",filtrarSolicitudes);
$("#btnClearFiltroSolDP").on('click',mostrarSolicitudesSeg);
$("#paginacionSolicitudesDP").on("click","#btnPag",filtrarSolicitudes);
$("#paginacionSolicitudesDP").on("click","#btnNextN",filtrarSolicitudes);
$("#paginacionSolicitudesDP").on("click","#btnPreviousN",filtrarSolicitudes);
$("#paginacionSolicitudesDP").on("click","#btnPagI",mostrarSolicitudesSeg);
$("#paginacionSolicitudesDP").on("click","#btnNextNI",mostrarSolicitudesSeg);
$("#paginacionSolicitudesDP").on("click","#btnPreviousNI",mostrarSolicitudesSeg);


$("#selProgramasV").on("change",vacanteenPrograma);
$("#btnModificarVacantes").on("click", modificarVacantes);
$("#btnGuardarVac").on("click",guardarVacantes);
$("#btnCancelarVac").on("click",cancelarModifVac);
$("#menuaperturaPrograma").on("click",mostrarAperturaProg);
$("#frmDepSSProgramas").on("submit",solicitarApPrograma);
$("#btnagregardptoDep").on("click",mostrarAgregarDptoDep);

}
$(document).on("ready",dependencia);