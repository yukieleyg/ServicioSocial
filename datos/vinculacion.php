<?php
require_once('entrar.php');
function muestraSolicitudes(){
	$respuesta	= false;
	$cn0		= conexionLocal();
	$qryvalida0	= sprintf("select * from solicitudes");
	$res0		= mysql_query($qryvalida0);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla		.=	"<th>Estatus</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th></th>";
	$tabla		.=	"</thead></tr>";

	while($row0 = mysql_fetch_array($res0)){
		$cveusuario  = $row0["cveusuario_1"];
		$cveprograma = $row0["cveprograma_1"];
		$cvesolicitud = $row0["cvesolicitud"];
		$cn1		= conexionLocal();
		$qryvalida1	= sprintf("select * from programas where cveprograma = %s",$cveprograma);
		$res1		= mysql_query($qryvalida1);
		$row1		= mysql_fetch_array($res1);



		$cn 		= conexionBD();
		$qryvalida	= sprintf("select * from DALUMN where ALUCTR = %s",$cveusuario);
		$res		= mysql_query($qryvalida);
		$row 		= mysql_fetch_array($res);
		$tabla		.= "<tr>";
		$tabla		.= "<td>".$row["ALUCTR"]."</td>";
		$tabla		.= "<td>".$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"]."</td>";
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
			$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cvesolicitud."'><a href='../datos/descargarArchivos.php?solicitud=".$cvesolicitud."' target=_blank><i class = 'material-icons'>file_download</i></a></button></td>";
			$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cvesolicitud."' ><i class = 'material-icons'>list</i></button></td>";
			
		}else{
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";
			$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cvesolicitud."' ><a href='../datos/descargarArchivos.php?solicitud=".$cvesolicitud."' target=_blank><i class = 'material-icons'>file_download</i></a></button></td>";
			$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cvesolicitud."' ><i class = 'material-icons'>list</i></button></td>";

		}

		$tabla		.= "</tr>";
		$respuesta = true;
	}

	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}
function aceptarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$cnU 		= conexionLocal();
	$aceptado 	= 1;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cveusuario_1 = %s",$aceptado,$usuario);	
	$resU 		= mysql_query($qryvalidaU);
	if($resU){
		$respuesta = true;
	}

	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}
function rechazarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$cnU 		= conexionLocal();
	$rechazado 	= 2;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cveusuario_1 = %s",$rechazado,$usuario);	
	$resU 		= mysql_query($qryvalidaU);
	if($resU){
		$respuesta = true;
	}

	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}

function obtenerTarjetaAlm(){
	$respuesta=false;
	$alumno="";
	$nocontrol	= "'".$_POST["ncontrol"]."'";
	$mensaje	="No se encuentra expediente";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("select * from expedientes where cveusuario_1=%s limit 1", $nocontrol);
	$res		= mysql_query($qryvalida);
	if($row= mysql_fetch_array($res)){
		$respuesta	=true;
		$nocontrol 	= $row["cveusuario_1"];
		$mensaje	="";
		$alumno=getAlumno($nocontrol);
	}
	$arrayJSON = array('respuesta' => $respuesta, 'alumno' => json_decode($alumno));
	print json_encode($arrayJSON);

}
function getAlumno($nocontrol){
	$cn=conexionBD();
	$qry=sprintf("select a.ALUAPP, a.ALUAPM, a.ALUNOM, a.ALUSEX, a.ALUCLL, a.ALUNUM, a.ALUCOL, a.ALUTE1, FLOOR(DATEDIFF(CURDATE(),ALUNAC)/365) as EDAD from DALUMN a where a.ALUCTR=%s",$nocontrol);
	$res		= mysql_query($qry);
	$nombre="";
	$edad="-";
	$sexo="";
	$domic="";
	$telef="";
	$creditos="";
	if($row= mysql_fetch_array($res)){
		$nombre=$row["ALUAPP"]." ".$row["ALUAPM"]." ".$row["ALUNOM"];
		$edad=$row["EDAD"];
		$sexo=($row["ALUSEX"]==1) ?'M':'F';
		$domic=$row["ALUCLL"]." ".$row["ALUNUM"]." ".$row["ALUCOL"];
		$telef=$row["ALUTE1"];
		$creditos=getCreditos($nocontrol);
	}
	
	$alumno=array('nocontrol'=>$nocontrol,'nombre'=>$nombre,'edad'=>$edad,'sexo'=>$sexo,'domicilio'=>$domic, 'telefono'=>$telef,'creditos'=>$creditos);
	return json_encode($alumno);
}
function getCreditos($nocontrol){
	$cn=conexionBD();
	$respuesta=false;
	$qryvalida 	= sprintf("select CALCAC from DCALUM where ALUCTR=%s",$nocontrol);
	$res= mysql_query($qryvalida);
	if($row=mysql_fetch_array($res)){
		$respuesta=$row["CALCAC"];
		return $respuesta;
	}
	return $respuesta;
}


