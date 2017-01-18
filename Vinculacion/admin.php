<!DOCTYPE html>
<html lang="es">
<head>

	<link rel="stylesheet" href="../css/vinculacion.css">
	<script src="../js/vinculacion.js"></script>	
</head>
<body>
<nav class="navbar navbar-default left grey lighten-4" id="barra">	
				<ul>
					<li class="dropdown" style="width: 15%;">
						<a data-toggle="dropdown" class="waves-effect waves-teal btn-flat text-darken-1" id="menuAlumnos"><i class="material-icons right">supervisor_account</i>Listado Sem.<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a id="muestraSolicitudes">Solicitudes</a></li>
							<li><a id="muestraAlumnos">Alumnos</a></li>
						</ul>
					</li>
					<li class="dropdown" style="width: 15%;">
						<a data-toggle="dropdown" class="waves-effect waves-teal btn-flat text-darken-1" id="menuRegistro"><i class="material-icons right">business</i>Registro<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a id="menuregistroEmpresas">Empresas</a></li>
							<li><a id="menuregistroProgramas">Programas</a></li>
							<li><a id="menuregistroAlumnos">Alumnos</a></li>
						</ul>
					</li>
					
						<a class=" waves-effect waves-teal btn-flat text-darken-1" href="#" id="menuTarjeta"><i class="material-icons right">class</i>Tarjeta de Control</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">toc</i>Resultados</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">vpn_key</i>Contraseña</a>

						<a  class="waves-effect waves-teal btn-flat text-darken-1"><i class="material-icons right">input</i>Salir</a>

			</ul>
</nav>
<section id="opcVinculacion" class="display">
	
<div id="listadoAlumnos">
	<?php include'adminAlumnosVista.php'; ?>
</div>
<div id="tarjetaControl">
	<?php include 'divTarjetaControlVista.php'; ?>
</div>
<div id="registroEmpresas" class="card">
	<?php include 'divRegistroEmpresa.php' ?>
</div>
<div id="registroProgramas" class="card">
	<?php include 'divRegistroProgramas.php' ?>
</div>
	
</section>
</body>
</html>