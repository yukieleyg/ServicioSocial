<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/dependencia.css">
	<script src="../js/dependencia.js"></script>
	<script src="../js/materialInit.js"></script>
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
</head>
<body>
<nav class="navbar navbar-default left grey lighten-4" id="barraDependencia">	
				<ul>
					<a class='dropdown-button btn grey lighten-4 btn-flat ' href='#' data-beloworigin="true" data-activates='dropdownSolicitarServS' data-hover="true" id="btnMenuSolicitarS" style="color:black;" ><i class="material-icons right">create_new_folder</i>Solicitar SS</a>
					<ul  class="dropdown-content" id="dropdownSolicitarServS">
						<li><a id="menuabrirVacantes" style="color:black;" >Abrir vacantes </a></li>
						<li><a id="menuaperturaPrograma" style="color:black;" >Apertura programa</a></li>
					</ul>
		
					<a class='dropdown-button btn grey lighten-4 btn-flat ' href='#' data-beloworigin="true" data-activates='dropdownSolicitarSS' data-hover="true" id="menuSeguimiento" style="color:black;"><i class="material-icons right">assignment_turned_in</i>Seguimiento<b class="caret"></b></a>
						<ul class="dropdown-content" id="dropdownSolicitarSS">
							<li><a id="menuSolicitudesSeg" style="color:black;">Solicitudes</a></li>
							<li><a id="menuAlumnosSeg"  style="color:black;">Alumnos</a></li>
							<input type="hidden" value=1 id="valorPagina">
						</ul>
					
					<a class=" waves-effect waves-teal btn-flat text-darken-1" href="#" id="btnMisDatosDep"><i class="material-icons right">contact_mail</i>Mis datos</a>

					<a  class="waves-effect waves-teal btn-flat text-darken-1" id="btnCambioClaveDep"><i class="material-icons right">vpn_key</i>Contraseña</a>

					<a  class="waves-effect waves-teal btn-flat text-darken-1" id="btnSalir" href="../Inicio/index.php"><i class="material-icons right">input</i>Salir</a>

			</ul>
</nav>
<section id="opcDependencia" class="display col s12 m6">
	<br><br>
	<div id="cambioClaveDep" class="card">
		<?php include '../Inicio/divClave.php' ?>
	</div>
	<div id="misDatos" class ="card">
		<?php include 'divMisDatos.php' ?>
	</div>
	<div id="solicitarSSVacantes" class="card">
		<?php include 'divSolicitarSSVacantes.php' ?>
	</div>
	<div id="solicitarSSProgramas" class="card">
		<?php include 'divSolicitarSSProgramas.php' ?>
	</div>
	<div id="seguimientoSolicitudes" class="card">
		<?php include 'divSolicitudesSeg.php' ?>
	</div>
	<div id="seguimientoAlumnos" class="card">
		<?php include 'divAlumnosSeg.php' ?>
	</div>
</section>
</body>
</html>