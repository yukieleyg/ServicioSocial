<form id="frmDetallesSolicitud" name="frmDetallesSolicitud">
	<div class="card-panel" id="divDetallesA" align="center">
		<label class="label label-default etiqueta">Detalles del Alumno</label><br><br><br>
		<input type="hidden" name="idSolicitud" id="idSolicitud">
		<div  class="row" style="margin-left:170px;" name="divDatos">
			<div class="col s10" style="text-align:left">
				<label class="lInputs">Nombre:   </label> <br><input class="cInputs" type="text" id="inputNombre" name="inputNombre" disabled><br>	
				<label class="lInputs">Carrera:  </label> <br><input class="cInputs" type="text" id="inputCarrera" name="inputCarrera" disabled="true"><br>
			</div>
		</div>
		<div class="row" style="margin-left:170px;"  name="divDatos1">
			<div class="col s5" style="text-align:left">
				<label class="lInputs">Periodo:   </label><br><input class="cInputs"type="text" id="inputPeriodo" disabled="true"><br>
				<label class="lInputs">Estado:   </label><br>
				<select name="selectEstado" id="selectEstado">
					<option value="0">Pendiente</option>
					<option value="1">Aceptado</option>
					<option value="2">Rechazado</option>	
				</select><br>
				
			</div>
			<div class="col s5" style="text-align:left">
				<label class="lInputs">Semestre:   </label> <br><input class="cInputs"type="text" id="inputSemestre" disabled="true"><br>	
				<label class="lInputs">Motivo:   </label><br><input type="text" class="cInputs" id="inputMotivo" name="inputMotivo" rows="4" cols="50"></input><br>
			</div>
		</div>
		<div class="row" style="margin-left:170px;"  name="divDatos3">
			<div class="col s5" style="text-align:left">
				<label class="lInputs">Dependencia:   </label><br><input class="cInputs"type="text" id="inputDependencia" disabled="true"><br>
				<label class="lInputs">Telefono:   </label> <br><input class="cInputs"type="text" id="inputTelefono" disabled="true"><br>			
			</div>
			<div class="col s5" style="text-align:left">
				<label class="lInputs">Programa: </label><br><input class="cInputs"type="text" id="inputPrograma" disabled="true"><br>
				<label class="lInputs">Email:   </label> <br><input class="cInputs"type="text" id="inputEmail" disabled="true"><br>
			</div>
		</div>
		<div  class="row" style="margin-left:170px;" name="divDatos2">
			<div class="col s10" style="text-align:left">
				<label class="lInputs">Dirección:   </label> <br><input class="cInputs" type="text" id="inputDireccion" disabled><br>	
				<label class="lInputs">Observaciones:   </label><br><input type="text" class="cInputs" id="inputObservaciones" name="inputObservaciones" rows="4" cols="50"></input><br>
			</div>
		</div><br>
		<div style="margin-left:550px;">
			<input type="submit" class="btn btn-success" value="ACEPTAR">
		</div>
	</div>
</form>