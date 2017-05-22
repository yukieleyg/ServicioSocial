<?php
require_once('entrar.php');
//require_once('cargarcursomoodle.php');
//require_once('documentos.php');
function muestraSolicitudes(){
	$pagina 	= $_POST['pagina'];
	$inicio 	= ($pagina - 1)*10;
	$respuesta	= false;
	$cn0		= conexionLocal();
	$qryvalidaC = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes");
	$resTotal 	= mysql_query($qryvalidaC);
	$rowTotal 	= mysql_fetch_array($resTotal);
	$total 		= $rowTotal['TOTAL'];
	$qryvalida0	= sprintf("SELECT * FROM solicitudes LIMIT 10 OFFSET %s",$inicio);
	$res0		= mysql_query($qryvalida0);
	$tabla		= "";
	$tabla		.= "<thead><tr>";
	$tabla		.= "<th>No. de Control</th>";
	$tabla		.=	"<th>Nombre</th>";
	$tabla		.=	"<th>Estado</th>";
	$tabla		.=	"<th>Programa</th>";
	$tabla		.=	"<th></th>";
	$tabla		.=	"</thead></tr>";
	while($row0 = mysql_fetch_array($res0)){
		$respuesta = true;
		$cveusuario  = $row0["cveusuario_1"];
		$cveprograma = $row0["cveprograma_1"];
		$cvesolicitud = $row0["cvesolicitud"];
		$cn1		= conexionLocal();
		$qryvalida1	= sprintf("SELECT * FROM programas WHERE cveprograma = %s ",$cveprograma);
		$res1		= mysql_query($qryvalida1);
		$row1		= mysql_fetch_array($res1);


		$cn 		= conexionBD();
		$qryvalida	= sprintf("SELECT ALUCTR, ALUNOM, ALUAPP, ALUAPM FROM DALUMN WHERE ALUCTR = %s",$cveusuario);
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
	}
	$totalBotones = intval($total/10);
	$restante = $total - $totalBotones;
	if($restante>0){
		$totalBotones=$totalBotones+1;
	}
	$botones = '<ul class="pagination">';
	if($pagina==1){
	    $botones .= '<li class="disabled" id="btnPreviousSol"><a><i class="material-icons">chevron_left</i></a></li>';
	}else{
	    $botones .= '<li class="waves-effect" id="btnPreviousSol"><a><i class="material-icons">chevron_left</i></a></li>';
	}
	for($i=0;$i<$totalBotones;$i++){
		$numero = $i+1;
		if($numero==$pagina){
   			$botones.= '<li class="teal lighten-2 active" value = '.$numero.'id="btnPagSol"><a>'.$numero.'</a></li>';
		}else{
   			$botones.= '<li class="waves-effect" value = '.$numero.' id="btnPagSol"><a>'.$numero.'</a></li>';
		}
	}
    
    if($pagina==$totalBotones){
	    $botones.= '<li class="disabled" id="btnNextSol"><a><i class="material-icons">chevron_right</i></a></li>';
    }else{
	    $botones.= '<li class="waves-effect" id="btnNextSol"><a><i class="material-icons">chevron_right</i></a></li>';
    }
  	$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPagSol">';
	if($totalBotones==1){
		$botones = '';

	}
	$arrayJSON = array('tabla' => $tabla, 'respuesta' => $respuesta , 'botones'=> $botones, 'pagina' => $pagina);
	print json_encode($arrayJSON);
}
function aceptarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM solicitudes WHERE cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$programa 	= $row["cveprograma_1"];
	$aceptado 	= 1;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cvesolicitud = %s",$aceptado,$solicitud);	
	$resU 		= mysql_query($qryvalidaU);
	if($resU){
		$respuesta = true;
		$consulta = sprintf("INSERT INTO  expedientes VALUES (NULL,%s,%s,%s,CURRENT_TIMESTAMP,' ',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0)",$solicitud,$usuario,$programa);
		$resconsulta= mysql_query($consulta);	
	}
	$arrayJSON = array('respuesta' => $respuesta);
	print json_encode($arrayJSON);

}
function rechazarSolicitudes (){
	$respuesta	= false;
	$solicitud	= "'".$_POST["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * FROM  solicitudes WHERE cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$usuario	= $row["cveusuario_1"];
	$cnU 		= conexionLocal();
	$rechazado 	= 2;
	$qryvalidaU	= sprintf("UPDATE solicitudes SET estado = %s WHERE cvesolicitud = %s",$rechazado,$solicitud);	
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
	$mesesPDO="";
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
		$mesesPDO	=getPeriodoAct();
	}
	$arrayJSON = array('respuesta' => $respuesta, 'alumno' => json_decode($alumno), 'periodo'=> $mesesPDO);
	print json_encode($arrayJSON);

}
function getPeriodoAct(){
	$respuesta=false;
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
	return $meses;
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


function verDetallesSolicitud(){
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
	mysql_query("set NAMES utf8");
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
	mysql_query("set NAMES utf8");
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
	$msj="";

	$depnom 	= strtoupper("'".$_POST["txtdepnom"]."'");
	$depusuario = "'".$_POST["txtdepusuario"]."'";
	$deprfc 	= "'".$_POST["txtdeprfc"]."'";
	$deptitular = "'".$_POST["txtdeptitular"]."'";
	$depdir = "'".$_POST["txtdepdir"]."'";
	$deptel 	= "'".$_POST["txtdeptel"]."'";
	//$depest 	= "'".$_POST["depest"]."'";
	$seldepest	="'".$_POST["seldepest"]."'";
	
	$conexion 	= conexionLocal();
	//$consultaruser	=sprintf("select * from usuarios where cveusuario=%s limit 1",$usuario,$clave);
	if(!existeusuario($depusuario)){
		//print("puede insertar");
		//agregar usuario a la base de datos
		mysql_query("set NAMES utf8");
		$consUsuario=sprintf("insert into usuarios values(%s,'password',2)",$depusuario);
		$resc= mysql_query($consUsuario);
		if(mysql_affected_rows()>0){
			$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
			$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
				$msj="Se ha registrado la dependencia";
			}

		}
	}else if(!existeusuarioDep($depusuario)){
		$consulta = sprintf("insert into dependencias values(NULL,%s,%s,%s,%s,%s,%s,%s)",$depnom,$depusuario,$deprfc,$deptitular,$depdir,$deptel,$seldepest);
		$resconsulta= mysql_query($consulta);

			if(mysql_affected_rows()>0){
				$respuesta=true;
				$msj="Se ha registrado la dependencia";
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
	$msj="No se registró el programa";	
	$prognom	= strtoupper("'".$_POST["txtprognom"]."'");
	$selprogdep	= "'".$_POST["selprogdep"]."'";
	$progdpto	= "'".$_POST["selprogdpto"]."'";
	$progobj	= "'".$_POST["txtprogobj"]."'";
	$progvac	= "'".$_POST["txtprogvac"]."'";
	$progmod	= "'".$_POST["selprogmod"]."'";
	$progtipo	= "'".$_POST["selprogtipo"]."'";
	$progcar	= $_POST["selprogcar"];
	$selprogact	= "'".$_POST["selprogact"]."'";
	$progact	= "'".$_POST["txtprogact"]."'";
	$progresp	= "'".$_POST["txtprogresp"]."'";
	$progpues	= "'".$_POST["txtprogpues"]."'";
	$selprogest	= "'".$_POST["selprogest"]."'";
	$vigencia=1;
	if($selprogest=="'0'" or $selprogest=="'2'"){
		$vigencia=0;
	}
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	mysql_query("START TRANSACTION");
	$consulta = sprintf("insert into programas values(NULL,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",$prognom,$selprogdep,$progdpto,$progobj,$progvac,$progmod,$progtipo,$selprogact,$progact,$progresp,$progpues,$selprogest,$vigencia);
	$a1 = mysql_query($consulta);
	$id=mysql_insert_id();
	foreach($progcar as $selected) {
	    $conscar=sprintf("INSERT into carrera_programa(cvecarpro,cveprograma,cvecarrera)
					   VALUES (NULL,$id,$selected)");
	    $a2 = mysql_query($conscar);
	    if($selected==0){
	    	break;
	    }
    }
//si hay comillas simples en alguno de los valores se altera la consulta
	if ($a1 and $a2) {
		$respuesta=true;
		$msj="Se ha registrado el programa ".$prognom.'';
	    mysql_query("COMMIT");
	} else {      
	    mysql_query("ROLLBACK");
	}
	$salidaJSON = array ('respuesta' => $respuesta, 'mensaje'=>$msj);
		print json_encode($salidaJSON);
}

function llenaDepProgramas(){
	$respuesta=false;
	$conexion 	= conexionLocal();
	mysql_query("set NAMES utf8");
	$cons=sprintf("select cvedependencia, nomdependencia from dependencias");
	$opciones="";
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_array($res)) {

                  $cve = $row['cvedependencia'];
                  $nom = $row['nomdependencia']; 
                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
       

		$respuesta=true;
		}
		
	
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);

}

function llenaDptoProgramas(){
	$respuesta=false;
	$conexion 	= conexionLocal();
	$cvedep="'".$_POST["selprogdep"]."'";
	mysql_query("set NAMES utf8");
	$cons=sprintf("select nomdepartamento, cvedepartamento from departamentos where cvedependencia=%s", $cvedep);
	$opciones="";
	$res=mysql_query($cons);
	   while ($row = mysql_fetch_array($res)) {

                  $cve = $row['cvedepartamento'];
                  $nom = $row['nomdepartamento']; 
                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';   
		$respuesta=true;
		}

		
	
	$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
	print json_encode($arrayJSON);
}

	function llenaActProg(){
		$respuesta=false;
		$conexion 	= conexionLocal();
		mysql_query("set NAMES utf8");
		$cons=sprintf("SELECT cvedependencia, nomdependencia FROM dependencias");
		$opciones="";
		$res=mysql_query($cons);
		   while ($row = mysql_fetch_array($res)) {

	                  $cve = $row['cvedependencia'];
	                  $nom = $row['nomdependencia']; 
	                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
	       
		$respuesta=true;
			}
			
		
		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);

	}
	function tablaprogramas(){
		$respuesta		= false;
		$cn 			= conexionLocal();
		mysql_query("set NAMES utf8");
		$pagina = $_POST['pagina'];
		$inicio = ($pagina-1)*10;
		$qry 	= sprintf("SELECT * FROM programas LIMIT 10 OFFSET %s",$inicio);
		$res 	= mysql_query($qry);
		$tabla 	="<thead><tr><th>Nombre</th><th>Dependencia</th><th>Estado</th><th>Vigencia</th><th>Vacantes Disponibles</th><th>Vacantes Ocupadas</th><th>Vacantes Solicitadas</th><th></th></tr></thead><tbody>";
		while($renglon=mysql_fetch_array($res)){
			$cveprograma= $renglon["cveprograma"];
			$nombre 	= $renglon["nombre"];
			$dependencia= $renglon["cvedependencia"];
			$qryNombreD = sprintf("SELECT * FROM dependencias WHERE cvedependencia =%s", $dependencia);
			$resD 		= mysql_query($qryNombreD);	
			$rowD 		= mysql_fetch_array($resD);
			$nombreDependencia = $rowD['nomdependencia'];
			$vacantes 	= $renglon["vacantes"];
			$cveprograma 	= $renglon["cveprograma"];
			$qryVacantesO 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE cveprograma_1 = %s AND estado = 1", $cveprograma);
			$resV 			= mysql_query($qryVacantesO);
		 	$rowV 			= mysql_fetch_array($resV);
			$vacantesO 		= $rowV['TOTAL'];
			$qryVacantesS 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE cveprograma_1 = %s AND estado = 0", $cveprograma);
			$resVs 			= mysql_query($qryVacantesS);
		 	$rowVs			= mysql_fetch_array($resVs);
			$vacantesS 		= $rowVs['TOTAL'];
			$estado 		= $renglon["estado"];
			$estadoN 		= "";
			if($estado == "0"){
				$estadoN="Pendiente";
			}elseif($estado == "1"){
				$estadoN="Aceptado";
			}elseif($estado == "2"){
				$estadoN="Rechazado";
			}
			$vigencia 		= $renglon["vigencia"]; 
			if($vigencia=="1"){
				$vigencia= "Vigente";
			}else if($vigencia == "2"){
				$vigencia = "Expirado";
			}else{
				$vigencia ="Sin Asignar";
			}
			if($estado == "0"){
				$tabla 		.="<tr><td>".$nombre."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td>".$vigencia."</td><td style='text-align: center'>".$vacantes."</td><td style='text-align: center'>".$vacantesO."</td><td style='text-align: center'>".$vacantesS."</td>";
				$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveprograma."'><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveprograma."'><i class= 'material-icons'>close</i></button></td>";
				$tabla		.= "<td><button id='detallesProgramas' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveprograma."' ><i class = 'material-icons'>list</i></button></td><tr>";
			}else{
				$tabla 		.="<tr><td>".$nombre."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td>".$vigencia."</td><td style='text-align: center'>".$vacantes."</td><td style='text-align: center'>".$vacantesO."</td><td style='text-align: center'>".$vacantesS."</td>";
				$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveprograma."' disabled><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveprograma."' disabled><i class= 'material-icons'>close</i></button></td>";
				$tabla		.= "<td><button id='detallesProgramas' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveprograma."' ><i class = 'material-icons'>list</i></button></td><tr>";


			}



		}
		$tabla.="</tbody>";
		$respuesta=true;
		$qryCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas");
		$resCount = mysql_query($qryCount);
		$row 			= mysql_fetch_array($resCount);
		$totalProgramas = $row['TOTAL'];
		$botonesTotal 	= intval($totalProgramas/10);
		$restante = $totalProgramas-($botonesTotal*10);
		if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousN"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina==$botonesTotal){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextN"><a><i class="material-icons">chevron_right</i></a></li>';
		}
		$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPaginaN">';
		$arrayJSON = array('renglones' => $tabla, 'respuesta' => $respuesta, 'botones' =>$botones,'pagActual' => $pagina);
		print json_encode($arrayJSON);
	}
	
	function documentosExpediente(){
		$respuesta=false;
		$nocontrol	= "'".$_POST["ncontrol"]."'";
		$mensaje	="No se encuentra expediente";
		$cn 		= conexionLocal();
		$cveexp="";
		$cvesol="";
		$qryvalida	= sprintf("SELECT 	e.cveexpediente,
									  	d.archivo AS 'ruta',
									  	e.cvesolicitud,
									  	d.cvedocumento,
									  	d.tipo,
									  	d.revisado,
									  	d.calificacion
							    FROM expedientes e 
							    INNER JOIN documentos d 
							    on d.cvedocumento in (e.cartaacep,
							    					e.plantrabajo,
							    					e.cartatermina)
							    WHERE cveusuario_1=%s",$nocontrol);
		$res		= mysql_query($qryvalida);
		$arrayExp=array();
		$arraytipodoc=Array();
		/*TIPOS: 1-Solicitud	2-Carta Aceptacion 3-Plan de Trabajo 4-ReporteUno 5-ReporteDos 6-ReporteTres 7-Carta de Terminacion*/
		while($row = mysql_fetch_array($res)){
			$cveexp=$row["cveexpediente"];
			$cvesol=$row["cvesolicitud"];
			$tipodoc=intval($row["tipo"]);
			$ruta=$row["ruta"];
			$cvedcto=$row["cvedocumento"];
			$revisado=$row["revisado"];
			$califdoc=$row["calificacion"];
			 	$arraytipodoc['tipo']=$tipodoc;
				$arraytipodoc['ruta']=$ruta;
				$arraytipodoc['cvedoc']=$cvedcto;
				$arraytipodoc['calificacion']=$califdoc;
				$arraytipodoc["revisado"]=$revisado;
			$arrayExp[$tipodoc]=$arraytipodoc;
			$respuesta=true;
		}
		$arrayJSON=Array('respuesta'=>$respuesta,
						'documentos'=>$arrayExp,'cveexpediente'=>$cveexp,'cvesolicitud'=>$cvesol);
		print json_encode($arrayJSON);
	}
	function reportesExpediente(){
		$respuesta=false;
		$nocontrol="'".$_POST["ncontrol"]."'";
		$cn= conexionLocal();
		$cveexp="";
		$qryvalida=sprintf("SELECT 	e.cveexpediente,
									  	r.archivo AS 'ruta',
									  	r.cvereporte,
									  	r.noreporte,
									  	r.calificacion,
									  	(r.calificacion+r.calificacionV) as calTot,
									  	r.calificacionV,
                                        r.estado
							    FROM expedientes e 
							    INNER JOIN reportes r
							    on r.cvereporte in (e.reporteuno,
							    					e.reportedos,
							    					e.reportetres)
							    WHERE cveusuario_1=%s",$nocontrol);
		$res= 		mysql_query($qryvalida);
		$arrayExpRep=array();
		$arraytiporep=Array();

		while($row = mysql_fetch_array($res)){
			$cveexp=$row["cveexpediente"];
			$rutareporte	=$row["ruta"];
			$noreporte		=$row["noreporte"];
			$califEmp		=$row['calificacion'];
			$califVinc 		=$row['calificacionV'];
			$califTotal		=$row['calTot'];
			$cvereporte		=$row["cvereporte"];
			$estadorep 		=$row['estado'];
				$arraytiporep['cvereporte']		=$cvereporte;
				$arraytiporep['ruta']			=$rutareporte;
			 	$arraytiporep["califEmp"]		=$califEmp;
			 	$arraytiporep["califVinc"] 		=$califVinc;
			 	$arraytiporep["califTotal"]		=$califTotal;
			 	$arraytiporep["estado"]			=$estadorep;
			$arrayExpRep[$noreporte]=$arraytiporep;
			$respuesta=true;
		}
		$arrayJSON=Array('respuesta'=>$respuesta,
						'reportes'=>$arrayExpRep,'cveexpediente'=>$cveexp);
		print json_encode($arrayJSON);

	}

	function detallesSolicitud(){
		$respuesta 	    = false;
		$solicitud		= $_POST["solicitud"]; 
		$motivo			= $_POST["motivo"]; 
		$observaciones	= $_POST["observaciones"];
		$estado 		= $_POST["estado"];
		$conexion 		= conexionLocal();
		mysql_query("set NAMES utf8");
		$qryvalida 		= sprintf("select * from solicitudes where cvesolicitud=%s", $solicitud);
		$res 			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$motivoAnt		= $row["motivo"];
		$estadoAnt		= $row["estado"];
		$observacionesAnt = $row["observaciones"];
		if(($motivo <> $motivoAnt) or ($observaciones <> $observacionesAnt) or ($estado <> $estadoAnt)){
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
		$estado 		= $_POST["estado"];
		$conexion 		= conexionLocal();
		$borrarExp 		= true;
		mysql_query("set NAMES utf8");
		if($estado == "2" or $estado == "0"){
			$qryvalida	= sprintf("DELETE FROM expedientes WHERE cvesolicitud =%s",$solicitud);
			$res 		= mysql_query($qryvalida);
			if($res == false){
				$borrarExp = false;
			}
		}elseif($estado =="1"){
			$qryvalida 		= sprintf("SELECT * FROM solicitudes WHERE cvesolicitud =%s", $solicitud);
			$res 			= mysql_query($qryvalida);
			$row 			= mysql_fetch_array($res);
			$usuario		= $row["cveusuario_1"];
			$programa 		= $row["cveprograma_1"];
			$qryvalida 		= sprintf("INSERT INTO expedientes VALUES(NULL,%s,%s,%s,CURRENT_TIMESTAMP,' ',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0)",$solicitud,$usuario,$programa);
			$res= mysql_query($qryvalida);	
		}
		if($borrarExp == true){
			$qryvalidaU	= sprintf("UPDATE solicitudes SET  estado = %s, observaciones=%s, motivo=%s WHERE cvesolicitud = %s",$estado, $observaciones, $motivo, $solicitud);	
			$resU 		= mysql_query($qryvalidaU);
		}
		if(mysql_affected_rows()>0){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
		$arrayJSON = array('respuestaM' => $respuesta, 'borrarExp' => $borrarExp);
		print json_encode($arrayJSON);

	}
	function aceptarPrograma(){
		$respuesta 		= false;
		$programa 		= $_POST["programa"];
		$cn 			= conexionLocal();
		$qryvalida		= sprintf("SELECT * from programas where cveprograma =%s",$programa);
		$res			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$aceptado 		= 1;
		$qryvalidaU		= sprintf("UPDATE programas SET estado = %s WHERE  cveprograma = %s",$aceptado,$programa);	
		$resU 			= mysql_query($qryvalidaU);
		if($resU){
			$respuesta = true;
		}
		$arrayJSON = array('respuesta' => $respuesta);
		print json_encode($arrayJSON);

	}
	function rechazarPrograma(){
		$respuesta 		= false;
		$programa 		= $_POST["programa"];
		$cn 			= conexionLocal();
		$qryvalida		= sprintf("SELECT * from programas where cveprograma =%s",$programa);
		$res			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$rechazado 		= 2;
		$qryvalidaU		= sprintf("UPDATE programas SET estado = %s WHERE  cveprograma = %s",$rechazado,$programa);	
		$resU 			= mysql_query($qryvalidaU);
		if($resU){
			$respuesta = true;
		}

		$arrayJSON = array('respuesta' => $respuesta);
		print json_encode($arrayJSON);

	}
	function detallesPrograma(){
		$respuesta 		= false;
		$programa 		= $_POST["programa"];
		$vigenciaAnt 	= $_POST["vigencia"];
		$estadoAnt 		= $_POST["estado"];
		$cn 			= conexionLocal();
		mysql_query("set NAMES utf8");
		$qryvalida1		= sprintf("SELECT p.nombre,
										p.tipoact,
										p.tipoactdes,
										tp.tipoprograma,
										p.modalidad,
										p.nomresp,
										p.puestoresp,
										p.objetivo,
										p.vacantes,
										p.vigencia,
										p.estado,
										p.cvedependencia,
										p.cvedepartamento,
										p.cveprograma,
                                        cp.cveprograma, 
                                        GROUP_CONCAT(c.CARNCO SEPARATOR ',') AS 'carreras'
									FROM carrera_programa cp
									INNER JOIN carreras c ON cp.cvecarrera=c.carcve
									INNER JOIN programas p ON cp.cveprograma=p.cveprograma
									INNER JOIN tipo_programa tp ON p.tipoprog=tp.cvetipo
									WHERE p.cveprograma=%s
									GROUP BY cp.cveprograma",$programa);
		$res 			= mysql_query($qryvalida1);
		$row 			= mysql_fetch_array($res);
		if($res){
			$respuesta 	= true;
		}
		$nombreP		= $row["nombre"];
		$tipoAct		= $row["tipoact"];
		$desAct			= $row["tipoactdes"];
		$tipoP			= $row["tipoprograma"];
		$modalidad 		= $row["modalidad"];
		$responsable 	= $row["nomresp"];
		$puesto			= $row["puestoresp"];
		$objetivo 		= $row["objetivo"];
		$vacantes 		= $row["vacantes"];
		$carrerapref 	= $row["carreras"];
		$vigencia 		= $row["vigencia"];
		$estado 		= $row["estado"];
		$cvedependencia = $row["cvedependencia"];
		$cvedepartamento = $row["cvedepartamento"];
		$qryvalida 		= sprintf("SELECT * FROM dependencias WHERE cvedependencia =%s", $cvedependencia);
		$res 			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$empresa		= $row["nomdependencia"];
		$qryvalida 		= sprintf("SELECT * FROM departamentos WHERE cvedependencia =%s AND cvedepartamento =%s", $cvedependencia, $cvedepartamento);
		$res 			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$departamento	= $row["nomdepartamento"];
		$qryvalida 		= sprintf("SELECT COUNT(*) as total FROM expedientes WHERE cveprograma_1 = %s AND estado = 1", $programa);
		$res  			= mysql_query($qryvalida);
		$row 			= mysql_fetch_array($res);
		$total 			= $row['total'];
		$expedientes 	= false;
		if($total>0){
			$expedientes = true;
		}
		$qryAlumnos 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE cveprograma_1 = %s and estado = 1", $programa);
		$res 			= mysql_query($qryAlumnos);
		$row 			= mysql_fetch_array($res);
		$totalAlumnos 	= $row['TOTAL'];
		$arrayJSON 		= array('respuesta' => $respuesta, 'nombreP' => $nombreP, 'tipoAct' => $tipoAct, 'desAct' => $desAct, 'tipoP' => $tipoP, 'modalidad' => $modalidad, 'resposable' => $responsable, 'puesto' => $puesto, 
		'objetivo' => $objetivo, 'vacantes' => $vacantes, 'carreras'=> $carrerapref, 'vigencia' => $vigencia, 'estado' => $estado, 'empresa' => $empresa, 'departamento' => $departamento, 'expedientes' => $expedientes, 'totalAlumnos' => $totalAlumnos);
		print json_encode($arrayJSON);
	}
	function modificarPrograma(){
		$modificar 		= false;
		$programa 		= $_POST["programa"];
		$vigencia 	 	= $_POST["vigencia"];
		$estado			= $_POST["estado"];
		$vacantes 		= $_POST["vacantes"];
		$cn 			= conexionLocal();
		$qryvalida 		= sprintf("SELECT * FROM programas WHERE cveprograma =%s", $programa);
		$res 			= mysql_query($qryvalida);
		$row			= mysql_fetch_array($res);
		$vigenciaAnt 	= $row["vigencia"];
		$estadoAnt 		= $row["estado"];
		$vacantesAnt	= $row["vacantes"];
		$modificarVacantes = false;
		if(($vigenciaAnt <> $vigencia)or($estadoAnt<>$estado)) {
			$modificar=true;
		}else if($vacantes <> $vacantesAnt){
			$modificarVacantes = true;
		}
		$qrySolicitudes = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes where cveprograma_1 = %s and estado != 2",$programa);
		$res 			= mysql_query($qrySolicitudes);
		$row 			= mysql_fetch_array($res);
		$totalS 		= $row['TOTAL'];
		$solicitudes 	= false;
		if($totalS>0){
			$solicitudes = true;
		}

		$arrayJSON 		= array('modificar' => $modificar, 'solicitudes' => $solicitudes, 'modificarVacantes' => $modificarVacantes);
		print json_encode($arrayJSON);
	}
	function guardarPrograma(){
		$respuesta 		= false;
		$programa 		= $_POST["programa"];
		$vigencia 	 	= $_POST["vigencia"];
		$estado			= $_POST["estado"];
		$solicitudes 	= $_POST["solicitudes"];
		$vacantes 		= $_POST["vacantes"];
		$cn 			= conexionLocal();
		mysql_query("set NAMES utf8");
		if($solicitudes){
			$borrarS  		= false;
			$qryEliminaS 	= sprintf("DELETE FROM solicitudes WHERE cveprograma_1 = %s", $programa);
			$res 			= mysql_query($qryEliminaS);
			if(mysql_affected_rows()>0){
				$borrarS = true;
			}

		}
		$qryvalida 		= sprintf("UPDATE programas SET estado = %s, vigencia = %s, vacantes = %s WHERE cveprograma =%s", $estado, $vigencia, $vacantes,$programa);
		$res 			= mysql_query($qryvalida);
		if($res){
			$respuesta = true;
		}
		$arrayJSON 		= array('respuesta' => $respuesta);
		print json_encode($arrayJSON);
	}
	function muestraAlumnos(){
		$respuesta	= true;
		$cn 		= conexionLocal();
		mysql_query("set NAMES utf8");
		$pagina 	= $_POST['pagina'];
		$inicio 	= ($pagina-1)*10;
		$tabla		= "";
		$tabla		.= "<thead><tr>";
		$tabla		.= "<th>No. de Control</th>";
		$tabla		.=	"<th>Nombre</th>";
		$tabla		.=	"<th>Carrera</th>";
		$tabla		.=	"<th>Empresa</th>";
		$tabla		.=	"<th>Estado</th>";
		$tabla		.=	"<th>Periodo</th>";
		$tabla 		.=  "<th>Ver Expediente</th>";
		$tabla		.=	"</thead></tr>";
		$qryExpediente  = sprintf("SELECT E.estado, P.cveprograma, D.cvedependencia, E.cveusuario_1, D.nomdependencia, S.pdocve_1 FROM expedientes E 
				INNER JOIN programas P on P.cveprograma = E.cveprograma_1 
				INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
				INNER JOIN solicitudes S on E.cvesolicitud = S.cvesolicitud LIMIT 10 OFFSET %s",$inicio);
		$qryExpedienteCount  = sprintf("SELECT COUNT(*) AS TOTAL FROM expedientes E 
				INNER JOIN programas P on P.cveprograma = E.cveprograma_1 
				INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
				INNER JOIN solicitudes S on E.cvesolicitud = S.cvesolicitud");
		$res 		= mysql_query($qryExpediente);
		$resCount 	= mysql_query($qryExpedienteCount); 
		while($rowE = mysql_fetch_array($res)){
			$periodo 		= $rowE['pdocve_1'];
			$ncontrol 		= $rowE['cveusuario_1'];
			$estado 		= $rowE['estado'];
			$estadoN 		= "";
			if($estado == 1){
				$estadoN= "Captura";
			}else if ($estado ==2 ){
				$estadoN="Finalizado";
			}
			$cveprograma 	= $rowE['cveprograma'];
			$cvedependencia = $rowE['cvedependencia'];
			$nombreDependencia = $rowE['nomdependencia'];
			$qryAlumno 	= sprintf("SELECT A.ALUNOM, A.ALUAPP, A.ALUAPM, DC.CARNOM FROM DALUMN A 
									INNER JOIN DCALUM D ON A.ALUCTR = D.ALUCTR 
									INNER JOIN DCARRE DC ON D.CARCVE = DC.CARCVE 
									WHERE  A.ALUCTR = %s", $ncontrol);
			$resA		= mysql_query($qryAlumno, conexionBD());
			$rowA 		= mysql_fetch_array($resA);
			$nombre		=	$rowA["ALUNOM"];
			$apellidopa	=	$rowA["ALUAPP"];
			$apellidoma	=	$rowA["ALUAPM"];
			$carrera 	=   $rowA["CARNOM"];
			$tabla 		.= "<tr><td>".$ncontrol."</td><td>".$nombre." ".$apellidopa." ".$apellidoma."</td><td>".$carrera."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td style='text-align: center'>".$periodo."</td><td style='text-align: center'>
							<button class='btn-floating btn-small waves-effect waves-light blue' id='expediente' target=_blank aling='right' value='".$ncontrol."'>
							<i class='material-icons'>open_in_new</i></button></td></tr>";

		}
		$row 			= mysql_fetch_array($resCount);
		$totalProgramas = $row['TOTAL'];
		$botonesTotal 	= intval($totalProgramas/10);
		$restante = $totalProgramas-($botonesTotal*10);
		if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousN"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPag"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina==$botonesTotal){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextN"><a><i class="material-icons">chevron_right</i></a></li>';
		}
		$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPaginaA">';
		$arrayJSON 	= array('respuesta'=> $respuesta, 'tabla' => $tabla, 'botones' => $botones);
		print json_encode($arrayJSON);
	}

	function consultaFiltro(){
		$value  		= $_POST['value'];
		$respuesta  	= false;
		$cn 			= conexionLocal();
		$opciones="";
		if($value=='1'){
			$qryvalida 		= sprintf("SELECT * FROM dependencias");
		    $res 			= mysql_query($qryvalida);
			while($row = mysql_fetch_array($res)){
					$cve 		= $row['cvedependencia'];
					$nom 		= $row['nomdependencia'];
					$opciones 	.= '<option value="'.$cve.'">'.$nom.'</option>';
					$respuesta = true;
			}
		}else{
			$qryvalida 		= sprintf("SELECT * FROM carreras");
			$res 			= mysql_query($qryvalida);
			while($row = mysql_fetch_array($res)){
			 	$cve 		= $row['CARCVE'];
				$nom 		= $row['CARNCO'];
				$opciones 	.= '<option value="'.$cve.'">'.$nom.'</option>';
				$respuesta = true;
			}
		}

		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);
	}
	function consultaFiltroSolicitudes(){
		$cn 			= conexionLocal();
		$qryvalida 		= sprintf("SELECT * FROM programas");
		$res 			= mysql_query($qryvalida);
		$opciones 		= "";
		$respuesta 		= false;
		while($row = mysql_fetch_array($res)){
				$cve 		= $row['cveprograma'];
				$nom 		= $row['nombre'];
				$opciones 	.= '<option value="'.$cve.'">'.$nom.'</option>';
				$respuesta   = true;
		}
		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta);
		print json_encode($arrayJSON);

	}
	function llenaTipoProg(){
		$respuesta=false;
		$conexion 	= conexionLocal();
		mysql_query("set NAMES utf8");
		$cons=	sprintf("SELECT cvetipo, 
								tipoprograma 
						FROM tipo_programa");
		$opciones="";
		$res=mysql_query($cons);
		   while ($row = mysql_fetch_array($res)) {

	                  $cve = intval($row['cvetipo']);
	                  $nom = $row['tipoprograma']; 
	                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
	                  $respuesta=true;
			}
			
		
		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);
	}
	function llenaCarreraPref(){
		$respuesta=false;
		$conexion 	= conexionLocal();
		mysql_query("set NAMES utf8");
		$cons=	sprintf("SELECT CARCVE, CARNCO 
						FROM carreras");
		$opciones="";
		$res=mysql_query($cons);
		   while ($row = mysql_fetch_array($res)) {
	                  $cve = intval($row['CARCVE']);
	                  $nom = $row['CARNCO']; 
	                  $opciones .='<option value="'.$cve.'">'.$nom.'</option>';
	                  $respuesta=true;
			}
			
		
		$arrayJSON = array('opciones' => $opciones, 'respuesta' => $respuesta );
		print json_encode($arrayJSON);
	}
	function consultaPeriodos(){
		$respuesta 	= false;
		$cn 		= conexionLocal();
		$qryPeriodos	= sprintf("SELECT DISTINCT pdocve_1 FROM solicitudes");
		$res 			= mysql_query($qryPeriodos);
		$opciones 		= "";
		if($res){
			$respuesta=true;
		}
	   while ($row = mysql_fetch_array($res)) {
          $periodo = $row['pdocve_1']; 
          $opciones .='<option value="'.$periodo.'">'.$periodo.'</option>';
		}
		$arrayJSON = array('periodos' => $opciones, 'respuesta' => $respuesta);
		print json_encode($arrayJSON); 
	}

	function agregarDepartamento(){
		$respuesta 	= 	false;
		$cn 		=	conexionLocal();
		$dptonom	=	strtoupper("'".$_POST['nombre']."'");
		$depcve		=	$_POST['dependencia'];
		$qryexiste	=	sprintf("SELECT dp.cvedepartamento, d.nomdependencia 
							FROM departamentos dp 
							INNER JOIN dependencias d ON dp.cvedependencia=d.cvedependencia
                            WHERE dp.cvedependencia =%s AND dp.nomdepartamento=%s",$depcve,$dptonom);
		$resaux		=	mysql_query($qryexiste);
		if($row= mysql_fetch_array($resaux)){
			$nombreDep		= $row["nomdependencia"];
			$mensaje		= "Ya existe un departamento con ese nombre en ".$nombreDep;

		}else{
			$qryDpto	= sprintf("INSERT INTO departamentos(cvedepartamento,cvedependencia,nomdepartamento)
										VALUES(NULL,$depcve,$dptonom)");
			$res 		= mysql_query($qryDpto);
				if(mysql_affected_rows()>0){
					$respuesta=true;
					$mensaje="Se ha agregado el departamento ".$dptonom;
				}
		}
		$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje);
		print json_encode($arrayJSON); 
	}
	function filtrarAlumnos(){
		$opcion  		= $_POST['opcion'];
		$filtro  		= $_POST['filtro'];
		$periodo  		= $_POST['periodo'];
		$pagina 	= $_POST['pagina'];
		$inicio 	= ($pagina-1)*10;
		$respuesta	= true;
		$cn 		= conexionLocal();
		$tabla		= "";
		$tabla		.= "<thead><tr>";
		$tabla		.= "<th>No. de Control</th>";
		$tabla		.=	"<th>Nombre</th>";
		$tabla		.=	"<th>Carrera</th>";
		$tabla		.=	"<th>Empresa</th>";
		$tabla		.=	"<th>Estado</th>";
		$tabla		.=	"<th>Periodo</th>";
		$tabla 		.=  "<th>Ver Expediente</th>";
		$tabla		.=	"</thead></tr>";
		$opcionCve   = ""; 
		if($filtro == '2'){
			$qryExpediente  = sprintf("SELECT E.cveusuario_1, E.estado, E.cveprograma_1, D.cvedependencia, D.nomdependencia
										FROM expedientes E 
										INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud 
										INNER JOIN programas P ON P.cveprograma = S.cveprograma_1
										INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
										WHERE E.estado = %s AND S.pdocve_1 =%s LIMIT 10 OFFSET %s", $opcion, $periodo, $inicio);
			$qryExpedienteCount  = sprintf("SELECT COUNT(*) AS TOTAL
										FROM expedientes E 
										INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud 
										INNER JOIN programas P ON P.cveprograma = S.cveprograma_1
										INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
										WHERE E.estado = %s AND S.pdocve_1 =%s ", $opcion, $periodo);
		//}else if(){
		}else if($filtro == '1'){
			$qryExpediente  = sprintf("SELECT E.cveusuario_1, E.estado, E.cveprograma_1, D.cvedependencia, D.nomdependencia 
							FROM expedientes E 
							INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud
							INNER JOIN programas P ON P.cveprograma = S.cveprograma_1
							INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
							WHERE S.pdocve_1 =%s AND P.cvedependencia = %s LIMIT 10 OFFSET %s", $periodo, $opcion, $inicio);
			$qryExpedienteCount  = sprintf("SELECT COUNT(*) AS TOTAL
							FROM expedientes E 
							INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud
							INNER JOIN programas P ON P.cveprograma = S.cveprograma_1
							INNER JOIN dependencias D on D.cvedependencia = P.cvedependencia
							WHERE S.pdocve_1 =%s AND P.cvedependencia = %s", $periodo, $opcion);
		}
		$res 			= mysql_query($qryExpediente);
		$resCount 		= mysql_query($qryExpedienteCount);
		while($rowE = mysql_fetch_array($res)){
			$ncontrol 		= $rowE['cveusuario_1'];
			$estado 		= $rowE['estado'];
			$estadoN 		= "";
			if($estado == 1){
				$estadoN= "Captura";
			}else if ($estado ==2 ){
				$estadoN="Finalizado";
			}
			$cveprograma 	= $rowE['cveprograma_1'];
			$cvedependencia = $rowE['cvedependencia'];
			$nombreDependencia = $rowE['nomdependencia'];
			$qryAlumno 	= sprintf("SELECT A.ALUNOM, A.ALUAPP, A.ALUAPM, DC.CARNOM, DC.CARCVE
				FROM DALUMN A INNER JOIN DCALUM D ON A.ALUCTR = D.ALUCTR INNER JOIN DCARRE DC ON D.CARCVE = DC.CARCVE WHERE  A.ALUCTR = %s",$ncontrol);
			$resA		= mysql_query($qryAlumno, conexionBD());
			$rowA 		= mysql_fetch_array($resA);
			$nombre		=	$rowA["ALUNOM"];
			$apellidopa	=	$rowA["ALUAPP"];
			$apellidoma	=	$rowA["ALUAPM"];
			$carrera 	=   $rowA["CARNOM"];
			$cvecarrera =   $rowA["CARCVE"];
			$tabla 		.= "<tr><td>".$ncontrol."</td><td>".$nombre." ".$apellidopa." ".$apellidoma."</td><td>".$carrera."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td style='text-align: center'>".$periodo."</td><td style='text-align: center'><button class='btn-floating btn-small waves-effect waves-light blue' id='expediente' target=_blank aling='right' value='".$ncontrol."'><i class='material-icons'>open_in_new</i></button></td></tr>";
		}
		$row 			= mysql_fetch_array($resCount);
		$totalProgramas = $row['TOTAL'];
		$botonesTotal 	= intval($totalProgramas/10);
		$restante = $totalProgramas-($botonesTotal*10);
		if($restante>0){
			$botonesTotal = $botonesTotal+1;
		}		
		if($botonesTotal==1){
			$botonesTotal = 0;
		}
		$botones = '<ul class="pagination" id="botonesPaginacion">';
		if($pagina==1){
			$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}else{	
			$botones .= '<li class="waves-effect" id="btnPreviousFA"><a><i class="material-icons">chevron_left</i></a></li>  ';
		}
		for($i=0;$i<$botonesTotal;$i++){
			$numero  	= $i+1;
			if($numero==$pagina){
				$botones 	.='<li class="teal lighten-2 active" value ='.$numero.' id="btnPagF"><a>'.$numero.'</a></li>  ';	
			}else{
				$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPagF"><a>'.$numero.'</a></li>  ';	
			}
		}
		if($pagina==$botonesTotal){
  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
		}else{
  			$botones .= '<li class="waves-effect" id="btnNextFA"><a><i class="material-icons">chevron_right</i></a></li>';
		}
		$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPaginaAF">';
		$arrayJSON 	= array('respuesta'=> $respuesta, 'tabla' => $tabla, 'botones' => $botones);
		print json_encode($arrayJSON);
	}
	function filtrarSolicitudes(){
		mysql_query("set NAMES utf8");
		$pagina 		= $_POST['pagina'];
		$inicio			= ($pagina-1)*10;
		$opcion  		= $_POST['opcion'];
		$filtro  		= $_POST['filtro'];
		$periodo  		= $_POST['periodo'];
		$nocontrol 		= $_POST['nocontrol'];
		$qrySolicitud = "";
		$qrySolicitudCount ="";
		$respuesta	= false;
		$cn 		= conexionLocal();
		$tabla		= "";
		$tabla		.= "<thead><tr>";
		$tabla		.= "<th>No. de Control</th>";
		$tabla		.=	"<th>Nombre</th>";
		$tabla		.=	"<th>Estado</th>";
		$tabla		.=	"<th>Programa</th>";
		$tabla		.=	"<th></th>";
		$tabla		.=	"</thead></tr>";
		switch ($filtro) {
			case '0':
				$qrySolicitud = sprintf("SELECT P.nombre, S.cveusuario_1, S.cvesolicitud, S.estado FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.estado = %s AND S.pdocve_1 =%s LIMIT 10 OFFSET %s",$opcion, $periodo,$inicio);
				$qrySolicitudCount = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.estado = %s AND S.pdocve_1 =%s",$opcion, $periodo);
				break;
			case '1':
				$qrySolicitud = sprintf("SELECT P.nombre, S.cveusuario_1, S.cvesolicitud, S.estado FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.cveprograma_1 =%s AND S.pdocve_1 =%s LIMIT 10 OFFSET %s",$opcion, $periodo,$inicio);
				$qrySolicitudCount = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.cveprograma_1 =%s AND S.pdocve_1 =%s",$opcion, $periodo);
				break;
			case '2':
				$qrySolicitud = sprintf("SELECT P.nombre, S.cveusuario_1, S.cvesolicitud, S.estado FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.cveusuario_1 = %s LIMIT 10 OFFSET %s",$nocontrol,$inicio);
				$qrySolicitudCount = sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes S INNER JOIN programas P ON S.cveprograma_1 = P.cveprograma WHERE S.cveusuario_1 = %s ",$nocontrol);
				break;
		}
		$res = mysql_query($qrySolicitud,$cn);
		while($row0 = mysql_fetch_array($res)){
			$respuesta 		= true;
			$cveusuario  	= $row0["cveusuario_1"];
			$cvesolicitud 	= $row0["cvesolicitud"];
			$nombrePro 		= $row0['nombre'];
			$estado 		= $row0["estado"];
			$tabla			.= "<tr>";
			$tabla			.= "<td>".$row0["cveusuario_1"]."</td>";
			$cn2	 		= conexionBD();
			$qryvalida		= sprintf("SELECT D.ALUNOM, D.ALUAPP, D.ALUAPM FROM DALUMN D WHERE ALUCTR = %s",$cveusuario);
			$resN			= mysql_query($qryvalida, $cn2);
			$row 			= mysql_fetch_array($resN);
			$tabla		.= "<td>".$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"]."</td>";
			if($row0["estado"]==0){
				$tabla		.= "<td>"."PENDIENTE"."</td>";
			}else if($row0["estado"]==1){
				$tabla		.="<td>"."ACEPTADO"."</td>";
			}else{
				$tabla		.="<td>"."RECHAZADO"."</td>";
			}

			if($estado !=0){
				$tabla		.= "<td>".$nombrePro."</td>";
				$tabla 		.= "<td><button name= 'aceptar 'id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' disabled><i class= 'material-icons'>close</i></a></td>";
				$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cvesolicitud."'><a href='../datos/descargarArchivos.php?solicitud=".$cvesolicitud."' target=_blank><i class = 'material-icons'>file_download</i></a></button></td>";
				$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cvesolicitud."' ><i class = 'material-icons'>list</i></button></td>";
				
			}else{
				$tabla		.= "<td>".$nombrePro."</td>";
				$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cvesolicitud."' ><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cvesolicitud."' ><i class= 'material-icons'>close</i></a></td>";
				$tabla		.= "<td><button id='descargar' class='btn-floating btn-small waves-effect waves-light blue' value = '".$cvesolicitud."' ><a href='../datos/descargarArchivos.php?solicitud=".$cvesolicitud."' target=_blank><i class = 'material-icons'>file_download</i></a></button></td>";
				$tabla		.= "<td><button id='detalles' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cvesolicitud."' ><i class = 'material-icons'>list</i></button></td>";

			}

			
		}
		$cn 	= conexionLocal();
		$resCount = mysql_query($qrySolicitudCount);
		$rowCount = mysql_fetch_array($resCount);
		$total 	  = $rowCount['TOTAL'];
		$totalBotones 	= intval($total/10);
		$restante 		= $total - ($totalBotones*10);
		if($restante>0){
			$totalBotones = $totalBotones+1;
		}
		if($totalBotones<=1){
			$totalBotones = 0;
			$botones = ' ';
		}else{
			$botones ='<ul class="pagination" id="botonesPaginacionFS">';
			if($pagina==1){
				$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
			}else{	
				$botones .= '<li class="waves-effect" id="btnPreviousFS"><a><i class="material-icons">chevron_left</i></a></li>  ';
			}
			for($i=0;$i<$totalBotones;$i++){
				$numero  	= $i+1;
				if($numero==$pagina){
					$botones 	.='<li class="active teal lighten-2" value ='.$numero.' id="btnPagFS"><a>'.$numero.'</a></li>  ';	
				}else{
					$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPagFS"><a>'.$numero.'</a></li>  ';	
				}
			}
			if($pagina==$totalBotones){
	  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
			}else{
	  			$botones .= '<li class="waves-effect" id="btnNextFS"><a><i class="material-icons">chevron_right</i></a></li>';
			}
			$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPagina">';
		}
		$tabla		.= "</tr>";
		$arrayJSON 	= array('respuesta'=> $respuesta, 'tabla' => $tabla, 'botones' => $botones, 'pagina' => $pagina);
		print json_encode($arrayJSON);

	}
	function filtrarProgramas(){
		$pagina 		= $_POST['pagina'];
		$opcion  		= $_POST['opcion'];
		$filtro  		= $_POST['filtro'];
		$respuesta	= false;
		$inicio 	= ($pagina-1)*10;
		$cn 		= conexionLocal();
		$qryProgramas = "";
		$tabla		= "";
		$tabla 		= "<thead><tr><th>Nombre</th><th>Dependencia</th><th>Estado</th><th>Vigencia</th><th>Vacantes Disponibles</th><th>Vacantes Ocupadas</th><th>Vacantes Solicitadas</th><th></th></tr></thead><tbody>";
		switch($filtro){
			case '0':
				$qryProgramasCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas WHERE vigencia = %s", $opcion);
				$qryProgramas = sprintf("SELECT * FROM programas WHERE vigencia = %s LIMIT 10 OFFSET %s", $opcion,$inicio);
				break;
			case '1': 
				$qryProgramasCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas WHERE cvedependencia =%s", $opcion);
				$qryProgramas = sprintf("SELECT * FROM programas WHERE cvedependencia =%s LIMIT 10 OFFSET %s", $opcion,$inicio);
				break;
			case '2': 
				if($opcion == '0'){
					$qryProgramasCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas");
					$qryProgramas = sprintf("SELECT * FROM programas LIMIT 10 OFFSET %s",$inicio);
				}else{
					$qryProgramasCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas P 
											INNER JOIN carrera_programa CP 
											ON P.cveprograma = CP.cveprograma 
											WHERE CP.cvecarrera = %s",$opcion);
					$qryProgramas = sprintf("SELECT * FROM programas P 
											INNER JOIN carrera_programa CP 
											ON P.cveprograma = CP.cveprograma 
											WHERE CP.cvecarrera = %s LIMIT 10 OFFSET %s",$opcion,$inicio);
				}
				break;
			case '3': 
				$qryProgramasCount = sprintf("SELECT COUNT(*) AS TOTAL FROM programas WHERE estado =%s", $opcion);
				$qryProgramas = sprintf("SELECT * FROM programas WHERE estado =%s LIMIT 10 OFFSET %s", $opcion,$inicio);
				break;
		}
		$res 		= mysql_query($qryProgramas);
		while($renglon 	= mysql_fetch_array($res)){
			$respuesta 	= true;
			$cveprograma= $renglon["cveprograma"];
			$nombre 	= $renglon["nombre"];
			$dependencia= $renglon["cvedependencia"];
			$qryNombreD = sprintf("SELECT * FROM dependencias WHERE cvedependencia =%s", $dependencia);
			$resD 		= mysql_query($qryNombreD);	
			$rowD 		= mysql_fetch_array($resD);
			$nombreDependencia = $rowD['nomdependencia'];
			$vacantes 	= $renglon["vacantes"];
			
			$cveprograma 	= $renglon["cveprograma"];
			$qryVacantesO 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE cveprograma_1 = %s AND estado = 1", $cveprograma);
			$resV 			= mysql_query($qryVacantesO);
		 	$rowV 			= mysql_fetch_array($resV);
			$vacantesO 		= $rowV['TOTAL'];
			$qryVacantesS 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE cveprograma_1 = %s AND estado != 1", $cveprograma);
			$resVs 			= mysql_query($qryVacantesS);
		 	$rowVs			= mysql_fetch_array($resVs);
			$vacantesS 		= $rowVs['TOTAL'];
			$estado 		= $renglon["estado"];
			$estadoN 		= "";
			if($estado == "0"){
				$estadoN="Pendiente";
			}elseif($estado == "1"){
				$estadoN="Aceptado";
			}elseif($estado == "2"){
				$estadoN="Rechazado";
			}
			$vigencia 		= $renglon["vigencia"]; 
			if($vigencia=="1"){
				$vigencia= "Vigente";
			}else if($vigencia == "2"){
				$vigencia = "Expirado";
			}else{
				$vigencia ="Sin Asignar";
			}

			if($estado == "0"){
				$tabla 		.="<tr><td>".$nombre."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td>".$vigencia."</td><td style='text-align: center'>".$vacantes."</td><td style='text-align: center'>".$vacantesO."</td><td style='text-align: center'>".$vacantesS."</td>";
				$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveprograma."'><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveprograma."'><i class= 'material-icons'>close</i></button></td>";
				$tabla		.= "<td><button id='detallesProgramas' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveprograma."' ><i class = 'material-icons'>list</i></button></td><tr>";
			}else{
				$tabla 		.="<tr><td>".$nombre."</td><td>".$nombreDependencia."</td><td>".$estadoN."</td><td>".$vigencia."</td><td style='text-align: center'>".$vacantes."</td><td style='text-align: center'>".$vacantesO."</td><td style='text-align: center'>".$vacantesS."</td>";
				$tabla 		.= "<td><button id='aceptar' class='btn-floating btn-small waves-effect waves-light green' value = '".$cveprograma."' disabled><i class= 'material-icons'>done_all</i></button></td>";
				$tabla		.= "<td><button id='rechazar' class='btn-floating btn-small waves-effect waves-light red' value = '".$cveprograma."' disabled><i class= 'material-icons'>close</i></button></td>";
				$tabla		.= "<td><button id='detallesProgramas' class='btn-floating btn-small waves-effect waves-light yellow' value = '".$cveprograma."' ><i class = 'material-icons'>list</i></button></td><tr>";
			}

		}
		$resCount 	= mysql_query($qryProgramasCount);
		$rowCount 	= mysql_fetch_array($resCount);
		$total 	  	= $rowCount['TOTAL'];
		$totalBotones 	= intval($total/10);
		$restante 		= $total - ($totalBotones*10);
		if($restante>0){
			$totalBotones = $totalBotones+1;
		}
		if($totalBotones<=1){
			$totalBotones = 0;
			$botones = ' ';
		}else{
			$botones ='<ul class="pagination" id="botonesPaginacionF">';
			if($pagina==1){
				$botones .= '<li class="disabled"><a><i class="material-icons">chevron_left</i></a></li>  ';
			}else{	
				$botones .= '<li class="waves-effect" id="btnPrevious"><a><i class="material-icons">chevron_left</i></a></li>  ';
			}
			for($i=0;$i<$totalBotones;$i++){
				$numero  	= $i+1;
				if($numero==$pagina){
					$botones 	.='<li class="active teal lighten-2" value ='.$numero.' id="btnPagF"><a>'.$numero.'</a></li>  ';	
				}else{
					$botones 	.='<li class="waves-effect" value ='.$numero.' id="btnPagF"><a>'.$numero.'</a></li>  ';	
				}
			}
			if($pagina==$totalBotones){
	  			$botones .= '<li class="disabled" ><a><i class="material-icons">chevron_right</i></a></li>';
			}else{
	  			$botones .= '<li class="waves-effect" id="btnNext"><a><i class="material-icons">chevron_right</i></a></li>';
			}
			$botones .= '</ul><input type="hidden" value='.$pagina.' id="valorPagina">';
		}
		$arrayJSON 	= array('respuesta'=> $respuesta, 'tabla' => $tabla, 'botones' => $botones,'pagActual' => $pagina);
		print json_encode($arrayJSON);
	}
	function registroAlumnos(){
		//funcion que devuelve a los alumnos candidatos 
		/*complementario a muestraregAlumnos2 en JS*/
		$respuesta 	= false;
		$mensaje 	="";
		$cn 		= conexionBD();
		$qrycandidatos 	= sprintf("SELECT alm.ALUCTR, 
							TRUNCATE((inf.calcac/p.placre),2) AS PORC, 
							inf.CARCVE 
							FROM DALUMN alm 
							INNER JOIN DCALUM inf on alm.ALUCTR=inf.ALUCTR and inf.calsit=1
							INNER JOIN DPLANE p on inf.PLACVE=p.PLACVE and inf.CARCVE=p.CARCVE 
							INNER JOIN DCLIST dc ON dc.ALUCTR=alm.ALUCTR 
							WHERE (dc.PDOCVE = (select PARFOL1 from DPARAM where PARCVE= 'PRDO') 
												AND alm.ALUCTR NOT IN (SELECT sol.cveusuario_1 FROM %s.solicitudes sol where estado!=2)) 
							HAVING PORC>=0.7 
							ORDER BY `PORC` DESC, alm.ALUCTR ",$GLOBALS['bdss']);
		
		$res = mysql_query($qrycandidatos);
		//echo mysql_errno($cn) . ": " . mysql_error($cn). "\n";
		$total= mysql_num_rows($res);


		$tbl="<tr><th>No. Control</th><th>PORCENTAJE</th><th>Asignación</th></tr>";
		$arreglo=Array();
	//EL 100 ES ARBITRARIO NECESITO VARIABLE
		$primerapagina=100;
		if($total<$primerapagina)
			$primerapagina=$total;

		for ($i = 0; $i <$primerapagina; $i++) {
		    //echo "{".$arreglo[$i][0].",".$arreglo[$i][1]."}";
		    $row = mysql_fetch_assoc($res);
		    $nc=$row["ALUCTR"];
			$porcentaje=$row["PORC"];
			$respuesta=true;

			$arreglo[]=array($nc,$porcentaje);

		}

		$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje, 'tablaArray'=>$arreglo, 'total'=>$total);
		print json_encode($arrayJSON); 
	}
	function totRegistroAlumnos(){
		$paginaI 	=$_POST['pagina'];
		$paginaI-=1;
		$respuesta 	= true;
		$mensaje 	="No se pudieron obtener los candidatos";
		$cn 		= conexionBD();

		$qrycandidatos 	= sprintf("SELECT alm.ALUCTR, 
							TRUNCATE((inf.calcac/p.placre),2) AS PORC, 
							inf.CARCVE 
							FROM DALUMN alm 
							INNER JOIN DCALUM inf on alm.ALUCTR=inf.ALUCTR and inf.calsit=1
							INNER JOIN DPLANE p on inf.PLACVE=p.PLACVE and inf.CARCVE=p.CARCVE 
							INNER JOIN DCLIST dc ON dc.ALUCTR=alm.ALUCTR 
							WHERE (dc.PDOCVE = (select PARFOL1 from DPARAM where PARCVE= 'PRDO') 
												AND alm.ALUCTR NOT IN (SELECT sol.cveusuario_1 FROM %s.solicitudes sol where estado!=2)) 
							HAVING PORC>=0.7 
							ORDER BY `PORC` DESC, alm.ALUCTR ASC LIMIT 100 OFFSET %s",$GLOBALS['bdss'],($paginaI*100));
		$res = mysql_query($qrycandidatos);
		$tbl="<tr><th>No. Control</th><th>PORCENTAJE AVANCE</th><th>Asignación</th></tr>";
		while($row = mysql_fetch_array($res)){
			$nc=$row["ALUCTR"];
			$porcentaje=$row["PORC"];
			$tbl.="<tr><td>".$nc."</td><td id='".$nc."''>".$porcentaje."</td>".
			"<td><button class='btn-floating waves-effect waves-light blue' id='btnasignaprog' value='".$nc."'><i class='material-icons'>library_add</i></button></td></tr>";
			$respuesta=true;
			$mensaje="";
		}

		$arrayJSON = array('respuesta' => $respuesta, 'mensaje'=>$mensaje,'candidatos'=>$tbl);
		print json_encode($arrayJSON); 
	}
	function programasAsignacion(){
		//function que devuelve la lista de programas segun la carrera del alumno
		$respuesta 	=	false;
		$mensaje	=	"No se ha podido Mostrar la lista de programas";
	$cnBD  		=	conexionBD();
		$ncontrol 	=	$_POST["ncontrol"];
		$qryAlumno 	= sprintf("SELECT A.ALUNOM, A.ALUAPP, A.ALUAPM, D.CARCVE, C.CARNCO
								FROM DALUMN A 
								INNER JOIN DCALUM D ON A.ALUCTR = D.ALUCTR
								INNER JOIN DCARRE C ON C.CARCVE = D.CARCVE 
								WHERE  A.ALUCTR = %s",$ncontrol);
		$resBD 		=	mysql_query($qryAlumno);	
		$cvecarrera	="";
		$carrera 	="";
		$nombre		="";
			
		if($row= mysql_fetch_array($resBD)){
			$cvecarrera	=	$row["CARCVE"];		
			$carrera 	=	$row["CARNCO"];
			$nombre		=	$row["ALUNOM"]." ".$row["ALUAPP"]." ".$row["ALUAPM"];			
		}
	$cn=conexionLocal();	
		//echo mysql_errno($cnBD) . ": " . mysql_error($cnBD). "\n";	
		$qryprogramas=	sprintf("SELECT p.cveprograma, p.nombre, c.carnco 
								FROM programas p 
								INNER JOIN carrera_programa cp ON cp.cveprograma=p.cveprograma 
								INNER JOIN carreras c ON c.carcve=cp.cvecarrera 
								WHERE (cp.cvecarrera=0 OR cp.cvecarrera=%s) AND vacantes>=1
								ORDER BY p.nombre ASC",$cvecarrera);
		$res= mysql_query($qryprogramas,$cn);
		$renglones = array();
		while($r = mysql_fetch_assoc($res)) {
			$renglones[] = $r;
			$respuesta 	=	true;
			$mensaje="";
		}
		//echo mysql_errno($cn) . ": " . mysql_error($cn). "\n";
		$arrayJSON = array('respuesta'=>$respuesta, 'opciones'=>$renglones,'nombrealm'=>$nombre,'carrera'=>$carrera, 'mensaje'=>$mensaje);
		print json_encode($arrayJSON);
	}
	function alumnoesusuario($alumno){  
		mysql_query("set NAMES utf8");
		$consultaruser	= sprintf("select * from usuarios where cveusuario=%s and tipousuario=3 limit 1",$alumno);
		$res 			= mysql_query($consultaruser,conexionLocal());
		if($row = mysql_fetch_array($res)){
			return true;
		}
		return false;
	}	
	function asignarprogramaAl(){

		//funcion que asigna un programa a un alumno :. solicitud

		//VERIFICAR QUE EXISTA EL ALUMNO!!
	$respuesta 	=	false;
	$alumno			=	$_POST['alumno'];
	$permisoAlumno	= alumnoesusuario($alumno);
	
	if(!$permisoAlumno){
	//el alumno no es usuario
		$arrayJSON = array('respuesta'=>true, 'permisoAlumno'=>$permisoAlumno);
		print json_encode($arrayJSON);
		return;
		
	}
		//EL ALUMNO ES USUARIO
		$mensaje		= "No se ha podido asignar al alumno";
		$programa		=	$_POST['programa'];
		$observaciones	=	"'".$_POST['observaciones']."'";
		
		//INSERTAR SI EL ALUMNO NO TIENE SOLICITUDES PENDIENTES O ACEPTADAS!
		$qrysolicitudprevia=sprintf("SELECT * FROM solicitudes WHERE cveusuario_1=%s and (estado=1 or estado=0)",$alumno);
		$resprevia=mysql_query($qrysolicitudprevia,conexionLocal());
		if($rowS = mysql_fetch_array($resprevia)){
			//YA EXISTE UNA SOLICITUD DEL ALUMNO :. NO SE PUEDE INSERTAR
			$arrayJSON = array('respuesta'=>true, 'mensaje'=>'No se puede asignar. El alumno ya cuenta con una solicitud Pendiente o Aceptada');
			print json_encode($arrayJSON);
			return;
		}
		//OBTENER PERIODO ACTUAL
		$qryperiodo	= sprintf("select PARFOL1 from DPARAM where PARCVE= 'PRDO'");
		$res		= mysql_query($qryperiodo,conexionBD());
		$row 		= mysql_fetch_array($res);
		$periodoAct	= $row["PARFOL1"];

		$qrysolicitud 	=sprintf("INSERT INTO solicitudes(cvesolicitud,cveusuario_1,cveprograma_1,estado,pdocve_1,motivo,observaciones) 
			VALUES (NULL,%s,%s,1,%s,'-',%s)",$alumno,$programa,$periodoAct,$observaciones);

		$res2 =mysql_query($qrysolicitud, conexionLocal());
		
		if(mysql_affected_rows()>0){
			$respuesta 	=true;
			$mensaje="Se ha asignado el alumno al programa";
		}

				
		$arrayJSON = array('respuesta'=>$respuesta, 'mensaje'=>$mensaje);
		print json_encode($arrayJSON);
	}
	function tomoCursoMoodle(){
		$respuesta=false;
		$mensaje="Asegúrate de que hayas aprobado el curso de preparación.";
		$alumno=$_POST['alumno'];
		$qryCurso=sprintf("SELECT cveusuario,curso FROM usuarios WHERE (cveusuario=%s AND tipousuario=3 AND curso=1) limit 1",$alumno);
		$res=mysql_query($qryCurso,conexionLocal());
		if($row = mysql_fetch_array($res)){
			$respuesta=true;
			$mensaje="";
		}
		$arrayJSON = array('respuesta'=>$respuesta, 'mensaje'=>$mensaje);
		print json_encode($arrayJSON);

	}
	function altaAlumnoUsuario(){
		/*AGREGAR ALUMNO A USUARIOS--->
		CONECTAR A SIE OBTENER CONTRASEÑA
		*/
		$respuesta=false;
		$mensaje="El alumno ya es usuario";
		$alumno=$_POST['alumno'];
		$aluPas=alupassword($alumno);
		if($aluPas==false){
			$mensaje="No se encontró numero de control";
			$arrayJSON = array('respuesta'=>$respuesta, 'mensaje'=>$mensaje);
			print json_encode($arrayJSON);
			return;
		}
		/*---->CIFRARLA MD5 */
		$md5pas= "'".md5($aluPas)."'";
		/*insertar en ss bd*/
		$qryaltaAlumno=sprintf("INSERT INTO usuarios(cveusuario,clave,tipousuario)
								VALUES(%s,%s,3)",$alumno,$md5pas);
		$res2 =mysql_query($qryaltaAlumno, conexionLocal());
		
		if(mysql_affected_rows()>0){
			$respuesta 	=true;
			$mensaje="Se ha habilitado al alumno como usuario del sistema";
		}
		$arrayJSON = array('respuesta'=>$respuesta, 'mensaje'=>$mensaje);
			print json_encode($arrayJSON);
	}
	function alupassword($alumno){
		//funcion que obtiene contraseña del alumno
		$cnSIE=conexionBD();
		$qryPassword=sprintf("SELECT ALUPAS FROM DALUMN WHERE ALUCTR=%s",$alumno);
		$res=mysql_query($qryPassword);
		if($row = mysql_fetch_array($res)){
			$contrasena=$row['ALUPAS'];
			//INSERTAR EN BD SS
			return $contrasena;
		}
		return false;		
	}
	function mostrarResultados(){
		$respuesta = true;
		$cn 		= conexionLocal();
		$qryPeriodos	= sprintf("SELECT DISTINCT pdocve_1 FROM solicitudes");
		$res 			= mysql_query($qryPeriodos);
		$ul="";
		while ($row = mysql_fetch_array($res)) {
        	$periodo 			= $row['pdocve_1']; 
        	$cn 				= conexionLocal();
			$qrySolicitudesT 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE pdocve_1 =%s",$periodo);
			$resST 				= mysql_query($qrySolicitudesT);

			$rowST 				= mysql_fetch_array($resST);
			$totalSolicitudes 	= $rowST['TOTAL'];
			$qrySolicitudesAcep 	= sprintf("SELECT COUNT(*) AS TOTALACEP FROM solicitudes WHERE pdocve_1 =%s AND estado = 1",$periodo);
			$resSA 				= mysql_query($qrySolicitudesAcep);
			$rowSA 				= mysql_fetch_array($resSA);
			$totalSolicitudesA 	= $rowSA['TOTALACEP'];
			$qrySolicitudesRech	= sprintf("SELECT COUNT(*) AS TOTALRECH FROM solicitudes WHERE pdocve_1 =%s AND estado = 2",$periodo);
			$resSR 				= mysql_query($qrySolicitudesRech);
			$rowSR 				= mysql_fetch_array($resSR);
			$totalSolicitudesR 	= $rowSR['TOTALRECH'];
			$qryCartaTerminacion = sprintf("SELECT COUNT(*) AS TOTALCT FROM documentos D 
												INNER JOIN  expedientes E ON D.cveexpediente_1 = E.cveexpediente 
												INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud WHERE D.tipoDoc = 'cT' AND S.pdocve_1 = %s",$periodo);
        	$resTF				=  mysql_query($qryCartaTerminacion);
        	$rowTF 				=  mysql_fetch_array($resTF);
        	$totalTramiteFin	=  $rowTF['TOTALCT'];
        	$ul .= '<li>
  					<div class="collapsible-header" id="badgedatos"><i class="material-icons">label</i><span class="left">'.$periodo.'</span></div>
  						<div class="collapsible-body">
  							<div class="container" style="overflow: scroll; overflow-x: hidden; height: 400px;">	
  								<table  class="bordered">
  									<tr>
  										<td>
  											<i class="material-icons">playlist_add_check</i>
	  						         		Solicitudes Iniciales:		'.$totalSolicitudes.'
		  						         </td>
		  						         <td>
		  						         	<i class="material-icons">done</i>
		  						         	Solicitudes Aceptadas:		'.$totalSolicitudesA.'
		  						   		 </td>
		  						         <td>
		  						         	<i class="material-icons">clear</i>
		  						         	Solicitudes Rechazadas: 	'.$totalSolicitudesR.'
		  						    	</td>
		  						    		<td>
		  						    		<i class="material-icons">done_all</i>
		  						    		Trámites Finalizados:		'.$totalTramiteFin.'
	  									</td>  									
  								</table><br>
  								<table>
		  							<thead>
		  							  	<th>No. de control</th>
		  								<th>Nombre</th>
		  								<th>1er. Reporte</th>
		  								<th>2do. Reporte</th>
		  								<th>3er. Reporte</th>
		  								<th>Calificación Final</th>
		  							</thead>';

				$qryAlumnos 	= sprintf("SELECT * FROM solicitudes S  
											INNER JOIN expedientes E ON S.cvesolicitud = E.cvesolicitud
											WHERE pdocve_1=%s",$periodo);
				$resAlumnos 	= mysql_query($qryAlumnos);
				while($rowA = mysql_fetch_array($resAlumnos)){
					$ul	.=  '<tr><td>'.$rowA['cveusuario_1'].'</td>';
					
					//CONSULTA PARA SACAR EL NOMBRE DE LOS ALUMNOS
					$qryDatos = sprintf("SELECT * FROM DALUMN WHERE ALUCTR = %s", $rowA['cveusuario_1']);
					$resDatos = mysql_query($qryDatos, conexionBD());
					$rowDatos = mysql_fetch_array($resDatos);
					$ul	.=  '<td>'.$rowDatos['ALUNOM']." ".$rowDatos['ALUAPP']." ".$rowDatos['ALUAPM'].'</td>';
					$cn 		= conexionLocal();

					//CONSULTA PARA TOMAR LA CALIFICACION DEL REPORTE 1  
					$qryRU	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 1 ",$rowA['reporteuno']);
					$resRU 	= mysql_query($qryRU);
					if($resRU == true){
						$rowRU 	= mysql_fetch_array($resRU);
						$ul	.=  '<td>'.$rowRU['calificacion'].'</td>';
					}else{
						$ul	.=  '<td> 0 </td>';
					}
					//REPORTE 2 
					$qryRD	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 2 ",$rowA['reportedos']);
					$resRD 	= mysql_query($qryRD);
					if($resRD == true){
						$rowRD 	= mysql_fetch_array($resRD);
						$ul	.=  '<td>'.$rowRD['calificacion'].'</td>';
					}else{
						$ul	.=  '<td> 0 </td>';
					}
					
					//REPORTE 3
					$qryRT	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 3 ",$rowA['reportetres']);
					$resRT 	= mysql_query($qryRT);
					if($resRT == true){
						$rowRT 	= mysql_fetch_array($resRT);
						$ul	.=  '<td>'.$rowRT['calificacion'].'</td></tr>';
					}else{
						$ul	.=  '<td> 0 </td></tr>';
					}
					/*CARTA LIBERAACION
					$qryRT	= sprintf("SELECT *  FROM documentos WHERE cvereporte = %s AND noreporte = 3 ",$rowA['reportetres']);
					$resRT 	= mysql_query($qryRT);
					if($resRT == true){
						$rowRT 	= mysql_fetch_array($resRT);
						$ul	.=  '<td>'.$rowRT['calificacion'].'</td></tr>';
					}else{
						$ul	.=  '<td> 0 </td></tr>';
					}*/
				}

				$ul .='			</table>
  							</div>
  						</div>
  					</div>
  				</li><br>';
         }
		$arrayJSON = array('respuesta' => $respuesta, 'ul'=> $ul);
		print json_encode($arrayJSON);
	}

	function guardarNuevaClave(){
		$cn = conexionLocal();
		$respuesta = false;
		$claveactual 	= md5($_POST["claveActual"]);
		$nuevaclave 	= "'".md5($_POST['nuevaClave'])."'";;
		$user 			= "'".$_POST['user']."'";
		$qryUsuario 	= sprintf("SELECT * FROM usuarios WHERE cveusuario =%s",$user);
		$res 			= mysql_query($qryUsuario);
		$row 			= mysql_fetch_array($res);
		if($row['clave']==$claveactual){
			if(mysql_affected_rows()>0){
				$qryUpdate 		= sprintf("UPDATE usuarios SET clave = %s WHERE cveusuario = %s",$nuevaclave, $user);
				$resU 			= mysql_query($qryUpdate);
				$respuesta 		= true;
			}
		}
		$arrayJSON = array('respuesta' => $respuesta);
		print json_encode($arrayJSON);
	}
	function mostrarResultadosFiltro(){
		$opcion 	= $_POST['opcion'];
		$filtro 	= $_POST['filtro']; 
		$respuesta 	= true;
		$cn 		= conexionLocal();
		$qryPeriodos	= sprintf("SELECT DISTINCT pdocve_1 FROM solicitudes");
		$res 			= mysql_query($qryPeriodos);
		$ul="";
		while ($row = mysql_fetch_array($res)) {
        	$periodo 			= $row['pdocve_1']; 
        	$cn 				= conexionLocal();
			$qrySolicitudesT 	= sprintf("SELECT COUNT(*) AS TOTAL FROM solicitudes WHERE pdocve_1 =%s",$periodo);
			$resST 				= mysql_query($qrySolicitudesT);

			$rowST 				= mysql_fetch_array($resST);
			$totalSolicitudes 	= $rowST['TOTAL'];
			$qrySolicitudesAcep 	= sprintf("SELECT COUNT(*) AS TOTALACEP FROM solicitudes WHERE pdocve_1 =%s AND estado = 1",$periodo);
			$resSA 				= mysql_query($qrySolicitudesAcep);
			$rowSA 				= mysql_fetch_array($resSA);
			$totalSolicitudesA 	= $rowSA['TOTALACEP'];
			$qrySolicitudesRech	= sprintf("SELECT COUNT(*) AS TOTALRECH FROM solicitudes WHERE pdocve_1 =%s AND estado = 2",$periodo);
			$resSR 				= mysql_query($qrySolicitudesRech);
			$rowSR 				= mysql_fetch_array($resSR);
			$totalSolicitudesR 	= $rowSR['TOTALRECH'];
			$qryCartaTerminacion = sprintf("SELECT COUNT(*) AS TOTALCT FROM documentos D 
												INNER JOIN  expedientes E ON D.cveexpediente_1 = E.cveexpediente 
												INNER JOIN solicitudes S ON S.cvesolicitud = E.cvesolicitud WHERE D.tipoDoc = 'cT' AND S.pdocve_1 = %s",$periodo);
        	$resTF				=  mysql_query($qryCartaTerminacion);
        	$rowTF 				=  mysql_fetch_array($resTF);
        	$totalTramiteFin	=  $rowTF['TOTALCT'];
        	$ul .= '<li>
  					<div class="collapsible-header" id="badgedatos"><i class="material-icons">label</i><span class="left">'.$periodo.'</span></div>
  						<div class="collapsible-body">
  							<div class="container" style="overflow: scroll; overflow-x: hidden; height: 400px;">	
  								<table  class="bordered">
  									<tr>
  										<td>
  											<i class="material-icons">playlist_add_check</i>
	  						         		Solicitudes Iniciales:		'.$totalSolicitudes.'
		  						         </td>
		  						         <td>
		  						         	<i class="material-icons">done</i>
		  						         	Solicitudes Aceptadas:		'.$totalSolicitudesA.'
		  						   		 </td>
		  						         <td>
		  						         	<i class="material-icons">clear</i>
		  						         	Solicitudes Rechazadas: 	'.$totalSolicitudesR.'
		  						    	</td>
		  						    		<td>
		  						    		<i class="material-icons">done_all</i>
		  						    		Trámites Finalizados:		'.$totalTramiteFin.'
	  									</td>  									
  								</table><br>
  								<table>
		  							<thead>
		  							  	<th>No. de control</th>
		  								<th>Nombre</th>
		  								<th>1er. Reporte</th>
		  								<th>2do. Reporte</th>
		  								<th>3er. Reporte</th>
		  								<th>Calificación Final</th>
		  							</thead>';
		  		if($opcion == 1){ // 1 ES EL VALOR DE EVALUADO EN EL SELECT 
					$qryAlumnos 	= sprintf("SELECT * FROM solicitudes S  
												INNER JOIN expedientes E ON S.cvesolicitud = E.cvesolicitud
												INNER JOIN reportes R on R.cveexpediente_1 = E.cveexpediente
												WHERE S.pdocve_1=%s AND R.noreporte = %s",$periodo,$filtro);
		  		}else{// 2 ES EL VALOR DE NO EVALUADO EN EL SELECT 
		  			$qryNI 		 	= sprintf("SELECT S.cveusuario_1 FROM solicitudes S  
												INNER JOIN expedientes E ON S.cvesolicitud = E.cvesolicitud
												INNER JOIN reportes R on R.cveexpediente_1 = E.cveexpediente
												WHERE S.pdocve_1=%s AND R.noreporte = %s",$periodo,$filtro);
		  			$resNI		= mysql_query($qryNI);
		  			$NI 		= Array();
		  			while($rowNI = mysql_fetch_array($resNI)){
		  				$NI[] = $rowNI['cveusuario_1'];
		  			}
		  			$ListaNI = implode(",",$NI);
		  			if($ListaNI == ""){
		  				$qryAlumnos 	= sprintf("SELECT * FROM solicitudes S  
												INNER JOIN expedientes E ON S.cvesolicitud = E.cvesolicitud
												WHERE S.pdocve_1=%s ",$periodo);
		  			}else{
		  				$qryAlumnos 	= sprintf("SELECT * FROM solicitudes S  
												INNER JOIN expedientes E ON S.cvesolicitud = E.cvesolicitud
												WHERE S.pdocve_1=%s AND S.cveusuario_1 NOT IN ( %s )",$periodo,$ListaNI);
		  			}

		  		}
				$resAlumnos 	= mysql_query($qryAlumnos);
				while($rowA = mysql_fetch_array($resAlumnos)){
					$ul	.=  '<tr><td>'.$rowA['cveusuario_1'].'</td>';
					
					//CONSULTA PARA SACAR EL NOMBRE DE LOS ALUMNOS
					$qryDatos = sprintf("SELECT * FROM DALUMN WHERE ALUCTR = %s", $rowA['cveusuario_1']);
					$resDatos = mysql_query($qryDatos, conexionBD());
					$rowDatos = mysql_fetch_array($resDatos);
					$ul	.=  '<td>'.$rowDatos['ALUNOM']." ".$rowDatos['ALUAPP']." ".$rowDatos['ALUAPM'].'</td>';
					$cn 		= conexionLocal();
					//CONSULTA PARA TOMAR LA CALIFICACION DEL REPORTE 1  
					$qryRU	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 1 ",$rowA['reporteuno']);
					$resRU 	= mysql_query($qryRU);
					if($resRU == true){
						$rowRU 	= mysql_fetch_array($resRU);
						$ul	.=  '<td>'.$rowRU['calificacion'].'</td>';
					}else{
						$ul	.=  '<td> 0 </td>';
					}
					
					//REPORTE 2 
					$qryRD	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 2 ",$rowA['reportedos']);
					$resRD 	= mysql_query($qryRD);
					if($resRD == true){
						$rowRD 	= mysql_fetch_array($resRD);
						$ul	.=  '<td>'.$rowRD['calificacion'].'</td>';
					}else{
						$ul	.=  '<td> 0 </td>';
					}
					
					//REPORTE 3
					$qryRT	= sprintf("SELECT *  FROM reportes WHERE cvereporte = %s AND noreporte = 3 ",$rowA['reportetres']);
					$resRT 	= mysql_query($qryRT);
					if($resRT == true){
						$rowRT 	= mysql_fetch_array($resRT);
						$ul	.=  '<td>'.$rowRT['calificacion'].'</td></tr>';
					}else{
						$ul	.=  '<td> 0 </td></tr>';
					}
					/*CARTA LIBERAACION
					$qryRT	= sprintf("SELECT *  FROM documentos WHERE cvereporte = %s AND noreporte = 3 ",$rowA['reportetres']);
					$resRT 	= mysql_query($qryRT);
					if($resRT == true){
						$rowRT 	= mysql_fetch_array($resRT);
						$ul	.=  '<td>'.$rowRT['calificacion'].'</td></tr>';
					}else{
						$ul	.=  '<td> 0 </td></tr>';
					}*/
				}

				$ul .='			</table>
  							</div>
  						</div>
  					</div>
  				</li><br>';
         }
		$arrayJSON = array('respuesta' => $respuesta, 'ul'=> $ul);
		print json_encode($arrayJSON);
	}
	function calificarReporte(){
		$respuesta=false;
		$mensaje="No se ha encontrado el reporte";
		$cn=conexionLocal();
		$cvereporte=$_POST["cvereporte"];
		$calificacionVinc=$_POST["calificacion"];
		$observaciones="'".$_POST["observaciones"]."'";
		$estadorep="'".$_POST["estado"]."'";
		$qryreporte=sprintf("UPDATE reportes 
							 SET calificacionV = %d, observaciones=%s, estado=%s 
							 WHERE cvereporte = %s",$calificacionVinc,$observaciones,$estadorep,$cvereporte);
		mysql_query($qryreporte);
		if(mysql_affected_rows()>0){
			$respuesta=true;
			$mensaje="Se ha revisado el reporte";
		}
		$arrayJSON = array('respuesta'=>$respuesta, 'mensaje'=>$mensaje);
			print json_encode($arrayJSON);
		}

	function aceptarDocumentos(){
			$cvedoc 			= $_POST['doc'];
		    $cn 				= conexionLocal();
			$qryDoc 			= sprintf("SELECT * FROM documentos WHERE cvedocumento =%s",$cvedoc);
			$resDoc 			= mysql_query($qryDoc);
			$rowDoc				= mysql_fetch_array($resDoc);
			$cveExpediente 		= $rowDoc['cveexpediente_1'];
			$estado 			= 1;
			$qryUpdate 			= sprintf("UPDATE documentos SET revisado = %s WHERE cvedocumento =%s",$estado,$cvedoc);
			$resUpdate 			= mysql_query($qryUpdate);
			$respuesta 			= false;
			if(mysql_affected_rows()>0){
				$respuesta = true;
			}
			$arrayJSON 	= array('respuesta' => $respuesta, 'cveExpediente' => $cveExpediente);
			print json_encode($arrayJSON);

	}
	function guardarObservaciones(){
		$doc 	= $_POST['doc']; 
		$obs 	= "'".$_POST['obs']."'";
		$cn  	= conexionLocal();
		$qryObs = sprintf("UPDATE documentos SET observaciones =%s WHERE cvedocumento=%s",$obs, $doc);
		$resObs = mysql_query($qryObs);
		$estado = '2';
		$qryRech = sprintf("UPDATE documentos SET revisado =%s WHERE cvedocumento=%s",$estado, $doc);
		$resRech = mysql_query($qryRech);
		$respuesta =  false;
		if(mysql_affected_rows()>0){
			$respuesta = true;
		}
		$arrayJSON 	= array('respuesta' => $respuesta);
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
		case 'verDetallesSolicitud':
			verDetallesSolicitud();
			break;
		case 'obtenerTarjetaAlm':
			obtenerTarjetaAlm();
			break;
		case 'registrarEmpresa':
			registrarEmpresa();
			break;
		case 'registrarPrograma':
			registrarPrograma();
			break;
		case 'llenaDepProgramas':
			llenaDepProgramas();
			break;
		case 'llenaDptoProgramas':
			llenaDptoProgramas();
			break;
		case 'llenaActProg':
			llenaActProg();
			break;
		case 'detallesSolicitud':
			detallesSolicitud();
			break;
		case 'tablaprogramas':
			tablaprogramas();
			break;
		case 'documentosExpediente':
			documentosExpediente();
			break;
		case 'reportesExpediente':
			reportesExpediente();
			break;
		case 'modificarSolicitud':
			modificarSolicitud();
			break;
		case 'aceptarPrograma':
			aceptarPrograma();
			break;
		case 'rechazarPrograma':
			rechazarPrograma();
			break;
		case 'detallesPrograma':
			detallesPrograma();
			break;
		case 'modificarPrograma':
			modificarPrograma();
			break;
		case 'guardarPrograma':
			guardarPrograma();
			break;
		case 'muestraAlumnos':
			muestraAlumnos();
			break;
		case 'consultaFiltro':
			consultaFiltro();
			break;
		case 'llenaTipoProg':
			llenaTipoProg();
			break;
		case 'llenaCarreraPref':
			llenaCarreraPref();
			break;
		case 'consultaFiltroSolicitudes':
			consultaFiltroSolicitudes();
			break;
		case 'consultaPeriodos':
			consultaPeriodos();
			break;
		case 'filtrarAlumnos':
			filtrarAlumnos();
			break;
		case 'filtrarSolicitudes':
			filtrarSolicitudes();
			break;
		case 'filtrarProgramas':
			filtrarProgramas();
			break;
		case 'agregarDepartamento':
			agregarDepartamento();
			break;
		case 'registroAlumnos':
			registroAlumnos();
			break;
		case 'programasAsignacion':
			programasAsignacion();
			break;
		case 'asignarprogramaAl':
			asignarprogramaAl();
			break;
		case 'altaAlumnoUsuario':
			altaAlumnoUsuario();
			break;
		case  'mostrarResultados':
			mostrarResultados();
			break;
		case 'guardarNuevaClave':
			guardarNuevaClave();
			break;
		case 'totRegistroAlumnos':
			totRegistroAlumnos();# code...
			break;
		case 'registroAlumnos':
			registroAlumnos();
			break;
		case 'mostrarResultadosFiltro':
			mostrarResultadosFiltro();
			break;
		case 'tomoCursoMoodle':
			tomoCursoMoodle();
			break;
		case 'calificarReporte':
			calificarReporte();
			break;
		case 'aceptarDocumentos':
			aceptarDocumentos();
			break;
		case 'guardarObservaciones':
			guardarObservaciones();
		default:
		# code...
		break;
	}
	?>