function detallesAlumno(){
 	$respuesta	= false;
	$solicitud	="'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$estado     = $row["estado"];
	$usuario	= $row["cveusuario_1"];
	$cveprograma = $row["cveprograma_1"];
	$motivo 	 	= $row["motivo"];
	$observaciones 	= $row["observaciones"];
	$qryvalida	= sprintf("select * from programas where cveprograma = %s",$cveprograma);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$programa	= $row["nombre"];
	$cvedependencia = $row["cvedependencia"];
	$qryvalida = sprintf("select * from dependencias where cvedependencia = %s", $cvedependencia);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$dependencia = $row["nomdependencia"];

	$cn2		= conexionBD();
	$qryvalida1 = sprintf("SELECT * from DALUMN where ALUCTR =%s",$usuario);
	$res1		= mysql_query($qryvalida1);
	$row1 		= mysql_fetch_array($res1);
	$nombre		=	$row1["ALUNOM"].' '.$row1["ALUAPP"].' '.$row1["ALUAPM"];;
	$tel		=	$row1["ALUTE1"];
	$calle		=	$row1["ALUCLL"];
	$num		=	$row1["ALUNUM"];
	$colonia	=	$row1["ALUCOL"];
	$numcontrol	=	$row1["ALUCTR"];
	$sexo		=	$row1["ALUSEX"];
	$email		=	$row1["ALUMAI"];
	$tel		=	$row1["ALUTE1"];
	$direccion	=   $calle.' '.$num.' '.$colonia;
	$qryvalida1 = sprintf("SELECT * from DCALUM where ALUCTR =%s",$usuario);
	$res1		= mysql_query($qryvalida1);
	$row1 		= mysql_fetch_array($res1);
	$carcve		= $row1["CARCVE"];
	$semestre	= $row1["CALNPE"];
	$qryvalida1 = sprintf("SELECT * from DCARRE where CARCVE =%s",$carcve);
	$res1		= mysql_query($qryvalida1);
	$row1 		= mysql_fetch_array($res1);
	$nomcarrera = $row1["CARNOM"];
	$qryvalida	= sprintf("select PARFOL1 from DPARAM where PARCVE= 'PRDO'");
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$periodoAct	= $row["PARFOL1"];
	$meses		= substr($periodoAct, 3,1);
	if($meses==1){
		$meses = " ENERO - JUNIO";
	} else {
		if($meses==3){
		$meses = "AGOSTO-DICIEMBRE";
		}
	}
	$respuesta	= true;
	$arrayJSON = array('respuesta' => $respuesta, 'nombre' => $nombre, 'direccion' => $direccion, 'email' => $email, 'numcontrol' => $numcontrol, 'tel' => $tel, 
	'carrera' => $nomcarrera, 'semestre' => $semestre, 'periodoAct' => $meses, 'estado' => $estado, 'tel' => $tel, 'dependencia' => $dependencia, 'programa' => $programa, 'solicitud' => $solicitud, 'motivo' => $motivo, 'observaciones' => $observaciones);
	print json_encode($arrayJSON);
}

function existeusuario($usuario){
	$conexion 		= conexionLocal();
	$consultaruser	= sprintf("select * from usuarios where cveusuario=%s and tipousuario=2 limit 1",$usuario);
	$res 			= mysql_query($consultaruser);
	if($row = mysql_fetch_array($res))
	{	
		return true; 
	}
	else
	{
		return false; //agregar el nuevo usuario
	}
}
function existeusuarioDep($usuario){
	$conexion 		= conexionLocal();
	$consultaruser	= sprintf("select cveusuario_1 from dependencias where cveusuario_1=%s limit 1",$usuario);
	$res 			= mysql_query($consultaruser);
	if($row = mysql_fetch_array($res))
	{	
		return true; //ya esta asociado
	}
	else
	{
		return false;
	}
}

