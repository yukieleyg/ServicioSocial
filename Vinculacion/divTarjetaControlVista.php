<div class="container" id="tarjetacontrol">
	<h5>Expediente</h5><!--Tarjeta de control-->
	<br>
	<div class="row">
		<div class="search-wrapper card" id="divbuscar" style="float:right;">
			<input id="txtbuscaTarjeta" type="search" style="width: 60%;">
			<button class="btn" id="btnbuscaTarjeta"><i class="material-icons">search</i></button>
		</div>
	</div>
    <!--<div class="nav-wrapper">
      <form name="">
        <div class="input-field">
          <input id="search" type="search" required>
          <label for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div>
      </form>
  </div>-->
  <ul class="collapsible popout" data-collapsible="explandable">
  	<li>
  		<div class="collapsible-header" id="badgedatos"><i class="material-icons">perm_identity</i><span class="left">Datos Alumno</span></div>
  		<div class="collapsible-body">
  		<br>
  			<div class="container">
  				<form action="" id="frmdatosExpediente">
  					<div class="input-field">
  						<label for="nombre" class="col-sm-2">Nombre</label>
  						<input type="text" class="" name="tnombre" id="tnombre" readonly placeholder="Nombre">
  					</div>
  					<div class="input-field">
  						<label class="col-sm-2">Edad</label>
  						<input type="text" class="" name="tedad" id="tedad" readonly placeholder="Edad">
  					</div>
  					<div class="input-field">

  						<select name="tsexo" id="tsexo" id="" placeholder="Sexo" disabled>
  							<option>Seleccione..</option>
  							<option value="F">Femenino</option>
  							<option value="M">Masculino</option>
  						</select>
  						<label for="" class="">Sexo</label>
  					</div>
  					<div class="input-field">
  						<label for="" class="col-sm-2">Domicilio</label>
  						<input type="text" name="tdomicilio" id="tdomicilio" readonly placeholder="Calle y número    Colonia     Ciudad y estado">
  					</div>
  					<div class="input-field">
  						<label for="" class="col-sm-2">Tel</label>
  						<input type="text" class="" name="ttelefono" id="ttelefono"readonly placeholder="Teléfono">
  					</div>
  					<div class="input-field">
  						<label for="" class="col-sm-2">No. Control</label>
  						<input type="text" class="" name="tncontrol" id="tncontrol" readonly placeholder="No. Control">
  					</div>
  					<div class="input-field">
  						<label for="" class="col-sm-2">Créditos aprobados</label>
  						<input type="text" class="" name="tcreditos" id="tcreditos" readonly placeholder="Créditos aprobados">
  					</div>
  					<div class="input-field">
  						<label for="" class="col-sm-2">Periodo</label><br>
  						<p >
  							<input type="radio" id="pdotarjeta1" name="pdotarjeta" disabled="disabled">
  							<label for="pdotarjeta1">ENERO-JUNIO</label>
  							&nbsp;&nbsp;&nbsp;
  							<input type="radio" id="pdotarjeta3" name="pdotarjeta" disabled="disabled"/>
  							<label for="pdotarjeta3">AGOSTO-DICIEMBRE</label>
  						</p>
  					</div>
  					<br>
  				</form>
  			</div>
  		</div>
  	</li>
  	<!--li>
  		<div class="collapsible-header" id="badgehoras"><i class="material-icons">query_builder</i><span class="left">Horas Acreditadas</span></div>
  		<div class="collapsible-body">
		<div id="info_programa_horas">
		<table id="horasacreditadastabla">

		</table>
	<hr>
