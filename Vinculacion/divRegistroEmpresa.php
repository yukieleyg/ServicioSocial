<div class="container">
	<h5>Registro de empresas</h5>
	<form action="javascript:void(0);" method= "POST" id="frmRegistroEmpresa">
		<input type="text" class="form-control" placeholder="Nombre de la empresa" id="txtdepnom" name="txtdepnom" required>
		<input type="text" class="form-control validate" placeholder="Nombre de usuario (email)" id="txtdepusuario" name="txtdepusuario" required><div id="resultado"></div>
		<input type="text" class="form-control" placeholder="RFC" id="txtdeprfc" name="txtdeprfc" maxlength="12" required>
		<input type="text" class="form-control" placeholder="Titular" id="txtdeptitular" name="txtdeptitular" required>
		<input type="text" class="form-control" placeholder="Direccion" id="txtdepdir" name="txtdepdir" required>
		<input type="tel" class="form-control" placeholder="Telefono" id="txtdeptel" name="txtdeptel" required>
		<select name="seldepest" id="seldepest">
			<option value="0" selected>Estado..</option>
			<option value="ALTA">ALTA</option>
			<option value="BAJA">BAJA</option>
		</select>
		<input type="submit" class="btn btn-lg btn-block btn-success" value="Registrar">
	</form>
	<br>
</div>

