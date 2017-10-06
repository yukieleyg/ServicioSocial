<?php
require_once('entrar.php');
function mostrarMisDatos(){
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM dependencias WHERE cveusuario_1 =%s",$usuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombre 	= $row['nomdependencia'];
	$direccion	= $row['direccion'];	
	$telefono	= $row['telefono'];
	$titular	= $row['titular'];
	$puesto 	= $row['puesto'];
	if($res){
		$respuesta	= true;
	}
	$arrayJSON = array('respuesta' => $respuesta, 'nombre' => $nombre, 'direccion' => $direccion, 'telefono' => $telefono, 'titular' => $titular, 'puesto' => $puesto);
	print json_encode($arrayJSON);


}
function guardarDatos(){
	$respuesta 	= false; 
	$usuario	= "'".$_POST["usuario"]."'";
	$nombreDep 	= "'".$_POST["nombreDep"]."'";
	$dirDep		= "'".$_POST["dirDep"]."'";	
	$telDep		= "'".$_POST["telDep"]."'";
	$titDep		= "'".$_POST["titDep"]."'";
	$pueDep		= "'".$_POST["pueDep"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM dependencias WHERE cveusuario_1 =%s",$usuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombre 	= "'".$row['nomdependencia']."'";
	$direccion	= "'".$row['direccion']."'";	
	$telefono	= "'".$row['telefono']."'";
	$titular	= "'".$row['titular']."'";
	$puesto 	= "'".$row['puesto']."'";
	if(($nombreDep!=$nombre)||($dirDep!=$direccion)||($telDep!=$telefono)||($titDep!=$titular)
		||($pueDep!=$puesto)){
		$respuesta = true;
	}
	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);
}
function guardarDatosModif(){
	$respuesta 	= false; 
	$usuario	= "'".$_POST["usuario"]."'";
	$nombreDep 	= "'".$_POST["nombreDep"]."'";
	$dirDep		= "'".$_POST["dirDep"]."'";	
	$telDep		= "'".$_POST["telDep"]."'";
	$titDep		= "'".$_POST["titDep"]."'";
	$pueDep		= "'".$_POST["pueDep"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("UPDATE dependencias SET  nomdependencia= %s, direccion =%s, telefono = %s, titular= %s, puesto= %s WHERE cveusuario_1 =%s",$nombreDep, $dirDep, $telDep, $titDep, $pueDep, $usuario);
	$res		= mysql_query($qryvalida);
	if(mysql_affected_rows()>0){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
	$arrayJSON =array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}
function mostrarProgramasVac(){
	$respuesta 	= false;
	$mensaje="No se han podido obtener los programas";
	$cn 		= conexionLocal();
	$usuario	= "'".$_POST["usuario"]."'";
	$qryVac 	= sprintf("	SELECT nombre,
							vacantes
							FROM programas p
							INNER JOIN dependencias d on d.cvedependencia=p.cvedependencia
							WHERE d.cveusuario_1=%s AND p.vigencia=1 AND p.estado=1
							ORDER BY vacantes ASC",$usuario);
	$res 		=mysql_query($qryVac);
	$arreglo=Array();
	while($row=mysql_fetch_assoc($res)){
		$programa= $row['nombre'];
		$vacantes= $row['vacantes'];
		$respuesta=true;
		$mensaje="";
		$arreglo[]=array($programa,$vacantes);
	}
	$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje, 'tablaProgramas'=>$arreglo);
	print json_encode($arrayJSON);
}
function llenaProgramasVac(){
	$respuesta  =	false;
	$usuario	= "'".$_POST["usuario"]."'";
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$cons=sprintf("SELECT cveprograma, 
							nombre 
					FROM programas p
					INNER JOIN dependencias d on d.cvedependencia=p.cvedependencia
					WHERE d.cveusuario_1=%s AND p.vigencia=1 AND p.estado=1
					ORDER BY nombre ASC",$usuario);
	$opciones=Array();
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_assoc($res)) {
                  $cve = $row['cveprograma'];
                  $nom = $row['nombre']; 
                  $opciones[]=array($cve,$nom);
				$respuesta=true;
		}
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);

}

function getPeriodoAct(){
	$respuesta=false;
	$cn 		= conexionBD();
	$qryvalida	= sprintf("select PARFOL1 from DPARAM where PARCVE= 'PRDO'");
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$periodoAct	= $row["PARFOL1"];
	return $periodoAct;
}
function mostrarSolicitudesSeg(){
	$pagina 	= $_POST["pagina"];
	$inicio 	= ($pagina-1)*10;
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$pdoAct 		= getPeriodoAct();
	$conexion 		= conexionLocal();
	$qrySolicitudes = sprintf("SELECT s.estado, s.cveusuario_1 , s.cvesolicitud, s.cveprograma_1, p.nombre FROM solicitudes AS s INNER JOIN programas AS p  ON p.cveprograma = s.cveprograma_1 
		INNER JOIN dependencias as dp ON dp.cvedependencia = p.cvedependencia
		WHERE dp.cveusuario_1 = %s  
			AND s.pdocve_1 = %s
			LIMIT 10 OFFSET %s",$usuario, $pdoAct, $inicio);
	$resSolicitudes = mysql_query($qrySolicitudes);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla 		.=  "<th>Carrera</th>";
	$tabla 		.=  "<th>Semestre</th>";
	$tabla		.=	"<th>Estado</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th></th>";
	$tabla		.=	"</thead></tr>";
	while($row0 = mysql_fetch_array($resSolicitudes)){
		$respuesta = true;
		$cveusuario  = $row0["cveusuario_1"];
		$cveprograma = $row0["cveprograma_1"];
		$cvesolicitud = $row0["cvesolicitud"];
		/*$cn1		= conexionLocal();
		$qryvalida1	= sprintf("SELECT * FROM programas WHERE cveprograma = %s ",$cveprograma);
		$res1		= mysql_query($qryvalida1);
		$row1		= mysql_fetch_array($res1);*/
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUCTR, DA.ALUNOM, DA.ALUAPP, DA.ALUAPM, DC.CARCVE, DC.CALNPE, DCRR.CARNOM 
			FROM DALUMN AS DA INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR
			INNER JOIN DCARRE AS DCRR ON DCRR.CARCVE = DC.CARCVE
		 	WHERE DA.ALUCTR = %s",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$semestre	= $row["CALNPE"];
		$nomCarrera = $row["CARNOM"];
		$tabla		.= "<tr>";
		$tabla		.= "<td>".$row["ALUCTR"]."</td>";
		$tabla		.= "<td>".$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"]."</td>";
		$tabla .= "<th>".$nomCarrera."</th>";
		$tabla .= "<th>".$semestre."</th>";
		if($row0["estado"]==0){
			$tabla		.= "<td>"."PENDIENTE"."</td>";
		}else if($row0["estado"]==1){
			$tabla		.="<td>"."ACEPTADO"."</td>";
		}else{
			$tabla		.="<td>"."RECHAZADO"."</td>";
		}

		if($row0["estado"]!=0){
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
			
		}else{
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";

		}

		$tabla		.= "</tr>";
	}
	$cn 				 = conexionLocal(); 
	$qrySolicitudesCount = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes AS s INNER JOIN programas AS p  ON p.cveprograma = s.cveprograma_1 
		INNER JOIN dependencias as dp ON dp.cvedependencia = p.cvedependencia WHERE dp.cveusuario_1 = %s  
			AND s.pdocve_1 = %s
			",$usuario, $pdoAct);
	$resSolicitudesCount = mysql_query($qrySolicitudesCount);
	$row 				 = mysql_fetch_array($resSolicitudesCount);
	$total 				= $row["TOTAL"];
	$botonesTotal 		= intval($total/10);
	$restante 			= $total - ($botonesTotal*10);
	$previo 			= $pagina - 1;
	$siguiente 			= $pagina + 1;
	//var_dump($total);
	if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons" value='.$previo.'>chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousNI" value='.$previo.'><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPagI"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPagI"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina== $botonesTotal or $botonesTotal== 0){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextNI" value='.$siguiente.'><a><i class="material-icons">chevron_right</i></a></li>';
		}
	$arrayJSON = array('respuesta' => $respuesta, 'tabla' => $tabla,'botones' => $botones);
	print json_encode($arrayJSON);

}

function aceptarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM solicitudes WHERE cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$programa 	= $row["cveprograma_1"];
	$aceptado 	= 1;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cvesolicitud = %s",$aceptado,$solicitud);	
	$resU 		= mysql_query($qryvalidaU);
	if($resU){
		$respuesta = true;
		$consulta = sprintf("INSERT INTO  expedientes VALUES (NULL,%s,%s,%s,CURRENT_TIMESTAMP,' ',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0)",$solicitud,$usuario,$programa);
		$resconsulta= mysql_query($consulta);	
	}
	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}

function rechazarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM  solicitudes WHERE cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$cnU 		= conexionLocal();
	$rechazado 	= 2;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cvesolicitud = %s",$rechazado,$solicitud);	
	$resU 		= mysql_query($qryvalidaU);
	if($resU){
		$respuesta = true;
	}

	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}

function consultaFiltroSolicitudesDP(){
	$usuario	= "'".$_POST["usuario"]."'";
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$qry 		= sprintf("SELECT cvedependencia FROM dependencias WHERE cveusuario_1 = %s",$usuario);
	$res 		= mysql_query($qry);
	$row		= mysql_fetch_array($res);
	$cvedependencia = $row['cvedependencia'];
	$cn 			= conexionLocal();
	$qryvalida 		= sprintf("SELECT * FROM programas where cvedependencia = %s",$cvedependencia);
	$res 			= mysql_query($qryvalida);
	$opciones 		= "";
	$respuesta 		= false;
	while($row = mysql_fetch_array($res)){
			$cve 		= $row['cveprograma'];
			$nom 		= $row['nombre'];
			$opciones 	.= '<option value="'.$cve.'">'.$nom.'</option>';
			$respuesta   = true;
	}
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta);
	print json_encode($arrayJSON);

}
function filtrarSolicitudesEstado(){
	$pagina 	= $_POST["pagina"];
	$inicio 	= ($pagina-1)*10;
	$estado 	= $_POST["estado"];
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	mysql_query("set NAMES utf8");
	$pdoAct 		= getPeriodoAct();
	$conexion 		= conexionLocal();
	$qrySolicitudes = sprintf("SELECT s.estado, s.cveusuario_1 , s.cvesolicitud, s.cveprograma_1, p.nombre FROM solicitudes AS s 
		INNER JOIN programas AS p ON p.cveprograma = s.cveprograma_1
		INNER JOIN dependencias AS dp ON dp.cvedependencia = p.cvedependencia 
		WHERE s.pdocve_1 = %s 
		AND s.estado = %s 
		AND dp.cveusuario_1 = %s
		LIMIT 10 OFFSET %s",  $pdoAct, $estado, $usuario, $inicio);
	$resSolicitudes = mysql_query($qrySolicitudes);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla 		.=  "<th>Carrera</th>";
	$tabla 		.=  "<th>Semestre</th>";
	$tabla		.=	"<th>Estado</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th></th>";
	$tabla		.=	"</thead></tr>";
	while($row0 = mysql_fetch_array($resSolicitudes)){
		$respuesta = true;
		$cveusuario  = $row0["cveusuario_1"];
		$cveprograma = $row0["cveprograma_1"];
		$cvesolicitud = $row0["cvesolicitud"];
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUCTR, DA.ALUNOM, DA.ALUAPP, DA.ALUAPM, DC.CARCVE, DC.CALNPE, DCRR.CARNOM FROM DALUMN AS DA 
			INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR 
			INNER JOIN DCARRE AS DCRR ON DC.CARCVE = DC.CARCVE
			WHERE DA.ALUCTR = %s",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$semestre	= $row["CALNPE"];
		$nomCarrera = $row["CARNOM"];
		$tabla		.= "<tr>";
		$tabla		.= "<td>".$row["ALUCTR"]."</td>";
		$tabla		.= "<td>".$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"]."</td>";
		$tabla .= "<th>".$nomCarrera."</th>";
		$tabla .= "<th>".$semestre."</th>";
		if($row0["estado"]==0){
			$tabla		.= "<td>"."PENDIENTE"."</td>";
		}else if($row0["estado"]==1){
			$tabla		.="<td>"."ACEPTADO"."</td>";
		}else{
			$tabla		.="<td>"."RECHAZADO"."</td>";
		}

		if($row0["estado"]!=0){
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
			
		}else{
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";

			}
		}
		$tabla		.= "</tr>";
		$conexion 			= conexionLocal();
		$qryEstadoCount = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes AS s 
		INNER JOIN programas AS p ON p.cveprograma = s.cveprograma_1
		INNER JOIN dependencias AS dp ON dp.cvedependencia = p.cvedependencia 
		WHERE s.pdocve_1 = %s 
		AND s.estado = %s 
		AND dp.cveusuario_1 = %s",  $pdoAct, $estado, $usuario);
		$resEstadoCount 	= mysql_query($qryEstadoCount);
		$rowCount 			= mysql_fetch_array($resEstadoCount);
		$total 				= $rowCount['TOTAL'];
		$botonesTotal 		= intval($total/10);
		$restante 			= $total - ($botonesTotal*10);
		$previo 			= $pagina - 1;
		$siguiente 			= $pagina + 1;
		if($restante>0){
				$botonesTotal = $botonesTotal+1;
			}		
			if($botonesTotal==1){
				$botonesTotal = 0;
			}
			$botones = '<ul class="pagination" id="botonesPaginacion">';
			if($pagina==1){
				$botones .= '<li class="disabled"><a><i class="material-icons" value='.$previo.'>chevron_left</i></a></li>  ';
			}else{	
				$botones .= '<li class="waves-effect" id="btnPreviousN" value='.$previo.'><a><i class="material-icons">chevron_left</i></a></li>  ';
			}
			for($i=0;$i<$botonesTotal;$i++){
				$numero  	= $i+1;
				if($numero==$pagina){
					$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
				}else{
					$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
				}
			}
			if($pagina== $botonesTotal or $botonesTotal== 0){
	  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
			}else{
	  			$botones .= '<li class="waves-effect" id="btnNextN" value='.$siguiente.'><a><i class="material-icons">chevron_right</i></a></li>';
			}
	$arrayJSON = array('respuesta' => $respuesta, 'tabla' => $tabla, 'botones' => $botones);
	print json_encode($arrayJSON);

}
function filtrarSolicitudesProgramas(){
	$pagina 	= $_POST["pagina"];
	$inicio 	= ($pagina-1)*10;
	$programa 	= $_POST["programa"];
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	$pdoAct 		= getPeriodoAct();
	$conexion 		= conexionLocal();
	$qryProgramas 	= sprintf("SELECT s.estado, s.cveusuario_1 , s.cvesolicitud, s.cveprograma_1, p.nombre FROM solicitudes AS s 
		INNER JOIN programas AS p  ON p.cveprograma = s.cveprograma_1
		INNER JOIN dependencias AS dp ON dp.cvedependencia = p.cvedependencia 
		WHERE  dp.cveusuario_1 = %s 
				AND s.pdocve_1 = %s 
				AND p.cveprograma = %s 
				LIMIT 10 OFFSET %s", $usuario, $pdoAct, $programa, $inicio);
	$resProgramas = mysql_query($qryProgramas);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla 		.=  "<th>Carrera</th>";
	$tabla 		.=  "<th>Semestre</th>";
	$tabla		.=	"<th>Estado</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th></th>";
	$tabla		.=	"</thead></tr>";
	while($row0 = mysql_fetch_array($resProgramas)){
		$respuesta = true;
		$cveusuario  = $row0["cveusuario_1"];
		$cveprograma = $row0["cveprograma_1"];
		$cvesolicitud = $row0["cvesolicitud"];
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUCTR, DA.ALUNOM, DA.ALUAPP, DA.ALUAPM, DC.CARCVE, DC.CALNPE,DCRR.CARNOM FROM DALUMN AS DA 
			INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR 
			INNER JOIN DCARRE as DCRR ON DCRR.CARCVE = DC.CARCVE
			WHERE DA.ALUCTR = %s
			",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$cvecarrera = $row["CARCVE"];	
		$semestre	= $row["CALNPE"];
		$nomCarrera = $row["CARNOM"];
		$tabla		.= "<tr>";
		$tabla		.= "<td>".$row["ALUCTR"]."</td>";
		$tabla		.= "<td>".$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"]."</td>";
		$tabla .= "<th>".$nomCarrera."</th>";
		$tabla .= "<th>".$semestre."</th>";
		if($row0["estado"]==0){
			$tabla		.= "<td>"."PENDIENTE"."</td>";
		}else if($row0["estado"]==1){
			$tabla		.="<td>"."ACEPTADO"."</td>";
		}else{
			$tabla		.="<td>"."RECHAZADO"."</td>";
		}

		if($row0["estado"]!=0){
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
			
		}else{
			$tabla		.= "<td>".$row0["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";

		}

		$tabla		.= "</tr>";
	}
	$cn = conexionLocal();
	$qryProgramasC 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes AS s 
		INNER JOIN programas AS p  ON p.cveprograma = s.cveprograma_1  
		INNER JOIN dependencias AS dp ON dp.cvedependencia = p.cvedependencia 
		WHERE  dp.cveusuario_1 = %s 
				AND s.pdocve_1 = %s 
				AND p.cveprograma = %s ", $usuario, $pdoAct, $programa);
	$resCount = mysql_query($qryProgramasC);
	$rowC 				= mysql_fetch_array($resCount);
	$total 				= $rowC['TOTAL'];
	$botonesTotal 		= intval($total/10);
	$restante 			= $total - ($botonesTotal*10);
	$previo 			= $pagina-1;
	$siguiente 			= $pagina+1;
	if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousN" value='.$previo.'><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina==$botonesTotal or $botonesTotal== 0){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextN" value ='.$siguiente.'><a><i class="material-icons">chevron_right</i></a></li>';
		}
	$arrayJSON = array('respuesta' => $respuesta, 'tabla' => $tabla, 'botones' => $botones);
	print json_encode($arrayJSON);

}
function vacanteenPrograma(){
	$respuesta	=	false;
	$cveprograma= 	"'".$_POST["cveprograma"]."'";
	$conexion 	=	conexionLocal();
	mysql_query("SET NAMES utf8");
	$qry 		= sprintf("SELECT vacantes FROM programas where cveprograma=%s",$cveprograma);
	$res=mysql_query($qry);
	if($row=mysql_fetch_array($res)){
		$vacante=$row["vacantes"];
		$respuesta=true;
	}
	$arrayJSON=array('respuesta'=>$respuesta,'numvacantes'=>$vacante);
	print json_encode($arrayJSON);
}
function guardarPrograma(){
	$respuesta	= false;
	$cveprograma= 	"'".$_POST["cveprograma"]."'";
	$vacantes 	= "'".$_POST["vacantes"]."'";
	$cn 		= conexionLocal();
	$qryvacantes	= sprintf("UPDATE programas SET  vacantes= %s WHERE cveprograma=%s", $vacantes, $cveprograma);
	$res		= mysql_query($qryvacantes);
	if(mysql_affected_rows()>0){
			$respuesta = true;
		}else{
			$respuesta = false;
		}

	$arrayJSON =array('respuesta' => $respuesta);
	print json_encode($arrayJSON);
}
function llenaDptosDep(){
	$respuesta=false;
	$conexion 	= conexionLocal();
	$nomdep="'".$_POST["nomdep"]."'";
	mysql_query("set NAMES utf8");
	$cons=sprintf("SELECT dp.nomdepartamento, dp.cvedepartamento 
					FROM departamentos dp
					INNER JOIN dependencias d on d.cvedependencia=dp.cvedependencia
					WHERE d.cveusuario_1=%s" , $nomdep);
	$opciones= array();
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_assoc($res)) {
                  $cve = $row['cvedepartamento'];
                  $nom = $row['nomdepartamento']; 
                  $opciones[]=array($cve,$nom);
				$respuesta=true;
		}
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}
function llenaTipoProg(){
		$respuesta=false;
		$conexion 	= conexionLocal();
		mysql_query("set NAMES utf8");
		$cons=	sprintf("SELECT cvetipo, 
								tipoprograma 
						FROM tipo_programa");
		$opc=array();
		$res=mysql_query($cons);
		   while ($row = mysql_fetch_array($res)) {

	                  $cve = intval($row['cvetipo']);
	                  $nom = $row['tipoprograma']; 
	                  $opc[]	=array($cve,$nom);
	                  $respuesta=true;
			}
		$arrayJSON = array('opciones' => $opc, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);
	}

function solicitarApPrograma(){
	$respuesta=false;
	$msj="No se registró el programa";	
	$prognom	= strtoupper("'".$_POST["txtprognomSS"]."'");
	$selprogdep	= "'".$_POST["selprogdepSS"]."'";
	$progdpto	= "'".$_POST["selprogdptoSS"]."'";
	$progobj	= "'".$_POST["txtprogobjSS"]."'";
	$progvac	= "'".$_POST["txtprogvacSS"]."'";
	$progmod	= "'".$_POST["selprogmodSS"]."'";
	$progtipo	= "'".$_POST["selprogtipoSS"]."'";
	$progcar	= 0;
	$selprogact	= "'".$_POST["selprogactSS"]."'";
	$progact	= "'".$_POST["txtprogactSS"]."'";
	$progresp	= "'".$_POST["txtprogrespSS"]."'";
	$progpues	= "'".$_POST["txtprogpuesSS"]."'";
	$selprogest	= "'".$_POST["selprogestSS"]."'";
	$progactotr = "'".$_POST["txttipoOtros"]."'";
	if($selprogact!="Otros"){
		$progactotr="'-'";
	}
	$vigencia=0;
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	mysql_query("START TRANSACTION");
	$consulta = sprintf("insert into programas values(NULL,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",$prognom,$selprogdep,$progdpto,$progobj,$progvac,$progmod,$progtipo,$selprogact,$progactotr,$progact,$progresp,$progpues,$selprogest,$vigencia);
	$a1 = mysql_query($consulta);
	$id=mysql_insert_id();
	    $conscar=sprintf("INSERT into carrera_programa(cvecarpro,cveprograma,cvecarrera)
					   VALUES (NULL,$id,$progcar)");
	    $a2 = mysql_query($conscar);
//si hay comillas simples en alguno de los valores se altera la consulta
	if ($a1 and $a2) {
		$respuesta=true;
	    mysql_query("COMMIT");
	    $msj="Se ha registrado el programa ".$prognom.'';
	} else {      
	    mysql_query("ROLLBACK");
	}
	$salidaJSON = array ('respuesta' => $respuesta, 'mensaje'=>$msj);
		print json_encode($salidaJSON);
}

function obtenerClaveDep(){
	$respuesta=false;
	$msj="no se ha podido obtener el id de la empresa";
	$usuariodep="'".$_POST["usuariodep"]."'";
	$cn=conexionLocal();
	mysql_query("set names utf8");
	$qryconsulta=sprintf("SELECT cvedependencia FROM dependencias where cveusuario_1=%s", $usuariodep);
	$res=mysql_query($qryconsulta);
	$clavedep="";
	if($row=mysql_fetch_array($res)){
		$clavedep=$row["cvedependencia"];
		$respuesta=true;
		$msj="";
	}
	$arrayJSON = array('clavedep' => $clavedep, 'respuesta' => $respuesta, 'mensaje'=> $msj );
	print json_encode($arrayJSON);
}
function mostrarAlumnosSeg(){
	$usuario 		= "'".$_POST['usuario']."'";
	$pagina 		= $_POST['pagina'];
	$inicio  		= ($pagina-1)*10;;
	$respuesta 		= false;
	$pdoAct 		= getPeriodoAct();
	$conexion 		= conexionLocal();
	$qryExpedientes = sprintf("SELECT ex.cveexpediente, ex.estado, s.cveusuario_1, s.cveprograma_1, s.cvesolicitud, p.nombre
		 	FROM expedientes AS ex
		 	 INNER JOIN solicitudes AS s ON s.cvesolicitud = ex.cvesolicitud
		 	 INNER JOIN programas AS p ON p.cveprograma = s.cveprograma_1
		 	 INNER JOIN dependencias AS dp ON dp.cvedependencia = %s 
		 	 WHERE s.pdocve_1 = %s
		 	 LIMIT 10 OFFSET %s",$usuario,$pdoAct, $inicio);
	$resExpedientes = mysql_query($qryExpedientes);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th>Reporte uno</th>";
	$tabla		.=	"<th>Reporte dos</th>";
	$tabla		.=	"<th>Reporte tres</th>";
	$tabla		.=	"<th>Estado</th>";
	$tabla		.=	"</thead></tr>";
	while($row = mysql_fetch_array($resExpedientes)){
		$respuesta = true;
		$nombrePrograma = $row["nombre"]; 
		$cveusuario  	= $row["cveusuario_1"];
		$cveprograma 	= $row["cveprograma_1"];
		$cvesolicitud 	= $row["cvesolicitud"];
		$cveexpediente 	= $row["cveexpediente"];
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUNOM, DA.ALUAPP, DA.ALUAPM FROM DALUMN AS DA 
			INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR 
			WHERE DA.ALUCTR = %s
			",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row1 		= mysql_fetch_array($res);
		$tabla		.= "<tr>";
		$tabla		.= "<td>".$cveusuario."</td>";
		$tabla		.= "<td>".$row1["ALUNOM"]." ".$row1["ALUAPP"]." ".$row1["ALUAPM"]."</td>";
		$tabla 		.= "<td>".$nombrePrograma."</td>";
		$conexionLocal 	= conexionLocal();
		$qryReportes 	= sprintf("SELECT estado, noreporte,cvereporte FROM reportes WHERE cveexpediente_1 = %s",$cveexpediente);
		$reporteUno 	="<td><a href=''>Crear</a></td>";
		$reporteDos 	="<td><a href=''>Crear</a></td>";
		$reporteTres 	="<td><a href=''>Crear</a></td>";
		if($resReportes = mysql_query($qryReportes)){
			while($rowReportes = mysql_fetch_array($resReportes)){
				$estadoreporte = $rowReportes["estado"];
				$noreporte 	   = $rowReportes["noreporte"];
				$cvereporte 	=$rowReportes["cvereporte"];
				switch ($estadoreporte) {
					case '0':
						$estadoreporte = "Pendiente"; 
						break;
					case '1':
					 	$estadoreporte = "Aceptado";
					 	break;
					 case '2':
					 	$estadoreporte = "Rechazado";
					 	break;
				}
				switch ($noreporte) {
					case 1:
						$reporteUno = "<td><a value=".$cvereporte."onclick='detallesCalifRep()'>".$estadoreporte."</a></td>";
						break;
					case 2:
						$reporteDos = "<td><a value=".$cvereporte."onclick='detallesCalifRep()'>".$estadoreporte."</a></td>";
						break;
					case 3:
						$reporteTres = "<td><a value=".$cvereporte."onclick='detallesCalifRep()'>".$estadoreporte."</a></td>";
						break;
				}

			}
		}
		$tabla .= $reporteUno.$reporteDos.$reporteTres;
		if($row["estado"]==1){
			$tabla		.= "<td>"."CAPTURA"."</td>";
		}else{
			$tabla		.="<td><a>"."FINALIZADO"."</a></td>";
		}
		$tabla		.= "</tr>";
	}
	$conexion 		= conexionLocal();
	$qryExpedientesCount = sprintf("SELECT COUNT(*) AS TOTAL FROM expedientes AS ex
	 INNER JOIN solicitudes AS s ON s.cvesolicitud = ex.cvesolicitud 
	 INNER JOIN programas AS p ON p.cveprograma = s.cveprograma_1 
	 INNER JOIN dependencias AS dp ON dp.cvedependencia = %s 
	 WHERE s.pdocve_1 = %s",$usuario,$pdoAct);
	$resExpedientesCount 	= mysql_query($qryExpedientesCount);
	$rowCount		 		= mysql_fetch_array($resExpedientesCount);
	$total 					= $rowCount["TOTAL"];
	$botonesTotal 			= intval($total/10);
	$restante 				= $total - ($botonesTotal*10);
	$previo 				= $pagina-1;
	$siguiente 				= $pagina+1;
	if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons" value='.$previo.'>chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousNI" value='.$previo.'><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPagI"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPagI"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina== $botonesTotal or $botonesTotal== 0){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextNI" value='.$siguiente.'><a><i class="material-icons">chevron_right</i></a></li>';
		}
	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta, 'botones' =>$botones);
	print json_encode($arrayJSON); 
}
function obtenerDptosDep(){
	$respuesta	=false;	
	$msj 		="no se han podiso obtener los departamentos de la dependencia";
	$cvedep 	="'".$_POST["clavedep"]."'";
	$cn 	=conexionLocal();
	mysql_query("SET NAMES utf8");
	$qrydptos 	=sprintf("SELECT GROUP_CONCAT(nomdepartamento SEPARATOR '\n') AS 'departamentos' 
						FROM departamentos where cvedependencia=%s",$cvedep);
	$res 	=mysql_query($qrydptos);
	if($row=mysql_fetch_array($res)){
		$dptos 	=$row["departamentos"];
		$respuesta 	=true;
		$msj 	="";
	}
	$arrayJSON = array('respuesta'=>$respuesta,'mensaje'=>$msj,'departamentos'=>$dptos);
	print json_encode($arrayJSON);
}
function agregarDepartamentoDep(){
		$respuesta 	= 	false;
		$cn 		=	conexionLocal();
		$dptonom	=	strtoupper("'".$_POST['nombre']."'");
		$depcve		=	$_POST['dependencia'];
		$qryexiste	=	sprintf("SELECT dp.cvedepartamento, d.nomdependencia 
							FROM departamentos dp 
							INNER JOIN dependencias d ON dp.cvedependencia=d.cvedependencia
                            WHERE dp.cvedependencia =%s AND dp.nomdepartamento=%s",$depcve,$dptonom);
		$resaux		=	mysql_query($qryexiste);
		if($row= mysql_fetch_array($resaux)){
			$nombreDep		= $row["nomdependencia"];
			$mensaje		= "Ya existe un departamento con ese nombre en ".$nombreDep;

		}else{
			$qryDpto	= sprintf("INSERT INTO departamentos(cvedepartamento,cvedependencia,nomdepartamento)
										VALUES(NULL,$depcve,$dptonom)");
			$res 		= mysql_query($qryDpto);
				if(mysql_affected_rows()>0){
					$respuesta=true;
					$mensaje="Se ha agregado el departamento ".$dptonom;
				}
		}
		$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje);
		print json_encode($arrayJSON); 
	}

function guardarCalificacionRep(){
	$respuesta 	= 	false;
	$cn 		=	conexionLocal();
	$mensaje 	=   "No se han podido guardar las calificaciones";
	$cvereporte	=	"'".$_POST['reporte']."'";
	$calDc1     =   "'".$_POST['txtCRdep1']."'";
	$calDc2     =   "'".$_POST['txtCRdep2']."'";
	$calDc3     =   "'".$_POST['txtCRdep3']."'";
	$calDc4     =   "'".$_POST['txtCRdep4']."'";
	$calDc5     =   "'".$_POST['txtCRdep5']."'";
	$calDc6     =   "'".$_POST['txtCRdep6']."'";
	$calDc7     =   "'".$_POST['txtCRdep7']."'";
	$calDc8     =   "'".$_POST['txtCRdep8']."'";
	$calDc9     =   "'".$_POST['txtCRdep9']."'";
	$calDc10     =   "'".$_POST['txtCRdep10']."'";

	$qrycalifR	=	sprintf("UPDATE reportes 
							SET calDc1=%s,calDc2=%s,calDc3=%s,calDc4=%s,calDc5=%s,
							    calDc6=%s,calDc7=%s,calDc8=%s,calDc9=%s,calDc10=%s,
							    estadoempresa=1 WHERE cvereporte=%s",$calDc1,$calDc2,$calDc3,$calDc4,$calDc5,$calDc6,$calDc7,$calDc8,$calDc9,$calDc10,$cvereporte);
	$res		=	mysql_query($qrycalifR);
	if($row= mysql_affected_rows()>0){
		$respuesta 		= true;
		$mensaje		= "Se guardaron calificaciones correctamente";

	}
	$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje);
	print json_encode($arrayJSON); 
}

$opc= $_POST["opc"];
switch ($opc){
	case 'mostrarMisDatos':
		mostrarMisDatos();
		break;
	case 'guardarDatos':
		guardarDatos();
		break;
	case 'guardarDatosModif':
		guardarDatosModif();
		break;
	case 'mostrarProgramasVac':
		mostrarProgramasVac();
		break;
	case 'llenaProgramasVac':
		llenaProgramasVac();
		break;	
	case 'mostrarSolicitudesSeg':
		mostrarSolicitudesSeg();
		break;
	case 'aceptarSolicitudes':
		aceptarSolicitudes();
		break;
	case 'rechazarSolicitudes':
		rechazarSolicitudes();
		break;
	case 'consultaFiltroSolicitudesDP':
		consultaFiltroSolicitudesDP();
		break;
	case 'filtrarSolicitudesEstado':
		filtrarSolicitudesEstado();
		break;
	case 'filtrarSolicitudesProgramas':
		filtrarSolicitudesProgramas();
		break;
	case 'vacanteenPrograma':
		vacanteenPrograma();
		break;
	case 'guardarPrograma':
		guardarPrograma();
		break;
	case 'llenaDptosDep':
		llenaDptosDep();
		break;
	case 'llenaTipoProg':
		llenaTipoProg();
		break;
	case 'solicitarApPrograma':
		solicitarApPrograma();
		break;
	case 'obtenerClaveDep':
		obtenerClaveDep();
		break;
	case 'mostrarAlumnosSeg':
		mostrarAlumnosSeg();
		break;
	case 'obtenerDptosDep':
		obtenerDptosDep();
		break;
	case 'agregarDepartamentoDep':
		agregarDepartamentoDep();
		break;
	case 'guardarCalificacionRep';
		guardarCalificacionRep();
		break;
}
?>

