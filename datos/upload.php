<?php
      

    $uploads_dir = 'C:\xampp\htdocs\RESIDENCIAS\ServicioSocial\datos\uploads';
    $name = $_FILES['fileToUpload']['name'];
    if (is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
    {       
        //in case you want to move  the file in uploads directory
         move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploads_dir."\\".$name);
         //echo 'moved file to destination directory';
         //exit;
    }
         

?>