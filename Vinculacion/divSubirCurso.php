<div class="container" id="alumnoscursomoodle">
	<h4>Subir archivo</h4>
<div class="row center">
	<div class="file-field input-field" style="width:70%;">
	<form action="../datos/upload.php" method="post" enctype="multipart/form-data" id="frmcurso">
		<div class="btn">
			<span>File</span>
			<input type="file"  accept=".csv" name="fileToUpload" id="fileToUpload">
			<!--<input type="file" accept=".csv" id="csvupload" name="csvupload">-->

		</div>

			<div class="file-path-wrapper">
				<input class="file-path validate" type="text" id="txtcargacsv">		
			</div>
			<input class="waves-effect waves-light blue lighten-1 btn right" type="submit" value="Subir" name="submit">
	</form>		
	</div>
    
    

</div>
<hr>
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
      <div class="collapsible-header"><i class="material-icons">playlist_add_check</i><span class="left">Alumnos registrados</span></div>
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
