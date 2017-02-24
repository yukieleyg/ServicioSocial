<div class="container">
	<div class="row inline" id="rowFiltroProgramas"><br>
		<div class="col s3">
			<select name="filtroProgramas" id="filtroProgramas">
				<option value="" disabled selected>Seleccione...</option>
				<option value="3">Estado</option>
				<option value="2">Carrera</option>
				<option value="1">Depedencia</option>
				<option value="0">Vigencia</option>
			</select>	
		</div>
		<div class="col s5">
			<select name="opcionProgramas" id="opcionProgramas"></select>	
		</div>
		<div class="col s2">	
			<button class="btn" id="btnFiltroProgramas"><i class="material-icons">search</i></button>
		</div>
	</div>
	<div class="row" id="rowProgramas">
		<div id="listaprogramas" class="col s14">
			<table id="tblprogramas" class="highlight" >			
			</table>	
		</div>
	</div>
</div>