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
		$tabla		.=	"</thead></tr>";

		while($row0 = mysql_fetch_array($res0)){
			$cveusuario  = $row0["cveusuario_1"];
			$cveprograma = $row0["cveprograma_1"];
			$cn1		= conexionLocal();
			$qryvalida1	= sprintf("select * from programas");
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
			

			$tabla		.= "<td>".$row1["nombre"]."</td>";
			$tabla		.= "</tr>";
			$respuesta = true;
		}
		
	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}

$opc= $_POST["opc"];
switch ($opc){
	case 'muestraSolicitudes':
		muestraSolicitudes();
		break;
	
	default:
		# code...
		break;
}
?>