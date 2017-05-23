<div class="container">
	<div id="modalcalificarreporte" class="modal">
		<div class="container">
			<div class="modal-content">
				<h4>Evaluación bimestral</h4>
				<div class="input-field col s12">
					<select name="selestadorep" id="selestadorep">
						<option value="0" selected>Sin revisar</option>
						<option value="1">Aceptado</option>
						<option value="2">Rechazado</option>
					</select>
					<label>Estado</label>
				</div>
				<div id="reportecontenido">
					
					<input type="hidden" name="cvereporte" id="cvereporte">

					<table>
						<tr disabled>
							<td class="right">CALIFICACIÓN EMPRESA</td>
							<td><input id="txtcalempresa" name="txtcalempresa" type="number" min="1" max="65" class="validate" style="color:black;" disabled></td>
						</tr>
						<tr>
							<td>
								1. Entrega en tiempo y forma los reportes o informes solicitados
							</td>
							<td>
								<input id="txttiempoforma" name="txttiempoforma" type="number" min="1" max="25" class="validate cals" value=0 disabled>
							</td>
						</tr>
						<tr>
							<td>
								2. Mostró responsabilidad y compromiso con su Servicio Social
							</td>
							<td>
								<input id="txtresponsabilidad" name="txtresponsabilidad" type="number" min="1" max="10" class="validate cals" value=0 disabled> 
							</td>
							<input type="hidden" id="txtcalVinc">
						</tr>
						<tr>
							<td class="right">CALIFICACIÓN FINAL</td>
							<th border="1" id="txtcalififinal"></th>
						</tr>

					</table>
					<div class="row">
						<span class="col s9"><b class="left">NIVEL DE DESEMPEÑO</b></span>
						<select name="" id="selniveldes" class="col s3" disabled>
							<option value="" slected>Seleccione..</option>
							<option value="">EXCELENTE</option>
							<option value="">NOTABLE</option>
							<option value="">BUENO</option>
							<option value="">SUFUCIENTE</option>
							<option value="">INSUFICIENTE</option>
						</select></td>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input id="observacionesreportes" name="observacionesreportes" type="text" disabled class="cals">
							<label for="observacionesreportes" class="active">Observaciones</label>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat btn" id="btncalificarmodal">Calificar</a>	      	
		</div>
	</div>
</div>