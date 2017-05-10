<?php 
require_once('conexion.php');

	$uploads_dir = 'C:\xampp\htdocs\RESIDENCIAS\ServicioSocial\datos\uploads';
	$archivo=$_FILES["file"]["name"];
	$ruta=$uploads_dir."\\".$archivo;
	//echo $archivo;
    if (is_uploaded_file($_FILES["file"]['tmp_name']))
    {       
        //in case you want to move  the file in uploads directory
         if(move_uploaded_file($_FILES["file"]['tmp_name'], $ruta)){
         	cargarcsv($ruta);
         }

    }


function cargarcsv($ruta){
	# Open the File.
	$mensaje="Falta columna Direccion de correo";
	$colCorreo=$colCalif=false;
	$posCorreo=$posCalif=0;
	//$ruta= $_POST['ruta'];

    if (($handle = fopen($ruta, "r")) !== FALSE) {
        # Set the parent multidimensional array key to 0.
        $nn = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            # Count the total keys in the row.
            $c = count($data);
            # Populate the multidimensional array.
            
            if($nn==0){
	            for ($x=0;$x<$c;$x++)
	            {
	            	//$csvarray[$nn][$x] = $data[$x];
	                if(!$colCorreo && utf8_encode($data[$x])=="Dirección de correo"){
	                	$colCorreo=true;
	                	$csvarray[$nn]["correo"] ="Dirección de correo";
	                	$posCorreo=$x;
	                	//echo "Correo ".$posCorreo;
	                }
	                if(!$colCalif && utf8_encode($data[$x])=="Total del curso (Real)"){
	                	$colCalif=true;
	                	$csvarray[$nn]["calif"] ="Total del curso (Real)";
	                	$posCalif=$x;
	                	//echo "calificacion ".$posCalif;
	                }
	            }
	            $nn=1;
	            continue;
	            //$nn=1;	
            } 
            
            	$csvarray[$nn]["correo"] = $data[$posCorreo];
            	$csvarray[$nn]["calif"] = $data[$posCalif];

            //$csvarray[$nn][$x] = $data[$x];
            $nn++;
        }
        # Close the File.
        fclose($handle);
    }else{
    	$mensaje="No se ha podido cargar el archivo";
    	print json_encode(array('mensaje' =>$mensaje));
		return; 
    }
    # Print the contents of the multidimensional array.
    if($colCorreo && $colCalif){
    	$correosaprobados	=obtenerCorreos($csvarray,100);//solo los que tienen 100
    	$correosTomaroncurso=obtenerCorreos($csvarray,0);//0 para que traiga todos
	}else{
		$mensaje="Verifique que existan las columnas Dirección de correo y Total del curso (Real)";
		//echo $mensaje;
		print json_encode(array('mensaje' =>$mensaje));
		return;  
	}
   
    //print obtenerAlumnos($correosTomaroncurso);
    registrarAlumnos($correosaprobados);
    print obtenerAlumnos($correosaprobados);

}
function obtenerAlumnos($correos){
	$respuesta=false;
	$listacorreos=strtoupper(separacomas($correos));
	//echo $listacorreos;
	$cn=conexionBD();
	mysql_query("set names utf8");
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
    $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
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
	//echo mysql_affected_rows();
	if($almguardados>0){
		print $almguardados;
	}
	


}

function obtenerCorreos($csvarray,$cal){
	$relacionCorreos= array();
	$aprobado=$cal;
	//echo count($csvarray);
	for($i=1;$i<count($csvarray);$i++ ){
		$email=$csvarray[$i]["correo"];
		//solo los que tengan 100¿?
		//$calificacion=$csvarray[$i][count($csvarray[$i])-2];
		$calificacion=$csvarray[$i]["calif"];
		if($calificacion>=$aprobado){
			$relacionCorreos[$i]=array('correo' =>$email ,'calificacion'=>$calificacion );
		}	
	}
	return $relacionCorreos;
	

	//print json_encode($relacionCorreos);
}

//$opc= $_POST["opc"];
/*switch ($opc) {
	case 'cargarcsv':
	cargarcsv();
		# code...
		break;
	
	default:
		# code...
		break;
}*/

 ?>