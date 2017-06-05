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

?>