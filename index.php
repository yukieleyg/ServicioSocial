<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Servicio Social ITC</title>
	<link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="css/dropdown.css">
	<link rel="stylesheet" href="css/estilos.css">

</head>
<body background="img/fondo.jpg">
	
		<?php include 'encabezado.php';?>
		<?php include '/datos/admin/admin_nav.php';?>
	
	<section>
		<div class="entradaUsuario card-panel" id="entradaUsuario">
			<div class="card-panel  purple darken-1">
				<h3 class="panel-title" id="titulo-entrar">DATOS DEL USUARIO</h3>
			</div>
			<div class="row">
				<div class="input-field col s11">
					<i class="material-icons prefix">perm_identity</i>
					<input type="text" class="validate" id="txtUsuario" placeholder="Usuario" autofocus>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s11">
					<i class="material-icons prefix">lock_outline</i>
					<input type="password" class="validate" id="txtClave" placeholder="Contraseña">
					<a class="btn-floating btn-small waves-effect waves-light purple darken-1" id="mostrarClave"><i class="material-icons">visibility_off</i></a>
				</div>
			</div>
			<button id="btnEntrar" class="btn btn-success btn-block green"><i class="material-icons left">send</i>Entrar</button>
		</div>

	</section>
	<section>	
		<?php include 'adminAlumnosVista.php';?>
	</section>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/eventos.js"></script>
	<script src="js/admin.js"></script>
</body>
</html>