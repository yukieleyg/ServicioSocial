<div class="container" id="tarjetacontrol">
	<h5>Tarjeta de control</h5>
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
  	<li>
  		<div class="collapsible-header" id="badgehoras"><i class="material-icons">query_builder</i><span class="left">Horas Acreditadas</span></div>
  		<div class="collapsible-body">
		<div id="info_programa_horas">
		<table id="horasacreditadastabla">

		</table>
	<hr>
</div>

  		</div>
  	</li>
  	<li>
  		<div class="collapsible-header" id="badgeexpediente"><i class="material-icons">folder</i><span class="left">Control de Expediente</span></div>
  		<div class="collapsible-body">
  		<br>
				<div id="controlexpediente1" class="col-sm-6 container" style="text-align:left;">
					<input type="checkbox" id="solicitud" class="filled-in"/>
					<label for="solicitud">Solicitud</label>
					<a href="#" id="isolicitud" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="cursoin" class="filled-in"/>
					<label for="cursoin">Curso Inducción</label>
					<a href="#" id="icursoin" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<!--se trata de la carta de ap´rpbacion o de aceptacion¿?-->
					<br>
					<input type="checkbox" id="cartaap" class="filled-in"/>
					<label for="cartaap">Carta Aprobación</label>
					<a href="#" id="icartaap" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="plantra" class="filled-in"/>
					<label for="plantra">Plan de trabajo</label>
					<a href="#" id="iplantra" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<label for="repbim">Reportes bimestrales</label><br>
					<input type="checkbox" id="repouno" class="filled-in"/>
					<label for="repouno">1</label>
					<a href="#" id="irepouno" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>

					<input type="checkbox" id="repodos" class="filled-in"/>
					<label for="repodos">2</label>
					<a href="#" id="irepodos" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>

					<input type="checkbox" id="repotres" class="filled-in"/>
					<label for="repotres">3</label><br>
					<a href="#" id="irepotres" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					<input type="checkbox" id="repfin" class="filled-in"/>
					<label for="repfin">Reporte final</label>
					<a href="#" id="irepfin" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
					<br>
					
						<div class="input-field col s6" style="margin-left: -2.3%;">
							<input type="checkbox" id="cartaterm" class="filled-in"/>
							<label for="cartaterm">Carta de terminación</label>
							<a href="#" id="icartaterm" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
						</div>
						<div class="input-field inline col s6">
							<label for="cartatermfecha">Fecha</label>
							<input type="date" id="cartatermfecha" class="datepicker" disabled  />
						</div>
					
						<div class="input-field col s6" style="margin-left: -2.3%;">
							<input type="checkbox" id="constanciaof" class="filled-in"/>
							<label for="constanciaof">Constancia oficial</label>
							<a href="#" id="iconstanciaof" style="display: none;" target=_blank class="ligadoc"><i class="material-icons">open_in_new</i></a>
						</div>
						<div class="input-field inline col s6">
							<label for="constanciaoffecha">Fecha</label>
							<input type="date" id="constanciaoffech" class="datepicker" disabled  />
						</div>
					
				<br>
				</div>
		
		</div>
	</li>
	</ul>
<br>

<!--<button class="btn waves-effect waves-light" id="btnverExpediente">Ver Control de Expediente</button>-->
</div>