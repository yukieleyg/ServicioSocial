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
	$pdf->Image('solicitudSS.jpg',20,20,0);
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
		$sexo = "F";
	}else{
		$sexo = "M";
	}
	$pdf->Text(70,75,$apellidopa);
	$pdf->Text(100,75,$apellidoma);
	$pdf->Text(130,75,$nombre);
	$pdf->Text(48,84,$sexo);
	$pdf->Text(67,84,$tel);
	$pdf->Text(95,84,$calle);
	$pdf->Text(120,84,$num);
	$pdf->Text(130,84,$colonia);
	$pdf->Text(60,97,$numcontrol);
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
		$meses = " ENERO - JUNIO";
	} elseif($meses==3){
		$meses = "AGOSTO-DICIEMBRE";
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
	$pdf->Text(97,142,$iniciopdo);
	$pdf->Text(150,142,$finpdo);
	$pdf->Text(47,103.5,$meses);
	$qryvalida	= sprintf("select CARNOM from DCARRE where CARCVE = %s",$cve);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombre		= $row["CARNOM"];
	$pdf->Text(93,97,$nombre);
	$pdf->Text(100,103.5,$periodo);
	$pdf->Text(120,103.5,$email);
	//$pdf->Image('solicitudSS.jpg',20,20,0);
	$cn			= conexionLocal();
	$qryvalida	= sprintf("select * from solicitudes where cveusuario_1 = %s",$cveusuario);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$programa	= $row["cveprograma_1"];
	$estado		= $row["estado"];
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
	$pdf->Text(50,129.5,$puesto);
	$qryvalida	= sprintf("select * from dependencias where cvedependencia = %s",$cvedependencia);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nomdependencia = $row["nomdependencia"];
	$titular		= $row["titular"];
	if($tipoprog=="Otros"){
		$pdf->Text(37,196,"X");
	}elseif ($tipoprog=="Educacion para adultos") {
		$pdf->Text(37,182,"X");
		
	}elseif ($tipoprog=="Actividades Deportivas") {
		$pdf->Text(37,189,"X");
		
	}elseif ($tipoprog=="Desarrollo de comunidad") {
		$pdf->Text(97,182,"X");
		
	}elseif ($tipoprog=="Actividades culturales") {
		$pdf->Text(97,189,"X");
		
	}
	if($estado == 1){
		$pdf ->Text(59,208,"X");
	}else{
		$pdf ->Text(72.5,208,"X");
	}

	$pdf->Text(70,136,$nombreprog);
	$pdf->Text(70,123,$titular);
	$pdf->Text(70,116.5,$nomdependencia);
	$pdf->Text(55,142,$modalidad);
	$inicio = 0;
	$cordenadaY= 152;
	if(strlen($desact)>90){
		while ($inicio<strlen($desact)) {
			$renglon= substr($desact, $inicio,90);
			$pdf->Text(38,$cordenadaY,$renglon);
			$inicio=$inicio+90;
			$cordenadaY=$cordenadaY+6;
		}

	}
	//$pdf->Text(38,152,$desact);
	$pdf->Output();

?>