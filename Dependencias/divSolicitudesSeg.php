<div class="card-panel" id="divSolicitudesSeg">
	<h1>Listado de Solicitudes</h1>
	<div class="row inline" id="rowFiltroSolicitudes"><br>
			<input type="hidden" id="paginaActualSol">
			<input type="hidden" id="opcionActualSol">
			<div class="col s3">
				<select name="filtroSolicitudesDependencia" id="filtroSolicitudesDependencia">
					<option value="" disabled selected>Seleccione...</option>
					<option value="0">Estado</option>
					<option value="1">Programa</option>
				</select>	
			</div>
			<div class="col s3" id="opcionSolicitudesDivDP">
				<select name="opcionSolicitudesDP" id="opcionSolicitudesDP"></select>
			</div>
			<div class="col s2">	
				<button class="btn" id="btnFiltroSolicitudesDP"><i class="material-icons">search</i></button>
			</div>	
			<div class="col s2 " id="divClearFiltroSolDP">
				<button class="btn" id="btnClearFiltroSolDP"><i class="material-icons">loop</i></button>
			</div>
	</div>				
	<div class="row" id="divTablaAlumnos">	
		<table id="tblAlumnos">
		</table>
		<div id="paginacionSolicitudesDP">
		</div>
	</div>
</div>