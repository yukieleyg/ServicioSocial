<div class="container">	
	<form class="col s12" method= "POST" id="frmDepSSProgramas" name="frmDepSSProgramas" action="javascript:void(0);">
	<br>	
	<h5>Solicitar apertura de Programa</h5>	
	<br>
    	<div class="row">
			<div class="input-field">		
				<input type="text" class="form-control" placeholder="Nombre del programa" id="txtprognomSS" name="txtprognomSS" required>
				<label for="txtprognomSS">Nombre del programa</label>
			</div>
		</div>
		<input type="hidden" name="selprogdepSS" id="selprogdepSS">
		<div class="row">
			<p><span class="label-select">Departamento</span></p>
		    <select name="selprogdptoSS" id="selprogdptoSS">
				<option value="">Seleccione departamento</option>
			</select>
		 </div>
	    	<div class="row">
				<div class="input-field">
					<textarea placeholder="Objetivos" class="materialize-textarea" name="txtprogobjSS" id="txtprogobjSS" cols="30" rows="3"></textarea>
					<label for="txtprogobjSS">Objetivos</label>
				</div>
			</div>
    	<div class="row">
			<div class="input-field">
				<input type="number" class="form-control" placeholder="Vacantes" id="txtprogvacSS" name="txtprogvacSS" min="1" required>
				<label for="txtprogvacSS">Vacantes</label>
			</div>
		</div>
    	<div class="row">
			<div class="input-field">
				<p><span class="label-select">Modalidad</span></p>
				<select name="selprogmodSS" id="selprogmodSS">
					<option value="Externo" selected>Externo</option>
				</select>
			</div>
		</div>
		<p>Tipo de Actividades</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoA" value="Administrativas"/>
			<label for="sstipoA">Administrativas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoT" value="Tecnicas"/>
			<label for="sstipoT">Técnicas</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoAs"  value="Asesorias"/>
			<label for="sstipoAs">Asesoria</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoI" value="Investigacion"/>
			<label for="sstipoI">Investigación</label>
		</p>
		<p>
			<input class="with-gap" name="selprogactSS" type="radio" id="sstipoD" value="Docentes"/>
			<label for="sstipoD">Docentes</label>
		</p>
		<p>
		<div class="row">
		<div class="col s3">
				<p>
					<input class="with-gap" name="selprogactSS" type="radio" id="sstipoOtras" value="Otros"/>
					<label for="sstipoOtras" placeholder="Tipo de actividad">Otras</label>

				</p>
			</div>
			
			<div class="col s6"> 
				<input type="text" name="txttipoOtros" id="txttipoOtros">
			</div>
		</div>
		<br>
    	<div class="row">
			<div class="input-field">
				<label for="txtprogactSS">Descripcion de actividades</label>
				<textarea placeholder="Descripcion actividad" class="materialize-textarea" name="txtprogactSS" id="txtprogactSS" cols="30" rows="3"></textarea>
			</div>
		</div>
    	<div class="row">
			<div class="input-field">
				<p><span class="label-select">Tipo de Programa</span></p>
				<select name="selprogtipoSS" id="selprogtipoSS">
					<option value="0" selected>Tipo de programa</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="input-field">
				<input type="text" class="form-control" placeholder="Nombre responsable" id="txtprogrespSS" name="txtprogrespSS" required>
				<label for="txtprogrespSS">Nombre responsable</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field">
				<input type="text" class="form-control" placeholder="Puesto responsable" id="txtprogpuesSS" name="txtprogpuesSS" required>
				<label for="txtprogpuesSS">Puesto responsable</label>
			</div>
		</div>		
    	<div class="row">
			<div class="input-field">
				<input type="hidden" value='0' id="selprogestSS" name="selprogestSS">
			</div>
		</div>
		<input type="submit" class="btn btn-lg btn-block btn-success right" value="SOLICITAR">
		<br>
	</form>
	<br>
	<br>
</div>



