<?php 
function conexionBD(){
	/*$cn= mysql_connect("itculiacan.edu.mx","sieapibduser","B5fa4x_7*.*");*/
	$cn = mysql_connect("localhost","root","");
	mysql_select_db("sieapibd");
	return $cn;
}
function conexionLocal(){
	$cn = mysql_connect("localhost","root","");
	mysql_select_db("serviciosocial");
	return $cn;
}
?>