<div class="container">
	<div id="asignarprograma" class="modal">
	<div class="container">
	    <div class="modal-content">
		    <h4>Registrar alumno en programa</h4>
		    <input id="ncontrol" name="ncontrol" type="hidden">
		    <div class="row">
		        <div class="input-field col s12">
		          <input id="nombre" name="ncontrol" type="text" disabled>
		          <label for="nombre" class="active">Nombre</label>
		        </div>
	      	</div>
	      	<div class="row">
		        <div class="input-field col s12">
		          <input id="carrera" name="carrera" type="text" disabled>
		          <label for="carrera" class="active">Carrera</label>
		        </div>
	        </div>
	      	<div class="row">
		        <div class="input-field col s12">
		          <input id="pcreditos" name="pcreditos" type="text" disabled>
		          <label for="pcreditos" class="active">% Creditos</label>
		        </div>
	        </div>
	      	
			<div class="row">
		        <div class="input-field col s12"> 
		          
			        <select id="pdisponibles" name="pdisponibles" >
						
					</select>
				<label for="pdisponibles" class="active">Programas Disponibles</label>
				</div>
	      	</div>
	      	<div class="row">
		        <div class="input-field col s12">
		          <input id="observaciones" name="observaciones" type="text">
		          <label for="observaciones" class="active">Observaciones</label>
		        </div>
	        </div>


	    </div>
	    </div>
	    <div class="modal-footer">
	      	<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
	      	<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat btn" id="btnasignarmodal">Asignar</a>	      	
	    </div>
  	</div>
	
	<h5>Registro de alumnos</h5>
	<form action="javascript:void(0);" method= "POST" id="frmRegistroAlumnos">
		<ul>
			<li>ver candidatos 70 creditos, periodo actual, estatus 1(no egresado ni baja), curso moodle</li>
		</ul>
		<div class="progress" id="load" style="display: none;">
			<div class="indeterminate"></div>
		</div>
		<table id="tblcandidatos" class="highlight">

		</table>

	</form>
	<br>
</div>
