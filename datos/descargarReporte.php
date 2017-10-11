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
	$numreporte = $rowR['noreporte'];
	$pdf->Text(70,69,$horas);
	$pdf->Text(95,72,$numreporte);
	$pdf->Text(177,95,$calDc1);
	$pdf->Text(177,102,$calDc2);
	$pdf->Text(177,109,$calDc3);
	$pdf->Text(177,116,$calDc4);
	$pdf->Text(177,123,$calDc5);
	$pdf->Text(177,130,$calDc6);
	$pdf->Text(177,136,$calDc7);
	$pdf->Text(177,143,$calDc8);
	$pdf->Text(177,150,$calDc9);
	$pdf->Text(177,157,$calDc10);
	$pdf->Text(177,163,$calVc1);
	$pdf->Text(177,170,$calVc2);
	
	$calTotal = ($calDc1+$calDc2+$calDc3+$calDc4+$calDc5+$calDc6+$calDc7+$calDc8+$calDc9+$calDc10+$calVc1+$calVc2);
	$pdf->Text(177,177,$calTotal);
	$pdf->Text(50,188,$obs);

	//DATOS DEL EXPEDIENTE
	$qryvalidaE	= sprintf("SELECT * FROM expedientes WHERE cveexpediente =%s",$expediente);
	$resE		= mysql_query($qryvalidaE);
	$rowE 		= mysql_fetch_array($resE);
	$cveusuario	= $rowE["cveusuario_1"];
	$cveprograma = $rowE["cveprograma_1"];
	$pdf->Text(150,62,$cveusuario);

	//DATOS DEL PROGRAMA 
	$qryprograma = sprintf("SELECT * FROM programas WHERE cveprograma = %s",$cveprograma);
	$resP 		 = mysql_query($qryprograma);
	$rowP 		 = mysql_fetch_array($resP);
	$responsable 	= $rowP["nomresp"];	
	$puesto 		= $rowP["puestoresp"];		 
	$pdf->Text(65,211,$responsable);
	$pdf->Text(90,215,$puesto);



	//HORAS ACUMULADAS
	$qryvalidaTH 	= sprintf("SELECT SUM(horas) AS Total_Horas FROM reportes WHERE cveexpediente_1=%s", $expediente);
	switch ($numreporte) {
		case '1':
		$qryvalidaTH 	= sprintf("SELECT horas AS Total_Horas FROM reportes where noreporte=1");
			break;
		case '2':
		$qryvalidaTH 	= sprintf("SELECT SUM(horas) AS Total_Horas FROM reportes WHERE cveexpediente_1=%s AND noreporte!=3", $expediente);
			break;
		case '3':
		$qryvalidaTH 	= sprintf("SELECT SUM(horas) AS Total_Horas FROM reportes WHERE cveexpediente_1=%s", $expediente);
		$pdf->Text(119,72.5,'x');
			break;
	}
	$resTH			= mysql_query($qryvalidaTH);
	$rowTH 			= mysql_fetch_array($resTH);
	$Total_Horas 	= $rowTH['Total_Horas'];
	$pdf->Text(140,69,$Total_Horas);
	
	
	//DATOS DEL ALUMNO
	$cn			= conexionBD();
	$qryvalidaA	= sprintf("SELECT CONCAT(A.ALUAPP,' ', A.ALUAPM,' ',A.ALUNOM) AS NOMBRE, D.CARCVE, C.CARNCO FROM DALUMN A INNER JOIN DCALUM D ON A.ALUCTR = D.ALUCTR INNER JOIN DCARRE C ON C.CARCVE = D.CARCVE WHERE A.ALUCTR = %s",$cveusuario);
	$resA		= mysql_query($qryvalidaA);
	$rowA 		= mysql_fetch_array($resA);
	$nombre		=	$rowA["NOMBRE"];
	$nombreC	= $rowA["CARNCO"];
	$pdf->Text(90,58,$nombre);
	$pdf->Text(55,61.5,$nombreC);

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

	$pdf->Text(75,65,$meses);

	//DATOS ESPECIFICOS DEL PERIODO
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
	$pdf->Text(95,65,$año);
	$finpdo		= $año."-".$mes."-".$dia;
	$pdf->Output();
?>