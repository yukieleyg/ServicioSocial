<div class="card-panel" id="divSolicitud">
	<h1>Listado de Solicitudes</h1>
	<div class="row inline" id="rowFiltroSolicitudes"><br>
			<input type="hidden" id="paginaActualSol">
			<input type="hidden" id="opcionActualSol">
			<div class="col s3">
				<select name="filtroSolicitudes" id="filtroSolicitudes">
					<option value="" disabled selected>Seleccione...</option>
					<option value="0">Estado</option>
					<option value="1">Programa</option>
					<option value="2">No.de Control</option>
				</select>	
			</div>
			<div class="col s3" id="opcionSolicitudesNC">
				<input type="number" id="filtroNoControlSolicitudes">	
			</div>
			<div class="col s3" id="opcionSolicitudesDiv">
				<select name="opcionSolicitudes" id="opcionSolicitudes"></select>
			</div>
			<div class="col s2" id="opcionPeriodo">	
				<select name="filtroPeriodo" id="filtroPeriodo"></select>
			</div>
			<div class="col s2">	
				<button class="btn" id="btnFiltroSolicitudes"><i class="material-icons">search</i></button>
			</div>	
			<div class="col s2 "id="divClearFiltroSol">
				<button class="btn" id="btnClearFiltroSol"><i class="material-icons">loop</i></button>
			</div>
	</div>				
	<div class="row">	
		<table id="tablaSolicitudes">
		</table>
		<div id="paginacionSolicitudes">
		</div>
	</div>
</div>