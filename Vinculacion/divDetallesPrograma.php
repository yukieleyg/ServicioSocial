<div class="container" id="detallesProgramaC">
	<form  id="frmDetallesPrograma" name="frmDetallesPrograma">
		<input type="hidden" id="idPrograma" name="idPrograma">
		<label class="label label-default etiqueta">Detalles del Programa</label> <br>
		<div class="row" style="margin-left:100px;"  name="divGrales">
			<div class="col s10" style="text-align:left">
				<label >Nombre</label>
				<input id="nombrePrograma" type="text" disabled><br>	
				<label> Tipo de Actividades</label>
				<input id ="tipodeactividades" type="text" disabled><br>	
				<label>Descripcion de Actividades</label>
				<textarea id ="desAct" type="text" disabled style="font-size: small;" class="materialize-textarea"></textarea> <br>	
			</div>
		</div>
		<div class="row" style="margin-left:100px;">
			<div class="col s5" style="text-align:left">
				<label>Tipo de programa</label>
				<input id ="tipoprograma" type="text" disabled><br>	
				<label>Empresa</label>
				<input id ="empresa" type="text" disabled><br>	
				<label>Responsable</label>
				<input id ="responsable" type="text" disabled><br>	
				<label >Vacantes Disponibles</label>
				<input type="number" id="vacantesInput" min= "0"><br>	
				<label>Estado</label>
				<select name="estadoPrograma" id="estadoPrograma">
					<option value="0">Pendiente</option>
					<option value="1">Aceptado</option>
					<option value="2">Rechazado</option>
				</select><br>	
				<label>Objetivo</label>
				<input id ="objetivo" type="text" disabled><br>	
			</div>
			<div class="col s5" style="text-align:left">
				<label>Modalidad</label>
				<input id ="modalidad" type="text" disabled><br>	
				<label>Departamento</label>
				<input id ="departamento" type="text" disabled><br>	
				<label>Puesto</label>
				<input id ="puesto" type="text" disabled><br>	
				<label for = "alumnosInput">Vacantes Ocupadas</label>
				<input type="number" id="alumnosInput"><br>	
				<label>Vigencia</label>
				<select name="vigenciaPrograma" id="vigenciaPrograma">
					<option value="0">Sin asignar</option>
					<option value="1">Vigente</option>
					<option value="2">Expirado</option>
				</select><br>
				<label>Carrera preferente</label>
				<textarea id="carrerapref" class="materialize-textarea" disabled="disabled"></textarea>
			</div>
		</div>
		<div class="row" style="margin-left:100px;"  name="divGrales">
			<div class="col s10" style="text-align:left">
				
			</div>
		</div>
		<div style="margin-left:550px;">
				<input id ="btnAceptar" type="submit" class="btn btn-success" value="ACEPTAR">
		</div><br>
	</form>
</div>