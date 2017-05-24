<div class="container">
	<h5>Registro de programas</h5>
	<form action="javascript:void(0);" method= "POST" id="frmRegistroProgramas" name="frmRegistroProgramas">
		<input type="text" class="form-control" placeholder="Nombre del programa" id="txtprognom" name="txtprognom" required>
		<select name="selprogdep" id="selprogdep">
			<option value="" selected disabled>Dependencia</option>
		</select>
		
		<div class="row">
		    <select name="selprogdpto" id="selprogdpto" class="col s11">
				<option value="">Seleccione departamento</option>
			</select>
			<button class="btn-floating waves-effect waves-light blue right tooltipped" id="btnagregardpto" data-position="left" data-delay="50" data-tooltip="Agregar departamento" disabled><i class="material-icons">add</i></button>
	    </div>
		<textarea placeholder="Objetivos" class="materialize-textarea" name="txtprogobj" id="txtprogobj" cols="30" rows="3"></textarea>
		<input type="number" class="form-control" placeholder="Vacantes" id="txtprogvac" name="txtprogvac" min="1" required>
		<select name="selprogmod" id="selprogmod">
			<option value="" selected>Modalidad</option>
			<option value="Interno">Interno</option>
			<option value="Externo">Externo</option>
		</select>
		<select name="selprogcar[]" id="selprogcar" multiple>
			<option value="" selected disabled>Seleccione carrera preferente..</option>
		</select>
		<p>Tipo de Actividades</p>
		<p>
			<input class="with-gap" name="selprogact" type="radio" id="tipoA" value="Administrativas"/>
			<label for="tipoA">Administrativas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogact" type="radio" id="tipoT" value="Tecnicas"/>
			<label for="tipoT">Técnicas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogact" type="radio" id="tipoAs"  value="Asesorias"/>
			<label for="tipoAs">Asesoria</label>
		</p>
		<p>
			<input class="with-gap" name="selprogact" type="radio" id="TipoI" value="Investigacion"/>
			<label for="TipoI">Investigación</label>
		</p>
		<p>
			<input class="with-gap" name="selprogact" type="radio" id="tipoD" value="Docentes"/>
			<label for="tipoD">Docentes</label>
		</p>
		<div class="row">
			<div class="col s3">
				<p>
					<input class="with-gap" name="selprogact" type="radio" id="tipoOtras" value="Otros"/>
					<label for="tipoOtras" placeholder="Tipo de actividad">Otras</label>

				</p>
			</div>

			<div class="col s6"> 
				<input type="text" name="tipoOtras">
			</div>
		</div>
		<p><label for="txtprogact">Descripcion de actividades</label></p>
		<textarea placeholder="Descripcion actividad" class="materialize-textarea" name="txtprogact" id="txtprogact" cols="30" rows="3"></textarea>
		
		<p>Tipo de Programa</p>

		<select name="selprogtipo" id="selprogtipo">
			<option value="0" selected>Tipo de programa</option>
		</select>
		<input type="text" class="form-control" placeholder="Nombre responsable" id="txtprogresp" name="txtprogresp" required>
		<input type="text" class="form-control" placeholder="Puesto responsable" id="txtprogpues" name="txtprogpues" required>
		<p><label>Estado</label></p>
		<select id="selprogest" name="selprogest">
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