function registrarEmpresa(){
	$respuesta 	=false;
	$msj="Se ha registrado la dependencia";

	$depnom 	= "'".$_POST["txtdepnom"]."'";
	$depusuario = "'".$_POST["txtdepusuario"]."'";
	$deprfc 	= "'".$_POST["txtdeprfc"]."'";
	$deptitular = "'".$_POST["txtdeptitular"]."'";
	$depdir = "'".$_POST["txtdepdir"]."'";
	$deptel 	= "'".$_POST["txtdeptel"]."'";
	$depest 	= "'".$_POST["txtdepest"]."'";
	$seldepest	="'".$_POST["txtdepest"]."'";
	
	$conexion 	= conexionLocal();
	//$consultaruser	=sprintf("select * from usuarios where cveusuario=%s limit 1",$usuario,$clave);
	if(!existeusuario($depusuario)){
		//print("puede insertar");
		//agregar usuario a la base de datos
		$consUsuario=sprintf("insert into usuarios values(%s,'password',2)",$depusuario);
		mysql_query($consUsuario);

		if(mysql_affected_rows()>0){
			$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
			$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
			}

		}
	}else if(!existeusuarioDep($depusuario)){
		$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
		$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
			}

	}else{
		//ya existe el usuario
			$msj="Elige un nombre de usuario diferente.";
		}


		$salidaJSON = array ('respuesta' => $respuesta, 'mensaje'=>$msj);
		print json_encode($salidaJSON);
	}
	
function registrarPrograma(){
	$respuesta=false;
	$msj="";

	
	$prognom	= "'".$_POST["txtprognom"]."'";
	$selprogdep	= "'".$_POST["selprogdep"]."'";
	$progdpto	= "'".$_POST["selprogdpto"]."'";
	$progobj	= "'".$_POST["txtprogobj"]."'";
	$progvac	= "'".$_POST["txtprogvac"]."'";
	$progmod	= "'".$_POST["selprogmod"]."'";
	$progtipo	= "'".$_POST["selprogtipo"]."'";
	$progcar	= "'".$_POST["txtprogcar"]."'";
	$selprogact	= "'".$_POST["selprogact"]."'";
	$progact	= "'".$_POST["txtprogact"]."'";
	$progresp	= "'".$_POST["txtprogresp"]."'";
	$progpues	= "'".$_POST["txtprogpues"]."'";
	$selprogest	= "'".$_POST["selprogest"]."'";

	$conexion 	= conexionLocal();
	$consulta = sprintf("insert into programas values(NULL,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",$prognom,$selprogdep,$progdpto,$progobj,$progvac,$progmod,$progtipo,$progcar,$selprogact,$progact,$progresp,$progpues,$selprogest);
	$resconsulta= mysql_query($consulta);

	if(mysql_affected_rows()>0){
		$respuesta=true;
		//print("respuesta true");
	}
	$salidaJSON = array ('respuesta' => $respuesta, 'mensaje'=>$msj);
		print json_encode($salidaJSON);
}

function llenaDepProgramas(){
	$respuesta=false;
	$conexion 	= conexionLocal();
	$cons=sprintf("select cvedependencia, nomdependencia from dependencias");
	$opciones="";
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_array($res)) {

                  $cve = $row['cvedependencia'];
                  $nom = $row['nomdependencia']; 
                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
       

		}
		$respuesta=true;
	
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);

}

