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
$opc= $_POST["opc"];
switch ($opc){
	case 'mostrarMisDatos':
		mostrarMisDatos();
		break;
	case 'guardarDatos':
		guardarDatos();
	case 'guardarDatosModif':
		guardarDatosModif();
}