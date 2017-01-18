<div class="container">
	<h5>Registro de programas</h5>
	<form action="javascript:void(0);" method= "POST" id="frmRegistroProgramas">
		<input type="text" class="form-control" placeholder="Nombre del programa" id="txtprognom" name="txtprognom" required>
		<select name="selprogdep" id="selprogdep">
			<option value="">Dependencia</option>
		</select>
		<select name="selprogdpto" id="selprogdpto">
			<option value="">Departamento</option>
		</select>
		<textarea placeholder="Objetivos" class="materialize-textarea" name="txtprogobj" id="txtprogobj" cols="30" rows="3"></textarea>
		<input type="number" class="form-control" placeholder="Vacantes" id="txtprogvac" name="txtprogvac" min="1" required>
		<select name="selprogmod" id="selprogmod" required>
			<option value="0" selected>Modalidad</option>
			<option value="Interno">Interno</option>
			<option value="Externo">Externo</option>
		</select>
		<input type="text" class="form-control" placeholder="Carrera preferente" id="txtprogcar" name="txtprogcar" required>
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
		<p>
			<input class="with-gap" name="selprogtipo" type="radio" id="tipoEd" value="Educacion-para-adultos"/>
			<label for="tipoEd">Educacion para Adultos</label>
		</p>
		<p>
			<input class="with-gap" name="selprogtipo" type="radio" id="tipoAd" value="Actividades-deportivas"/>
			<label for="tipoAd">Actividades Deportivas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogtipo" type="radio" id="tipoDc" value="Desarrollo-de-comunidad" />
			<label for="tipoDc">Desarrollo de comunidad</label>
		</p>
		<p>
			<input class="with-gap" name="selprogtipo" type="radio" id="TipoAc" value="Actividades-culturales"/>
			<label for="TipoAc">Actividades culturales</label>
		</p>
		<p>
			<input class="with-gap" name="selprogtipo" type="radio" id="tipoOt" value="Otros"/>
			<label for="tipoOt">Otros</label>
		</p>
		<input type="text" class="form-control" placeholder="Nombre responsable" id="txtprogresp" name="txtprogresp" required>
		<input type="text" class="form-control" placeholder="Puesto responsable" id="txtprogpues" name="txtprogpues" required>
		<select id="selprogest" name="selprogest">
			<option value="1" selected>Sin revisar</option>
			<option value="2">Aceptado</option>
			<option value="3">Rechazado</option>
		</select>
		<input type="submit" class="btn btn-lg btn-block btn-success" value="Registrar">
	</form>
	<br>
	<br>
</div>



