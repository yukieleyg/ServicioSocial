<?php
	require_once('entrar.php');
function mostrarExpedientes(){
		$respuesta	= false;
		$cn0		= conexionLocal();
		$qryvalida0	= sprintf("select cveusuario_1,estado from solicitudes");
		$res0		= mysql_query($qryvalida0);
		$cn 		= conexionBD();
		$tabla		= "";
		$tabla		.= "<tr>";
		$tabla		.= "<th>No. de Control</th>";
		$tabla		.=	"<th>Nombre</th>";
		#$tabla		.=	"<th>Carrera</th>";
		$tabla		.=	"<th>Estatus</th>";
		$tabla		.=	"</tr>";

		while($row0= mysql_fetch_array($res0)){
			$cveusuario = $row0["cveusuario_1"];
			$qryvalida	= sprintf("select * from DALUMN where ALUCTR = %s",$cveusuario);
			$res		= mysql_query($qryvalida);
			$row 		= mysql_fetch_array($res);
			$tabla		.= "<tr>";
			$tabla		.= "<td>".$row["ALUCTR"]."</td>";
			$tabla		.= "<td>".$row["ALUNOM"]."</td>";
			$tabla		.= "<td>".$row0["estado"]."</td>";
			#$tabla		.= "<td>".$row["ALUNOM"]."</td>";
			$tabla		.= "</tr>";
			$respuesta = true;
		}
		
	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}

$opc= $_POST["opc"];
switch ($opc){
	case 'mostrarExpedientes':
		mostrarExpedientes();
		break;
	
	default:
		# code...
		break;
}
?>