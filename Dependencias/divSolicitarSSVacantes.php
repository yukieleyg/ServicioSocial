<div id="divSolicitarSS" class="container">
	<form class="col s12" method="POST">
	    <div class="row">
			<br><h5>Abrir Vacantes</h5> <br>
			
	        <div class="row center">
	        	<select name="selProgramasV" id="selProgramasV" class="col s10">
	        		<option value="a">Seleccione programa...</option>
	        	</select>
	        	<input type="text" id="txtProgVacantes" class="col s2" readonly>
	        </div>
	    </div>
	    <table id="tblProgramasVac" class="striped">
	    	
	    </table>
	    <br>
		<a class="btn" id="btnModificarVacantes"><i class="material-icons">create</i>  Modificar</a>
		<a class="btn green disabled" id="btnGuardarVac"><i class="material-icons" >save</i> Guardar</a>
		<a class="btn red disabled" id="btnCancelarVac"><i class="material-icons" >close</i>  Cancelar</a><br><br><br>
	</form>
</div>