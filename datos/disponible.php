<?php 
	require_once('conexion.php');

    if(isset($_POST['action']) && $_POST['action'] == 'disponible')
    {
    	$connection=conexionLocal();
        $username   = "'".$_POST["username"]."'";
            $query  = sprintf("select cveusuario from usuarios where cveusuario=%s",$username);
            $res    = mysql_query($query);
            $count  = mysql_num_rows($res);
            echo $count;
    }
 ?>