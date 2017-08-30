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
							WHERE d.cveusuario_1=%s AND p.vigencia=1
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
					WHERE d.cveusuario_1=%s AND p.vigencia=1
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
}