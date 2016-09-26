<!DOCTYPE html>
<html lang="es">
<head>
	<?php include 'head.php';?>
	<?php include 'encabezado.php';?>
</head>
<body background="../img/fondo.jpg">
	
<!--		<div id="divBarra">	
				<?php include '/datos/admin/admin_nav.php';?>
		</div>-->
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
	<!--<section>	
		<?php include '/datos/admin/adminAlumnosVista.php';?>
	</section>
	<section>
		<?php include '/datos/admin/TarjetaControlVista.php';?>
	</section>
	-->
	<section id="vinculacion">
		<?php include '../Vinculacion/admin.php'; ?>
	</section>
	

	<script src="../js/eventos.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
</body>
<footer>
	<?php include 'footer.php';?>
</footer>
</html>