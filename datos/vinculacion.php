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
/*function obtenerTarjetaAlm(){
	$respuesta=false;
	$usuario	= "'".$_POST["ncontrol"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("select * from usuarios where cveusuario=%s limit 1", $usuario);
	$res		= mysql_query($qryvalida);
	if($row= mysql_fetch_array($res)){
		$respuesta=true;
		$nombre 	= $row["cveusuario"];

	}
	$arrayJSON = array('respuesta' => $respuesta, 'nombre' => $nombre);
	print json_encode($arrayJSON);

}*/
function existeusuario($usuario){
	$conexion 		= conexionLocal();
	$consultaruser	= sprintf("select * from usuarios where cveusuario=%s limit 1",$usuario);
	$res 			= mysql_query($consultaruser);
	if($row = mysql_fetch_array($res))
	{	
		return true;
	}
	else
	{
		return false;
	}
}

function registrarEmpresa(){
	$respuesta 	=false;
	$msj="";

	$depnom 	= "'".$_POST["txtdepnom"]."'";
	$depusuario = "'".$_POST["txtdepusuario"]."'";
	$deprfc 	= "'".$_POST["txtdeprfc"]."'";
	$deptitular = "'".$_POST["txtdeptitular"]."'";
	$depdir = "'".$_POST["txtdeptitular"]."'";
	$deptel 	= "'".$_POST["txtdeptel"]."'";
	$depest 	= "'".$_POST["txtdepest"]."'";
	
	$conexion 	= conexionLocal();
	//$consultaruser	=sprintf("select * from usuarios where cveusuario=%s limit 1",$usuario,$clave);
	if(!existeusuario($depusuario)){
		print("puede insertar");
		//agregar usuario a la base de datos
		$consUsuario=sprintf("insert into usuarios values(%s,'password',2)",$depusuario);
		mysql_query($consUsuario);

		if(mysql_affected_rows()>0){
			print("usuario insertado");
		}

		//agregar la empresa a la BD
		$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$depest);
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
	default:
		# code...
		break;
}
?>