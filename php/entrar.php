<?php
function conexionBD(){
	$cn= mysql_connect("itculiacan.edu.mx","sieapibduser","B5fa4x_7*.*");
	mysql_select_db("sieapibd");
	return $cn;
}
function validaentrada()
{
	$respuesta=false;
	$nombre		="";
	$usuario	= "'".$_POST["usuario"]."'";
	$clave		= "'".$_POST["clave"]."'";
	$cn 		= conexionBD();
	$qryvalida	= sprintf("select * from DALUMN where ALUCTR=%s and ALUPAS=%s limit 1",$usuario,$clave);
	$res		= mysql_query($qryvalida);

	if($row= mysql_fetch_array($res)){
		$nombre		= $row["ALUNOM"];
		$respuesta	=	true;
		
	}
	$arrayJSON = array('respuesta' 	=> $respuesta,
						'nombre'	=> $nombre);
	print json_encode($arrayJSON);
}

$opc= $_POST["opc"];
switch ($opc) {
	case 'validaentrada':
		validaentrada();
		break;
	
	default:
		# code...
		break;
}


?>