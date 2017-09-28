<div id="divMisDatos" class="row">
	<form class="col s12">
	    <div class="row">
			<br><h5>Mis datos</h5> <br>
			<div class="col s6">
	        	<label class="left" for="nomDep">Nombre de la dependencia</label>
				<input type="text" class="validate" disabled="disabled" id="nomDep">
	        </div>
	        <div class="col s6">
				<label class="left" for="titDep">Titular</label>
				<input type="text" disabled="disabled" id="titDep">
	        </div>
			<div class="col s6">
	        	<label class="left" for="dirDep">Direccion</label>
				<input type="text" disabled="disabled" id="dirDep">
	        </div>
	        <div class="col s6">
				<label class="left" for="pueDep">Puesto</label>
				<input type="text" disabled="disabled" id="pueDep">
	        </div>
			<div class="col s6" >
				<label class="left" for="telDep">Telefono</label>
				<input type="text" disabled="disabled" id="telDep">
	        </div>
	        <div class="col s5">
	        	<label for="txtdptosDep" class="left">Departamentos</label>
	        	<textarea name="txtdptosDep" id="txtdptosDep" class="materialize-textarea" style="resize: none;" data-role="none" disabled="disabled"></textarea>
	        	
	        </div>
	        <div class="col s1"> 
	        	<br><br>
				<button class="btn-floating waves-effect waves-light blue right tooltipped" id="btnagregardptoDep" data-position="left" data-delay="50" data-tooltip="Agregar departamento" disabled><i class="material-icons">add</i></button>
				<input type="hidden" id="txtdptomodif" value=0>
	        </div>
	    </div>
		<button class="btn" id="btnModificarDatos"><i class="material-icons">create</i>  Modificar</button>
		<button class="btn green" id="btnGuardarDatos" disabled="disabled"><i class="material-icons" >save</i> Guardar</button>
		<button class="btn red" id="btnCancelarDatos" disabled="disabled"><i class="material-icons" >close</i>  Cancelar</button><br><br><br>
	</form>
</div>