<?php 
require_once('conexion.php');
function cargarcsv(){
	# Open the File.
	$ruta= $_POST['ruta'];
    if (($handle = fopen($ruta, "r")) !== FALSE) {
        # Set the parent multidimensional array key to 0.
        $nn = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            # Count the total keys in the row.
            $c = count($data);
            # Populate the multidimensional array.
            for ($x=0;$x<$c;$x++)
            {
                $csvarray[$nn][$x] = $data[$x];
            }
            $nn++;
        }
        # Close the File.
        fclose($handle);
    }
    # Print the contents of the multidimensional array.
    $correosaprobados	=obtenerCorreos($csvarray,100);//solo los que tienen 100
    $correosTomaroncurso=obtenerCorreos($csvarray,0);//0 para que traiga todos
    print obtenerAlumnos($correosTomaroncurso);
    registrarAlumnos($correosaprobados);

}
function obtenerAlumnos($correos){
	$respuesta=false;
	$listacorreos=strtoupper(separacomas($correos));
	//echo $listacorreos;
	$cn=conexionBD();
	$qrydatosalm= sprintf("SELECT aluctr,concat(aluapp,' ',aluapm,' ',alunom) as nombre, UPPER(alumai) as correo
							FROM dalumn
							WHERE alumai in (%s)",$listacorreos);
	$res=mysql_query($qrydatosalm);
	$arreglo=Array();
	while($row=mysql_fetch_assoc($res)){

		    $nc=$row["aluctr"];
			$nom=$row["nombre"];
			$correo=$row["correo"];
			$respuesta=true;
			//eliminar de lista de correos original
			$listacorreos=str_replace('"'.$correo.'"',"",$listacorreos);
			$arregloEncontrados[]=array('ncontrol'=>$nc,'nombre'=>$nom,'correo'=>$correo);

	}
    $pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
    preg_match_all($pattern, $listacorreos, $noencontrados);
	$arrayJSON = array('respuesta'=>$respuesta,'alumnos'=>$arregloEncontrados,'noencontrados'=>$noencontrados[0]);
	//print json_encode($arrayJSON); 
	return json_encode($arrayJSON); 
}
function separacomas($correos){
	$prefix=$listacorreos='';
	foreach ($correos as $key => $value) {
		$listacorreos.=$prefix .'"'.$correos[$key]['correo'].'"';
		$prefix=", ";	
	}
	return $listacorreos;
}

function registrarAlumnos($correos){
	$listacorreos=separacomas($correos);

	$qrymatchemails = sprintf("INSERT INTO usuarios (cveusuario,clave,tipousuario,curso)
						SELECT aluctr,md5(ALUPAS),3,1
						FROM %s.dalumn
						WHERE alumai in (%s)
						ON DUPLICATE KEY UPDATE cveusuario=cveusuario,curso=1",$GLOBALS['sie'],$listacorreos);
	$cn = conexionLocal();
	$respuesta = false;
	$resInsert =mysql_query($qrymatchemails);
	$almguardados=mysql_affected_rows();
	if($almguardados>0){
		print $almguardados;
	}
	


}

function obtenerCorreos($csvarray,$cal){
	$relacionCorreos= array();
	$aprobado=$cal;
	for($i=1;$i<count($csvarray);$i++ ){
		$email=$csvarray[$i][5];
		//solo los que tengan 100¿?
		$calificacion=$csvarray[$i][count($csvarray[$i])-2];
		if($calificacion>=$aprobado){
			$relacionCorreos[$i]=array('correo' =>$email ,'calificacion'=>$calificacion );
		}	
	}
	return $relacionCorreos;
	

	//print json_encode($relacionCorreos);
}

$opc= $_POST["opc"];
switch ($opc) {
	case 'cargarcsv':
	cargarcsv();
		# code...
		break;
	
	default:
		# code...
		break;
}

 ?>