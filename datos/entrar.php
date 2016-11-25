<?php
require_once('conexion.php');
function validaentrada()
{
	$respuesta	= false;
	$creditos 	= false;
	$porcentaje	= 0.0;
	$nombre		= "";
	$usuario	= "'".$_POST["usuario"]."'";
	$clave		= "'".$_POST["clave"]."'";
	/*$cn 		= conexionBD();
	$qryvalida	= sprintf("select * from DALUMN where ALUCTR=%s and ALUPAS=%s limit 1",$usuario,$clave);
	$res		= mysql_query($qryvalida);
	$tipo 		= 0;
	//print $qryvalida;
	/*if($row= mysql_fetch_array($res)){
		$nombre		= $row["ALUNOM"];
		$respuesta	= true;
		$tipo		= 3;

			$qryvalida 	= sprintf("select alm.aluctr, TRUNCATE((inf.calcac/p.placre),2) AS PORC from DALUMN alm INNER JOIN DCALUM inf on alm.ALUCTR=inf.ALUCTR inner join DPLANE p on inf.PLACVE=p.PLACVE and inf.CARCVE=p.CARCVE where alm.ALUCTR=%s",$usuario);
			$res = mysql_query($qryvalida);

				if($row= mysql_fetch_array($res)){
					$porcentaje = $row["PORC"];
					if($porcentaje>0.70){
						$creditos=true;
					}
				}


	}else{*/
		$clave		= "'".md5($_POST["clave"])."'";
		$cn 		= conexionLocal();
		$qryvalida 	= sprintf("select * from usuarios where cveusuario=%s and clave=%s limit 1", $usuario,$clave);
		$res 		= mysql_query($qryvalida);
		if($row = mysql_fetch_array($res)){
			$respuesta 	= true;
			$tipo		= $row["tipousuario"];
			if($tipo == 2){
				$qrynombred = sprintf("select * from dependencias where cveusuario_1=%s limit 1", $usuario);
				$res2 		= mysql_query($qrynombred);
				$row2		= mysql_fetch_array($res2);
				$nombre		= $row2["nomdependencia"]; 
			}else{
				$nombre 	= $row["cveusuario"];
			}
		}

	//}
	$arrayJSON = array('respuesta' => $respuesta, 'creditos'=> $creditos,'nombre' => $nombre, 'tipo' => $tipo);
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