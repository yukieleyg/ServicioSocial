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
	<!--<section id="alumnoscursomoodle">
		<div class="file-field input-field">
	      <div class="btn">
	        <span>File</span>
	        <input type="file" accept=".csv">
	      </div>
	      <div class="file-path-wrapper">
	        <input class="file-path validate" type="text" id="txtcargacsv">
	        <a class="waves-effect waves-light btn" id="matchemails">MATCH</a>
	      </div>
	    </div>
	</section>-->
	<form action="javascript:void(0);" method= "POST" id="frmRegistroAlumnos">   
		<div class="progress" id="load" style="display: none;">
			<div class="indeterminate"></div>
		</div>
		<table id="tblcandidatos" class="highlight centered">

		</table>
		<div id="btnPagRegAlm">
		<input type="hidden" id="paginaactual">
		<input type="hidden" id="paginastotal">
		<ul class="pagination" id="ulpagregalm">
   
  </ul>
		</div>

	</form>
	
	<br>
</div>
