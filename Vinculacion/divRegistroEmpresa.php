<div class="container">
	<h5>Registro de empresas</h5>
	<form action="javascript:void(0);" method= "POST" id="frmRegistroEmpresa">
		<input type="text" class="" placeholder="Nombre de la empresa" id="txtdepnom" name="txtdepnom" required>
		<input type="email" class=" validate" placeholder="Nombre de usuario (email)" id="txtdepusuario" name="txtdepusuario" required><div id="resultado"></div>
		<input type="text" class="" placeholder="RFC" id="txtdeprfc" name="txtdeprfc" maxlength="13" pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$" title="Ingresa un RFC válido" required>
		<input type="text" class="" placeholder="Titular" id="txtdeptitular" name="txtdeptitular" required>
		<input type="text" class="" placeholder="Direccion" id="txtdepdir" name="txtdepdir" required>
		<input type="tel" class="" placeholder="Telefono" id="txtdeptel" name="txtdeptel" pattern="^\d{7,10}$" title="Ingrese un número de teléfono válido" required>
		<select name="seldepest" id="seldepest">
			<option value="0" selected>Estado..</option>
			<option value="ALTA">ALTA</option>
			<option value="BAJA">BAJA</option>
		</select>
		<input type="submit" class="btn btn-lg btn-block btn-success right" value="Registrar">
		<br>
	</form>
	<br>
</div>

