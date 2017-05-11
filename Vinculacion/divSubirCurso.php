<div class="container" id="alumnoscursomoodle">
	<br>
	<h4>Cargar curso</h4>
<div class="row center col s6 offset-s3" style="width: 70%; margin-left: 15%;">
	<div class="file-field input-field" >
	<form action="#" method="post" enctype="multipart/form-data" id="frmcurso">
		<div class="btn">
			<span>File</span>
			<input type="file"  accept=".csv" name="fileToUpload" id="fileToUpload">
		</div>

			<div class="file-path-wrapper">
				<input class="file-path validate" type="text" id="txtcargacsv">		
			</div>
			<a href="#" class="waves-effect waves-light blue lighten-1 btn right" id="btnsubmitcurso">SUBIR</a>
	</form>		
	</div>
</div>

<br>
<div id="resultadosmatch">
	<ul class="collapsible" data-collapsible="expandable">
    <li>
      <div class="collapsible-header" id="tabNOencontrados"><i class="material-icons">warning</i><span class="left">Correos no registrados</span></div>
      <div class="collapsible-body" id="almnoencontrados" style="padding: 15px;">
      		
	      		<table class="striped" id="tblalmNOencontrados">
	      		
	      		</table>
      	
      </div>
    </li>
    <li>
      <div class="collapsible-header" id="tabEncontrados"><i class="material-icons">playlist_add_check</i><span class="left">Alumnos registrados</span></div>
      <div class="collapsible-body" id="almencontrados" style="padding: 15px;">
      	
      		<table class="striped" id="tblalmencontrados" >
      		
      		</table>
    
      </div>
    </li>   
  	</ul>
	<a class="waves-effect waves-light btn right" id="btnRegAlm">Registrar</a>
	<br><br>
</div>

</div>
