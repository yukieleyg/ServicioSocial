<div class="container" id="tarjetacontrol">
	<h5>Tarjeta de control</h5>
	<br>
	<div class="search-wrapper card">
            <input id="txtbuscaTarjeta" type="search">
            <button class="btn" id="btnbuscaTarjeta"><i class="material-icons">search</i></button>
    </div>
	

	</div>
	<div id="datosAlm" class="container">
		<form action="">
			<div class="col-sm-6">
				<label for="nombre" class="col-sm-2">Nombre</label>
				<input type="text" class="" name="tnombre" id="tnombre" readonly>
			</div>
			<div class="col-sm-3">
				<label for="" class="col-sm-2">Edad</label>
				<input type="text" class="" name="tedad" id="tedad" readonly>
			</div>
			<div class="col-sm-3">
				<label for="" class="col-sm-2">Sexo</label>
				<select name="tsexo" id="tsexo" id="" disabled>
					<option value="F">Femenino</option>
					<option value="M">Masculino</option>
				</select>
			</div>
			<div class="col-sm-8">
				<label for="" class="col-sm-2">Domicilio</label>
				<input type="text" name="tdomicilio" id="tdomicilio" readonly placeholder="Calle y número    Colonia     Ciudad y estado">
			</div>
			<div class="col-sm-4">
				<label for="" class="col-sm-2">Tel</label>
				<input type="text" class="" name="ttelefono" id="ttelefono"readonly>
			</div>
			<div class="col-sm-6">
				<label for="" class="col-sm-2">No. Control</label>
				<input type="text" class="" name="tncontrol" id="tncontrol" readonly>
			</div>
			<div class="col-sm-6">
				<label for="" class="col-sm-2">Créditos aprobados</label>
				<input type="text" class="" name="tcreditos" id="tcreditos" readonly>
			</div>
			<div class="col-sm-12">
				<label for="" class="col-sm-2">Periodo</label><br>
				<p >
					<input type="checkbox" id="test5" />
					<label for="test5">ENERO-JUNIO</label>
					&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="test6" />
					<label for="test6">AGOSTO-DICIEMBRE</label>
				</p>
			</div>
<br>
		</form>
		<hr>
	</div>
	
	<div id="info_programa_horas">
		<table id="horasacreditadastabla">

		</table>
		<hr>
	</div>
	
	<div id="controlexpediente1" class="col-sm-6" style="text-align:left;">
		<input type="checkbox" id="solicitud" class="filled-in"/>
		<label for="solicitud">Solicitud</label><br>
		<input type="checkbox" id="cursoin" class="filled-in"/>
		<label for="cursoin">Curso Inducción</label><br>
		<input type="checkbox" id="cartaap" class="filled-in"/>
		<label for="cartaap">Carta Aprobación</label><br>
		<input type="checkbox" id="plantra" class="filled-in"/>
		<label for="plantra">Plan de trabajo</label><br>

	</div>
	<div id="controlexpediente2" class="col-sm-6" style="text-align:left;">
		<input type="checkbox" id="repbim" class="filled-in"/>
		<label for="repbim">Reporte bimestral</label><br>
		<input type="checkbox" id="repfin" class="filled-in"/>
		<label for="repfin">Reporte final</label><br>
		<input type="checkbox" id="constanciaterm" class="filled-in"/>
		<label for="constanciaterm">constancia terminación</label><br>
		<input type="checkbox" id="constanciaof" class="filled-in"/>
		<label for="constanciaof">constancia oficial</label><br>
	</div>
</div>