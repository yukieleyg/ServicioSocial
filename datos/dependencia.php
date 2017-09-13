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
	$respuesta=false;
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
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$qry 		= sprintf("SELECT cvedependencia FROM dependencias WHERE cveusuario_1 = %s",$usuario);
	$res 		= mysql_query($qry);
	$row		= mysql_fetch_array($res);
	$cvedependencia = $row['cvedependencia'];
	$pdoAct 		= getPeriodoAct();
	$conexion 	= conexionLocal();
	$qryProgramas = sprintf("SELECT s.estado, s.cveusuario_1 , s.cvesolicitud, s.cveprograma_1 FROM solicitudes AS s INNER JOIN programas AS p  on p.cveprograma = s.cveprograma_1 WHERE cvedependencia = %s AND pdocve_1 = %s", $cvedependencia, $pdoAct);
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
		$cn1		= conexionLocal();
		$qryvalida1	= sprintf("SELECT * FROM programas WHERE cveprograma = %s ",$cveprograma);
		$res1		= mysql_query($qryvalida1);
		$row1		= mysql_fetch_array($res1);
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUCTR, DA.ALUNOM, DA.ALUAPP, DA.ALUAPM, DC.CARCVE, DC.CALNPE FROM DALUMN AS DA INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR WHERE DA.ALUCTR = %s",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$cvecarrera = $row["CARCVE"];	
		$semestre	= $row["CALNPE"];
		$qryCarrera = sprintf("SELECT CARNOM FROM DCARRE WHERE CARCVE = %s",$cvecarrera);
		$resCarrera = mysql_query($qryCarrera);
		$rowCarrera = mysql_fetch_array($resCarrera);
		$nomCarrera = $rowCarrera["CARNOM"];
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
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
			
		}else{
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";

		}

		$tabla		.= "</tr>";
	}
	$arrayJSON = array('cvedependencia' => $cvedependencia, 'respuesta' => $respuesta, 'tabla' => $tabla);
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
	$estado 	= $_POST["estado"];
	$respuesta	= false;
	$usuario	= "'".$_POST["usuario"]."'";
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$qry 		= sprintf("SELECT cvedependencia FROM dependencias WHERE cveusuario_1 = %s",$usuario);
	$res 		= mysql_query($qry);
	$row		= mysql_fetch_array($res);
	$cvedependencia = $row['cvedependencia'];
	$pdoAct 		= getPeriodoAct();
	$conexion 	= conexionLocal();
	$qryProgramas = sprintf("SELECT s.estado, s.cveusuario_1 , s.cvesolicitud, s.cveprograma_1 FROM solicitudes AS s INNER JOIN programas AS p  on p.cveprograma = s.cveprograma_1 WHERE cvedependencia = %s AND pdocve_1 = %s AND s.estado = %s", $cvedependencia, $pdoAct, $estado);
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
		$cn1		= conexionLocal();
		$qryvalida1	= sprintf("SELECT * FROM programas WHERE cveprograma = %s ",$cveprograma);
		$res1		= mysql_query($qryvalida1);
		$row1		= mysql_fetch_array($res1);
		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT DA.ALUCTR, DA.ALUNOM, DA.ALUAPP, DA.ALUAPM, DC.CARCVE, DC.CALNPE FROM DALUMN AS DA INNER JOIN DCALUM AS DC ON DA.ALUCTR = DC.ALUCTR WHERE DA.ALUCTR = %s",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$cvecarrera = $row["CARCVE"];	
		$semestre	= $row["CALNPE"];
		$qryCarrera = sprintf("SELECT CARNOM FROM DCARRE WHERE CARCVE = %s",$cvecarrera);
		$resCarrera = mysql_query($qryCarrera);
		$rowCarrera = mysql_fetch_array($resCarrera);
		$nomCarrera = $rowCarrera["CARNOM"];
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
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
			
		}else{
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";

		}

		$tabla		.= "</tr>";
	}
	$arrayJSON = array('cvedependencia' => $cvedependencia, 'respuesta' => $respuesta, 'tabla' => $tabla);
	print json_encode($arrayJSON);

}
function filtrarSolicitudesProgramas(){

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
}?>
