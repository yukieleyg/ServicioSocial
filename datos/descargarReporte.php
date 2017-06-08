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
	$pdf = new FPDF();
	$pdf->SetFont('Arial','',9);
	$pdf->AddPage();
	$pdf->SetMargins(0, 0, 0);
	$pdf->SetXY(0, 0);
	$pdf->Image('reporte.jpg',10,10,0);
	$reporte 	= "'".$_GET["reporte"]."'";

	//DATOS DEL REPORTE
	$cn 		= conexionLocal();
	$qryvalidaR	= sprintf("SELECT * FROM reportes WHERE cvereporte =%s",$reporte);
	$resR		= mysql_query($qryvalidaR);
	$rowR 		= mysql_fetch_array($resR);
	$expediente = $rowR['cveexpediente_1'];
	$horas 		= $rowR['horas'];
	$calDc1		= $rowR['calDc1']; 
	$calDc2		= $rowR['calDc2'];
	$calDc3		= $rowR['calDc3'];
	$calDc4		= $rowR['calDc4']; 
	$calDc5		= $rowR['calDc5']; 
	$calDc6		= $rowR['calDc6']; 
	$calDc7		= $rowR['calDc7']; 
	$calDc8		= $rowR['calDc8']; 
	$calDc9		= $rowR['calDc9']; 
	$calDc10	= $rowR['calDc10']; 
	$calVc1		= $rowR['calVc1']; 
	$calVc2		= $rowR['calVc2'];
	$obs		= $rowR['observaciones'];




	//DATOS DEL EXPEDIENTE
	$qryvalidaE	= sprintf("SELECT * FROM expedientes WHERE cveexpediente =%s",$expediente);
	$resE		= mysql_query($qryvalidaE);
	$rowE 		= mysql_fetch_array($resE);
	$cveusuario	= $rowE["cveusuario_1"];

	//DATOS DEL ALUMNO
	$cn			= conexionBD();
	$qryvalidaA	= sprintf("SELECT * FROM DALUMN WHERE ALUCTR = %s",$cveusuario);
	$resA		= mysql_query($qryvalidaA);
	$rowA 		= mysql_fetch_array($resA);
	$nombre		=	$rowA["ALUNOM"];
	$apellidopa	=	$rowA["ALUAPP"];
	$apellidoma	=	$rowA["ALUAPM"];
	$pdf->Text(90,58,$nombre);
	$pdf->Text(115,58,$apellidopa);
	$pdf->Text(125,58,$apellidoma);


	//DATOS CARRERA
	$qryvalidaCa	= sprintf("SELECT CARCVE,CALNPE FROM DCALUM WHERE ALUCTR = %s",$cveusuario);
	$resCa		= mysql_query($qryvalidaCa);
	$rowCa 		= mysql_fetch_array($resCa);
	$cve 		= $rowCa["CARCVE"];
	$periodo	= $rowCa["CALNPE"];
	$pdf->Text(150,62,$cveusuario);


	$qryvalida	= sprintf("SELECT CARNCO FROM DCARRE WHERE CARCVE = %s",$cve);
	$res		= mysql_query($qryvalida);
	$row 		= mysql_fetch_array($res);
	$nombreC	= $row["CARNCO"];
	$pdf->Text(55,62,$nombreC);

	//DATOS PERIODO
	$qryvalidaP	= sprintf("SELECT PARFOL1 FROM DPARAM WHERE PARCVE= 'PRDO'");
	$resP		= mysql_query($qryvalidaP);
	$rowP 		= mysql_fetch_array($resP);
	$periodoAct	= $rowP["PARFOL1"];
	$meses		= substr($periodoAct, 3,1);
	if($meses==1){
		$meses = " ENE - JUN";
	} elseif($meses==3){
		$meses = "AGO - DIC";
	}
	$qryvalida	= sprintf("SELECT PDOINI FROM DPERIO WHERE PDOCVE=%s",$periodoAct);
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
	$pdf->Output();
?>