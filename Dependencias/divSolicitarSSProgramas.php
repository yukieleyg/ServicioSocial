<div class="container">
	<h5>Solicitar apertura de Programa</h5>
	<form action="javascript:void(0);" method= "POST" id="frmDepSSProgramas" name="frmDepSSProgramas">
		<input type="text" class="form-control" placeholder="Nombre del programa" id="txtprognomSS" name="txtprognomSS" required>
		<select name="selprogdepSS" id="selprogdepSS">
			<option value="" selected disabled>Dependencia</option>
		</select>
		
		<div class="row">
		    <select name="selprogdptoSS" id="selprogdptoSS" class="col s11">
				<option value="">Seleccione departamento</option>
			</select>
			<button class="btn-floating waves-effect waves-light blue right tooltipped" id="btnagregardptoSS" data-position="left" data-delay="50" data-tooltip="Agregar departamento" disabled><i class="material-icons">add</i></button>
	    </div>
		<textarea placeholder="Objetivos" class="materialize-textarea" name="txtprogobjSS" id="txtprogobjSS" cols="30" rows="3"></textarea>
		<input type="number" class="form-control" placeholder="Vacantes" id="txtprogvacSS" name="txtprogvacSS" min="1" required>
		<select name="selprogmodSS" id="selprogmodSS">
			<option value="" selected>Modalidad</option>
			<option value="Interno">Interno</option>
			<option value="Externo">Externo</option>
		</select>
		<select name="selprogcarSS[]" id="selprogcarSS" multiple>
			<option value="" selected disabled>Seleccione carrera preferente..</option>
		</select>
		<p>Tipo de Actividades</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoA" value="Administrativas"/>
			<label for="tipoA">Administrativas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoT" value="Tecnicas"/>
			<label for="tipoT">Técnicas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoAs"  value="Asesorias"/>
			<label for="tipoAs">Asesoria</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoI" value="Investigacion"/>
			<label for="TipoI">Investigación</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoD" value="Docentes"/>
			<label for="tipoD">Docentes</label>
		</p>
		<div class="row">
			<div class="col s3">
				<p>
					<input class="with-gap" name="selprogactSS" type="radio" id="tipoOtras" value="Otros"/>
					<label for="tipoOtras" placeholder="Tipo de actividad">Otras</label>

				</p>
			</div>

			<div class="col s6"> 
				<input type="text" name="tipoOtrasSS" id="txttipoOtrosSS">
			</div>
		</div>
		<p><label for="txtprogactSS">Descripcion de actividades</label></p>
		<textarea placeholder="Descripcion actividad" class="materialize-textarea" name="txtprogactSS" id="txtprogactSS" cols="30" rows="3"></textarea>
		
		<p>Tipo de Programa</p>

		<select name="selprogtipoSS" id="selprogtipoSS">
			<option value="0" selected>Tipo de programa</option>
		</select>
		<input type="text" class="form-control" placeholder="Nombre responsable" id="txtprogrespSS" name="txtprogrespSS" required>
		<input type="text" class="form-control" placeholder="Puesto responsable" id="txtprogpuesSS" name="txtprogpuesSS" required>
		<p><label>Estado</label></p>
		<select id="selprogestSS" name="selprogestSS">
			<option value="0">Sin revisar</option>
			<option value="1" selected>Aceptado</option>
			<option value="2">Rechazado</option>
		</select>
		<input type="submit" class="btn btn-lg btn-block btn-success right" value="Registrar">
		<br>
	</form>
	<br>
	<br>
</div>



