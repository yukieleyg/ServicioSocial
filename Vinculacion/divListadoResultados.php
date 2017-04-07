<div class="container" id="listadoResultadosC"><br>
 <h1>Resultados Semestrales</h1>
 	<div class="progress" id="loadResultados" >
		<div class="indeterminate"></div>
	</div>
	<br>
	<div class="row" style="margin-left: 20%;">
		<div  class="col s3">
				<select name="filtroResultados" id="filtroResultados">
					<option value="" disabled selected>Seleccione...</option>
					<option value="1">1er. Reporte </option>
					<option value="2">2do. Reporte </option>
					<option value="3">3er. Reporte </option>
			</select>
		</div>	
		<div class="col s3">
				<select name="opcionResultados" id="opcionResultados">
					<option value="" disabled selected>Seleccione...</option>
					<option value="2">No evaluado</option>
					<option value="1">Evaluado</option>
			</select>	
		</div>
		<div class="col s2">
			<button class="btn" id="btnFiltroResultados"><i class="material-icons">search</i></button>
		</div>
	</div>
 	<ul class="collapsible popout" data-collapsible="explandable" id="ulResultados" style="width:130%; margin-left:-15%;">
  	</ul>
</div>
