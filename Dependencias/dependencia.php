<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/dependencia.css">
	<script src="../js/dependencia.js"></script>
	<script src="../js/materialInit.js"></script>
</head>
<body>
<nav class="navbar navbar-default left grey lighten-4" id="barraDependencia">	
				<ul>
					<a class=" waves-effect waves-teal btn-flat text-darken-1" href="#" id="solicitarSS"><i class="material-icons right">create_new_folder</i>Solicitar SS</a>
		
					<a class='dropdown-button btn grey lighten-4 btn-flat ' href='#' data-beloworigin="true" data-activates='dropdownSolicitarSS' data-hover="true" id="menuSeguimiento" style="color:black;"><i class="material-icons right">assignment_turned_in</i>Seguimiento<b class="caret"></b></a>
						<ul class="dropdown-content" id="dropdownSolicitarSS">
							<li><a id="menuregistroAlumnos" style="color:black;" >Alumnos</a></li>
							<li><a id="menuregistroProgramas"  style="color:black;">Programas</a></li>
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
</section>
</body>
</html>