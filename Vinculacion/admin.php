<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/vinculacion.css">
	<script src="../js/vinculacion.js"></script>
	<script src="../js/materialInit.js"></script>
</head>
<body>
<nav class="navbar navbar-default left grey lighten-4" id="barra">	
				<ul>
					 <a class='dropdown-button btn grey lighten-4 btn-flat' href='#' data-beloworigin="true" data-activates='dropdownListSem' data-hover="true" id="menuAlumnos" style="color:black;"><i class="material-icons right">supervisor_account</i>Listado Sem.<b class="caret"></b></a>
						<ul class="dropdown-content" id="dropdownListSem">
							<li><a id="muestraAlumnos"  style="color:black;">Alumnos</a></li>
							<li><a id="muestraProgramas"  style="color:black;">Programas</a></li>
							<li><a id="muestraSolicitudes"  style="color:black;">Solicitudes</a></li>
						</ul>
						<a class='dropdown-button btn grey lighten-4 btn-flat ' href='#' data-beloworigin="true" data-activates='dropdownRegistro' data-hover="true" id="menuRegistro" style="color:black;"><i class="material-icons right">business</i>Registro<b class="caret"></b></a>
						<ul class="dropdown-content" id="dropdownRegistro">
							<li><a id="menuregistroAlumnos" style="color:black;" >Alumnos</a></li>
							<li><a id="menusubirCSV" style="color:black;" ><i class="material-icons">file_upload</i>Cargar curso</a></li>
							<li class="divider"></li>
							<li><a id="menuregistroEmpresas"  style="color:black;">Empresas</a></li>
							<li><a id="menuregistroProgramas"  style="color:black;">Programas</a></li>
						</ul>
					
						<a class=" waves-effect waves-teal btn-flat text-darken-1" href="#" id="menuTarjeta"><i class="material-icons right">folder</i>Expediente</a><!--Tarjeta de control-->

						<a  class="waves-effect waves-teal btn-flat text-darken-1" id="muestraResultados"><i class="material-icons right">toc</i>Resultados</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1" id="btnCambioClave"><i class="material-icons right">vpn_key</i>Contraseña</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1" id="btnSalir" href="../Inicio/index.php"><i class="material-icons right">input</i>Salir</a>

			</ul>
</nav>
<section id="opcVinculacion" class="display col s12 m6">
	<br><br>	
	<div id="listadoSolicitudes" class="card">
		<?php include'divSolicitudes.php'; ?>
	</div>
	<div id="detallesSolicitudA" class="card">
		<?php include'detallesSolicitud.php'; ?>
	</div>
	<div id="listadoProgramas" class="card">
		<?php include'divListadoProgramas.php'; ?>
	</div>
	</div>
	<div id="tarjetaControl" class="card">
		<?php include 'divTarjetaControlVista.php'; ?>
		<?php include 'divModalCalificacion.php'; ?>
		<?php include 'divModalRechazarDocumentos.php' ?>
	</div>
	<div id="registroAlumnos" class="card">
		<?php include 'divRegistroAlumnos.php' ?>
	</div>
	<div id="registroAlumnosSubirCurso" class="card">
		<?php include 'divSubirCurso.php' ?>
	</div>
	<div id="registroEmpresas" class="card">
		<?php include 'divRegistroEmpresa.php' ?>
	</div>
	<div id="registroProgramas" class="card">
		<?php include 'divRegistroProgramas.php' ?>
	</div>
	<div id="detallesPrograma" class="card">
		<?php include 'divDetallesPrograma.php' ?>
	</div>
	<div id="listadoAlumnos" class="card">
		<?php include 'divListadoAlumnos.php' ?>
	</div>
	<div id="listadoResultados" class="card">
		<?php include 'divListadoResultados.php' ?>
	</div>
		<div id="cambioClave" class="card">
		<?php include 'divClave.php' ?>
	</div>
</section>
</body>
</html>