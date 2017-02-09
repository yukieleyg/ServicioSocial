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
							<li><a id="muestraSolicitudes"  style="color:black;">Solicitudes</a></li>
							<li><a id="muestraAlumnos"  style="color:black;">Alumnos&nbsp;&nbsp;</a></li>
							<li><a id="muestraProgramas"  style="color:black;">Programas</a></li>
						</ul>
						<a class='dropdown-button btn grey lighten-4 btn-flat ' href='#' data-beloworigin="true" data-activates='dropdownRegistro' data-hover="true" id="menuRegistro" style="color:black;"><i class="material-icons right">business</i>Registro<b class="caret"></b></a>
						<ul class="dropdown-content" id="dropdownRegistro">
							<li><a id="menuregistroEmpresas"  style="color:black;">Empresas</a></li>
							<li><a id="menuregistroProgramas"  style="color:black;">Programas</a></li>
							<li><a id="menuregistroAlumnos" style="color:black;" >Alumnos</a></li>
						</ul>
					
						<a class=" waves-effect waves-teal btn-flat text-darken-1" href="#" id="menuTarjeta"><i class="material-icons right">class</i>Tarjeta de Control</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">toc</i>Resultados</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">vpn_key</i>Contraseña</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">input</i>Salir</a>

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
</section>
</body>
</html>