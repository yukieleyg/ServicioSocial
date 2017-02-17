<div class="container" id="detallesProgramaC">
	<form  id="frmDetallesPrograma" name="frmDetallesPrograma">
		<input type="hidden" id="idPrograma" name="idPrograma">
		<label class="label label-default etiqueta">Detalles del Programa</label> <br>
		<div class="row" style="margin-left:100px;"  name="divGrales">
			<div class="col s10" style="text-align:left">
				<label >Nombre</label><br>
				<input id="nombre" type="text" disabled>
				<label> Tipo de Actividades</label>
				<input id ="tipodeactividades" type="text" disabled>
				<label>Descripcion de Actividades</label>
				<textarea id ="desAct" type="text" disabled style="font-size: small;" class="materialize-textarea"></textarea> 
			</div>
		</div>
		<div class="row" style="margin-left:100px;">
			<div class="col s5" style="text-align:left">
				<label>Tipo de programa</label>
				<input id ="tipoprograma" type="text" disabled>
				<label>Empresa</label>
				<input id ="empresa" type="text" disabled>
				<label>Responsable</label>
				<input id ="responsable" type="text" disabled>
				<label>Estado</label>
				<select name="estadoPrograma" id="estadoPrograma">
					<option value="0">Pendiente</option>
					<option value="1">Aceptado</option>
					<option value="2">Rechazado</option>
				</select>
			</div>
			<div class="col s5" style="text-align:left">
				<label>Modalidad</label>
				<input id ="modalidad" type="text" disabled>
				<label>Departamento</label>
				<input id ="departamento" type="text" disabled>
				<label>Puesto</label>
				<input id ="puesto" type="text" disabled>
				<label>Vigencia</label>
				<select name="vigenciaPrograma" id="vigenciaPrograma">
					<option value="0">Sin asignar</option>
					<option value="1">Vigente</option>
					<option value="2">Expirado</option>
				</select>
			</div>
		</div>
		<div class="row" style="margin-left:100px;"  name="divGrales">
			<div class="col s10" style="text-align:left">
				<label>Objetivo</label>
				<input id ="objetivo" type="text" disabled>
			</div>
		</div>
		<div style="margin-left:550px;">
				<input id ="btnAceptar" type="submit" class="btn btn-success" value="ACEPTAR">
		</div><br>
	</form>
</div>