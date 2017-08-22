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
			<div class="card-title purple darken-1" style="padding: 10%;" id= "divUsuario" name="divUsuario">	
				<span id="titulo-entrar" >DATOS DEL USUARIO</span>	
			</div>
			<div class="row">
				<div class="input-field col s11">
					<i class="material-icons prefix">perm_identity</i>
					<input type="text" class="validate" id="txtUsuario" placeholder="Usuario" autofocus value="dependencia">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s11">
					<i class="material-icons prefix">lock_outline</i>
					<input type="password" class="validate" id="txtClave" placeholder="Contraseña" value="dependencia">
					<a class="btn-floating btn-small waves-effect waves-light purple darken-1" id="mostrarClave"><i class="material-icons">visibility_off</i></a>
				</div>
			</div>
			<div id="divEntrar" name="divEntrar" class="center-align" >
				<button  class="btn btn-success green" id="btnEntrar" name="btnEntrar"><i class="material-icons left">send</i>Entrar</button>
			</div>
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
	<section id="dependencia">
		<?php include '../Dependencias/dependencia.php'; ?>	
	</section>

	<script src="../js/eventos.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
</body>
<footer>
	<?php include 'footer.php';?>
</footer>
</html>