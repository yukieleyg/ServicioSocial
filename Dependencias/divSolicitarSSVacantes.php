<div id="divSolicitarSS" class="container">
	<form class="col s12">
	    <div class="row">
			<br><h5>Abrir Vacantes</h5> <br>
			
	        <div class="row center">
	        	<select name="selProgramaV" id="selProgramaV" class="col s10">
	        		<option value="a">Seleccione programa...</option>
	        	</select>
	        	<input type="text" id="txtProgVacantes" class="col s2" readonly>
	        </div>
	    </div>
	    <table id="tblProgramasVac" class="striped">
	    	
	    </table>
	    <br>
		<button class="btn" id="btnModificarVacantes"><i class="material-icons">create</i>  Modificar</button>
		<button class="btn green" id="btnGuardarVac" disabled="disabled"><i class="material-icons" >save</i> Guardar</button>
		<button class="btn red" id="btnCancelarVac" disabled="disabled"><i class="material-icons" >close</i>  Cancelar</button><br><br><br>
	</form>
</div>