</div>

  		</div>
  	</li-->
  	<li>
  		<div class="collapsible-header" id="badgeexpediente"><i class="material-icons">folder</i><span class="left">Control de Expediente</span></div>
  		<div class="collapsible-body">
  		<br>
			<div id="controlexpediente1" class="container" style="text-align:left;">
				<table  class="striped">
  					<thead>
			          <tr>
			          	  <th></th>
			              <th>Documento</th>
			              <th>Link</th>
			              <th>Estado</th>
			              <th></th>
			              <th></th>
			          </tr>
			        </thead>
						<tr>
							<td><input type="checkbox" id="solicitud" class="inputVisible" disabled/></td>
							<td>Solicitud</td>
							<td><a href="#" id="isolicitud" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
							<td></td>
							<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '' disabled><i class= 'material-icons'>done_all</i></button></td>
							<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '' disabled><i class= 'material-icons'>close</i></a></td>
						</tr>
						<tr>
							<td><input type="checkbox" id="cursoin" class="inputVisible" disabled/></td>
							<td>Curso Inducción</td>
							<td></td>
							<td></td>
							<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '' disabled><i class= 'material-icons'>done_all</i></button></td>
							<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '' disabled><i class= 'material-icons'>close</i></a></td>
						</tr>
						<tr>
							<td><input type="checkbox" id="cartaap" class="inputVisible" disabled/></td>
							<td>Carta Aprobación</td>
							<td><a href="#" id="icartaap" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
							<td></td>
							<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '' disabled><i class= 'material-icons'>done_all</i></button></td>
							<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '' disabled><i class= 'material-icons'>close</i></a></td>
						</tr>
						<tr>
							<td><input type="checkbox" id="plantra" class="inputVisible" disabled/></td>
							<td>Plan de trabajo</td>
							<td><a href="#" id="iplantra" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
							<td></td>
							<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '' disabled><i class= 'material-icons'>done_all</i></button></td>
							<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '' disabled><i class= 'material-icons'>close</i></a></td>							
						</tr>
  				</table>
				<br>
				<hr>
				<table  class="striped">
					<tr>
						<th></th>
						<th>No.de Reporte</th>
						<th>Link</th>
						<th>Calif. Empresa</th>
						<th>Calif. Total</th>
						<th>Estado</th>
					</tr>
					<tr>
						<td><input type="checkbox" id="repouno" class="inputVisible" disabled/></td>
						<td>1</td>
						<td><a href="#" id="irepouno" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input type="checkbox" id="repodos" class="inputVisible" disabled/></td>
						<td>2</td>
						<td><a href="#" id="irepodos" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input type="checkbox" id="repotres" class="inputVisible" disabled/></td>
						<td>3</td>
						<td><a href="#" id="irepotres" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<br>
				<table class="striped">
					<tr>
						<th></th>
						<th>Documento</th>
						<th>Link</th>
						<th>Fecha</th>
					</tr>
					<tr>
						<td><input type="checkbox" id="cartaterm" class="inputVisible" disabled/></td>
						<td>Carta de terminación</td>
						<td><a href="#" id="icartaterm" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
						<td><input type="date" id="cartatermfecha" class="datepicker" disabled  /></td>
					</tr>
					<tr>
						<td><input type="checkbox" id="constanciaof" class="inputVisible" disabled/></td>
						<td>Constancia oficial</td>
						<td><a href="#" id="iconstanciaof" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a></td>
						<td><input type="date" id="constanciaoffech" class="datepicker" disabled  /></td>
					</tr>
				</table>
  				<!--
					<input type="checkbox" id="solicitud" class="" disabled/>
					<label>Solicitud</label>
					<a href="#" id="isolicitud" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="cursoin" class="" disabled/>
					<label for="cursoin">Curso Inducción</label>
					<a href="#" id="icursoin" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					se trata de la carta de ap´rpbacion o de aceptacion¿?
					<br>
					<input type="checkbox" id="cartaap" class="" disabled/>
					<label for="cartaap">Carta Aprobación</label>
					<a href="#" id="icartaap" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="plantra" class="" disabled/>
					<label for="plantra">Plan de trabajo</label>
					<a href="#" id="iplantra" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<label for="repbim">Reportes bimestrales</label><br>
					<input type="checkbox" id="repouno" class="" disabled/>
					<label for="repouno">1</label>
					<a href="#" id="irepouno" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="repodos" class="" disabled/>
					<label for="repodos">2</label>
					<a href="#" id="irepodos" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="repotres" class="" disabled/>
					<label for="repotres">3</label><br>
					<a href="#" id="irepotres" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="repfin" class="" disabled />
					<label for="repfin">Reporte final</label>
					<a href="#" id="irepfin" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					
						<div class="input-field col s6" style="margin-left: -2.3%;">
							<input type="checkbox" id="cartaterm" class="" disabled/>
							<label for="cartaterm">Carta de terminación</label>
							<a href="#" id="icartaterm" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
						</div>
						<div class="input-field inline col s6">
							<label for="cartatermfecha">Fecha</label>
							<input type="date" id="cartatermfecha" class="datepicker" disabled  />
						</div>
					
						<div class="input-field col s6" style="margin-left: -2.3%;">
							<input type="checkbox" id="constanciaof" class="" disabled/>
							<label for="constanciaof">Constancia oficial</label>
							<a href="#" id="iconstanciaof" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
						</div>
						<div class="input-field inline col s6">
							<label for="constanciaoffecha">Fecha</label>
							<input type="date" id="constanciaoffech" class="datepicker" disabled  />
						</div>-->
					
				<br>
				</div>
		
		</div>
	</li>
	</ul>
<br>

<!--<button class="btn waves-effect waves-light" id="btnverExpediente">Ver Control de Expediente</button>-->
</div>