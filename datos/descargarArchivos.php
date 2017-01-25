<?php
require('fpdf.php');
 	
 	function conexionBD(){
	$cn= mysql_connect("localhost","root","");
	mysql_select_db("sieapibd");
	return $cn;
	}
	function conexionLocal(){
	$cn = mysql_connect("localhost","root","");
	mysql_select_db("serviciosocial");
	return $cn;
	}
	$solicitud  = "'".$_GET["solicitud"]."'";
	$cn 		= conexionLocal();
	$qryvalida	= sprintf("SELECT * from solicitudes where cvesolicitud =%s",$solicitud);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$cveusuario	= $row["cveusuario_1"];
	$cn		= conexionBD();
	$qryvalida	= sprintf("select * from DALUMN where ALUCTR = %s",$cveusuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$pdf = new FPDF();
	$pdf->SetFont('Arial','',9);
	$pdf->AddPage();
	$pdf->SetMargins(0, 0, 0);
	$pdf->SetXY(0, 0);
	$pdf->Image('solicitudSS.jpg',10,10,0);
	$nombre		=	$row["ALUNOM"];
	$apellidopa	=	$row["ALUAPP"];
	$apellidoma	=	$row["ALUAPM"];
	$tel		=	$row["ALUTE1"];
	$calle		=	$row["ALUCLL"];
	$num		=	$row["ALUNUM"];
	$colonia	=	$row["ALUCOL"];
	$numcontrol	=	$row["ALUCTR"];
	$sexo		=	$row["ALUSEX"];
	$email		=	$row["ALUMAI"];
	if($sexo == 2){
		$sexo = "M";
	}else{
		$sexo = "H";
	}
	$pdf->Text(70,79,$apellidopa);
	$pdf->Text(100,79,$apellidoma);
	$pdf->Text(130,79,$nombre);
	$pdf->Text(48,85,$sexo);
	$pdf->Text(77,85,$tel);
	$pdf->Text(113,85,$calle);
	$pdf->Text(143,85,$num);
	$pdf->Text(152,85,$colonia);
	$pdf->Text(58,103.5,$numcontrol);
	$cn			= conexionBD();
	$qryvalida	= sprintf("select CARCVE,CALNPE from DCALUM where ALUCTR = %s",$cveusuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$cve 		= $row["CARCVE"];
	$periodo	= $row["CALNPE"];
	$qryvalida	= sprintf("select PARFOL1 from DPARAM where PARCVE= 'PRDO'");
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$periodoAct	= $row["PARFOL1"];
	$meses		= substr($periodoAct, 3,1);
	if($meses==1){
		$meses = " ENE - JUN";
	} elseif($meses==3){
		$meses = "AGO - DIC";
	}
	$qryvalida	= sprintf("select PDOINI from DPERIO where PDOCVE=%s",$periodoAct);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$iniciopdo	= $row["PDOINI"];
	$dia 		= substr($iniciopdo, 8,2);
	$mes 		= substr($iniciopdo, 5,2)+6;
	$año 		= substr($iniciopdo, 0,4);
	if($mes>12){
		$mes= $mes-12;
		$año = $año+1;
		if($mes<10){
			$mes='0'.$mes;
		}
	}

	$finpdo		= $año."-".$mes."-".$dia;
	$pdf->Text(97,166.5,$iniciopdo);
	$pdf->Text(153,166.5,$finpdo);
	$pdf->Text(47,111,$meses);
	$qryvalida	= sprintf("select CARNOM from DCARRE where CARCVE = %s",$cve);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombre		= $row["CARNOM"];
	$pdf->Text(98,103.5,$nombre);
	$pdf->Text(95,111,$periodo);
	$pdf->Text(120,111,$email);
	//$pdf->Image('solicitudSS.jpg',20,20,0);
	$cn			= conexionLocal();
	$qryvalida	= sprintf("select * from solicitudes where cveusuario_1 = %s",$cveusuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$programa	= $row["cveprograma_1"];
	$estado		= $row["estado"];
	$motivo		= $row["motivo"];	
	$observaciones		= $row["observaciones"];
	$pdf->Text(104,224,$motivo);
	$pdf->Text(65,231,$observaciones);
	$qryvalida	= sprintf("select * from programas where cveprograma = %s",$programa);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombreprog	= $row["nombre"];
	$modalidad	= $row["modalidad"];
	$desact	= $row["tipoactdes"];
	$cvedependencia = $row["cvedependencia"];
	$tipoprog	= $row["tipoprog"]."";
	$cvedepartamento = $row["cvedepartamento"];
	$qryvalida	= sprintf("select * from departamentos where cvedependencia = %d and cvedepartamento=%d",$cvedependencia,$cvedepartamento);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$puesto		= $row["puesto"];
	$departamento = $row["nomdepartamento"];
	$pdf->Text(50,152,$puesto);
	$pdf->Text(58,137,$departamento);
	$qryvalida	= sprintf("select * from dependencias where cvedependencia = %s",$cvedependencia);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nomdependencia = $row["nomdependencia"];
	$titular		= $row["titular"];
	if ($tipoprog=="Educacion para adultos") {
		$pdf->Text(28,193,"X");
		
	}elseif ($tipoprog=="Contingencia"){
		$pdf->Text(28,197,"X");
		
	}elseif ($tipoprog=="Apoyo a la salud"){
		$pdf->Text(28,201,"X");
		
	}elseif ($tipoprog=="Establecido por el ITC"){
		$pdf->Text(28,205.5,"X");
		
	}elseif ($tipoprog=="Gubernamental"){
		$pdf->Text(73.5,193,"X");
		
	}elseif ($tipoprog=="Actividades deportivas, culturales y civicas"){
		$pdf->Text(73.5,197,"X");
		
	}elseif ($tipoprog=="Cuidado al medio ambiente y desarrollo sustentable"){
		$pdf->Text(73.5,201,"X");
		
	}elseif ($tipoprog=="Otros") {
		$pdf->Text(73.5,205.5,"X");
		
	}

	if($estado == 1){
		$pdf ->Text(60,224,"X");
	}elseif($estado == 2){
		$pdf ->Text(75,224,"X");
	}

	$pdf->Text(70,159,$nombreprog);
	$pdf->Text(75,144,$titular);
	$pdf->Text(70,129,$nomdependencia);
	$pdf->Text(53,166.5,$modalidad);
	/*$inicio = 0;
	$cordenadaY= 152;
	if(strlen($desact)>90){
		while ($inicio<strlen($desact)) {
			$renglon= substr($desact, $inicio,90);
			$pdf->Text(38,$cordenadaY,$renglon);
			$inicio=$inicio+90;
			$cordenadaY=$cordenadaY+6;
		}

	}*/
	//$pdf->Text(38,152,$desact);
	$pdf->Output();

?>