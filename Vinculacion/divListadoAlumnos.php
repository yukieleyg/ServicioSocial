<div class="container" id="listadoAlumnosC"><br>
	<h1>Listado de Alumnos</h1>
	<div class="row inline" id="rowFiltroAlumnos"><br>
			<div class="col s3">
				<select name="filtroAlumnos" id="filtroAlumnos">
					<option value="" disabled selected>Seleccione...</option>
					<option value="0">Carrera</option>
					<option value="1">Empresa</option>
					<option value="2">Estado</option>
				</select>	
			</div>
			<div class="col s5" id="opcionAlumnosNC">
					<input type="number" id="filtroNoControlAlumnos">
			</div>
			<div class="col s5" id="opcionAlumnosDiv">
				<select name="opcionAlumnos" id="opcionAlumnos"></select>	
			</div>
			<div class="col s2" id="opcionPeriodoAlumnos">	
				<select name="filtroPeriodoAlumnos" id="filtroPeriodoAlumnos"></select>
			</div>
			<div class="col s2">	
				<button class="btn" id="btnFiltroAlumnos"><i class="material-icons">search</i></button>
			</div>
	</div>		
	<div class="row">
		<div id="listaAlumnos" class="col s12">
			<div class="progress" id="loadAlumnos" >
				<div class="indeterminate"></div>
			</div>
			<table id="tablaAlumnos" class="highlight">			
			</table>
			<div id="paginacionAlumnos">
			</div>	
		</div>
	</div>
</div>