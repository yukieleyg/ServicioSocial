<?php
require_once('entrar.php');
function muestraSolicitudes(){
	$respuesta	= false;
	$cn0		= conexionLocal();
	$qryvalida0	= sprintf("select cveusuario_1,estado,cveprograma_1 from solicitudes");
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
			$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveusuario."' disabled><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveusuario."' disabled><i class= 'material-icons'>close</i></a></td>";
			$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cveusuario."'><i class = 'material-icons'>file_download</i></button></td>";
			$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveusuario."' ><i class = 'material-icons'>list</i></button></td>";
			
		}else{
			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveusuario."' ><i class= 'material-icons'>done_all</i></button></td>";
			$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveusuario."' ><i class= 'material-icons'>close</i></a></td>";
			$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cveusuario."' ><i class = 'material-icons'>file_download</i></button></td>";
			$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveusuario."' ><i class = 'material-icons'>list</i></button></td>";

		}

		$tabla		.= "</tr>";
		$respuesta = true;
	}

	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}
function aceptarSolicitudes (){
	$respuesta	= false;
	$usuario	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cveusuario_1 =%s",$usuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
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
	$usuario	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cveusuario_1 =%s",$usuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
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
/*function detallesAlumno(){

}*/
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
			//print("usuario insertado");
			//agregar la empresa a la BD
			$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
			$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
				//print("respuesta true");
			}

		}
	}else if(!existeusuarioDep($depusuario)){
		$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
		$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
				//print("respuesta true");
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
		$qry= sprintf("select nombre,cvedependencia,vacantes,carrerapref from programas");
		$res= mysql_query($qry);

		$tabla="<thead><tr><th>Nombre</th><th>Dependencia</th><th>Vacantes</th><th>Carrera</th></tr></thead><tbody>";

		while($renglon=mysql_fetch_array($res)){
			$nombre 	= $renglon["nombre"];
			$dependencia= $renglon["cvedependencia"];
			$vacantes 	= $renglon["vacantes"];
			$carrera 	= $renglon["carrerapref"];

			$tabla.="<tr><td>".$nombre."</td><td>".$dependencia."</td><td>".$vacantes."</td><td>".$carrera."</td></tr>";	
		}
		$tabla.="</tbody>";
		$respuesta=true;
		$arrayJSON = array('renglones' => $tabla, 'respuesta' => $respuesta );
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
	/*case 'descargarSolicitud':
		#break;
	case 'detallesAlumno':
		detallesAlumno();
		break;*/
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
		case 'tablaprogramas':
		tablaprogramas();
			# code...
			break;
		default:
		# code...
		break;
	}
	?>