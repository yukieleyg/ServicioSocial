<?php
function conexionBD(){
	$cn= mysql_connect("localhost","root","");
	mysql_select_db("serviciosocial");
	return $cn;
}
function validaentrada()
{
	$respuesta=false;
	$nombre		="";
	$usuario	= "'".$_POST["usuario"]."'";
	$clave		= "'".md5($_POST["clave"])."'";
	$cn 		= conexionBD();
	$qryvalida	= sprintf("select * from usuarios where usuario=%s and clave=%s limit 1",$usuario,$clave);
	$res		= mysql_query($qryvalida);

	if($row= mysql_fetch_array($res)){
		$nombre		= $row["nombre"];
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