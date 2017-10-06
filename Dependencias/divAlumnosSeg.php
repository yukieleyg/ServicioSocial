<div id="divAlumnosSeg" class="card-panel"><br>
	<h1>Listado de Alumnos</h1>
		<div class="row inline" id="rowFiltroAlumnos"><br>
			<input type="hidden" id="paginaActualAl" value=1>
			<input type="hidden" id="opcionActualAl">
			<div class="col s3" id="divfiltrosAlumnosSeg">
				<select name="" id="filtrosAlumnosSeg">
					<option value="" disabled selected>Seleccione...</option>
					<option value="0">Estado</option>
					<option value="1">Programa</option>
					<option value="2">Reporte</option>
				</select>	
			</div>
			<div class="col s3" id="divOpcionAlumnosSeg">
				<select name="" id="opcionAlumnosSeg"></select>
			</div>
			<div class="col s2">	
				<button class="btn" id="" value="1"><i class="material-icons">search</i></button>
			</div>	
			<div class="col s2 " id="">
				<button class="btn" id="" value="1"><i class="material-icons">loop</i></button>
			</div>
			<input type="hidden" value=1 id="">
			<input type="hidden" value=1 id="">
			<input type="hidden" value=1 id= "">

	</div>				
	<div class="row" id="divSeguimientoAlumnos">	
		<table id="tablaAlumnosSeg">
		</table>
		<div id="paginacionAlumnosSeg">
		</div>
		<div class="progress" id="loadAlumnosSeg" style="display: none">
				<div class="indeterminate"></div>
		</div>	
	</div>
</div>