function llenaDptoProgramas(){
	$respuesta=false;
	$conexion 	= conexionLocal();
	$cvedep="'".$_POST["selprogdep"]."'";
	
	$cons=sprintf("select nomdepartamento, cvedepartamento from departamentos where cvedependencia=%s", $cvedep);
	$opciones="";
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_array($res)) {

                  $cve = $row['cvedepartamento'];
                  $nom = $row['nomdepartamento']; 
                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';   

		}

		$respuesta=true;
	
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}

	function llenaActProg(){
		$respuesta=false;
		$conexion 	= conexionLocal();
		$cons=sprintf("select cvedependencia, nomdependencia from dependencias");
		$opciones="";
		$res=mysql_query($cons);
		   while ($row = mysql_fetch_array($res)) {

	                  $cve = $row['cvedependencia'];
	                  $nom = $row['nomdependencia']; 
	                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
	       

			}
			$respuesta=true;
		
		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);

	}
	function tablaprogramas(){
		$respuesta	= false;
		$cn=conexionLocal();
		$qry= sprintf("select * from programas");
		$res= mysql_query($qry);

		$tabla="<thead><tr><th>Nombre</th><th>Dependencia</th><th>Vacantes</th><th>Carrera</th><th>Estado</th><th>Vigencia</th><th></th></tr></thead><tbody>";
		while($renglon=mysql_fetch_array($res)){
			$nombre 	= $renglon["nombre"];
			$dependencia= $renglon["cvedependencia"];
			$vacantes 	= $renglon["vacantes"];
			$carrera 	= $renglon["carrerapref"];
			$cveprograma 	= $renglon["cveprograma"];
			$estado 		= $renglon["estado"];
			$vigencia 		= $renglon["vigencia"]; 
			$tabla 		.="<tr><td>".$nombre."</td><td>".$dependencia."</td><td>".$vacantes."</td><td>".$carrera."</td><td>".$estado."</td><td>".$vigencia."</td>";
			$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveprograma."' ><i class = 'material-icons'>list</i></button></td><tr>";


		}
		$tabla.="</tbody>";
		$respuesta=true;
		$arrayJSON = array('renglones' => $tabla, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);
	}
	
	function detallesSolicitud(){
		$solicitud		= $_POST["solicitud"]; 
		$motivo			= "'".$_POST["motivo"]."'"; 
		$observaciones	= "'".$_POST["observaciones"]."'";
		$estado 		= "'".$_POST["estado"]."'";
		$conexion 		= conexionLocal();
		$qryvalida 		= sprintf("select * from solicitudes where cvesolicitud=%s", $solicitud);
		$res 			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$motivoAnt		= $row["motivo"];
		$estadoAnt		= $row["estado"];
		$respuesta 	    = false;
		$observacionesAnt = $row["observaciones"];
		if(($motivo <> "'".$motivoAnt."'") or ($observaciones <> "'".$observacionesAnt."'") or ($estado <> "'".$estadoAnt."'")){
			$respuesta = true;
		}
		$arrayJSON = array('respuesta' => $respuesta);
		print json_encode($arrayJSON);
	}
	function modificarSolicitud(){
		$respuesta		= false;
		$solicitud		= $_POST["solicitud"]; 
		$motivo			= "'".$_POST["motivo"]."'"; 
		$observaciones	= "'".$_POST["observaciones"]."'";
		$estado 		= "'".$_POST["estado"]."'";
		$conexion 		= conexionLocal();
		$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s, motivo = %s, observaciones =%s WHERE cvesolicitud = %s",$estado,$motivo, $observaciones, $solicitud);	
		$resU 		= mysql_query($qryvalidaU);
		if(mysql_affected_rows()>0){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
		$arrayJSON = array('respuestaM' => $respuesta);
		print json_encode($arrayJSON);

	}
	$opc= $_POST["opc"];
	switch ($opc){
		case 'muestraSolicitudes':
		muestraSolicitudes();
		break;
		case 'aceptarSolicitudes':
		aceptarSolicitudes();
		break;
		case 'rechazarSolicitudes':
		rechazarSolicitudes();
		break;
		case 'detallesAlumno':
		detallesAlumno();
		break;
		case 'obtenerTarjetaAlm':
		obtenerTarjetaAlm();
		break;
		case 'registrarEmpresa':
		registrarEmpresa();
		# code...
		break;
		case 'registrarPrograma':
		registrarPrograma();
			# code...
			break;
		case 'llenaDepProgramas':
		llenaDepProgramas();
			# code...
			break;
		case 'llenaDptoProgramas':
		llenaDptoProgramas();
			# code...
			break;
		case 'llenaActProg':
		llenaActProg();
			# code...
			break;
		case 'detallesSolicitud':
		detallesSolicitud();
			break;
		case 'tablaprogramas':
		tablaprogramas();
			break;
		case 'modificarSolicitud':
		modificarSolicitud();
		default:
		# code...
		break;
	}
	?>